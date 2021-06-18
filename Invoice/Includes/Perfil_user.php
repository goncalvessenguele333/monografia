<?php
require_once '../Core/Init.php';
include '../classes/Conexaodb.php';
if(Session::exists('home')){
  echo '<p>'.Session::flash('home').'</p>';
}


$user=new User();
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

  <title>Sistema de facturação</title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">

  <link rel="stylesheet" href="../dist/css/adminlte.min.css">

  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  <link rel="stylesheet" type="text/css" href="../Contents/Estilos/style.css">

<style type="text/css">
  #msgError{
    color: red;
  }
</style>
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.js">
</script>
<script type="text/javascript">

  $(document).ready(function(){

$('#nomeUsuario').attr('disabled','disabled');
$('#telefoneUsuario').attr('disabled','disabled');
$('#emailUsuario').attr('disabled','disabled');
 
 
    $('#btn_passwordConfirm').click(function(e) {
  e.preventDefault();


 var emailUsuario=$("#emailUsuario").val();
  var passwordConfirm=$("#passwordConfirm").val();

 var action='confirmarUsuario';
 $.ajax({
      url:'../classes/ajax.php',
      type:"POST",
      async:true,
      data:{action:action,emailUsuario:emailUsuario,passwordConfirm:passwordConfirm},
      success: function(response)
      {
        console.log(response);
      if(response !=0){
          
          if(response ==1){
          
      $('#nomeUsuario').removeAttr('disabled');
      $('#telefoneUsuario').removeAttr('disabled');
      $('#emailUsuario').removeAttr('disabled');
      $('#fileInput').slideDown();
      $('#confirmctual').slideUp();
      $('#actualizarUser').slideDown();
      $('#msgError').html("");
       $("#modal-default").modal("hide");
      }
      else if(response ==2){
           $('#msgError').html("A sua password está incorrecta"); 
           $('#passwordConfirm').val("");
      }

      }
      else{
        $('#msgError').html("Coloca a sua password");
     
      }

    },  
      error:function(error){
          $('#msgGravar').html("");

      }
    });
});




$('#actualizarUser').click(function(e) {
  e.preventDefault();

var emailUsuario=$("#emailUsuario").val();
  var nomeUsuario=$("#nomeUsuario").val();
  var telefoneUsuario=$("#telefoneUsuario").val();

   var action='actualizaUsuario';
 $.ajax({
      url:'../classes/ajax.php',
      type:"POST",
      async:true,
      data:{action:action,emailUsuario:emailUsuario,nomeUsuario:nomeUsuario,telefoneUsuario:telefoneUsuario},
      success: function(response)
      {
      
if(response !=0){
      console.log(response);
}
       },
      error:function(error){

      }
    }); 
});

  });


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
          <a href="#" class="d-block"> <?php 
     echo escape($lista->name); 
   ?></a>
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
            <h1>Meus dados</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="Principal,php">Home</a></li>
              <li class="breadcrumb-item active">Meus dados</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

     <section class="content">
      <div class="container-fluid">
      
            
        <form role="form" action="" method="Post">
          <div class="row">
        <div class="col-md-6">
           
            <div class="card card-primary">
                <div class="card-body">
                  <div class="form-group">
                    <label for="nomeUsuario">Nome</label>
                    <input type="text" class="form-control" value="<?php echo escape($lista->name); ?>" id="nomeUsuario" name="nomeUsuario"  autocomplete="off" >
                  </div>
                  <div class="form-group">
                    <label for="telefoneUsuario">Telefone</label>
                    <input type="text" class="form-control" value="<?php echo escape($lista->contact); ?>" id="telefoneUsuario" name="telefoneUsuario"  autocomplete="off" >
                  </div>

                   <div class="form-group">
                    <label for="emailUsuario">Email</label>
                    <input type="text" class="form-control" value="<?php echo escape($lista->username); ?>" id="emailUsuario" name="emailUsuario"  autocomplete="off" >
                  </div>

                                                
                </div>
        </div>
      

          </div>

<div class="col-md-6">
            <!-- general form elements disabled -->
            <div class="card card-warning">
        <div class="card-body">
             <div class="row">
                <div class="col-md-6">
                   <div class="form-group">
                    <div class="image">
                      <img src="../upload/<?=$arquivo?>">
                    </div>
                  </div>           
                  
                </div>
                <div class="col-md-6">
                   <div class="form-group">
                    <input type="file" class="form-control" id="fileInput" name="arquivo" style="display: none" />
                  </div>
                  
                </div>
               
             </div>
                
                 
        </div>
<?php
}
?>

          </div>
            <button type="button" class="btn btn-success" id="confirmctual" name="confirmctual" data-toggle="modal" data-target="#modal-default">Confirmar password

            </button>
            <button type="button" class="btn btn-success" id="actualizarUser" name="actualizarUser" style="display: none;">Actualizar</button>
              
        </div>

     
      </div>
              
              </form>
            
      
      
  
      </div>
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


   <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Confirmação de password</h4>
             
            </div>
            <div class="modal-body">
           <input type="password" name="passwordConfirm" id="passwordConfirm" class="form-control">
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
               <span id="msgError"></span>
              <button type="button" class="btn btn-primary" id="btn_passwordConfirm" name="btn_passwordConfirm">Confirmar</button>
             
            </div>

          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

</body>
</html>
