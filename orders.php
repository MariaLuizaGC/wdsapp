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

  <title>WDS App | Pedidos</title>
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
			<h1 class="m-0 text-dark bold f30">Pedidos</h1>
		</div>
        <div class="flex p-2 text-right ">
          <a href="pedido/novo" class="btn btn-sm btn-outline-danger"><span class="btn-label">Novo<span class="cinza">&nbsp;&nbsp;|&nbsp;&nbsp;</span></span><i class="nav-icon fas fa-plus f12"></i></a>
        </div>

	  </nav>
      <!-- /.navbar -->
	  <?php include('sidebar.php'); ?>


	  <div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<div class="content-header">
		  <div class="container-fluid">
			<div class="row">
				<div class="col-sm-12">
					<div class="clr h10"></div>
					<div class="card filter ">
						<div class="">
							<div class="card-header pd20">
								<h3 class="card-title f20"><strong data-toggle="collapse" href="#filterBody" role="button" class="bt"><i class="nav-icon fas fa-filter f14"></i>&nbsp;Filtros</strong>&nbsp; <a href="<?= _HOST_ ?>pedidos" class="  btn btn-xs btn-outline-primary">(Limpar)</a></h3>
								 <div class="card-tools">
									<a class="preto" data-toggle="collapse" href="#filterBody" role="button" aria-expanded="false" aria-controls="filterBody"><i class="nav-icon fas fa-sort f14 bt"></i></a>
								</div>
							  </div>
							  <!-- /.card-header -->
							<div class="card-body collapse hide " id="filterBody">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6 col-lg-3 py-1">
                                        <label for="filterStatus">Status</label>
                                        <select class="form-control" id="filterStatus">
                                            <option value="" selected>Todos</option>
                                            <option value="Aberto" >Aberto</option>
                                            <option value="Faturado" >Faturado</option>
                                            <option value="Cancelado" >Cancelado</option>
                                        </select>
                                    </div>
                                </div>
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
				<?php

                if($userLevel["id"] == 1){
                    $seller = "";
                }else{
                    $seller = $_SESSION["id_user_WDSApp_session"];
                }

                $conn = new connect();
                $getStatus = "";
                if(isset($_GET["status"]))$getStatus = $_GET["status"];

                $rsOrders = $functions->getOrders($seller, $getStatus);

                if($rsOrders){

                    $card_title = '<h3 class="card-title f20" aria-label="Todos os Registros"><strong><i class="fas fa-list mr-1 f16"></i> Todos os Registros</strong></h3>';

                    $return = '
                        <div class="card content">
                          
                          <!-- /.card-header -->
                          
                          <div class="card-body table-responsive p-0">
                            <table class="table table-hover" id="contentDataTable">
                              <thead>
                                <tr>
                                  <th>Data</th>
                                  <th>Código</th>
                                  <th>Cliente</th>
                                  <th>Valor</th>
                                  <th>Status</th>
                                  <th>Vendedor</th>
                                  <th class="text-right">Opções</th>
                                </tr>
                              </thead>
                              <tbody>
                    ';

                            foreach ($rsOrders as $rs){

                                $data = $rs["data"];
                                $codigo = $rs["id"];
                                $cliente_id = $rs["client_id"];
                                $cliente = $functions->search("clients","id",$cliente_id);
                                $cliente_nome = $cliente["nome"]. " ".$cliente["sobrenome"];

                                $valor = number_format($rs["valor"],2,",",".");
                                $vendedor_id = $rs["seller_id"];
                                $vendedor = $functions->search("users","id",$vendedor_id);
                                $vendedor_nome = $vendedor["user"];

                                $status = $rs["status"];

                                if($status == "Aberto"){
                                    $options = '<a onclick="getConfirm(\''.$codigo.'\');" class="a-danger bt"><i class="nav-icon far fa-trash-alt  text-danger"></i></a>&nbsp;';
                                }else{
                                    $options = '<i class="nav-icon far fa-trash-alt  text-secondary"></i>&nbsp;';
                                }

                                $return .= '
                             <tr>
                                  <td>'.date("d/m/Y", strtotime($data)).'</td>
                                  <td><a href="pedido/'.$codigo.'">'.$codigo.'</a></td>
                                  <td><a href="pedido/'.$codigo.'">'.$cliente_nome.'</a></td>
                                  <td>'.$valor.'</td>
                                   <td>'.$status.'</td>
                                  <td>'.$vendedor_nome.'</td>
                                  
                                  <td class="text-right f12">
                                    '.$options.'
                                  </td>
                            </tr>
                        ';
                            }
                            $return  .= '
                     </tbody>
                            </table>
                    ';

                    $return .= '</div></div>';

                }else{
                    $return = 'Nenhum registro encontrado';
                }
                echo $return;

                ?>

				<!-- /.card -->
			  </div>
			</div>
		  </div><!-- /.container-fluid -->
		</section>
    <!-- /.content -->
  	</div>
  </div>
<!-- /.content-wrapper -->

    <!-- Confirm modal -->


    <div class="modal fade" id="modal_confirm" tabindex="-1" role="dialog" aria-labelledby=" Mensagem" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content bg-danger">
                <div class="modal-body">
                    É necessário confirmar esta operação.
                    <input type="hidden" class="field_confirm" id="field_confirm" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-warning" id="confirm" onclick="cancelOrder($('#field_confirm').val())">Confirmar</button>
                    <button type="button" data-dismiss="modal" class="btn btn-danger">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
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

        $("#filterStatus").change(function(){
            let status = $(this).val();


            location.href = "<?=_HOST_?>pedidos/?status="+status;
        });
	})



</script>
</body>
</html>
