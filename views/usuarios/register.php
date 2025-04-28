<?php include '../partials/head.php'; ?>
<?php include '../partials/navbar.php'; ?>
<div class="container mt-5">
    <h2>Registro de Usuario</h2>
    <?php if (isset($_GET['msg']) && $_GET['msg'] == 'ok'): ?>
        <div class="alert alert-success">Registro exitoso. Ya puedes iniciar sesión.</div>
    <?php elseif (isset($_GET['msg']) && $_GET['msg'] == 'error'): ?>
        <div class="alert alert-danger">Error: El correo ya está registrado.</div>
    <?php endif; ?>
    <form method="POST" action="../../controller/UsuarioController.php">
        <input type="hidden" name="registro" value="1">
        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="nombre" required class="form-control">
        </div>
        <div class="mb-3">
            <label>Correo</label>
            <input type="email" name="email" required class="form-control">
        </div>
        <div class="mb-3">
            <label>Contraseña</label>
            <input type="password" name="password" required class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Registrar</button>
    </form>
</div>
<?php include '../partials/footer.php'; ?>