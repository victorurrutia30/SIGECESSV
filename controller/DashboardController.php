<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php");
    exit;
}

require_once __DIR__ . '/../models/Dashboard.php';
$dashboard = new Dashboard();

$data = [
    'usuarios'                => $dashboard->contarUsuarios(),
    'docentes'                => $dashboard->contarDocentes(),
    'cursos'                  => $dashboard->contarCursos(),
    'inscripciones'           => $dashboard->contarInscripciones(),
    'inscripcionesPorCurso'   => $dashboard->inscripcionesPorCurso(),
    'asignacionesPorCurso'    => $dashboard->asignacionesPorCurso(),
    'asignacionesRecientes'   => $dashboard->asignacionesRecientes(),
    'promedioNotas'           => $dashboard->promedioNotas(),
    'estudiantes'           => $dashboard->contarEstudiantes(),
    'activosUltimaSemana'     => $dashboard->contarActivosUltimaSemana(),
    'pendientesCalificar'     => $dashboard->contarPendientesCalificar(),
    'rolesDist'               => $dashboard->rolesDistribution(),
    'inscripcionesTrend'     => $dashboard->inscripcionesPorFecha(30),
    'cursosInscritos'        => $dashboard->cursosInscritos($_SESSION['usuario']['id']),
    'cursosCompletados'      => $dashboard->cursosCompletados($_SESSION['usuario']['id']),
    'promedioUsuario'     => $dashboard->promedioUsuario($_SESSION['usuario']['id']),
    'pendientesUsuario'   => $dashboard->pendientesUsuario($_SESSION['usuario']['id']),
    'tendenciaPromedio'       => $dashboard->tendenciaPromedioUsuario($_SESSION['usuario']['id'], 'day'),
    'notasCurso'              => $dashboard->notasPorCursoUsuario($_SESSION['usuario']['id']),

];


// Definimos título y cargamos head.php si lo necesitas
$pageTitle = 'Dashboard';
include __DIR__ . '/../views/partials/head.php';

// Finalmente cargamos la vista donde usas $data
include __DIR__ . '/../views/usuarios/dashboard.php';
