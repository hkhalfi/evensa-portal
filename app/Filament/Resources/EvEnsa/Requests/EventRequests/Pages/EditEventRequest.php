<?php

namespace App\Filament\Resources\EvEnsa\Requests\EventRequests\Pages;

use App\Domain\EvEnsa\Actions\CreateEventFromRequestAction;
use App\Domain\EvEnsa\Workflows\EventRequestWorkflow;
use App\Filament\Resources\EvEnsa\Events\Events\EventResource;
use App\Filament\Resources\EvEnsa\Requests\EventRequests\EventRequestResource;
use App\Models\EvEnsa\Requests\EventRequestComment;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Throwable;

class EditEventRequest extends EditRecord
{
    protected static string $resource = EventRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('submit')
                ->label('Soumettre')
                ->icon('heroicon-o-paper-airplane')
                ->color('info')
                ->visible(fn (): bool => auth()->user()->can('submit', $this->record))
                ->requiresConfirmation()
                ->action(function (): void {
                    try {
                        $workflow = app(EventRequestWorkflow::class);

                        $workflow->submit($this->record, auth()->user());

                        Notification::make()
                            ->title('Demande soumise avec succès')
                            ->success()
                            ->send();

                        $this->refreshFormData([
                            'status',
                            'submitted_at',
                        ]);
                    } catch (Throwable $exception) {
                        Notification::make()
                            ->title('Soumission impossible')
                            ->body($exception->getMessage())
                            ->danger()
                            ->send();
                    }
                }),

            Action::make('back_to_draft')
                ->label('Remettre en brouillon')
                ->icon('heroicon-o-pencil-square')
                ->color('gray')
                ->visible(fn (): bool => in_array($this->record->status, ['submitted', 'needs_revision'], true))
                ->requiresConfirmation()
                ->action(function (): void {
                    $this->record->update([
                        'status' => 'draft',
                    ]);

                    EventRequestComment::create([
                        'event_request_id' => $this->record->id,
                        'user_id' => auth()->id(),
                        'comment_type' => 'decision_note',
                        'comment' => 'Demande remise en brouillon.',
                    ]);

                    Notification::make()
                        ->title('La demande a été remise en brouillon')
                        ->success()
                        ->send();

                    $this->refreshFormData([
                        'status',
                    ]);
                }),

            Action::make('mark_under_review')
                ->label('Passer en examen')
                ->icon('heroicon-o-eye')
                ->color('warning')
                ->visible(fn (): bool => auth()->user()->can('review', $this->record))
                ->requiresConfirmation()
                ->action(function (): void {
                    $this->record->update([
                        'status' => 'under_review',
                    ]);

                    EventRequestComment::create([
                        'event_request_id' => $this->record->id,
                        'user_id' => auth()->id(),
                        'comment_type' => 'internal_note',
                        'comment' => 'La demande est passée en cours d’examen.',
                    ]);

                    Notification::make()
                        ->title('La demande est maintenant en cours d’examen')
                        ->success()
                        ->send();

                    $this->refreshFormData([
                        'status',
                    ]);
                }),

            Action::make('request_revision')
                ->label('Demander une révision')
                ->icon('heroicon-o-arrow-path')
                ->color('warning')
                ->visible(fn (): bool => auth()->user()->can('requestRevision', $this->record))
                ->form([
                    Textarea::make('comment')
                        ->label('Motif / commentaire de révision')
                        ->required()
                        ->rows(4),
                ])
                ->action(function (array $data): void {
                    $this->record->update([
                        'status' => 'needs_revision',
                    ]);

                    EventRequestComment::create([
                        'event_request_id' => $this->record->id,
                        'user_id' => auth()->id(),
                        'comment_type' => 'revision_request',
                        'comment' => $data['comment'],
                    ]);

                    Notification::make()
                        ->title('Révision demandée')
                        ->success()
                        ->send();

                    $this->refreshFormData([
                        'status',
                    ]);
                }),

            Action::make('approve')
                ->label('Approuver')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->visible(fn (): bool => auth()->user()->can('approve', $this->record))
                ->requiresConfirmation()
                ->action(function (): void {
                    try {
                        $workflow = app(EventRequestWorkflow::class);

                        $workflow->approve($this->record, auth()->user());

                        Notification::make()
                            ->title('La demande a été approuvée')
                            ->success()
                            ->send();

                        $this->refreshFormData([
                            'status',
                        ]);
                    } catch (Throwable $exception) {
                        Notification::make()
                            ->title('Approbation impossible')
                            ->body($exception->getMessage())
                            ->danger()
                            ->send();
                    }
                }),

            Action::make('reject')
                ->label('Rejeter')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->visible(fn (): bool => auth()->user()->can('reject', $this->record))
                ->form([
                    Textarea::make('comment')
                        ->label('Motif du rejet')
                        ->required()
                        ->rows(4),
                ])
                ->action(function (array $data): void {
                    try {
                        $workflow = app(EventRequestWorkflow::class);

                        $workflow->reject(
                            $this->record,
                            auth()->user(),
                            $data['comment'] ?? '',
                        );

                        Notification::make()
                            ->title('La demande a été rejetée')
                            ->success()
                            ->send();

                        $this->refreshFormData([
                            'status',
                        ]);
                    } catch (Throwable $exception) {
                        Notification::make()
                            ->title('Rejet impossible')
                            ->body($exception->getMessage())
                            ->danger()
                            ->send();
                    }
                }),

            Action::make('create_event')
                ->label('Créer l’événement')
                ->icon('heroicon-o-calendar-days')
                ->color('success')
                ->visible(fn (): bool => auth()->user()->can('createEvent', $this->record))
                ->requiresConfirmation()
                ->action(function (): void {
                    try {
                        $action = app(CreateEventFromRequestAction::class);

                        $event = $action->execute($this->record, auth()->user());

                        Notification::make()
                            ->title('Événement créé avec succès')
                            ->success()
                            ->send();

                        $this->redirect(EventResource::getUrl('edit', ['record' => $event]));
                    } catch (Throwable $exception) {
                        Notification::make()
                            ->title('Création impossible')
                            ->body($exception->getMessage())
                            ->danger()
                            ->send();
                    }
                }),

            Action::make('view_event')
                ->label('Voir l’événement')
                ->icon('heroicon-o-arrow-top-right-on-square')
                ->color('gray')
                ->visible(fn (): bool => $this->record->event !== null)
                ->url(fn (): string => EventResource::getUrl('edit', ['record' => $this->record->event]))
                ->openUrlInNewTab(false),

            DeleteAction::make(),
        ];
    }
}
