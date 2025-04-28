<!-- Modal: Eliminar Usuario -->
<div class="modal fade" id="deleteUsuarioModal<?= $u['id'] ?>" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="../../controller/UsuarioAdminController.php" method="POST">
                <input type="hidden" name="eliminar" value="1">
                <input type="hidden" name="id" value="<?= $u['id'] ?>">
                <div class="modal-header">
                    <h5 class="modal-title">Eliminar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro que deseas eliminar al usuario <strong><?= htmlspecialchars($u['nombre']) ?></strong>?
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger">Eliminar</button>
                </div>
            </form>
        </div>
    </div>
</div>