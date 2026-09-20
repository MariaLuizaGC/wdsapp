<?php
include_once 'controllers/session_control.php';
include_once 'controllers/functions.php';
include_once 'controllers/client_header.php';

$session = new session_control();
$functions = new functions();


if(isset($_SESSION["id_client_WDSApp_session"])){

?>
<!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-light-info elevation-4">
    <!-- Brand Logo -->
    <a href="./painel" class="brand-link center-block ">
      <img src="imgs/logo_app.jpg" height="50px" alt="WDS App" class="img-responsive logo-xl ">
      <img src="imgs/logo_app_mini.jpg"  height="50px" alt="WDS App" class="img-responsive logo-xs">
    
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
     <?php $rsUser = $functions->search('clients','id',$_SESSION["id_client_WDSApp_session"]); ?>
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="imgs/profile_user_160x160.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <span class="d-block"><?php echo utf8_encode($_SESSION["nome_client_WDSApp_session"]);?></span>
        </div>
        <div class="info"><button class="btn-xs btn-light" onClick="clientLogoff()">sair</button></div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-legacy" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="./painel" class="nav-link active">
              <i class="nav-icon fas fa-dolly"></i>
              <p>
                Pedidos
              </p>
            </a>
          </li>
		</ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
<?php } ?>