<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../../index.php");
    exit;
}
require_once '../../models/Curso.php';
require_once '../../models/Asignacion.php';

$curso = new Curso();
$cursos = $curso->obtenerCursos();

$asignacionObj = new Asignacion(); // Instancia para verificar asignaciones
include '../partials/head.php';
include '../partials/navbar.php';
?>

<div class="cursos-section container my-5">
    <h2 class="cursos-title text-center mb-4">Gestión de Cursos</h2>

    <?php if (isset($_GET['msg'])): ?>
        <div class="alert alert-success text-center">
            <?php
            $msg = $_GET['msg'];
            if ($msg === 'agregado') echo "Curso agregado correctamente.";
            elseif ($msg === 'editado') echo "Curso editado correctamente.";
            elseif ($msg === 'eliminado') echo "Curso eliminado correctamente.";
            ?>
        </div>
    <?php endif; ?>

    <?php if ($_SESSION['usuario']['rol'] != 'estudiante'): ?>
        <div class="d-flex justify-content-between align-items-center flex-wrap mb-3 gap-2">
            <button class="btn btn-agregar" data-bs-toggle="modal" data-bs-target="#addModal">
                <i class="fas fa-plus"></i> Agregar Curso
            </button>
            <input class="form-control w-auto" type="text" id="searchCursoInput" placeholder="Buscar curso...">
        </div>
    <?php else: ?>
        <div class="d-flex justify-content-end mb-3">
            <input class="form-control w-25" type="text" id="searchCursoInput" placeholder="Buscar curso...">
        </div>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-bordered table-hover table-cursos text-center align-middle" id="cursosTable">
            <thead class="table-head">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cursos as $c): ?>
                    <tr>
                        <td><?= $c['id'] ?></td>
                        <td><?= $c['nombre'] ?></td>
                        <td>
                            <div class="d-flex flex-wrap justify-content-center align-items-center gap-2">
                                <button class="btn btn-ver btn-sm" data-bs-toggle="modal" data-bs-target="#viewModal<?= $c['id'] ?>">
                                    <i class="fas fa-eye me-1"></i> Ver
                                </button>

                                <?php if ($_SESSION['usuario']['rol'] != 'estudiante'): ?>
                                    <button class="btn btn-editar btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?= $c['id'] ?>">
                                        <i class="fas fa-edit me-1"></i> Editar
                                    </button>

                                    <?php $asignaciones = $asignacionObj->contarAsignacionesPorCurso($c['id']); ?>
                                    <?php if ($asignaciones == 0): ?>
                                        <button class="btn btn-eliminar btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $c['id'] ?>">
                                            <i class="fas fa-trash me-1"></i> Eliminar
                                        </button>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Curso asignado</span>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </td>

                    </tr>
                    <?php include '../modal/viewModal.php'; ?>
                    <?php include '../modal/editModal.php'; ?>
                    <?php include '../modal/deleteModal.php'; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../modal/addModal.php'; ?>

<?php include '../partials/footer.php'; ?>