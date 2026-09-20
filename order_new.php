<?php
include_once 'controllers/session_control.php';
include_once 'controllers/functions.php';
include_once 'config/app.php';

$session = new session_control();
$functions = new functions();

$session->setSession('pagina','orders');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">


<html><head>
  
  <title>WDS App | Novo Pedido</title>
  <?php include_once 'controllers/header.php'; ?>
  <?php echo $meta_tags; ?>
  <?php echo $stylesheet; ?>
  <?php echo $js; ?>

</head>
<body class="hold-transition sidebar-mini layout-fixed sidebar-collapse">

<div class="wrapper">

  <!-- Navbar d-lg-none d-xl-none-->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav mt-1">
      <li class="nav-item">
        <a class="nav-link  pd10" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <div class="flex py-2 pr-3">
	<h1 class="m-0 text-dark bold f30">Novo Pedido</h1>
    </div>
    <div class="flex-fill py-2 text-left">
		<a href="pedidos" class="  btn btn-xs btn-outline-primary">(Ver Todos)</a>
    </div>
    <div class="flex p-2 text-right ">
		<a href="pedido/novo" class="btn btn-sm btn-outline-danger"><span class="btn-label">Novo<span class="cinza">&nbsp;&nbsp;|&nbsp;&nbsp;</span></span><i class="nav-icon fas fa-plus f12"></i></a>
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
      <div class="container-fluid">
        <div class="row">

          </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <form id="form_data" action="javascript:setOrder()" method="post" class="">
        	<div class="row">

			  <input type="hidden" id="act" name="act" value="new">
              <input type="hidden" id="auth_token" name="auth_token" value="<?= base64_encode($_SESSION["id_user_WDSApp_session"]) ?>">

			<div class="col-12 col-sm-6">
			  <div class="card content">
				<div class="card-body">
					<div class="form-row">
						<div class="form-group col-12 ">
							<label for="user" aria-label="Cliente">Cliente*</label>
                            <select class="custom-select" id="cliente" name="cliente"  required>
                                <?php echo $functions->selectClient(); ?>
                            </select>
						</div>
					</div>
                    <?php

                    if($userLevel["id"] == 1){
                        $seller = "";
                        $display = "block";
                    }else{
                        $seller = $_SESSION["id_user_WDSApp_session"];
                        $display = "none";
                    }
                    ?>
                    <div class="form-row" style="display: <?= $display ?>">
                        <div class="form-group col-12 ">
                            <label for="user" aria-label="Cliente">Vendedor*</label>
                            <select class="custom-select" id="vendedor" name="vendedor"  required>
                                <?php echo $functions->selectSeller($seller); ?>
                            </select>
                        </div>
                    </div>

				</div>
			  </div>
			</div>




			<div class="col-12">
				<div class="card content">
					<div class="card-body">
						<div class="form-group col-sm-12">
							<a class="btn btn-default bt btn-sm  pd20" onclick="history.back();"><i class="far fa-window-close"></i>&nbsp;&nbsp;Cancelar</a>
							<button type="submit" class="btn btn-primary btn-sm  pd20"><i class="far fa-save"></i>&nbsp;&nbsp;Continuar</button>
						</div>
					</div>
			  	</div>
			</div>

          </div>
		</form>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
</div>
<!-- /.content-wrapper -->
  <?php include('footer.php'); ?>

</body>


</html>
