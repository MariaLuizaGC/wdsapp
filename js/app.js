// JavaScript Document
$(document).ready(function() {
	
	$('#modal_loading').on('shown.bs.modal', function (e) {
		var hideLoading = $('#hideLoading').val();
	
		if(hideLoading == 1){
			e.stopPropagation();
			loading('hide');
		}
	});
		
	$('#modal_loading').on('hidden.bs.modal', function (e) {
		$('#hideLoading').val('');
	});
	
	
	$('#modal_mov').on('shown.bs.modal', function () {
		$('#amount').focus();
	});
	
	
	$("#form_mov").on( 'submit', function( event ) {
	 event.preventDefault();
	 setMov();
	});
	
	
	$("#mailForm").on( 'submit', function( event ) {
	 event.preventDefault();
	 setMail();
	});
	
	
	$("#apiForm").on( 'submit', function( event ) {
	 event.preventDefault();
	 setApi();
	});
	
	$('.modal').on('show.bs.modal', function(){ // detecta abertura da model
	   var modS = $('.modal').not($(this)), // seleciona todas as modais menos a que foi aberta
		   modZ = 0; // variável para comparar os z-index das modais e armazenar a que tiver o maior
	   modS.each(function(){ // loop nas modais
		  var zIdx = $(this).css('z-index'); // modal atual do loop
		  if(zIdx >= modZ){ // vejo se o z-index da modal do loop é maior ou igual do que a variável
			 modZ = parseInt(zIdx)+1; // se for maior ou igual, somo +1 ao valor 
		  }
	   });
	   $(this).css('z-index', modZ); // aplico o valor ao z-index da modal aberta
	});
	
})

loading = function(act){
	
	if(act == 'show'){
		$('#modal_loading').modal('show');
	}else if(act == 'hide'){
		$('#hideLoading').val(1);
		$('#modal_loading').modal('hide');	
	}
}

logoff = function(){
	$.post("logoff.php","",function(data){
		if (data == '1'){
			window.location.href = "./login";
		}else{
			$('#modal_alert').find('.modal-title').html('Atenção');
			$('#modal_alert').find('.modal-body').html(data);
			$('#modal_alert').modal('show');
			
		}	
	});
}

clientLogoff = function(){
	$.post("logoff.php","",function(data){
		if (data == '1'){
			window.location.href = "./acesso";
		}else{
			$('#modal_alert').find('.modal-title').html('Atenção');
			$('#modal_alert').find('.modal-body').html(data);
			$('#modal_alert').modal('show');

		}
	});
}

sendPassword = function(){
	loading('show');
	$.post("sendTokenNewPass.php", $("#datauser").serialize(),
		function(data){
			loading('hide');
			if(data == "success"){
				$('#modal_alert').find('.modal-title').html('Solicitação Realizada');
				$('#modal_alert').find('.modal-body').html('Uma solicitação para gerar uma nova senha de acesso foi enviada para o seu endereço de e-mail.');
				$('#modal_alert').modal('show');
			}else{
				$('#modal_alert').find('.modal-title').html('Atenção');
				$('#modal_alert').find('.modal-body').html(data);
				$('#modal_alert').modal('show');
			}
		}
	);
}

sendClientPassword = function(email){
	loading('show');
	$.post("sendClientNewPass.php",$("#datauser").serialize(),
		function(data){
			loading('hide');
			if(data == "success"){
				$('#modal_alert').find('.modal-title').html('Solicitação Realizada');
				$('#modal_alert').find('.modal-body').html('Uma solicitação para gerar uma nova senha de acesso foi enviada para o seu endereço de e-mail.');
				$('#modal_alert').modal('show');
			}else{
				$('#modal_alert').find('.modal-title').html('Atenção');
				$('#modal_alert').find('.modal-body').html(data);
				$('#modal_alert').modal('show');
			}
		}
	);
}

