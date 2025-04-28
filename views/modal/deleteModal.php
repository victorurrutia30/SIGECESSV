<div class="modal fade" id="deleteModal<?= $c['id'] ?>" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="../../controller/CursoController.php" method="POST">
                <input type="hidden" name="eliminar" value="1">
                <input type="hidden" name="id" value="<?= $c['id'] ?>">
                <div class="modal-header">
                    <h5 class="modal-title">Eliminar Curso</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    ¿Seguro que desea eliminar el curso: <strong><?= $c['nombre'] ?></strong>?
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger">Eliminar</button>
                </div>
            </form>
        </div>
    </div>
</div>