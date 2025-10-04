<?php

namespace App\Filament\Resources\ConversationResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class MessagesRelationManager extends RelationManager
{
    protected static string $relationship = 'messages'; // العلاقة في Conversation Model

    protected static ?string $recordTitleAttribute = 'message'; // العمود الأساسي اللي يظهر كـ title

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Textarea::make('message')
                ->label('Message')
                ->required()
                ->maxLength(500),

            Forms\Components\Select::make('sender_id')
                ->relationship('sender', 'name')
                ->label('Sender')
                ->required(),

            Forms\Components\Select::make('receiver_id')
                ->relationship('receiver', 'name')
                ->label('Receiver')
                ->required(),

            Forms\Components\Toggle::make('is_active')
                ->label('Active')
                ->default(true),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sender.name')
                    ->label('Sender')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('receiver.name')
                    ->label('Receiver')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('message')
                    ->label('Message')
                    ->limit(50)
                    ->wrap(),

                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active'),

                Tables\Columns\IconColumn::make('read_at')
                    ->boolean()
                    ->label('Read'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Sent At')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
