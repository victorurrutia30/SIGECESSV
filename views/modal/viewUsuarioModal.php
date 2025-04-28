<!-- Modal: Ver Usuario -->
<div class="modal fade" id="viewUsuarioModal<?= $u['id'] ?>" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalles del Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p><strong>ID:</strong> <?= $u['id'] ?></p>
                <p><strong>Nombre:</strong> <?= htmlspecialchars($u['nombre']) ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($u['email']) ?></p>
                <p><strong>Rol:</strong> <?= ucfirst($u['rol']) ?></p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>