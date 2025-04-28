<?php
session_start();
if (
    !isset($_SESSION['usuario']) ||
    ($_SESSION['usuario']['rol'] != 'admin' && $_SESSION['usuario']['rol'] != 'docente')
) {
    header("Location: ../../index.php");
    exit;
}

require_once '../../models/Asignacion.php';
$asignacion = new Asignacion();
$usuarios    = $asignacion->obtenerUsuarios();
$cursos      = $asignacion->obtenerCursos();

$pageTitle = 'Asignación de Cursos';
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
                            <h1 class="mb-0">Asignación de Cursos</h1>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end::App Content Header -->

            <!-- begin::App Content -->
            <div class="app-content">
                <div class="container-fluid asignacion-section my-5">
                    <h2 class="asignacion-title text-center mb-4">Asignación de Cursos a Usuarios</h2>

                    <?php if (isset($_GET['msg']) && $_GET['msg'] == 'ok'): ?>
                        <div class="alert alert-success text-center">Cursos asignados correctamente.</div>
                    <?php elseif (isset($_GET['msg']) && $_GET['msg'] == 'eliminado'): ?>
                        <div class="alert alert-warning text-center">Curso eliminado correctamente del usuario.</div>
                    <?php endif; ?>

                    <form action="../../controller/AsignacionController.php" method="POST" class="form-asignacion mb-5">
                        <input type="hidden" name="asignar" value="1">
                        <div class="mb-3">
                            <label for="id_usuario" class="form-label fw-semibold">Selecciona Usuario</label>
                            <select name="id_usuario" id="id_usuario" required class="form-select">
                                <option value="">-- Seleccionar --</option>
                                <?php foreach ($usuarios as $u): ?>
                                    <option value="<?= $u['id'] ?>">
                                        <?= htmlspecialchars($u['nombre']) ?> (<?= htmlspecialchars($u['rol']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="cursos" class="form-label fw-semibold">Selecciona Cursos</label>
                            <select name="cursos[]" id="cursos" multiple required class="form-select" size="6">
                                <?php foreach ($cursos as $c): ?>
                                    <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['nombre']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="d-grid">
                            <button class="btn btn-asignar">Asignar Cursos</button>
                        </div>
                    </form>

                    <hr class="mb-4">

                    <h4 class="text-center mb-3">Cursos Asignados por Usuario</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered table-asignacion text-center align-middle">
                            <thead class="table-head">
                                <tr>
                                    <th>Usuario</th>
                                    <th>Rol</th>
                                    <th>Cursos Asignados</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($usuarios as $u): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($u['nombre']) ?></td>
                                        <td><?= htmlspecialchars($u['rol']) ?></td>
                                        <td>
                                            <?php
                                            $asignados = $asignacion->cursosAsignados($u['id']);
                                            foreach ($asignados as $asig):
                                            ?>
                                                <div class="d-flex justify-content-between align-items-center mb-1 p-2 rounded border bg-light-subtle">
                                                    <span><?= htmlspecialchars($asig['nombre']) ?></span>
                                                    <?php if ($_SESSION['usuario']['rol'] === 'admin'): ?>
                                                        <form action="../../controller/AsignacionController.php" method="POST" class="ms-2">
                                                            <input type="hidden" name="id_usuario" value="<?= $u['id'] ?>">
                                                            <input type="hidden" name="id_curso" value="<?= $asig['id'] ?>">
                                                            <input type="hidden" name="eliminar_asignacion" value="1">
                                                            <button type="submit" class="btn btn-sm btn-outline-danger">Quitar</button>
                                                        </form>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endforeach; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- end::App Content -->
        </main>
        <!-- end::App Main -->

        <?php include '../partials/footer.php'; ?>
    </div>
    <!-- end::App Wrapper -->