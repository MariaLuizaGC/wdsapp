<?php
include_once 'controllers/session_control.php';
include_once 'config/connect.php';
include_once 'controllers/model.php';
include_once 'config/app.php';


class functions extends connect{

    function __construct(){
        $session = new session_control();
    }
	
	function search($tabela, $campo = "", $id = ""){
	
		$conn = new connect();

		// echo $conn;
		// exit();
		
		if($campo !=''){
			$query = $conn->query("SELECT * FROM ".$tabela." where ".$campo." = '".$id."' LIMIT 1");
		}else{
			$query = $conn->query("SELECT * FROM ".$tabela);
		}
		
		return $conn->fetch_array($query);

	}

	function select_box_uf($uf = ""){
		$conn = new connect();

		$sql = "SELECT * FROM uf order by uf_id";
		$query = $conn->query($sql);

		if(!$uf){
			$return = '<option value="" selected="selected">UF*</option>';
		}

		while($rs = $conn->fetch_array($query)){

			if ($rs["uf_sigla"] == $uf){
				$selected  = 'selected="selected"';
			}else{
				$selected  = '';
			}


			$return .= '<option value="'.$rs["uf_sigla"].'" '.$selected.' >'.utf8_encode($rs["uf_sigla"]).'</option>';

		}

		return $return;
	}

	function getMailData(){
		$conn = new connect();
		
		$query = $conn->query("SELECT * FROM config");

		return $conn->fetch_array($query);
		
	}
	
	function authUser($user, $password){
	
		$array_data = [
			':user' => $user,
		];

		$conn = new connect();
        
		$sql = "SELECT * FROM users where email = :user";
		$query = $conn->query($sql, $array_data);
		$result = $conn->fetch_array($query);

		if($result){

			$login_attempts = 0;
			$time_block = 0;

			if($result["login_time_block"] > time()){
				$time_block = $result["login_time_block"];
				$minutes_block = ($time_block - time()) / 60;
				$minutes_block = str_replace(",", ".", $minutes_block);
				$minutes_block = ceil($minutes_block);

				$return = [
					"return" => false,
					"message" => "Múltiplas tentativas de acesso detectadas. Tente novamente após ".$minutes_block." minuto(s)."
				];
			}
			else{
				$salt = functions::search("hashu","ref",$result["id"]);
				if($salt){
					$passwordHashed = hash('sha256',md5($salt["hash"] . $password));
	
					if($passwordHashed == $result["senha"]){						
						$return = [
							"return" => true,
							"data" => $result
						];	
					}else{

						$login_attempts = $result["login_attempts"];
						$login_attempts++;

						if($login_attempts >= 5){
							$time_block = time() + 180;
						}

						$return = [
							"return" => false,
							"message" => "E-mail ou senha incorretos."
						];						
					}
				}
				else
				{
					$return = [
						"return" => false,
						"message" => "E-mail ou senha incorretos."
					];
				}
			}

			$qry = "UPDATE users SET login_attempts = ".$login_attempts.", login_time_block = ".$time_block." WHERE id = ".$result["id"];
			$model = new model();
			$rsExec = $model->model_exec($qry);
		}
		else
		{
			$return = [
						"return" => false,
						"message" => "E-mail ou senha incorretos."
					];
		}

		return $return;
	}

	function clientAuth($user, $password){

		$array_data = [
			':user' => $user,
		];

		$conn = new connect();
		// é feito o teste na tela de login e no campo password ao colocar ' or 1=1#' acessa normalmente o sistema
        // $sql = "SELECT * FROM clients where email = '".$user."' and password = '".$password."'";
        
		$sql = "SELECT * FROM clients where email = :user";
		$query = $conn->query($sql, $array_data);
		$result = $conn->fetch_array($query);

		if($result){
			$login_attempts = 0;
			$time_block = 0;

			if($result["login_time_block"] > time()){
				$time_block = $result["login_time_block"];
				$minutes_block = ($time_block - time()) / 60;
				$minutes_block = str_replace(",", ".", $minutes_block);
				$minutes_block = ceil($minutes_block);

				$return = [
					"return" => false,
					"message" => "Múltiplas tentativas de acesso detectadas. Tente novamente após ".$minutes_block." minuto(s)."
				];
			}
			else{
				$salt = functions::search("hashc","ref",$result["id"]);
				if($salt){
					$passwordHashed = hash('sha256',md5($salt["hash"] . $password));

					if($passwordHashed == $result["password"]){
						$return = [
							"return" => true,
							"data" => $result
						];	
					}else{
						$login_attempts = $result["login_attempts"];
						$login_attempts++;

						if($login_attempts >= 5){
							$time_block = time() + 180;
						}

						$return = [
							"return" => false,
							"message" => "E-mail ou senha incorretos."
						];	
					}
				}
				else
				{
					$return = [
						"return" => false,
						"message" => "E-mail ou senha incorretos."
					];
				}
			}

			$qry = "UPDATE clients SET login_attempts = ".$login_attempts.", login_time_block = ".$time_block." WHERE id = ".$result["id"];
			$model = new model();
			$rsExec = $model->model_exec($qry);
		}
		else
		{
			$return = [
						"return" => false,
						"message" => "E-mail ou senha incorretos."
					];
		}		

		return $return;

	}