sendTokenUser = function(email){
	loading('show');
	$.post("sendTokenUser.php",{email:email},function(data){
		loading('hide');
		if(data == "success"){

			$('#modal_alert').find('.modal-title').html('Ação Concluída');
			$('#modal_alert').find('.modal-body').html('Token de acesso Enviado com Sucesso');
			$('#modal_alert').modal('show');
		}else{

			$('#modal_alert').find('.modal-title').html('Atenção');
			$('#modal_alert').find('.modal-body').html(data);
			$('#modal_alert').modal('show');
		}
	});
}

sendTokenCliente = function(email){
	loading('show');
	$.post("sendTokenClient.php",{email:email},function(data){
		loading('hide');
		if(data == "success"){
			$('#modal_alert').find('.modal-title').html('Ação Concluída');
			$('#modal_alert').find('.modal-body').html('Token de acesso Enviado com Sucesso');
			$('#modal_alert').modal('show');
		}else{

			$('#modal_alert').find('.modal-title').html('Atenção');
			$('#modal_alert').find('.modal-body').html(data);
			$('#modal_alert').modal('show');
		}
	});
}

authUser = function(){
	loading('show');

	var user  = $('#user').val();
	var senha = CryptoJS.SHA256($('#senha').val()).toString();

	$.post("setUserAuth.php", {user:user, senha:senha},
		function(data){
			loading('hide');
			if (data==1){
				window.location.href = "./";
			}else{
				//$('#buttonLogin').show();
				$('#modal_alert').find('.modal-title').html('Atenção');
				$('#modal_alert').find('.modal-body').html(data);
				$('#modal_alert').modal('show');
			}
		}
	);
}


authClient = function(){	
	loading('show');

	var user  = $('#user').val();
	var senha = CryptoJS.SHA256($('#senha').val()).toString();
	
	$.post("setClientAuth.php", {user:user, senha:senha},
		function(data){
			loading('hide');
			if (data==1){
				window.location.href = "./painel";
			}else{
				//$('#buttonLogin').show();
				$('#modal_alert').find('.modal-title').html('Atenção');
				$('#modal_alert').find('.modal-body').html(data);
				$('#modal_alert').modal('show');
			}
		}
	);
}

setNovaSenha = function(){
	loading('show');

	var email  = $('#email').val();
	var senha = CryptoJS.SHA256($('#senha').val()).toString();
	var token = $('#token').val();

	$.post("setUserPass.php", {email:email, senha:senha, token:token},
		function(data){
			loading('hide');
			if (data==1){
				$('#modal_alert').find('.modal-title').html('Sucesso');
				$('#modal_alert').find('.modal-body').html("Sua senha foi alterada com sucesso. ");
				$('#modal_alert').modal('show').on('hidden.bs.modal', function(){
					window.location.href = "./login";
				})
			}else{
				$('#modal_alert').find('.modal-title').html('Atenção');
				$('#modal_alert').find('.modal-body').html(data);
				$('#modal_alert').modal('show').on('hidden.bs.modal', function(){
					location.reload();
				})
			}
		}
	);
}

setClientNovaSenha = function(){
	loading('show');

	var email  = $('#email').val();
	var senha = CryptoJS.SHA256($('#senha').val()).toString();
	var token = $('#token').val();

	$.post("setClientPass.php", {email:email, senha:senha, token:token},
		function(data){
			loading('hide');
			console.log(data);
			if (data==1){
				$('#modal_alert').find('.modal-title').html('Sucesso');
				$('#modal_alert').find('.modal-body').html("Sua senha foi alterada com sucesso. ");
				$('#modal_alert').modal('show').on('hidden.bs.modal', function(){
					window.location.href = "./acesso";
				})
			}else{
				$('#modal_alert').find('.modal-title').html('Atenção');
				$('#modal_alert').find('.modal-body').html(data);
				$('#modal_alert').modal('show').on('hidden.bs.modal', function(){
					location.reload();
				})
			}
		}
	);
}


