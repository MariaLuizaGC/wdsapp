<?php
include_once 'controllers/session_control.php';
include_once 'controllers/functions.php';
include_once 'config/app.php';

$session = new session_control();
$functions = new functions();

$session->setSession('pagina','clientes');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">


<html><head>
  
  <title>WDS App | Editar Cliente</title>
  <?php include_once 'controllers/header.php'; ?>
  <?php echo $meta_tags; ?>
  <?php echo $stylesheet; ?>
  <?php echo $js; ?>
  <?php

  	

	if(!$_GET["item"]){
		 header("location:"._HOST_."clientes");
	}else{
		
		$getItem = $_GET["item"];

		$id = $getItem;

		$conn = new connect();
		

		$qry = "
		SELECT 
			* 
		FROM
			clients
		WHERE
		  id = ".$id." 
		LIMIT 1";

		$query = $conn->query($qry, $con);
		$rs =  $conn->fetch_array($query);

		if(!$rs){
			 header("location:"._HOST_."usuarios");
		}
		$id = $rs["id"];
		$nome = $rs["nome"];
        $sobrenome = $rs["sobrenome"];
		$email = $rs["email"];
        $telefone = $rs["telefone"];
        $documento = $rs["documento"];
        $endereco = $rs["endereco"];
        $cidade = $rs["cidade"];
        $estado = $rs["estado"];
        $cep = $rs["cep"];
        $pais = $rs["pais"];
        $password = $rs["password"];
	}

	
  ?>
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
	<h1 class="m-0 text-dark bold f30">Edição de Cliente</h1>
    </div>
    <div class="flex-fill py-2 text-left">
		<a href="clientes" class="  btn btn-xs btn-outline-primary">(Ver Todos)</a>
    </div>
    <div class="flex-fill text-right">
		<button class="btn btn-outline-info btn-sm" onClick="sendTokenCliente('<?php echo $email; ?>')"><span class="btn-label">Enviar Acesso<span class="cinza">&nbsp;&nbsp;|&nbsp;&nbsp;</span></span><i class="nav-icon fas fa-key f12"></i></button>
    </div>
    <div class="flex p-2 text-right ">
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
      <div class="container-fluid">
        <div class="row">
        	
          </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <form id="form_data" action="javascript:setClient()" method="post" class="">
        	<div class="row">
          
			  <input type="hidden" id="act" name="act" value="edit">
			  <input type="hidden" id="id" name="id" value="<?php echo $getItem; ?>">
			
			<div class="col-12">
			  <div class="card content">
                  <div class="card-body">

                      <div class="form-row">
                          <div class="col-sm-12 col-md-6 col-lg-5 col-xl-5">
                              <div class="form-row">
                                  <div class="form-group pd10">
                                      <h3 class="card-title" aria-label="Dados do Cliente"><strong><i class="fas fa-edit mr-1 f14" ></i> Dados do Cliente</strong></h3>
                                  </div>
                              </div>
                              <div class="form-row">

                                  <div class="form-group col-sm-12 col-md-6">
                                      <label for="nome" aria-label="nome">Nome*</label>
                                      <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome" value="<?php echo $nome; ?>" required>
                                  </div>
                                  <div class="form-group col-sm-12 col-md-6">
                                      <label for="nome" aria-label="nome">Sobrenome*</label>
                                      <input type="text" class="form-control" id="sobrenome" name="sobrenome" placeholder="Sobrenome" value="<?php echo $sobrenome; ?>" required>
                                  </div>
                              </div>
                              <div class="form-row">
                                  <div class="form-group col-sm-12 col-md-6">
                                      <label for="cpf" aria-label="CPF">Documento*</label>
                                      <input type="text" class="form-control documento" id="documento" name="documento" placeholder="Documento" value="<?php echo $documento; ?>" required>
                                  </div>
                                  <div class="form-group col-sm-12 col-md-6">
                                      <label for="telefone" aria-label="Telefone">Telefone*</label>
                                      <input type="text" class="form-control telefone" id="telefone" name="telefone" placeholder="Telefone" value="<?php echo $telefone; ?>" required>
                                  </div>
                              </div>
                              <div class="form-row">
                                  <div class="form-group col-sm-12 ">
                                      <label for="email" aria-label="E-mail">E-mail*</label>
                                      <div class="input-group ">
                                          <div class="input-group-prepend">
                                              <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                          </div>
                                          <input type="email" class="form-control " id="email" name="email" placeholder="Email" value="<?php echo $email; ?>" required>
                                      </div>
                                  </div>
                              </div>
                              <!--
                              <div class="form-row">
                                  <div class="form-group col-sm-12 ">
                                      <label for="email" aria-label="E-mail">Password*</label>
                                      <div class="input-group ">
                                          <div class="input-group-prepend">
                                              <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                          </div>
                                          <input type="password" class="form-control " id="password" name="password" placeholder="Senha" value="<?php echo $password; ?>" >
                                      </div>
                                  </div>
                              </div>
                              -->

                          </div>
                          <div class="col-sm-1 d-none d-sm-none d-md-none d-lg-block"></div>
                          <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                              <div class="form-row">
                                  <div class="form-group pd10">
                                      <h3 class="card-title " aria-label="Endereço"><strong><i class="fas fa-map-marker-alt mr-1 f14" ></i> Endereço</strong></h3>
                                  </div>
                              </div>

                              <div class="form-row">
                                  <div class="form-group col-sm-12">
                                      <label for="endereco" aria-label="Rua/Avenida">Rua / Av*</label>
                                      <input type="text" class="form-control" id="endereco" name="endereco" placeholder="Rua/Av" value="<?php echo $endereco; ?>" required>
                                  </div>
                              </div>
                              <div class="form-row">
                                  <div class="form-group col-sm-12 col-md-10 col-lg-10 col-xl-10">
                                      <label for="cidade" aria-label="Cidade">Cidade*</label>
                                      <input type="text" class="form-control" id="cidade" name="cidade" placeholder="Cidade" value="<?php echo $cidade; ?>" required>
                                  </div>

                                  <div class="form-group col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                      <label for="uf" aria-label="UF">UF*</label>
                                      <select class="custom-select " id="estado" name="estado"  required>
                                          <?php echo $functions->select_box_uf($estado); ?>
                                      </select>
                                  </div>
                              </div>
                              <div class="form-row">
                                  <div class="form-group col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                      <label for="cep" aria-label="CEP">CEP*</label>
                                      <input type="text" class="form-control cep" id="cep" name="cep" placeholder="CEP" value="<?php echo $cep; ?>" required>
                                  </div>
                                  <div class="form-group col-sm-12 col-md-8 col-lg-8 col-xl-8">
                                      <label for="bairro" aria-label="País">País*</label>
                                      <input type="text" class="form-control" id="pais" name="pais" placeholder="País" value="<?php echo $pais; ?>" required>
                                  </div>
                              </div>

                          </div>
                      </div>
                      <div class="clr h40"></div>


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
<script>
    $(".documento").inputmask({
    rightAlign:false,
    mask: '999.999.999-99'
    });

    $(".cep").inputmask({
    rightAlign:false,
    mask: '99999-999'
    });

    $(".telefone").inputmask({
    rightAlign:false,
    mask: ['(99)99999-9999','(99) 9999-9999']
    });

</script>
 
</body>


</html>
