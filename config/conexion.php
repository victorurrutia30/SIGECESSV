<?php
class Conexion
{
    private $host = "localhost";
    private $usuario = "root";
    private $password = "";
    private $base_datos = "sigeces";
    private $port = "3307";
    public $conexion;

    public function __construct()
    {
        $this->conexion = new mysqli($this->host, $this->usuario, $this->password, $this->base_datos, $this->port);

        if ($this->conexion->connect_error) {
            die("Error de conexión: " . $this->conexion->connect_error);
        }
    }

    public function cerrarConexion()
    {
        $this->conexion->close();
    }
}
