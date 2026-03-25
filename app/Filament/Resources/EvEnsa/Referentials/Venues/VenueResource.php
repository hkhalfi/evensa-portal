<?php

namespace App\Filament\Resources\EvEnsa\Referentials\Venues;

use App\Filament\Resources\EvEnsa\Referentials\Venues\Pages\CreateVenue;
use App\Filament\Resources\EvEnsa\Referentials\Venues\Pages\EditVenue;
use App\Filament\Resources\EvEnsa\Referentials\Venues\Pages\ListVenues;
use App\Models\EvEnsa\Referentials\Venue;
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

class VenueResource extends Resource
{
    protected static ?string $model = Venue::class;

    protected static ?string $recordTitleAttribute = 'name';

    protected static string | BackedEnum | null $navigationIcon = Heroicon::OutlinedMapPin;

    protected static string | UnitEnum | null $navigationGroup = 'Référentiels';

    protected static ?int $navigationSort = 3;

    protected static ?string $slug = 'evensa/referentials/venues';

    protected static ?string $modelLabel = 'lieu';

    protected static ?string $pluralModelLabel = 'lieux';

    protected static ?string $navigationLabel = 'Lieux';

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
                ->helperText('Exemple : amphi-a, salle-info-2, salle-conference'),

            TextInput::make('location')
                ->label('Emplacement')
                ->maxLength(255)
                ->placeholder('Exemple : Bâtiment A, 1er étage'),

            TextInput::make('capacity')
                ->label('Capacité')
                ->numeric()
                ->nullable(),

            Toggle::make('is_internal')
                ->label('Lieu interne à l’établissement')
                ->default(true),

            Toggle::make('is_active')
                ->label('Actif')
                ->default(true),

            Textarea::make('description')
                ->label('Description')
                ->rows(4)
                ->columnSpanFull(),
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

                TextColumn::make('location')
                    ->label('Emplacement')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('capacity')
                    ->label('Capacité')
                    ->sortable(),

                IconColumn::make('is_internal')
                    ->label('Interne')
                    ->boolean(),

                IconColumn::make('is_active')
                    ->label('Actif')
                    ->boolean(),

                TextColumn::make('created_at')
                    ->label('Créé le')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('name');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListVenues::route('/'),
            'create' => CreateVenue::route('/create'),
            'edit' => EditVenue::route('/{record}/edit'),
        ];
    }
}
