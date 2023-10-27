<?php

namespace App\Filament\Resources\ProjectResource\Pages;

use App\Filament\Resources\ProjectResource;
use App\Filament\Resources\ProjectResource\Widgets\BudgetOverview;
use App\Filament\Resources\ProjectResource\Widgets\ObjectiveOverview;
use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\DomPDF\Pdf as document;
use Filament\Pages\Actions;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class EditProject extends EditRecord
{
    protected static string $resource = ProjectResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Action::make('pdf')
                ->action(function(){
                    $this->generatePDF();
                    return response()->download(public_path('storage/projects/' . $this->record->name.'.pdf'));
                }),
            Action::make('status')
                ->label(fn() => ($this->record->status) ? __("Open project") : __("Close Project"))
                ->color(fn() => ($this->record->status) ? "warning" : "success")
                ->action(function(){
                    if ($this->record->status)
                        $this->record->status = false;
                    else
                        $this->record->status = true;

                    $this->record->save();
                })
                ->requiresConfirmation()

        ];
    }

    public function hasCombinedRelationManagerTabsWithForm(): bool
    {
        return true;
    }

    protected function getHeaderWidgets(): array
    {
        return [
            BudgetOverview::class,
            ObjectiveOverview::class
        ];
    }

    public function generatePDF()
    {

        $pdf = Pdf::loadView('pdf.project', ['project' => $this->record]);
        Storage::disk('public')->makeDirectory('projects');

        return $pdf->save(public_path('storage/projects/' . $this->record->name.'.pdf'));
        ;
    }

}
