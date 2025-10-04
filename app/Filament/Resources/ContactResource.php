<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactResource\Pages;
use App\Models\Contact;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;
    protected static ?string $navigationIcon = 'heroicon-o-envelope';
    protected static ?string $navigationGroup = 'Static Pages';
    protected static ?string $navigationLabel = 'Contact';
    protected static ?string $modelLabel = 'Contact Page';
    protected static ?string $pluralModelLabel = 'Contact Pages';
    protected static ?int $navigationSort = 2; // بعد About في الـ Sidebar

    // public static function canAccess(): bool
    // {
    //     return auth()->user()->hasPermissionTo('manage-contact', 'web');
    // }

    public static function form(Form $form): Form
    {
        $locales = config('translatable.locales');

        return $form->schema([
            Forms\Components\TextInput::make('slug')
                ->label(__('Slug'))
                ->required()
                ->unique(ignoreRecord: true)
                ->helperText(__('رابط ثابت للصفحة مثل contact')),

            Forms\Components\Toggle::make('is_active')
                ->label(__('Active'))
                ->default(true),

            Forms\Components\TextInput::make('sort_order')
                ->label(__('Sort Order'))
                ->numeric()
                ->default(0),

            Forms\Components\Tabs::make('Translations')
                ->tabs(
                    collect($locales)->map(function ($code) {
                        return Forms\Components\Tabs\Tab::make(strtoupper($code))
                            ->schema([
                                Forms\Components\TextInput::make("{$code}.title")
                                    ->label(__('Title') . " ({$code})")
                                    ->required()
                                    ->afterStateHydrated(function ($component, $state, $record) use ($code) {
                                        if ($record) {
                                            $component->state(
                                                $record->translate($code)?->title
                                            );
                                        }
                                    })
                                    ->dehydrateStateUsing(fn($state) => $state),

                                Forms\Components\RichEditor::make("{$code}.content")
                                    ->label(__('Content') . " ({$code})")
                                    ->required()
                                    ->afterStateHydrated(function ($component, $state, $record) use ($code) {
                                        if ($record) {
                                            $component->state(
                                                $record->translate($code)?->content
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
                                    ->rows(3)
                                    ->afterStateHydrated(function ($component, $state, $record) use ($code) {
                                        if ($record) {
                                            $component->state(
                                                $record->translate($code)?->meta_description
                                            );
                                        }
                                    })
                                    ->dehydrateStateUsing(fn($state) => $state),

                                Forms\Components\TextInput::make("{$code}.meta_keywords")
                                    ->label(__('Meta Keywords') . " ({$code})")
                                    ->helperText(__('افصل الكلمات بفاصلة , '))
                                    ->maxLength(255)
                                    ->afterStateHydrated(function ($component, $state, $record) use ($code) {
                                        if ($record) {
                                            $component->state(
                                                $record->translate($code)?->meta_keywords
                                            );
                                        }
                                    })
                                    ->dehydrateStateUsing(fn($state) => $state),

                                Forms\Components\FileUpload::make("{$code}.image")
                                    ->label(__('Image') . " ({$code})")
                                    ->image()
                                    ->maxFiles(1)
                                    ->directory('contact/images')
                                    ->afterStateHydrated(function ($component, $state, $record) use ($code) {
                                        if ($record) {
                                            $component->state(
                                                $record->translate($code)?->image
                                            );
                                        }
                                    })
                                    ->dehydrateStateUsing(fn ($state) => is_array($state) ? $state[0] ?? null : $state),

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
                    })->toArray()
                )
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('slug')
                ->label(__('Slug'))
                ->searchable(),

            Tables\Columns\TextColumn::make('title')
                ->label(__('Title'))
                ->getStateUsing(fn ($record) => $record->translate(app()->getLocale())?->title ?? '')
                ->searchable(),

            Tables\Columns\ToggleColumn::make('is_active')
                ->label(__('Active')),

            Tables\Columns\TextColumn::make('sort_order')
                ->label(__('Sort Order'))
                ->sortable(),

            Tables\Columns\TextColumn::make('created_at')
                ->label(__('Created At'))
                ->dateTime(),
        ])
        ->filters([
            Tables\Filters\Filter::make('is_active')
                ->label(__('Active'))
                ->toggle(),
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
        ])
        ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContacts::route('/'),
            'create' => Pages\CreateContact::route('/create'),
            'edit' => Pages\EditContact::route('/{record}/edit'),
        ];
    }
}