<!-- views/partials/footer.php -->
<footer class="footer-sigeces text-center py-3">
    <div class="container">
        <p class="mb-0">© 2025 <strong>SIGECES</strong> - Sistema de Gestión de Cursos y Estudiantes</p>
    </div>
</footer>

<!-- dependencias comunes -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<?php if (isset($_SESSION['usuario'])): ?>
    <!-- Sólo para páginas logueadas -->
    <script src="/SIGECES/adminlte/dist/js/adminlte.min.js"></script>
    <script src="/SIGECES/asset/js/main.js"></script>
<?php endif; ?>

</html>