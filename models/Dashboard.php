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

    /**
     * PARA ESTUDIANTES 
     */

    public function cursosInscritos($id_usuario)
    {
        $sql = "
        SELECT COUNT(*) AS total
FROM cursos_usuarios
WHERE id_usuario = ?;
    ";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        return (int) $res['total'];
    }

    /**
     * Número de cursos donde el estudiante ya tiene nota
     */
    public function cursosCompletados($id_usuario)
    {
        $sql = "
        SELECT COUNT(*) AS total
          FROM calificaciones
         WHERE id_usuario = ?
           AND nota IS NOT NULL
    ";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        return (int) $res['total'];
    }

    /**
     * Promedio de notas de un usuario específico
     */
    public function promedioUsuario($id_usuario)
    {
        $sql = "
        SELECT AVG(nota) AS promedio
          FROM calificaciones
         WHERE id_usuario = ?
           AND nota IS NOT NULL
    ";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        return $res['promedio'] !== null
            ? round((float)$res['promedio'], 2)
            : 0.00;
    }

    /**
     * Cursos en los que está inscrito (por inscripción o asignación)
     * pero aún no tiene nota.
     */
    public function pendientesUsuario($id_usuario)
    {
        $sql = "
        SELECT COUNT(*) AS total
          FROM (
              SELECT cu.id_curso
                FROM cursos_usuarios cu
               WHERE cu.id_usuario = ?
              UNION
              SELECT i.id_curso
                FROM inscripciones i
               WHERE i.id_usuario = ?
          ) AS cursos_totales
    LEFT JOIN calificaciones c
           ON cursos_totales.id_curso = c.id_curso
          AND c.id_usuario = ?
         WHERE c.nota IS NULL
    ";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("iii", $id_usuario, $id_usuario, $id_usuario);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        return (int) $res['total'];
    }

    /**
     * Evolución acumulada del promedio del usuario,
     * agrupada por día o semana usando las fechas correctas.
     */
    public function tendenciaPromedioUsuario($id_usuario, $periodo = 'day')
    {
        if ($periodo === 'week') {
            // Agrupación semanal (ISO week), acumulado
            $sql = "
            SELECT 
              STR_TO_DATE(CONCAT(t.yw, ' Monday'), '%X%V %W') AS fecha,
              (
                SELECT ROUND(AVG(nota), 2)
                  FROM calificaciones
                 WHERE id_usuario = ?
                   AND nota IS NOT NULL
                   AND YEARWEEK(fecha_actualizacion,1) <= t.yw
              ) AS promedio
            FROM (
                SELECT DISTINCT YEARWEEK(fecha_actualizacion,1) AS yw
                  FROM calificaciones
                 WHERE id_usuario = ?
                   AND nota IS NOT NULL
            ) AS t
            ORDER BY t.yw ASC
        ";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("ii", $id_usuario, $id_usuario);
        } else {
            // Agrupación diaria, acumulado
            $sql = "
            SELECT 
              t.fecha,
              (
                SELECT ROUND(AVG(nota), 2)
                  FROM calificaciones
                 WHERE id_usuario = ?
                   AND nota IS NOT NULL
                   AND DATE(fecha_actualizacion) <= t.fecha
              ) AS promedio
            FROM (
                SELECT DISTINCT DATE(fecha_actualizacion) AS fecha
                  FROM calificaciones
                 WHERE id_usuario = ?
                   AND nota IS NOT NULL
            ) AS t
            ORDER BY t.fecha ASC
        ";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("ii", $id_usuario, $id_usuario);
        }

        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Devuelve las notas de cada curso para un usuario específico
     */
    public function notasPorCursoUsuario($id_usuario)
    {
        $sql = "
        SELECT c.nombre, n.nota
          FROM calificaciones n
    INNER JOIN cursos c
            ON n.id_curso = c.id
         WHERE n.id_usuario = ?
    ";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
