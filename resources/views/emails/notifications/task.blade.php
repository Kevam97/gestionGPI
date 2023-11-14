<x-mail::message>
# {{ $task->name }}

{{ $user->name }}, tienes un pendiente la actividad {{ $task->name }} del proyecto {{ $task->project->name }}
que tiene un tiempo asigando entre {{ $task->start->format('d/m/Y') }} - {{ $task->end->format('d/m/Y') }}.

{{ config('app.name') }}
</x-mail::message>
