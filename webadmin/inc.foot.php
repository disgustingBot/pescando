<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 3 -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="../plugins/jQueryUI/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="../plugins/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../plugins/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- Custom DataTable Internalisation -->
<script src="js/datatable-lang-es.js"></script>
<!-- Slimscroll -->
<script src="../plugins/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- Morris.js charts -->
<script src="../plugins/raphael/raphael.min.js"></script>
<script src="../plugins/morris.js/morris.min.js"></script>
<!-- FastClick -->
<script src="../plugins/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../js/adminlte.min.js"></script>

<script>
  $(function () {
    $('[data-toggle="tooltip"]').tooltip();
  });
</script>