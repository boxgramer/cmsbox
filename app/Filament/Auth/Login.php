<?php

namespace App\Filament\Auth;

use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Auth\Login as AuthLogin;
use Illuminate\Validation\ValidationException;

class Login extends AuthLogin
{

    public function form(Form $form): Form
    {
        return $form->schema([
            $this->getUsernameFormComponent(),
            $this->getPasswordFormComponent(),
            $this->getRememberFormComponent(),
        ])->statePath('data');
    }
    protected function getUsernameFormComponent(): Component
    {
        return TextInput::make('username')
            ->required();
    }
    protected function getCredentialsFromFormData(array $data): array
    {
        return [
            'username' => $data['username'],
            'password' => $data['password'],
        ];
    }
    protected function throwFailureValidationException(): never
    {
        throw ValidationException::withMessages([
            'data.username' => __('filament-panels::pages/auth/login.messages.failed'),
        ]);
    }
}
