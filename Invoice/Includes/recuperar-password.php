<?php
require_once '../Core/Init.php';
include '../classes/Conexaodb.php';


if(isset($_GET['cod_user'])){
 $cod_user=$_GET['cod_user'];
}
$user=new User();

if(Input::exists()){
  if(Token::check(input::get('token'))){
    $validate=new Validate();
  $validation=$validate->check($_POST, array(
     'password_new'=>array(
        'required'=>true,
        'min'=>6
      ),
      'password_new_again'=>array(
        'required'=>true,
        'min'=>6,
        'matches'=>'password_new'
      )

    ));
   if($validation->passed())
    {
     

    $salt=Hash::salt(32);
        $user->actualizarUser($cod_user, array(
          'password'=>Hash::make(Input::get('password_new')),
          'salt'=>$salt

        ));
        Session::flash('home,your password has been changed');
        Redirect::to('../Index.php');
    
    }
    else{
      foreach ($validation->errors() as $error) {
        echo $error, '<br>';

      }
    }
  }
}

?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Recuperar Password</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">

   <a href="#"><b>Multigest</b>Software</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      

      <form action="" method="Post">
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password_new" id="password_new" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password_new_again" id="password_new_again" placeholder="Confirma Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Alterar password</button>
             <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
          </div>
          <!-- /.col -->
        </div>
      </form>

      <p class="mt-3 mb-1">
        <a href="../Index.php">Login</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>

</body>
</html>
