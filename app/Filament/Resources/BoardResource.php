<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BoardResource\Pages;
use App\Filament\Resources\BoardResource\RelationManagers;
use App\Filament\Resources\BoardResource\RelationManagers\SubtasksRelationManager;
use App\Filament\Resources\BoardResource\RelationManagers\TasksRelationManager;
use App\Models\Board;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Icetalker\FilamentTableRepeater\Forms\Components\TableRepeater;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class BoardResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $modelLabel = 'Mis proyectos';
    protected static ?string $slug = 'board';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([

                        Select::make('company_id')
                            ->relationship('company','name')
                            ->disabled()
                            ->required(),
                        Select::make('user_id')
                            ->multiple()
                            ->relationship('user','name')
                            ->preload()
                            ->disabled()
                            ->required(),
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->disabled()
                            ->maxLength(255),
                        TextInput::make('amount')
                            ->required()
                            ->disabled()
                            ->mask(fn (TextInput\Mask $mask) => $mask->money(prefix: '$', thousandsSeparator: ',', decimalPlaces: 0))
                            ->numeric()
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('company.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('amount')
                    ->formatStateUsing(fn (int $state): string => '$'.number_format($state,0))
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            TasksRelationManager::class,
            SubtasksRelationManager::class,
        ];
    }

    protected static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->hasRole('manager');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBoards::route('/'),
            'create' => Pages\CreateBoard::route('/create'),
            'edit' => Pages\EditBoard::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
                        ->where('status',0)
                        ->whereHas('user', function($query){
                            $query->where('users.id', Auth::id());
                        });
    }


}
