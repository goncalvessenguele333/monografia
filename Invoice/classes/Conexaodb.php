<?php

/*$host='localhost';
$user='root';
$password='';
$db='db_multicastservicos';*/
ini_set('default-charset', 'UTF-8');
$host='188.93.227.106';
$user='Adminms';
$password='@PV6GIv@oH6s';
$db='db_multicastservicos';

$conexao=@mysqli_connect($host,$user,$password,$db);

if(!$conexao){
	echo "Error de conexao";
}
$conexao->query("SET NAMES utf8");

?>
