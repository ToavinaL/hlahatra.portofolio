<?php

namespace App\Filament\Admin\Resources\Experiences\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ExperienceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('company')->label('Entreprise ou contexte')->maxLength(255),
                DatePicker::make('started_on')->label('Début')->required(),
                DatePicker::make('ended_on')->label('Fin'),
                Toggle::make('is_current')->label('Expérience actuelle'),
                Select::make('technologies')->relationship('technologies', 'name')->multiple()->searchable()->preload(),
                Repeater::make('translations')->relationship()->schema([
                    Select::make('locale')->options(['fr' => 'Français', 'en' => 'English'])->required()->distinct()->disableOptionsWhenSelectedInSiblingRepeaterItems(),
                    TextInput::make('role')->required()->maxLength(255),
                    Textarea::make('missions')->rows(5)->maxLength(5000),
                ])->columns(2)->minItems(1)->maxItems(2),
            ]);
    }
}
