<?php include '../partials/head.php'; ?>
<?php include '../partials/navbar.php'; ?>

<div class="login-section d-flex align-items-center justify-content-center py-5">
    <div class="login-box container">

        <div class="logo-container">
            <img src="../../asset/img/UtecLog.png" alt="Logo UTEC">
        </div>

        <h2 class="login-title mb-4">Iniciar Sesión</h2>

        <?php if (isset($_GET['msg']) && $_GET['msg'] == 'error'): ?>
            <div class="alert alert-danger">Credenciales incorrectas.</div>
        <?php endif; ?>

        <form method="POST" action="../../controller/UsuarioController.php">
            <input type="hidden" name="login" value="1">

            <div class="mb-3">
                <label for="email" class="form-label">Correo</label>
                <input type="email" name="email" id="email" required class="form-control">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" name="password" id="password" required class="form-control">
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-login">Ingresar</button>
            </div>
        </form>
    </div>
</div>

<?php include '../partials/footer.php'; ?>