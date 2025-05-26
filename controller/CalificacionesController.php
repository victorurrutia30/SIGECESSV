<?php
// SIGECES/controller/CalificacionesController.php

session_start();
// Permitir solo administradores y docentes
if (
    !isset($_SESSION['usuario']) ||
    !in_array($_SESSION['usuario']['rol'], ['admin', 'docente'])
) {
    header("Location: ../index.php");
    exit;
}

require_once __DIR__ . '/../librerias/tcpdf/tcpdf.php';
require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../models/Nota.php';

// 1) Conexión y modelo
$db        = new Conexion();
$conn      = $db->conexion;
$notaModel = new Nota();

// 2) Obtener todas las calificaciones con estudiante y curso
$sqlEntries = "
    SELECT 
        cal.id_usuario,
        cal.id_curso,
        cal.nota,
        u.nombre   AS estudiante,
        c.nombre   AS curso
    FROM calificaciones cal
    JOIN usuarios u ON cal.id_usuario = u.id
    JOIN cursos   c ON cal.id_curso   = c.id
    ORDER BY u.nombre, c.nombre
";
$resEntries = $conn->query($sqlEntries);
$entries    = $resEntries ? $resEntries->fetch_all(MYSQLI_ASSOC) : [];

// 3) Calcular promedio por curso
$sqlAvg = "SELECT id_curso, AVG(nota) AS promedio FROM calificaciones GROUP BY id_curso";
$resAvg = $conn->query($sqlAvg);
$avgMap = [];
if ($resAvg) {
    while ($row = $resAvg->fetch_assoc()) {
        $avgMap[(int)$row['id_curso']] = number_format($row['promedio'], 2);
    }
}

// 4) Configuración de TCPDF
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetCreator('SIGECES');
$pdf->SetAuthor($_SESSION['usuario']['nombre']);
$pdf->SetTitle('Reporte General de Calificaciones');
$pdf->SetMargins(15, 20);
$pdf->SetHeaderMargin(10);
$pdf->SetFooterMargin(10);
$pdf->SetAutoPageBreak(true, 15);
$pdf->AddPage();

// 5) Construir contenido HTML
$html  = '<h2 style="text-align:center;">Reporte General de Calificaciones</h2>';
$html .= '<table border="1" cellpadding="4">
    <thead>
      <tr bgcolor="#eeeeee">
        <th><b>Estudiante</b></th>
        <th><b>Curso</b></th>
        <th><b>Nota Actual</b></th>
        <th><b>Promedio Curso</b></th>
      </tr>
    </thead>
    <tbody>';

foreach ($entries as $e) {
    $prom = $avgMap[(int)$e['id_curso']] ?? 'N/A';
    $html .= '<tr>
        <td>' . htmlspecialchars($e['estudiante']) . '</td>
        <td>' . htmlspecialchars($e['curso']) . '</td>
        <td align="center">' . htmlspecialchars($e['nota']) . '</td>
        <td align="center">' . $prom . '</td>
      </tr>';
}

$html .= '</tbody></table>';

// 6) Escribir HTML y enviar PDF al navegador
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('reporte_general_calificaciones.pdf', 'I');

// 7) Cerrar conexión
$db->cerrarConexion();
