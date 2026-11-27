<?php

namespace App\Filament\Admin\Resources;

use App\Enums\Involvement;
use App\Enums\ProjectStatus;
use App\Filament\Admin\Resources\ProjectResource\Pages;
use App\Models\Category;
use App\Models\Project;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'slug';

    protected static ?string $slug = 'projets';

    protected static ?string $navigationLabel = 'Projets';

    protected static ?string $modelLabel = 'projet';

    protected static ?string $pluralModelLabel = 'projets';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Identité du projet')
                ->description('Les champs marqués comme bilingues doivent être renseignés dans les deux langues.')
                ->schema([
                    Grid::make(2)->schema([
                        TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Select::make('category_id')
                            ->label('Catégorie')
                            ->options(function (): array {
                                /** @var Collection<int, Category> $categories */
                                $categories = Category::query()
                                    ->with('translations')
                                    ->orderBy('sort_order')
                                    ->get();
                                $options = [];

                                foreach ($categories as $category) {
                                    $options[$category->getKey()] = $category->name ?? $category->slug;
                                }

                                return $options;
                            })
                            ->searchable()
                            ->preload(),
                    ]),
                    FileUpload::make('cover_image')
                        ->label('Image de couverture')
                        ->image()
                        ->disk('public')
                        ->directory('projects/covers')
                        ->visibility('public')
                        ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                        ->maxSize(10240)
                        ->previewable()
                        ->downloadable()
                        ->openable()
                        ->imageEditor(),
                ]),

            Section::make('Contenu bilingue')
                ->description('Une traduction française et une traduction anglaise sont attendues.')
                ->schema([
                    Repeater::make('translations')
                        ->label('Traductions')
                        ->relationship()
                        ->schema([
                            Select::make('locale')
                                ->label('Langue')
                                ->options([
                                    'fr' => 'Français',
                                    'en' => 'English',
                                ])
                                ->required()
                                ->distinct()
                                ->disableOptionsWhenSelectedInSiblingRepeaterItems(),
                            TextInput::make('title')
                                ->required()
                                ->maxLength(255),
                            Textarea::make('summary')
                                ->required()
                                ->rows(3)
                                ->maxLength(1000),
                            Textarea::make('description')
                                ->rows(6)
                                ->maxLength(10000),
                            Grid::make(2)->schema([
                                Textarea::make('context')->rows(4)->maxLength(5000),
                                Textarea::make('problem')->rows(4)->maxLength(5000),
                                Textarea::make('solution')->rows(4)->maxLength(5000),
                                Textarea::make('contributions')->rows(4)->maxLength(5000),
                                Textarea::make('features')->rows(4)->maxLength(5000),
                                TextInput::make('cover_alt')
                                    ->label('Texte alternatif de la couverture')
                                    ->maxLength(255),
                            ]),
                            Grid::make(2)->schema([
                                TextInput::make('seo_title')->maxLength(255),
                                Textarea::make('seo_description')->rows(3)->maxLength(160),
                            ]),
                        ])
                        ->columns(2)
                        ->minItems(2)
                        ->maxItems(2)
                        ->defaultItems(2)
                        ->reorderable(false)
                        ->addActionLabel('Ajouter une langue'),
                ]),

            Section::make('Publication et classement')
                ->schema([
                    Grid::make(2)->schema([
                        Select::make('status')
                            ->options([
                                ProjectStatus::Draft->value => 'Brouillon',
                                ProjectStatus::Published->value => 'Publié',
                            ])
                            ->default(ProjectStatus::Draft->value)
                            ->required(),
                        Select::make('involvement')
                            ->label('Participation')
                            ->options([
                                Involvement::Personal->value => 'Projet personnel',
                                Involvement::Team->value => 'Équipe',
                                Involvement::Maintenance->value => 'Maintenance',
                            ]),
                        DatePicker::make('started_on')->label('Début'),
                        DatePicker::make('ended_on')->label('Fin'),
                        TextInput::make('project_url')->label('URL du projet')->url()->maxLength(255),
                        TextInput::make('repository_url')->label('URL du dépôt')->url()->maxLength(255),
                        TextInput::make('sort_order')->integer()->default(0)->minValue(0),
                        Toggle::make('is_featured')->label('Projet mis en avant'),
                        Toggle::make('is_ongoing')->label('Projet en cours'),
                    ]),
                    Select::make('technologies')
                        ->relationship('technologies', 'name')
                        ->multiple()
                        ->searchable()
                        ->preload()
                        ->label('Technologies'),
                ]),

            Section::make('Galerie')
                ->description('Chaque image peut recevoir un texte alternatif dans les deux langues.')
                ->schema([
                    Repeater::make('images')
                        ->relationship()
                        ->schema([
                            FileUpload::make('path')
                                ->label('Image')
                                ->image()
                                ->disk('public')
                                ->directory('projects/gallery')
                                ->visibility('public')
                                ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                ->maxSize(10240)
                                ->previewable()
                                ->downloadable()
                                ->openable()
                                ->required(),
                            KeyValue::make('alt')
                                ->label('Textes alternatifs')
                                ->keyLabel('Langue')
                                ->valueLabel('Texte')
                                ->addButtonLabel('Ajouter une langue')
                                ->keyPlaceholder('fr ou en')
                                ->valuePlaceholder('Description de l’image'),
                        ])
                        ->columns(2)
                        ->orderColumn('sort_order')
                        ->reorderable()
                        ->addActionLabel('Ajouter une image'),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->columns([
                TextColumn::make('title')
                    ->label('Titre')
                    ->state(fn (Project $record): ?string => $record->title)
                    ->limit(40),
                TextColumn::make('slug')
                    ->searchable()
                    ->copyable(),
                TextColumn::make('category.name')
                    ->label('Catégorie')
                    ->placeholder('Sans catégorie'),
                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn (ProjectStatus|string|null $state): string => match ($state instanceof ProjectStatus ? $state->value : $state) {
                        ProjectStatus::Published->value => 'Publié',
                        default => 'Brouillon',
                    })
                    ->color(fn (ProjectStatus|string|null $state): string => ($state instanceof ProjectStatus ? $state->value : $state) === ProjectStatus::Published->value ? 'success' : 'gray'),
                IconColumn::make('is_featured')
                    ->label('Mis en avant')
                    ->boolean(),
                TextColumn::make('updated_at')
                    ->label('Modifié')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        ProjectStatus::Draft->value => 'Brouillon',
                        ProjectStatus::Published->value => 'Publié',
                    ]),
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
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
