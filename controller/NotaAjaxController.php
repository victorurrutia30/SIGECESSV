<?php
require_once '../models/Asignacion.php';
require_once '../models/Nota.php';

$asignacion = new Asignacion();
$notaModel = new Nota();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_usuario = $_POST['id_usuario'] ?? null;

    if ($id_usuario) {
        $cursos = $asignacion->cursosAsignados($id_usuario);
        $data = [];

        foreach ($cursos as $c) {
            $nota = $notaModel->obtenerNota($id_usuario, $c['id']);
            $data[] = [
                'id' => $c['id'],
                'nombre' => $c['nombre'],
                'nota' => $nota
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($data);
    }
}
