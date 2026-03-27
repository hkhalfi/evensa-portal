<?php

namespace App\Filament\Resources\EvEnsa\Requests\EventRequests\Pages;

use App\Filament\Resources\EvEnsa\Events\Events\EventResource;
use App\Filament\Resources\EvEnsa\Requests\EventRequests\EventRequestResource;
use App\Models\EvEnsa\Events\Event;
use App\Models\EvEnsa\Requests\EventRequestComment;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

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
                ->visible(fn (): bool => $this->record->status === 'draft')
                ->requiresConfirmation()
                ->action(function (): void {
                    $record = $this->record;

                    if (blank($record->organization_request_file)) {
                        Notification::make()
                            ->title('Impossible de soumettre')
                            ->body('Veuillez joindre la demande d’organisation.')
                            ->danger()
                            ->send();

                        return;
                    }

                    if ($record->start_at >= $record->end_at) {
                        Notification::make()
                            ->title('Dates invalides')
                            ->body('La date de fin doit être après la date de début.')
                            ->danger()
                            ->send();

                        return;
                    }

                    if (
                        blank($record->instance_id) ||
                        blank($record->event_type_id) ||
                        blank($record->category_id) ||
                        blank($record->description)
                    ) {
                        Notification::make()
                            ->title('Dossier incomplet')
                            ->body('Veuillez remplir tous les champs obligatoires.')
                            ->danger()
                            ->send();

                        return;
                    }

                    $record->update([
                        'status' => 'submitted',
                        'submitted_at' => now(),
                    ]);

                    EventRequestComment::create([
                        'event_request_id' => $record->id,
                        'user_id' => auth()->id(),
                        'comment_type' => 'decision_note',
                        'comment' => 'Demande soumise.',
                    ]);

                    Notification::make()
                        ->title('Demande soumise avec succès')
                        ->success()
                        ->send();
                }),

            Action::make('back_to_draft')
                ->label('Remettre en brouillon')
                ->icon('heroicon-o-pencil-square')
                ->color('gray')
                ->visible(fn (): bool => in_array($this->record->status, ['submitted', 'needs_revision']))
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
                }),

            Action::make('mark_under_review')
                ->label('Passer en examen')
                ->icon('heroicon-o-eye')
                ->color('warning')
                ->visible(fn (): bool => in_array($this->record->status, ['submitted']))
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
                }),

            Action::make('request_revision')
                ->label('Demander une révision')
                ->icon('heroicon-o-arrow-path')
                ->color('warning')
                ->visible(fn (): bool => in_array($this->record->status, ['submitted', 'under_review']))
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
                }),

            Action::make('approve')
                ->label('Approuver')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->visible(fn (): bool => in_array($this->record->status, ['submitted', 'under_review']))
                ->requiresConfirmation()
                ->action(function (): void {
                    $this->record->update([
                        'status' => 'approved',
                    ]);

                    EventRequestComment::create([
                        'event_request_id' => $this->record->id,
                        'user_id' => auth()->id(),
                        'comment_type' => 'decision_note',
                        'comment' => 'Demande approuvée.',
                    ]);

                    Notification::make()
                        ->title('La demande a été approuvée')
                        ->success()
                        ->send();
                }),

            Action::make('reject')
                ->label('Rejeter')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->visible(fn (): bool => in_array($this->record->status, ['submitted', 'under_review']))
                ->form([
                    Textarea::make('comment')
                        ->label('Motif du rejet')
                        ->required()
                        ->rows(4),
                ])
                ->action(function (array $data): void {
                    $this->record->update([
                        'status' => 'rejected',
                    ]);

                    EventRequestComment::create([
                        'event_request_id' => $this->record->id,
                        'user_id' => auth()->id(),
                        'comment_type' => 'decision_note',
                        'comment' => $data['comment'],
                    ]);

                    Notification::make()
                        ->title('La demande a été rejetée')
                        ->success()
                        ->send();
                }),

            Action::make('create_event')
                ->label('Créer l’événement')
                ->icon('heroicon-o-calendar-days')
                ->color('success')
                ->visible(fn (): bool => $this->record->status === 'approved' && $this->record->event === null)
                ->requiresConfirmation()
                ->action(function (): void {
                    $record = $this->record;

                    $event = Event::create([
                        'event_request_id' => $record->id,
                        'title' => $record->title,
                        'instance_id' => $record->instance_id,
                        'event_type_id' => $record->event_type_id,
                        'category_id' => $record->category_id,
                        'venue_id' => $record->venue_id,
                        'event_mode' => $record->event_mode,
                        'start_at' => $record->start_at,
                        'end_at' => $record->end_at,
                        'expected_attendees' => $record->expected_attendees,
                        'description' => $record->description,
                        'status' => 'draft',
                        'is_published' => false,
                    ]);

                    EventRequestComment::create([
                        'event_request_id' => $record->id,
                        'user_id' => auth()->id(),
                        'comment_type' => 'decision_note',
                        'comment' => 'Événement créé à partir de la demande approuvée.',
                    ]);

                    Notification::make()
                        ->title('Événement créé avec succès')
                        ->success()
                        ->send();

                    $this->redirect(EventResource::getUrl('edit', ['record' => $event]));
                }),

            DeleteAction::make(),
        ];
    }
}
