<?php

namespace App\Filament\Resources\EvEnsa\Requests\EventRequests;

use App\Filament\Resources\EvEnsa\Requests\EventRequests\Pages\CreateEventRequest;
use App\Filament\Resources\EvEnsa\Requests\EventRequests\Pages\EditEventRequest;
use App\Filament\Resources\EvEnsa\Requests\EventRequests\Pages\ListEventRequests;
use App\Models\EvEnsa\Referentials\Category;
use App\Models\EvEnsa\Referentials\EventType;
use App\Models\EvEnsa\Referentials\Instance;
use App\Models\EvEnsa\Referentials\Venue;
use App\Models\EvEnsa\Requests\EventRequest;
use BackedEnum;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class EventRequestResource extends Resource
{
    protected static ?string $model = EventRequest::class;

    protected static ?string $recordTitleAttribute = 'title';

    protected static string | BackedEnum | null $navigationIcon = Heroicon::OutlinedCalendarDays;

    protected static string | UnitEnum | null $navigationGroup = 'Demandes';

    protected static ?int $navigationSort = 1;

    protected static ?string $slug = 'evensa/requests/event-requests';

    protected static ?string $modelLabel = 'demande d’événement';

    protected static ?string $pluralModelLabel = 'demandes d’événements';

    protected static ?string $navigationLabel = 'Demandes d’événements';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('title')
                ->label('Intitulé de l’événement')
                ->required()
                ->maxLength(255),

            Select::make('instance_id')
                ->label('Instance organisatrice')
                ->options(
                    Instance::query()->where('is_active', true)->orderBy('name')->pluck('name', 'id')
                )
                ->searchable()
                ->required(),

            Select::make('event_type_id')
                ->label('Type d’événement')
                ->options(
                    EventType::query()->where('is_active', true)->orderBy('name')->pluck('name', 'id')
                )
                ->searchable()
                ->required(),

            Select::make('category_id')
                ->label('Catégorie')
                ->options(
                    Category::query()->where('is_active', true)->orderBy('name')->pluck('name', 'id')
                )
                ->searchable()
                ->required(),

            Select::make('venue_id')
                ->label('Lieu')
                ->options(
                    Venue::query()->where('is_active', true)->orderBy('name')->pluck('name', 'id')
                )
                ->searchable()
                ->nullable(),

            Select::make('event_mode')
                ->label('Mode')
                ->options([
                    'internal' => 'Interne',
                    'external' => 'Externe',
                    'online' => 'En ligne',
                    'hybrid' => 'Hybride',
                ])
                ->default('internal')
                ->required(),

            DateTimePicker::make('start_at')
                ->label('Début')
                ->seconds(false)
                ->required(),

            DateTimePicker::make('end_at')
                ->label('Fin')
                ->seconds(false)
                ->required()
                ->after('start_at'),

            TextInput::make('expected_attendees')
                ->label('Nombre prévisionnel de participants')
                ->numeric()
                ->nullable(),

            TextColumn::make('status')
                ->label('Statut')
                ->badge()
                ->formatStateUsing(fn (string $state): string => match ($state) {
                    'draft' => 'Brouillon',
                    'submitted' => 'Soumise',
                    'under_review' => 'En cours d’examen',
                    'needs_revision' => 'Révision demandée',
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
                })
                ->sortable(),

            Textarea::make('description')
                ->label('Description')
                ->rows(6)
                ->required()
                ->columnSpanFull(),

            Textarea::make('review_notes')
                ->label('Notes de revue')
                ->rows(4)
                ->nullable()
                ->columnSpanFull(),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->with(['instance', 'eventType', 'category', 'venue']))
            ->columns([
                TextColumn::make('title')
                    ->label('Intitulé')
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                TextColumn::make('instance.name')
                    ->label('Instance')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('eventType.name')
                    ->label('Type')
                    ->badge()
                    ->sortable(),

                TextColumn::make('category.name')
                    ->label('Catégorie')
                    ->badge()
                    ->sortable(),

                TextColumn::make('event_mode')
                    ->label('Mode')
                    ->badge(),

                TextColumn::make('start_at')
                    ->label('Début')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                TextColumn::make('end_at')
                    ->label('Fin')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('status')
                    ->label('Statut')
                    ->badge()
                    ->sortable(),

                TextColumn::make('venue.name')
                    ->label('Lieu')
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Créée le')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEventRequests::route('/'),
            'create' => CreateEventRequest::route('/create'),
            'edit' => EditEventRequest::route('/{record}/edit'),
        ];
    }
}
