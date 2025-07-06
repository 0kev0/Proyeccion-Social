@extends('layouts.appE')

@section('title', 'Dashboard - Horas Sociales')

@section('styles')

@endsection

@section('content')
<div class="container mt-5">
    <div class="row">
        <!-- Información de usuario -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4>Información del Usuario</h4>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item"><strong>Nombre:</strong> {{ $estudiante->name }}</li>
                        <li class="list-group-item"><strong>Apellido:</strong> {{ $estudiante->apellido }}</li>
                        <li class="list-group-item"><strong>Sección:</strong> {{ $estudiante->estudiante->seccion->nombre_seccion}}</li>
                        <li class="list-group-item"><strong>Horas Completadas:</strong> {{ $estudiante->estudiante->horas_sociales_completadas }} (hrs) / 500 (hrs)</li>
                    </ul>

                    <!-- Barra de progreso -->
                    <div class="mt-3">
                        <strong>Progreso: </strong>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: {{ $estudiante->estudiante->porcentaje_completado }}%;" aria-valuenow="{{ $estudiante->estudiante->porcentaje_completado }}" aria-valuemin="0" aria-valuemax="100">
                            {{ $estudiante->estudiante->porcentaje_completado }}%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-secondary text-white">
                        <h4>Historial de Proyectos</h4>
                    </div>
                    <div class="card-body">
                        @if($estudiante->estudiante->proyecto == null)
                        <p>No hay proyectos asignados.</p>
                        @else
                        <ul class="list-group">
                            <li class="list-group-item">
                                <strong>Proyecto:</strong> {{ $estudiante->estudiante->proyecto->nombre_proyecto }} <br>
                                <small><em>{{$estudiante->estudiante->proyecto->fecha_inicio }} - {{ $estudiante->estudiante->proyecto->fecha_fin  }}</em></small>
                            </li>

                        </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


@endsection