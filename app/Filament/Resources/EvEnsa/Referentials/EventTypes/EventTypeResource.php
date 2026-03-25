<?php

namespace App\Filament\Resources\EvEnsa\Referentials\EventTypes;

use App\Filament\Resources\EvEnsa\Referentials\EventTypes\Pages\CreateEventType;
use App\Filament\Resources\EvEnsa\Referentials\EventTypes\Pages\EditEventType;
use App\Filament\Resources\EvEnsa\Referentials\EventTypes\Pages\ListEventTypes;
use App\Models\EvEnsa\Referentials\EventType;
use BackedEnum;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class EventTypeResource extends Resource
{
    protected static ?string $model = EventType::class;

    protected static ?string $recordTitleAttribute = 'name';

    protected static string | BackedEnum | null $navigationIcon = Heroicon::OutlinedTag;

    protected static string | UnitEnum | null $navigationGroup = 'Référentiels';

    protected static ?int $navigationSort = 1;

    protected static ?string $slug = 'evensa/referentials/event-types';

    protected static ?string $modelLabel = 'type d’événement';

    protected static ?string $pluralModelLabel = 'types d’événements';

    protected static ?string $navigationLabel = 'Types d’événements';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')
                ->label('Nom')
                ->required()
                ->maxLength(255),

            TextInput::make('code')
                ->label('Code')
                ->required()
                ->unique(ignoreRecord: true)
                ->maxLength(100)
                ->helperText('Exemple : conference, competition, formation'),

            Textarea::make('description')
                ->label('Description')
                ->rows(4)
                ->columnSpanFull(),

            TextInput::make('minimum_submission_days')
                ->label('Délai minimum de soumission (jours)')
                ->numeric()
                ->required()
                ->default(0),

            Toggle::make('is_active')
                ->label('Actif')
                ->default(true),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nom')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('code')
                    ->label('Code')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('minimum_submission_days')
                    ->label('Délai min. (jours)')
                    ->sortable(),

                IconColumn::make('is_active')
                    ->label('Actif')
                    ->boolean(),

                TextColumn::make('created_at')
                    ->label('Créé le')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('name');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEventTypes::route('/'),
            'create' => CreateEventType::route('/create'),
            'edit' => EditEventType::route('/{record}/edit'),
        ];
    }
}
