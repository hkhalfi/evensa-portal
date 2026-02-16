<?php

namespace App\Filament\Resources\HR\Projects\Pages;

use App\Enums\ProjectStatus;
use App\Filament\Resources\HR\Projects\ProjectResource;
use App\Models\HR\Project;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Icons\Heroicon;

class EditProject extends EditRecord
{
    protected static string $resource = ProjectResource::class;

    protected function getActions(): array
    {
        return [
            ViewAction::make(),
            Action::make('put_on_hold')
                ->icon(Heroicon::Pause)
                ->color('warning')
                ->visible(fn (Project $record): bool => $record->status === ProjectStatus::Active)
                ->requiresConfirmation()
                ->modalHeading('Put Project On Hold')
                ->modalDescription('This will pause all work on this project.')
                ->modalIcon(Heroicon::ExclamationTriangle)
                ->modalIconColor('warning')
                ->action(function (Project $record): void {
                    $record->update(['status' => ProjectStatus::OnHold]);
                    $this->refreshFormData(['status']);

                    Notification::make()
                        ->title('Project put on hold')
                        ->warning()
                        ->send();
                }),
            Action::make('resume')
                ->icon(Heroicon::Play)
                ->color('success')
                ->visible(fn (Project $record): bool => $record->status === ProjectStatus::OnHold)
                ->action(function (Project $record): void {
                    $record->update(['status' => ProjectStatus::Active]);
                    $this->refreshFormData(['status']);

                    Notification::make()
                        ->title('Project resumed')
                        ->success()
                        ->send();
                }),
            DeleteAction::make(),
            RestoreAction::make(),
            ForceDeleteAction::make(),
        ];
    }
}
