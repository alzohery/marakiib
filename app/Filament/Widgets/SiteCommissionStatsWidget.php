<?php

namespace App\Filament\Widgets;

use App\Models\SiteCommission;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class SiteCommissionStatsWidget extends BaseWidget
{
    use InteractsWithPageFilters;

    protected static ?int $sort = 5;
    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        $filters = $this->filters;

        // Base query
        $baseQuery = SiteCommission::query();

        if (!empty($filters['start_date']) && !empty($filters['end_date'])) {
            $baseQuery->whereBetween('created_at', [$filters['start_date'], $filters['end_date']]);
        }

        // Clone queries for each type
        $total  = (clone $baseQuery)->sum('amount');
        $buyer  = (clone $baseQuery)->where('applies_to', 'buyer')->sum('amount');
        $seller = (clone $baseQuery)->where('applies_to', 'seller')->sum('amount');
        $both   = (clone $baseQuery)->where('applies_to', 'both')->sum('amount');

        return [
            Stat::make(__('Total Site Commissions'), $this->formatAmount($total))
                ->description(__('Sum of all site commissions'))
                ->color('success'),

            Stat::make(__('Buyer Commissions'), $this->formatAmount($buyer))
                ->description(__('Commissions from buyers'))
                ->color('primary'),

            Stat::make(__('Seller Commissions'), $this->formatAmount($seller))
                ->description(__('Commissions from sellers'))
                ->color('warning'),

            Stat::make(__('Both Commissions'), $this->formatAmount($both))
                ->description(__('Commissions from both'))
                ->color('info'),
        ];
    }

    protected function formatAmount($amount): string
    {
        // تنسيق المبلغ مع الفاصلة وعلامة العملة
        return number_format($amount, 2) . ' ' . config('app.currency', '$');
    }

    public static function canView(): bool
    {
        return auth()->user()->hasPermissionTo('view-adminpanel', 'web');
    }
}
