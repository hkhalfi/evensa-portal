<?php

namespace App\Filament\Portal\Pages;

use BackedEnum;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;

class MyInstance extends Page implements HasForms
{
    use InteractsWithForms;

    protected string $view = 'filament.portal.pages.my-instance';

    protected static ?string $navigationLabel = 'Profil';

    protected static ?string $title = 'Profil de l’instance';

    protected static BackedEnum | string | null $navigationIcon = Heroicon::OutlinedBuildingOffice;

    public ?array $data = [];

    public function mount(): void
    {
        $instance = Auth::user()->instance;

        abort_if(! $instance, 403);

        $this->form->fill([
            'name' => $instance->name,
            'type' => $instance->type,
            'description' => $instance->description,
            'email' => $instance->email,
            'phone' => $instance->phone,
            'website' => $instance->website,
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informations générales')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nom de l’instance')
                            ->required(),

                        TextInput::make('type')
                            ->label('Type'),

                        Textarea::make('description')
                            ->label('Description')
                            ->rows(4)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Contact')
                    ->schema([
                        TextInput::make('email')->email(),
                        TextInput::make('phone'),
                        TextInput::make('website')->url(),
                    ])
                    ->columns(2),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $instance = Auth::user()->instance;

        abort_if(! $instance, 403);

        $instance->update($this->form->getState());

        Notification::make()
            ->title('Profil mis à jour avec succès')
            ->success()
            ->send();
    }
}
