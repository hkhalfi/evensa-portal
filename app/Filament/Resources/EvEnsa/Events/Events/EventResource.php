<?php

namespace App\Filament\Resources\EvEnsa\Events\Events;

use App\Filament\Resources\EvEnsa\Events\Events\Pages\CreateEvent;
use App\Filament\Resources\EvEnsa\Events\Events\Pages\EditEvent;
use App\Filament\Resources\EvEnsa\Events\Events\Pages\ListEvents;
use App\Models\EvEnsa\Events\Event;
use App\Models\EvEnsa\Referentials\Category;
use App\Models\EvEnsa\Referentials\EventType;
use App\Models\EvEnsa\Referentials\Instance;
use App\Models\EvEnsa\Referentials\Venue;
use BackedEnum;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;
use UnitEnum;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $recordTitleAttribute = 'title';

    protected static string | BackedEnum | null $navigationIcon = Heroicon::OutlinedCalendarDays;

    protected static string | UnitEnum | null $navigationGroup = 'Événements';

    protected static ?int $navigationSort = 1;

    protected static ?string $slug = 'evensa/events/events';

    protected static ?string $modelLabel = 'événement';

    protected static ?string $pluralModelLabel = 'événements';

    protected static ?string $navigationLabel = 'Événements';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('title')
                ->label('Intitulé')
                ->required()
                ->maxLength(255),

            Placeholder::make('source_request')
                ->label('Demande source')
                ->content(fn ($record) => $record?->eventRequest?->id ? 'Demande #' . $record->eventRequest->id : 'Aucune demande source')
                ->columnSpanFull(),

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
                ->label('Participants attendus')
                ->numeric()
                ->nullable(),

            FileUpload::make('cover_image')
                ->label('Image de couverture')
                ->directory('events/covers')
                ->disk('public')
                ->image()
                ->downloadable()
                ->openable()
                ->nullable()
                ->columnSpanFull(),

            Textarea::make('description')
                ->label('Description')
                ->rows(6)
                ->nullable()
                ->columnSpanFull(),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->with(['instance', 'eventType', 'category', 'venue', 'eventRequest']))
            ->columns([
                TextColumn::make('title')
                    ->label('Intitulé')
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                TextColumn::make('instance.name')
                    ->label('Instance')
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
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'internal' => 'Interne',
                        'external' => 'Externe',
                        'online' => 'En ligne',
                        'hybrid' => 'Hybride',
                        default => $state,
                    }),

                TextColumn::make('start_at')
                    ->label('Début')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

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
                    })
                    ->sortable(),

                IconColumn::make('is_published')
                    ->label('Publié')
                    ->boolean(),

                TextColumn::make('published_at')
                    ->label('Publié le')
                    ->dateTime('d/m/Y H:i')
                    ->toggleable(),

                TextColumn::make('eventRequest.id')
                    ->label('Demande source')
                    ->formatStateUsing(fn ($state) => filled($state) ? '#' . $state : '—')
                    ->badge()
                    ->color(fn ($state) => filled($state) ? 'info' : 'gray')
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Créé le')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('start_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEvents::route('/'),
            'create' => CreateEvent::route('/create'),
            'edit' => EditEvent::route('/{record}/edit'),
        ];
    }

    public function event(): HasOne
    {
        return $this->hasOne(Event::class);
    }
}
