<?php

     namespace App\Filament\Resources;

     use App\Filament\Resources\BookingResource\Pages;
     use App\Models\Booking;
     use Filament\Forms;
     use Filament\Forms\Form;
     use Filament\Resources\Resource;
     use Filament\Tables;
     use Filament\Tables\Table;

     class BookingResource extends Resource
     {
         protected static ?string $model = Booking::class;
         protected static ?string $navigationIcon = 'heroicon-o-document-text';

         public static function canAccess(): bool
         {
             return auth()->user()->hasPermissionTo('view-any-Bookings', 'web');
         }

         public static function canViewAny(): bool
         {
             return auth()->user()->hasPermissionTo('view-any-Bookings', 'web');
         }

         public static function canView($record): bool
         {
             return auth()->user()->hasPermissionTo('view-Bookings', 'web');
         }

         public static function canCreate(): bool
         {
             return auth()->user()->hasPermissionTo('create-Bookings', 'web');
         }

         public static function canEdit($record): bool
         {
             return auth()->user()->hasPermissionTo('update-Bookings', 'web');
         }

         public static function canDelete($record): bool
         {
             return auth()->user()->hasPermissionTo('delete-Bookings', 'web');
         }

         public static function form(Form $form): Form
         {
             return $form
                 ->schema([
                     Forms\Components\Select::make('customer_id')
                         ->relationship('customer', 'name')
                         ->required(),
                     Forms\Components\Select::make('car_id')
                         ->relationship('car', 'model')
                         ->required(),
                     Forms\Components\DateTimePicker::make('start_date')
                         ->required(),
                     Forms\Components\DateTimePicker::make('end_date')
                         ->required(),
                     Forms\Components\TextInput::make('total')
                         ->numeric()
                         ->required(),
                     Forms\Components\Select::make('status')
                         ->options([
                             'pending' => 'Pending',
                             'completed' => 'Completed',
                             'cancelled' => 'Cancelled',
                             'rejected' => 'Rejected',
                         ])
                         ->required(),
                     Forms\Components\TextInput::make('contact_number')
                         ->maxLength(255),
                     Forms\Components\Select::make('gender')
                         ->options([
                             'male' => 'Male',
                             'female' => 'Female',
                         ]),
                     Forms\Components\Toggle::make('is_active')
                         ->default(true),
                 ]);
         }

         public static function table(Table $table): Table
         {
             return $table
                 ->columns([
                     Tables\Columns\TextColumn::make('customer.name')
                         ->searchable(),
                     Tables\Columns\TextColumn::make('car.model')
                         ->searchable(),
                     Tables\Columns\TextColumn::make('start_date')
                         ->dateTime(),
                     Tables\Columns\TextColumn::make('end_date')
                         ->dateTime(),
                     Tables\Columns\TextColumn::make('total')
                         ->numeric(),
                     Tables\Columns\TextColumn::make('status')
                         ->badge()
                         ->color(fn (string $state): string => match ($state) {
                             'pending' => 'warning',
                             'completed' => 'success',
                             'cancelled' => 'danger',
                             'rejected' => 'danger',
                         }),
                     Tables\Columns\ToggleColumn::make('is_active'),
                 ])
                 ->filters([
                     Tables\Filters\SelectFilter::make('status')
                         ->options([
                             'pending' => 'Pending',
                             'completed' => 'Completed',
                             'cancelled' => 'Cancelled',
                             'rejected' => 'Rejected',
                         ]),
                     Tables\Filters\Filter::make('is_active')
                         ->toggle(),
                 ])
                 ->actions([
                     Tables\Actions\EditAction::make(),
                     Tables\Actions\DeleteAction::make(),
                 ])
                 ->bulkActions([
                     Tables\Actions\DeleteBulkAction::make(),
                 ]);
         }

         public static function getPages(): array
         {
             return [
                 'index' => Pages\ListBookings::route('/'),
                 'create' => Pages\CreateBooking::route('/create'),
                 'edit' => Pages\EditBooking::route('/{record}/edit'),
                 
             ];
         }
     }
     ?>