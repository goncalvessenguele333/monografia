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

function diasDatas($data_inicial,$data_final) {
    $diferenca = strtotime($data_final) - strtotime($data_inicial);
    $dias = floor($diferenca / (60 * 60 * 24)); 
    return $dias;
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

  <title>Sistema de Contrato</title>

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



$('#btnNovoCliente').click(function(e){
e.preventDefault();
$('#txtNomeCliente1').removeAttr('disabled');
$('#txtTelefoneCliente1').removeAttr('disabled');
$('#txtEnderecoCliente1').removeAttr('disabled');
$('#txtNuitCliente1').removeAttr('disabled');
$('#txtEmailCliente1').removeAttr('disabled');
$('#ckbIva').removeAttr('disabled');
$('#lblCogido').slideUp();
$('#lblCodigo').slideUp();


$('#div_registo_cliente').slideDown();

});
$('#btnActualizaCliente').click(function(e){
e.preventDefault();
$('#txtNomeCliente1').removeAttr('disabled');
$('#txtTelefoneCliente1').removeAttr('disabled');
$('#txtEnderecoCliente1').removeAttr('disabled');
$('#ckbIva').removeAttr('disabled');
$('#txtEmailCliente1').removeAttr('disabled');
$('#txtNuitCliente1').removeAttr('disabled');
$('#div_actualizacliente').slideDown();
$('#txtCodigoCliente1').attr('disabled','disabled');

});

    
$('#txtCodigoCliente1').keyup(function(e){
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
        $('#txtEmailCliente1').val('');
        $('#txtNomeCliente1').val('');
        $('#txtTelefoneCliente1').val('');
        $('#txtEnderecoCliente1').val('');
        $('#txtNuitCliente1').val('');
        $('#ckbIva').prop("checked",false);
        $('#btnNovoCliente').slideDown();
        $('#btnActualizaCliente').slideUp();
        $('#div_actualizacliente').slideUp();
        $('#msgMensagem').html('');
        }
        else{
        var data = $.parseJSON(response);
        if(data.estado=="Nao activo"){
          $('#msgMensagem').html('O cliente está desactivado, por isso não pode efectuar a compra');
        }
        else{
          $('#msgMensagem').html('');
            $('#txtEmailCliente1').val(data.email);
        $('#idCliente').val(data.idCliente);
        $('#txtNuitCliente1').val(data.nuitCliente);
        $('#idCliente').val(data.idCliente);
        $('#txtNomeCliente1').val(data.nomeCliente);
        $('#txtTelefoneCliente1').val(data.contactoCliente);
        $('#txtEnderecoCliente1').val(data.endereco);
        if(data.iva==17){
          $('#ckbIva').prop("checked",true);

        }else{
          $('#ckbIva').prop("checked",false);

        }
        $('#btnActualizaCliente').slideDown();
  
      $('#btnNovoCliente').slideUp();
      $('#div_registo_cliente').slideUp();
      $('#txtNomeCliente1').attr('disabled','disabled');
      $('#txtTelefoneCliente1').attr('disabled','disabled');
      $('#txtEnderecoCliente1').attr('disabled','disabled');
      $('#ckbIva').attr('disabled','disabled');
      $('#msgErrorAgregar').html('');
        }

      
}


      },
      error:function(error){

      }
    });
    });


//Criar nono cliente....
$('#div_registo_cliente').click(function(e) {
  e.preventDefault();


 var txtNomeCliente1=$("#txtNomeCliente1").val();
  var txtNuitCliente1=$("#txtNuitCliente1").val();
  var txtEnderecoCliente1=$("#txtEnderecoCliente1").val();
  var txtTelefoneCliente1=$("#txtTelefoneCliente1").val();
  var ivaCliente= $('#ckbIva:eq(0)').is(':checked') ? 17 : 0;
  var emailCliente=$('#txtEmailCliente1').val();
  var tipoCliente="Temporario";

 var action='addCliente';
 $.ajax({
      url:'../classes/ajax.php',
      type:"POST",
      async:true,
      data:{action:action,txtNomeCliente1:txtNomeCliente1,txtNuitCliente1:txtNuitCliente1,txtEnderecoCliente1:txtEnderecoCliente1,txtTelefoneCliente1:txtTelefoneCliente1,ivaCliente:ivaCliente,tipoCliente:tipoCliente,emailCliente:emailCliente},
      success: function(response)
      {
        console.log(response);
    
             $('#txtNomeCliente1').attr('disabled','disabled');
      $('#txtTelefoneCliente1').attr('disabled','disabled');
      $('#txtEnderecoCliente1').attr('disabled','disabled');
      $('#emailCliente').attr('disabled','disabled');
      $('#txtNuitCliente1').attr('disabled','disabled');
      $('#ckbIva').attr('disabled','disabled');
      $('#btnNovoCliente').slideUp();
      $('#div_registo_cliente').slideUp();
      $('#lblCogido').slideDown();
      $('#lblCodigo').slideDown();
      var info=JSON.parse(response);
      $('#txtCodigoCliente1').val(info.idCliente);

       },
      error:function(error){

      }
    }); 
});


