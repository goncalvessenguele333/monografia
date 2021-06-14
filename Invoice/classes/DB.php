 <?php
class DB{
	private static $_instance=null;
	private $_pdo,
	$_query,
	$_error=false,
	$_result,
	$_count=0; 


private function __construct(){
//header('Content-Type: text/html; charset=utf-8');
	ini_set('default-charset', 'UTF-8');
		try{
			$this->_pdo=new PDO('mysql:host='.Config::get('mysql/host').';
			dbname='.Config::get('mysql/db'),Config::get('mysql/username'),Config::get('mysql/password'));

	$this->_pdo->query("SET NAMES utf8");
		}
		catch(PDOException $e)
		{
			die($e->getMessage());
		}
	}
	public static function getInstance()
	{		
		if(!isset(self::$_instance)){
			self::$_instance=new DB();
		}
		return self::$_instance;
	}


	public function query($sql,$params=array()){
		$this->_error=false;
		if($this->_query=$this->_pdo->prepare($sql)){
			//echo "sucess";
			
			$x=1;
			if(count($params)){
				foreach ($params as $param) {
					$this->_query->bindValue($x,$param);
					$x++;
				}
			}
			if($this->_query->execute()){
				//echo "sucess";
				$this->_result=$this->_query->fetchAll(PDO::FETCH_OBJ);
				$this->_count=$this->_query->rowCount();
			}
			else{
				$this->_error=true;
			} 
		}
		return $this;
	}

		public function consulta($sql){
		$this->_error=false;
		if($this->_query=$this->_pdo->prepare($sql)){
			//echo "sucess";
			if($this->_query->execute()){
				//echo "sucess";
				$this->_result=$this->_query->fetchAll(PDO::FETCH_OBJ);
				$this->_count=$this->_query->rowCount();
			}
			else{
				$this->_error=true;
			} 
		}
		return $this;
	}
	public function actualizaCli($table, $codigo,$fields){
	$set= '';
	$x=1;
	foreach ($fields as $name => $value) {
		$set .="{$name} = ?";
		if($x<count($fields)){
			$set .=', ';
		}
		$x++;
	}
	$sql="UPDATE {$table} SET {$set} WHERE idCliente = {$codigo}";
	if(!$this->query($sql,$fields)->error()){
		return true;
	}
	return false;
}

	public function actualizaRecebimentoContr($table, $codigo,$fields){
	$set= '';
	$x=1;
	foreach ($fields as $name => $value) {
		$set .="{$name} = ?";
		if($x<count($fields)){
			$set .=', ';
		}
		$x++;
	}
	$sql="UPDATE {$table} SET {$set} WHERE cod_contrato= {$codigo}";
	if(!$this->query($sql,$fields)->error()){
		return true;
	}
	return false;
}

public function action($action,$table,$where=array())
	{
		
		if(count($where)===3){
			$operators=array('=','>','<','>=','<=');
			$field		= 	$where[0];
			$operator	=	$where[1];
			$value 		=	$where[2];

			if(in_array($operator, $operators)){
				
				$sql="{$action} FROM {$table} WHERE {$field} {$operator} ?";
				if(!$this->query($sql,array($value))->error()){
					return $this;
					
				}
			}
		} 
		return false;

	}
	public function insert($table,$fields=array()){
		if(count($fields)){
			$keys=array_keys($fields);
			$values='';
			$x=1;
			foreach ($fields as $field) {
				$values .='?';
				if($x<count($fields)){
					$values .= ', ';
				}
				$x++;
			}

		$sql="INSERT INTO {$table}(`" . implode('`, `',$keys) . "`) VALUES ({$values})";
			if(!$this->query($sql , $fields)->error()){
				return true;
			}
		}
		return false;
	}
public function update($table, $codigo,$fields){
	$set= '';
	$x=1;
	foreach ($fields as $name => $value) {
		$set .="{$name} = ?";
		if($x<count($fields)){
			$set .=', ';
		}
		$x++;
	}
	$sql="UPDATE {$table} SET {$set} WHERE id = {$codigo}";
	if(!$this->query($sql,$fields)->error()){
		return true;
	}
	return false;
}

public function actualiza($table, $codigo,$fields){
	$set= '';
	$x=1;
	foreach ($fields as $name => $value) {
		$set .="{$name} = ?";
		if($x<count($fields)){
			$set .=', ';
		}
		$x++;
	}
	$sql="UPDATE {$table} SET {$set} WHERE codigo = {$codigo}";
	if(!$this->query($sql,$fields)->error()){
		return true;
	}
	return false;
}


	public function get($table,$where){
return $this->action('SELECT *',$table,$where);
		
	}
	public function delete($table,$where){
   return $this->action('DELETE',$table,$where);
	}
	public function error(){
		return $this->_error;
	}
	public function results(){
		return $this->_result; 
	}
	public function first(){
		return $this->results()[0];
	}
	public function count(){
		return $this->_count;
	}

	}
