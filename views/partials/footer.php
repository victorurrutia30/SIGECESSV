<?php // Footer + scripts 
?>
<footer class="app-footer"><!--begin::Footer-->
    <strong>© 2025 <a href="https://adminlte.io" class="text-decoration-none">SIGECES</a>.</strong>
    Todos los derechos reservados.
</footer><!--end::Footer-->

<!-- OverlayScrollbars -->
<!-- AdminLTE depende de Bootstrap.bundle (ya incluye Popper.js) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

<!-- OverlayScrollbars -->
<script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/browser/overlayscrollbars.browser.es6.min.js" crossorigin="anonymous"></script>

<!-- AdminLTE v4 -->
<script src="/SIGECES/adminlte/dist/js/adminlte.js"></script>

<!-- Inicializa OverlayScrollbars en el sidebar -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const sb = document.querySelector('.sidebar-wrapper');
        if (sb && window.OverlayScrollbars) {
            OverlayScrollbars(sb, {});
        }
    });
</script>



</body><!--end::Body-->

</html>