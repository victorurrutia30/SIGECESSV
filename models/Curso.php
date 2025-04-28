<?php
require_once(__DIR__ . '/../config/conexion.php');


class Curso
{
    private $db;

    public function __construct()
    {
        $conexion = new Conexion();
        $this->db = $conexion->conexion;
    }

    public function obtenerCursos()
    {
        $query = "SELECT * FROM cursos ORDER BY id DESC";
        return $this->db->query($query);
    }

    public function agregarCurso($nombre)
    {
        $query = "INSERT INTO cursos (nombre) VALUES (?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $nombre);
        return $stmt->execute();
    }

    public function editarCurso($id, $nombre)
    {
        $query = "UPDATE cursos SET nombre=? WHERE id=?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("si", $nombre, $id);
        return $stmt->execute();
    }

    public function eliminarCurso($id)
    {
        $query = "DELETE FROM cursos WHERE id=?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
