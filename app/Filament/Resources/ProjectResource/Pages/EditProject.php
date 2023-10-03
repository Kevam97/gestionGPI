<?php

namespace App\Filament\Resources\ProjectResource\Pages;

use App\Filament\Resources\ProjectResource;
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
                    // return response()->download(public_path('storage/projects/' . $this->record->name.'.pdf'));
                })

        ];
    }

    public function hasCombinedRelationManagerTabsWithForm(): bool
    {
        return true;
    }

    public function generatePDF()
    {

        $pdf = Pdf::loadView('pdf.project', ['project' => $this->record]);
        Storage::disk('public')->makeDirectory('projects');

        return $pdf->save(public_path('storage/projects/' . $this->record->name.'.pdf'));
        ;
    }

}
