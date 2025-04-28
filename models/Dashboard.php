<?php
require_once __DIR__ . '/../config/conexion.php';

class Dashboard
{
    private $db;

    public function __construct()
    {
        $this->db = (new Conexion())->conexion;
    }

    public function contarUsuarios()
    {
        $sql = "SELECT COUNT(*) AS total FROM usuarios";
        $result = $this->db->query($sql);
        $fila = $result->fetch_assoc();
        return (int) $fila['total'];
    }

    public function contarDocentes()
    {
        $sql = "SELECT COUNT(*) AS total FROM usuarios WHERE rol = 'admin'";
        $result = $this->db->query($sql);
        $fila = $result->fetch_assoc();
        return (int) $fila['total'];
    }

    public function contarCursos()
    {
        $sql = "SELECT COUNT(*) AS total FROM cursos";
        $result = $this->db->query($sql);
        $fila = $result->fetch_assoc();
        return (int) $fila['total'];
    }

    public function contarInscripciones()
    {
        $sql = "SELECT COUNT(*) AS total FROM inscripciones";
        $result = $this->db->query($sql);
        $fila = $result->fetch_assoc();
        return (int) $fila['total'];
    }
}
