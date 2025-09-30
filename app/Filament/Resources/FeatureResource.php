<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FeatureResource\Pages;
use App\Models\Feature;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class FeatureResource extends Resource
{
    protected static ?string $model = Feature::class;
    protected static ?string $navigationIcon = 'heroicon-o-cog';
    protected static ?string $navigationGroup = 'Car Management';
    protected static ?string $navigationLabel = 'Features';
    protected static ?string $modelLabel = 'Feature';
    protected static ?string $pluralModelLabel = 'Features';

    public static function canAccess(): bool
    {
        return auth()->user()->hasPermissionTo('manage-features', 'web');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('slug')
                ->required()
                ->unique(ignoreRecord: true),

            // 🔹 Tabs للغات
            // Forms\Components\Tabs::make('Translations')
            //     ->tabs(
            //         collect(config('translatable.locales'))->map(function ($locale) {
            //             return Forms\Components\Tabs\Tab::make(strtoupper($locale))
            //                 ->schema([
            //                     Forms\Components\TextInput::make("{$locale}.name")
            //                         ->label(__('Name') . " ({$locale})")
            //                         ->default(fn($record) => $record?->translate($locale)?->name)
            //                         ->required(),

            //                     Forms\Components\Textarea::make("{$locale}.description")
            //                         ->label(__('Description') . " ({$locale})")
            //                         ->default(fn($record) => $record?->translate($locale)?->description),
            //                 ]);
            //         })->toArray()
            //     ),

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



            Forms\Components\Select::make('type')
                ->options([
                    'select' => 'Select',
                    'checkbox' => 'Checkbox',
                    'number' => 'Number',
                    'text' => 'Text',
                ])
                ->default('select')
                ->required(),

            Forms\Components\FileUpload::make('image')
                ->image()
                ->directory('features'),

            Forms\Components\Toggle::make('is_required')
                ->default(true),

            Forms\Components\Toggle::make('is_active')
                ->default(true),

            Forms\Components\TextInput::make('sort_order')
                ->numeric()
                ->default(0),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // 🔹 الاسم حسب لغة لوحة التحكم
                Tables\Columns\TextColumn::make('name')
                    ->label(__('Name'))
                    ->getStateUsing(fn ($record) => $record->translate(app()->getLocale())?->name ?? ''),

                Tables\Columns\TextColumn::make('type'),
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\ToggleColumn::make('is_required'),
                Tables\Columns\ToggleColumn::make('is_active'),
                Tables\Columns\TextColumn::make('sort_order')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
            ])
            ->filters([
                Tables\Filters\Filter::make('is_active')->toggle(),
                Tables\Filters\SelectFilter::make('type')->options([
                    'select' => 'Select',
                    'checkbox' => 'Checkbox',
                    'number' => 'Number',
                    'text' => 'Text',
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
            'index' => Pages\ListFeatures::route('/'),
            'create' => Pages\CreateFeature::route('/create'),
            'edit' => Pages\EditFeature::route('/{record}/edit'),
        ];
    }
}
