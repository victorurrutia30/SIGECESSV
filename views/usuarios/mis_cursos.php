<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../../index.php");
    exit;
}

require_once '../../models/Asignacion.php';
$asignacion = new Asignacion();
$id_usuario = $_SESSION['usuario']['id'];
$cursos     = $asignacion->cursosAsignados($id_usuario);

$pageTitle = 'Mis Cursos Asignados';
include '../partials/head.php';
?>

<body class="layout-fixed sidebar-expand-lg sidebar-mini bg-body-tertiary app-loaded sidebar-collapse">
    <div class="app-wrapper">
        <?php include '../partials/navbar.php'; ?>
        <?php include '../partials/sidebar.php'; ?>

        <main class="app-main"><!--begin::App Main-->
            <!--begin::App Content Header-->
            <div class="app-content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <h1 class="mb-0"><?= htmlspecialchars($pageTitle) ?></h1>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::App Content Header-->

            <!--begin::App Content-->
            <div class="app-content">
                <div class="container-fluid mis-cursos-section my-5">
                    <?php if ($cursos->num_rows === 0): ?>
                        <div class="alert alert-info text-center">No tienes cursos asignados aún.</div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-mis-cursos text-center align-middle">
                                <thead class="table-head">
                                    <tr>
                                        <th>ID Curso</th>
                                        <th>Nombre del Curso</th>
                                        <th>Anular</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($cursos as $curso): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($curso['id']) ?></td>
                                            <td><?= htmlspecialchars($curso['nombre']) ?></td>
                                            <td>
                                                <form action="../../controller/InscripcionController.php" method="POST">
                                                    <input type="hidden" name="anular" value="1">
                                                    <input type="hidden" name="id_curso" value="<?= $curso['id'] ?>">

                                                    <button class="btn btn-sm btn-outline-danger">Anular</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <!--end::App Content-->
        </main>
        <!--end::App Main-->

        <?php include '../partials/footer.php'; ?>
    </div>
    <!--end::App Wrapper-->