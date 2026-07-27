<?php

namespace App\Filament\Resources\Registrations\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class RegistrationInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('child_name'),
                TextEntry::make('child_age')
                    ->numeric(),
                TextEntry::make('parent_name'),
                TextEntry::make('parent_email'),
                TextEntry::make('parent_phone'),
                TextEntry::make('programme_id')
                    ->numeric(),
                TextEntry::make('payment_status'),
                TextEntry::make('payment_amount')
                    ->numeric(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
