<!-- Modal: Agregar Usuario -->
<div class="modal fade" id="addUsuarioModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="../../controller/UsuarioAdminController.php" method="POST">
                <input type="hidden" name="agregar" value="1">
                <div class="modal-header">
                    <h5 class="modal-title">Agregar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label>Nombre:</label>
                    <input type="text" name="nombre" class="form-control mb-2" required>

                    <label>Email:</label>
                    <input type="email" name="email" class="form-control mb-2" required>

                    <label>Contraseña:</label>
                    <input type="password" name="password" class="form-control mb-2" required>

                    <label>Rol:</label>
                    <select name="rol" class="form-select" required>
                        <option value="estudiante">Estudiante</option>
                        <option value="docente">Docente</option>
                        <option value="admin">Administrador</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>