<?php
// SIGECES/controller/UsuariosRolController.php

session_start();
// Solo administradores
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

require_once __DIR__ . '/../librerias/tcpdf/tcpdf.php';
require_once __DIR__ . '/../models/Usuario.php';

// Instanciar modelo y obtener usuarios
$usuarioModel = new Usuario();
$usuarios     = $usuarioModel->obtenerTodos();

// Agrupar usuarios por rol
$grouped = [
    'admin'      => [],
    'docente'    => [],
    'estudiante' => [],
];
foreach ($usuarios as $u) {
    $rol = $u['rol'];
    if (!isset($grouped[$rol])) {
        $grouped[$rol] = [];
    }
    $grouped[$rol][] = $u;
}

// Etiquetas legibles de roles
$roleNames = [
    'admin'      => 'Administradores',
    'docente'    => 'Docentes',
    'estudiante' => 'Estudiantes',
];

// Configuración de TCPDF
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetCreator('SIGECES');
$pdf->SetAuthor($_SESSION['usuario']['nombre']);
$pdf->SetTitle('Usuarios por Rol');
$pdf->SetMargins(15, 20);
$pdf->SetHeaderMargin(10);
$pdf->SetFooterMargin(10);
$pdf->SetAutoPageBreak(true, 15);
$pdf->AddPage();

// Construir contenido HTML
$html  = '<h2 style="text-align:center;">Usuarios por Rol</h2>';
foreach ($grouped as $rol => $lista) {
    $titulo = isset($roleNames[$rol]) ? $roleNames[$rol] : ucfirst($rol);
    $html .= '<h3>' . $titulo . '</h3>';
    $html .= '<table border="1" cellpadding="4" width="100%">
                <thead>
                  <tr bgcolor="#eeeeee">
                    <th><b>ID</b></th>
                    <th><b>Nombre</b></th>
                    <th><b>Correo</b></th>
                  </tr>
                </thead>
                <tbody>';
    foreach ($lista as $u) {
        $html .= '<tr>
                    <td align="center">' . $u['id'] . '</td>
                    <td>' . htmlspecialchars($u['nombre']) . '</td>
                    <td>' . htmlspecialchars($u['email']) . '</td>
                  </tr>';
    }
    $html .= '</tbody></table><br />';
}

// Escribir HTML en el PDF y enviarlo al navegador
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('usuarios_por_rol.pdf', 'I');
