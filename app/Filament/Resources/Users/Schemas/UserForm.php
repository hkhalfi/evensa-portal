<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Models\EvEnsa\Referentials\Instance;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nom')
                    ->required()
                    ->maxLength(255),

                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),

                TextInput::make('password')
                    ->label('Mot de passe')
                    ->password()
                    ->revealable()
                    ->required(fn (string $operation): bool => $operation === 'create')
                    ->rule(Password::defaults())
                    ->dehydrated(fn ($state): bool => filled($state))
                    ->dehydrateStateUsing(fn ($state): string => Hash::make($state)),

                Select::make('role')
                    ->label('Rôle')
                    ->options([
                        'super_admin' => 'Super Admin',
                        'commission_member' => 'Commission Member',
                        'instance_manager' => 'Instance Manager',
                        'viewer' => 'Viewer',
                    ])
                    ->required()
                    ->default('viewer')
                    ->dehydrated(false)
                    ->live()
                    ->afterStateHydrated(function (Select $component, $record): void {
                        if ($record) {
                            $component->state($record->getRoleNames()->first());
                        }
                    }),

                Select::make('instance_id')
                    ->label('Instance')
                    ->options(
                        Instance::query()
                            ->where('is_active', true)
                            ->orderBy('name')
                            ->pluck('name', 'id')
                    )
                    ->searchable()
                    ->preload()
                    ->nullable()
                    ->visible(fn ($get): bool => $get('role') === 'instance_manager')
                    ->required(fn ($get): bool => $get('role') === 'instance_manager')
                    ->helperText('Obligatoire uniquement pour un compte de type instance manager.'),
            ])
            ->columns(2);
    }
}
