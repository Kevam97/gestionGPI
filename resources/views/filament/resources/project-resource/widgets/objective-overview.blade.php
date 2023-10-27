<x-filament::widget>
    <x-filament::card>
        <span class="font-semibold">Objetivos</span>
        <div>

            <span>{{ $record->objectives->count().'/'.$record->objectives->where('status',true)->count() }}</span>
        </div>
    </x-filament::card>
</x-filament::widget>
