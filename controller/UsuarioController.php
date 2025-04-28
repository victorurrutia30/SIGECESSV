<?php
session_start();
require_once '../models/Usuario.php';

$usuario = new Usuario();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['registro'])) {
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $registroExitoso = $usuario->registrar($nombre, $email, $password);
        header("Location: ../views/usuarios/register.php?msg=" . ($registroExitoso ? "ok" : "error"));
        exit;
    }

    if (isset($_POST['login'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $datos = $usuario->login($email, $password);

        if ($datos) {
            $_SESSION['usuario'] = $datos;
            header("Location: ../controller/DashboardController.php");
        } else {
            header("Location: ../views/usuarios/login.php?msg=error");
        }
        exit;
    }
}
