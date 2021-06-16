 <?php
class User{
	private $_db,
			$_data,
			$_sessionName,
			$_cookieName,
			$_isLoggedIn;

	public function __construct($user=null){
		$this->_db=DB::getInstance();

		$this->_sessionName=Config::get('session/session_name');
		 $this->_cookieName=Config::get('remember/cookie_name');

		if(!$user){
			if(Session::exists($this->_sessionName)){
				$user=Session::get($this->_sessionName);

				if($this->find($user)){
					$this->_isLoggedIn=true;
				}
				else{
					//process logout
				}
			}
		}
		else{
			$this->find($user);
		}
	}

	public function update($fields=array(), $id=null){
		if(!$id && $this->isLoggedIn()){
			$id=$this->data()->id;
		}
		if(!$this->_db->update('users', $id,$fields)){
			throw new Exception("There was a problem updating");
			
		}
	}

	public function create($fields=array()){

		if(!$this->_db->insert('users',$fields)){
			throw new Exception("There was a problem creating an account");
			
		}
	}


	public function createImagem($fields=array()){

		if(!$this->_db->insert('arquivo',$fields)){
			throw new Exception("There was a problem creating an account");
			
		}
	}

	public function FuncionarioLog($codigo){
	$sql=$this->_db->consulta("SELECT id,name,contact,username,joined, arquivo FROM users WHERE id='$codigo'");
	if($sql){
		return $sql->results();
	}
}

	public function emailUser($email){
	$sql=$this->_db->consulta("SELECT id,name,contact,username,joined FROM users WHERE username='$email'");
	if($sql){
		return $sql->results();
	}
}


	public function gravaCliente($fields=array()){

		if(!$this->_db->insert('tb_cliente',$fields)){
			throw new Exception("Houve problemas ao gravar cliente.");
			
		}
	}
	public function actualizarCliente($id, $fields=array()){

	$fun=new User();
		
		if(!$fun->_db->actualizaCli('tb_cliente', $id, $fields)) {
			throw new Exception("There was a problem updating funcionario");
			
		}

	}
public function actualizarUser($id, $fields=array()){

	$fun=new User();
		
		if(!$fun->_db->update('users', $id, $fields)) {
			throw new Exception("There was a problem updating funcionario");
			
		}

	}

	public function find($user=null){
		if($user){
			$field=(is_numeric($user)) ? 'id' : 'username';
			$data=$this->_db->get('users',array($field, '=', $user));

			if($data->count()){
				$this->_data=$data->first();
				return true;
			}
		}
		return false;
	}
	public function login($username=null, $password=null,$remember=false ){
		if(!$username && $password && $this->exists()){
Session::put($this->_sessionName,$this->data()->id); 
		}
		else{
			$user=$this->find($username);

	
		if($user){
			
			if ($this->data()->password === Hash::make($password)) {

				Session::put($this->_sessionName,$this->data()->id);
if($remember){
	$hash=Hash::unique();
	$hashCheck=$this->_db->get('users_session',array('user_id','=',$this->data()->id));

	if(!$hashCheck->count())
	{
		     $this->_db->insert('users_session', array(
			 'user_id'=> $this->data()->id,
		  	 'hash'=>$hash 
			 ));
	}
	else
	{
		$hash=$hashCheck->first()->hash;
	}

		Cookies::put($this->_cookieName, $hash, Config::get('remember/cookie_expiry'));

}
return true;
}

}
	}
	return false;
}


public function hasPermission($key){
	$group=$this->_db->get('groups',array('id','=',$this->data()->group));

if($group->count()){
	$permissions=json_decode($group->first()->permissions,true);
	

	if($permissions[$key] == true){
		return true;
	}
}
return false;
}

public function exists(){
	return (!empty($this->_data)) ? true : false;
}
	public function data(){
		return $this->_data;
	}
	public function logout(){
		$this->_db->delete('users_session',array('user_id','=',$this->data()->id));
		Session::delete($this->_sessionName);
		Cookies::delete($this->_cookieName);
	}
	public function isLoggedIn(){
		return $this->_isLoggedIn;
	}

public function gravaDetalhe_temp($fields=array()){

		if(!$this->_db->insert('tb_detalhe_temp',$fields)){
			throw new Exception("Houve problemas ao gravar.");
			
		}
	}

	public function gravaDetalheContrato_temp($fields=array()){

		if(!$this->_db->insert(' tb_detalheContrato_temp',$fields)){
			throw new Exception("Houve problemas ao gravar.");
			
		}
	}

	public function gravaDetalhe_temp_cotacao($fields=array()){

		if(!$this->_db->insert('tb_detalhe_temp_cotacao',$fields)){
			throw new Exception("Houve problemas ao gravar.");
			
		}
	}

