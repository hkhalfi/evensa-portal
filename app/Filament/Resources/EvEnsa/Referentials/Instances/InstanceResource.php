<?php

namespace App\Filament\Resources\EvEnsa\Referentials\Instances;

use App\Filament\Resources\EvEnsa\Referentials\Instances\Pages\CreateInstance;
use App\Filament\Resources\EvEnsa\Referentials\Instances\Pages\EditInstance;
use App\Filament\Resources\EvEnsa\Referentials\Instances\Pages\ListInstances;
use App\Models\EvEnsa\Referentials\Instance;
use BackedEnum;
use Filament\Forms\Components\Select;
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

class InstanceResource extends Resource
{
    protected static ?string $model = Instance::class;

    protected static ?string $recordTitleAttribute = 'name';

    protected static string | BackedEnum | null $navigationIcon = Heroicon::OutlinedBuildingOffice2;

    protected static string | UnitEnum | null $navigationGroup = 'Référentiels';

    protected static ?int $navigationSort = 4;

    protected static ?string $slug = 'evensa/referentials/instances';

    protected static ?string $modelLabel = 'instance';

    protected static ?string $pluralModelLabel = 'instances';

    protected static ?string $navigationLabel = 'Instances';

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
                ->helperText('Exemple : club-ia, dept-mgsi, bde'),

            Select::make('instance_type')
                ->label('Type d’instance')
                ->options([
                    'club' => 'Club',
                    'departement' => 'Département',
                    'filiere' => 'Filière',
                    'bureau' => 'Bureau',
                    'association' => 'Association',
                    'autre' => 'Autre',
                ])
                ->required()
                ->searchable(),

            TextInput::make('contact_email')
                ->label('Email de contact')
                ->email()
                ->maxLength(255),

            TextInput::make('contact_phone')
                ->label('Téléphone de contact')
                ->tel()
                ->maxLength(50),

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

                TextColumn::make('instance_type')
                    ->label('Type')
                    ->badge()
                    ->sortable(),

                TextColumn::make('contact_email')
                    ->label('Email')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('contact_phone')
                    ->label('Téléphone')
                    ->toggleable(),

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
            'index' => ListInstances::route('/'),
            'create' => CreateInstance::route('/create'),
            'edit' => EditInstance::route('/{record}/edit'),
        ];
    }
}
