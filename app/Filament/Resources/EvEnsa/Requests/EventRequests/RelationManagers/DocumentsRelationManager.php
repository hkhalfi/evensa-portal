<?php

namespace App\Filament\Resources\EvEnsa\Requests\EventRequests\RelationManagers;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class DocumentsRelationManager extends RelationManager
{
    protected static string $relationship = 'documents';

    protected static ?string $title = 'Documents complémentaires';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('document_type')
                ->label('Type de document')
                ->options([
                    'programme_previsionnel' => 'Programme prévisionnel',
                    'affiche' => 'Affiche',
                    'autorisation' => 'Autorisation',
                    'budget_previsionnel' => 'Budget prévisionnel',
                    'autre' => 'Autre',
                ])
                ->required(),

            TextInput::make('title')
                ->label('Titre')
                ->required()
                ->maxLength(255),

            FileUpload::make('file_path')
                ->label('Fichier')
                ->required()
                ->directory('event-request-documents')
                ->disk('public')
                ->downloadable()
                ->openable()
                ->helperText('Joindre la demande officielle d’organisation de l’événement.')
                ->columnSpanFull(),

            Textarea::make('notes')
                ->label('Notes')
                ->rows(4)
                ->nullable()
                ->columnSpanFull(),
        ])->columns(2);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('document_type')
                    ->label('Type')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'programme_previsionnel' => 'Programme prévisionnel',
                        'affiche' => 'Affiche',
                        'autorisation' => 'Autorisation',
                        'budget_previsionnel' => 'Budget prévisionnel',
                        'autre' => 'Autre',
                        default => $state,
                    }),

                Tables\Columns\TextColumn::make('title')
                    ->label('Titre')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Ajouté le')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Ajouter un document'),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
