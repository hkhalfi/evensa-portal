<?php

namespace App\Filament\Resources\HR\Expenses\Pages;

use App\Enums\ExpenseStatus;
use App\Filament\Resources\HR\Expenses\ExpenseResource;
use App\Models\HR\Expense;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;

class ViewExpense extends ViewRecord
{
    protected static string $resource = ExpenseResource::class;

    protected function getActions(): array
    {
        return [
            Action::make('approve')
                ->icon(Heroicon::Check)
                ->color('success')
                ->visible(fn (Expense $record): bool => $record->status === ExpenseStatus::Submitted)
                ->requiresConfirmation()
                ->action(function (Expense $record): void {
                    $record->update([
                        'status' => ExpenseStatus::Approved,
                        'approved_at' => now(),
                    ]);

                    Notification::make()
                        ->title('Expense approved')
                        ->success()
                        ->send();

                    $this->refreshFormData(['status']);
                }),
            Action::make('reject')
                ->icon(Heroicon::XMark)
                ->color('danger')
                ->visible(fn (Expense $record): bool => $record->status === ExpenseStatus::Submitted)
                ->modalWidth(Width::Medium)
                ->modalSubmitActionLabel('Reject')
                ->schema([
                    Textarea::make('rejection_reason')
                        ->required()
                        ->label('Reason for rejection'),
                ])
                ->action(function (Expense $record, array $data): void {
                    $record->update([
                        'status' => ExpenseStatus::Rejected,
                        'notes' => $data['rejection_reason'],
                    ]);

                    Notification::make()
                        ->title('Expense rejected')
                        ->danger()
                        ->send();

                    $this->refreshFormData(['status']);
                }),
            Action::make('reimburse')
                ->icon(Heroicon::Banknotes)
                ->color('primary')
                ->visible(fn (Expense $record): bool => $record->status === ExpenseStatus::Approved)
                ->requiresConfirmation()
                ->action(function (Expense $record): void {
                    $record->update(['status' => ExpenseStatus::Reimbursed]);

                    Notification::make()
                        ->title('Expense reimbursed')
                        ->success()
                        ->send();

                    $this->refreshFormData(['status']);
                }),
            EditAction::make(),
        ];
    }
}
