<?php

  namespace App\Filament\Resources;

  use App\Filament\Resources\SiteCommissionResource\Pages;
  use App\Models\SiteCommission;
  use Filament\Forms;
  use Filament\Forms\Form;
  use Filament\Resources\Resource;
  use Filament\Tables;
  use Filament\Tables\Table;

  class SiteCommissionResource extends Resource
  {
      protected static ?string $model = SiteCommission::class;
      protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
      protected static ?string $navigationGroup = 'Financial Management';
      protected static ?string $navigationLabel = 'Site Commissions';
      protected static ?string $modelLabel = 'Site Commission';
      protected static ?string $pluralModelLabel = 'Site Commissions';

      public static function canAccess(): bool
      {
          return auth()->user()->hasPermissionTo('manage-commissions', 'web');
      }

      public static function form(Form $form): Form
      {
          return $form
              ->schema([
                  Forms\Components\Select::make('booking_commission_id')
                    ->label(__('Booking Commission'))
                    ->options(
                        \App\Models\BookingCommission::all()->mapWithKeys(
                            fn ($bc) => [$bc->id => $bc->commission->type . ' - ' . $bc->amount . ' (' . $bc->applies_to . ')']
                        )
                    )
                    ->searchable()
                    ->required(),

                  Forms\Components\TextInput::make('amount')
                      ->label(__('Amount'))
                      ->numeric()
                      ->required()
                      ->minValue(0),
                  Forms\Components\Select::make('applies_to')
                      ->label(__('Applies To'))
                      ->options([
                          'buyer' => 'Buyer',
                          'seller' => 'Seller',
                          'both' => 'Both',
                      ])
                      ->required(),
                  Forms\Components\Textarea::make('description')
                      ->label(__('Description'))
                      ->maxLength(65535),
              ]);
      }

      public static function table(Table $table): Table
      {
          return $table
              ->columns([
                  Tables\Columns\TextColumn::make('bookingCommission.booking.slug')
                      ->label(__('Booking'))
                      ->searchable(),
                  Tables\Columns\TextColumn::make('amount')
                      ->label(__('Amount'))
                      ->numeric()
                      ->sortable(),
                  Tables\Columns\TextColumn::make('applies_to')
                      ->label(__('Applies To')),
                  Tables\Columns\TextColumn::make('description')
                      ->label(__('Description'))
                      ->limit(50),
                  Tables\Columns\TextColumn::make('created_at')
                      ->dateTime(),
              ])
              ->filters([
                  Tables\Filters\SelectFilter::make('applies_to')
                      ->options([
                          'buyer' => 'Buyer',
                          'seller' => 'Seller',
                          'both' => 'Both',
                      ]),
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
              'index' => Pages\ListSiteCommissions::route('/'),
              'create' => Pages\CreateSiteCommission::route('/create'),
              'edit' => Pages\EditSiteCommission::route('/{record}/edit'),
          ];
      }
  }
  ?>