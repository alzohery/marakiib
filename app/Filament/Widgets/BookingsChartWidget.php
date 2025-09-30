<?php




     namespace App\Filament\Widgets;

     use App\Models\Booking;
     use Filament\Widgets\ChartWidget;
     use Flowframe\Trend\Trend;
     use Flowframe\Trend\TrendValue;

     class BookingsChartWidget extends ChartWidget
     {
         protected static ?string $heading = 'Bookings by Status';
         protected static ?int $sort = 2;
         protected int | string | array $columnSpan = 2;

         protected function getType(): string
         {
             return 'bar';
         }

         protected function getData(): array
         {
             $filters = $this->getFilters();
             $start = isset($filters['start_date']) ? $filters['start_date'] : now()->subMonth();
             $end = isset($filters['end_date']) ? $filters['end_date'] : now();

             $pending = Trend::query(Booking::where('status', 'pending'))
                 ->between(start: $start, end: $end)
                 ->perDay()
                 ->count();

             $completed = Trend::query(Booking::where('status', 'completed'))
                 ->between(start: $start, end: $end)
                 ->perDay()
                 ->count();

             return [
                 'datasets' => [
                     [
                         'label' => __('Pending Bookings'),
                         'data' => $pending->map(fn (TrendValue $value) => $value->aggregate),
                         'backgroundColor' => '#f59e0b',
                     ],
                     [
                         'label' => __('Completed Bookings'),
                         'data' => $completed->map(fn (TrendValue $value) => $value->aggregate),
                         'backgroundColor' => '#22c55e',
                     ],
                 ],
                 'labels' => $pending->map(fn (TrendValue $value) => $value->date),
             ];
         }

         public static function canView(): bool
         {
             return auth()->user()->hasPermissionTo('view-adminpanel', 'web');
         }
     }

     



// namespace App\Filament\Widgets;

// use App\Models\Booking;
// use Filament\Widgets\ChartWidget;
// use Flowframe\Trend\Trend;
// use Flowframe\Trend\TrendValue;

// class BookingsChartWidget extends ChartWidget
// {
//     protected static ?string $heading = 'Bookings by Status';
//     protected static ?int $sort = 2;
//     protected int | string | array $columnSpan = 2;

//     protected function getType(): string
//     {
//         return 'bar';
//     }

//     protected function getData(): array
//     {
//         $filters = $this->getFilters();
//         $start = isset($filters['start_date']) ? $filters['start_date'] : now()->subMonth();
//         $end = isset($filters['end_date']) ? $filters['end_date'] : now();

//         $pending = Trend::model(Booking::class)
//             ->where('status', 'pending')
//             ->between(start: $start, end: $end)
//             ->perDay()
//             ->count();

//         $completed = Trend::model(Booking::class)
//             ->where('status', 'completed')
//             ->between(start: $start, end: $end)
//             ->perDay()
//             ->count();

//         return [
//             'datasets' => [
//                 [
//                     'label' => __('Pending Bookings'),
//                     'data' => $pending->map(fn (TrendValue $value) => $value->aggregate),
//                     'backgroundColor' => '#f59e0b',
//                 ],
//                 [
//                     'label' => __('Completed Bookings'),
//                     'data' => $completed->map(fn (TrendValue $value) => $value->aggregate),
//                     'backgroundColor' => '#d20d2eff',
//                 ],
//             ],
//             'labels' => $pending->map(fn (TrendValue $value) => $value->date),
//         ];
//     }

//     public static function canView(): bool
//     {
//         return auth()->user()->hasPermissionTo('view-adminpanel');
//     }
// }
?>