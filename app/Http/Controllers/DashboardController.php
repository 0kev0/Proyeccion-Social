<?php

namespace App\Http\Controllers;

use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\NotificacionController;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    protected $estudianteController;
    protected $proyectoController;
    protected $userController;
    protected $notificacionController;

    // Inyección de dependencias a través del constructor
    public function __construct(
        EstudianteController $estudianteController,
        ProyectoController $proyectoController,
        UserController $userController,
        NotificacionController $notificacionController
    ) {
        $this->estudianteController = $estudianteController;
        $this->proyectoController = $proyectoController;
        $this->userController = $userController;
        $this->notificacionController = $notificacionController;
    }
    public function index()
    {
        $totalEstudiantes = $this->estudianteController->totalEstudiantes();
        $totalProyectosActivos = $this->proyectoController->totalProyectosActivos();
        $totalProyectosAsignados = $this->proyectoController->totalProyectosAsignados();
        $totalTutores = $this->userController->totalTutores();
        $totalCoordinadores = $this->userController->totalCoordinadores();
        $notificaciones = $this->notificacionController->getNotifiaciones(Auth::user()->id_usuario);

        return view('dashboard.dashboard', compact('totalEstudiantes', 'totalProyectosActivos', 'totalProyectosAsignados', 'totalTutores', 'totalCoordinadores', 'notificaciones'));
    }
}