setUser = function(){
	loading('show');
	var act = $('#act').val();
	$.post("setUser.php",$('#form_data').serialize(),
		function(data){
			loading('hide');
			if(act == 'new'){
				if(data == "success") {
					$('#modal_alert').find('.modal-title').html('Sucesso');
					$('#modal_alert').find('.modal-body').html("Acesso enviado para o novo usuário");
					$('#modal_alert').modal('show');
					$('#modal_alert').on('hidden.bs.modal', function () {
						window.location.href = 'usuarios'
					});
				}else{
					$('#modal_alert').find('.modal-title').html('Atenção');
					$('#modal_alert').find('.modal-body').html(data);
					$('#modal_alert').modal('show');

				}
			}else if(act == 'edit'){
				if(data == 1) {
					history.back();
				}else{
					$('#modal_alert').find('.modal-title').html('Atenção');
					$('#modal_alert').find('.modal-body').html(data);
					$('#modal_alert').modal('show');

				}
			}
		}
	);
}

setMail = function(){
	loading('show');
	$.post("setMail.php",$('#mailForm').serialize(),
		function(data){
			loading('hide');
			if(data == 1){
				$('#modal_alert').find('.modal-title').html('Sucesso');
				$('#modal_alert').find('.modal-body').html("Atualização Realizada");
				$('#modal_alert').modal('show');
			}else{
				$('#modal_alert').find('.modal-title').html('Atenção');
				$('#modal_alert').find('.modal-body').html(data);
				$('#modal_alert').modal('show');
				//alert(data);
			}
		}
	);
}

setApi = function(){
	loading('show');
	var act = $('#act').val();
	$.post("setApi.php",$('#apiForm').serialize(),
		function(data){
			loading('hide');
			if(data == 1){
				window.location.href = 'admin';
			}else{
				$('#modal_alert').find('.modal-title').html('Atenção');
				$('#modal_alert').find('.modal-body').html(data);
				$('#modal_alert').modal('show');
				//alert(data);
			}
		}
	);
}


getConfirm = function(id){
	$('#field_confirm').val(id);
	$('#modal_confirm').on('shown.bs.modal', function () {
	  $('#confirm').trigger('focus');
	})
	$('#modal_confirm').modal('show');
}

getConfirmFaturamento = function(id, seller){
	$('#field_confirm_faturamento').val(id);
	$('#field_order_seller').val(seller);
	$('#modal_confirm_faturamento').on('shown.bs.modal', function () {
		$('#confirm_faturamento').trigger('focus');
	})
	$('#modal_confirm_faturamento').modal('show');
}

delUser = function(id){
	$.post("setUser.php",{id:id,act:'del'},
		function(data){
			if(data == 1){
				location.reload();
			}else{
				$('#modal_alert').find('.modal-title').html('Atenção');
				$('#modal_alert').find('.modal-body').html(data);
				$('#modal_alert').modal('show');
				//alert(data);
			}
		}
	);
}

delApi = function(id){
	$.post("setApi.php",{id:id,act:'del'},
		function(data){
			if(data == 1){
				location.reload();
			}else{
				$('#modal_alert').find('.modal-title').html('Atenção');
				$('#modal_alert').find('.modal-body').html(data);
				$('#modal_alert').modal('show');
				//alert(data);
			}
		}
	);
}

setClient = function(){
	loading('show');
	var act = $('#act').val();
	$.post("setClient.php",$('#form_data').serialize(),
		function(data){
			loading('hide');
			if(data == 1){
				//alert("success");
				if(act == 'new'){
					window.location.href = 'clientes';
				}else if(act == 'edit'){
					history.back();
				}

			}else{
				$('#modal_alert').find('.modal-title').html('Atenção');
				$('#modal_alert').find('.modal-body').html(data);
				$('#modal_alert').modal('show');
				//alert(data);
			}
		}
	);
}

delCliente = function(id){
	$.post("setClient.php",{id:id,act:'del'},
		function(data){
			if(data == 1){
				location.reload();
			}else{
				$('#modal_alert').find('.modal-title').html('Atenção');
				$('#modal_alert').find('.modal-body').html(data);
				$('#modal_alert').modal('show');
				//alert(data);
			}
		}
	);
}

