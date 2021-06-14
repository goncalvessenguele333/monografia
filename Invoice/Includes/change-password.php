<?php
require_once '../Core/Init.php';
$user=new User();
if(!$user->isLoggedIn()){
  Redirect::to(Index.php);
}
if($user->isLoggedIn()){
$codigo= ($user->data()->id); 
}
if(Input::exists()){
  if(Token::check(input::get('token'))){
    $validate=new Validate();
    $validation=$validate->check($_POST, array(
      'password_current'=>array(
        'required'=>true,
        'min'=>6
      ),
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
      if(Hash::make( Input::get('password_current')) !==$user->data()->password)
      {
        echo 'Your current password is wrong';
      }
      else{

$salt=Hash::salt(32);
        $user->update(array(
          'password'=>Hash::make(Input::get('password_new')),
          'salt'=>$salt

        ));
        Session::flash('home,your password has been changed');
        Redirect::to('../Index.php');
      }
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
  <title>Recover Password</title>
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
      <p class="login-box-msg">Altere a sua senha agora</p>

      <form action="" method="post">
      <div class="input-group mb-3">
          <input type="password" class="form-control" name="password_current" id="password_current" placeholder="Password actual">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password_new" id="password_new" placeholder="Nova Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password_new_again" id="password_new_again" placeholder="Confirma a nova Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Alterar a senha</button>
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