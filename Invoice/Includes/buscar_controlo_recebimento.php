<?php

require_once '../Core/Init.php';
include '../classes/Conexaodb.php';
$user=new User();

if(!$user->isLoggedIn()){
  Redirect::to('../index.php');
 }

if($user->isLoggedIn()){
$codigo= ($user->data()->id); 
}

//$where='';
$buscarcontratoCod='';
$buscarcontratoEstado='';
$buscarcontratoAno='';


if(isset($_REQUEST['buscarContratoCodigo']) && $_REQUEST['buscarContratoCodigo']== ''){
  Redirect::to('Lista_controlo_recebimentos.php');
}

if(isset($_REQUEST['buscarContratoAno']) && $_REQUEST['buscarContratoAno']== ''){
  Redirect::to('Lista_controlo_recebimentos.php');
}

if(isset($_REQUEST['buscarContratoEstado']) && $_REQUEST['buscarContratoEstado']== ''){
  Redirect::to('Lista_controlo_recebimentos.php');
}

if(!empty($_REQUEST['buscarContratoCodigo'])){
$buscarcodContrato=strtolower($_REQUEST['buscarContratoCodigo']);
$where="cont_r.cod_contrato=$buscarcodContrato";
}

$query_ano= mysqli_query($conexao,"SELECT YEAR(data_assinatura) as anoAssinatura from tb_contrato");
     $result_ano=mysqli_num_rows($query_ano);
  
      if($result_ano>0){
        $data=mysqli_fetch_assoc($query_ano);
        $anoAss=$data['anoAssinatura'];

      }


     if(!empty($_REQUEST['buscarContratoAno'])){
        $buscarAnoContrato=strtolower($_REQUEST['buscarContratoAno']);
        $where="$anoAss=$buscarAnoContrato";
}


if(!empty($_REQUEST['buscarContratoEstado'])){
$buscarEstadoContrato=strtolower($_REQUEST['buscarContratoEstado']);
$where="con.estado='$buscarEstadoContrato'";
}


foreach ($user->FuncionarioLog($codigo) as $lista) 
{

  ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Sistema de facturação</title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">

  <link rel="stylesheet" href="../dist/css/adminlte.min.css">

  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  <link rel="stylesheet" type="text/css" href="../Contents/Estilos/style.css">



    <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.js">
</script>
<script type="text/javascript">
  

  $(document).ready(function(){
    //Anular factura.....
$('.apagar').click(function(e){
  e.preventDefault();
  var noCliente=$(this).attr('id_cliente');
   var action='apagaCliente';

  $.ajax({
      url:'../classes/ajax.php',
      type:"POST",
      async:true,
      data:{action:action,noCliente:noCliente},
      success: function(response)
      {

        console.log(response);
        location.reload();
      },
      error:function(error){

      }
    });
  
}); 

  });//Fim do ready....




</script>
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="Principal.php" class="nav-link">Home</a>
      </li>
     
    </ul>  

   
<ul class="navbar-nav">
  <li class="nav-item">
        <a href="Logout.php" class="nav-link" ><i class="fas fa-power-off"></i></a>
      </li>
</ul>

  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="Principal.php" class="brand-link">
      <img src="../Contents/images/logo.png" alt="AdminLTE Logo" class="brand-image elevation-3"
           style="opacity: .8">
   
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
       <?php
        $arquivo=escape($lista->arquivo);
          ?>
            <img class="img-fluid col-md-2 img-thumbnail" src="../upload/<?=$arquivo?>" />
        <div class="info">
          <a href="#" class="d-block"> <?php 
     echo escape($lista->name); 
   }?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
             
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-plus-square"></i>
              <p>
              Cadastros
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="Empresa.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dados Empresa</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="Register.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Usuários</p>
                </a>
              </li>
                <li class="nav-item">
                <a href="Perfil_user.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Perfil</p>
                </a>
              </li>
                 <li class="nav-item">
                <a href="change-password.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Alterar password</p>
                </a>
              </li>
            
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Clientes
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="Registar_Clientes.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Registar Clientes</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="Lista_Cliente.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Listar Clientes</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-cubes"></i>
              <p>
               Facturas
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="factura.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Factura</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="Lista_factura.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Listar facturas</p>
                </a>
              </li>           
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
               Cotação
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="Cotacao.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Cotação</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="Lista_cotacaoo.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Listar Cotação</p>
                </a>
              </li>
             
            </ul>
          </li>
           <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
               Contratos
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="Contrato.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Registar Contrato</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="Lista_Contratos.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Listar Contratos</p>
                </a>
              </li>
                <li class="nav-item">
                <a href="Pagamentos_contrato.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pagamentos</p>
                </a>
              </li>
             <li class="nav-item">
                <a href="Lista_controlo_recebimentos.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Recebimentos contratos</p>
                </a>
              </li>
             
            </ul>
          </li>
        
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <div class="content-wrapper">
    
        <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Listagens de controlo de recebimentos</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="Principal.php">Home</a></li>
              <li class="breadcrumb-item active">Listagens de controlo de recebimentos</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

       <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
            <div class="row">
              <div class="col-md-4">
                  <form action="buscar_controlo_recebimento.php" method="get" >
             <div class="form-inline">
                  <input type="number" class="form-control" name="buscarContratoCodigo" id="buscarContratoCodigo" placeholder="Código do contrato" required>
                   <button type="submit" class="btn btn-success"><i class="fas fa-search"></i></button> 
             </div>           
            </form>                 
              </div>
              <div class="col-md-4">
                  <form action="buscar_controlo_recebimento.php" method="get" >
             <div class="form-inline">
                 <select class="form-control" name="buscarContratoAno" id="buscarContratoAno">
                  <option value="">Selecciona pelo ano</option>
                  <option value="2020">2020</option>
                  <option value="2021">2021</option>
                  </select>
                   <button type="submit" class="btn btn-success"><i class="fas fa-search"></i></button> 
             </div>
           
            </form>
                
              </div>
                 <div class="col-md-4">
                  <form action="buscar_controlo_recebimento.php" method="get" >
             <div class="form-inline">
                 <select class="form-control" name="buscarContratoEstado" id="buscarContratoEstado">
                  <option value="">Selecciona pelo estado</option>
                  <option value="Em vigente">Em vigente</option>
                  <option value="Vencido">Vencido</option>
                   <option value="Anulado">Anulado</option>
                  </select>
                   <button type="submit" class="btn btn-success"><i class="fas fa-search"></i></button> 
             </div>
           
            </form>
                
              </div>
              
            </div>


              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>Código</th>
                    <th>Janeiro</th>
                    <th>Fevereiro</th>
                    <th>Março</th>
                    <th>Abril</th>
                    <th>Maio</th>
                    <th>Junho</th>
                    <th>Julho</th>
                    <th>Agosto</th>
                    <th>Setembro</th>
                    <th>Outubro</th>
                    <th>Novembro</th>
                    <th>Dezembro</th>
                    <th>Total</th>
                  </tr>
                  </thead>
                  <tbody>                
                 
                  
                    <?php



