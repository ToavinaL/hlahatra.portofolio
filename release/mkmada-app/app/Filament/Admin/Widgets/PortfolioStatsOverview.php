<?php

namespace App\Filament\Admin\Widgets;

use App\Filament\Admin\Resources\CategoryResource;
use App\Filament\Admin\Resources\ProjectResource;
use App\Filament\Admin\Resources\TechnologyResource;
use App\Models\Category;
use App\Models\Project;
use App\Models\Technology;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PortfolioStatsOverview extends BaseWidget
{
    protected static ?int $sort = -2;

    protected function getStats(): array
    {
        return [
            Stat::make('Projets', Project::count())
                ->description(Project::where('status', 'published')->count().' publiés')
                ->descriptionIcon(Heroicon::OutlinedRectangleStack)
                ->color('primary')
                ->url(ProjectResource::getUrl()),
            Stat::make('Catégories', Category::count())
                ->description('Pour organiser les projets')
                ->descriptionIcon(Heroicon::OutlinedTag)
                ->color('gray')
                ->url(CategoryResource::getUrl()),
            Stat::make('Technologies', Technology::count())
                ->description('Dans la stack technique')
                ->descriptionIcon(Heroicon::OutlinedCodeBracket)
                ->color('gray')
                ->url(TechnologyResource::getUrl()),
        ];
    }
}
