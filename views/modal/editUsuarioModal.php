<!-- Modal: Editar Usuario -->
<div class="modal fade" id="editUsuarioModal<?= $u['id'] ?>" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="../../controller/UsuarioAdminController.php" method="POST">
                <input type="hidden" name="editar" value="1">
                <input type="hidden" name="id" value="<?= $u['id'] ?>">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label>Nombre:</label>
                    <input type="text" name="nombre" class="form-control mb-2" value="<?= htmlspecialchars($u['nombre']) ?>" required>

                    <label>Email:</label>
                    <input type="email" name="email" class="form-control mb-2" value="<?= htmlspecialchars($u['email']) ?>" required>

                    <label>Rol:</label>
                    <select name="rol" class="form-select" required>
                        <option value="estudiante" <?= $u['rol'] === 'estudiante' ? 'selected' : '' ?>>Estudiante</option>
                        <option value="docente" <?= $u['rol'] === 'docente' ? 'selected' : '' ?>>Docente</option>
                        <option value="admin" <?= $u['rol'] === 'admin' ? 'selected' : '' ?>>Administrador</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-warning">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>