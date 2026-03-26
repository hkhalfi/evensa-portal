<?php

namespace App\Filament\Resources\EvEnsa\Requests\EventRequests\Pages;

use App\Filament\Resources\EvEnsa\Requests\EventRequests\EventRequestResource;
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
                    $this->record->update([
                        'status' => 'submitted',
                        'submitted_at' => now(),
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
                    Textarea::make('review_notes')
                        ->label('Motif / commentaire de révision')
                        ->required()
                        ->rows(4),
                ])
                ->action(function (array $data): void {
                    $this->record->update([
                        'status' => 'needs_revision',
                        'review_notes' => $data['review_notes'],
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
                    Textarea::make('review_notes')
                        ->label('Motif du rejet')
                        ->required()
                        ->rows(4),
                ])
                ->action(function (array $data): void {
                    $this->record->update([
                        'status' => 'rejected',
                        'review_notes' => $data['review_notes'],
                    ]);

                    Notification::make()
                        ->title('La demande a été rejetée')
                        ->success()
                        ->send();
                }),

            DeleteAction::make(),
        ];
    }
}
