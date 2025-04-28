<?php
require_once '../config/conexion.php';

class Usuario
{
    private $db;

    public function __construct()
    {
        $conexion = new Conexion();
        $this->db = $conexion->conexion;
    }

    public function registrar($nombre, $email, $password)
    {
        $query = "SELECT * FROM usuarios WHERE email = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) return false;

        $hashed_password = md5($password);
        $rol = 'estudiante';
        $query = "INSERT INTO usuarios (nombre, email, password, rol) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ssss", $nombre, $email, $hashed_password, $rol);
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
}
