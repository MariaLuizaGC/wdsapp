<?php
include_once 'controllers/session_control.php';
include_once 'controllers/functions.php';
include_once 'config/app.php';

$session = new session_control();
$functions = new functions();

$session->setSession('pagina','index');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">


<html><head>
  
  <title>WDS App | Adicionar Produto</title>
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
	<h1 class="m-0 text-dark bold f30">Adicionar Produto</h1>
    </div>
    <div class="flex-fill py-2 text-left">
		<a href="produtos" class="  btn btn-xs btn-outline-primary">(Ver Todos)</a>
    </div>
    <div class="flex p-2 text-right ">
		<a href="produto/novo" class="btn btn-sm btn-outline-danger"><span class="btn-label">Novo<span class="cinza">&nbsp;&nbsp;|&nbsp;&nbsp;</span></span><i class="nav-icon fas fa-plus f12"></i></a>
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
        <form id="form_data" action="javascript:setProduto()" method="post" class="">
        	<div class="row">
          
			  <input type="hidden" id="act" name="act" value="new">
			
			<div class="col-12 col-sm-6">
			  <div class="card content">
				<div class="card-body">
					<div class="form-row">
						<div class="form-group col-12 ">
							<label for="user" aria-label="Produto">Produto*</label>
							<div class="input-group">
							  <div class="input-group-prepend">
								<span class="input-group-text"><i class="fas fa-box"></i></span>
							  </div>
							  <input type="text" class="form-control " id="produto" name="produto" placeholder="Produto" required>
							</div>
						</div>
					</div>
					
					
					<div class="form-row">
						<div class="form-group col-6 ">
							<label for="email" aria-label="Valor">Valor*</label>
							<div class="input-group ">
							  <div class="input-group-prepend">
								<span class="input-group-text">R$</span>
							  </div>
							  <input type="text" class="form-control input-value " id="valor" name="valor" placeholder="Valor"  required>
							</div>
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
							<button type="submit" class="btn btn-primary btn-sm  pd20"><i class="far fa-save"></i>&nbsp;&nbsp;Salvar</button>
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
 
    <script type="text/javascript">
        $(".input-value").inputmask({
            rightAlign:false,
            alias: "numeric",
            allowMinus: true,
            digits: 2,
            min: 0,
            max: 9999.99
        });
    </script>
</body>


</html>
