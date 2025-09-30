<?php

  namespace App\Filament\Resources;

  use App\Filament\Resources\CommissionResource\Pages;
  use App\Models\Commission;
  use Filament\Forms;
  use Filament\Forms\Form;
  use Filament\Resources\Resource;
  use Filament\Tables;
  use Filament\Tables\Table;

  class CommissionResource extends Resource
  {
      protected static ?string $model = Commission::class;
      protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
      protected static ?string $navigationGroup = 'Financial Management';
      protected static ?string $navigationLabel = 'Commissions';
      protected static ?string $modelLabel = 'Commission';
      protected static ?string $pluralModelLabel = 'Commissions';

      public static function canAccess(): bool
      {
          return auth()->user()->hasPermissionTo('manage-commissions', 'web');
      }

      public static function form(Form $form): Form
      {
          return $form
              ->schema([
                  Forms\Components\Select::make('plate_type')
                      ->label(__('Plate Type'))
                      ->options([
                          'white' => 'White',
                          'green' => 'Green',
                      ])
                      ->required(),
                  Forms\Components\Select::make('type')
                      ->label(__('Type'))
                      ->options([
                          'fixed' => 'Fixed',
                          'percentage' => 'Percentage',
                      ])
                      ->required(),
                  Forms\Components\TextInput::make('value')
                      ->label(__('Value'))
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
                      ->default('both')
                      ->required(),
                  Forms\Components\Toggle::make('is_active')
                      ->default(true),
                  Forms\Components\Tabs::make('Translations')
                      ->tabs(
                          collect(config('translatable.locales'))
                              ->map(function ($locale, $key) {
                                  $code = is_array($locale) ? $key : $locale;

                                  return Forms\Components\Tabs\Tab::make(strtoupper($code))
                                      ->schema([
                                          Forms\Components\Textarea::make("{$code}.description")
                                              ->label(__('Description') . " ({$code})")
                                              ->afterStateHydrated(function ($component, $state, $record) use ($code) {
                                                  if ($record) {
                                                      $component->state(
                                                          $record->translate($code)?->description
                                                      );
                                                  }
                                              })
                                              ->dehydrateStateUsing(fn($state) => $state),
                                      ]);
                              })
                              ->values()
                              ->toArray()
                      ),
              ]);
      }

      public static function table(Table $table): Table
      {
          return $table
              ->columns([
                  Tables\Columns\TextColumn::make('plate_type')
                      ->label(__('Plate Type')),
                  Tables\Columns\TextColumn::make('type')
                      ->label(__('Type')),
                  Tables\Columns\TextColumn::make('value')
                      ->label(__('Value'))
                      ->formatStateUsing(fn ($state, $record) => $record->type === 'percentage' ? $state . '%' : $state),
                  Tables\Columns\TextColumn::make('applies_to')
                      ->label(__('Applies To')),
                  Tables\Columns\ToggleColumn::make('is_active')
                      ->label(__('Active')),
                  Tables\Columns\TextColumn::make('created_at')
                      ->dateTime(),
              ])
              ->filters([
                  Tables\Filters\Filter::make('is_active')
                      ->toggle(),
                  Tables\Filters\SelectFilter::make('plate_type')
                      ->options([
                          'white' => 'White',
                          'green' => 'Green',
                      ]),
                  Tables\Filters\SelectFilter::make('type')
                      ->options([
                          'fixed' => 'Fixed',
                          'percentage' => 'Percentage',
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
              'index' => Pages\ListCommissions::route('/'),
              'create' => Pages\CreateCommission::route('/create'),
              'edit' => Pages\EditCommission::route('/{record}/edit'),
          ];
      }
  }
  ?>