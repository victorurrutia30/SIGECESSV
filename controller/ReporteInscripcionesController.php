<?php


session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'admin') {
  header("Location: ../index.php");
  exit;
}

require_once __DIR__ . '/../librerias/tcpdf/tcpdf.php';
require_once __DIR__ . '/../config/conexion.php';

// Conectar a la base de datos
$db   = new Conexion();
$conn = $db->conexion;

// Obtener datos de cursos
$queryCursos = "SELECT id, nombre FROM cursos";
$resCursos   = $conn->query($queryCursos);
$cursos      = $resCursos ? $resCursos->fetch_all(MYSQLI_ASSOC) : [];

$data = [];
foreach ($cursos as $c) {
  $id = (int)$c['id'];

  // Cantidad de inscritos
  $resTotal  = $conn->query(
    "SELECT COUNT(*) AS total 
         FROM inscripciones 
         WHERE id_curso = $id"
  );
  $filaTotal = $resTotal->fetch_assoc();
  $total     = isset($filaTotal['total']) ? (int)$filaTotal['total'] : 0;

  // Fecha última inscripción
  $resUlt   = $conn->query(
    "SELECT MAX(fecha_inscripcion) AS ultima 
         FROM inscripciones 
         WHERE id_curso = $id"
  );
  $filaUlt  = $resUlt->fetch_assoc();
  $fechaUlt = !empty($filaUlt['ultima']) ? $filaUlt['ultima'] : 'N/A';

  $data[] = [
    'curso'     => $c['nombre'],
    'inscritos' => $total,
    'fecha_ult' => $fechaUlt,
  ];
}

// Configuración del PDF
$pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetCreator('SIGECES');
$pdf->SetAuthor($_SESSION['usuario']['nombre']);
$pdf->SetTitle('Reporte de Inscripciones por Curso');
$pdf->SetMargins(15, 20);
$pdf->SetHeaderMargin(10);
$pdf->SetFooterMargin(10);
$pdf->SetAutoPageBreak(true, 15);
$pdf->AddPage();

// Contenido HTML
$html  = '<h2 style="text-align:center;">Reporte de Inscripciones por Curso</h2>';
$html .= '<table border="1" cellpadding="4">
    <thead>
      <tr bgcolor="#eeeeee">
        <th><b>Curso</b></th>
        <th><b>Inscritos</b></th>
        <th><b>Última Inscripción</b></th>
      </tr>
    </thead>
    <tbody>';
foreach ($data as $row) {
  $html .= '<tr>
      <td>' . htmlspecialchars($row['curso']) . '</td>
      <td align="center">' . $row['inscritos'] . '</td>
      <td>' . $row['fecha_ult'] . '</td>
    </tr>';
}
$html .= '</tbody></table>';

// Escribir HTML en el PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Salida del PDF al navegador
$pdf->Output('reporte_inscripciones.pdf', 'I');

// Cerrar conexión
$db->cerrarConexion();
