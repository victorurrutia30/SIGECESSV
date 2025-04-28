<?php
session_start();
if (!isset($_SESSION['usuario']) || ($_SESSION['usuario']['rol'] != 'admin' && $_SESSION['usuario']['rol'] != 'docente')) {
    header("Location: ../index.php");
    exit;
}

require_once '../models/Asignacion.php';
$asignacion = new Asignacion();



// ── NUEVO: inscripción del estudiante ─────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['inscribir'])) {
    $id_usuario = $_SESSION['usuario']['id'];
    $id_curso   = $_POST['id_curso'];
    $asignacion->asignarCursos($id_usuario, [$id_curso]);
    // ── Log self‐enroll ──
    $asignacion->logAccion($id_usuario, $id_curso, $id_usuario, 'asignacion');
    header("Location: ../views/usuarios/mis_cursos.php?msg=inscrito");
    exit;
}
// ────────────────────────────────────────────────────────────────

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['asignar'])) {
    $id_usuario = $_POST['id_usuario'];
    $ids_cursos = $_POST['cursos'] ?? [];
    $asignacion->asignarCursos($id_usuario, $ids_cursos);
    // ── Log admin assign ──
    foreach ($ids_cursos as $id_curso) {
        $asignacion->logAccion($id_usuario, $id_curso, $_SESSION['usuario']['id'], 'asignacion');
    }
    header("Location: ../views/asignaciones/index.php?msg=ok");
    exit;
}
if (isset($_POST['eliminar_asignacion'])) {
    $id_usuario = $_POST['id_usuario'];
    $id_curso   = $_POST['id_curso'];
    $asignacion->eliminarAsignacion($id_usuario, $id_curso);
    // ── Log any removal (self‐unenroll or admin remove) ──
    $asignacion->logAccion($id_usuario, $id_curso, $_SESSION['usuario']['id'], 'eliminacion');
    header("Location: ../views/asignaciones/index.php?msg=eliminado");
    exit;
}
