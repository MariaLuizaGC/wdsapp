<?php
include_once 'controllers/session_control.php';
include_once 'controllers/functions.php';
include_once 'config/app.php';

$session = new session_control();
$functions = new functions();


$session->setSession('pagina','painel');


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">


<html><head>

  <title>WDS App | Pedidos</title>
  <?php include_once 'controllers/client_header.php'; ?>
  <?php echo $meta_tags; ?>
  <?php echo $stylesheet; ?>
  <?php echo $js; ?>

</head>
<body class="hold-transition sidebar-mini layout-fixed sidebar-collapse ">

	<div class="wrapper">

	 <!-- Navbar d-lg-none d-xl-none-->
	  <nav class="main-header navbar navbar-expand navbar-light">
		<ul class="navbar-nav mt-1">
		  <li class="nav-item">
			<a class="nav-link  pd10" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
		  </li>
		</ul>
		<div class="py-2 pr-3 flex-fill">
			<h1 class="m-0 text-dark bold f30">Meu Painel</h1>
		</div>

	  </nav>
      <!-- /.navbar -->
	  <?php include('client_sidebar.php'); ?>


	  <div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<div class="content-header">
		  <div class="container-fluid">
			<div class="row">
				<div class="col-sm-12 d-none">
					<div class="clr h10"></div>
					<div class="card filter ">
						<div class="">
							<div class="card-header pd20">
								<h3 class="card-title f20"><strong data-toggle="collapse" href="#filterBody" role="button" class="bt"><i class="nav-icon fas fa-filter f14"></i>&nbsp;Filtros</strong>&nbsp; <a href="./" class="  btn btn-xs btn-outline-primary">(Limpar)</a></h3>
								 <div class="card-tools">
									<a class="preto" data-toggle="collapse" href="#filterBody" role="button" aria-expanded="false" aria-controls="filterBody"><i class="nav-icon fas fa-sort f14 bt"></i></a>
								</div>
							  </div>
							  <!-- /.card-header -->
							<div class="card-body collapse hide " id="filterBody">

							</div>
						</div>
					</div>
				</div>

			  </div><!-- /.row  -->
		  </div><!-- /.container-fluid  -->
		</div>
		<!-- /.content-header   -->
		<!-- Main content -->
		<section class="content">
		  <div class="container-fluid">

			<div class="row">
			  <div class="col-12">
				<?php echo $functions->getClientOrders($_SESSION["id_client_WDSApp_session"]);?>

				<!-- /.card -->
			  </div>
			</div>
		  </div><!-- /.container-fluid -->
		</section>
    <!-- /.content -->
  	</div>
  </div>
<!-- /.content-wrapper -->

<?php include('footer.php'); ?>


<script>

	$(".input-int").inputmask({
	  rightAlign:false,
	  alias: "numeric",
	  allowMinus: true,
	  digits: 0,
	  min: -9999,
	  max: 9999
	});

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
</body>
</html>
