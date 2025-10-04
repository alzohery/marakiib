<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ConversationResource\Pages;
use App\Models\Conversation;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;

class ConversationResource extends Resource
{
    protected static ?string $model = Conversation::class;
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    // ✅ يظهر عنوان المحادثة
    protected static ?string $recordTitleAttribute = 'subject';

    // ❌ منع الإنشاء والتعديل من الـ form
    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // ✅ عرض فقط
                \Filament\Tables\Columns\TextColumn::make('sender.name')->label('المرسل'),
                \Filament\Tables\Columns\TextColumn::make('receiver.name')->label('المستقبل'),
                \Filament\Tables\Columns\TextColumn::make('subject')->label('الموضوع'),
                \Filament\Tables\Columns\BooleanColumn::make('is_active')->label('مفعل'),
            ])
            ->filters([])
            ->actions([
                // ❌ حذف زرار التعديل، وخلي بس "عرض المحادثة"
                \Filament\Tables\Actions\Action::make('chat')
                    ->label('عرض المحادثة')
                    ->url(fn ($record) => ConversationResource::getUrl('chat', ['record' => $record])),
            ])
            ->bulkActions([
                // ❌ ممكن كمان توقف الحذف الجماعي لو مش عايزه
                // \Filament\Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    // ❌ منع أي relation يضيف/يعدل رسائل (هنا ممكن نوقف الـ RelationManager لو عايزها read-only)
    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListConversations::route('/'),
            // ❌ شلنا create و edit
            'chat' => Pages\ConversationChat::route('/{record}/chat'),
        ];
    }
}
