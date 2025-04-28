<?php // Footer + scripts 
?>
<footer class="app-footer"><!--begin::Footer-->
    <strong>© 2025 <a href="https://adminlte.io" class="text-decoration-none">SIGECES</a>.</strong>
    Todos los derechos reservados.
</footer><!--end::Footer-->

<!-- OverlayScrollbars -->
<script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/browser/overlayscrollbars.browser.es6.min.js"
    integrity="sha256-dghWARbRe2eLlIJ56wNB+b760ywulqK3DzZYEpsg2fQ="
    crossorigin="anonymous"></script>
<!-- Popper + Bootstrap 5 -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
<!-- AdminLTE App -->
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