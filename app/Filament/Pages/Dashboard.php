<?php



     namespace App\Filament\Pages;

     use Filament\Pages\Dashboard as BaseDashboard;
     use Filament\Forms;
     use App\Filament\Widgets\StatsOverviewWidget;
     use App\Filament\Widgets\LatestBookingsWidget;
     use App\Filament\Widgets\BookingsChartWidget;
     use App\Filament\Widgets\SiteCommissionStatsWidget;
    //  use App\Filament\Widgets\CommissionStatsWidget;

     class Dashboard extends BaseDashboard
     {
         use BaseDashboard\Concerns\HasFiltersForm;

         protected static ?string $navigationIcon = 'heroicon-o-home';

         public function getColumns(): int | array
         {
             return [
                 'md' => 3,
                 'xl' => 4,
             ];
         }

        //  protected function getHeaderWidgets(): array
        //  {
        //      return [
        //          StatsOverviewWidget::class,
        //          BookingsChartWidget::class,
        //          LatestBookingsWidget::class,
        //      ];
        //  }
        protected function getHeaderWidgets(): array
        {
            return [
                StatsOverviewWidget::class,
                // CommissionStatsWidget::class,
                // WalletStatsWidget::class,
                BookingsChartWidget::class,
                LatestBookingsWidget::class,
                SiteCommissionStatsWidget::class,
            ];
        }

         public function filtersForm(Forms\Form $form): Forms\Form
         {
             return $form
                 ->schema([
                     Forms\Components\Section::make()
                         ->schema([
                             Forms\Components\DatePicker::make('start_date'),
                             Forms\Components\DatePicker::make('end_date'),
                         ])
                         ->columns(2),
                 ]);
         }

         public static function canAccess(): bool
         {
             return auth()->user()->hasPermissionTo('view-adminpanel', 'web');
         }
         

     }
  


// namespace App\Filament\Pages;

// use Filament\Pages\Dashboard as BaseDashboard;
// use Filament\Forms;
// use App\Filament\Widgets\StatsOverviewWidget;
// use App\Filament\Widgets\LatestBookingsWidget;
// use App\Filament\Widgets\BookingsChartWidget;

// class Dashboard extends BaseDashboard
// {
//     use BaseDashboard\Concerns\HasFiltersForm;

//     protected static ?string $navigationIcon = 'heroicon-o-home';

//     public function getColumns(): int | array
//     {
//         return [
//             'md' => 3,
//             'xl' => 4,
//         ];
//     }

//     protected function getHeaderWidgets(): array
//     {
//         return [
//             StatsOverviewWidget::class,
//             BookingsChartWidget::class,
//             LatestBookingsWidget::class,
//         ];
//     }

//     public function filtersForm(Forms\Form $form): Forms\Form
//     {
//         return $form
//             ->schema([
//                 Forms\Components\Section::make()
//                     ->schema([
//                         Forms\Components\DatePicker::make('start_date'),
//                         Forms\Components\DatePicker::make('end_date'),
//                     ])
//                     ->columns(2),
//             ]);
//     }

//     public static function canAccess(): bool
//     {
//         return auth()->user()->hasPermissionTo('view-adminpanel', 'web');
//     }
// }
     


