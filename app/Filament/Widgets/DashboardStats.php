<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\Car;
use App\Models\Wallet;
use App\Models\Transaction;

class DashboardStats extends StatsOverviewWidget
{
    // protected static string $heading = 'لوحة التحكم'; // optional

    protected function getCards(): array
    {
        return [
            Card::make('عدد السيارات', fn () => Car::count())
                ->description('إجمالي عدد السيارات المسجلة')
                ->color('primary'),

            Card::make('إجمالي رصيد المحافظ', fn () => Wallet::sum('balance'))
                ->description('إجمالي الأرصدة في جميع المحافظ')
                ->color('success'),

            Card::make('عدد المحافظ النشطة', fn () => Wallet::where('is_active', true)->count())
                ->description('المحافظ النشطة فقط')
                ->color('warning'),

            Card::make('إجمالي المعاملات', fn () => Transaction::count())
                ->description('إجمالي المعاملات المالية')
                ->color('info'),

            Card::make('طلبات السحب المعلقة', fn () => Transaction::where('type', 'withdrawal')->where('status', 'pending')->count())
                ->description('طلبات السحب في انتظار الموافقة')
                ->color('danger'),
        ];
    }
}
