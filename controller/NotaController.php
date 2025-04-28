<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

require_once '../models/Nota.php';
$notaModel = new Nota();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar_nota'])) {
    $id_usuario = $_POST['id_usuario'];
    $id_curso   = $_POST['id_curso'];
    $nota       = $_POST['nota'];

    if ($notaModel->guardarNota($id_usuario, $id_curso, $nota)) {
        header("Location: ../views/notas/index.php?msg=ok");
    } else {
        header("Location: ../views/notas/index.php?msg=error");
    }
    exit;
}