	function selectLevels($id = null){

		$levels = array(
			0=>array("id"=>"1","level"=>"Administrador"),
			1=>array("id"=>"2" ,"level"=>"Colaborador")
		);
		$x = 0;
		foreach ($levels as $level){

			if($x==0 && !$id){
				$selected  = 'selected="selected"';
			}elseif ($level["id"] == $id){
				$selected  = 'selected="selected"';
			}else{
				$selected  = '';
			}


			$return .= '<option value="'.$level["id"].'" class="pd10" '.$selected.' >'.utf8_encode($level["level"]).'</option>';

			$x++;
		}

		return $return;
	}

	function selectClient($id = null){
		$conn = new connect();

		$qry = "SELECT * FROM clients order by nome";
		$query = $conn->query($qry);


		$x = 0;

		while($rs = $conn->fetch_array($query)){

			if($x==0 && !$id){
				$selected  = 'selected="selected"';
				$return .= '<option value="" class="pd10" '.$selected.'></option>';
				$selected  = '';

			}elseif ($rs["id"] == $id){
				$selected  = 'selected="selected"';
			}else{
				$selected  = '';
			}


			$return .= '<option value="'.$rs["id"].'" class="pd10" '.$selected.' >'.($rs["nome"]." ".$rs["sobrenome"]).'</option>';

			$x++;
		}

		return $return;

	}

	function selectSeller($id = null){
		$conn = new connect();

		$qry = "SELECT * FROM users order by user";
		$query = $conn->query($qry);


		$x = 0;

		while($rs = $conn->fetch_array($query)){

			if($x==0 && !$id){
				$selected  = 'selected="selected"';
				$return .= '<option value="" class="pd10" '.$selected.'></option>';
				$selected  = '';

			}elseif ($rs["id"] == $id){
				$selected  = 'selected="selected"';
			}else{
				$selected  = '';
			}


			$return .= '<option value="'.$rs["id"].'" class="pd10" '.$selected.' >'.($rs["user"]).'</option>';

			$x++;
		}

		return $return;

	}

	function selectProducts($id = null){
		$conn = new connect();

		$qry = "SELECT * FROM products order by produto";
		$query = $conn->query($qry);


		$x = 0;

		while($rs = $conn->fetch_array($query)){

			if($x==0 && !$id){
				$selected  = 'selected="selected"';
				$return .= '<option value="" class="pd10" '.$selected.'>Selecione um Produto</option>';
				$selected  = '';

			}elseif ($rs["id"] == $id){
				$selected  = 'selected="selected"';
			}else{
				$selected  = '';
			}


			$return .= '<option value="'.$rs["id"].'" class="pd10" '.$selected.' >'.$rs["produto"].'</option>';

			$x++;
		}

		return $return;

	}

	function getLevel($id){
		
		$levels = array(
			0=>array("id"=>"1","level"=>"Administrador"),
			1=>array("id"=>"2" ,"level"=>"Colaborador")
		);
		foreach ($levels as $level){
			
			if ($level["id"] == $id){
				$return = utf8_encode($level["level"]);
				break;
			
			}		
		}

		return $return;
	}

	function checkToken($token, $email){
	
		$conn = new connect();
		
		$query = $conn->query("SELECT * FROM users where email = '".$email."'" );
		$rsRow = $conn->row($query);
				
		if($rsRow == 1){
			$rs = $conn->fetch_array($query);
			$id = $rs["id"];
			$temporary_salt = $rs["temporary_salt"];
			$chave = $email.$temporary_salt;
			$chave = hash('sha256',$chave);
		
			if($token == $chave && $temporary_salt > time()){
				return $id;
			}
		}
	}

