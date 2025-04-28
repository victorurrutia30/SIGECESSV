<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../../index.php");
    exit;
}

require_once '../../models/Asignacion.php';
$asignacion = new Asignacion();
$id_usuario = $_SESSION['usuario']['id'];
$cursos = $asignacion->cursosAsignados($id_usuario);

include '../partials/head.php';
include '../partials/navbar.php';
?>

<div class="mis-cursos-section container my-5">
    <h2 class="mis-cursos-title text-center mb-4">Mis Cursos Asignados</h2>

    <?php if ($cursos->num_rows === 0): ?>
        <div class="alert alert-info text-center">No tienes cursos asignados aún.</div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-mis-cursos text-center align-middle">
                <thead class="table-head">
                    <tr>
                        <th>ID Curso</th>
                        <th>Nombre del Curso</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cursos as $curso): ?>
                        <tr>
                            <td><?= $curso['id'] ?></td>
                            <td><?= $curso['nombre'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>


<?php include '../partials/footer.php'; ?>