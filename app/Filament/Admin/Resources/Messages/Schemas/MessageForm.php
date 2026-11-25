<?php

namespace App\Filament\Admin\Resources\Messages\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class MessageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->disabled(),
                TextInput::make('email')->email()->disabled(),
                TextInput::make('subject')->disabled(),
                Textarea::make('message')->disabled()->rows(8),
            ]);
    }
}
