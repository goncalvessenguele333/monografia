
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
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Sistema de facturação</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <!-- summernote
  <link rel="stylesheet" href="../plugins/summernote/summernote-bs4.css">
   Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

 <link rel="stylesheet" type="text/css" href="../Contents/Estilos/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style type="text/css">
  #msgSend{
    color: #4caf50;
    font-size: 18px;
  }
   .navbar-nav{
 margin-right: 8%;
}
.main-header .navbar-nav i{
font-size: 25px;
}
#msgErrorE{
  color: #ff0000;
    font-size: 18px;
}
</style>

  <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.js">
</script>
<script type="text/javascript">
  

  $(document).ready(function(){

    $('#btnSendEmail').click(function(e){
  e.preventDefault();

  var email_deliver=$("#text_destino").val();
    var email_subject=$("#tex_subject").val();
      var email_message=$("#text_message").val();
   var action='send_email';
$.ajax({
      url:'../classes/ajax.php',
      type:"POST",
      async:true,
      data:{action:action,email_deliver:email_deliver,email_subject:email_subject,email_message:email_message},
      success: function(response)
      {
        console.log(response);
       if(response ==0){
            $('#msgSend').html('');
            $('#msgErrorE').html('');
          $('#msgErrorE').html('Por favor, verfica se preencheu todos campos');

        } 
        else if(response ==1){
           $('#msgSend').html('');
            $('#msgErrorE').html('');
          $('#msgErrorE').html('Verfica o formato do email do destinatário');
        } 
        else if(response ==2){
           $('#msgSend').html('');
            $('#msgErrorE').html('');
           
          $('#msgSend').html('Email enviado com sucesso!');
          $("#text_destino").val('');
          $("#tex_subject").val('');
          $("#text_message").val('');
        }    
        
   },
      error:function(error){

      }
    });
  
}); 

  });


 </script>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
   <nav class="main-header navbar navbar-expand navbar-white navbar-light">


     
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
        <a href="enviar_email.php" class="nav-link" ><i class="fas fa-envelope"></i>Enviar email</a>
      </li>
      </ul>

   <ul class="navbar-nav">
  <li class="nav-item">
        <a href="#" class="nav-link" ><i class="fa fa-file-pdf-o"></i>Documentos</a>
      </li>
  </ul>
   <ul class="navbar-nav">
  <li class="nav-item">
        <a href="#" class="nav-link" ><i class="fa fa-gear fa-spin"></i>Manual</a>
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
      <img src="../Contents/images/logo.png" alt="AdminLTE Logo"
           class="brand-image  elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">M</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
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

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Enviar email</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="Principal.php">Home</a></li>
              <li class="breadcrumb-item active">Enviar email</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">
            <a href="#" class="btn btn-primary btn-block mb-3">Email</a>

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Folders</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body p-0">
                <ul class="nav nav-pills flex-column">
                  <li class="nav-item active">
                    <a href="#" class="nav-link">
                      <i class="fas fa-inbox"></i> Entradas
                      <span class="badge bg-primary float-right">12</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="far fa-envelope"></i> Enviados
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="far fa-file-alt"></i> Reascunhos
                    </a>
                  </li>
                 
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="far fa-trash-alt"></i> Apagados
                    </a>
                  </li>
                </ul>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card card-primary card-outline">
              <div class="card-header">
                
              </div>
              <!-- /.card-header -->
              <div class="card-body">
               <form>
                  <div class="form-group">
                  <input type="email" class="form-control" placeholder="Para:" id="text_destino" name="text_destino">
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" id="tex_subject" name="tex_subject" placeholder="Assunto:">
                </div>
                <div class="form-group">
                <textarea id="text_message" name="text_message" class="form-control" rows="8"></textarea>
                </div>
               </form>
                 <div class="card-footer">
                  <span id="msgSend"></span>
                  <span id="msgErrorE"></span>
                <div class="float-right">
                
                  <button type="button" class="btn btn-primary" id="btnSendEmail"><i class="far fa-envelope"></i> Enviar</button>
                </div>
            
              </div>
              </div>
              <!-- /.card-body -->
            
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
    <footer class="main-footer">
    <strong>Copyright &copy; <script>document.write(new Date().getFullYear());</script>  <a href="https://www.multicastservicos.co.mz">Multicast Serviços E.I</a>.</strong>
    Todos direitos servados
    <div class="float-right d-none d-sm-inline-block">
      <b>Versão</b> 0.0.1
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script>
<!-- Summernote
<script src="../plugins/summernote/summernote-bs4.min.js"></script>
 Page Script -->
<script>
 /* $(function () {
    //Add text editor
    $('#compose-textarea').summernote()
  })*/
</script>
</body>
</html>
