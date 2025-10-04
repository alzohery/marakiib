<?php


     namespace App\Filament\Widgets;

     use App\Models\Booking;
     use Filament\Tables;
     use Filament\Tables\Table;
     use Filament\Widgets\TableWidget;

     class LatestBookingsWidget extends TableWidget
     {
         protected static ?string $heading = 'Latest Bookings';
         protected static ?int $sort = 3;
         protected int | string | array $columnSpan = 2;

         // دعم الفلاتر من الـ dashboard
         protected function getFilters(): ?array
         {
             return $this->filters ?? [];
         }

         public function table(Table $table): Table
         {
             return $table
                 ->query(
                     Booking::query()
                         ->where('is_active', true)
                         ->when($this->getFilters()['start_date'] ?? null, fn ($q, $date) => $q->where('created_at', '>=', $date))
                         ->when($this->getFilters()['end_date'] ?? null, fn ($q, $date) => $q->where('created_at', '<=', $date))
                 )
                 ->columns([
                     Tables\Columns\TextColumn::make('customer.name')
                         ->label(__('Customer'))
                         ->sortable()
                         ->searchable(),
                     Tables\Columns\TextColumn::make('car.model')
                         ->label(__('Car'))
                         ->sortable()
                         ->searchable(),
                     Tables\Columns\TextColumn::make('status')
                         ->label(__('Status'))
                         ->badge()
                         ->color(fn (string $state): string => match ($state) {
                             'pending' => 'warning',
                             'completed' => 'success',
                             'cancelled' => 'danger',
                             'rejected' => 'danger',
                             default => 'secondary',
                         }),
                     Tables\Columns\TextColumn::make('created_at')
                         ->label(__('Created At'))
                         ->dateTime()
                         ->sortable(),
                 ])
                 ->defaultSort('created_at', 'desc')
                 ->filters([
                     Tables\Filters\SelectFilter::make('status')
                         ->options([
                             'pending' => __('Pending'),
                             'completed' => __('Completed'),
                             'cancelled' => __('Cancelled'),
                             'rejected' => __('Rejected'),
                         ])
                         ->label(__('Status')),
                 ])
                 ->actions([
                     Tables\Actions\Action::make('view')
                         ->label(__('View'))
                        //  ->url(fn (Booking $record): string => route('filament.resources.bookings.view', $record))
                         ->color('primary'),
                 ]);
         }

         public static function canView(): bool
         {
             return auth()->user()->hasPermissionTo('view-adminpanel', 'web');
         }
     }
    


// namespace App\Filament\Widgets;

// use App\Models\Booking;
// use Filament\Tables;
// use Filament\Tables\Table;
// use Filament\Widgets\TableWidget;

// class LatestBookingsWidget extends TableWidget
// {
//     protected static ?string $heading = 'Latest Bookings';
//     protected static ?int $sort = 3;
//     protected int | string | array $columnSpan = 2;

//     public function table(Table $table): Table
//     {
//         return $table
//             ->query(
//                 Booking::query()
//                     ->where('is_active', true)
//                     ->when($this->getFilters()['start_date'] ?? null, fn ($q, $date) => $q->where('created_at', '>=', $date))
//                     ->when($this->getFilters()['end_date'] ?? null, fn ($q, $date) => $q->where('created_at', '<=', $date))
//             )
//             ->columns([
//                 Tables\Columns\TextColumn::make('customer.name')
//                     ->label(__('Customer'))
//                     ->sortable(),
//                 Tables\Columns\TextColumn::make('car.model')
//                     ->label(__('Car'))
//                     ->sortable(),
//                 Tables\Columns\TextColumn::make('status')
//                     ->label(__('Status'))
//                     ->badge()
//                     ->color(fn (string $state): string => match ($state) {
//                         'pending' => 'warning',
//                         'completed' => 'success',
//                         'cancelled' => 'danger',
//                         'rejected' => 'danger',
//                     }),
//                 Tables\Columns\TextColumn::make('created_at')
//                     ->label(__('Created At'))
//                     ->dateTime()
//                     ->sortable(),
//             ])
//             ->defaultSort('created_at', 'desc')
//             ->filters([
//                 Tables\Filters\SelectFilter::make('status')
//                     ->options([
//                         'pending' => __('Pending'),
//                         'completed' => __('Completed'),
//                         'cancelled' => __('Cancelled'),
//                         'rejected' => __('Rejected'),
//                     ])
//                     ->label(__('Status')),
//             ])
//             ->actions([
//                 Tables\Actions\Action::make('view')
//                     ->label(__('View'))
//                     ->url(fn (Booking $record): string => route('filament.resources.bookings.view', $record))
//                     ->color('primary'),
//             ]);
//     }

//     public static function canView(): bool
//     {
//         return auth()->user()->hasPermissionTo('view-adminpanel');
//     }
// }
?>