<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Validation\Rules\Password;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getActions(): array
    {
        return [
            Actions\Action::make('chang_password')
                ->form([
                    TextInput::make('password')->password()
                        ->required()
                        ->rule(Password::default()),
                    TextInput::make('password_confirmation')->password()
                        ->same('password')
                        ->rule(Password::default()),
                ])
            ->action(function (array $data) {
                $this->record->update([
                    'password' => bcrypt($data['password']),
                ]);
                $this->notify('success', 'Senha alterada com sucesso!');
            }),
            Actions\DeleteAction::make(),
        ];
    }
}
