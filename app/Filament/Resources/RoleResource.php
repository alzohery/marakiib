<?php

     namespace App\Filament\Resources;

     use App\Filament\Resources\RoleResource\Pages;
     use Spatie\Permission\Models\Role;
     use Filament\Forms;
     use Filament\Forms\Form;
     use Filament\Resources\Resource;
     use Filament\Tables;
     use Filament\Tables\Table;

     class RoleResource extends Resource
     {
         protected static ?string $model = Role::class;
         protected static ?string $navigationIcon = 'heroicon-o-shield-check';
         protected static ?string $navigationGroup = 'Permissions';

         public static function canAccess(): bool
         {
             return auth()->user()->hasPermissionTo('manage-roles', 'web');
         }

         public static function form(Form $form): Form
         {
             return $form
                 ->schema([
                     Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->unique(
                        table: Role::class, 
                        column: 'name', 
                        ignoreRecord: true, 
                        modifyRuleUsing: fn ($rule, $get) => $rule->where('guard_name', $get('guard_name'))
                    ),

                     Forms\Components\Select::make('permissions')
                         ->multiple()
                         ->relationship('permissions', 'name')
                         ->preload()
                         ->searchable(),
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
                     Tables\Columns\TextColumn::make('permissions.name')
                         ->listWithLineBreaks()
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
                 'index' => Pages\ListRoles::route('/'),
                 'create' => Pages\CreateRole::route('/create'),
                 'edit' => Pages\EditRole::route('/{record}/edit'),
             ];
         }
     }
     ?>