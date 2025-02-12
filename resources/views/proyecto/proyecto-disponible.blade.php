@extends('layouts.app')

@section('title', 'Proyectos Disponibles')

@section('content')
<h2 class="my-4">Proyectos Disponibles</h2>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@php
    // Obtener el usuario autenticado
    $user = auth()->user();
    $userSeccion = null;

    // Determinar la sección según el rol del usuario
    if ($user->hasRole('Estudiante')) {
        $userSeccion = DB::table('estudiantes')
            ->join('secciones', 'estudiantes.id_seccion', '=', 'secciones.id_seccion')
            ->where('estudiantes.id_usuario', $user->id_usuario)
            ->select('secciones.id_seccion', 'secciones.nombre_seccion')
            ->first();
    } elseif ($user->hasRole('Tutor')) {
        $userSeccion = DB::table('seccion_tutor')
            ->join('secciones', 'seccion_tutor.id_seccion', '=', 'secciones.id_seccion')
            ->where('seccion_tutor.id_tutor', $user->id_usuario)
            ->select('secciones.id_seccion', 'secciones.nombre_seccion')
            ->first();
    } elseif ($user->hasRole('Coordinador')) {
        $userSeccion = DB::table('secciones')
            ->where('id_coordinador', $user->id_usuario)
            ->select('id_seccion', 'nombre_seccion')
            ->first();
    }

    // Filtrar proyectos según la sección y el rol del usuario
    $filteredProjects = $proyectos->filter(function ($proyecto) use ($user, $userSeccion) {
        // Administrador: Mostrar todos los proyectos
        if ($user->hasRole('Administrador')) {
            return true;
        }

        // Filtrar proyectos según la sección asociada al usuario
        return isset($proyecto->seccion) && $proyecto->seccion->id_seccion == ($userSeccion->id_seccion ?? null);
    });

    // Convertir proyectos filtrados a JSON
    $filteredProjectsJson = $filteredProjects->values()->toJson(); // `values()` reindexa el array
@endphp

<!-- Campo de búsqueda -->
<div class="buscar grupo-entrada mb-3 d-flex align-items-center rounded shadow-sm p-2 bg-white mx-auto" style="max-width: 700px;">
    <form class="d-flex w-100" onsubmit="return false;">
        <input type="text" id="search-input" class="form-control border-0 shadow-none" placeholder="Buscar proyectos..." aria-label="Buscar proyectos">
        <button class="btn btn-light p-2 ms-2 px-3" type="button" onclick="filterTable()">
            <i class="bi bi-search text-muted"></i>
        </button>
    </form>
</div>

<!-- Tabla de proyectos -->
<div class="tabla-contenedor shadow-sm rounded bg-white">
    <div class="table-responsive">
        <table id="projects-table" class="table tabla-hover align-middle mb-0">
            <thead class="tabla-clara border-bottom">
                <tr>
                    <th scope="col"><input type="checkbox" class="form-check-input"></th>
                    <th scope="col">Título del proyecto</th>
                    <th scope="col">Descripción</th>
                    <th scope="col">Horas requeridas</th>
                    <th scope="col">Ubicación</th>
                    <th scope="col">Sección/Departamento</th>
                    <th scope="col" class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody id="projects-tbody"></tbody>
        </table>
    </div>
    <!-- Controles de paginación -->
<div class="d-flex justify-content-between align-items-center mt-3">
    <!-- Selector de número de filas por página -->
    <div class="d-flex align-items-center">
        <label for="rows-per-page" class="me-2">Mostrar:</label>
        <select id="rows-per-page" class="form-select form-select-sm w-auto">
            <option value="5">5</option>
            <option value="10" selected>10</option>
            <option value="20">20</option>
            <option value="50">50</option>
        </select>
        <span class="ms-2">por página</span>
    </div>
    <ul id="pagination-buttons" class="pagination mb-0"></ul>
</div>

</div>


<!-- Contenedor oculto para almacenar los datos filtrados -->
<div id="all-projects" style="display: none;">{{ $filteredProjectsJson }}</div>

