<?php

namespace App\Filament\Resources\BoardResource\RelationManagers;

use App\Models\Objective;
use App\Models\SpecificObjective;
use App\Models\Subtask;
use App\Models\Task;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Icetalker\FilamentTableRepeater\Forms\Components\TableRepeater;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class TasksRelationManager extends RelationManager
{
    protected static string $relationship = 'boardTasks';
    protected static ?string $modelLabel = "Actividades";
    protected static ?string $pluralModelLabel = "Actividades";
    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                ->schema([

                Hidden::make('id')
                    ->reactive(),

                Forms\Components\TextInput::make('name')
                    ->required()
                    ->disabled()
                    ->maxLength(255),
                FileUpload::make('documents')
                    ->multiple(),
                Toggle::make('status')
                    ->hidden(fn(Closure $get) => Subtask::where('task_id',$get('id'))->count() > 0 )

                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('specificObjective.objective.name')
                    ->searchable(),
                TextColumn::make('specificObjective.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->label('task'),
                TextColumn::make('value')
                    ->formatStateUsing(fn (int $state): string => '$'.number_format($state,0))
                    ->sortable(),
                IconColumn::make('status')
                    ->boolean()
            ])
            ->filters([
                SelectFilter::make('objective')
                    ->options(fn(RelationManager $livewire) => Objective::where('project_id',$livewire->ownerRecord->id)->pluck('name','id')),
                SelectFilter::make('specificObjective')
                    ->options(fn(RelationManager $livewire) => SpecificObjective::whereHas('objective', function ($query)  use ($livewire){
                        $query->where('project_id', $livewire->ownerRecord->id);
                    })->with('objective')->pluck('name','id'))
            ])
            ->headerActions([
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
