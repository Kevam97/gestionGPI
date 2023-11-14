<span style="text-transform: uppercase; color:rgb(45, 45, 179); font-weight: bold;">Generalidades</span>
<div style="width:100%;">

    <table style="width:100%;  margin-bottom: 5%;">
        <tr>
            <th style="width:50%; border: 1px solid #dddddd; background-color: #9c9c9c">
                Name
            </th>
            <td style=" width:50%; border: 1px solid #dddddd;">
                {{ $project->name }}
            </td>
        </tr>
        <tr>

            <th style="width:50%; border: 1px solid #dddddd; background-color: #9c9c9c">
                Empresa
            </th>
            <td style=" width:50%; border: 1px solid #dddddd;">
                {{ $project->company->name }}
            </td>
        </tr>
        <tr>
            <th style=" width:50%; border: 1px solid #dddddd; background-color: #9c9c9c">
                Presupuesto
            </th>
            <td style=" width:50%; border: 1px solid #dddddd;">
                {{ '$'.number_format($project->amount,0)}}
            </td>
        </tr>
        <tr>

            <th style="width:50%; border: 1px solid #dddddd; background-color: #9c9c9c">
                Personas asignadas  a la ejecucion
            </th>
            <td style="width:50%; border: 1px solid #dddddd;">
                @foreach ($project->user as $user)
                {{ $user->name }} <br>
                @endforeach
            </td>
        </tr>
    </table>
</div>

<span style="text-transform: uppercase; color:rgb(45, 45, 179); font-weight: bold;">Informacion de la empresa</span>
<table style="width:100%;  margin-bottom: 5%;">
    <tr>
        <th style="width:50%; border: 1px solid #dddddd; background-color: #9c9c9c">
            Nit
        </th>
        <td style="width:50%; border: 1px solid #dddddd;">
            {{ $project->company->nit }}
        </td>
    </tr>
    <tr>
        <th style="width:50%; border: 1px solid #dddddd; background-color: #9c9c9c">
            Empresa
        </th>
        <td style="width:50%; border: 1px solid #dddddd;">
            {{ $project->company->name }}
        </td>
    </tr>
    <tr>
        <th style="width:50%; border: 1px solid #dddddd; background-color: #9c9c9c">
            Representante
        </th>
        <td style="width:50%; border: 1px solid #dddddd;">
            {{ $project->company->agent }}
        </td>
    </tr>
    <tr>
        <th style="width:50%; border: 1px solid #dddddd; background-color: #9c9c9c">
            Correo
        </th>
        <td style="width:50%; border: 1px solid #dddddd;">
            {{ $project->company->email }}
        </td>
    </tr>
    <tr>
        <th style="width:50%; border: 1px solid #dddddd; background-color: #9c9c9c">
            Telefono
        </th>
        <td style="width:50%; border: 1px solid #dddddd;">
            {{ $project->company->phone }}
        </td>
    </tr>
</table>

<span style="text-transform: uppercase; color:rgb(45, 45, 179); font-weight: bold;">Objetivos del proyecto({{'Total: '.$project->objectives->count()  }})</span>
@foreach ($project->objectives as $key => $objective )
    <div style='width:100%; border: 1px solid #000000; padding: 1em; margin-bottom: 5%;'>
        <span style="text-transform: uppercase; color:rgb(45, 45, 179); font-weight: bold;">Objetivo {{ ($key+1).' de '.$project->objectives->count() }}:</span>
        <table style='width:100%;' border="1">
            <thead style="background-color: #9c9c9c">
                <tr>
                    <th>Nombre</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody style=" border: 1px solid #dddddd;">
                <tr>
                    <td>
                        {{ $objective->name }}
                    </td>
                    <td>
                        @if ($objective->status )
                            Terminado
                        @else
                        En proceso
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
        @foreach ($objective->specificObjectives as $specificObjective )
            <table style='width:100%; margin-top: 5%; margin-bottom: 5%;' border="1">
                <thead style="background-color: #9c9c9c">
                    <tr>
                        <th>Nombre</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            {{ $specificObjective->name }}
                        </td>
                        <td>
                            @if ($specificObjective->status )
                                Terminado
                            @else
                                En proceso
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            <span style="text-transform: uppercase; color:rgb(45, 45, 179); font-weight: bold;">Actividades del objetivo especifico</span>
            <table  style='width:100%;' border="1">
                <thead style="background-color: #9c9c9c">
                    <tr>
                        <th>Nombre</th>
                        <th>Presupuesto</th>
                        <th>Fecha inicio</th>
                        <th>Fecha fin</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($specificObjective->tasks as $task)
                        <tr>
                            <td>
                                {{ $task->name }}
                            </td>
                            <td>
                                {{ '$'.number_format($task->value,0) }}
                            </td>
                            <td>
                                {{ $task->start->format('Y-m-d') }}
                            </td>
                            <td>
                                {{ $task->end->format('Y-m-d') }}
                            </td>
                            <td>
                                @if ($task->status )
                                    Terminado
                                @else
                                    En proceso
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endforeach
    </div>
@endforeach
