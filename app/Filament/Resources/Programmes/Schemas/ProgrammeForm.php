<?php

namespace App\Filament\Resources\Programmes\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ProgrammeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('schedule')
                    ->required(),
                Textarea::make('activities')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('outcomes')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }
}
