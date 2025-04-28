<?php
session_start();
if (!isset($_SESSION['usuario']) || ($_SESSION['usuario']['rol'] != 'admin' && $_SESSION['usuario']['rol'] != 'docente')) {
    header("Location: ../index.php");
    exit;
}

require_once '../models/Asignacion.php';
$asignacion = new Asignacion();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['asignar'])) {
    $id_usuario = $_POST['id_usuario'];
    $ids_cursos = $_POST['cursos'] ?? [];
    $asignacion->asignarCursos($id_usuario, $ids_cursos);
    header("Location: ../views/asignaciones/index.php?msg=ok");
    exit;
}

if (isset($_POST['eliminar_asignacion'])) {
    $id_usuario = $_POST['id_usuario'];
    $id_curso = $_POST['id_curso'];
    $asignacion->eliminarAsignacion($id_usuario, $id_curso);
    header("Location: ../views/asignaciones/index.php?msg=eliminado");
    exit;
}
