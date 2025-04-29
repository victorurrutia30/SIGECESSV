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
    public function inscripcionesPorCurso()
    {
        $sql = "
          SELECT c.id, c.nombre AS curso, COUNT(i.id_usuario) AS total
          FROM cursos c
          LEFT JOIN inscripciones i ON c.id = i.id_curso
          GROUP BY c.id, c.nombre
          ORDER BY total DESC
        ";
        $res  = $this->db->query($sql);
        $rows = $res->fetch_all(MYSQLI_ASSOC);
        foreach ($rows as &$r) {
            $r['total'] = (int)$r['total'];
        }
        return $rows;
    }

    // Devuelve número de asignaciones (tabla cursos_usuarios) por curso
    public function asignacionesPorCurso()
    {
        $sql = "
          SELECT c.id, c.nombre AS curso, COUNT(cu.id_usuario) AS total
          FROM cursos c
          LEFT JOIN cursos_usuarios cu ON c.id = cu.id_curso
          GROUP BY c.id, c.nombre
          ORDER BY total DESC
        ";
        $res  = $this->db->query($sql);
        $rows = $res->fetch_all(MYSQLI_ASSOC);
        foreach ($rows as &$r) {
            $r['total'] = (int)$r['total'];
        }
        return $rows;
    }

    // Últimas 5 acciones de asignación de cursos
    public function asignacionesRecientes($limit = 5)
    {
        $sql = "
          SELECT la.*, u1.nombre AS estudiante, u2.nombre AS actor, c.nombre AS curso
            FROM log_asignaciones la
            JOIN usuarios u1 ON la.id_usuario = u1.id
            JOIN usuarios u2 ON la.actor_id  = u2.id
            JOIN cursos   c  ON la.id_curso  = c.id
           WHERE la.accion = 'asignacion'
           ORDER BY la.fecha_asignacion DESC
           LIMIT ?
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Promedio global de todas las notas asignadas
    public function promedioNotas()
    {
        $sql = "SELECT AVG(nota) AS promedio FROM calificaciones";
        $res = $this->db->query($sql);
        $row = $res->fetch_assoc();
        return round((float)$row['promedio'], 2);
    }
}
