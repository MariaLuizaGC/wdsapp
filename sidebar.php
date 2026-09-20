<?php
include_once 'controllers/session_control.php';
include_once 'controllers/functions.php';
include_once 'controllers/header.php';

$session = new session_control();
$functions = new functions();


if(isset($_SESSION["id_user_WDSApp_session"])){

?>
<!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-light-info elevation-4">
    <!-- Brand Logo -->
    <a href="./" class="brand-link center-block ">
      <img src="imgs/logo_app.jpg" height="50px" alt="WDS App" class="img-responsive logo-xl ">
      <img src="imgs/logo_app_mini.jpg"  height="50px" alt="WDS App" class="img-responsive logo-xs">
    
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="imgs/profile_user_160x160.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <span class="d-block"><?php echo ($_SESSION["nome_user_WDSApp_session"]);?></span>
        </div>
        <div class="info"><button class="btn-xs btn-light" onClick="logoff()">sair</button></div>
      </div>
  

      <!-- Sidebar Menu -->
      <nav class="mt-2">
      <?php 
       $menu = '
        <ul class="nav nav-pills nav-sidebar flex-column nav-legacy" data-widget="treeview" role="menu" data-accordion="false">
		 ';
		  if($_SESSION["pagina"]=="index"){$active = 'active';}else{$active = '';}
		  $menu .= '
          <li class="nav-item">
            <a href="./" class="nav-link '.$active.'">
              <i class="nav-icon fas fa-boxes"></i>
              <p>
                Produtos
              </p>
            </a>
          </li>
		  ';
          if($_SESSION["pagina"]=="orders"){$active = 'active';}else{$active = '';}
          $menu .= '
          <li class="nav-item">
            <a href="./pedidos" class="nav-link '.$active.'">
              <i class="nav-icon fas fa-dolly"></i>
              <p>
                Pedidos
              </p>
            </a>
          </li>
		  ';
          if($_SESSION["pagina"]=="sellers_fee"){$active = 'active';}else{$active = '';}
          $menu .= '
          <li class="nav-item">
            <a href="./comissoes" class="nav-link '.$active.'">
              <i class="nav-icon fas fa-hand-holding-usd"></i>
              <p>
                Comissões
              </p>
            </a>
          </li>
		  ';
          if($_SESSION["pagina"]=="clientes"){$active = 'active';}else{$active = '';}
          $menu .= '
          <li class="nav-item">
            <a href="./clientes" class="nav-link '.$active.'">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Clientes
              </p>
            </a>
          </li>
		  ';


		 
											 
		  if($userLevel["id"] == 1){ 
			  if($_SESSION["pagina"]=="usuarios"){$active = 'active';}else{$active = '';}
			  $menu .= '
			  <li class="nav-item">
				<a href="usuarios" class="nav-link '.$active.'">
				  <i class="nav-icon fas fa-user"></i>
				  <p>
					Usuários
				  </p>
				</a>

			  </li>
			  ';
			  
			 
			  
			 
	      } 
		 
		  $menu .= '</ul>';
		  echo $menu;
		  ?>
        
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
<?php } ?>