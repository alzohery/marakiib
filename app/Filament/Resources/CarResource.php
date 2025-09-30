<?php

  namespace App\Filament\Resources;

  use App\Filament\Resources\CarResource\Pages;
  use App\Models\Car;
  use App\Models\FeatureValue;
  use Filament\Forms;
  use Filament\Forms\Form;
  use Filament\Resources\Resource;
  use Filament\Tables;
  use Filament\Tables\Table;

  class CarResource extends Resource
  {
      protected static ?string $model = Car::class;
      protected static ?string $navigationIcon = 'heroicon-o-truck';
      protected static ?string $navigationGroup = 'Car Management';
      protected static ?string $navigationLabel = 'Cars';
      protected static ?string $modelLabel = 'Car';
      protected static ?string $pluralModelLabel = 'Cars';

      public static function canAccess(): bool
      {
          return auth()->user()->hasPermissionTo('manage-cars', 'web');
      }

      public static function form(Form $form): Form
      {
          return $form
              ->schema([
                  Forms\Components\Select::make('user_id')
                      ->label(__('User'))
                      ->relationship('user', 'name')
                      ->searchable()
                      ->required(),
                  Forms\Components\FileUpload::make('main_image')
                      ->image()
                      ->directory('cars')
                      ->required(),
                  Forms\Components\FileUpload::make('extra_images')
                      ->multiple()
                      ->image()
                      ->directory('cars/extra'),
                  Forms\Components\TextInput::make('slug')
                      ->required()
                      ->unique(ignoreRecord: true),
                  Forms\Components\Select::make('plate_type')
                      ->options([
                          'white' => 'White',
                          'green' => 'Green',
                      ])
                      ->required(),
                  Forms\Components\TextInput::make('rental_price')
                      ->numeric()
                      ->required(),
                  Forms\Components\DateTimePicker::make('availability_start')
                      ->required(),
                  Forms\Components\DateTimePicker::make('availability_end')
                      ->required(),
                  Forms\Components\TextInput::make('latitude')
                      ->numeric()
                      ->nullable(),
                  Forms\Components\TextInput::make('longitude')
                      ->numeric()
                      ->nullable(),
                  Forms\Components\Toggle::make('long_term_guarantee')
                      ->default(false),
                  Forms\Components\Toggle::make('pickup_delivery')
                      ->default(false),
                  Forms\Components\Toggle::make('is_active')
                      ->default(true),
                  Forms\Components\TextInput::make('sort_order')
                      ->numeric()
                      ->default(0),
                //   Forms\Components\Select::make('feature_values')
                //       ->multiple()
                //       ->label(__('Feature Values'))
                //       ->relationship('featureValues', fn ($query) => $query->get()->mapWithKeys(
                //           fn ($value) => [$value->id => $value->translate(app()->getLocale())?->value ?? '']
                //       ))
                //       ->preload(),
                Forms\Components\Select::make('feature_values')
                ->multiple()
                ->label(__('Feature Values'))
                ->relationship(
                    'featureValues',
                    'id',
                    modifyQueryUsing: fn ($query) => $query->withTranslation(app()->getLocale())
                )
                ->getOptionLabelFromRecordUsing(
                    fn ($record) => $record->translate(app()->getLocale())?->value ?? '—'
                )
                ->preload(),

                  Forms\Components\Tabs::make('Translations')
                      ->tabs(
                          collect(config('translatable.locales'))
                              ->map(function ($locale, $key) {
                                  $code = is_array($locale) ? $key : $locale;

                                  return Forms\Components\Tabs\Tab::make(strtoupper($code))
                                      ->schema([
                                          Forms\Components\TextInput::make("{$code}.name")
                                              ->label(__('Name') . " ({$code})")
                                              ->required()
                                              ->afterStateHydrated(function ($component, $state, $record) use ($code) {
                                                  if ($record) {
                                                      $component->state(
                                                          $record->translate($code)?->name
                                                      );
                                                  }
                                              })
                                              ->dehydrateStateUsing(fn($state) => $state),
                                          Forms\Components\TextInput::make("{$code}.insurance_type")
                                              ->label(__('Insurance Type') . " ({$code})")
                                              ->required()
                                              ->afterStateHydrated(function ($component, $state, $record) use ($code) {
                                                  if ($record) {
                                                      $component->state(
                                                          $record->translate($code)?->insurance_type
                                                      );
                                                  }
                                              })
                                              ->dehydrateStateUsing(fn($state) => $state),
                                          Forms\Components\TextInput::make("{$code}.usage_nature")
                                              ->label(__('Usage Nature') . " ({$code})")
                                              ->required()
                                              ->afterStateHydrated(function ($component, $state, $record) use ($code) {
                                                  if ($record) {
                                                      $component->state(
                                                          $record->translate($code)?->usage_nature
                                                      );
                                                  }
                                              })
                                              ->dehydrateStateUsing(fn($state) => $state),
                                          Forms\Components\Textarea::make("{$code}.description")
                                              ->label(__('Description') . " ({$code})")
                                              ->required()
                                              ->afterStateHydrated(function ($component, $state, $record) use ($code) {
                                                  if ($record) {
                                                      $component->state(
                                                          $record->translate($code)?->description
                                                      );
                                                  }
                                              })
                                              ->dehydrateStateUsing(fn($state) => $state),
                                          Forms\Components\TextInput::make("{$code}.meta_title")
                                              ->label(__('Meta Title') . " ({$code})")
                                              ->afterStateHydrated(function ($component, $state, $record) use ($code) {
                                                  if ($record) {
                                                      $component->state(
                                                          $record->translate($code)?->meta_title
                                                      );
                                                  }
                                              })
                                              ->dehydrateStateUsing(fn($state) => $state),
                                          Forms\Components\Textarea::make("{$code}.meta_description")
                                              ->label(__('Meta Description') . " ({$code})")
                                              ->afterStateHydrated(function ($component, $state, $record) use ($code) {
                                                  if ($record) {
                                                      $component->state(
                                                          $record->translate($code)?->meta_description
                                                      );
                                                  }
                                              })
                                              ->dehydrateStateUsing(fn($state) => $state),
                                          Forms\Components\TextInput::make("{$code}.image_alt")
                                              ->label(__('Image Alt') . " ({$code})")
                                              ->afterStateHydrated(function ($component, $state, $record) use ($code) {
                                                  if ($record) {
                                                      $component->state(
                                                          $record->translate($code)?->image_alt
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
                  Tables\Columns\TextColumn::make('name')
                      ->label(__('Name'))
                      ->getStateUsing(fn ($record) => $record->translate(app()->getLocale())?->name ?? '')
                      ->searchable(),
                  Tables\Columns\TextColumn::make('user.name')
                      ->label(__('User'))
                      ->searchable(),
                  Tables\Columns\ImageColumn::make('main_image'),
                  Tables\Columns\TextColumn::make('rental_price')
                      ->numeric()
                      ->sortable(),
                  Tables\Columns\TextColumn::make('plate_type'),
                  Tables\Columns\ToggleColumn::make('is_active'),
                  Tables\Columns\TextColumn::make('sort_order')
                      ->sortable(),
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
              'index' => Pages\ListCars::route('/'),
              'create' => Pages\CreateCar::route('/create'),
              'edit' => Pages\EditCar::route('/{record}/edit'),
          ];
      }
  }
  ?>