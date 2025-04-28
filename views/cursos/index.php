<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../../index.php");
    exit;
}

require_once '../../models/Curso.php';
require_once '../../models/Asignacion.php';

$curso         = new Curso();
$cursos        = $curso->obtenerCursos();
$asignacionObj = new Asignacion();

$pageTitle = 'Gestión de Cursos';
include '../partials/head.php';
?>

<body class="layout-fixed sidebar-expand-lg sidebar-mini bg-body-tertiary app-loaded sidebar-collapse">
    <div class="app-wrapper">
        <?php include '../partials/navbar.php'; ?>
        <?php include '../partials/sidebar.php'; ?>

        <main class="app-main"><!-- begin::App Main -->
            <!-- begin::App Content Header -->
            <div class="app-content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <h1 class="mb-0"><?= htmlspecialchars($pageTitle) ?></h1>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end::App Content Header -->

            <!-- begin::App Content -->
            <div class="app-content">
                <div class="container-fluid cursos-section my-5">
                    <h2 class="cursos-title text-center mb-4">Gestión de Cursos</h2>

                    <?php if (isset($_GET['msg'])): ?>
                        <div class="alert alert-success text-center">
                            <?php
                            $msg = $_GET['msg'];
                            if ($msg === 'agregado')   echo "Curso agregado correctamente.";
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
                                        <td><?= htmlspecialchars($c['id']) ?></td>
                                        <td><?= htmlspecialchars($c['nombre']) ?></td>
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

                    <?php include '../modal/addModal.php'; ?>
                </div>
            </div>
            <!-- end::App Content -->
        </main>
        <!-- end::App Main -->

        <?php include '../partials/footer.php'; ?>
    </div>
    <!-- end::App Wrapper -->
</body>

</html>