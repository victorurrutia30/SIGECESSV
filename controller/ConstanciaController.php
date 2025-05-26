<?php
// SIGECES/controller/ConstanciaController.php

session_start();
// Solo estudiantes pueden acceder
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'estudiante') {
    header("Location: ../index.php");
    exit;
}

// Dependencias
require_once __DIR__ . '/../librerias/tcpdf/tcpdf.php';
require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../models/Asignacion.php';
require_once __DIR__ . '/../models/Inscripcion.php';
require_once __DIR__ . '/../models/Nota.php';

// Instancias
$db          = new Conexion();
$conn        = $db->conexion;
$asignModel  = new Asignacion();
$insModel    = new Inscripcion();
$notaModel   = new Nota();

// Datos del estudiante
$id_usuario      = (int) $_SESSION['usuario']['id'];
$nombre_usuario  = $_SESSION['usuario']['nombre'];
$email_usuario   = $_SESSION['usuario']['email'] ?? '';

// Obtener cursos (admin + auto-inscripción)
$adminCursos = $asignModel->cursosAsignados($id_usuario);
$selfIns     = $insModel->listarPorUsuario($id_usuario);

$courses = [];
foreach ($adminCursos as $c) {
    $courses[$c['id']] = [
        'id'     => $c['id'],
        'nombre' => $c['nombre']
    ];
}
foreach ($selfIns as $i) {
    if (!isset($courses[$i['id_curso']])) {
        $courses[$i['id_curso']] = [
            'id'     => $i['id_curso'],
            'nombre' => $i['nombre']
        ];
    }
}

// Configurar TCPDF
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetCreator('SIGECES');
$pdf->SetAuthor($nombre_usuario);
$pdf->SetTitle('Constancia de Estudio');
$pdf->SetMargins(15, 20);
$pdf->SetHeaderMargin(10);
$pdf->SetFooterMargin(10);
$pdf->SetAutoPageBreak(true, 15);
$pdf->AddPage();

// Construir HTML de la constancia
$html  = '<h2 style="text-align:center;">Constancia de Estudio</h2>';
$html .= '<p><strong>Estudiante:</strong> ' . htmlspecialchars($nombre_usuario) . ' (ID: ' . $id_usuario . ')</p>';
if ($email_usuario) {
    $html .= '<p><strong>Email:</strong> ' . htmlspecialchars($email_usuario) . '</p>';
}
$html .= '<p><strong>Fecha de emisión:</strong> ' . date('d/m/Y') . '</p>';
$html .= '<hr>';
$html .= '<h3>Cursos Actuales Inscritos</h3>';
$html .= '<table border="1" cellpadding="4">
            <thead>
              <tr bgcolor="#eeeeee">
                <th><b>Curso</b></th>
                <th><b>Nota</b></th>
              </tr>
            </thead>
            <tbody>';

foreach ($courses as $c) {
    $nota = $notaModel->obtenerNota($id_usuario, $c['id']);
    $notaTexto = ($nota !== null) ? number_format($nota, 2) : 'Sin nota';
    $html .= '<tr>
                <td>' . htmlspecialchars($c['nombre']) . '</td>
                <td align="center">' . $notaTexto . '</td>
              </tr>';
}

$html .= '  </tbody>
          </table>';

// Escribir HTML en el PDF y enviar al navegador
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('constancia_' . $id_usuario . '.pdf', 'I');

// Cerrar conexión
$db->cerrarConexion();
