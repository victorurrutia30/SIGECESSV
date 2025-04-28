<?php
// Sidebar de AdminLTE 4 – ¡ojo a la clase .main-sidebar!
?>
<aside class="main-sidebar app-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <div class="sidebar-brand">
        <a href="/SIGECES/index.php" class="brand-link">
            <img
                src="/SIGECES/adminlte/dist/assets/img/AdminLTELogo.png"
                alt="SIGECES Logo"
                class="brand-image img-circle elevation-3"
                style="opacity:.8" />
            <span class="brand-text fw-bold">SIGECES</span>
        </a>
    </div>

    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul
                class="nav sidebar-menu flex-column"
                data-lte-toggle="treeview"
                data-accordion="false"
                role="menu">
                <li class="nav-item">
                    <a href="/SIGECES/controller/DashboardController.php" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>


                <?php if ($_SESSION['usuario']['rol'] === 'admin'): ?>
                    <li class="nav-item">
                        <a href="/SIGECES/views/cursos/index.php" class="nav-link">
                            <i class="nav-icon fas fa-chalkboard"></i>
                            <p>Cursos</p>
                        </a>
                    </li>

                <?php endif; ?>

                <?php if ($_SESSION['usuario']['rol'] === 'estudiante'): ?>
                    <li class="nav-item">
                        <a href="/SIGECES/views/usuarios/mis_cursos.php" class="nav-link">
                            <i class="nav-icon fas fa-book"></i>
                            <p>Mis Cursos</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/SIGECES/views/inscripciones/index.php" class="nav-link">
                            <i class="nav-icon fas fa-clipboard-list"></i>
                            <p>Inscripciones</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/SIGECES/views/inscripciones/mis_inscripciones.php" class="nav-link">
                            <i class="nav-icon fas fa-book-open"></i>
                            <p>Mi Historial</p>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (in_array($_SESSION['usuario']['rol'], ['admin', 'docente'])): ?>
                    <li class="nav-item">
                        <a href="/SIGECES/views/usuarios/admin_index.php" class="nav-link">
                            <i class="nav-icon fas fa-tasks"></i>
                            <p>Usuarios</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/SIGECES/views/asignaciones/index.php" class="nav-link">
                            <i class="nav-icon fas fa-tasks"></i>
                            <p>Asignar Cursos</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/SIGECES/views/notas/index.php" class="nav-link">
                            <i class="nav-icon fas fa-clipboard-check"></i>
                            <p>Asignar Calificaciones</p>
                        </a>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a href="/SIGECES/controller/logout.php" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Cerrar Sesión</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>