$('#div_actualizacliente').click(function(e) {
  e.preventDefault();

var idCliente=$('#idCliente').val();
 var txtNomeCliente1=$("#txtNomeCliente1").val();
  var txtNuitCliente1=$("#txtNuitCliente1").val();
  var txtEnderecoCliente1=$("#txtEnderecoCliente1").val();
  var txtTelefoneCliente1=$("#txtTelefoneCliente1").val();
  var ivaCliente= $('#ckbIva:eq(0)').is(':checked') ? 17 : 0;
  var estadoCliente="Activo";
   var emailCliente=$('#txtEmailCliente1').val();
  var tipoCliente="Temporario";
 var action='actualizaCliente';
 $.ajax({
      url:'../classes/ajax.php',
      type:"POST",
      async:true,
      data:{action:action,idCliente:idCliente,txtNomeCliente1:txtNomeCliente1,txtNuitCliente1:txtNuitCliente1,txtEnderecoCliente1:txtEnderecoCliente1,txtTelefoneCliente1:txtTelefoneCliente1,ivaCliente:ivaCliente,estadoCliente:estadoCliente,emailCliente:emailCliente,tipoCliente:tipoCliente},
      success: function(response)
      {
        console.log(response);

             $('#txtNomeCliente1').attr('disabled','disabled');
      $('#txtTelefoneCliente1').attr('disabled','disabled');
      $('#txtEnderecoCliente1').attr('disabled','disabled');
      $('#txtEmailCliente1').attr('disabled','disabled');
      $('#txtNuitCliente1').attr('disabled','disabled');
      $('#ckbIva').attr('disabled','disabled');
      $('#btnActualizaCliente').slideUp();
      $('#btnNovoCliente').slideUp();
      $('#div_actualizacliente').slideUp();
      $('#txtCodigoCliente1').removeAttr('disabled');
       },
      error:function(error){

      }
    }); 
});

$('#txt_preco').keyup(function(e){
e.preventDefault();
var preco_total=$(this).val() * $('#txt_quant_produto').val();
//var existencia=parseInt($('#txt_exixtencia').html());
$('#txt_preco_total').html(preco_total);


if( ($(this).val() < 1 ) )
{
  $('#add_product_venda').slideUp();
  
}
else{
  $('#add_product_venda').slideDown();
  
  
}
});

$('#add_product_venda').click(function(e){
        e.preventDefault();

      if($('#txt_quant_produto').val() > 0){
      var descProduto=$('#txt_descripcion').val();
      var quanti=$('#txt_quant_produto').val();
      var preco=$('#txt_preco').val();
      var precoTotal=$('#txt_preco_total').html();
      var codCliente=$('#txtCodigoCliente1').val();
      var codproducto=$('#txt_cod_producto').val();
      var action='addProdutoDetalheContrato';


        $.ajax({
      url:'../classes/ajax.php',
      type:"POST",
      async:true,
      data:{action:action,descProduto:descProduto,preco:preco,precoTotal:precoTotal,quanti:quanti,codCliente:codCliente,codproducto:codproducto},
      success: function(response)
      {
        if(response !=0){
          var info=JSON.parse(response);
          console.log(response);
         $('#detalhe_venda').html(info.detalhe);
          $('#detalhe_total_venda').html(info.total);
          $('#txValorTotal').val(info.valor_total);
          $('#txt_cod_producto').val('');
          $('#txt_descripcion').val('');          
          $('#txt_quant_produto').val('');
          $('#txt_preco').val('');
          $('#txt_preco_total').html('0.00');         
          $('#add_product_venda').slideUp();
        }
        else{
          //console.log('no data');
          $('#msgErrorAgregar').html('<h6>Verfica se introduziu os dados do cliente!</h6>');
        }
         viewProcessar();
      },
      error:function(error){

      }
  });
}
});

