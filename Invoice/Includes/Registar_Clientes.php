 <?php
require_once '../Core/Init.php';
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



  <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.js">
</script>
<script type="text/javascript">

  $(document).ready(function(){


    $('#pesquisarCliente').keyup(function(e){
    e.preventDefault();
    var cl=$(this).val();
    var action='seachCliente';
    $.ajax({
      url:'../classes/ajax.php',
      type:"POST",
      async:true,
      data:{action:action,cliente:cl},
      success: function(response)
      {
        console.log(response);


      if(response == 0){
        $('#nomeCliente').val('');
        $('#nuitCliente').val('');
        $('#enderecoCleinte').val('');
        $('#ckbIva').prop("checked",false);
        $('#telefoneCliente').val('');
        $('#tipoCliente').val('');
        $('#emailCliente').val('');
        $('#actualizarCliente').slideUp();
        $('#gravarCliente').slideDown();
        $('#estadoCliente').slideUp();
        $('#lblEstadoCl').slideUp();
        
        }
        else{
           console.log(response);
        var data = $.parseJSON(response);
        $('#nuitCliente').val(data.nuitCliente);
        $('#nomeCliente').val(data.nomeCliente);
        $('#emailCliente').val(data.email);
        $('#telefoneCliente').val(data.contactoCliente);
        $('#enderecoCleinte').val(data.endereco);
        $('#tipoCliente').val(data.tipo);
        $('#estadoCliente').val(data.estado);
        if(data.iva==17){
          $('#ckbIva').prop("checked",true);

        }else{
          $('#ckbIva').prop("checked",false);

        }
        $('#estadoCliente').slideDown();
        $('#lblEstadoCl').slideDown();
        $('#actualizarCliente').slideDown();
        $('#gravarCliente').slideUp();
        $('#msgGravar').html("");
      $('#msgError').html("");

  
      
}


      },
      error:function(error){

      }
    });
    });
 
    $('#gravarCliente').click(function(e) {
  e.preventDefault();


 var txtNomeCliente1=$("#nomeCliente").val();
  var txtNuitCliente1=$("#nuitCliente").val();
  var txtEnderecoCliente1=$("#enderecoCleinte").val();
  var txtTelefoneCliente1=$("#telefoneCliente").val();
    var tipoCliente=$("#tipoCliente").val();
  var emailCliente=$("#emailCliente").val();
  var ivaCliente= $('#ckbIva:eq(0)').is(':checked') ? 17 : 0;
 var action='addCliente';
 $.ajax({
      url:'../classes/ajax.php',
      type:"POST",
      async:true,
      data:{action:action,txtNomeCliente1:txtNomeCliente1,txtNuitCliente1:txtNuitCliente1,txtEnderecoCliente1:txtEnderecoCliente1,txtTelefoneCliente1:txtTelefoneCliente1,ivaCliente:ivaCliente,tipoCliente:tipoCliente,emailCliente:emailCliente},
      success: function(response)
      {
        console.log(response);
      if(response !=0){
      $('#msgGravar').html("Cliente gravado com sucesso");
      $('#msgError').html("");
            $('#nomeCliente').val('');
      $('#nuitCliente').val('');
      $('#enderecoCleinte').val('');
      $('#ckbIva').prop("checked",false);
      $('#telefoneCliente').val('');
      $('#tipoCliente').val('');
      $('#emailCliente').val('');
      }
      else{
        $('#msgError').html("Verfica se preencheu todos campos");
          $('#msgGravar').html("");
      }

    },  
      error:function(error){
          $('#msgGravar').html("");

      }
    }); 
});




$('#actualizarCliente').click(function(e) {
  e.preventDefault();
  var idCliente=$("#pesquisarCliente").val();
  var txtNomeCliente1=$("#nomeCliente").val();
    var txtNuitCliente1=$("#nuitCliente").val();
    var txtEnderecoCliente1=$("#enderecoCleinte").val();
    var txtTelefoneCliente1=$("#telefoneCliente").val();
    var tipoCliente=$("#tipoCliente").val();
    var emailCliente=$("#emailCliente").val();
    var estadoCliente=$("#estadoCliente").val();
    var ivaCliente= $('#ckbIva:eq(0)').is(':checked') ? 17 : 0;
   var action='actualizaCliente';
 $.ajax({
      url:'../classes/ajax.php',
      type:"POST",
      async:true,
      data:{action:action,idCliente:idCliente,txtNomeCliente1:txtNomeCliente1,txtNuitCliente1:txtNuitCliente1,txtEnderecoCliente1:txtEnderecoCliente1,txtTelefoneCliente1:txtTelefoneCliente1,ivaCliente:ivaCliente,tipoCliente:tipoCliente,emailCliente:emailCliente,estadoCliente:estadoCliente},
      success: function(response)
      {
        console.log(response);

           $('#nomeCliente').val('');
        $('#nuitCliente').val('');
        $('#enderecoCleinte').val('');
        $('#pesquisarCliente').val('');
        $('#ckbIva').prop("checked",false);
        $('#telefoneCliente').val('');
        $('#tipoCliente').val('');
        $('#emailCliente').val('');
        $('#actualizarCliente').slideUp();
        $('#gravarCliente').slideDown();
        $('#estadoCliente').slideUp();
        $('#lblEstadoCl').slideUp();
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
          <a href="#" class="d-block"> 
            <?php 
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
            <h1>Registar clientes</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="Principal.php">Home</a></li>
              <li class="breadcrumb-item active">Registar clientes</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

     <section class="content">
      <div class="container-fluid">
      
        <input type="number" class="form-control" name="pesquisarCliente" id="pesquisarCliente" placeholder="Pesquisar cliente pelo codigo" style="width: 50%">
        <span id="msgGravar"></span><span id="msgError"></span> 
          <hr>
        
        <form role="form" action="" method="Post">
          <div class="row">
        <div class="col-md-6">
           
            <div class="card card-primary">
                <div class="card-body">
                  <div class="form-group">
                    <label for="nomeCliente">Nome</label>
                    <input type="text" class="form-control" id="nomeCliente" name="nomeCliente"  autocomplete="off">
                  </div>
                  <div class="form-group">
                    <label for="nuitCliente">NUIT</label>
                    <input type="text" class="form-control" id="nuitCliente" name="nuitCliente"  autocomplete="off">
                  </div>

                   <div class="form-group">
                    <label for="enderecoCleinte">Endereço</label>
                    <input type="text" class="form-control" id="enderecoCleinte" name="enderecoCleinte"  autocomplete="off">
                  </div>

                   <div class="form-group">
                    <label for="tipoCliente">Tipo Cliente</label>
                   <select id="tipoCliente" name="tipoCliente" class="form-control">
                     <option value="">Seleccione o tipo</option>
                     <option value="Permanente">Permanente</option>
                      <option value="Temporario">Temporário</option>
        </select>
                  </div>

                              
                </div>
        </div>
      

          </div>

<div class="col-md-6">
            <!-- general form elements disabled -->
            <div class="card card-warning">
        <div class="card-body">
              <div class="form-group">
                    <label for="emailCliente">E-email</label>
                    <input type="text" class="form-control" id="emailCliente" name="emailCliente"  autocomplete="off">
                  </div>
                   <div class="form-group">
                    <label for="ckbIva">Aplicar iva</label>
                   <input type="checkbox"  name="ckbIva" class="form-control" id="ckbIva">
                  </div>
                   <div class="form-group">
                    <label for="estadoCliente">Estado</label>
                   <select id="estadoCliente" name="estadoCliente" class="form-control">
                        <option>Actualiza o estado</option>
                        <option value="Activo">Activo</option>
                         <option value="Nao activo">Nao activo</option>
                      </select>
                  </div>
                   <div class="form-group">
                    <label for="telefoneCliente">Telefone</label>
                    <input type="text" class="form-control" id="telefoneCliente" name="telefoneCliente"  autocomplete="off">
                  </div>
                 
        </div>


          </div>
        </div>

       <button type="button" class="btn btn-success" id="gravarCliente" name="gravarCliente">Gravar</button><button type="button" class="btn btn-success" id="actualizarCliente" name="actualizarCliente" style="display: none;">Actualizar</button>
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
