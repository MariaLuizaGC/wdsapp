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

  <title>WDS App | Pedido</title>
  <?php include_once 'controllers/client_header.php'; ?>
  <?php echo $meta_tags; ?>
  <?php echo $stylesheet; ?>
  <?php echo $js; ?>
  <?php


    if(!$_GET["item"]){
        header("location:"._HOST_);
    }else{

        $getItem = $_GET["item"];

        $id = $getItem;

        $rs = $functions->search("orders","id",$id);

        if(!$rs){
             header("location:"._HOST_."painel");
        }
        $data = $rs["data"];
        $stt_dataPed = strtotime($data);
        $codigo = $rs["id"];
        $cliente_id = $rs["client_id"];
        $cliente = $functions->search("clients","id",$cliente_id);
        $cliente_nome = $cliente["nome"]. " ".$cliente["sobrenome"];

        $valor = $rs["valor"];
        $vendedor_id = $rs["seller_id"];
        $vendedor = $functions->search("users","id",$vendedor_id);
        $vendedor_nome = $vendedor["user"];

        $status = $rs["status"];
        $obs = $rs["observacoes"];

    }


  ?>
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
		<div class="py-2 pr-3 flex">
			<h1 class="m-0 text-dark bold f30">Pedido </h1>
		</div>
        <div class="flex-fill py-2 text-left">
          <a href="painel" class="  btn btn-xs btn-outline-primary">(Ver Todos)</a>
        </div>
	  </nav>
      <!-- /.navbar -->
	  <?php include('client_sidebar.php'); ?>


	  <div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<div class="content-header">
		  <div class="container-fluid">
              <div class="row">
                  <div class="col-sm-12">
                      <div class="clr h10"></div>
                      <div class="card filter ">
                          <div class="d-block">
                              <div class="card-header pd20">
                                  <h3 class="card-title f20"><strong><i class="nav-icon far fa-tag f14 "></i>&nbsp;&nbsp;Nro. <?php echo $codigo; ?></strong></h3>
                                  <div class="card-tools">
                                      <a class="preto" data-toggle="collapse" href="#headerPedido" role="button" aria-expanded="false" aria-controls="headerPedido"><i class="nav-icon fas fa-sort f14 bt"></i></a>
                                  </div>
                              </div>
                              <div class="card-body collapse show pdh10 " id="headerPedido">
                                  <div class="row">
                                      <div class="col-md-6 px-5 pdb20">
                                          <div class="row">
                                              <table class="table table-borderless">
                                                  <tbody>
                                                  <tr class="">
                                                      <td class="align-middle py-3 pl-1"><strong>Data:</strong> <?php echo date("d/m/Y",$stt_dataPed); ?></td>
                                                  </tr>
                                                  </tbody>
                                              </table>
                                          </div>

                                          <div class="row bdt1">
                                              <table class="table table-borderless">
                                                  <tbody>
                                                  <tr class="">
                                                      <td class="align-middle py-3 pl-1"><strong>Cliente:</strong> <?php echo $cliente_nome; ?></td>
                                                  </tr>
                                                  </tbody>
                                              </table>
                                          </div>

                                          <div class="row bdt1 bdb1">
                                              <table class="table table-borderless">
                                                  <tbody>
                                                  <tr class="">
                                                      <td class="align-middle py-3 pl-1"><strong>Vendedor:</strong> <?php echo $vendedor_nome; ?></td>
                                                  </tr>
                                                  </tbody>
                                              </table>
                                          </div>




                                      </div>
                                      <div class="col-md-6 px-5">

                                          <div class="row  bdb1">
                                              <table class="table table-borderless">
                                                  <tbody>
                                                  <tr class="">
                                                      <td class="align-middle py-3 pl-1"><strong>Status do Pedido:</strong> <?php echo $status; ?></td>
                                                  </tr>
                                                  </tbody>
                                              </table>
                                          </div>

                                          <div class="row  bdb1 ">
                                              <table class="table table-borderless">
                                                  <tbody>
                                                  <tr class="">
                                                      <td class="align-middle py-3 pl-1"><strong>Valor Total:</strong> R$ <?php echo number_format($valor, 2, ",","."); ?></td>
                                                  </tr>
                                                  </tbody>
                                              </table>
                                          </div>
                                          <?php if($obs){ ?>
                                          <div class="row ">
                                              <table class="table table-borderless">
                                                  <tbody>
                                                  <tr class="">
                                                      <td class="align-middle py-3 pl-1">
                                                          <strong>Observações:</strong><br>
                                                          <?= $obs ?>
                                                      </td>
                                                  </tr>
                                                  </tbody>
                                              </table>
                                          </div>
                                          <?php } ?>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div><!-- /.row -->
		  </div><!-- /.container-fluid  -->
		</div>
		<!-- /.content-header   -->
		<!-- Main content -->
		<section class="content">
		  <div class="container-fluid">

			<div class="row">
			  <div class="col-12">
				<?php echo $functions->getClientOrderProducts($codigo);?>

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

    function addProduto(){
        $('#modal_add_produto').on('shown.bs.modal', function () {
            //$('#produto').trigger('focus');
        })
        $('#modal_add_produto').modal('show');
    }

	$(document).ready(function() {

        $("#btn_add_produto").click(function(){
            addProduto();
        });
        $("#btn_faturar_pedido").click(function(){
            let pedido ='<?= $getItem ?>';
            console.log(pedido);
            getConfirmFaturamento(pedido);
        });

        $("#btn_act_add_produto").click(function(){
            let pedido = <?= $id ?>;
            let produto = $("#produto").val();
            let qtde = $("#qtde").val();
            setOrderProduct(produto, qtde, pedido);
        });


		var oTable = $("#contentDataTable").DataTable({
			"ordering":false,
            "paging":false,
            "searching":false,
			"info":false,
			"language": {
				"zeroRecords": "Ops! Nenhum item encontrado",
				"infoEmpty": "Ops! Nenhum registro encontrado",
			}
		})
	})



</script>
</body>
</html>
