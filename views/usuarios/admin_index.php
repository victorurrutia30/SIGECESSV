<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'admin') {
    header("Location: ../../index.php");
    exit;
}
require_once '../../models/Usuario.php';
$usuario = new Usuario();
$usuarios = $usuario->obtenerTodos();

$pageTitle = 'Gestión de Usuarios';
include '../partials/head.php';
?>

<body class="layout-fixed sidebar-expand-lg sidebar-mini bg-body-tertiary app-loaded sidebar-collapse">
    <div class="app-wrapper">
        <?php include '../partials/navbar.php'; ?>
        <?php include '../partials/sidebar.php'; ?>

        <main class="app-main">
            <div class="app-content-header">
                <div class="container-fluid">
                    <h1 class="mb-0"><?= $pageTitle ?></h1>
                </div>
            </div>

            <div class="app-content">
                <div class="container-fluid my-5">
                    <?php if (isset($_GET['msg']) && $_GET['msg'] == 'ok'): ?>
                        <div class="alert alert-success">Acción realizada correctamente.</div>
                    <?php endif; ?>

                    <div class="d-flex justify-content-between mb-3">
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addUsuarioModal">
                            <i class="fas fa-user-plus me-1"></i> Agregar Usuario
                        </button>
                        <input class="form-control w-auto" type="text" id="searchInput" placeholder="Buscar usuario...">
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped align-middle text-center" id="usuariosTable">

                            <thead class="table-head">
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Correo</th>
                                    <th>Rol</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($usuarios as $u): ?>
                                    <tr>
                                        <td><?= $u['id'] ?></td>
                                        <td><?= htmlspecialchars($u['nombre']) ?></td>
                                        <td><?= htmlspecialchars($u['email']) ?></td>
                                        <td><?= $u['rol'] ?></td>
                                        <td>
                                            <div class="d-flex justify-content-center gap-2 flex-wrap">
                                                <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#viewUsuarioModal<?= $u['id'] ?>">
                                                    <i class="fas fa-eye me-1"></i> Ver
                                                </button>
                                                <button class="btn btn-outline-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editUsuarioModal<?= $u['id'] ?>">
                                                    <i class="fas fa-edit me-1"></i> Editar
                                                </button>
                                                <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteUsuarioModal<?= $u['id'] ?>">
                                                    <i class="fas fa-trash me-1"></i> Eliminar
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    <?php include '../modal/editUsuarioModal.php'; ?>
                                    <?php include '../modal/deleteUsuarioModal.php'; ?>
                                    <?php include '../modal/viewUsuarioModal.php'; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <?php include '../modal/addUsuarioModal.php'; ?>
                </div>
            </div>
            <!-- Popper + Bootstrap JS -->

        </main>


        <?php include '../partials/footer.php'; ?>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const input = document.getElementById('searchInput');
            const rows = document.querySelectorAll('#usuariosTable tbody tr');
            input.addEventListener('input', () => {
                const q = input.value.toLowerCase();
                rows.forEach(row => {
                    const match = row.textContent.toLowerCase().includes(q);
                    row.style.display = match ? '' : 'none';
                });
            });
        });
    </script>