//Processar factura
 $('#btn_facturar_venda').click(function(e){
        e.preventDefault();


        var rows = $('#detalhe_venda tr').length;
      if(rows > 0){
    var action='processar_contrato';
  var codCliente=$('#idCliente').val();
  var tipoContrato=$('#txtTipoContrato').val();
  var valorTotal=$('#txValorTotal').val();
  var valorMensal=$('#txtValorMensal1').val();
  var dataAssinatura=$('#txtDataAssinatura').val();
  var dataInicio=$('#txtDataInicio').val();
  var dataVencimentoCont=$('#txtDataVencimentoCont').val();
  var duracoaContrat=$('#txtDuracoaContrat').val();

  $.ajax({
    url:'../classes/ajax.php',
      type:"POST",
      async:true,
      data:{action:action,codCliente:codCliente,tipoContrato:tipoContrato,valorTotal:valorTotal,valorMensal:valorMensal,dataAssinatura:dataAssinatura,dataInicio:dataInicio,dataVencimentoCont:dataVencimentoCont,duracoaContrat:duracoaContrat},
      success: function(response)
      {       
        if(response !=0){
          //var info=JSON.parse(response);
          console.log(response);
         // gerarPDF(info.cod_cliente,info.nr_factura);
          //location.reload();
      }
      else{
        console.log('no data');
      }
      },
      error:function(error){

      }
  })
}
});

//Anular venda
$('#btn_anular_venda').click(function(e){
e.preventDefault();
//var rows = $('#detalhe_venda tr').length;
//if(rows > 0){
  var action='anularVenda';

  $.ajax({
    url:'../classes/ajax.php',
      type:"POST",
      async:true,
      data:{action:action},
      success: function(response)
      {
        console.log(response);
        if(response !='error'){
          location.reload();
        }
      },
      error:function(error){

      }
  })
//}
});

$('#txtDataVencimentoCont').change(function(){
 var dt1 = $('#txtDataInicio').val();
  var dt2 = $('#txtDataVencimentoCont').val();
  
  $('#txtDuracoaContrat').val(calcula(dt1,dt2))
 /// alert("Encontado");

});

});//Fim do ready

function gerarPDF(cliente,factura){
  var ancho=100;
  var alto=800;
  var x=parseInt((window.screen.width/2)-(ancho/2));
  var y=parseInt((window.screen.height/2)-(alto/2));
  window.location='../Relatorios/factura_pdf.php?cod_Cliente='+cliente+'&cod_Factura='+factura;
  //window.open($url);
}



  function searchForDetalheContrato(id){
    var action='searchForDetalheContrato';
    var user=id;
    $.ajax({
      url:'../classes/ajax.php',
      type:"POST",
      async:true,
      data:{action:action,user:user},
      success: function(response)
      {
        if(response ==0){
          console.log('nao ha dados');
        }
        else{
          
          console.log(response);
          var info=JSON.parse(response);
          //console.log(info);
          $('#detalhe_venda').html(info.detalhe);
          $('#detalhe_total_venda').html(info.total);
           $('#txValorTotal').val(info.valor_total);
        }
        viewProcessar();
        },
      error:function(error){

      }
  }); 


  }

function viewProcessar(){
  if($('#detalhe_venda tr').length > 0){
    $('#btn_facturar_venda').show();
  }
  else{
    $('#btn_facturar_venda').hide();
  }
}



  //funcao para apagar detalhe de produtos
  function del_produt_detalhe_Contrato(correlativo){
    var action='apagaProductDetalheContrato';
    var id_detalhe=correlativo;
    $.ajax({
      url:'../classes/ajax.php',
      type:"POST",
      async:true,
      data:{action:action,id_detalhe:id_detalhe},
      success: function(response)
      {
        //console.log(response);
      if(response !=0){
          var info=JSON.parse(response);
          $('#detalhe_venda').html(info.detalhe);
          $('#detalhe_total_venda').html(info.total);
          $('#txValorTotal').val(info.valor_total);
          $('#txt_descripcion').val('');
          $('#txt_quant_produto').val('0');
          $('#txt_preco').val('');
          $('#txt_preco_total').val('0.00');          
          $('#add_product_venda').slideUp();
        }
        else{
          $('#detalhe_venda').html('');
          $('#detalhe_total_venda').html('');
           $('#txValorTotal').val('');
        }
         viewProcessar();
      },
      error:function(error){

      }
  }); 
  }
  

