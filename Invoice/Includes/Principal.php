
 <?php
require_once '../Core/Init.php';
include '../classes/Conexaodb.php';
if(Session::exists('home')){
  echo '<p>'.Session::flash('home').'</p>';
}


$user=new User();
if(!$user->isLoggedIn()){
  Redirect::to('../Index.php');
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

  
<ul class="navbar-nav ">
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
      <img src="../Contents/images/logo.png" alt="Logo" class="brand-image elevation-3"
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
          <a href="#" class="d-block">
            <?php 
     echo escape($lista->name); 
   }?>
          </a>
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
    <!-- Content Header (Page header) -->
      <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total contratos</span>
                  <?php
                  foreach ($user->TotalContratos() as $lista) 
                {

                  ?>
                <span class="info-box-number">
                   <?php 
     echo escape($lista->totalContratos); 
   }?>
            
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-cubes" style="color: #fff"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total facturas</span>

                  <?php
                  foreach ($user->TotalFactura() as $lista) 
                {

                  ?>
                <span class="info-box-number">
                  <?php 
     echo escape($lista->totalFacturas); 
   }?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-table" style="color: #fff"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total cotação</span>
                 <?php
                  foreach ($user->TotalCotaco() as $lista) 
                {

                  ?>
                <span class="info-box-number"> <?php 
     echo escape($lista->totalCotacao); 
   }?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users" style="color: #fff"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Clientes</span>

                  <?php
                  foreach ($user->TotalCliente() as $lista) 
                {

                  ?>


                <span class="info-box-number">  <?php 
     echo escape($lista->totalClientes); 
   }?></span>


                

              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div> 
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Gráficos de pagamentos de contratos</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="Principal.php">Home</a></li>
              <li class="breadcrumb-item active">Gráficos de pagamentos de contratos</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-6">
            <!-- AREA CHART -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Gráfico de Área</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="areaChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- DONUT CHART -->
            <div class="card card-danger">
              <div class="card-header">
                <h3 class="card-title">Donut Chart</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                </div>
              </div>
              <div class="card-body">
                <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- PIE CHART -->
            <div class="card card-danger">
              <div class="card-header">
                <h3 class="card-title">Gráfico de pizza</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                </div>
              </div>
              <div class="card-body">
                <canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

          </div>
          <!-- /.col (LEFT) -->
          <div class="col-md-6">
            <!-- LINE CHART -->
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Gráfico de linha</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="lineChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- BAR CHART -->
            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Gráfico de barras</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- STACKED BAR CHART -->
            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Gráfico de Barras Empilhadas</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="stackedBarChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

          </div>
          <!-- /.col (RIGHT) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
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
<?php
$query_janeiro= mysqli_query($conexao,"SELECT count(id) as total_janeiro FROM tb_pagamento_contrato WHERE mes_pago='Janeiro'");

      $result_janeiro=mysqli_num_rows($query_janeiro);
    
      if($result_janeiro>0){
        $data=mysqli_fetch_assoc($query_janeiro);
        $total_janeiro1=$data['total_janeiro'];
      }

      $query_dezembro= mysqli_query($conexao,"SELECT count(id) as total FROM tb_pagamento_contrato WHERE mes_pago='Dezembro'");
     
      $result_dezembro=mysqli_num_rows($query_dezembro);
    
      if($result_dezembro>0){
        $data=mysqli_fetch_assoc($query_dezembro);
        $total_dezembro=$data['total'];
      }




      $query_fevereiro= mysqli_query($conexao,"SELECT count(id) as total_fevereiro FROM tb_pagamento_contrato WHERE mes_pago='Fevereiro'");
     
      $result_fevereiro=mysqli_num_rows($query_fevereiro);
    
      if($result_fevereiro>0){
        $data=mysqli_fetch_assoc($query_fevereiro);
        $result_fevereiro=$data['total_fevereiro'];
      }



      $query_marco= mysqli_query($conexao,"SELECT count(id) as total_marco FROM tb_pagamento_contrato WHERE mes_pago='Março'");
     
      $result_marco=mysqli_num_rows($query_marco);
    
      if($result_marco>0){
        $data=mysqli_fetch_assoc($query_marco);
        $total_marco=$data['total_marco'];
      }

      $query_abril= mysqli_query($conexao,"SELECT count(id) as total_abril FROM tb_pagamento_contrato WHERE mes_pago='Abril'");
     
      $result_abril=mysqli_num_rows($query_abril);
    
      if($result_abril>0){
        $data=mysqli_fetch_assoc($query_abril);
        $total_abril=$data['total_abril'];
      }

      $query_maio= mysqli_query($conexao,"SELECT count(id) as total_maio FROM tb_pagamento_contrato WHERE mes_pago='Maio'");
     
      $result_maio=mysqli_num_rows($query_maio);
    
      if($result_maio>0){
        $data=mysqli_fetch_assoc($query_maio);
        $total_maio=$data['total_maio'];
      }

      $query_junho= mysqli_query($conexao,"SELECT count(id) as total_junho FROM tb_pagamento_contrato WHERE mes_pago='Junho'");
     
      $result_junho=mysqli_num_rows($query_junho);
    
      if($result_junho>0){
        $data=mysqli_fetch_assoc($query_junho);
        $total_junho=$data['total_junho'];
      }

      $query_julho= mysqli_query($conexao,"SELECT count(id) as total_julho FROM tb_pagamento_contrato WHERE mes_pago='Julho'");
     
      $result_julho=mysqli_num_rows($query_julho);
    
      if($result_julho>0){
        $data=mysqli_fetch_assoc($query_julho);
        $total_julho=$data['total_julho'];
      }

      $query_agosto= mysqli_query($conexao,"SELECT count(id) as total_agosto FROM tb_pagamento_contrato WHERE mes_pago='Agosto'");
     
      $result_agosto=mysqli_num_rows($query_agosto);
    
      if($result_agosto>0){
        $data=mysqli_fetch_assoc($query_agosto);
        $total_agosto=$data['total_agosto'];
      }

      $query_setembro= mysqli_query($conexao,"SELECT count(id) as total_setembro FROM tb_pagamento_contrato WHERE mes_pago='Setembro'");
     
      $result_setembro=mysqli_num_rows($query_setembro);
    
      if($result_setembro>0){
        $data=mysqli_fetch_assoc($query_setembro);
        $total_setembro=$data['total_setembro'];
      }

      $query_outubro= mysqli_query($conexao,"SELECT count(id) as total_outubro FROM tb_pagamento_contrato WHERE mes_pago='Outubro'");
     
      $result_outubro=mysqli_num_rows($query_outubro);
    
      if($result_outubro>0){
        $data=mysqli_fetch_assoc($query_outubro);
        $total_outubro=$data['total_outubro'];
      }

      $query_novembro= mysqli_query($conexao,"SELECT count(id) as total_novembro FROM tb_pagamento_contrato WHERE mes_pago='Dezembro'");
     
      $result_novembro=mysqli_num_rows($query_novembro);
    
      if($result_novembro>0){
        $data=mysqli_fetch_assoc($query_novembro);
        $total_novembro=$data['total_novembro'];
      }

