<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProyectosEstudiante\UpdateRequest;
use App\Http\Requests\ProyectosEstudiantes\StoreRequest;
use App\Models\Estudiante;
use App\Models\ProyectosEstudiantes;
use App\Models\HistoriaHorasActualizada;
use Illuminate\Container\Attributes\Log;
use Illuminate\Http\Request;

use App\Models\Proyecto;

use function Laravel\Prompts\select;

class ProyectosEstudiantesController extends Controller
{
    public function index()
    {
        $proyectos_estudiantes = ProyectosEstudiantes::all();
        return view('proyectos_estudiantes.index', compact('proyectos_estudiantes'));
    }

    public function getEstudiantesbyProyecto($id_proyectos)
    {
        $proyectos_estudiantes = ProyectosEstudiantes::where('id_proyectos', $id_proyectos)->get();
        return view('proyectos_estudiantes.index', compact('proyectos_estudiantes'));
    }

    public function getProyectobyEstudiantes($id_estudiantes)
    {
        $proyectos_estudiantes = ProyectosEstudiantes::where('id_estudiantes', $id_estudiantes)->get();
        return view('proyectos_estudiantes.index', compact('proyectos_estudiantes'));
    }

    public function create()
    {
        return view("proyectos_estudiantes.create");
    }
    
    public function store(StoreRequest $request)
    {
        ProyectosEstudiantes::create($request->all());

        return redirect()->route('proyectos_estudiantes.index')->with('success', 'Asignacion de estudiante a proyecto exitosa');
    }

    public function show(string $id)
    {
        $proyectos_estudiantes = ProyectosEstudiantes::find($id);
        return view('proyectos_estudiantes.show', compact('proyectos_estudiantes'));
    }

    public function edit(string $id)
    {
        $proyectos_estudiantes = ProyectosEstudiantes::find($id);

        if (!$proyectos_estudiantes) {
            return redirect()->route('proyectos_estudiantes.index')->with('error', 'No se econtró ese Proyecto');
        }
        return view("proyectos_estudiantes.edit", compact('proyectos_estudiantes'));
    }

    public function update(UpdateRequest $request, string $id)
    {

        $proyectos_estudiantes = ProyectosEstudiantes::find($id);

        if (!$proyectos_estudiantes) {
            return redirect()->route('proyectos_estudiantes.index')->with('error', 'No se econtró ese Proyecto');
        }

        $proyectos_estudiantes->update($request);
        return redirect()->route('proyectos_estudiantes.index')->with('success', 'Modificacion de asignacion de estudiante a proyecto exitosa');
    }

    public function destroy(string $id)
    {
        $proyectos_estudiantes = ProyectosEstudiantes::find($id);

        if (!$proyectos_estudiantes) {
            return redirect()->route('proyectos_estudiantes.index')->with('error', 'No se econtró ese Proyecto');
        }

        $proyectos_estudiantes->delete();
        return redirect()->route('proyectos_estudiantes.index')->with('success', 'Elminacion de asignacion de estudiante a proyecto exitosa');;
    }
    public function Rechazar_solicitus_destroy(string $id_proyectoEstudiante)
    {
        // Buscar registros relacionados al proyecto
        $proyectos_estudiantes = ProyectosEstudiantes::where('id_proyecto', $id_proyectoEstudiante)->get();

        // Verificar si existen registros relacionados
        if ($proyectos_estudiantes->isEmpty()) {
            return redirect()->back()->with('error', 'No se encontraron registros relacionados a eliminar.');
        }

        // Eliminar registros relacionados
        ProyectosEstudiantes::where('id_proyecto', $id_proyectoEstudiante)->delete();

        // Buscar y eliminar el proyecto principal
        $proyecto = Proyecto::find($id_proyectoEstudiante);
        if (!$proyecto) {
            return redirect()->back()->with('error', 'El proyecto principal no se encontró.');
        }
        $proyecto->delete();
        return redirect()->back()->with('success', 'Registros eliminados correctamente.');
    }

