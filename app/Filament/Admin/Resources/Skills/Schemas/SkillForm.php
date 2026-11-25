<?php

namespace App\Filament\Admin\Resources\Skills\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SkillForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('skill_category_id')->relationship('category', 'slug')->searchable()->preload()->required(),
                TextInput::make('name')->required()->maxLength(255),
                TextInput::make('level')->integer()->minValue(1)->maxValue(5),
                TextInput::make('sort_order')->integer()->default(0)->minValue(0),
            ]);
    }
}
