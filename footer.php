<?php if($_SESSION["pagina"] != "login" && $_SESSION["pagina"] != "user-pass" ){ ?>

<footer class="main-footer">
    <div class="row">
        <div class="flex-fill">
            <strong>Copyright &copy; <?php echo date("Y"); ?> <span class="text-info">WDS App</span>.</strong>
            Todos os Direitos Reservados.
        </div>
        <!--
        <div class="flex-fill text-right p-1" style="font-size:12px">
            <a href="view_api.php" class="text-dark">Consulta API</a>
        </div>
        -->
    </div>
</footer>

<?php } ?>
 
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->


<!-- Alert modal -->
	

<div class="modal fade" id="modal_alert" tabindex="-1" role="dialog" aria-labelledby="Mensagem" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
	<div class="modal-content">
	  <div class="modal-header">
		<h5 class="modal-title"></h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	  <div class="modal-body">
		...
	  </div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
	  </div>
	</div>
  </div>
</div>


<!-- Loading modal -->


<div class="modal fade" id="modal_loading" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="Aguarde" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
	<div class="modal-content">
	  <div class="overlay d-flex justify-content-center align-items-center">
			<i class="fas fa-2x fa-sync fa-spin"></i>
		</div>
	  <div class="modal-header">
		<h5 class="modal-title">Aguarde...</h5>
	  </div>
	  <div class="modal-body">
		  <div class="d-flex justify-content-center">
			Estamos processando sua solicitação.
			<input type="hidden" id="hideLoading" name="hideLoading" value="">
		  </div>
	   </div>
	</div>
  </div>
</div>
<?php echo $jsFooter; ?>