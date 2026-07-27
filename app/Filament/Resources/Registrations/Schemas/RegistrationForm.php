<?php

namespace App\Filament\Resources\Registrations\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class RegistrationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('child_name')
                    ->required(),
                TextInput::make('child_age')
                    ->required()
                    ->numeric(),
                TextInput::make('parent_name')
                    ->required(),
                TextInput::make('parent_email')
                    ->email()
                    ->required(),
                TextInput::make('parent_phone')
                    ->tel()
                    ->required(),
                Select::make('programme_id')
                    ->relationship('programme', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                Select::make('payment_status')
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                        'failed' => 'Failed',
                    ])
                    ->required()
                    ->default('pending'),
                TextInput::make('payment_amount')
                    ->required()
                    ->numeric(),
            ]);
    }
}
