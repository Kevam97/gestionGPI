<?php

namespace App\Filament\Resources\ProjectResource\RelationManagers;

use App\Models\Objective;
use App\Models\SpecificObjective;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Icetalker\FilamentTableRepeater\Forms\Components\TableRepeater;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TasksRelationManager extends RelationManager
{
    protected static string $relationship = 'tasks';
    protected static ?string $modelLabel = "Actividades";
    protected static ?string $pluralModelLabel = "Actividades";
    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                ->schema([

                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TableRepeater::make('subtasks')
                    ->relationship()
                    ->schema([
                        TextInput::make('name')
                            ->required(),
                        TextInput::make('value')
                            ->mask(fn (TextInput\Mask $mask) => $mask->money(prefix: '$', thousandsSeparator: ',', decimalPlaces: 0))
                            ->required(),
                        Hidden::make('project_id')
                            ->default(function(RelationManager $livewire)
                            {
                                return $livewire->ownerRecord->id;
                            })
                    ])
                    ->rules([
                        function (Model $record) {
                            return function (string $attribute, $value, Closure $fail) use ($record) {
                                $amount = 0;
                                $amount_assigned = 0;

                                foreach ($value as $key => $item) {
                                    if (str_contains($key,'record') == false) {
                                        $amount = $item['value'] + $amount;
                                    }
                                }

                                foreach ($record->subtasks as  $subtask) {
                                    $amount_assigned = $subtask->value + $amount_assigned;
                                }

                                if ($amount  > $record->value || ($amount_assigned + $amount) > $record->value ) {

                                    $fail('Sobrepasa el presupuesto asignado a la actividad');
                                }
                            };
                        },
                    ]),
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
                    ->sortable()
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
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
