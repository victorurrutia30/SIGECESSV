<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="../../controller/CursoController.php" method="POST">
                <input type="hidden" name="agregar" value="1">
                <div class="modal-header">
                    <h5 class="modal-title">Agregar Curso</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label>Nombre:</label>
                    <input type="text" name="nombre" class="form-control" required>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>