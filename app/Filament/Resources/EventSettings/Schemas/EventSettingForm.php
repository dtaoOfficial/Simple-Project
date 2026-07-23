<?php

namespace App\Filament\Resources\EventSettings\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class EventSettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                DatePicker::make('start_date')
                    ->required(),
                DatePicker::make('end_date')
                    ->required(),
                TextInput::make('timings')
                    ->required(),
                TextInput::make('fee')
                    ->required()
                    ->numeric(),
                TextInput::make('phone')
                    ->tel()
                    ->required(),
                TextInput::make('min_age')
                    ->required()
                    ->numeric(),
                TextInput::make('max_age')
                    ->required()
                    ->numeric(),
            ]);
    }
}
