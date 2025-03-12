</main>
<footer class="footer mt-auto footer-light">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 small">Copyright &copy; Machines <?=Date('Y')?></div>
            <div class="col-md-6 text-md-right small">
                <a href="#!">Privacy Policy</a>
                &middot;
                <a href="#!">Terms &amp; Conditions</a>
            </div>
        </div>
    </div>
</footer>
</div>
</div>


<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url('assets/AdminLTE-3.0.2/');?>plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url('assets/AdminLTE-3.0.2/');?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<!--<script src="--><?php //echo base_url('assets/AdminLTE-3.0.2/');?><!--plugins/chart.js/Chart.min.js"></script>-->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- daterangepicker -->
<script src="<?php echo base_url('assets/AdminLTE-3.0.2/');?>plugins/moment/moment.min.js"></script>
<script src="<?php echo base_url('assets/AdminLTE-3.0.2/');?>plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?php echo base_url('assets/AdminLTE-3.0.2/');?>plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>

<!-- overlayScrollbars -->
<script src="<?php echo base_url('assets/AdminLTE-3.0.2/');?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="<?php echo base_url('assets/AdminLTE-3.0.2/');?>/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script src="<?php echo base_url('assets/AdminLTE-3.0.2/');?>plugins/sweetalert2/sweetalert2.all.min.js"></script>
<script src="<?php echo base_url('assets/sb_admin_pro/');?>js/jquery.star-rating.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.11.5/r-2.2.9/datatables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>

<script src="<?php echo base_url('assets/sb_admin_pro/');?>js/scripts.js"></script>
<script src="<?php echo base_url('assets/draggable-kanban-board-ui/');?>js/kanban.js"></script>
<script src="<?php echo base_url('assets/jqueryui/');?>jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js"></script>


<script type="text/javascript">
$(document).ready(function () {
  bsCustomFileInput.init();
});
const Toast = Swal.mixin({
      toast: true,
      position: 'top-center',
      showConfirmButton: false,
      timer: 3000
    });
</script>
<?php if(isset($js)){	
	if (file_exists($js)) {
           include $js;
        }else{
		echo "<!--page $js file load fail Error 404-->";
		}
 }?>

</body>
</html>
