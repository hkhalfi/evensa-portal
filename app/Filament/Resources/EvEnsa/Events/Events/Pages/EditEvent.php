<?php

namespace App\Filament\Resources\EvEnsa\Events\Events\Pages;

use App\Filament\Resources\EvEnsa\Events\Events\EventResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditEvent extends EditRecord
{
    protected static string $resource = EventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('schedule')
                ->label('Planifier')
                ->icon('heroicon-o-calendar')
                ->color('info')
                ->visible(fn (): bool => in_array($this->record->status, ['draft']))
                ->requiresConfirmation()
                ->action(function (): void {
                    $this->record->update([
                        'status' => 'scheduled',
                    ]);

                    Notification::make()
                        ->title('Événement planifié')
                        ->success()
                        ->send();
                }),

            Action::make('publish')
                ->label('Publier')
                ->icon('heroicon-o-megaphone')
                ->color('success')
                ->visible(fn (): bool => in_array($this->record->status, ['draft', 'scheduled']) && ! $this->record->is_published)
                ->requiresConfirmation()
                ->action(function (): void {
                    $record = $this->record;

                    if (blank($record->title)) {
                        Notification::make()
                            ->title('Publication impossible')
                            ->body('Le titre est requis.')
                            ->danger()
                            ->send();

                        return;
                    }

                    if (blank($record->instance_id) || blank($record->event_type_id) || blank($record->category_id)) {
                        Notification::make()
                            ->title('Publication impossible')
                            ->body('Instance, type et catégorie sont requis.')
                            ->danger()
                            ->send();

                        return;
                    }

                    if (blank($record->start_at) || blank($record->end_at) || $record->start_at >= $record->end_at) {
                        Notification::make()
                            ->title('Publication impossible')
                            ->body('Les dates de début et fin doivent être valides.')
                            ->danger()
                            ->send();

                        return;
                    }

                    if (blank($record->description)) {
                        Notification::make()
                            ->title('Publication impossible')
                            ->body('La description est requise avant publication.')
                            ->danger()
                            ->send();

                        return;
                    }

                    $record->update([
                        'status' => 'published',
                        'is_published' => true,
                        'published_at' => now(),
                    ]);

                    Notification::make()
                        ->title('Événement publié')
                        ->success()
                        ->send();
                }),

            Action::make('unpublish')
                ->label('Dépublier')
                ->icon('heroicon-o-eye-slash')
                ->color('warning')
                ->visible(fn (): bool => $this->record->is_published)
                ->requiresConfirmation()
                ->action(function (): void {
                    $this->record->update([
                        'status' => 'scheduled',
                        'is_published' => false,
                        'published_at' => null,
                    ]);

                    Notification::make()
                        ->title('Événement dépublié')
                        ->success()
                        ->send();
                }),

            Action::make('complete')
                ->label('Marquer comme terminé')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->visible(fn (): bool => in_array($this->record->status, ['scheduled', 'published']))
                ->requiresConfirmation()
                ->action(function (): void {
                    $this->record->update([
                        'status' => 'completed',
                    ]);

                    Notification::make()
                        ->title('Événement marqué comme terminé')
                        ->success()
                        ->send();
                }),

            Action::make('archive')
                ->label('Archiver')
                ->icon('heroicon-o-archive-box')
                ->color('gray')
                ->visible(fn (): bool => in_array($this->record->status, ['completed', 'published', 'scheduled']))
                ->requiresConfirmation()
                ->action(function (): void {
                    $this->record->update([
                        'status' => 'archived',
                        'is_published' => false,
                    ]);

                    Notification::make()
                        ->title('Événement archivé')
                        ->success()
                        ->send();
                }),

            DeleteAction::make(),
        ];
    }
}