function calcula(data1, data2){
  data1 = new Date(data1);
  data2 = new Date(data2);
  if(data2>=data1){
    return (data2 - data1)/(1000*3600*24);
  }

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
            <h1><i class="fas fa-cube"></i>Factura</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="Principal.php">Home</a></li>
              <li class="breadcrumb-item active">Factura</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

       <section class="content">
      <div class="container-fluid">
      
       <div class="row">

<div class="col-sm-12 " id="text-left"> 

<section class="container" id="container">
    
  <div class="dados_clientes">
    <table class="table-borderless">
    <div class="form-inline">
    <div class="action_cliente">
      <div class="form-inline dados_inline">
         <h5>Dados dos clientes</h5>
         <button type="button" id="btnNovoCliente"  class="btn btn-success"><i class="fas fa-plus"></i>Novo Cliente</button>
 <button type="button" id="btnActualizaCliente"  class="btn btn-success"><i class="fas fa-edit"></i>Actualizar Cliente</button>
      
      <span id="msgMensagem"></span>
      </div>
     
  
        
      
    </div>
    </div>
    </table>
  </div>

    <div class="bordas">
      <form name="form_new_cliente_venda" id="form_new_cliente_venda" action="" class="dados" method="Post">

    <div class="form-group">
    <div class="row">
        <input type="hidden" name="idCliente" id="idCliente">
        <div class="col-md-3" id="lblCogido">
          <div class="form-group">
            <label  for="txtCodigoCliente1">Código</label>
            <input type="number" name="txtCodigoCliente1" class="form-control" id="txtCodigoCliente1"   autocomplete="off">
          </div>
  
        </div>
        <div class="col-md-3">
            <div class="form-group">
              <label for="txtNuitCliente1">Nuit</label>
              <input type="number" name="txtNuitCliente1" class="form-control" id="txtNuitCliente1"   autocomplete="off"  disabled required>
            </div>
        </div>
        <div class="col-md-3">
              <div class="form-group">
                <label for="txtNomeCliente1">Nome</label>
                <input type="text"  name="txtNomeCliente1" class="form-control" id="txtNomeCliente1"  autocomplete="off" disabled required >
              </div>
        </div>
        <div class="col-md-3">
              <div class="form-group">
                <label for="txtTelefoneCliente1">Telefone</label>
                <input type="text"  name="txtTelefoneCliente1" class="form-control" id="txtTelefoneCliente1"   autocomplete="off" required disabled >
              </div>
        </div>
      </div>
<div class="row">
  <div class="col-md-4">
  <div class="form-group">
<label for="txtEmailCliente1">Email</label>
<input type="email" name="txtEmailCliente1" class="form-control" id="txtEmailCliente1"   autocomplete="off" required disabled>
  </div>
</div>
  <div class="col-md-4">
  <div class="form-group">
    <label for="txtEnderecoCliente1">Endereço</label>
    <input type="text" name="txtEnderecoCliente1" class="form-control" id="txtEnderecoCliente1"   autocomplete="off" required disabled>
  </div>
</div>
  <div class="col-md-4">
  <div class="form-group">
    <label for="ckbIva">Aplicar iva</label>
    <input type="checkbox"  name="ckbIva" class="form-control" id="ckbIva" disabled>
  </div>
</div>

  
</div>       
      </div>
    <div class="row">
      <div class="col-md-3">
         <button type="button" id="div_registo_cliente" class="btn btn-success"><i class="far fa-save fa-lg"></i>Guardar</button>
      </div>
      <div class="col-md-3">
        <button type="button" id="div_actualizacliente" class="btn btn-success"><i class="far fa-edit"></i>actualizar</button>
      </div>
    </div>
      
     

          
        
  
    </form>
 
    </div>
  <div class="title_page">
    <h3>Dados de Contrato</h3>
    
  </div>
  
  <div class="bordas"> 
  <div class="dados_venda">
    <div class="dados">
  <div class="wd50">
        

        <div id="Acciones_venda">

            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label>Vendedor</label>
                  <?php

foreach ($user->FuncionarioLog($codigo) as $lista) {
  ?>
      <p> <?php echo escape($lista->name);?> </p>
          <?php
        }
?>

                </div>                
              </div>
               <div class="col-md-2">
                <div class="form-group">
                  
                </div>                
              </div>
               <div class="col-md-3">
                <div class="form-group">
                  <label>Acciones</label>
                  <br>
                  <button id="btn_anular_venda" class="btn btn-danger"><i class="fas fa-ban"></i> Anular</button>
                  <button class="btn btn-success" style="display: none;" id="btn_facturar_venda"><i class="fas fa-edit"></i> Processar</button>
                </div>                
              </div>              
            </div>
        </div>
        
      </div>
    </div>
    
  </div>

</div>
<br>

<table class="table table-bordered table-hover" cellpadding="10">
  <thead>
    <tr>
      <th width="100px">Código</th>
      <th width="300px" colspan="3">Descrição</th>          
      <th width="120px">Quantidade</th>
      <th class="textright"> Preço</th>
      <th class="textright"> Preço total </th>
      <th> Acção</th>
    </tr>

    <tr> 
      <td><input type="text" class="form-control" name="txt_cod_producto" id="txt_cod_producto"></td>
      <td colspan="3"><input type="text" class="form-control" name="txt_descripcion" id="txt_descripcion" min="1"></td>
      
      <td><input type="number" class="form-control" name="txt_quant_produto" id="txt_quant_produto" placeholder="0" min="1"></td>
      <td><input type="text" id="txt_preco" class="form-control" name="txt_preco" placeholder="0.00"></td>
      <td id="txt_preco_total" class="textright">0.00</td>
      <td><button id="add_product_venda" class="btn btn-info"><i class="fas fa-plus"></i>Agregar</button></td>
    </tr>
    <tr><td colspan="6"><span id="msgErrorAgregar"></span></td></tr>
   
    <tr>
      <!--<th>Codigo</th>-->
      <th width="100px">Código</th>
      <th colspan="3">Descrição</th>
      <th>Quantidade</th>
      <th class="textright">Preço</th>
      <th class="textright">Preço Total</th>
      <th>Acção</th>
    </tr>
  </thead>
  <tbody id="detalhe_venda">
  
  </tbody>
  <tfoot id="detalhe_total_venda">
    

  </tfoot>  
</table>

      <div class="card-body">
               <div class="row">
                <div class="col-md-6">
                     <div class="form-group">
                    <label for="txtTipoContrato">Tipo de contrato</label>
                    <select class="form-control" id="txtTipoContrato" name="txtTipoContrato">
                      <option value="Prestacao de Serviços">Prestação de Serviços</option>
                      <option value="Parceria">Parceria</option>
                      <option value="">Aluguer</option>
                    </select>
                  
                  </div>
                  <div class="form-group">
                    <label for="txValorTotal">Valor total</label>
                    <input type="text" class="form-control" id="txValorTotal" name="txValorTotal"  autocomplete="off" readonly>
                  </div>

                   <div class="form-group">
                    <label for="txtValorMensal1">Valor mensal</label>
                    <input type="text" class="form-control" id="txtValorMensal1" name="txtValorMensal1"  autocomplete="off">
                  </div>

                   <div class="form-group">
                    <label for="txtDataAssinatura">Data de assinatura</label>
                    <input type="date" class="form-control" id="txtDataAssinatura" name="txtDataAssinatura"  autocomplete="off">
                  </div>
                </div>
                <div class="col-md-6">
                     <div class="form-group">
                    <label for="txtDataInicio">Data de início</label>
                    <input type="date" class="form-control" id="txtDataInicio" name="txtDataInicio"  autocomplete="off">
                  </div>
                  <div class="form-group">
                    <label for="txtDataVencimentoCont"> Data de vencimento do contrato</label>
                    <input type="date" class="form-control" id="txtDataVencimentoCont" name="txtDataVencimentoCont"  autocomplete="off">
                  </div>

                   <div class="form-group">
                    <label for="txtDuracoaContrat">Duração do contrato</label>
                    <input type="number" class="form-control" id="txtDuracoaContrat" name="txtDuracoaContrat"  autocomplete="off" readonly>
                  </div>

                   <div class="form-group">
                    <label for="txtProvincia">Situação</label>
                    <input type="text" class="form-control" id="txtProvincia" name="txtProvincia"  autocomplete="off">
                  </div>

                
                </div>
               </div>

               
        </div>




</section>



</div>
</div>
      </div>
      <!-- /.container-fluid -->
    </section>
  
  </div>


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

<script type="text/javascript">
  $(document).ready(function(){
    var usuario='<?php echo $codigo;?>';
    searchForDetalheContrato(usuario);
  });
 
</script>


</body>
</html>