    //to service
    public function Detalles_proyecto()
    {
        $userId = auth()->user()->id_usuario;
        $estudiante = Estudiante::where('id_usuario', $userId)->first();

        if (!$estudiante) {
            return 'Estudiante no encontrado';
        }

        // Recupera la relación entre el estudiante y su proyecto
        $proyectoEstudiante = ProyectosEstudiantes::where('id_estudiante', $estudiante->id_estudiante)
            ->with('proyecto')
            ->first();

        if (!$proyectoEstudiante || !$proyectoEstudiante->proyecto) {
            return 'No posee proyecto asignado';
        }

        $horasCompletadas = $estudiante->horas_sociales_completadas ?? 0;
        $horasTotales = $proyectoEstudiante->proyecto->horas_requeridas ?? 1;

        $porcentaje = $horasTotales > 0
            ? round(($horasCompletadas / $horasTotales) * 100, 2)
            : 0;

        // Obtener historial de horas actualizadas para este proyecto
        $historial = HistoriaHorasActualizada::where('id_proyecto', $proyectoEstudiante->proyecto->id_proyecto)
            ->orderBy('created_at', 'desc')  // Opcional: Ordenar por la fecha de actualización
            ->get();

        return view('estudiantes.detallesmio', compact('proyectoEstudiante', 'porcentaje', 'horasCompletadas', 'horasTotales', 'historial'));
    }

    //retorna vista solicitud de proyecto
    public function Mi_proyecto()
    {
        $userId = auth()->user()->id_usuario;
        $estudiante = Estudiante::where('id_usuario', $userId)->first();

        if (!$estudiante) {
            return redirect()->back()->with('warning', 'Estudiante no encontrado.');
        }

        $proyectoEstudiante = ProyectosEstudiantes::where('id_estudiante', $estudiante->id_estudiante)
            ->with('proyecto')
            ->first();

        if (!$proyectoEstudiante || !$proyectoEstudiante->proyecto) {
            return redirect()->back()->with('warning', 'No posee proyecto asignado.');
        }

        $horasCompletadas = $estudiante->horas_sociales_completadas ?? 0;
        $horasTotales = $proyectoEstudiante->proyecto->horas_requeridas ?? 1;

        // Calcula el porcentaje
        $porcentaje = $horasTotales > 0
            ? round(($horasCompletadas / $horasTotales) * 100, 2)
            : 0;

        return view('estudiantes.proyectomio', compact('proyectoEstudiante', 'porcentaje', 'horasCompletadas', 'horasTotales'));
    }


public function Solicitud_Proyecto_Student()
{
    // Obtener el ID del usuario autenticado
    $estudianteId = auth()->user()->id_usuario;
    \Log::debug("ID del estudiante autenticado: " . $estudianteId); // Mensaje de depuración

    // Obtener el estudiante con la relación 'proyecto'
    $estudiante = Estudiante::with('proyecto') // Asumimos que hay una relación 'proyecto' en Estudiante
        ->where('id_usuario', $estudianteId)
        ->first();

    if (!$estudiante) {
        \Log::debug("No se encontró al estudiante con ID: " . $estudianteId); // Mensaje de depuración
        return redirect()->back()->with('error', 'No se encontró al estudiante.');
    }

    // Verificar si el estudiante tiene un proyecto asignado
    if ($estudiante->proyecto) {
        \Log::debug("El estudiante tiene un proyecto asignado con ID: " . $estudiante->proyecto->id_proyecto); // Mensaje de depuración

        // Verificar si el proyecto tiene un estado de 7 (estado no permitido para solicitud)
        if ($estudiante->proyecto) {
            \Log::debug("El proyecto tiene un estado de 7, no se puede enviar la solicitud."); // Mensaje de depuración
            return redirect()->back()->with('warning', 'No se puede enviar el proyecto, ya enviaste una solicitud.');
        }
        $seccion_id = $estudiante->id_seccion;

        \Log::debug("El proyecto tiene un estado permitido, se puede enviar la solicitud."); // Mensaje de depuración

        return view('estudiantes.solicitud-proyecto', compact('estudiante','seccion_id'));
    }

    // Si el estudiante no tiene un proyecto asignado
    $seccion_id = $estudiante->id_seccion;
    \Log::debug("El estudiante no tiene proyecto, buscando proyectos para la sección con ID: " . $seccion_id); // Mensaje de depuración

    // Obtener proyectos disponibles para la sección del estudiante
    $proyectosDisponibles = Proyecto::where('seccion_id', $seccion_id)->get();
    \Log::debug("Proyectos disponibles para la sección: " . $proyectosDisponibles->count()); // Mensaje de depuración

    if ($proyectosDisponibles->isEmpty()) {
        \Log::debug("No hay proyectos disponibles para la sección con ID: " . $seccion_id); // Mensaje de depuración
        return redirect()->back()->with('error', 'No hay proyectos disponibles para esta sección.');
    }

    // Mostrar vista con los proyectos disponibles
    \Log::debug("Hay proyectos disponibles, mostrando la vista."); // Mensaje de depuración
    return view('estudiantes.solicitud-proyecto', compact('proyectosDisponibles','seccion_id'));
}



    public function Procesos()
    {
        return view('estudiantes.vista_procesos_horas');
    }

    public function docs()
    {
        return view('estudiantes.docs_tramites');
    }
}
