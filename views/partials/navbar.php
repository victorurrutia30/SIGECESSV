<?php
// Navbar de AdminLTE 4 minimalista
?>
<nav class="app-header navbar navbar-expand navbar-sigeces">
    <div class="container-fluid">
        <?php if (isset($_SESSION['usuario'])): ?>
            <!-- Toggle del sidebar -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                        <i class="bi bi-list"></i>
                    </a>
                </li>
            </ul>
        <?php endif; ?>

        <!-- Marca -->
        <a href="/SIGECES/index.php" class="navbar-brand text-white fw-bold ms-2">
            SIGECES
        </a>

        <!-- Toggler en móvil -->
        <button
            class="navbar-toggler border-0"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarSigeces"
            aria-controls="navbarSigeces"
            aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <ul class="navbar-nav ms-auto">
            <?php if (isset($_SESSION['usuario'])): ?>

                <?php if ($_SESSION['usuario']['rol'] === 'admin'): ?>
                    <li class="nav-item">
                        <a class="nav-link nav-link-sigeces" href="/SIGECES/views/asignaciones/index.php">
                            <i class="fas fa-tasks me-1"></i> Asignar Cursos
                        </a>
                    </li>
                <?php elseif ($_SESSION['usuario']['rol'] === 'estudiante'): ?>
                    <li class="nav-item">
                        <a class="nav-link nav-link-sigeces" href="/SIGECES/views/usuarios/mis_cursos.php">
                            <i class="fas fa-book me-1"></i> Mis Cursos
                        </a>
                    </li>
                <?php endif; ?>

                <li class="nav-item">
                    <a class="nav-link nav-link-sigeces" href="/SIGECES/views/cursos/index.php">
                        <i class="fas fa-chalkboard me-1"></i> Cursos
                    </a>
                </li>


                <li class="nav-item">
                    <a class="nav-link" href="#" data-lte-toggle="fullscreen">
                        <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
                        <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none"></i>
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <a
                        class="nav-link nav-link-sigeces dropdown-toggle"
                        href="#"
                        id="userMenuDropdown"
                        role="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fas fa-user me-1"></i>
                        <?= htmlspecialchars($_SESSION['usuario']['nombre']) ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenuDropdown">
                        <li>
                            <a href="/SIGECES/controller/logout.php" class="dropdown-item">
                                <i class="fas fa-sign-out-alt me-1"></i> Cerrar Sesión
                            </a>
                        </li>
                    </ul>
                </li>

            <?php else: ?>

                <li class="nav-item">
                    <a class="nav-link nav-link-sigeces" href="/SIGECES/views/usuarios/login.php">
                        <i class="fas fa-sign-in-alt me-1"></i> Iniciar Sesión
                    </a>
                </li>

            <?php endif; ?>
        </ul>

    </div>
</nav>