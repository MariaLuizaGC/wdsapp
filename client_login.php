<?php
include_once 'controllers/session_control.php';
include_once 'controllers/functions.php';
include_once 'config/app.php';

$session = new session_control();
$functions = new functions();

$session->setSession('pagina','client-login');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once 'controllers/client_header.php'; ?>
<title>WDS App | Acesso</title>

<?php echo $meta_tags; ?>
<?php echo $stylesheet; ?>
<?php echo $js; ?>



<script type="text/javascript">

$(function() {
 
    $("#login").on( "submit", function( event ) {
      event.preventDefault();
      authUser();
    });

});

</script>

<?php  if($session->getSession('id_client_WDSApp_session')){ ?>
<script> window.location.href = "./painel"</script>
<?php } ?>

</head>

<body class="bckgdlogin">


<div class="container-fluid vertical-center">
    <div id="" class="col-sm-12 col-md-10 offset-md-1">
    	<div class="row">
           <div class="col-sm-12 col-md-6 offset-md-3 rounded text-center bckgdboxlogin">
           <div class="row">
			   <div class="col-sm-10 offset-sm-1">
			   		<div class="w-100 clr h20"></div>
					<img src="imgs/logo_app.jpg" alt="WDS App" title="WDS App" class="img-responsive center-block" />
				
					<div class="w-100 clr h40"></div>    

					<div class="row text-left">
						<div class="col-12 ">
							<form class="form" name="acesso" id="acesso" enctype="multipart/form-data" action="javascript:authClient()">
								 <div class="form-group row">
									<label for="email" class="col-sm-2 col-form-label">Email</label>
									<div class="col-sm-10">
										<input class="f16 form-control input-lg" type="email" name="user" id="user" placeholder="E-mail" required 
											value="<?php echo $_SESSION["login_email"]; ?>"
										/>
									 </div>
								 </div>  

								 <div class="clr h10"></div>  
								<div class="form-group row">
									<label for="password" class="col-sm-2 col-form-label">Senha</label>
									<div class="col-sm-10">
										<input class="col-12  f16 form-control input-lg" type="password" name="senha" id="senha" required
											value=""
											placeholder="Senha"
										/>
									</div>
								  </div>  
								  <div class="clr h10"></div>  
								  <div class="form-group">
									  <input type="submit" class="btn btn-dark f20 col-12 pd20 bold" value="LOGIN">        
								  </div>	
								  <div class="clr h20"></div>

								  <span class="f14">Esqueceu sua senha?</span>
								  <div class="clr"></div>
                                <span class="f14"><a href="<?= _HOST_ ?>acesso/novasenha" class="text-danger bt">Clique aqui</a> e solicite uma nova senha.</span>

							</form>	
						</div>
				   </div>
					<div class="validateTips text-center"></div>
					<div class="h20"></div>
				</div>
			</div>
    		<div class="clr h40"></div>
    	
     	</div>
     	<div class="w-100 clr h40"></div>

    </div>
</div>

<?php include('footer.php'); ?>
</body>
</html>