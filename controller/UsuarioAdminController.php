<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

require_once '../models/Usuario.php';
$usuario = new Usuario();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['agregar'])) {
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $password = md5($_POST['password']);
        $rol = $_POST['rol'];
        $usuario->registrar($nombre, $email, $password, $rol); // Modifica el registrar si es necesario
    }

    if (isset($_POST['editar'])) {
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $rol = $_POST['rol'];
        $usuario->actualizar($id, $nombre, $email, $rol);
    }

    if (isset($_POST['eliminar'])) {
        $usuario->eliminar($_POST['id']);
    }

    header("Location: ../views/usuarios/admin_index.php?msg=ok");
    exit;
}