$query= mysqli_query($conexao,"SELECT cont_r.id, cont_r.cod_contrato,cont_r.Janeiro,cont_r.Feverreiro,cont_r.Marco,cont_r.Abril,cont_r.Maio,cont_r.Junho,cont_r.Julho,cont_r.Agosto,cont_r.Setembro,cont_r.Outubro,cont_r.Novembro,cont_r.Dezembro, cont_r.total FROM tb_controlo_recebimento_contrato cont_r INNER JOIN tb_contrato con ON cont_r.cod_contrato=con.cod_contrato WHERE $where");
     // mysqli_close($conexao);
      $result=mysqli_num_rows($query);
     
      if($result>0){

      while($data=mysqli_fetch_array($query)){
        
 ?>
 <tr id="row_<?php echo $data['id']; ?>">
<td><?php echo $data['cod_contrato']; ?></td>
<td><?php echo $data['Janeiro']; ?></td>
<td><?php echo $data['Feverreiro']; ?></td>
<td><?php echo $data['Marco']; ?></td>
<td><?php echo $data['Abril']; ?></td>
<td><?php echo $data['Maio']; ?></td>
<td><?php echo $data['Junho']; ?></td>
<td><?php echo $data['Julho']; ?></td>
<td><?php echo $data['Agosto']; ?></td>
<td><?php echo $data['Setembro']; ?></td>
<td><?php echo $data['Outubro']; ?></td>
<td><?php echo $data['Novembro']; ?></td>
<td><?php echo $data['Dezembro']; ?></td>
<td><?php echo $data['total']; ?></td>
</tr>
 <?php

}
}
?>
                  
                 
                  </tbody>
               
                </table>
              </div>
              <!-- /.card-body -->
            </div>
           </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
  
  </div>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>Copyright &copy; <script>document.write(new Date().getFullYear());</script>  <a href="https://www.multicastservicos.co.mz">Multicast Serviços E.I</a>.</strong>
    Todos direitos servados
    <div class="float-right d-none d-sm-inline-block">
      <b>Versão</b> 0.0.1
    </div>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="../plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.js"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="../dist/js/demo.js"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="../plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="../plugins/raphael/raphael.min.js"></script>
<script src="../plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="../plugins/jquery-mapael/maps/usa_states.min.js"></script>
<!-- ChartJS -->
<script src="../plugins/chart.js/Chart.min.js"></script>

<!-- PAGE SCRIPTS -->
<script src="../dist/js/pages/dashboard2.js"></script>



</body>
</html>
