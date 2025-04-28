<?php
session_start();
if (isset($_SESSION['usuario'])) {
    header("Location: views/usuarios/dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php include 'views/partials/head.php'; ?>
    <title>SIGECES - Inicio</title>
</head>

<body>

    <?php include 'views/partials/navbar.php'; ?>

    <div class="main-wrapper">

        <div class="hero-section text-center">
            <div class="hero-container container py-4">
                <div class="hero-icon mb-3">
                    <i class="fas fa-graduation-cap fa-2x"></i>
                </div>
                <h1 class="hero-title mb-2">Bienvenido a SIGECES</h1>
                <p class="hero-subtitle mb-2">Sistema de Gestión de Cursos y Estudiantes</p>
                <p class="hero-description mb-3">Una plataforma académica moderna para la Universidad Tecnológica de El Salvador.</p>
                <a href="/SIGECES/views/usuarios/login.php" class="btn btn-warning hero-login-btn fw-bold">
                    👉 Iniciar sesión
                </a>
            </div>
        </div>




        <div class="about-sigeces-section text-center py-5">
            <div class="about-container container">
                <h2 class="about-title mb-4">¿Qué es SIGECES?</h2>
                <p class="about-description mb-4">
                    SIGECES es una plataforma académica integral diseñada para optimizar la gestión educativa en la Universidad Tecnológica de El Salvador.
                    Facilita el acceso de estudiantes, docentes y personal administrativo a herramientas modernas que simplifican los procesos académicos.
                </p>

                <div class="about-features row justify-content-center align-items-stretch">
                    <div class="col-md-6 col-lg-3 mb-4 d-flex">
                        <div class="feature-item h-100 w-100 d-flex flex-column justify-content-center text-center p-3">
                            <i class="fas fa-book-open fa-2x mb-2 feature-icon"></i>
                            <h5 class="feature-title">Gestión de cursos</h5>
                            <p class="feature-text">Organización y seguimiento de asignaturas y calificaciones.</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-4 d-flex">
                        <div class="feature-item h-100 w-100 d-flex flex-column justify-content-center text-center p-3">
                            <i class="fas fa-user-graduate fa-2x mb-2 feature-icon"></i>
                            <h5 class="feature-title">Administración de estudiantes</h5>
                            <p class="feature-text">Gestión eficiente del perfil estudiantil y trayectoria académica.</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-4 d-flex">
                        <div class="feature-item h-100 w-100 d-flex flex-column justify-content-center text-center p-3">
                            <i class="fas fa-calendar-alt fa-2x mb-2 feature-icon"></i>
                            <h5 class="feature-title">Inscripción en línea</h5>
                            <p class="feature-text">Procesos de matrícula accesibles desde cualquier lugar.</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-4 d-flex">
                        <div class="feature-item h-100 w-100 d-flex flex-column justify-content-center text-center p-3">
                            <i class="fas fa-chart-bar fa-2x mb-2 feature-icon"></i>
                            <h5 class="feature-title">Reportes académicos</h5>
                            <p class="feature-text">Visualización clara del rendimiento académico institucional.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="benefits-section py-5">
            <div class="benefits-container container text-center">
                <h2 class="benefits-title mb-4">Beneficios para la comunidad</h2>
                <div class="row justify-content-center">

                    <!-- Card Docentes -->
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card benefit-card h-100 shadow-sm">
                            <div class="card-body">
                                <div class="benefit-icon mb-3">
                                    <i class="fas fa-chalkboard-teacher fa-2x"></i>
                                </div>
                                <h5 class="card-title text-primary fw-bold">Docentes</h5>
                                <p class="card-text">Control de cursos y calificaciones con acceso fácil y centralizado.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Card Estudiantes -->
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card benefit-card h-100 shadow-sm">
                            <div class="card-body">
                                <div class="benefit-icon mb-3">
                                    <i class="fas fa-user-graduate fa-2x"></i>
                                </div>
                                <h5 class="card-title text-primary fw-bold">Estudiantes</h5>
                                <p class="card-text">Acceso a inscripción, historial académico y progreso educativo.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Card Administrativos -->
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card benefit-card h-100 shadow-sm">
                            <div class="card-body">
                                <div class="benefit-icon mb-3">
                                    <i class="fas fa-school fa-2x"></i>
                                </div>
                                <h5 class="card-title text-primary fw-bold">Administrativos</h5>
                                <p class="card-text">Gestión académica centralizada con procesos optimizados.</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="how-it-works-section py-5">
            <div class="howit-container container text-center">
                <h2 class="howit-title mb-4">¿Cómo funciona?</h2>
                <p class="howit-description mb-5">
                    Sigue estos sencillos pasos para comenzar a utilizar SIGECES de forma fácil y rápida.
                </p>
                <div class="row justify-content-center">
                    <!-- Paso 1 -->
                    <div class="col-md-4 mb-4 d-flex">
                        <div class="howit-step h-100 w-100 d-flex flex-column justify-content-center align-items-center px-3 py-4">
                            <div class="howit-icon mb-3">
                                <i class="fas fa-sign-in-alt fa-2x"></i>
                            </div>
                            <h5 class="howit-step-title">① Inicia sesión</h5>
                            <p class="howit-step-text text-center">Accede con tus credenciales institucionales para comenzar.</p>
                        </div>
                    </div>

                    <!-- Paso 2 -->
                    <div class="col-md-4 mb-4 d-flex">
                        <div class="howit-step h-100 w-100 d-flex flex-column justify-content-center align-items-center px-3 py-4">
                            <div class="howit-icon mb-3">
                                <i class="fas fa-columns fa-2x"></i>
                            </div>
                            <h5 class="howit-step-title">② Accede a tu panel</h5>
                            <p class="howit-step-text text-center">Visualiza tu información académica desde un solo lugar.</p>
                        </div>
                    </div>

                    <!-- Paso 3 -->
                    <div class="col-md-4 mb-4 d-flex">
                        <div class="howit-step h-100 w-100 d-flex flex-column justify-content-center align-items-center px-3 py-4">
                            <div class="howit-icon mb-3">
                                <i class="fas fa-tasks fa-2x"></i>
                            </div>
                            <h5 class="howit-step-title">③ Gestiona tu información</h5>
                            <p class="howit-step-text text-center">Administra cursos, inscripciones y reportes con facilidad.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</body>
<?php include 'views/partials/footer.php'; ?>