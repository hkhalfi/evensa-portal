<?php

namespace App\Filament\Resources\Announcements\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class AnnouncementForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Titre')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),

                TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->unique(ignoreRecord: true),

                Textarea::make('excerpt')
                    ->label('Résumé')
                    ->rows(3)
                    ->nullable()
                    ->columnSpanFull(),

                Textarea::make('content')
                    ->label('Contenu')
                    ->rows(10)
                    ->nullable()
                    ->columnSpanFull(),

                Select::make('type')
                    ->label('Type')
                    ->options([
                        'information' => 'Information',
                        'submission' => 'Soumission',
                        'decision' => 'Décision',
                        'notice' => 'Avis',
                    ])
                    ->default('information')
                    ->required(),

                Select::make('status')
                    ->label('Statut')
                    ->options([
                        'draft' => 'Brouillon',
                        'published' => 'Publié',
                        'archived' => 'Archivé',
                    ])
                    ->default('draft')
                    ->required(),
                Toggle::make('is_published')
                    ->required(),
                DateTimePicker::make('published_at'),
                TextInput::make('user_id')
                    ->numeric(),
            ]);
    }
}
