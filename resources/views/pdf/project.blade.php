<div class="grid grid-cols-2">
    <div>
        <label>Nombre</label>
        {{ $project->name }}
    </div>

    <div>
        <label>Empresa</label>
        {{ $project->company->name }}
    </div>

    <div>
        <label>Presupuesto</label>
        {{ $project->amount }}
    </div>


</div>
<br>
<table class="table-auto">
    <thead>
        <tr>
            <th>Objetivo</th>
            <th>Especificos</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($project->objectives as $objective)
            <tr>
                <td>{{ $objective->name }}</td>
                <td>{{ $objective->specificObjectives->count() }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
<br>
@foreach ($project->objectives as $objective)

    <label>Objetivo: {{ $objective->name }}</label>

    <table class="table-auto">
        <thead>
            <tr>
                <th>Especificos</th>
                <th>Tareas</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($objective->specificObjectives as $specificObjective)
                <tr>
                    <td>{{ $specificObjective->name }}</td>
                    <td>{{ $specificObjective->tasks->count() }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endforeach
