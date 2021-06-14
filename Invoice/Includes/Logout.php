<?php
require_once '../Core/Init.php';

$user=new User();
$user->logout();

Redirect::to('../Index.php');
	