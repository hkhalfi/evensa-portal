<?php

namespace App\Filament\Widgets;

use App\Models\EvEnsa\Requests\EventRequest;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentEventRequests extends BaseWidget
{
    protected static ?string $heading = 'Demandes récentes';

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                EventRequest::query()
                    ->with(['instance', 'eventType', 'category'])
                    ->latest()
                    ->limit(10)
            )
            ->columns([
                TextColumn::make('title')
                    ->label('Intitulé')
                    ->searchable()
                    ->wrap(),

                TextColumn::make('instance.name')
                    ->label('Instance'),

                TextColumn::make('eventType.name')
                    ->label('Type')
                    ->badge(),

                TextColumn::make('category.name')
                    ->label('Catégorie')
                    ->badge(),

                TextColumn::make('status')
                    ->label('Statut')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'draft' => 'Brouillon',
                        'submitted' => 'Soumise',
                        'under_review' => 'En examen',
                        'needs_revision' => 'Révision',
                        'approved' => 'Approuvée',
                        'rejected' => 'Rejetée',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'draft' => 'gray',
                        'submitted' => 'info',
                        'under_review' => 'warning',
                        'needs_revision' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('created_at')
                    ->label('Créée le')
                    ->dateTime('d/m/Y H:i'),
            ]);
    }
}
