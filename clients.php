<?php
include_once 'controllers/session_control.php';
include_once 'controllers/functions.php';
include_once 'config/app.php';

$session = new session_control();
$functions = new functions();

$session->setSession('pagina','clientes');
header ('Content-type: text/html; charset=UTF-8');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">


<html><head>
  
  <title>WDS App | Clientes</title>
  <?php include_once 'controllers/header.php'; ?>
  <?php echo $meta_tags; ?>
  <?php echo $stylesheet; ?>
  <?php echo $js; ?>

</head>
<body class="hold-transition sidebar-mini layout-fixed sidebar-collapse">

<div class="wrapper">

  <!-- Navbar d-lg-none d-xl-none-->
  <nav class="main-header navbar navbar-expand navbar-light">
    <ul class="navbar-nav mt-1">
      <li class="nav-item">
        <a class="nav-link  pd10" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <div class="flex-fill py-2 pr-3">
	<h1 class="m-0 text-dark bold f30">Clientes</h1>
    </div>
 
    <div class="flex text-right">
		<a href="cliente/novo" class="btn btn-sm btn-outline-danger"><span class="btn-label">Novo<span class="cinza">&nbsp;&nbsp;|&nbsp;&nbsp;</span></span><i class="nav-icon fas fa-plus f12"></i></a>
    </div>
    &nbsp;
	
    
    <!-- Right navbar links -->
    
  </nav>
  <!-- /.navbar -->
 <?php include('sidebar.php'); ?>
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
    
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        
        <div class="row">
          <div class="col-sm-12">
           
            <!--<div class="card content">-->
              <?php
			  	echo $functions->getClients();
			  ?>   
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
</div>
<!-- /.content-wrapper -->
  <?php include('footer.php'); ?>
 
 
	
	<!-- Confirm modal -->
	

	<div class="modal fade" id="modal_confirm" tabindex="-1" role="dialog" aria-labelledby=" Mensagem" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
		<div class="modal-content bg-danger">
		  <div class="modal-body">
			É necessário confirmar esta operação.
			<input type="hidden" class="field_confirm" id="field_confirm" value="">
		  </div>
		  <div class="modal-footer">
			<button type="button" data-dismiss="modal" class="btn btn-warning" id="confirm" onclick="delCliente($('#field_confirm').val())">Confirmar</button>
    		<button type="button" data-dismiss="modal" class="btn btn-danger">Cancelar</button>
		  </div>
		 </div>
	  </div>
	</div>
	
	

</body>
<script>
	$(document).ready(function() {
		var oTable = $("#contentDataTable").DataTable({
			"order":[[ 0, "desc" ]],
			"pageLength": 50,
			"info":false,
			"language": {
				"paginate": {
				  "previous": "&laquo;",
				  "next": "&raquo;"
				},
				"lengthMenu": "_MENU_&nbsp;&nbsp;Registros por página",
				"zeroRecords": "Ops! Nenhum item encontrado",
				"infoEmpty": "Ops! Nenhum registro encontrado",
				"infoFiltered": "(Filtrado por _MAX_)",
				"search":"Buscar:"
			}
		})
	})
</script>

</html>
