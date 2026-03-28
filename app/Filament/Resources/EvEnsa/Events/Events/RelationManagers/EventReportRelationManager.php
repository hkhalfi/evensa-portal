<?php

namespace App\Filament\Resources\EvEnsa\Events\Events\RelationManagers;

use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class EventReportRelationManager extends RelationManager
{
    protected static string $relationship = 'report';

    protected static ?string $title = 'Bilan de l’événement';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            FileUpload::make('report_file')
                ->label('Document de bilan')
                ->required()
                ->directory('event-reports')
                ->disk('public')
                ->downloadable()
                ->openable()
                ->columnSpanFull(),

            Textarea::make('global_feedback')
                ->label('Feedback global')
                ->rows(5)
                ->nullable()
                ->columnSpanFull(),
        ])->columns(1);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('report_file')
                    ->label('Bilan')
                    ->formatStateUsing(fn (?string $state): string => filled($state) ? 'Document disponible' : '—')
                    ->badge()
                    ->color(fn (?string $state): string => filled($state) ? 'success' : 'gray'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Ajouté le')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Ajouter le bilan')
                    ->visible(fn () => $this->getOwnerRecord()->report === null),
            ])
            ->actions([
                EditAction::make(),
            ]);
    }
}
