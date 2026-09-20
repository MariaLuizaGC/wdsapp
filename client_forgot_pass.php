<?php
include_once 'controllers/session_control.php';
include_once 'controllers/functions.php';
include_once 'config/app.php';

$session = new session_control();
$functions = new functions();

$session->setSession('pagina','client-pass');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<title>Solicitar nova senha | WDS App</title>
<?php include_once 'controllers/client_header.php'; ?>
<?php echo $meta_tags; ?>
<?php echo $stylesheet; ?>
<?php echo $js; ?>

</head>


<body class="bckgdlogin">


<div class="container-fluid vertical-center">
    <div id="" class="col-sm-12 col-md-10 offset-md-1">
    	<div class="row">
           <div class="col-sm-12 col-md-6 offset-md-3 rounded text-center bckgdboxlogin">
           <div class="row">
			   <div class="col-sm-10 offset-sm-1">
			   		<div class="w-100 clr h20"></div>
					<div class="row">
						<div class="col-12 text-left">

							<h1 class=" bold"><strong>Redefinição de Senha</strong></h1>
							<span class="f16 ">Informe seu email e solicite uma nova senha</span>
						</div>
					</div>
				
					<div class="w-100 clr h40"></div>    

					<div class="row text-left">
						<div class="col-12 ">
							<form class="form" name="datauser" id="datauser" enctype="multipart/form-data">
								 <div class="form-group row">
									<label for="email" class="col-sm-2 col-form-label">Email</label>
									<div class="col-sm-10">
										<input class="f16 form-control input-lg" type="email" name="email" id="email" placeholder="E-mail" required />
									 </div>
								 </div>  

								  <div class="clr h40"></div>
								  <div class="form-group">
									  <input type="submit" class="btn btn-dark f20 col-12 pd20 bold" value="Solicitar nova senha">
								  </div>	
								  <div class="clr h20"></div>
							</form>	
						</div>
				   </div>

					<div class="h20"></div>
					
				</div>
			</div>
    		<div class="clr h40"></div>
    	
     	</div>

    </div>
</div>

<?php include('footer.php'); ?>

<script type="text/javascript">
	
$(function() {

    $("#datauser").on( "submit", function( event ) {
      event.preventDefault();
      sendClientPassword();
    });

});

</script>
</body>
</html>