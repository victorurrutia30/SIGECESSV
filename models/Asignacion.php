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
        $res = $this->db->query("SELECT * FROM usuarios ORDER BY nombre");
        return $res->fetch_all(MYSQLI_ASSOC);
    }

    public function obtenerCursos()
    {
        $res = $this->db->query("SELECT * FROM cursos ORDER BY nombre");
        return $res->fetch_all(MYSQLI_ASSOC);
    }

    public function cursosAsignados($id_usuario)
    {
        $query = "SELECT c.* 
                    FROM cursos c
                    JOIN cursos_usuarios cu ON c.id = cu.id_curso
                   WHERE cu.id_usuario = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res->fetch_all(MYSQLI_ASSOC);
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


    // Loguear cada acción
    public function logAccion($id_usuario, $id_curso, $actor_id, $accion)
    {
        // Verificar si ya existe un registro exactamente igual en los últimos 2 segundos (previene reenvíos rápidos)
        $sql = "SELECT COUNT(*) AS total FROM log_asignaciones
                WHERE id_usuario = ? AND id_curso = ? AND accion = ? AND actor_id = ?
                  AND fecha_asignacion >= NOW() - INTERVAL 2 SECOND";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("iisi", $id_usuario, $id_curso, $accion, $actor_id);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();

        if ($res['total'] == 0) {
            $insert = $this->db->prepare("INSERT INTO log_asignaciones (id_usuario, id_curso, accion, actor_id)
                                          VALUES (?, ?, ?, ?)");
            $insert->bind_param("iisi", $id_usuario, $id_curso, $accion, $actor_id);
            $insert->execute();
        }
    }

    // Obtener histórico de un usuario
    public function obtenerLog($id_usuario)
    {
        $sql = "SELECT la.*, u.nombre AS actor_nombre, c.nombre AS curso_nombre
            FROM log_asignaciones la
            JOIN usuarios u  ON la.actor_id  = u.id
            JOIN cursos   c  ON la.id_curso  = c.id
           WHERE la.id_usuario = ?
           ORDER BY la.fecha_asignacion DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        return $stmt->get_result();
    }

    //obtener estudiantes con cursos 
    public function estudiantesConCursos()
    {
        $query = "SELECT DISTINCT u.id, u.nombre, u.rol
                  FROM usuarios u
                  JOIN cursos_usuarios cu ON u.id = cu.id_usuario
                  WHERE u.rol = 'estudiante'";
        $res = $this->db->query($query);
        return $res->fetch_all(MYSQLI_ASSOC);
    }
}
