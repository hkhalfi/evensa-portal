<?php

namespace App\Filament\Resources\EvEnsa\Events\Events\Pages;

use App\Domain\EvEnsa\Workflows\EventWorkflow;
use App\Filament\Resources\EvEnsa\Events\Events\EventResource;
use App\Filament\Resources\EvEnsa\Requests\EventRequests\EventRequestResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Throwable;

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
                ->visible(fn (): bool => auth()->user()->can('schedule', $this->record))
                ->requiresConfirmation()
                ->action(function (): void {
                    try {
                        $workflow = app(EventWorkflow::class);

                        $workflow->schedule($this->record, auth()->user());

                        Notification::make()
                            ->title('Événement planifié')
                            ->success()
                            ->send();

                        $this->refreshFormData([
                            'status',
                        ]);
                    } catch (Throwable $exception) {
                        Notification::make()
                            ->title('Planification impossible')
                            ->body($exception->getMessage())
                            ->danger()
                            ->send();
                    }
                }),

            Action::make('publish')
                ->label('Publier')
                ->icon('heroicon-o-megaphone')
                ->color('success')
                ->visible(fn (): bool => auth()->user()->can('publish', $this->record))
                ->requiresConfirmation()
                ->action(function (): void {
                    try {
                        $workflow = app(EventWorkflow::class);

                        $workflow->publish($this->record, auth()->user());

                        Notification::make()
                            ->title('Événement publié')
                            ->success()
                            ->send();

                        $this->refreshFormData([
                            'status',
                            'is_published',
                            'published_at',
                        ]);
                    } catch (Throwable $exception) {
                        Notification::make()
                            ->title('Publication impossible')
                            ->body($exception->getMessage())
                            ->danger()
                            ->send();
                    }
                }),

            Action::make('unpublish')
                ->label('Dépublier')
                ->icon('heroicon-o-eye-slash')
                ->color('warning')
                ->visible(fn (): bool => auth()->user()->can('unpublish', $this->record))
                ->requiresConfirmation()
                ->action(function (): void {
                    try {
                        $workflow = app(EventWorkflow::class);

                        $workflow->unpublish($this->record, auth()->user());

                        Notification::make()
                            ->title('Événement dépublié')
                            ->success()
                            ->send();

                        $this->refreshFormData([
                            'status',
                            'is_published',
                            'published_at',
                        ]);
                    } catch (Throwable $exception) {
                        Notification::make()
                            ->title('Dépublication impossible')
                            ->body($exception->getMessage())
                            ->danger()
                            ->send();
                    }
                }),

            Action::make('complete')
                ->label('Marquer comme terminé')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->visible(fn (): bool => auth()->user()->can('complete', $this->record))
                ->requiresConfirmation()
                ->action(function (): void {
                    try {
                        $workflow = app(EventWorkflow::class);

                        $workflow->complete($this->record, auth()->user());

                        Notification::make()
                            ->title('Événement marqué comme terminé')
                            ->success()
                            ->send();

                        $this->refreshFormData([
                            'status',
                            'is_published',
                            'published_at',
                        ]);
                    } catch (Throwable $exception) {
                        Notification::make()
                            ->title('Transition impossible')
                            ->body($exception->getMessage())
                            ->danger()
                            ->send();
                    }
                }),

            Action::make('archive')
                ->label('Archiver')
                ->icon('heroicon-o-archive-box')
                ->color('gray')
                ->visible(fn (): bool => auth()->user()->can('archive', $this->record))
                ->requiresConfirmation()
                ->action(function (): void {
                    try {
                        $workflow = app(EventWorkflow::class);

                        $workflow->archive($this->record, auth()->user());

                        Notification::make()
                            ->title('Événement archivé')
                            ->success()
                            ->send();

                        $this->refreshFormData([
                            'status',
                            'is_published',
                            'published_at',
                        ]);
                    } catch (Throwable $exception) {
                        Notification::make()
                            ->title('Archivage impossible')
                            ->body($exception->getMessage())
                            ->danger()
                            ->send();
                    }
                }),

            Action::make('view_request')
                ->label('Voir la demande')
                ->icon('heroicon-o-arrow-top-right-on-square')
                ->color('gray')
                ->visible(fn (): bool => $this->record->eventRequest !== null)
                ->url(fn (): string => EventRequestResource::getUrl('edit', ['record' => $this->record->eventRequest]))
                ->openUrlInNewTab(false),

            DeleteAction::make(),
        ];
    }
}