setProduto = function(){
	loading('show');
	var act = $('#act').val();
	$.post("setProduct.php",$('#form_data').serialize(),
		function(data){
			loading('hide');
			if(data == 1){
				//alert("success");
				if(act == 'new'){
					window.location.href = 'produtos';
				}else if(act == 'edit'){
					history.back();
				}

			}else{
				$('#modal_alert').find('.modal-title').html('Atenção');
				$('#modal_alert').find('.modal-body').html(data);
				$('#modal_alert').modal('show');
				//alert(data);
			}
		}
	);
}

delProduto = function(id){
	$.post("setProduct.php",{id:id,act:'del'},
		function(data){
			if(data == 1){
				location.reload();
			}else{
				$('#modal_alert').find('.modal-title').html('Atenção');
				$('#modal_alert').find('.modal-body').html(data);
				$('#modal_alert').modal('show');
				//alert(data);
			}
		}
	);
}


setOrder = function(){
	loading('show');
	var act = $('#act').val();
	$.post("setOrder.php",$('#form_data').serialize(),
		function(data){
			var dataArray = data.split(';');
			loading('hide');
			if(dataArray[0] == 1){
				//alert("success");
				if(act == 'new'){
					//console.log(data);
					window.location.href = 'pedido/'+dataArray[1];
				}else if(act == 'edit'){
					location.reload();
				}

			}else{
				$('#modal_alert').find('.modal-title').html('Atenção');
				$('#modal_alert').find('.modal-body').html(data);
				$('#modal_alert').modal('show');
				//alert(data);
			}
		}
	);
}

cancelOrder = function(id){
	$.post("setOrder.php",{id:id,act:'del'},
		function(data){
			if(data == 1){
				location.reload();
			}else{
				$('#modal_alert').find('.modal-title').html('Atenção');
				$('#modal_alert').find('.modal-body').html(data);
				$('#modal_alert').modal('show');
				//alert(data);
			}
		}
	);
}


setOrderProduct = function(produto, qtde, pedido){
	$.post("setOrderProduct.php",{produto:produto, qtde:qtde,pedido:pedido, act:'new'},
		function(data){
			if(data == 1){
				location.reload();
			}else{
				$('#modal_alert').find('.modal-title').html('Atenção');
				$('#modal_alert').find('.modal-body').html(data);
				$('#modal_alert').modal('show');
				//alert(data);
			}
		}
	);
}

faturarPedido = function(auth_token, pedido, seller){
	$.post("setOrder.php",{auth_token:auth_token, id:pedido, vendedor:seller, act:'faturar'},
	function(data){
			if(data == 1){
				location.reload();
			}else{
				$('#modal_alert').find('.modal-title').html('Atenção');
				$('#modal_alert').find('.modal-body').html(data);
				$('#modal_alert').modal('show');
				//alert(data);
			}
		}
	);
}

delOrderProduct = function(id){
	$.post("setOrderProduct.php",{id:id,act:'del'},
		function(data){
			if(data == 1){
				location.reload();
			}else{
				$('#modal_alert').find('.modal-title').html('Atenção');
				$('#modal_alert').find('.modal-body').html(data);
				$('#modal_alert').modal('show');
				//alert(data);
			}
		}
	);
}

updateObsOrder = function(auth_token, order, obs = ""){
	$.post("setOrder.php",{auth_token:auth_token, id:order, obs:obs, act:"edit"},
		function(data){
			if(data == 1) {
				location.reload();
			}else{
				$('#modal_alert').find('.modal-title').html('Atenção');
				$('#modal_alert').find('.modal-body').html(data);
				$('#modal_alert').modal('show');
				//alert(data);
			}
		}
	);
}

updateSellerOrder = function(auth_token, order, seller = ""){
	$.post("setOrder.php",{auth_token:auth_token, id:order, vendedor:seller, act:"edit"},
		function(data){
			if(data != 1){
				$('#modal_alert').find('.modal-title').html('Atenção');
				$('#modal_alert').find('.modal-body').html(data);
				$('#modal_alert').modal('show');
				//alert(data);
			}
		}
	);
}

viewApi = function(source){
	$.post("view_api_data.php", {source:source},
		function(data){
			if (data){
				$('#content_api').html(data)
			}
		}
	);
	return false;
}