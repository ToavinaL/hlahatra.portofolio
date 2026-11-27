<?php

namespace App\Filament\Admin\Resources\Settings\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Schemas\Schema;

class SettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('key')->required()->unique(ignoreRecord: true),
                FileUpload::make('value')->label('Fichier PDF')->disk('public')->directory('documents/resume')->visibility('public')->acceptedFileTypes(['application/pdf'])->maxSize(10240)->previewable()->downloadable()->openable()->visible(fn (Get $get): bool => $get('key') === 'resume.path'),
                Textarea::make('value')->label('Valeur JSON ou texte')->required()->rows(5)->visible(fn (Get $get): bool => $get('key') !== 'resume.path'),
            ]);
    }
}
