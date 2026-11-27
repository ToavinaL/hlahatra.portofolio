<?php

namespace App\Filament\Admin\Resources\Education\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class EducationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('institution')->required()->maxLength(255),
                DatePicker::make('started_on')->label('Début'),
                DatePicker::make('ended_on')->label('Fin'),
                TextInput::make('sort_order')->integer()->default(0)->minValue(0),
                Repeater::make('translations')->relationship()->schema([
                    Select::make('locale')->options(['fr' => 'Français', 'en' => 'English'])->required()->distinct()->disableOptionsWhenSelectedInSiblingRepeaterItems(),
                    TextInput::make('title')->required()->maxLength(255),
                    Textarea::make('description')->rows(4)->maxLength(5000),
                ])->columns(2)->minItems(1)->maxItems(2),
            ]);
    }
}
