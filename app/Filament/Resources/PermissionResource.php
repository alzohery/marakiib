<?php

     namespace App\Filament\Resources;

     use App\Filament\Resources\PermissionResource\Pages;
     use Spatie\Permission\Models\Permission;
     use Filament\Forms;
     use Filament\Forms\Form;
     use Filament\Resources\Resource;
     use Filament\Tables;
     use Filament\Tables\Table;

     class PermissionResource extends Resource
     {
         protected static ?string $model = Permission::class;
         protected static ?string $navigationIcon = 'heroicon-o-key';
         protected static ?string $navigationGroup = 'Permissions';

         public static function canAccess(): bool
         {
             return auth()->user()->hasPermissionTo('manage-permissions', 'web');
         }

         public static function form(Form $form): Form
         {
             return $form
                 ->schema([
                     Forms\Components\TextInput::make('name')
                         ->required()
                         ->maxLength(255)
                         ->unique(ignoreRecord: true),
                     Forms\Components\Select::make('guard_name')
                         ->options([
                             'web' => 'Web',
                             'api' => 'API',
                         ])
                         ->default('web')
                         ->required(),
                 ]);
         }

         public static function table(Table $table): Table
         {
             return $table
                 ->columns([
                     Tables\Columns\TextColumn::make('name')
                         ->searchable(),
                     Tables\Columns\TextColumn::make('guard_name'),
                     Tables\Columns\TextColumn::make('created_at')
                         ->dateTime(),
                 ])
                 ->filters([
                     Tables\Filters\SelectFilter::make('guard_name')
                         ->options([
                             'web' => 'Web',
                             'api' => 'API',
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
                 'index' => Pages\ListPermissions::route('/'),
                 'create' => Pages\CreatePermission::route('/create'),
                 'edit' => Pages\EditPermission::route('/{record}/edit'),
             ];
         }
     }
     ?>