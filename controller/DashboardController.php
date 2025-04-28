<?php
require_once __DIR__ . '/../../models/Dashboard.php'; // Ajusta ruta si es necesario

$dashboard = new Dashboard();

$data = [
    'usuarios' => $dashboard->contarUsuarios(),
    'docentes' => $dashboard->contarDocentes(),
    'cursos' => $dashboard->contarCursos(),
    'inscripciones' => $dashboard->contarInscripciones(),
];
