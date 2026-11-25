<?php

namespace App\Filament\Admin\Resources\SkillCategories\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SkillCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('slug')->required()->unique(ignoreRecord: true),
                TextInput::make('sort_order')->integer()->default(0)->minValue(0),
                Repeater::make('translations')->relationship()->schema([
                    Select::make('locale')->options(['fr' => 'Français', 'en' => 'English'])->required()->distinct()->disableOptionsWhenSelectedInSiblingRepeaterItems(),
                    TextInput::make('name')->required()->maxLength(255),
                ])->columns(2)->minItems(1)->maxItems(2),
            ]);
    }
}
