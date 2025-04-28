<?php
require_once __DIR__ . '/../config/conexion.php';

class Usuario
{
    private $db;

    public function __construct()
    {
        $conexion = new Conexion();
        $this->db = $conexion->conexion;
    }

    public function registrar($nombre, $email, $password, $rol = 'estudiante')
    {
        $query = "SELECT * FROM usuarios WHERE email = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) return false;

        $hashed_password = md5($password); // Ya viene MD5 desde el controller, podrías omitir aquí
        $query = "INSERT INTO usuarios (nombre, email, password, rol) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ssss", $nombre, $email, $password, $rol);
        return $stmt->execute();
    }


    public function login($email, $password)
    {
        $hashed_password = md5($password);
        $query = "SELECT * FROM usuarios WHERE email = ? AND password = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ss", $email, $hashed_password);
        $stmt->execute();
        $result = $stmt->get_result();
        return ($result->num_rows === 1) ? $result->fetch_assoc() : false;
    }

    public function obtenerTodos()
    {
        $res = $this->db->query("SELECT * FROM usuarios ORDER BY nombre");
        return $res->fetch_all(MYSQLI_ASSOC);
    }

    public function actualizar($id, $nombre, $email, $rol)
    {
        $query = "UPDATE usuarios SET nombre = ?, email = ?, rol = ? WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("sssi", $nombre, $email, $rol, $id);
        return $stmt->execute();
    }

    public function eliminar($id)
    {
        $query = "DELETE FROM usuarios WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
