<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use App\Models\Favorite;
use App\Models\Review;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;
    protected int|string|array $columnSpan = 'full';

    protected function getStats(): array
    {
        return [
            Stat::make(__('Total Bookings'), Booking::count())
                ->description(__('Total bookings in the system'))
                ->color('primary'),

            Stat::make(__('Favorites'), Favorite::where('is_active', true)->count())
                ->description(__('Cars added to favorites'))
                ->color('success'),

            Stat::make(__('Average Rating'), number_format(
                Review::where('is_active', true)->avg('rating'),
                2
            ))
                ->description(__('Average rating of cars'))
                ->color('warning'),
        ];
    }

    public static function canView(): bool
    {
        return auth()->user()?->hasPermissionTo('view-adminpanel', 'web') ?? false;
    }
}
