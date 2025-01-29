<?php

namespace App\Filament\Widgets;

use App\Models\Post;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UsersOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Users', User::count())
                ->description('All registered users')
                ->icon('heroicon-o-user-group')
                ->color('success'),
            Stat::make('Total Posts', Post::count())
                ->description('All published posts')
                ->icon('heroicon-o-document-text')
                ->color('primary'),
            Stat::make('Posts Today', Post::whereDate('created_at', today())->count())
                ->description('Posts created today')
                ->icon('heroicon-o-calendar')
                ->color('warning'),
        ];


    }
}
