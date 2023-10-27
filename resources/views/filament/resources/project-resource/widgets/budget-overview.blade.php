<x-filament::widget>
    <x-filament::card>
        <span class="font-semibold">Presupuesto</span>
        <div class="grid grid-cols-2">
            <div>
                Asignado:
            </div>
            <div>
                {{ '$'.number_format($record->amount ,0) }}
            </div>
            <div>
                Disponible:
            </div>
            <div>
                {{ '$'.number_format($record->amount  - $record->tasks->sum('value'), 0) }}
            </div>
        </div>
    </x-filament::card>
</x-filament::widget>
