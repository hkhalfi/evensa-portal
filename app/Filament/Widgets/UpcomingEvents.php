<?php

namespace App\Filament\Widgets;

use App\Models\EvEnsa\Events\Event;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class UpcomingEvents extends BaseWidget
{
    protected static ?string $heading = 'Prochains événements';

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Event::query()
                    ->with(['instance', 'eventType', 'category', 'venue'])
                    ->where('start_at', '>=', now())
                    ->orderBy('start_at')
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

                TextColumn::make('start_at')
                    ->label('Début')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                TextColumn::make('venue.name')
                    ->label('Lieu')
                    ->default('—'),

                TextColumn::make('status')
                    ->label('Statut')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'draft' => 'Brouillon',
                        'scheduled' => 'Planifié',
                        'published' => 'Publié',
                        'completed' => 'Terminé',
                        'archived' => 'Archivé',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'draft' => 'gray',
                        'scheduled' => 'info',
                        'published' => 'success',
                        'completed' => 'warning',
                        'archived' => 'gray',
                        default => 'gray',
                    }),

                TextColumn::make('is_published')
                    ->label('Public')
                    ->badge()
                    ->formatStateUsing(fn (bool $state): string => $state ? 'Oui' : 'Non')
                    ->color(fn (bool $state): string => $state ? 'success' : 'gray'),
            ]);
    }
}
