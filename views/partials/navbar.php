<nav class="main-header navbar navbar-expand navbar-sigeces">
    <div class="container">

        <!-- PushMenu de AdminLTE -->
        <button class="nav-link text-white me-3" data-widget="pushmenu" type="button">
            <i class="fas fa-bars"></i>
        </button>

        <a class="navbar-brand text-white fw-bold" href="/SIGECES/index.php">SIGECES</a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon custom-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto gap-2">
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
                        <a class="nav-link nav-link-sigeces" href="/SIGECES/controller/logout.php">
                            <i class="fas fa-sign-out-alt me-1"></i> Cerrar Sesión
                        </a>
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
    </div>
</nav>