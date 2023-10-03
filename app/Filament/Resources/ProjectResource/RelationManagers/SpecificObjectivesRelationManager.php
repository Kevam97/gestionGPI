<?php

namespace App\Filament\Resources\ProjectResource\RelationManagers;

use Closure;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Icetalker\FilamentTableRepeater\Forms\Components\TableRepeater;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SpecificObjectivesRelationManager extends RelationManager
{
    protected static string $relationship = 'specificObjectives';
    protected static ?string $modelLabel = "Objetivos especificos";
    protected static ?string $pluralModelLabel = "Objetivos especificos";
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
                TableRepeater::make('tasks')
                    ->relationship()
                    ->schema([
                        TextInput::make('name')
                            ->required(),
                        TextInput::make('value')
                            ->numeric()
                            ->required(),
                        DatePicker::make('start')
                            ->required(),
                        DatePicker::make('end')
                            ->required(),
                        Select::make('users')
                            ->multiple()
                            ->preload()
                            ->relationship('users', 'name',
                                fn(Builder $query, RelationManager $livewire) => $query->whereIn('id',$livewire->ownerRecord->user()->pluck('users.id')->toArray())
                            ),
                        Hidden::make('project_id')
                            ->default(fn(RelationManager $livewire) => $livewire->ownerRecord->id)
                    ])
                    ->rules([
                        function ( RelationManager $livewire) {
                            return function (string $attribute, $value, Closure $fail) use ($livewire) {
                                $amount = 0;
                                $amount_assigned = 0;

                                foreach ($value as $key => $item) {
                                    if (str_contains($key,'record') == false) {
                                        $amount = $item['value'] + $amount;
                                    }
                                }

                                foreach ($livewire->ownerRecord->tasks as  $task) {
                                    $amount_assigned = $task->value + $amount_assigned;
                                }

                                if ($amount  > $livewire->ownerRecord->amount || ($amount_assigned + $amount) > $livewire->ownerRecord->amount ) {

                                    $fail('Sobrepasa el presupuesto asignado al proyecto');
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
                TextColumn::make('objective.name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('name')
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query
                            ->where('specific_objectives.name', 'like', "%{$search}%");
                    })
                    ->label('Specific objective'),
            ])
            ->filters([
                SelectFilter::make('objective')
                    ->relationship('objective', 'name',
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
