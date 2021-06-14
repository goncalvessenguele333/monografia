<?php
header('Content-Type: text/html; charset=utf-8');
session_start();
	$GLOBALS['config']=array(
		'mysql'=>array(
			'host'=>'188.93.227.106',
			'username'=>"Adminms",
			'password'=>"@PV6GIv@oH6s",
			'db'=>"db_multicastservicos"

		),
		'remember'=>array(
			'cookie_name'=>'hash',
			'cookie_expiry'=>6040800
		),
		'session'=>array(
			'session_name'=>'user',
			'token_name'=>'token'
		)
		
	);
	//mysqli_set_charset($GLOBALS, "utf8");
	header('Content-Type: text/html; charset=utf-8');
	spl_autoload_register(function($class){
		require_once '../classes/'.$class.'.php';
	});
	
	require_once '../Function/Saniteze.php';

	if(Cookies::exists(Config::get('remember/cookie_name')) && !Session::exists(Config::get('session/session_name'))){
		$hash=Cookies::get(Config::get('remember/cookie_name'));
		$hashCheck=DB::getInstance()->get('users_session',array('hash','=',$hash));

		if($hashCheck->count()){
			$user=new User($hashCheck->first()->user_id);
			$user->login();
		}
	}

	