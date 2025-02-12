@extends('layouts.app')

@section('title', 'Detalles')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/proyecto-general.css') }}">
<link rel="stylesheet" href="{{ asset('css/gestor-de-TI.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection

@section('content')
<div class="job-card">
    <div class="section-content">
    <h1>{{ $proyecto->nombre_proyecto }}</h1>
    </div>

    <div class="section">
        <div class="section-title"><i class="fas fa-file-alt"></i> Descripción:</div>
        <div class="section-content">
            {{ $proyecto->descripcion_proyecto }}
        </div>
    </div>

    <div class="section">
        <div class="section-title"> <i class="fas fa-users"></i> Estudiantes asignados:</div>
        <div class="subtitle">

            @if($proyecto->estudiantes->isNotEmpty())
            <ul>
                @foreach($proyecto->estudiantes as $estudiante)
                <li>
                    DUE: {{ $estudiante->id_estudiante }},
                    Nombre: {{ $estudiante->usuario ? $estudiante->usuario->name : 'No disponible' }}
                </li>
                @endforeach
            </ul>
            @else
            <p>No hay estudiantes disponibles.</p>
            @endif

        </div>
    </div>

    <div class="section">
        <div class="section-title"><i class="fas fa-clock"></i> Horas requeridas:</div>
        <div class="section-content">{{ $proyecto->horas_requeridas === 0 ? 'Sin asignar horas' : $proyecto->horas_requeridas . '  horas requeridas' }}</div>
    </div>

    <div class="section">
        <div class="section-title"><i class="fas fa-map-marker-alt"></i> Ubicación:</div>
        <div class="section-content">{{ $proyecto->lugar }}</div>
    </div>

    <div class="section">
        <div class="section-title"><i class="fas fa-building"></i> Sección Departamental:</div>
        <div class="section-content">{{ $proyecto->seccion->nombre_seccion }}</div>
    </div>

    <div class="section">
        <div class="section-title"><i class="fas fa-calendar-alt"></i> Fechas:</div>
        <div class="section-content">
            Fecha de inicio: {{ \Carbon\Carbon::parse($proyecto->fecha_inicio)->format('d-m-Y') }}<br>
            Fecha de fin: {{ \Carbon\Carbon::parse($proyecto->fecha_fin)->format('d-m-Y') }}
        </div>
    </div>

    <div class="section">
        <div class="section-title"><i class="fas fa-cogs"></i> Estado:</div>
        <div class="section-content">
            {{$proyecto->estadoos->nombre_estado}}
        </div>
    </div>

    <div class="actions">
        <form action="{{ route('proyectos.aceptar', ['id_proyecto' => $proyecto->id_proyecto]) }}" method="POST" style="display: inline-block;">
            @csrf
            <button type="submit" class="btn btn-success">Aceptar</button>
        </form>
        <form action="{{ route('proyectos.rechazar', ['id_proyecto' => $proyecto->id_proyecto]) }}" method="POST" style="display: inline-block;">
            @csrf
            <button type="submit" class="btn btn-danger">Rechazar</button>
        </form>
    </div>
</div>
@endsection