	function checkClientToken($token, $email){

		$conn = new connect();

		$query = $conn->query("SELECT * FROM clients where email = '".$email."'" );
		$rsRow = $conn->row($query);
		
		if($rsRow == 1){
			$rs = $conn->fetch_array($query);
			$id = $rs["id"];
			$temporary_salt = $rs["temporary_salt"];
			$chave = $email.$temporary_salt;
			$chave = hash('sha256',$chave);

			if($token == $chave && $temporary_salt > time()){
				return $id;
			}
		}
	}

	function createPassword($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = false){
		$lmin = 'abcdefghijklmnopqrstuvwxyz';
		$lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$num = '1234567890';
		$simb = '!@#$%*-';

		$password = '';
		$caracteres = '';

		$caracteres .= $lmin;
		if ($maiusculas) $caracteres .= $lmai;
		if ($numeros) $caracteres .= $num;
		if ($simbolos) $caracteres .= $simb;

		$len = strlen($caracteres);

		for ($n = 1; $n <= $tamanho; $n++) {
			$rand = mt_rand(1, $len);
			$password .= $caracteres[$rand-1];
		}

		return $password;
	}
	
	function getUserLevel(){
		
		if(isset($_SESSION["id_user_WDSApp_session"])){

			$conn = new connect();

			$query = $conn->query("SELECT * FROM users where id = '".$_SESSION["id_user_WDSApp_session"]."' LIMIT 1");
			$rsUser = $conn->fetch_array($query);

			$user_level = $rsUser["level"];

			$queryLevel = $conn->query("SELECT * FROM users_level where id = ".$user_level." LIMIT 1");
			$rsUserLevel = $conn->fetch_array($queryLevel);

			return $rsUserLevel;

		}
	
	}

