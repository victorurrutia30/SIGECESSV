<?php
// SIGECES/controller/HistorialAsignacionesController.php

session_start();
// Sólo administradores y estudiantes
if (
    !isset($_SESSION['usuario']) ||
    !in_array($_SESSION['usuario']['rol'], ['admin', 'estudiante'])
) {
    header("Location: ../index.php");
    exit;
}

require_once __DIR__ . '/../librerias/tcpdf/tcpdf.php';
require_once __DIR__ . '/../config/conexion.php';

// 1) Conexión a la base de datos
$db   = new Conexion();
$conn = $db->conexion;

// 2) Si es estudiante, limitar al propio historial
$where = '';
if ($_SESSION['usuario']['rol'] === 'estudiante') {
    $userId = (int) $_SESSION['usuario']['id'];
    $where  = "WHERE la.id_usuario = {$userId}";
}

// 3) Consulta usando las columnas reales:
//    - usuarios.id y usuarios.nombre
//    - log_asignaciones.fecha_asignacion
$sql = "
    SELECT
        u.nombre              AS estudiante,
        c.nombre              AS curso,
        la.accion             AS accion,
        actor.nombre          AS actor,
        la.fecha_asignacion   AS fecha
    FROM log_asignaciones la
    JOIN usuarios u      ON la.id_usuario = u.id
    JOIN cursos c        ON la.id_curso   = c.id
    JOIN usuarios actor  ON la.actor_id   = actor.id
    {$where}
    ORDER BY la.fecha_asignacion DESC
";

$result = $conn->query($sql);
$rows   = $result
    ? $result->fetch_all(MYSQLI_ASSOC)
    : [];

// 4) Configuración de TCPDF
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetCreator('SIGECES');
$pdf->SetAuthor($_SESSION['usuario']['nombre']);
$pdf->SetTitle('Historial de Asignaciones por Estudiante');
$pdf->SetMargins(15, 20);
$pdf->SetHeaderMargin(10);
$pdf->SetFooterMargin(10);
$pdf->SetAutoPageBreak(true, 15);
$pdf->AddPage();

// 5) Generar contenido HTML
$html  = '<h2 style="text-align:center;">Historial de Asignaciones por Estudiante</h2>';
$html .= '<table border="1" cellpadding="4">
    <thead>
      <tr bgcolor="#eeeeee">
        <th><b>Estudiante</b></th>
        <th><b>Curso</b></th>
        <th><b>Acción</b></th>
        <th><b>Actor</b></th>
        <th><b>Fecha</b></th>
      </tr>
    </thead>
    <tbody>';
foreach ($rows as $r) {
    $html .= '<tr>
        <td>' . htmlspecialchars($r['estudiante']) . '</td>
        <td>' . htmlspecialchars($r['curso'])      . '</td>
        <td>' . htmlspecialchars(ucfirst($r['accion'])) . '</td>
        <td>' . htmlspecialchars($r['actor'])      . '</td>
        <td>' . htmlspecialchars($r['fecha'])      . '</td>
      </tr>';
}
$html .= '</tbody></table>';

// 6) Escribir HTML en el PDF y enviarlo al navegador
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('historial_asignaciones.pdf', 'I');

// 7) Cerrar conexión
$db->cerrarConexion();
