<?php
require_once './Core_/Init.php';

if(Input::exists()){
  if(Token::check(Input::get('token'))){
    $validate=new Validate();
    $validation=$validate->check($_POST,array(
      'username'=>array('required'=>true),
      'password'=>array('required'=>true)
    ));
    if($validation->passed()){
      $user=new User();
      $remember=(Input::get('remember') ==='on') ? true : false;
      $login=$user->login(Input::get('username'),Input::get('password'),$remember);

      if($login){
        //echo 'sucess';


        Redirect::to('./Includes/Principal.php');


      }
      else{
        echo'<p>Sorry, loggin in failed.</p>';
      }

    }
    else
    {
      foreach ($validation->errors() as $error) {
        echo $error,'<br>';
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
  <title>Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="index.html"><b>Multigest </b>Software</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Controlo de acesso</p>

      <form action="" method="Post">
        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Email" name="username" id="username">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="password" id="password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember" name="remember">
              <label for="remember">
               Lembra me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
            <button type="submit" class="btn btn-primary btn-block">Autenticar</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

        <!--  <div class="social-auth-links text-center mb-3">
        <p>- OR -</p>
        <a href="https://web.facebook.com/search/top?q=multicast%20servicos" target="_blank" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i>Facebook
        </a>
        
      </div>
   /.social-auth-links -->

      <p class="mb-1">
        <a href="Includes/forgot-password.php">Esqueci a minha senha</a>
      </p>
     
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>

</body>
</html>