	function getUsers(){
		$conn = new connect();
		
		$qry = "SELECT * FROM users";

		$card_title = '<h3 class="card-title f20" aria-label="Todos os Registros"><strong><i class="fas fa-list mr-1 f16"></i> Todos os Registros</strong></h3>';

		$query = $conn->query($qry);
		$rows = $conn->row($query);
		
		
		if($rows){

			
			$return = '
				<div class="card content">
				  
				  <!-- /.card-header -->
				  <div class="card-body table-responsive p-0">
					<table class="table table-hover" id="contentDataTable">
					  <thead>
						<tr>
						  <th>Nome</th>
						  <th>Email</th>
						  <th>Nível de Acesso</th>
						  <th class="text-right">Opções</th>
						  
						</tr>
					  </thead>
					  <tbody>
			';
		
			while($rs = $conn->fetch_array($query)){

				$id = $rs["id"];
				$nome = $rs["user"];
				$email = $rs["email"];
				$level = $rs["level"];
				
				$return .= '
					 <tr>
						  <td>'.$nome.'</td>
						  <td>'.$email.'</td>
						  <td>'.functions::getLevel($level).'</td>
						  
						  <td class="text-right f12">
							<a href="usuarios/edit/'.$id.'" data-password="'.$rs["senha"].'" style="padding: 2px" class="a-default"><i class="nav-icon far fa-edit"></i></a>&nbsp;
				';
				if($_SESSION["id_user_WDSApp_session"]!=$id){
					$return .= '
							<a onclick="getConfirm(\''.$id.'\');" style="padding: 2px" class="a-danger bt"><i class="nav-icon far fa-trash-alt  text-danger"></i></a>&nbsp;
					';
				}else{
					$return .= '<i class="nav-icon far fa-trash-alt text-muted" style="padding: 2px"></i>&nbsp;';
				}
					$return .= '
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
		return $return;

	}

	function getClients(){
		$conn = new connect();

		$qry = "SELECT * FROM clients";


		$card_title = '<h3 class="card-title f20" aria-label="Todos os Registros"><strong><i class="fas fa-list mr-1 f16"></i> Todos os Registros</strong></h3>';


		$query = $conn->query($qry);
		$rows = $conn->row($query);


		if($rows){


			$return = '
				<div class="card content">
				  
				  <!-- /.card-header -->
				  <div class="card-body table-responsive p-0">
					<table class="table table-hover" id="contentDataTable">
					  <thead>
						<tr>
						  <th>ID</th>
						  <th>Nome</th>
						  <th>Email</th>
						  <th>Telefone</th>
						  <th>Localização</th>
						  <th class="text-right">Opções</th>
						  
						</tr>
					  </thead>
					  <tbody>
			';

			while($rs = $conn->fetch_array($query)){

				$id = $rs["id"];
				$nome = $rs["nome"]. " ".$rs["sobrenome"];
				$email = $rs["email"];
				$telefone = $rs["telefone"];
				$local = $rs["cidade"]." - ".$rs["estado"];


				$return .= '
					 <tr>
						  <td>'.$id.'</td>
						  <td>'.$nome.'</td>
						  <td>'.$email.'</td>
						  <td>'.$telefone.'</td>
						  <td>'.$local.'</td>
						  
						  <td class="text-right f12">
							<a href="cliente/edit/'.$id.'" style="padding: 2px" class="a-default"><i class="nav-icon far fa-edit"></i></a>&nbsp;
						    <a onclick="getConfirm(\''.$id.'\');" style="padding: 2px" class="a-danger bt"><i class="nav-icon far fa-trash-alt  text-danger"></i></a>&nbsp;
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
		return $return;

	}

	function getProducts($userLevel){
		$conn = new connect();
		$options_label = "";
		if($userLevel == 1){
			$options_label = '<th class="text-right">Opções</th>';
		}

		$qry = "SELECT * FROM products";


		$card_title = '<h3 class="card-title f20" aria-label="Todos os Registros"><strong><i class="fas fa-list mr-1 f16"></i> Todos os Registros</strong></h3>';


		$query = $conn->query($qry);
		$rows = $conn->row($query);


		if($rows){


			$return = '
				<div class="card content">
				  
				  <!-- /.card-header -->
				  <div class="card-body table-responsive p-0">
					<table class="table table-hover" id="contentDataTable">
					  <thead>
						<tr>
						  <th>ID</th>
						  <th>Produto</th>
						  <th>Valor</th>
						  '.$options_label.'
						  
						</tr>
					  </thead>
					  <tbody>
			';

			while($rs = $conn->fetch_array($query)){


				$id = $rs["id"];
				$produto = $rs["produto"];
				$valor = $rs["valor"];
				$options = "";

				if($userLevel == 1){
					$options = '
						<td class="text-right f12">
							<a href="produto/edit/'.$id.'" style="padding: 2px" class="a-default"><i class="nav-icon far fa-edit"></i></a>&nbsp;
							<a onclick="getConfirm(\''.$id.'\');" style="padding: 2px" class="a-danger bt"><i class="nav-icon far fa-trash-alt  text-danger"></i></a>&nbsp;
						</td>
					';
				}
				$return .= '
					 <tr>
						  <td>'.$id.'</td>
						  <td>'.$produto.'</td>
						  <td style="width: 150px">R$ '.number_format($valor,2,',','.').'</td>
						  '.$options.'
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
		return $return;

	}

	function getOrders($seller = "", $status = ""){
		$conn = new connect();

        $qry = "SELECT * FROM orders ";

        if($status || $seller){
            $qry .= " where ";
        }

        if($status){
            $qry .= " status = '".$status."'";
        }

		if($seller){
            if($status)$qry .= " and ";
			$qry .= " seller_id = ".$seller;
		}

		$query = $conn->query($qry);
        return $conn->fetch_all($query);

	}

	function getClientOrders($seller){
		$conn = new connect();

		$qry = "SELECT * FROM orders where client_id = ".$seller;


		$card_title = '<h3 class="card-title f20" aria-label="Todos os Registros"><strong><i class="fas fa-list mr-1 f16"></i> Todos os Registros</strong></h3>';


		$query = $conn->query($qry);
		$rows = $conn->row($query);


		if($rows){


			$return = '
				<div class="card content">
				  
				  <!-- /.card-header -->
				  <div class="card-body table-responsive p-0">
					<table class="table table-hover" id="contentDataTable">
					  <thead>
						<tr>
						  <th>Data</th>
						  <th>Código</th>
						  <th>Valor</th>
						  <th>Status</th>
						  <th>Vendedor</th>
						</tr>
					  </thead>
					  <tbody>
			';

			while($rs = $conn->fetch_array($query)){

				$data = $rs["data"];
				$codigo = $rs["id"];
				$cliente_id = $rs["client_id"];
				$cliente = functions::search("clients","id",$cliente_id);
				$cliente_nome = $cliente["nome"]. " ".$cliente["sobrenome"];

				$valor = number_format($rs["valor"],2,",",".");
				$vendedor_id = $rs["seller_id"];
				$vendedor = functions::search("users","id",$vendedor_id);
				$vendedor_nome = $vendedor["user"];

				$status = $rs["status"];

				if($status == "Aberto"){
					$options = '<a onclick="getConfirm(\''.$codigo.'\');" class="a-danger bt"><i class="nav-icon far fa-trash-alt  text-danger"></i></a>&nbsp;';
				}else{
					$options = '<i class="nav-icon far fa-trash-alt  text-secondary"></i>&nbsp;';
				}

				$return .= '
					 <tr>
					 	  <td><a href="painel/'.$codigo.'">'.date("d/m/Y", strtotime($data)).'</a></td>
						  <td><a href="painel/'.$codigo.'">'.$codigo.'</a></td>
						  <td>'.$valor.'</td>
						   <td>'.$status.'</td>
						  <td>'.$vendedor_nome.'</td>

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
		return $return;

	}

	function getOrderProducts($order = null){

		$order_data = functions::search("orders","id",$order);
		$status = $order_data["status"];

		$conn = new connect();
		$qry = "SELECT * FROM order_products where order_id = ".$order;

		$card_title = '<h3 class="card-title f20" aria-label="Todos os Registros"><strong><i class="fas fa-list mr-1 f16"></i> Todos os Registros</strong></h3>';

		$query = $conn->query($qry);
		$rows = $conn->row($query);


		if($rows){


			$return = '
				<div class="card content">
				  
				  <!-- /.card-header -->
				  <div class="card-body table-responsive p-0">
					<table class="table table-hover" id="contentDataTable">
					  <thead>
						<tr>
						  <th>ID</th>
						  <th>Produto</th>
						  <th>Quantidade</th>
						  <th>Valor Unit.</th>
						  <th>Subtotal</th>
						  <th class="text-right">Opções</th>
						</tr>
					  </thead>
					  <tbody>
			';

			while($rs = $conn->fetch_array($query)){

				$id = $rs["id"];
				$produto_id = $rs["product_id"];
				$produto = functions::search("products","id",$produto_id);
				$produto_nome = $produto["produto"];
				$quantidade = $rs["quantidade"];
				$valor_unit = number_format($rs["valor_unit"],2,',','.');;
				$subtotal = number_format($quantidade * $rs["valor_unit"],2,',','.');
                $file = $rs["file"];

                if($file){
                    $options = '<a href="'.$file.'" target="_blank" ><i class="nav-icon fas fa-link  text-primary"></i></a>&nbsp;&nbsp;';
                }else{
                    $options = '<i class="nav-icon fas fa-link  text-secondary"></i>&nbsp;&nbsp;';
                }

				if($status == "Aberto"){
					$options .= '&nbsp;<a onclick="getConfirm(\''.$id.'\');" class="a-danger bt"><i class="nav-icon far fa-trash-alt  text-danger"></i></a>&nbsp;';
				}else{
					$options .= '&nbsp;<i class="nav-icon far fa-trash-alt  text-secondary"></i>&nbsp;';
				}


				$return .= '
					 <tr>
					 	  <td>'.$produto_id.'</td>
						  <td>'.$produto_nome.'</td>
						  <td>'.$quantidade.'</td>
						  <td>'.$valor_unit.'</td>
						  <td>'.$subtotal.'</td>
						  
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
			$return = 'Adicione produtos ao pedido';
		}
		return $return;

	}

	function getClientOrderProducts($order = null){

		$order_data = functions::search("orders","id",$order);
		$status = $order_data["status"];

		$conn = new connect();
		$qry = "SELECT * FROM order_products where order_id = ".$order;

		$card_title = '<h3 class="card-title f20" aria-label="Todos os Registros"><strong><i class="fas fa-list mr-1 f16"></i> Todos os Registros</strong></h3>';

		$query = $conn->query($qry);
		$rows = $conn->row($query);


		if($rows){


			$return = '
				<div class="card content">
				  
				  <!-- /.card-header -->
				  <div class="card-body table-responsive p-0">
					<table class="table table-hover" id="contentDataTable">
					  <thead>
						<tr>
						  <th>ID</th>
						  <th>Produto</th>
						  <th>Quantidade</th>
						  <th>Valor Unit.</th>
						  <th>Subtotal</th>
						</tr>
					  </thead>
					  <tbody>
			';

			while($rs = $conn->fetch_array($query)){

				$id = $rs["id"];
				$produto_id = $rs["product_id"];
				$produto = functions::search("products","id",$produto_id);
				$produto_nome = $produto["produto"];
				$quantidade = $rs["quantidade"];
				$valor_unit = number_format($rs["valor_unit"],2,',','.');;
				$subtotal = number_format($quantidade * $rs["valor_unit"],2,',','.');

				$return .= '
					 <tr>
					 	  <td>'.$produto_id.'</td>
						  <td>'.$produto_nome.'</td>
						  <td>'.$quantidade.'</td>
						  <td>'.$valor_unit.'</td>
						  <td>'.$subtotal.'</td>
					</tr>
				';
			}
			$return  .= '
			 </tbody>
					</table>
			';

			$return .= '</div></div>';

		}else{
			$return = 'Adicione produtos ao pedido';
		}
		return $return;

	}

	function getSellersFee($seller){
		$conn = new connect();

		if($seller){
			$qry = "SELECT * FROM sellers_fee where seller_id = ".$seller;
			$seller_caption = '';
		}else{
			$qry = "SELECT * FROM sellers_fee";
			$seller_caption = '<th>Vendedor</th>';
		}


		$card_title = '<h3 class="card-title f20" aria-label="Todos os Registros"><strong><i class="fas fa-list mr-1 f16"></i> Todos os Registros</strong></h3>';


		$query = $conn->query($qry);
		$rows = $conn->row($query);


		if($rows){


			$return = '
				<div class="card content">
				  
				  <!-- /.card-header -->
				  <div class="card-body table-responsive p-0">
					<table class="table table-hover" id="contentDataTable">
					  <thead>
						<tr>
						  <th>Data</th>
						  <th>Pedido</th>
						  <th>Cliente</th>
						  <th>Comissão</th>
						  '.$seller_caption.'
						</tr>
					  </thead>
					  <tbody>
			';

			while($rs = $conn->fetch_array($query)){

				$data = $rs["data"];
				$codigo = $rs["order_id"];
				$cliente_id = $rs["client_id"];
				$cliente = functions::search("clients","id",$cliente_id);
				$cliente_nome = $cliente["nome"]. " ".$cliente["sobrenome"];

				$valor = number_format($rs["valor"],2,",",".");
				$vendedor_id = $rs["seller_id"];
				$vendedor = functions::search("users","id",$vendedor_id);
				$vendedor_nome = $vendedor["user"];


				if($seller){
					$seller_column = '';
				}else{
					$seller_column = ' <td>'.$vendedor_nome.'</td>';
				}

				$return .= '
					 <tr>
					 	  <td>'.date("d/m/Y", strtotime($data)).'</td>
						  <td><a href="pedido/'.$codigo.'">'.$codigo.'</a></td>
						  <td><a href="pedido/'.$codigo.'">'.$cliente_nome.'</a></td>
						  <td>'.$valor.'</td>
						  '.$seller_column.'
						 
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
		return $return;

	}

    function getApi($token, $source){
        $conn = new connect();
        $return = false;

        $qry = "SELECT * FROM api";

        $query = $conn->query($qry);
        $api = $conn->fetch_array($query);

        if($token == $api["token"]){

		switch ($source) {			
			case 'pedidos':
				$source = "orders";
				break;
			case 'comissoes':
				$source = "sellers_fee";
				break;
			default:
				$source = "";
				break;
		}	

            $qry_data = "SELECT * FROM ".$source;

            $query_data = $conn->query($qry_data);
            $data = $conn->fetch_all($query_data);

            if($data){
                $return = ["status"=> "success","data"=>$data];
            }else{
                $return = ["status"=> "error","data"=>"Data not found"];
            }

        }else{
            $return = ["status"=> "error","data"=>"Authentication Failure"];
        }
        $datetime = date("Y-m-d H:i:s");
        $datetime_log = date("Ymd");

        $log = $datetime." - ".$source." - ".$return["status"];

        if($return["status"] == "error"){
            $log .= " - ".$return["data"];
        }
        $log .= "\n";
        file_put_contents("log/" . $datetime_log . ".txt", $log, FILE_APPEND);
        return json_encode($return, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

    }
}