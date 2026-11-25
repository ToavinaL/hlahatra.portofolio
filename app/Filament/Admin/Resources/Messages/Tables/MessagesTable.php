<?php

namespace App\Filament\Admin\Resources\Messages\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MessagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable(),
                TextColumn::make('email')->searchable(),
                TextColumn::make('subject')->limit(40),
                TextColumn::make('read_at')->label('Lu le')->dateTime(),
                TextColumn::make('archived_at')->label('Archivé le')->dateTime(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                Action::make('markAsRead')->label('Marquer lu')->action(fn ($record) => $record->markAsRead())->visible(fn ($record) => ! $record->isRead()),
                Action::make('archive')->label('Archiver')->action(fn ($record) => $record->archive())->visible(fn ($record) => ! $record->isArchived()),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
