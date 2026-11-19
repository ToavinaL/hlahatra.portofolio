<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\TechnologyResource\Pages;
use App\Models\Technology;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TechnologyResource extends Resource
{
    protected static ?string $model = Technology::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedCodeBracket;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $slug = 'technologies';

    protected static ?string $navigationLabel = 'Technologies';

    protected static ?string $modelLabel = 'technologie';

    protected static ?string $pluralModelLabel = 'technologies';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Technologie')
                ->schema([
                    Grid::make(2)->schema([
                        TextInput::make('name')
                            ->label('Nom')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        TextInput::make('icon')
                            ->label('Icône')
                            ->placeholder('Ex. laravel')
                            ->maxLength(255),
                        TextInput::make('sort_order')
                            ->label('Ordre')
                            ->numeric()
                            ->default(0)
                            ->minValue(0),
                    ]),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->columns([
                TextColumn::make('name')
                    ->label('Nom')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('slug')
                    ->searchable()
                    ->copyable(),
                TextColumn::make('icon')
                    ->label('Icône')
                    ->placeholder('—'),
                TextColumn::make('sort_order')
                    ->label('Ordre')
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->label('Modifiée')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTechnologies::route('/'),
            'create' => Pages\CreateTechnology::route('/create'),
            'edit' => Pages\EditTechnology::route('/{record}/edit'),
        ];
    }
}
