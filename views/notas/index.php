<?php
session_start();
if ($_SESSION['usuario']['rol'] !== 'admin') {
    header("Location: ../../index.php");
    exit;
}
require_once '../../models/Asignacion.php';
require_once '../../models/Nota.php';

$asignacion = new Asignacion();
$notaModel = new Nota();


$usuarios = $asignacion->estudiantesConCursos(); // cambio aquí

$cursos   = $asignacion->obtenerCursos();

$pageTitle = 'Asignación de Calificaciones';
include '../partials/head.php';
?>

<body class="layout-fixed sidebar-expand-lg sidebar-mini bg-body-tertiary app-loaded sidebar-collapse">
    <div class="app-wrapper">
        <?php include '../partials/navbar.php'; ?>
        <?php include '../partials/sidebar.php'; ?>

        <main class="app-main">
            <div class="app-content-header">
                <div class="container-fluid">
                    <h1><?= $pageTitle ?></h1>
                </div>
            </div>
            <div class="app-content">
                <div class="container my-5">
                    <?php if (isset($_GET['msg']) && $_GET['msg'] == 'ok'): ?>
                        <div class="alert alert-success">Nota asignada correctamente.</div>
                    <?php endif; ?>

                    <form action="../../controller/NotaController.php" method="POST">
                        <input type="hidden" name="guardar_nota" value="1">

                        <div class="mb-3">
                            <label>Estudiante:</label>
                            <select name="id_usuario" class="form-select" required>
                                <option value="">Seleccionar...</option>
                                <?php foreach ($usuarios as $u): ?>
                                    <?php if ($u['rol'] === 'estudiante'): ?>
                                        <option value="<?= $u['id'] ?>"><?= $u['nombre'] ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Curso:</label>
                            <select name="id_curso" id="id_curso" class="form-select" required>
                                <option value="">Selecciona primero un estudiante</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Nota actual (si existe):</label>
                            <input type="text" id="nota_actual" class="form-control" readonly>
                        </div>

                        <div class="mb-3">
                            <label>Nota:</label>
                            <input type="number" name="nota" class="form-control" step="0.01" min="0" max="10" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Guardar Nota</button>
                    </form>
                </div>
            </div>
        </main>
        <?php include '../partials/footer.php'; ?>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const estudianteSelect = document.querySelector('select[name="id_usuario"]');
            const cursoSelect = document.getElementById('id_curso');
            const notaActual = document.getElementById('nota_actual');

            estudianteSelect.addEventListener('change', () => {
                const id_usuario = estudianteSelect.value;

                cursoSelect.innerHTML = '<option value="">Cargando...</option>';
                notaActual.value = '';

                if (!id_usuario) return;

                fetch('../../controller/NotaAjaxController.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: new URLSearchParams({
                            id_usuario
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        cursoSelect.innerHTML = '<option value="">Seleccionar curso...</option>';
                        data.forEach(curso => {
                            const opt = document.createElement('option');
                            opt.value = curso.id;
                            opt.textContent = curso.nombre;
                            opt.dataset.nota = curso.nota ?? '';
                            cursoSelect.appendChild(opt);
                        });
                    });
            });

            cursoSelect.addEventListener('change', () => {
                const nota = cursoSelect.selectedOptions[0]?.dataset?.nota;
                notaActual.value = nota ? parseFloat(nota).toFixed(2) : 'Sin nota';
            });
        });
    </script>