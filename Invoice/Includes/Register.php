<?php

require_once '../Core/Init.php';
require_once '../classes/Conexaodb.php';

$user=new User();
if(Session::exists('home')){
  echo '<p>'.Session::flash('home').'</p>';
}

if(!$user->isLoggedIn()){
  Redirect::to('../Index.php');
 }

$msg = false;
if(isset($_FILES['arquivo'])){
    $arquivo = $_FILES['arquivo']['name'];
    $extensao = strtolower(pathinfo($arquivo, PATHINFO_EXTENSION));
    
    $novo_nome = md5(time()).".".$extensao;
    
    $diretorio = "../upload/";
    
    move_uploaded_file($_FILES['arquivo']['tmp_name'], $diretorio . $novo_nome);



if(Input::exists()){
  if(Token::check(Input::get('token'))){
    //echo "I have been run";
  $validate=new Validate();
  $validation=$validate->check($_POST,array(
    'username'=>array(
      'required'=>true,
      'min'=>2,
      'max'=>100,
      'unique'=>'users'
    ),
    'password'=>array(
      'required'=>true,
      'min'=>6
    ),
    'password_again'=>array(
      'required'=>true,
      'matches'=>'password'
    ),
    'name'=>array(
      'required'=>true,
      'min'=>2,
      'max'=>50
    )

  ));

  if($validation->passed()){
    $user=new User();

    $salt = Hash::salt(32);
   $user->create(array(
        'id'      =>'',
       
        'name'      =>Input::get('name'),
        'contact'   =>Input::get('contact'),
        'username'  =>Input::get('username'),
        'password'  =>Hash::make(Input::get('password')),
        'salt'      =>$salt,        
        'joined'    =>date('Y-m-d H:i:s'),
        'group'     =>1,
        'arquivo'   =>$novo_nome 
      )); 

 }
 else{
    foreach($validation->errors() as $errors);
    echo $errors,'<br>';
  }
}
}

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
 
 <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.js">
</script>
<script type="text/javascript">

  $(document).ready(function(){

  $('#btnActualizarEmpresa').click(function(e){
e.preventDefault();

var txtNome=$('#txtNome').val();
var txtNuit=$('#txtNuit').val();
var txtProvincia=$('#txtProvincia').val();
var txtNacional=$('#txtNacional').val();
var txtCidade=$('#txtCidade').val();
var txtAvenida=$('#txtAvenida').val();
var txtNumero=$('#txtNumero').val();
var txtWebSite=$('#txtWebSite').val();
var txtTelefone=$('#txtTelefone').val();
var txtEmail=$('#txtEmail').val();
    var action='actualizar_empresa';
  
  $.ajax({
    url:'../classes/ajax.php',
      type:"POST",
      async:true,
      data:{action:action,txtNome:txtNome,txtNuit:txtNuit,txtProvincia:txtProvincia,txtNacional:txtNacional,txtCidade:txtCidade,txtAvenida:txtAvenida,txtNumero:txtNumero,txtWebSite:txtWebSite,txtTelefone:txtTelefone,txtEmail:txtEmail},
      success: function(response)
      {       
        if(response !='error'){
          //var info=JSON.parse(response);
          console.log(response);
          $('#msgActualizarE').html('Actualizado com sucesso');
          //gerarPDF(info.cod_cliente,info.nr_factura);
          //location.reload();
      }
      else{
        console.log('no data');
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
          <a href="#" class="d-block"> 

<?php
 echo escape($lista->name); 
}
?>
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
    
        <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Registo de usuários</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="Principal.php">Home</a></li>
              <li class="breadcrumb-item active">Registo de usuários</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

     <section class="content">
      <div class="container-fluid">
      
         
        <form role="form" action="" method="Post" enctype="multipart/form-data">
          <div class="row">
        <div class="col-md-6">
           
            <div class="card card-primary">
                <div class="card-body">
                  <div class="form-group">
                    <label for="name">Nome Completo</label>
                    <input type="text" class="form-control" id="name" name="name"  autocomplete="off" required>
                  </div>
                  <div class="form-group">
                    <label for="contact">Telefone</label>
                    <input type="text" class="form-control" id="contact" name="contact"  autocomplete="off" required>
                  </div>

                   <div class="form-group">
                    <label for="username">Email</label>
                    <input type="email" class="form-control" id="username" name="username"  autocomplete="off" required>
                  </div>                

                </div>
        </div>
      

          </div>

<div class="col-md-6">
            <!-- general form elements disabled -->
            <div class="card card-warning">
        <div class="card-body">
              <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" required name="password"  autocomplete="off">
                  </div>
                   <div class="form-group">
                    <label for="password_again">Repita password</label>
                    <input type="password" class="form-control" id="password_again" name="password_again" required  autocomplete="off">
                  </div>
               <div class="form-group">
                <input type="file" class="form-control" name="arquivo"/>
                 
               </div>
                 
             <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
    
  <input type="submit"  class="btn btn-success"  id="contact-submit" value="Gravar" name=""> 


          </div>
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

<!-- PAGE SCRIPTS -->
<script src="../dist/js/pages/dashboard2.js"></script>



</body>
</html>
