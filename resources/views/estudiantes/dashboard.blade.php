@extends('layouts.appE')

@section('title', 'Dashboard - Horas Sociales')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/estudianteprincipal.css') }}">
<link rel="stylesheet" href="{{ asset('css/deshboard-title.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
@endsection

@section('content')

@if (session()->has('warning'))
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    {{ session('warning') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="card mx-auto mb-4 card-med">
    <div class="card-body">
        <h2 class="card-title text-start fw-bold">Proceso de Horas Sociales</h2>
        <p class="card-text text-muted text-start">Seguimiento paso a paso de tu proceso</p>
        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    <div>
                        <span class="badge rounded-circle  circulo-paso" style="width: 30px; height: 30px;">1</span>
                        <p>
                            Formulario No. 1 Hoja de inscripción para realizar servicio social
                            
                        </p>
                    </div>
                </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <!-- Card 1 -->
                        <div class="col-12">
                            <div class="card shadow-sm h-100 card-reducido">
                                <div class="card-body">
                                    <h5 class="titulo-documento">
                                        <span class="step-number">1.</span> Inscripción
                                    </h5>
                                    <p class="descripcion-corta">Inicia el proceso de inscripción para el servicio social</p>
                                    <ul class="step-list">
                                        <li>Presentarse en la unidad de proyección social para abrir expediente.</li>
                                        <li>Solicitar y llenar el Formulario de Hoja de Inscripción (Formulario N°1).</li>
                                        <li>Entregar el formulario al coordinador de la subunidad de Proyección Social.</li>
                                    </ul>
                                    <a href="{{ route('descargar', ['filename' => 'FORMULARIO N1 HOJA DE INSCRIPCION PARA SERVICIO SOCIAL.docx']) }}" class="btn btn-descargar">
                                        <i class="bi bi-download me-2"></i> Descargar formulario-inscripcion.docx
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    <span class="badge rounded-circle  circulo-paso" style="width: 30px; height: 30px;">2</span>
                    <p>Carta No. 1 Asignación de tutor de servicio social</p> 
                </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                <!---->
                            <!-- Card 2 -->
                    <div class="col-12">
                        <div class="card shadow-sm h-100 card-reducido">
                            <div class="card-body">
                                <h5 class="titulo-documento">
                                    <span class="step-number">2.</span> Asignación de tutor
                                </h5>
                                <p class="descripcion-corta">Solicita la asignacion de un tutor para orientarte en el servicio social</p>
                                <ul class="step-list">
                                    <li>Rellena la asignacion de tutor</li>
                                    <li>Entregar la solicitud al coordinador de la subunidad.</li>
                                </ul>
                                <a href="{{ route('descargar', ['filename' => 'CARTA ASIGNACION DE TUTOR.docx']) }}" class="btn btn-descargar"><i class="bi bi-download"></i> Descargar Asignación Tutor</a>

                            </div>
                        </div>
                    </div>
            <!---->
                </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingThree">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    <span class="badge rounded-circle  circulo-paso" style="width: 30px; height: 30px;">3</span>
                    <p>Nota de la institución donde se desarrollarán las horas sociales</p>
                </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <div class="col-12">
                            <div class="card shadow-sm h-100">
                                <div class="card-body">
                                    <h5 class="titulo-documento">
                                        <span class="step-number">3. </span>Modelo de Carta a la Institución
                                    </h5>
                                    <p class="descripcion-corta">Plantilla de carta para la institución que recibirá el estudiante</p>
                                    <ul class="step-list">
                                        <li>Rellena la solicitud </li>
                                        <li>Una vez rellenado, entregalo a la institucion en donde se realizarán las horas sociales</li>
                                    </ul>
                                    <a href="{{ route('descargar', ['filename' => 'MODELO DE CARTA A LA INSTITUCION QUE SOLICITA ESTUDIANTES EN SERVICIO SOCIAL.docx']) }}" class="btn btn-descargar"><i class="bi bi-download"></i> Descargar Modelo Carta</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingFour">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                    <span class="badge rounded-circle  circulo-paso" style="width: 30px; height: 30px;">4</span>
                    <p>Constancia de la administración académica del 60% de la carrera</p>
                </button>
                </h2>
                <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                <!----->
                <!-- Card 3 -->
                <div class="col-12">
                        <div class="card shadow-sm h-100 card-reducido">
                            <div class="card-body">
                                <h5 class="titulo-documento">
                                    <span class="step-number">4.</span> Constancia del 60% de la carrera
                                </h5>
                                <p class="descripcion-corta">Sube la constancia del progreso de tu carrera</p>
                                <ul class="step-list">
                                    <li>Acudir a administración academica a solicitar dicho documento.</li>
                                    <li>Una vez entregado, subelo a tus documentos</li>
                                </ul>
                                
                            </div>
                        </div>
                    </div>
                <!---->
                
                </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingFive">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                    <span class="badge rounded-circle  circulo-paso" style="width: 30px; height: 30px;">5</span>
                    <p>Carta No. 2 Constancia de aprobación del plan de trabajo del servicio social</p>
                </button>
                </h2>
                <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                <!---->
                <!--card 4-->    
                <div class="col-12">
                        <div class="card shadow-sm h-100 card-reducido">
                            <div class="card-body">
                                <h5 class="titulo-documento">
                                    <span class="step-number">5.</span> Autorización y Planificación
                                </h5>
                                <p class="descripcion-corta">Obtén la autorización y planifica tu servicio social</p>
                                <ul class="step-list">
                                    <li>Recibir carta de autorización para iniciar el servicio social.</li>
                                    <li>Consultar las opciones de servicio social disponibles.</li>
                                    <li>Elaborar un plan de trabajo con ayuda del tutor asignado.</li>
                                    <li>Entregar el plan de trabajo al coordinador de la subunidad.</li>
                                </ul>
                                <a href="{{ route('descargar', ['filename' => 'Constancia de aprobación del Plan de Trabajo del Servicio Social.docx']) }}" class="btn btn-descargar">
                                    <i class="bi bi-download me-2"></i> Descargar plan-trabajo.docx
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="contenedor-carrusel ">
    <h2 class="titulo-proyectos mb-4">Proyectos disponibles</h2>
    @if ($proyectos->isEmpty())
    <p class="text-muted text-center">No hay proyectos disponibles en este momento.</p>
    @endif
    <div class="d-flex align-items-center justify-content-center ">
        <button class="btn boton-carrusel" id="btnIzquierda">
            <span class="flecha-carrusel"><i class="bi bi-arrow-left"></i></span>
        </button>
        <div class="carrusel carru" id="contenedorCarrusel">
            @foreach ($proyectos as $proyecto)
            <div class="tarjeta-proyecto carru">
                <h3 class="card-title c-titulo">{{ $proyecto->nombre_proyecto }}</h3>
                <br>
                <p class="card-text">Descripción:</p>
                <p class="card-text">{{ $proyecto->descripcion_proyecto }}</p>
                <p class="card-text"><strong>Horas requeridas:</strong> {{ $proyecto->horas_requeridas }}</p>

                <a href="{{ route('proyecto.ver', $proyecto->id_proyecto) }}" class="ver-mas">VER MÁS</a>
                <span class="{{ $proyecto->estado == 1 ? 'estado-disponible' : 'estado-no-disponible' }}">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    {{ $proyecto->estado == 1 ? 'Disponible' : 'No Disponible' }}
                </span>
            </div>
            @endforeach
        </div>
        <button class="btn boton-carrusel" id="btnDerecha">
            <span class="flecha-carrusel"><i class="bi bi-arrow-right"></i></span>
        </button>
    </div>
</div>


<div class="card mt-5 mx-auto card-med mb-4">
    <div class="card-body">
        <h2 class="titulo-documentos">Documentos</h2>
        <p class="descripcion-documentos text-start">
            Descarga los documentos necesarios para tu proceso
        </p>
        <ul class="lista-documentos">
            <li class="item-documento">
                <a href="{{ route('descargar', ['filename' => 'MODELO DE CARTA A LA INSTITUCION QUE SOLICITA ESTUDIANTES EN SERVICIO SOCIAL.docx']) }}" class="enlace-documento">
                    <span class="icono-documento">&#128196;</span>
                    <span class="texto-documento text-start">MODELO DE CARTA A LA INSTITUCION QUE SOLICITA ESTUDIANTES EN SERVICIO SOCIAL</span>
                </a>
            </li>

            <li class="item-documento">
                <a href="{{ route('descargar', ['filename' => 'FORMULARIO N1 HOJA DE INSCRIPCION PARA SERVICIO SOCIAL.docx'] ) }}" class="enlace-documento">
                    <span class="icono-documento">&#128196;</span>
                    <span class="texto-documento text-start">FORMULARIO N1 HOJA DE INSCRIPCION PARA SERVICIO SOCIAL</span>
                </a>
            </li>

        </ul>
        <a href="{{ route('documentos_horas_sociales') }}" class="ver-mas-documentos">VER MÁS</a>
    </div>

    <script src="{{ asset('js/estudianteprincipal.js') }}"></script>
    @endsection