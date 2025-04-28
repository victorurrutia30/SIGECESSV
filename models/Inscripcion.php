<?php
require_once __DIR__ . '/../config/conexion.php';

class Inscripcion
{
    private $db;

    public function __construct()
    {
        $this->db = (new Conexion())->conexion;
    }

    // Para que un estudiante se inscriba
    public function inscribir($id_usuario, $id_curso)
    {
        $sql = "INSERT IGNORE INTO inscripciones (id_usuario, id_curso) VALUES (?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ii", $id_usuario, $id_curso);
        return $stmt->execute();
    }

    // Anular inscripción
    public function anular($id_usuario, $id_curso)
    {
        $sql = "DELETE FROM inscripciones WHERE id_usuario = ? AND id_curso = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ii", $id_usuario, $id_curso);
        return $stmt->execute();
    }

    // Listar inscripciones de un usuario
    public function listarPorUsuario($id_usuario)
    {
        $sql = "SELECT i.*, c.nombre 
                  FROM inscripciones i
                  JOIN cursos c ON i.id_curso = c.id
                 WHERE i.id_usuario = ?
                 ORDER BY i.fecha_inscripcion DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Verificar cupos disponibles (simulado)
    public function cuposDisponibles($id_curso, $cupo_max = 30)
    {
        $sql = "SELECT COUNT(*) AS inscritos FROM inscripciones WHERE id_curso = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id_curso);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        return ($res['inscritos'] < $cupo_max);
    }

    public function contarInscripcionesPorCurso($id_curso)
    {
        $sql = "SELECT COUNT(*) AS total FROM inscripciones WHERE id_curso = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id_curso);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        return $res['total'];
    }
}