	public function gravaDadosContrato($fields=array()){

		if(!$this->_db->insert('tb_contrato',$fields)){
			throw new Exception("Houve problemas ao gravar.");
			
		}
	}

		public function gravamensalidade_tmp($fields=array()){

		if(!$this->_db->insert('tb_mensalidade_tmp',$fields)){
			throw new Exception("Houve problemas ao gravar.");
			
		}
	}
	public function gravapagamentocontrato($fields=array()){

		if(!$this->_db->insert('tb_pagamento_contrato',$fields)){
			throw new Exception("Houve problemas ao gravar.");
			
		}
	}

	public function actualizacontroloRecibemento($id, $fields=array()){

		$fun=new User();
		
		if(!$fun->_db->actualizaRecebimentoContr('tb_controlo_recebimento_contrato', $id, $fields)) {
			throw new Exception("There was a problem updating funcionario");
			
		}

	}

public function listaDadosEmpresa($codigo){
	$sql=$this->_db->consulta("SELECT * FROM tb_dadosempresa WHERE codigo=$codigo");
	if($sql){
		return $sql->results();
	}
}
public function actualizaDadosEmpresa($id, $fields=array()){

	$fun=new User();
		/*if(!$id && $fun->isLoggedIn()){
			$id=$fun->data()->codigo;
		}*/
		//$id=$fun->data()->codigo;
		if(!$fun->_db->actualiza('tb_dadosempresa', $id, $fields)) {
			throw new Exception("There was a problem updating empresa");
			
		}

	}

public function detalheTotalFactura($codFactura){
	$sql=$this->_db->consulta("SELECT nr_factura, usuario, cod_cliente, subtotal_factura,perc_desconto,subTotal_descontado, iva_factura, total_factura, estado, dataVenda FROM tb_factura WHERE nr_factura='$codFactura'");
	if($sql){
		return $sql->results();
	}
	
}

public function detalheTotal_cotacao($codFactura){
	$sql=$this->_db->consulta("SELECT nr_factura, usuario, cod_cliente, subtotal_factura,perc_desconto,valor_descontado, iva_factura, total_factura, estado,dataVenda, Year(dataVenda) as ano FROM tb_cotacao WHERE nr_factura='$codFactura'");
	if($sql){
		return $sql->results();
	}
	
}

public function pesquisaContrato($codContrato){
	$sql=$this->_db->consulta("SELECT tipo_contrato,usuario,valor_contrato, valor_prestacao,Year(data_assinatura) as anoAssinatura FROM tb_contrato  WHERE cod_contrato = '$codContrato'");
	if($sql){
		return $sql->results();
	}
	
}
public function detalheContrato($codContrato){
	$sql=$this->_db->consulta("SELECT nr_contrato, cod_produto,description,quantidade, valor,valor_subtotal FROM tb_detalhe_contrato  WHERE nr_contrato = '$codContrato'");
	if($sql){
		return $sql->results();
	}
	
}
// tb_detalhe_contrato

	public function PesquisaCliente($idCliente){
	$sql=$this->_db->query("SELECT * FROM tb_cliente WHERE idCliente = '$idCliente'");
	if($sql){
		return $sql->results();
	}
}

	public function TotalCliente(){
	$sql=$this->_db->query("SELECT COUNT(idCliente) as totalClientes FROM tb_cliente");
	if($sql){
		return $sql->results();
	}
}

public function TotalFactura(){
	$sql=$this->_db->query("SELECT COUNT(nr_factura) as totalFacturas FROM tb_factura");
	if($sql){
		return $sql->results();
	}
}
public function TotalContratos(){
	$sql=$this->_db->query("SELECT COUNT(cod_contrato) as totalContratos FROM tb_contrato WHERE estado='Em vigente'");
	if($sql){
		return $sql->results();
	}
}

public function TotalCotaco(){
	$sql=$this->_db->query("SELECT COUNT(nr_factura) as totalCotacao FROM tb_cotacao");
	if($sql){
		return $sql->results();
	}
}

public function detalheFactura($codi_prod){
	$sql=$this->_db->consulta("SELECT df.correlativo, df.cod_produto, df.description, df.quantidade,df.preco, df.subtotal_prod,df.perc_desconto FROM tb_detalhe_factura df INNER JOIN tb_factura f ON df.nr_factura=f.nr_factura WHERE
								 	 f.nr_factura='$codi_prod'");
	if($sql){
		return $sql->results();
	}
	
}
public function detalheCotacao($codi_prod){
	$sql=$this->_db->consulta("SELECT df.correlativo,df.cod_servico, df.description, df.quantidade, df.preco,df.perc_desconto,df.subtotal_prod FROM tb_detalhe_cotacao df INNER JOIN 
								tb_cotacao f ON df.nr_factura=f.nr_factura WHERE
								 f.nr_factura='$codi_prod'");
	if($sql){
		return $sql->results();
	}
	
}

	}