?>

<script>
  $(function () {
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */

    //--------------
    //- AREA CHART -
    //--------------

    // Get context with jQuery - using jQuery's .get() method.
    var areaChartCanvas = $('#areaChart').get(0).getContext('2d')

    var areaChartData = {
      labels  : ['Janeiro', 'Fevereiro', 'Maio', 'Abril', 'Maio', 'Junho', 'Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
      datasets: [
        {
          label               : 'Digital Goods',
          backgroundColor     : 'rgba(60,141,188,0.9)',
          borderColor         : 'rgba(60,141,188,0.8)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : [<?php echo  $total_janeiro1; ?>, <?php echo $result_fevereiro; ?>, <?php echo $total_marco; ?>, <?php echo $total_abril ?>, <?php echo $total_maio; ?>, <?php echo $total_junho; ?>, <?php echo  $total_julho; ?>,<?php echo $total_agosto; ?>,<?php echo $total_setembro; ?>,<?php echo $total_outubro; ?>,<?php echo $total_novembro; ?>,<?php echo $total_dezembro; ?>]
        },
        {
          label               : 'Electronics',
          backgroundColor     : 'rgba(210, 214, 222, 1)',
          borderColor         : 'rgba(210, 214, 222, 1)',
          pointRadius         : false,
          pointColor          : 'rgba(210, 214, 222, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [65, 59, 80, 81, 56, 55, 40,88,56,26,90,30]
        },
      ]
    }

    var areaChartOptions = {
      maintainAspectRatio : false,
      responsive : true,
      legend: {
        display: false
      },
      scales: {
        xAxes: [{
          gridLines : {
            display : false,
          }
        }],
        yAxes: [{
          gridLines : {
            display : false,
          }
        }]
      }
    }

    // This will get the first returned node in the jQuery collection.
    var areaChart       = new Chart(areaChartCanvas, { 
      type: 'line',
      data: areaChartData, 
      options: areaChartOptions
    })

    //-------------
    //- LINE CHART -
    //--------------
    var lineChartCanvas = $('#lineChart').get(0).getContext('2d')
    var lineChartOptions = jQuery.extend(true, {}, areaChartOptions)
    var lineChartData = jQuery.extend(true, {}, areaChartData)
    lineChartData.datasets[0].fill = false;
    lineChartData.datasets[1].fill = false;
    lineChartOptions.datasetFill = false

    var lineChart = new Chart(lineChartCanvas, { 
      type: 'line',
      data: lineChartData, 
      options: lineChartOptions
    })

    //-------------
    //- DONUT CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
    var donutData        = {
      labels: [
          'Chrome', 
          'IE',
          'FireFox', 
          'Safari', 
          'Opera', 
          'Navigator', 
      ],
      datasets: [
        {
          data: [700,500,400,600,300,100],
          backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
        }
      ]
    }
    var donutOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    var donutChart = new Chart(donutChartCanvas, {
      type: 'doughnut',
      data: donutData,
      options: donutOptions      
    })

    //-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
    var pieData        = donutData;
    var pieOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    var pieChart = new Chart(pieChartCanvas, {
      type: 'pie',
      data: pieData,
      options: pieOptions      
    })

    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $('#barChart').get(0).getContext('2d')
    var barChartData = jQuery.extend(true, {}, areaChartData)
    var temp0 = areaChartData.datasets[0]
    var temp1 = areaChartData.datasets[1]
    barChartData.datasets[0] = temp1
    barChartData.datasets[1] = temp0

    var barChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      datasetFill             : false
    }

    var barChart = new Chart(barChartCanvas, {
      type: 'bar', 
      data: barChartData,
      options: barChartOptions
    })

    //---------------------
    //- STACKED BAR CHART -
    //---------------------
    var stackedBarChartCanvas = $('#stackedBarChart').get(0).getContext('2d')
    var stackedBarChartData = jQuery.extend(true, {}, barChartData)

    var stackedBarChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      scales: {
        xAxes: [{
          stacked: true,
        }],
        yAxes: [{
          stacked: true
        }]
      }
    }

    var stackedBarChart = new Chart(stackedBarChartCanvas, {
      type: 'bar', 
      data: stackedBarChartData,
      options: stackedBarChartOptions
    })
  })
</script>
</body>
</html>
