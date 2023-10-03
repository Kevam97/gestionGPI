<?php

namespace App\Filament\Resources\ProjectResource\RelationManagers;

use App\Models\Objective;
use App\Models\SpecificObjective;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SubtasksRelationManager extends RelationManager
{
    protected static string $relationship = 'subtasks';
    protected static ?string $modelLabel = "Subactividades";
    protected static ?string $pluralModelLabel = "Subactividades";
    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('task.specificObjective.objective.name')
                    ->searchable(),
                TextColumn::make('task.specificObjective.name')
                    ->searchable(),
                TextColumn::make('task.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->label('subtask'),
                TextColumn::make('value')
                    ->sortable()
            ])
            ->filters([
                SelectFilter::make('objective')
                    ->options(fn(RelationManager $livewire) => Objective::where('project_id',$livewire->ownerRecord->id)->pluck('name','id')),
                SelectFilter::make('specificObjective')
                    ->options(fn(RelationManager $livewire) => SpecificObjective::whereHas('objective', function ($query)  use ($livewire){
                        $query->where('project_id', $livewire->ownerRecord->id);
                    })->with('objective')->pluck('name','id')),
                SelectFilter::make('task')
                    ->relationship('task', 'name',
                        fn (Builder $query, RelationManager $livewire) => $query->where('project_id', $livewire->ownerRecord->id))

            ])
            ->headerActions([
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
