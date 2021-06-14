<?php

require_once '../Core/Init.php';
include '../classes/Conexaodb.php';

$user=new User();

$email = $_POST['email'];

foreach ($user->emailUser($email) as $lista) 
{

$codUser = $lista->id;

 $user->actualizarUser($codUser, array(
          'password'=>'',
          'salt'=>''

        ));


Redirect::to('./recuperar-password.php?cod_user='.$codUser);

}

//Redirect::to('../Index.php);








