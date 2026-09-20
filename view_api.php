<?php
include_once 'controllers/session_control.php';
include_once 'controllers/functions.php';
include_once 'config/app.php';

$session = new session_control();
$functions = new functions();

$session->setSession('pagina','api');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html><head>

  <title>WDS App | API</title>
  <?php include_once 'controllers/header.php'; ?>
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
			<h1 class="m-0 text-dark bold f30">API</h1>
		</div>
        <div class="flex p-2 text-right ">
          <a href="view_api.php?logs=log/" class="btn btn-sm btn-outline-dark"><span class="btn-label">Logs API<span class="cinza">&nbsp;&nbsp;|&nbsp;&nbsp;</span></span><i class="nav-icon fas fa-history f12"></i></a>
        </div>
          <div class="flex p-2 text-right ">
              <a href="view_api.php?doc=doc/" class="btn btn-sm btn-outline-dark"><span class="btn-label">Doc<span class="cinza">&nbsp;&nbsp;|&nbsp;&nbsp;</span></span><i class="nav-icon far fa-file f12"></i></a>
          </div>
	  </nav>

	  <?php include('sidebar.php'); ?>

	  <div class="content-wrapper">
		<div class="content-header">
		  <div class="container-fluid">
			<div class="row">
				<div class="col-sm-12">
					<div class="clr h10"></div>
					<div class="card filter ">
						<div class="">
							<div class="card-header pd20">
								<h3 class="card-title f20"><strong data-toggle="collapse" href="#filterBody" role="button" class="bt"><i class="nav-icon fas fa-filter f14"></i>&nbsp;Filtros</strong>&nbsp; <a href="<?= _HOST_ ?>view_api.php" class="  btn btn-xs btn-outline-primary">(Limpar)</a></h3>
								 <div class="card-tools">
									<a class="preto" data-toggle="collapse" href="#filterBody" role="button" aria-expanded="false" aria-controls="filterBody"><i class="nav-icon fas fa-sort f14 bt"></i></a>
								</div>
							</div>
							<div class="card-body collapse show " id="filterBody">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6 col-lg-3 py-1">
                                        <label for="filter">Dados da Consulta</label>
                                        <select class="form-control" id="filter">
                                            <option value="" selected>Selecione uma opção</option>
                                            <option value="orders" >Pedidos</option>
                                            <option value="sellers_fee" >Comissões</option>
                                        </select>
                                    </div>
                                </div>
							</div>
						</div>
					</div>
				</div>

			  </div>
		  </div>
		</div>

		<section class="content">
		  <div class="container-fluid">

			<div class="row">
			  <div class="col-12 px-4 pb-4" id="content_api">
                  <?php
                      if($_GET["logs"]){
                          $path = $_GET["logs"];
                          $diretorio = dir($path);
                          echo "<strong>Logs Report:</strong><br /><br />";
                          while($arquivo = $diretorio -> read()){
                              if(strlen($arquivo) > 4){
                                  $data_log = base64_encode(json_encode(["logfile"=>$path.$arquivo]));
                                  echo "
                                      <div class='col-12 px-0 py-1'>
                                          <a href='view_api.php?log=".$path.$arquivo."'>".$arquivo."</a>&nbsp;
                                          <a class='btRemoveLog bt text-danger f10' data-log='".$data_log."'><i class='fas fa-trash'></i></a>
                                      </div>
                                  ";
                              }
                          }
                          $diretorio -> close();
                      } elseif($_GET["log"]){
                              $file = $_GET["log"];
                              echo "Log File '<strong>".$file."</strong>':<br /><br />";
                              echo str_replace("\n", "<br>",htmlentities(file_get_contents($file)));
                      } elseif($_GET["doc"]){
                          if($_GET["next"]) {
                              $datetime = date("Y-m-d H:i:s");
                              $datetime_log = date("Ymd");
                              $log = $datetime . " - Documentation - " . $_GET["next"];
                              $log .= "\n";
                              file_put_contents("log/" . $datetime_log . ".txt", $log, FILE_APPEND);
                              header("Location: " . $_GET["next"]);
                          }
                          ?>
                            <h4 class="font-weight-bold">Documentação WDS APP 1.0</h4>
                            <p>Sistema de uso exclusivo, dedicado ao gerenciamento de pedidos de venda com recursos para geração de comissionamento para vendedores.</p>


                            <div class="py-4">
                                <h5 class="font-weight-bold pt-3">
                                    Produtos
                                    <a href="view_api.php?doc=doc&next=<?=_HOST_?>produtos" class="btn-xs"><i class="fas fa-link"></i></a>
                                </h5>
                                <p>Cadastro, edição e exclusão de produtos utilizados em pedidos</p>

                                <h5 class="font-weight-bold pt-3">
                                    Clientes
                                    <a href="view_api.php?doc=doc&next=<?=_HOST_?>clientes" class="btn-xs"><i class="fas fa-link"></i></a>
                                </h5>
                                <p>Cadastro, edição e exclusão de clientes</p>

                                <h5 class="font-weight-bold pt-3">
                                    Usuários
                                    <a href="view_api.php?doc=doc&next=<?=_HOST_?>usuarios" class="btn-xs"><i class="fas fa-link"></i></a>
                                </h5>
                                <p>Cadastro, edição e exclusão de usuários para acesso ao sistema</p>

                                <h5 class="font-weight-bold pt-3">
                                    Pedidos
                                    <a href="view_api.php?doc=doc&next=<?=_HOST_?>pedidos" class="btn-xs"><i class="fas fa-link"></i></a>
                                </h5>
                                <p>Cadastro, edição e exclusão de pedidos de venda para clientes</p>

                                <h5 class="font-weight-bold pt-3">
                                    Comissões
                                    <a href="view_api.php?doc=doc&next=<?=_HOST_?>comissoes" class="btn-xs"><i class="fas fa-link"></i></a>
                                </h5>
                                <p>Listagem de comissões geradas para usuários com base nos pedidos realizados</p>

                                <h5 class="font-weight-bold pt-3">
                                    Área do Cliente
                                    <a href="view_api.php?doc=doc&next=<?=_HOST_?>painel" class="btn-xs"><i class="fas fa-link"></i></a>
                                </h5>
                                <p>Painel do cliente para acesso à pedidos.</p>
                            </div>

                          <h5 class="font-weight-bold pb-4">Níveis de acesso</h5>
                          <p class="font-weight-bold">Colaborador</p>
                          <ul>
                              <li class="">Cadastro de Clientes;</li>
                              <li class="">Listagem de produtos;</li>
                              <li class="">Cadastro de pedidos de venda; *</li>
                              <li class="">Importação de produtos para pedidos de venda; *</li>
                              <li class="">Faturamento de pedidos de venda; *</li>
                              <li class="">Listagem de Comissões; *</li>
                              <p class="font-italic"> * Operações apenas para registros cujo vendedor seja o próprio colaborador;</p>
                          </ul>
                          <p class="font-weight-bold">Administrador</p>
                          <ul>
                              <li class="">Todas as funções de colaborador;</li>
                              <li class="">Cadastro de produtos</li>
                              <li class="">Cadastro de usuários;</li>
                              <li class="">Acesso à todos pedidos de venda;</li>
                              <li class="">Edição de vendedores em pedidos de venda;</li>

                          </ul>

                          <p class="font-weight-bold">Cliente</p>
                          <ul>
                              <li class="">Acesso à pedidos</li>
                          </ul>

                          <?php
                      }else{
                          echo "Selecione os dados que deseja consultar<br>";
                      }


                  ?>

			  </div>
			</div>
		  </div>
		</section>
  	</div>
  </div>

<?php include('footer.php'); ?>


<script>

	$(document).ready(function() {

        $("#filter").change(function(){
            let filter = $(this).val();
            let data = viewApi(filter);
        });

        $(".btRemoveLog").on("click", function () {
            let log = $(this).attr('data-log');
            let div = eval($(this).parent());

            $.post("view_api_del.php", {log:log},
                function(data){
                    if (data){
                        div.html(data);
                    }
                }
            );


        });
	})
</script>
</body>
</html>
