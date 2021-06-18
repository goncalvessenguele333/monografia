<?php
require_once '../Core/Init.php';
include '../classes/Conexaodb.php';
$user=new User();
//$categoria=new Produto();
if(!$user->isLoggedIn()){
  Redirect::to('../index.php');
 }

if($user->isLoggedIn()){
$codigo= ($user->data()->id); 
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

  <title>sistema de facturação</title>

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
      $('.anular_factura').click(function(e) {
  e.preventDefault();
  var noFactura=$(this).attr('fac');
  var action='anularFactura';

  $.ajax({
      url:'../classes/ajax.php',
      type:"POST",
      async:true,
      data:{action:action,noFactura:noFactura},
      success: function(response)
      {
        if(response !='error'){
         $('#row_'+noFactura+'.div_factura').html('<button type="button" class="btn_anular inactive"><i class="fas fa-ban"></i></button>');
         $('#row_'+noFactura+'.estado').html('<span class="anulada">Anulada</span>');
        location.reload();
      }

      },
      error:function(error){

      }
    });
  
});


$('.view_factura').click(function(e) {
  e.preventDefault();
  var codCliente=$(this).attr('cl');
  var codFacrura=$(this).attr('f');
gerarPDF(codCliente,codFacrura);
});

  });//Fim do ready....

function gerarPDF(cliente,factura){
  var ancho=100;
  var alto=800;
  var x=parseInt((window.screen.width/2)-(ancho/2));
  var y=parseInt((window.screen.height/2)-(alto/2));
  window.location='../Relatorios/Quote_free.php?cod_Cliente='+cliente+'&cod_Factura='+factura;
  //window.open($url);
}
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
          <a href="#" class="d-block"><?php 
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
            <h1><i class="far fa-newspaper"></i>Listagem de Cotação</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="Principal.php">Home</a></li>
              <li class="breadcrumb-item active">Listagem de Cotação</li>
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
         
             

                <div class="title_page">
    <table class="table table-borderless" cellpadding="10" cellspacing="10">
    <form action="buscar_cotacao.php" method="get" >
     <tr><td> <a href="Cotacao.php" ><i class="fas fa-user-plus"></i>Nova cotação</a></td>
     <td> <input type="number" class="form-control" name="buscarVenda" id="buscarVenda" placeholder="Numero cotação"
     autocomplete required></td>
     <td> <button type="submit" class="btn btn-success"><i class="fas fa-search"></i></button></td></tr>
      </form>
    </table>
<table class="table table-borderless" cellpadding="10" cellspacing="10">
  <form action="buscar_cotacao.php" method="get" class="form_search_date">
<tr><td><h5>Buscar por data</h5></td>

 <td> <label>De</label></td>
 <td> <input type="date" name="data_de" class="form-control" id="data_de" required></td>
  <td><label>A</label></td>
  <td><input type="date" name="data_a" class="form-control" id="data_a" required></td>
  <td><button type="submit" class="btn btn-success"><i class="fas fa-search"></i></button>
  </td></tr>
</form>
</table>

  </div>





              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
              <th>Nr.</th>
              <th>Data/Hora</th>
              <th>Cliente</th>
               <th>Operador</th>
                <th>Estado</th>
                <th class="textright">Valor total</th>
                <th class="textright">Acção</th>
</tr>
                  </thead>
                  <tbody>
                  
                 
                  
                  </tr>

  <?php



$query= mysqli_query($conexao,"SELECT f.nr_factura,fun.name,
                              cl.idCliente,f.estado,
                              cl.nomeCliente,f.dataVenda,
                              f.total_factura FROM tb_cotacao f INNER JOIN 
                              users fun ON f.usuario=fun.id
                               INNER JOIN tb_cliente cl ON f.cod_cliente=cl.idCliente");
      mysqli_close($conexao);
      $result=mysqli_num_rows($query);
     
      if($result>0){

      while($data=mysqli_fetch_array($query)){



        if($data['estado']==1) {
   $estado='<span class="pagada">Requesitada</span>';
 }
 else{
  $estado='<span class="anulada">Anulada</span>';
 }
 ?>
 <tr id="row_<?php echo $data['nr_factura']; ?>">
<td><?php echo $data['nr_factura']; ?></td>
<td><?php echo $data['dataVenda']; ?></td>
<td><?php echo $data['nomeCliente']; ?></td>
<td><?php echo $data['name']; ?></td>
<td class="estado"><?php echo $estado; ?></td>
<td class="textright totalFactura"><span>Q.</span><?php echo $data['total_factura']; ?></td>
<td>
  <div class="div_accao">
    <div>
      <button class="btn_view view_factura" type="button"
      cl="<?php echo $data['idCliente']; ?>" f="<?php echo $data['nr_factura']; ?>"><i class="fas fa-eye"></i></button>
    </div>


        </div>
</td>

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
