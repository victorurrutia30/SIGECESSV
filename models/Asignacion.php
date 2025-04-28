<?php
require_once(__DIR__ . '/../config/conexion.php');

class Asignacion
{
    private $db;

    public function __construct()
    {
        $conexion = new Conexion();
        $this->db = $conexion->conexion;
    }

    public function obtenerUsuarios()
    {
        return $this->db->query("SELECT * FROM usuarios ORDER BY nombre");
    }

    public function obtenerCursos()
    {
        return $this->db->query("SELECT * FROM cursos ORDER BY nombre");
    }

    public function cursosAsignados($id_usuario)
    {
        $query = "SELECT cursos.* FROM cursos
                  JOIN cursos_usuarios ON cursos.id = cursos_usuarios.id_curso
                  WHERE cursos_usuarios.id_usuario = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function asignarCursos($id_usuario, $ids_cursos)
    {
        foreach ($ids_cursos as $id_curso) {
            $query = "INSERT IGNORE INTO cursos_usuarios (id_usuario, id_curso) VALUES (?, ?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("ii", $id_usuario, $id_curso);
            $stmt->execute();
        }
    }

    public function eliminarAsignacion($id_usuario, $id_curso)
    {
        $query = "DELETE FROM cursos_usuarios WHERE id_usuario = ? AND id_curso = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ii", $id_usuario, $id_curso);
        return $stmt->execute();
    }

    public function contarAsignacionesPorCurso($id_curso)
    {
        $query = "SELECT COUNT(*) AS total FROM cursos_usuarios WHERE id_curso = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id_curso);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['total'];
    }
}
