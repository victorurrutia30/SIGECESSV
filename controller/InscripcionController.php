<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'estudiante') {
    header("Location: ../index.php");
    exit;
}

require_once '../models/Inscripcion.php';
$ins = new Inscripcion();

$id_usuario = $_SESSION['usuario']['id'];
$id_curso   = $_POST['id_curso'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['inscribir'])) {
    // Validar cupos
    if ($ins->cuposDisponibles($id_curso)) {
        $ins->inscribir($id_usuario, $id_curso);
        header("Location: ../views/inscripciones/index.php?msg=ok");
    } else {
        header("Location: ../views/inscripciones/index.php?msg=full");
    }
    exit;
}

if (isset($_POST['anular'])) {
    $ins->anular($id_usuario, $id_curso);
    header("Location: ../views/inscripciones/mis_inscripciones.php?msg=anulado");
    exit;
}
