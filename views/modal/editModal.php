<div class="modal fade" id="editModal<?= $c['id'] ?>" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="../../controller/CursoController.php" method="POST">
                <input type="hidden" name="editar" value="1">
                <input type="hidden" name="id" value="<?= $c['id'] ?>">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Curso</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label>Nombre:</label>
                    <input type="text" name="nombre" class="form-control" value="<?= $c['nombre'] ?>" required>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-warning">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>