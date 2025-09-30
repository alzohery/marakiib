<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FeatureValueResource\Pages;
use App\Models\FeatureValue;
use App\Models\Feature;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class FeatureValueResource extends Resource
{
    protected static ?string $model = FeatureValue::class;
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationGroup = 'Car Management';
    protected static ?string $navigationLabel = 'Feature Values';
    protected static ?string $modelLabel = 'Feature Value';
    protected static ?string $pluralModelLabel = 'Feature Values';

    public static function canAccess(): bool
    {
        return auth()->user()->hasPermissionTo('manage-features', 'web');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            // 🔹 اختيار الـ Feature المرتبط
            Forms\Components\Select::make('feature_id')
                ->label(__('Feature'))
                ->options(
                    Feature::all()->mapWithKeys(
                        fn ($feature) => [
                            $feature->id => $feature->translate(app()->getLocale())?->name ?? '',
                        ]
                    )
                )
                ->searchable()
                ->required(),

            // 🔹 Tabs للغات مع afterStateHydrated
            Forms\Components\Tabs::make('Translations')
                ->tabs(
                    collect(config('translatable.locales'))
                        ->map(function ($locale, $key) {
                            $code = is_array($locale) ? $key : $locale;

                            return Forms\Components\Tabs\Tab::make(strtoupper($code))
                                ->schema([
                                    Forms\Components\TextInput::make("{$code}.value")
                                        ->label(__('Value') . " ({$code})")
                                        ->required()
                                        ->afterStateHydrated(function ($component, $state, $record) use ($code) {
                                            if ($record) {
                                                $component->state(
                                                    $record->translate($code)?->value
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

            Forms\Components\TextInput::make('slug')
                ->required()
                ->unique(ignoreRecord: true),

            Forms\Components\FileUpload::make('image')
                ->image()
                ->directory('feature-values'),

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
                Tables\Columns\TextColumn::make('feature.name')
                    ->label(__('Feature'))
                    ->getStateUsing(fn ($record) => $record->feature?->translate(app()->getLocale())?->name ?? ''),

                Tables\Columns\TextColumn::make('value')
                    ->label(__('Value'))
                    ->getStateUsing(fn ($record) => $record->translate(app()->getLocale())?->value ?? ''),

                Tables\Columns\ImageColumn::make('image'),

                Tables\Columns\ToggleColumn::make('is_active'),

                Tables\Columns\TextColumn::make('sort_order')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
            ])
            ->filters([
                Tables\Filters\Filter::make('is_active')->toggle(),
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
            'index' => Pages\ListFeatureValues::route('/'),
            'create' => Pages\CreateFeatureValue::route('/create'),
            'edit' => Pages\EditFeatureValue::route('/{record}/edit'),
        ];
    }
}
