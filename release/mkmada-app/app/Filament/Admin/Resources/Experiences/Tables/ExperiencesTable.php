<?php

namespace App\Filament\Admin\Resources\Experiences\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ExperiencesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('role')->label('Rôle')->state(fn ($record) => $record->role)->searchable(),
                TextColumn::make('company')->label('Entreprise')->searchable(),
                TextColumn::make('started_on')->date('m/Y')->sortable(),
                TextColumn::make('is_current')->label('Actuelle')->badge(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
