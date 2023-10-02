<?php

namespace App\Filament\Pages;

use App\Models\Objective;
use App\Models\Project;
use Filament\Tables;
use App\Models\SpecificObjective;
use App\Models\Subtask;
use App\Models\Task;
use Closure;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Pages\Page;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class Panel extends Page implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.panel';

    public  $project;
    public  $objective;
    public  $specificObjective;
    public  $task;
    public  $subtask;
    // protected Builder $query;



    public function edit($record)
    {
        return [
            TextInput::make('text')
        ];
    }

    protected function getFormSchema(): array
    {
        return [
            Card::make()
                ->schema([
                    Wizard::make([
                        Wizard\Step::make('Project')
                        ->schema([
                            Select::make('project')
                            ->options(auth()->user()->projects()->pluck('name','projects.id'))
                            ->reactive()
                            ->searchable(),
                                ]),
                        Wizard\Step::make('Objective')
                            ->schema([
                                Select::make('objective')
                                ->options(
                                    fn(Closure $get)=> Objective::where('project_id',$get('project'))->pluck('name','id')
                                    )
                                ->reactive()
                                ->searchable()
                                ->hidden(fn (Closure $get) => $get('project') === null),
                            ]),
                        Wizard\Step::make('Specifics Objectives')
                            ->schema([
                                Select::make('specificObjective')
                                ->options(
                                    fn(Closure $get)=> SpecificObjective::where('objective_id',$get('objective'))->pluck('name','id')
                                    )
                                ->reactive()
                                ->searchable()
                                ->hidden(fn (Closure $get) => $get('objective') === null),
                            ]),
                        Wizard\Step::make('Tasks')
                            ->schema([
                                Select::make('task')
                                ->options(
                                    fn(Closure $get)=> Task::where('specific_objective_id',$get('specificObjective'))->pluck('name','id')
                                    )
                                ->reactive()
                                ->searchable()
                                ->hidden(fn (Closure $get) => $get('specificObjective') === null),
                            ]),
                    ])
                    ->skippable()




                    // CheckboxList::make('subtask')
                    //     ->options(
                    //         fn(Closure $get)=> Subtask::where('task_id',$get('task'))->pluck('name','id')
                    //         )

                    //     ->hidden(fn (Closure $get) => $get('task') === null),
                ])
        ];
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('name'),
            IconColumn::make('status')
                ->boolean()
        ];
    }

    // protected function getTableRecordActionUsing(): ?Closure
    // {
    //     return fn (): string => 'edit';
    // }
}