<script>
    let currentPage = 1; 
    let rowsPerPage = 10; 
    let allProjects = []; 
    let filteredProjects = [];

    document.addEventListener('DOMContentLoaded', () => {
        allProjects = JSON.parse(document.getElementById('all-projects').textContent);
        filteredProjects = allProjects;

        document.getElementById('search-input').addEventListener('input', filterTable);
        document.getElementById('rows-per-page').addEventListener('change', updateRowsPerPage);

        renderTable();
    });

    function updateRowsPerPage() {
        rowsPerPage = parseInt(document.getElementById('rows-per-page').value);
        currentPage = 1; 
        renderTable();
    }

    // Filtrar la tabla según el texto del buscador
    function filterTable() {
        const searchValue = document.getElementById('search-input').value.toLowerCase();

        filteredProjects = allProjects.filter(project =>
            project.nombre_proyecto.toLowerCase().includes(searchValue) ||
            project.descripcion_proyecto.toLowerCase().includes(searchValue) ||
            project.lugar.toLowerCase().includes(searchValue)
        );

        currentPage = 1; 
        renderTable();
    }

    function renderTable() {
        const tbody = document.getElementById('projects-tbody');
        tbody.innerHTML = ''; 

        const start = (currentPage - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        const pageData = filteredProjects.slice(start, end);

        pageData.forEach(project => {
            const row = `
                <tr>
                    <td><input type="checkbox" class="form-check-input" value="${project.id_proyecto}"></td>
                    <td>${project.nombre_proyecto}</td>
                    <td>${project.descripcion_proyecto.length > 100 ? project.descripcion_proyecto.substring(0, 100) + '...' : project.descripcion_proyecto}</td>
                    <td>${project.horas_requeridas} (Hrs) </td>
                    <td>${project.lugar}</td>
                    <td>${project.seccion?.nombre_seccion || 'No asignada'}</td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-2">
                            <a href="/proyecto/${project.id_proyecto}/detalle" class="btn btn-light btn-sm p-2 px-3">
                                <i class="bi bi-eye text-muted"></i>
                            </a>
                            <a href="/proyecto/${project.id_proyecto}/editar_proyecto" class="btn btn-light btn-sm p-2 px-3">
                                <i class="bi bi-pencil text-warning"></i>
                            </a>
                            <form action="/proyecto/${project.id_proyecto}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-light btn-sm p-2 px-3 delete-button">
                                    <i class="bi bi-trash text-danger"></i>
                                </button>
                            </form>

                        </div>
                    </td>
                </tr>
            `;
            tbody.innerHTML += row;
        });

        renderPagination();
    }

    // Generar controles de paginación
    function renderPagination() {
    const paginationControls = document.getElementById('pagination-buttons');
    const totalPages = Math.ceil(filteredProjects.length / rowsPerPage);

    paginationControls.innerHTML = ''; // Limpiar controles previos

    // Botón "Anterior"
    if (currentPage > 1) {
        const prevButton = `<li class="page-item">
                                <a class="page-link" href="#" onclick="changePage(${currentPage - 1})">Anterior</a>
                            </li>`;
        paginationControls.innerHTML += prevButton;
    }

    // Botones de número de página
    for (let i = 1; i <= totalPages; i++) {
        const isActive = i === currentPage;
        const pageButton = `<li class="page-item ${isActive ? 'active' : ''}">
                                <a class="page-link ${isActive ? 'text-white bg-c' : ''}" 
                                   href="#" 
                                   onclick="changePage(${i})"
                                   style="${isActive ? 'color: white; background-color: red;' : ''}">
                                   ${i}
                                </a>
                            </li>`;
        paginationControls.innerHTML += pageButton;
    }

    // Botón "Siguiente"
    if (currentPage < totalPages) {
        const nextButton = `<li class="page-item">
                                <a class="page-link" href="#" onclick="changePage(${currentPage + 1})">Siguiente</a>
                            </li>`;
        paginationControls.innerHTML += nextButton;
    }
}

    // Cambiar página
    function changePage(page) {
        currentPage = page;
        renderTable();
    }

    //ALERTA DE ELIMINAR DATA
    document.addEventListener('DOMContentLoaded', () => {
        document.addEventListener('click', function (e) {
            if (e.target.closest('.delete-button')) {
                e.preventDefault();
                const form = e.target.closest('form');
                Swal.fire({
                    html: `        <p>¡No podrás revertir esto!</p>
       <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="url(#gradient)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 48px; height: 48px;">
            <defs>
                <linearGradient id="gradient" x1="0" y1="0" x2="1" y2="1">
                    <stop offset="0%" stop-color="#800000" />
                    <stop offset="100%" stop-color="#e91d53" />
                </linearGradient>
            </defs>
            <path d="M3 6h18M9 6v12M15 6v12M19 6v16H5V6z" />
        </svg>
    `,
    title: '¿Estás seguro?',
    showCancelButton: true,
    confirmButtonColor: '#800000',
    cancelButtonColor: '#C7C8CC',
    confirmButtonText: 'Sí, eliminar',
    cancelButtonText: 'Cancelar',
    customClass: {
        popup: 'custom-swal-popup' 
    },
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                        Swal.fire({
                            title: "ELiminado!",
                            text: "El proyecto fue elimando con exito.",
                            icon: "success",
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#800000'
    }); 
                    }
                });
            }
        });
    });
</script>
<style>
    .page-item.active .page-link {
    background: #800000 !important;
    color: white !important;
    border-color: red;
}
.page-link {
    color: #6c757d; 
    text-decoration: none;
}
.page-link:hover {
    color: #495057; 
}
/* Fondo con desenfoque para la alerta */
.custom-swal-popup {
    backdrop-filter: blur(10px); 
    -webkit-backdrop-filter: blur(10px); 
    background: rgba(255, 255, 255, 0.9); 
    border-radius: 10px;
}

.swal2-container {
    backdrop-filter: blur(5px); 
    -webkit-backdrop-filter: blur(5px); 
}


</style>
@endsection
