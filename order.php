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

  <title>WDS App | Pedido</title>
  <?php include_once 'controllers/header.php'; ?>
  <?php echo $meta_tags; ?>
  <?php echo $stylesheet; ?>
  <?php echo $js; ?>
  <?php


    if(!$_GET["item"]){
        header("location:"._HOST_);
    }else{


        $rs = $functions->search("orders","id",$_REQUEST["item"]);


        if(!$rs){
             header("location:"._HOST_."pedidos");
        }
        $id = $rs["id"];
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
          <a href="pedidos" class="  btn btn-xs btn-outline-primary">(Ver Todos)</a>
        </div>
        <div class="flex p-2 text-right ">
          <a href="pedido/novo" class="btn btn-sm btn-outline-danger"><span class="btn-label">Novo Pedido<span class="cinza">&nbsp;&nbsp;|&nbsp;&nbsp;</span></span><i class="nav-icon fas fa-plus f12"></i></a>
        </div>
        <?php
          if($status == "Aberto"){
        ?>
          <div class="flex p-2 text-right ">
              <button id="btn_add_produto" class="btn btn-sm btn-outline-primary"><span class="btn-label">Adicionar Produto<span class="cinza">&nbsp;&nbsp;|&nbsp;&nbsp;</span></span><i class="nav-icon fas fa-plus f12"></i></button>
          </div>
          <div class="flex p-2 text-right ">
              <button id="btn_importar_produtos" class="btn btn-sm btn-outline-secondary"><span class="btn-label">Importar Produtos<span class="cinza">&nbsp;&nbsp;|&nbsp;&nbsp;</span></span><i class="nav-icon fas fa-plus f12"></i></button>
          </div>
          <div class="flex p-2 text-right ">
              <button id="btn_faturar_pedido" class="btn btn-sm btn-outline-success"><span class="btn-label">Faturar Pedido<span class="cinza">&nbsp;&nbsp;|&nbsp;&nbsp;</span></span><i class="nav-icon fas fa-dollar-sign f12"></i></button>
          </div>

          <?php } ?>

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

                                          <div class="row bdt1">
                                              <table class="table table-borderless">
                                                  <tbody>
                                                  <tr class="">
                                                      <td class="align-middle py-3 pl-1"><strong>Vendedor:</strong>
                                                          <?php if($userLevel["id"] == 1 &&  $status == "Aberto"){
                                                              echo '
                                                                <select class="custom-select mt-2" id="vendedor" name="vendedor"  >
                                                                    '.$functions->selectSeller($vendedor_id).'
                                                                </select>
                                                              ';
                                                          }else{
                                                              echo $vendedor_nome.'<input type="hidden"  id="vendedor" name="vendedor" value="'.$vendedor_id.'">';
                                                          } ?>
                                                      </td>
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

                                          <div class="row ">
                                              <table class="table table-borderless">
                                                  <tbody>
                                                  <tr class="">
                                                      <td class="align-middle py-3 pl-1">
                                                          <strong>Observações:</strong>
                                                          <?php if($status == "Aberto"){ ?>
                                                          <a href="#" id="btn_edit_obs" class="a-default f12 pl-1"><i class="nav-icon far fa-edit"></i></a>&nbsp;
                                                          <?php } ?>
                                                          <br>
                                                          <?= $obs ?>
                                                      </td>
                                                  </tr>
                                                  </tbody>
                                              </table>
                                          </div>

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
				<?php echo $functions->getOrderProducts($codigo);?>

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
                    <button type="button" data-dismiss="modal" class="btn btn-warning" id="confirm" onclick="delOrderProduct($('#field_confirm').val())">Confirmar</button>
                    <button type="button" data-dismiss="modal" class="btn btn-danger">Cancelar</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modal_confirm_faturamento" tabindex="-1" role="dialog" aria-labelledby=" Mensagem" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content bg-danger">
                <div class="modal-body">
                    É necessário confirmar esta operação.
                    <input type="hidden" class="field_confirm" id="field_confirm_faturamento" value="">
                    <input type="hidden" class="field_confirm" id="field_order_seller" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-warning" id="confirm_faturamento" onclick="faturarPedido('<?= base64_encode($_SESSION["id_user_WDSApp_session"]) ?>', $('#field_confirm_faturamento').val(),$('#field_order_seller').val())">Confirmar</button>
                    <button type="button" data-dismiss="modal" class="btn btn-danger">Cancelar</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modal_add_produto" tabindex="-1" role="dialog" aria-labelledby="Selecione um produto" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered  modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Adicionar produto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-left">
                    <div class="form-row">
                        <div class="form-group col-12">
                            <label for="produto" aria-label="Produto">Produto*</label>
                            <select id="produto" name="produto" class="custom-select">
                                <?= $functions->selectProducts() ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-12">
                            <label for="qtde" aria-label="Quantidade">Quantidade*</label>
                            <input type="text" id="qtde" name="qtde" class="form-control" value="1">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btn_act_add_produto" class="btn btn-primary" data-dismiss="modal" >Adicionar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_importar_produtos" tabindex="-1" role="dialog" aria-labelledby="Selecione um arquivo XML" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered  modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Importar produtos via XML</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-left">
                    <div class="form-row">
                        <div class="form-group col-12">
                            <label for="file" aria-label="Selecione um arquivo XML">Selecione o arquivo XML</label>
                            <input type="file" class="" name="file"  id="file">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btn_act_importar_produtos" class="btn btn-primary" data-dismiss="modal" >Importar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_edit_obs" tabindex="-1" role="dialog" aria-labelledby="Observações" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered  modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Observações</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-left">
                    <div class="form-row">
                        <div class="form-group col-12">
                                <textarea rows="4"  id="obs" name="obs" class="form-control col-12 mt-2"><?= $obs ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btn_act_edit_obs" class="btn btn-primary" data-dismiss="modal" >Salvar</button>
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

        $("#btn_add_produto").click(function(event){
            event.preventDefault();
            $('#modal_add_produto').modal('show');
        });
        $("#btn_importar_produtos").click(function(event){
            event.preventDefault();
            $('#modal_importar_produtos').modal('show');
        });
        $("#btn_edit_obs").click(function(event){
            event.preventDefault();
            $('#modal_edit_obs').modal('show');
        });

        $("#btn_faturar_pedido").click(function(){
            let pedido ='<?= $id ?>';
            let seller = $("#vendedor").val();
            getConfirmFaturamento(pedido, seller);
        });
        $("#btn_act_add_produto").click(function(){
            let pedido = <?= $id ?>;
            let produto = $("#produto").val();
            let qtde = $("#qtde").val();
            setOrderProduct(produto, qtde, pedido);
        });

        $("#btn_act_importar_produtos").click(function(){
            let pedido = <?= $id ?>;

                var file_data = $('#file').prop('files')[0];
                var form_data = new FormData();
                form_data.append('file', file_data);
                form_data.append('pedido', pedido);

                $.ajax({
                    type: "POST",
                    url: "setImportOrderProducts.php",
                    dataType: 'text',
                    data: form_data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function( response )
                    {
                        if(response == 1){
                            location.reload();
                        }else{
                            $('#modal_alert').find('.modal-title').html('Atenção');
                            $('#modal_alert').find('.modal-body').html(response);
                            $('#modal_alert').modal('show');

                        }
                    }
                });
                return false;
        });

        $("#vendedor").change(function(){
            let pedido ='<?= $id ?>';
            //console.log($(this).val());
            let auth_token = '<?= base64_encode($_SESSION["id_user_WDSApp_session"]) ?>';
            updateSellerOrder(auth_token, pedido, $(this).val());
        });
        $("#btn_act_edit_obs").click(function(){
            let pedido ='<?= $id ?>';
            let auth_token = '<?= base64_encode($_SESSION["id_user_WDSApp_session"]) ?>';
            updateObsOrder(auth_token, pedido, $('#obs').val());
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
