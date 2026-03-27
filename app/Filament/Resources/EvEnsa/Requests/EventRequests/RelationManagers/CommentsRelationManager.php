<?php

namespace App\Filament\Resources\EvEnsa\Requests\EventRequests\RelationManagers;

use Filament\Actions\CreateAction;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class CommentsRelationManager extends RelationManager
{
    protected static string $relationship = 'comments';

    protected static ?string $title = 'Commentaires';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Hidden::make('user_id')
                ->default(fn () => auth()->id()),

            Select::make('comment_type')
                ->label('Type de commentaire')
                ->options([
                    'general' => 'Général',
                    'internal_note' => 'Note interne',
                    'revision_request' => 'Demande de révision',
                    'decision_note' => 'Note de décision',
                ])
                ->default('general')
                ->required(),

            Textarea::make('comment')
                ->label('Commentaire')
                ->required()
                ->rows(5)
                ->columnSpanFull(),
        ])->columns(2);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('comment')
            ->columns([
                Tables\Columns\TextColumn::make('comment_type')
                    ->label('Type')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'general' => 'Général',
                        'internal_note' => 'Note interne',
                        'revision_request' => 'Demande de révision',
                        'decision_note' => 'Note de décision',
                        default => $state,
                    }),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Auteur')
                    ->default('Système')
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('comment')
                    ->label('Commentaire')
                    ->limit(80)
                    ->wrap(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Ajouté le')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Ajouter un commentaire'),
            ])
            ->actions([
            ]);
    }
}
