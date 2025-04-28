<?php
require_once __DIR__ . '/../config/conexion.php';

class Nota
{
    private $db;

    public function __construct()
    {
        $this->db = (new Conexion())->conexion;
    }

    // Obtener nota de un usuario para un curso específico
    public function obtenerNota($id_usuario, $id_curso)
    {
        $sql = "SELECT nota FROM calificaciones WHERE id_usuario = ? AND id_curso = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ii", $id_usuario, $id_curso);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        return $res['nota'] ?? null;
    }

    // Asignar o actualizar nota
    public function guardarNota($id_usuario, $id_curso, $nota)
    {
        if (!is_numeric($nota) || $nota < 0 || $nota > 10) return false;

        $sql = "INSERT INTO calificaciones (id_usuario, id_curso, nota)
                VALUES (?, ?, ?)
                ON DUPLICATE KEY UPDATE nota = VALUES(nota)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("iid", $id_usuario, $id_curso, $nota);
        return $stmt->execute();
    }
}
