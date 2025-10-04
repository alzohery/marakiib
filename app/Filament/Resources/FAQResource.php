<?php 
namespace App\Filament\Resources;

use App\Filament\Resources\FAQResource\Pages;
use App\Models\FAQ;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class FAQResource extends Resource
{
    protected static ?string $model = FAQ::class;
    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';
    protected static ?string $navigationGroup = 'Static Pages';
    protected static ?string $navigationLabel = 'FAQ';
    protected static ?string $modelLabel = 'FAQ Page';
    protected static ?string $pluralModelLabel = 'FAQ Pages';
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        $locales = config('translatable.locales', ['en' => 'English', 'ar' => 'Arabic']);

        return $form->schema([
            Forms\Components\TextInput::make('slug')
                ->label(__('Slug'))
                ->required()
                ->unique(ignorable: fn ($record) => $record)
                ->helperText(__('رابط ثابت للصفحة مثل faq')),

            Forms\Components\Toggle::make('is_active')
                ->label(__('Active'))
                ->default(true),

            Forms\Components\TextInput::make('sort_order')
                ->label(__('Sort Order'))
                ->numeric()
                ->default(0),

            Forms\Components\Tabs::make('Translations')
                ->tabs(
                    collect($locales)->map(fn($locale, $key) => 
                        Forms\Components\Tabs\Tab::make(strtoupper(is_string($locale) ? $locale : $key))
                        ->schema(self::makeTranslationFields(is_string($locale) ? $locale : $key)))
                    ->toArray()
                )
                ->columnSpanFull(),
        ]);
    }

    // دالة مساعدة لإنشاء حقول الترجمة لكل لغة
    protected static function makeTranslationFields(string $locale): array
    {
        return [
            Forms\Components\TextInput::make("{$locale}.title")->label(__('Title'))->required(),
            Forms\Components\RichEditor::make("{$locale}.content")->label(__('Content'))->required(),
            Forms\Components\TextInput::make("{$locale}.meta_title")->label(__('Meta Title')),
            Forms\Components\Textarea::make("{$locale}.meta_description")->label(__('Meta Description'))->rows(3),
            Forms\Components\TextInput::make("{$locale}.meta_keywords")->label(__('Meta Keywords'))->helperText(__('افصل الكلمات بفاصلة , ')),
            Forms\Components\FileUpload::make("{$locale}.image")
                ->label(__('Image'))
                ->image()
                ->directory('faq/images')
                ->imagePreviewHeight('100')
                ->enableOpen(),
            Forms\Components\TextInput::make("{$locale}.image_alt")->label(__('Image Alt')),
        ];
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('slug')->label(__('Slug'))->searchable(),
            Tables\Columns\TextColumn::make('title')
            ->label(__('Title'))
            ->formatStateUsing(fn ($state, $record) => $record->title) // <-- هنا ناخد فقط النص
            ->searchable(),

            Tables\Columns\IconColumn::make('is_active')->label(__('Active'))->boolean(),
            Tables\Columns\TextColumn::make('sort_order')->label(__('Sort Order'))->sortable(),
            Tables\Columns\TextColumn::make('created_at')->label(__('Created At'))->dateTime(),
            Tables\Columns\TextColumn::make('updated_at')->label(__('Updated At'))->dateTime(),
        ])
        ->filters([
            Tables\Filters\SelectFilter::make('is_active')
                ->label(__('Status'))
                ->options([
                    1 => __('Active'),
                    0 => __('Inactive'),
                ]),
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(), // حذف عنصر واحد
        ])
        ->bulkActions([
            Tables\Actions\BulkAction::make('delete')
                ->label(__('Delete Selected'))
                ->action(fn ($records) => $records->each->delete())
                ->requiresConfirmation()
                ->color('danger'),

            Tables\Actions\BulkAction::make('activate')
                ->label(__('Activate Selected'))
                ->action(fn ($records) => $records->each->update(['is_active' => true]))
                ->color('success'),

            Tables\Actions\BulkAction::make('deactivate')
                ->label(__('Deactivate Selected'))
                ->action(fn ($records) => $records->each->update(['is_active' => false]))
                ->color('secondary'),
        ]);
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFAQs::route('/'),
            'create' => Pages\CreateFAQ::route('/create'),
            'edit' => Pages\EditFAQ::route('/{record}/edit'),
        ];
    }
}
