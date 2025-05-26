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

    public function contarEstudiantes()
    {
        $sql    = "SELECT COUNT(*) AS total FROM usuarios WHERE rol = 'estudiante'";
        $result = $this->db->query($sql);
        $fila   = $result->fetch_assoc();
        return (int) $fila['total'];
    }

    public function contarCursos()
    {
        $sql = "SELECT COUNT(*) AS total FROM cursos";
        $result = $this->db->query($sql);
        $fila = $result->fetch_assoc();
        return (int) $fila['total'];
    }

    public function contarActivosUltimaSemana()
    {
        // Fecha y hora de hace 7 días
        $hace7 = date('Y-m-d H:i:s', strtotime('-7 days'));

        // Consulta única con UNION y COUNT DISTINCT
        $sql = "
      SELECT COUNT(DISTINCT id_usuario) AS total FROM (
        SELECT id_usuario, fecha_inscripcion AS fecha 
          FROM inscripciones 
         WHERE fecha_inscripcion >= '$hace7'
        UNION ALL
        SELECT id_usuario, fecha_asignacion AS fecha 
          FROM log_asignaciones 
         WHERE fecha_asignacion >= '$hace7'
      ) AS actividades
    ";
        $res  = $this->db->query($sql);
        $fila = $res->fetch_assoc();
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

    public function contarPendientesCalificar()
    {
        $sql = "
      SELECT COUNT(*) AS total
        FROM inscripciones i
   LEFT JOIN calificaciones c 
          ON i.id_usuario = c.id_usuario
         AND i.id_curso   = c.id_curso
       WHERE c.nota IS NULL
    ";
        $res  = $this->db->query($sql);
        $fila = $res->fetch_assoc();
        return (int) $fila['total'];
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


    public function rolesDistribution()
    {
        $sql = "
      SELECT rol, COUNT(*) AS total
        FROM usuarios
    GROUP BY rol
    ";
        $res  = $this->db->query($sql);
        $rows = $res->fetch_all(MYSQLI_ASSOC);
        // Asegurar que 'total' sea int
        foreach ($rows as &$r) {
            $r['total'] = (int)$r['total'];
        }
        return $rows;
    }

    public function inscripcionesPorFecha($dias = 30)
    {
        // Fecha de hace $dias días
        $desde = date('Y-m-d', strtotime("-{$dias} days"));

        $sql = "
      SELECT 
        DATE(fecha_inscripcion) AS fecha,
        COUNT(*)           AS total
      FROM inscripciones
     WHERE fecha_inscripcion >= '$desde'
  GROUP BY DATE(fecha_inscripcion)
  ORDER BY DATE(fecha_inscripcion) ASC
    ";
        $res  = $this->db->query($sql);
        $rows = $res->fetch_all(MYSQLI_ASSOC);
        // Asegurarnos de que total sea int
        foreach ($rows as &$r) {
            $r['total'] = (int)$r['total'];
        }
        return $rows;
    }
}
