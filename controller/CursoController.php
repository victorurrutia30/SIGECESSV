<?php
session_start();
if (!isset($_SESSION['usuario']) || ($_SESSION['usuario']['rol'] != 'admin' && $_SESSION['usuario']['rol'] != 'docente')) {
    header("Location: ../index.php");
    exit;
}

require_once '../models/Curso.php';
$curso = new Curso();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['agregar'])) {
        $nombre = $_POST['nombre'];
        $curso->agregarCurso($nombre);
        header("Location: ../views/cursos/index.php?msg=agregado");
    }

    if (isset($_POST['editar'])) {
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $curso->editarCurso($id, $nombre);
        header("Location: ../views/cursos/index.php?msg=editado");
    }

    if (isset($_POST['eliminar'])) {
        $id = $_POST['id'];
        $curso->eliminarCurso($id);
        header("Location: ../views/cursos/index.php?msg=eliminado");
    }
}
