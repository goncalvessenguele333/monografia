<?php

include 'Conexaodb.php';
require_once '../Core/Init.php';
if(Session::exists('home')){
  echo '<p>'.Session::flash('home').'</p>';
}


$user=new User();
if(!$user->isLoggedIn()){
  Redirect::to('../Index.php');
 }
if($user->isLoggedIn()){
$codigoLog= ($user->data()->id); 
}


if(!empty($_POST)){


if($_POST['action']=='activarUsuario'){
	if(empty($_POST['codUsuario'])){
			echo 'error';
		}
		else{
			$codUsuario=$_POST['codUsuario'];

			$fun=new User();

			$fun->actualizarFuncionario($codUsuario, array(
				'estado'		=>1

			));
			echo 'Actualizado com sucesso';


		}

	exit;
}
if($_POST['action']=='actualizaCliente'){

	if(empty($_POST['txtNuitCliente1'])){
		echo 'error';
	}
	else if(empty($_POST['idCliente'])){
		echo 'error';
	}
	else if(empty($_POST['txtNomeCliente1'])){
		echo 'error';
	}
	else if(empty($_POST['txtTelefoneCliente1'])){
		echo 'error';
	}
	else if(empty($_POST['txtEnderecoCliente1'])){
		echo 'error';
	}
	else if(empty($_POST['tipoCliente'])){
		echo 'error';
	}
	else if(empty($_POST['emailCliente'])){
		echo 'error';
	}
	else if (empty($_POST['estadoCliente'])) {
		echo 'error';
	}
	else{

	$nuitCl=$_POST['txtNuitCliente1'];
	$idCliente=$_POST['idCliente'];
	$nomeCl=$_POST['txtNomeCliente1'];
	$telefoneCl=$_POST['txtTelefoneCliente1'];
	$enderecoCl=$_POST['txtEnderecoCliente1'];
	$usuario_id=$codigoLog;
	$ivaCliente=$_POST['ivaCliente'];
	$tipoCliente=$_POST['tipoCliente'];
	$emailCliente=$_POST['emailCliente'];
	$estadoCliente=$_POST['estadoCliente'];
//$iva=17;

		$cliente=new User();
		$cliente->actualizarCliente($idCliente,array(
		'nuitCliente'		=>$nuitCl,
		'nomeCliente'		=>$nomeCl,
		'endereco'			=>$enderecoCl,		
		'contactoCliente'	=>$telefoneCl,
		'iva'				=>$ivaCliente,
		'usuario'			=>$usuario_id,
		'tipo'				=>$tipoCliente,
		'email'				=>$emailCliente,
		'estado'			=>$estadoCliente
));
echo "Actualizado com sucesso";
}



	exit;
}

if($_POST['action']=='anularUsuario'){
	if(empty($_POST['codUsuario'])){
			echo 'error';
		}
		else{
			$codUsuario=$_POST['codUsuario'];

			$fun=new User();

			$fun->actualizarFuncionario($codUsuario, array(
				'estado'		=>2

			));
			echo 'Actualizado com sucesso';


		}

	exit;
}

if($_POST['action']=='actualizarCliente'){

	if(empty($_POST['idClient'])){
			echo 'error';
		}
		else if(empty($_POST['nomeClient'])){
			echo 'error';
		}
		else if(empty($_POST['enderecoClient'])){
			echo 'error';
		}
		else if(empty($_POST['nuitClient'])){
			echo 'error';
		}
		else if(empty($_POST['contactoClient'])){
			echo 'error';
		}
		else{
			$idClient=$_POST['idClient'];
			$nomeClient=$_POST['nomeClient'];
			$enderecoClient=$_POST['enderecoClient'];
			$nuitClient=$_POST['nuitClient'];
			$contactoClient=$_POST['contactoClient'];
			$ivaCliente=$_POST['ivaCliente'];
			$usuario_id=$codigoLog;
			
			$cliente=new User();
			$cliente->actualizarCliente($idClient, array(
					'nuitCliente'			=>$nuitClient,
					'nomeCliente'			=>$nomeClient,
					'endereco'				=>$enderecoClient,
					'contactoCliente'		=>$contactoClient,
					'iva'					=>$ivaCliente,
					'usuario'				=>$usuario_id
			));
			echo "Actualizado com sucesso";
		}



	exit;
}


if($_POST['action']=='seachCliente'){
		    
		if(!empty($_POST['cliente'])){
			$codCl=$_POST['cliente'];
			$query= mysqli_query($conexao,"SELECT * FROM tb_cliente WHERE idCliente = $codCl");
			mysqli_close($conexao);
			$result=mysqli_num_rows($query);
			$data='';
			if($result>0){
				$data=mysqli_fetch_assoc($query);
			}else{
				$data=0;
			}
	
		echo json_encode($data,JSON_UNESCAPED_UNICODE);
	}
//OR nomeCliente LIKE '$nomeC'%
exit;
}


if($_POST['action']=='seach_Nome_Cliente'){
		    
		if(!empty($_POST['nome'])){
			$nome=$_POST['nome'];
			$query= mysqli_query($conexao,"SELECT * FROM tb_cliente WHERE nomeCliente LIKE '$nome%'");
			mysqli_close($conexao);
			$result=mysqli_num_rows($query);
			$data='';
			if($result>0){
				$data=mysqli_fetch_assoc($query);
			}else{
				$data=0;
			}
	
		echo json_encode($data,JSON_UNESCAPED_UNICODE);
	}
//OR nomeCliente LIKE '$nomeC'%
exit;
}


if($_POST['action']=='addProdutoDetalheContrato'){
//	print_r($_POST);
	if(empty($_POST['descProduto'])){
		echo 0;
	}
	else if(empty($_POST['preco'])){
		echo 0;
	}
	else if(empty($_POST['precoTotal'])){
		echo 0;
	}
	else if(empty($_POST['quanti'])){
		echo 0;
	}
	else if(empty($_POST['codCliente'])){
		echo 0;
	}
	else if(empty($_POST['codproducto'])){
		echo 0;
	}
	else{
		$descProduto=$_POST['descProduto'];
		$preco=$_POST['preco'];
		$precoTotal=$_POST['precoTotal'];
		$quantidade=$_POST['quanti'];
		$codCliente=$_POST['codCliente'];
		$codproducto=$_POST['codproducto'];

		$token_user=$codigoLog;


		$query_iva=mysqli_query($conexao,"SELECT iva FROM tb_cliente WHERE idCliente='$codCliente'");
		$result_iva=mysqli_num_rows($query_iva);

	$detalhe_temp=new User();
			$detalhe_temp->gravaDetalheContrato_temp(array(
					'codUsuario'		=>$token_user,
					'codCliente'		=>$codCliente,
					'cod_produto'		=>$codproducto,
					'description'		=>$descProduto,
					'quantidade'		=>$quantidade,
					'valor'				=>$preco,
					'valor_subtotal'		=>$precoTotal
			));
		
$query_detalhe_temp=mysqli_query($conexao,"SELECT * FROM tb_detalheContrato_temp WHERE 	codUsuario=$token_user");
		$result=mysqli_num_rows($query_detalhe_temp);
		$detalheTable='';
		$sub_total=0;
		$iva=0;
		$total=0;
		$arrayData=array();

		if($result > 0){
			if($result_iva > 0){
				$info_iva=mysqli_fetch_assoc($query_iva);
					$iva=$info_iva['iva'];
			
			while ($data=mysqli_fetch_assoc($query_detalhe_temp)) {
				$precoTotal1=round($data['quantidade'] * $data['valor'],2);
				$sub_total=round($sub_total + $precoTotal1, 2);
				$total=round($total + $precoTotal1, 2);

				$detalheTable .='
							<tr>	
							<td>'.$data['cod_produto'].'</td>						
							<td colspan="3">'.$data['description'].'</td>
							<td class="textright">'.$data['quantidade'].'</td>
							<td class="textright">'.$data['valor'].'</td>
							<td class="textright">'.$precoTotal1.'</td>
							<td class="">
								<button class="btn btn-default" data-toggle="tooltip" title="Elimina o produto" onclick="event.preventDefault();del_produt_detalhe_Contrato('.$data['correlativo'].');"><i class="far fa-trash-alt "></i></button>
							</td>
						</tr>';

			}

			/*$imposto=round($sub_total * ($iva / 100),2);
			//$tl_sniva=round($sub_total - $imposto, 2);
			$total=round($sub_total + $imposto,2);*/

			$detalhe_total_venda ='
							<tr>
										<td colspan="6" class="textright">Subtotal Q.</td>
										<td class="textright">'.$sub_total.'</td>
									</tr>
									';

									$arrayData['detalhe']=$detalheTable;
									$arrayData['total']=$detalhe_total_venda;
									$arrayData['valor_total']=$sub_total;

									echo json_encode($arrayData,JSON_UNESCAPED_UNICODE);
		
}
		}
		else{
			$arrayData=0;
		}

		mysqli_close($conexao);
}
	
exit;
	}

//Agregar produtos de detalhe temporal..

if($_POST['action']=='addProdutoDetalhe'){
//	print_r($_POST);
	if(empty($_POST['descProduto'])){
		echo 0;
	}
	else if(empty($_POST['preco'])){
		echo 0;
	}
	else if(empty($_POST['precoTotal'])){
		echo 0;
	}
	else if(empty($_POST['quanti'])){
		echo 0;
	}
	else if(empty($_POST['codCliente'])){
		echo 0;
	}
	else if(empty($_POST['codproducto'])){
		echo 0;
	}
	else{
		$descProduto=$_POST['descProduto'];
		$preco=$_POST['preco'];
		$precoTotal=$_POST['precoTotal'];
		$quantidade=$_POST['quanti'];
		$codCliente=$_POST['codCliente'];
		$codproducto=$_POST['codproducto'];
		$desconto=$_POST['desconto'];
		$token_user=$codigoLog;


		$query_iva=mysqli_query($conexao,"SELECT iva FROM tb_cliente WHERE idCliente='$codCliente'");
		$result_iva=mysqli_num_rows($query_iva);

	$detalhe_temp=new User();
			$detalhe_temp->gravaDetalhe_temp(array(
					'token_user'		=>$token_user,
					'codCliente'		=>$codCliente,
					'cod_produto'		=>$codproducto,
					'description'		=>$descProduto,
					'quantidade'		=>$quantidade,
					'preco'				=>$preco,
					'subtotal_prod'		=>$precoTotal,
					'perc_desconto'		=>$desconto
			));
		
$query_detalhe_temp=mysqli_query($conexao,"SELECT * FROM tb_detalhe_temp WHERE token_user='$token_user'");
		$result=mysqli_num_rows($query_detalhe_temp);
		$detalheTable='';
		$sub_total=0;
		$iva=0;
		$total=0;
		$arrayData=array();

		if($result > 0){
			if($result_iva > 0){
				$info_iva=mysqli_fetch_assoc($query_iva);
					$iva=$info_iva['iva'];
			
			while ($data=mysqli_fetch_assoc($query_detalhe_temp)) {
				$precoTotal1=round($data['quantidade'] * $data['preco'],2);
				$sub_total=round($sub_total + $precoTotal1, 2);
				$total=round($total + $precoTotal1, 2);

				$detalheTable .='
							<tr>	
							<td>'.$data['cod_produto'].'</td>						
							<td colspan="3">'.$data['description'].'</td>
							<td class="textright">'.$data['quantidade'].'</td>
							<td class="textright">'.$data['preco'].'</td>
							<td class="textright">'.$data['perc_desconto'].'</td>
							<td class="textright">'.$precoTotal1.'</td>
							<td class="">
								<button class="btn btn-default" data-toggle="tooltip" title="Elimina o produto" onclick="event.preventDefault();del_produt_detalhe('.$data['correlativo'].');"><i class="far fa-trash-alt "></i></button>
							</td>
						</tr>';

			}

			$imposto=round($sub_total * ($iva / 100),2);
			//$tl_sniva=round($sub_total - $imposto, 2);
			$total=round($sub_total + $imposto,2);

			$detalhe_total_venda ='
							<tr>
										<td colspan="7" class="textright">Valor líquido Q.</td>
										<td class="textright">'.$sub_total.'</td>
									</tr>
									<tr>
										<td colspan="7" class="textright">Desconto(0%)</td>
										<td class="textright">'.'0,00'.'</td>
									</tr>
									<tr>
										<td colspan="7" class="textright">Subtotal</td>
										<td class="textright">'.$sub_total.'</td>
									</tr>
									<tr>
										<td colspan="7" class="textright">IVA('.$iva.')</td>
										<td class="textright">'.$imposto.'</td>
									</tr>
									<tr>
										<td colspan="7" class="textright">Total</td>
										<td class="textright">'.$total.'</td>
									</tr>';

									$arrayData['detalhe']=$detalheTable;
									$arrayData['total']=$detalhe_total_venda;

									echo json_encode($arrayData,JSON_UNESCAPED_UNICODE);
		
}
		}
		else{
			$arrayData=0;
		}

		mysqli_close($conexao);
}
	
exit;
	}




	if($_POST['action']=='addProdutoDetalheCotacao'){
	//print_r($_POST);
	if(empty($_POST['descProduto'])){
		echo 0;
		
	}
else if(empty($_POST['cod_servico'])){
		echo 0;
	}
		else if(empty($_POST['preco'])){
		echo 0;
	}
	else if(empty($_POST['precoTotal'])){
		echo 0;
	}
	else if(empty($_POST['quanti'])){
		echo 0;
	}
	else if(empty($_POST['cod_Cliente'])){
		echo 0;
	}
	else{
		$descProduto=$_POST['descProduto'];
		$cod_servico=$_POST['cod_servico'];
		$preco=$_POST['preco'];
		$precoTotal=$_POST['precoTotal'];
		$quantidade=$_POST['quanti'];
		$cod_Cliente=$_POST['cod_Cliente'];
		$desconto=$_POST['desconto'];
		$token_user=$codigoLog;



		$query_iva=mysqli_query($conexao,"SELECT iva FROM tb_cliente WHERE idCliente='$cod_Cliente'");
		$result_iva=mysqli_num_rows($query_iva);

		

		$detalhe_temp=new User();
			$detalhe_temp->gravaDetalhe_temp_cotacao(array(
					'token_user'		=>$token_user,
					'cod_Cliente'		=>$cod_Cliente,
					'cod_servico'		=>$cod_servico,
					'description'		=>$descProduto,
					'quantidade'		=>$quantidade,
					'preco'				=>$preco,
					'subtotal_prod'		=>$precoTotal,
					'perc_desconto'		=>$desconto
			));
		
$query_detalhe_temp=mysqli_query($conexao,"SELECT * FROM tb_detalhe_temp_cotacao WHERE token_user='$token_user'");
		$result=mysqli_num_rows($query_detalhe_temp);
		$detalheTable='';
		$sub_total=0;
		$iva=0;
		$total=0;
		$arrayData=array();

		if($result > 0){
			if($result_iva > 0){
				$info_iva=mysqli_fetch_assoc($query_iva);
					$iva=$info_iva['iva'];
			
			while ($data=mysqli_fetch_assoc($query_detalhe_temp)) {
				$precoTotal1=round($data['quantidade'] * $data['preco'],2);
				$sub_total=round($sub_total + $precoTotal1, 2);
				$total=round($total + $precoTotal1, 2);

				$detalheTable .='
							<tr>
							<td>'.$data['cod_servico'].'</td>						
							<td colspan="3">'.$data['description'].'</td>
							<td class="textright">'.$data['quantidade'].'</td>
							<td class="textright">'.$data['preco'].'</td>
							<td class="textright">'.$data['perc_desconto'].'</td>
							<td class="textright">'.$precoTotal1.'</td>
							<td class="">
								<button class="btn btn-default" data-toggle="tooltip" title="Elimina o produto" onclick="event.preventDefault();del_produt_detalhe('.$data['correlativo'].');"><i class="far fa-trash-alt "></i></button>
							</td>
						</tr>';

			}

			$imposto=round($sub_total * ($iva / 100),2);
			//$tl_sniva=round($sub_total - $imposto, 2);
			$total=round($sub_total + $imposto,2);

			$detalhe_total_venda ='
							<tr>
										<td colspan="7" class="textright">Subtotal Q.</td>
										<td class="textright">'.$sub_total.'</td>
									</tr>
									<tr>
										<td colspan="7" class="textright">Desconto(0%)</td>
										<td class="textright">'.'0.00'.'</td>
									</tr>
									<tr>
										<td colspan="7" class="textright">Subtotal Q.</td>
										<td class="textright">'.$sub_total.'</td>
									</tr>
									<tr>
										<td colspan="7" class="textright">IVA('.$iva.')</td>
										<td class="textright">'.$imposto.'</td>
									</tr>
									<tr>
										<td colspan="7" class="textright">Total</td>
										<td class="textright">'.$total.'</td>
									</tr>';

									$arrayData['detalhe']=$detalheTable;
									$arrayData['total']=$detalhe_total_venda;

									echo json_encode($arrayData,JSON_UNESCAPED_UNICODE);
		
}
		}
		else{
			$arrayData=0;
		}

	mysqli_close($conexao);
}
	
exit;
	}


//Extrair dados da tabela detalhe_temp....
if($_POST['action']=='searchForDetalhe'){

	//print_r($_POST);
	if(empty($_POST['user'])){
		echo 0;
	}
	else{
		$token_user=$_POST['user'];

		$query=mysqli_query($conexao,"SELECT correlativo,
							token_user,perc_desconto,codCliente,cod_produto,description,quantidade,
							preco,subtotal_prod FROM tb_detalhe_temp WHERE 
							token_user=$token_user");

		$result=mysqli_num_rows($query);

		

		$detalheTable='';
		$sub_total=0;
		$iva=17;
		$total=0;
		$arrayData=array();

		if($result > 0){

			
			while ($data=mysqli_fetch_assoc($query)) {
				$precoTotal=round($data['quantidade'] * $data['preco'],2);
				$sub_total=round($sub_total + $precoTotal, 2);
				$total=round($total + $precoTotal, 2);

				$detalheTable .='
							<tr>
							<td>'.$data['cod_produto'].'</td>
							<td colspan="3">'.$data['description'].'</td>
							<td class="textright">'.$data['quantidade'].'</td>
							<td class="textright">'.$data['preco'].'</td>
							<td class="textright">'.$data['perc_desconto'].'</td>
							<td class="textright">'.$precoTotal.'</td>
							<td class="">
								<button class="btn btn-default" onclick="event.preventDefault();del_produt_detalhe('.$data['correlativo'].');"><i class="far fa-trash-alt "></i></button>
							</td>
						</tr>';

			}
			$imposto=round($sub_total * ($iva / 100),2);
			//$tl_sniva=round($sub_total - $imposto, 2);
			$total=round($sub_total + $imposto,2);

			$detalhe_total_venda ='
							<tr>
										<td colspan="7" class="textright">Valor líquido Q.</td>
										<td class="textright">'.$sub_total.'</td>
									</tr>
									<tr>
										<td colspan="7" class="textright">Desconto(0%)</td>
										<td class="textright">'.'0,00'.'</td>
									</tr>
									<tr>
										<td colspan="7" class="textright">Subtotal</td>
										<td class="textright">'.$sub_total.'</td>
									</tr>
									<tr>
										<td colspan="7" class="textright">IVA('.$iva.')</td>
										<td class="textright">'.$imposto.'</td>
									</tr>
									<tr>
										<td colspan="7" class="textright">Total</td>
										<td class="textright">'.$total.'</td>
									</tr>';

									$arrayData['detalhe']=$detalheTable;
									$arrayData['total']=$detalhe_total_venda;

									echo json_encode($arrayData,JSON_UNESCAPED_UNICODE);
		}
		else{
			$arrayData=0;
		}

		//mysqli_close($conexao);
}
exit;
	}


	if($_POST['action']=='searchForDetalheContrato'){

	//print_r($_POST);
	if(empty($_POST['user'])){
		echo 0;
	}
	else{
		$token_user=$_POST['user'];

		$query=mysqli_query($conexao,"SELECT correlativo,codUsuario,codCliente,cod_produto,
										description,quantidade,valor,valor_subtotal FROM tb_detalheContrato_temp WHERE codUsuario=$token_user");

		$result=mysqli_num_rows($query);

		

		$detalheTable='';
		$sub_total=0;
		$iva=17;
		$total=0;
		$arrayData=array();

		if($result > 0){

			
			while ($data=mysqli_fetch_assoc($query)) {
				$precoTotal=round($data['quantidade'] * $data['valor'],2);
				$sub_total=round($sub_total + $precoTotal, 2);
				$total=round($total + $precoTotal, 2);

				$detalheTable .='
							<tr>
							<td>'.$data['cod_produto'].'</td>
							<td colspan="3">'.$data['description'].'</td>
							<td class="textright">'.$data['quantidade'].'</td>
							<td class="textright">'.$data['valor'].'</td>
							<td class="textright">'.$precoTotal.'</td>
							<td class="">
								<button class="btn btn-default" onclick="event.preventDefault();del_produt_detalhe_Contrato('.$data['correlativo'].');"><i class="far fa-trash-alt "></i></button>
							</td>
						</tr>';

			}
			$detalhe_total_venda ='
							<tr>
										<td colspan="6" class="textright">Subtotal Q.</td>
										<td class="textright">'.$sub_total.'</td>
									</tr>';

									$arrayData['detalhe']=$detalheTable;
									$arrayData['total']=$detalhe_total_venda;
									$arrayData['valor_total']=$sub_total;

									echo json_encode($arrayData,JSON_UNESCAPED_UNICODE);
		}
		else{
			$arrayData=0;
		}

		//mysqli_close($conexao);
}
exit;
	}



//Extrair dados da tabela detalhe_temp....
if($_POST['action']=='searchForDetalhe_cotacao'){

	//print_r($_POST);
	if(empty($_POST['user'])){
		echo 'error';
	}
	else{
		$token_user=$_POST['user'];

		$query=mysqli_query($conexao,"SELECT correlativo,
							token_user,cod_Cliente,cod_servico,description,quantidade,
							preco,perc_desconto,subtotal_prod FROM tb_detalhe_temp_cotacao WHERE 
							token_user='$token_user'");

		$result=mysqli_num_rows($query);

		

		$detalheTable='';
		$sub_total=0;
		$iva=17;
		$total=0;
		$arrayData=array();

		if($result > 0){

		
			while ($data=mysqli_fetch_assoc($query)) {
				$precoTotal=round($data['quantidade'] * $data['preco'],2);
				$sub_total=round($sub_total + $precoTotal, 2);
				$total=round($total + $precoTotal, 2);

				$detalheTable .='
							<tr>
							<td>'.$data['cod_servico'].'</td>
							<td colspan="3">'.$data['description'].'</td>
							<td class="textright">'.$data['quantidade'].'</td>
							<td class="textright">'.$data['preco'].'</td>
							<td class="textright">'.$data['perc_desconto'].'</td>
							<td class="textright">'.$precoTotal.'</td>
							<td class="">
								<button class="btn btn-default" onclick="event.preventDefault();del_produt_detalhe('.$data['correlativo'].');"><i class="far fa-trash-alt "></i></button>
							</td>
						</tr>';

			}
			$imposto=round($sub_total * ($iva / 100),2);
			//$tl_sniva=round($sub_total - $imposto, 2);
			$total=round($sub_total + $imposto,2);

			$detalhe_total_venda ='
							<tr>
										<td colspan="7" class="textright">Valor líquido.</td>
										<td class="textright">'.$sub_total.'</td>
									</tr>
									<tr>
										<td colspan="7" class="textright">Desconto(0%)</td>
										<td class="textright">'.'0.00'.'</td>
									</tr>
										<tr>
										<td colspan="7" class="textright">Subtotal Q.</td>
										<td class="textright">'.$sub_total.'</td>
									</tr>
									<tr>
										<td colspan="7" class="textright">IVA('.$iva.')</td>
										<td class="textright">'.$imposto.'</td>
									</tr>
									<tr>
										<td colspan="7" class="textright">Total</td>
										<td class="textright">'.$total.'</td>
									</tr>';

									$arrayData['detalhe']=$detalheTable;
									$arrayData['total']=$detalhe_total_venda;

									echo json_encode($arrayData,JSON_UNESCAPED_UNICODE);
		}
		else{
			$arrayData=0;
		}

		//mysqli_close($conexao);
}
exit;
	}


	//Apaga detalhes do produto na tabela detalha_tep...
if($_POST['action']=='apagaProductDetalhe'){

	if(empty($_POST['id_detalhe'])){
		echo 'error';
	}
	else{
		$id_detalhe=$_POST['id_detalhe'];
		$token_user=$codigoLog;

		$query_iva=mysqli_query($conexao,"SELECT iva FROM tb_cliente");
		$result_iva=mysqli_num_rows($query_iva);

		$query_detalhe=mysqli_query($conexao,"CALL apaga_detalhe_temp($id_detalhe,'$token_user')");
		$result=mysqli_num_rows($query_detalhe);

		$detalheTable='';
		$sub_total=0;
		$iva=0;
		$total=0;
		$arrayData=array();

		if($result > 0){
			if($result_iva > 0){
				$info_iva=mysqli_fetch_assoc($query_iva);
					$iva=$info_iva['iva'];
			}
			while ($data=mysqli_fetch_assoc($query_detalhe)) {
				$precoTotal=round($data['quantidade'] * $data['preco'],2);
				$sub_total=round($sub_total + $precoTotal, 2);
				$total=round($total + $precoTotal, 2);

				$detalheTable .='
							<tr>
							<td>'.$data['cod_produto'].'</td>
							<td colspan="3">'.$data['description'].'</td>
							<td class="textright">'.$data['quantidade'].'</td>
							<td class="textright">'.$data['preco'].'</td>
							<td class="textright">'.$data['perc_desconto'].'</td>
							<td class="textright">'.$precoTotal.'</td>
							<td class="">
								<button class="btn btn-default" onclick="event.preventDefault();del_produt_detalhe('.$data['correlativo'].');"><i class="far fa-trash-alt "></i></button>
							</td>
						</tr>';

			}

			$imposto=round($sub_total * ($iva / 100),2);
			//$tl_sniva=round($sub_total - $imposto, 2);
			$total=round($sub_total + $imposto,2);

			$detalhe_total_venda ='
							<tr>
										<td colspan="7" class="textright">Valor líquido</td>
										<td class="textright">'.$sub_total.'</td>
									</tr>
									<tr>
										<td colspan="7" class="textright">Desconto(0%)</td>
										<td class="textright">'.'0,00'.'</td>
									</tr>
									<tr>
										<td colspan="7" class="textright">Subtotal</td>
										<td class="textright">'.$sub_total.'</td>
									</tr>
									<tr>
										<td colspan="7" class="textright">IVA('.$iva.')</td>
										<td class="textright">'.$imposto.'</td>
									</tr>
									<tr>
										<td colspan="7" class="textright">Total</td>
										<td class="textright">'.$total.'</td>
									</tr>';

									$arrayData['detalhe']=$detalheTable;
									$arrayData['total']=$detalhe_total_venda;

									echo json_encode($arrayData,JSON_UNESCAPED_UNICODE);
		}
		else{
			$arrayData=0;
		}

		mysqli_close($conexao);
}	
	
exit;
}


if($_POST['action']=='apagaProductDetalheContrato'){

	if(empty($_POST['id_detalhe'])){
		echo 'error';
	}
	else{
		$id_detalhe=$_POST['id_detalhe'];
		$token_user=$codigoLog;

		$query_iva=mysqli_query($conexao,"SELECT iva FROM tb_cliente");
		$result_iva=mysqli_num_rows($query_iva);

		$query_detalhe=mysqli_query($conexao,"CALL apaga_detalhe_contrato_temp($id_detalhe,$token_user)");
		$result=mysqli_num_rows($query_detalhe);

		$detalheTable='';
		$sub_total=0;
		$iva=0;
		$total=0;
		$arrayData=array();

		if($result > 0){
			if($result_iva > 0){
				$info_iva=mysqli_fetch_assoc($query_iva);
					$iva=$info_iva['iva'];
			}
			while ($data=mysqli_fetch_assoc($query_detalhe)) {
				$precoTotal=round($data['quantidade'] * $data['valor'],2);
				$sub_total=round($sub_total + $precoTotal, 2);
				$total=round($total + $precoTotal, 2);

				$detalheTable .='
							<tr>
							<td>'.$data['cod_produto'].'</td>
							<td colspan="3">'.$data['description'].'</td>
							<td class="textright">'.$data['quantidade'].'</td>
							<td class="textright">'.$data['valor'].'</td>
							<td class="textright">'.$precoTotal.'</td>
							<td class="">
								<button class="btn btn-default" onclick="event.preventDefault();del_produt_detalhe_Contrato('.$data['correlativo'].');"><i class="far fa-trash-alt "></i></button>
							</td>
						</tr>';

			}

		
			$detalhe_total_venda ='
							<tr>
										<td colspan="6" class="textright">Subtotal Q.</td>
										<td class="textright">'.$sub_total.'</td>
									</tr>';

									$arrayData['detalhe']=$detalheTable;
									$arrayData['total']=$detalhe_total_venda;
									$arrayData['valor_total']=$sub_total;
									echo json_encode($arrayData,JSON_UNESCAPED_UNICODE);
		}
		else{
			$arrayData=0;
		}

		mysqli_close($conexao);
}	
	
exit;
}




if($_POST['action']=='apagaProductDetalhe_cotacao'){

	if(empty($_POST['id_detalhe'])){
		echo 'error';
	}
	else{
		$id_detalhe=$_POST['id_detalhe'];
		$token_user=$codigoLog;

		$query_iva=mysqli_query($conexao,"SELECT iva FROM tb_cliente");
		$result_iva=mysqli_num_rows($query_iva);

		$query_detalhe=mysqli_query($conexao,"CALL apaga_detalhe_temp_cotacao($id_detalhe,'$token_user')");
		$result=mysqli_num_rows($query_detalhe);

		$detalheTable='';
		$sub_total=0;
		$iva=0;
		$total=0;
		$arrayData=array();

		if($result > 0){
			if($result_iva > 0){
				$info_iva=mysqli_fetch_assoc($query_iva);
					$iva=$info_iva['iva'];
			}
			while ($data=mysqli_fetch_assoc($query_detalhe)) {
				$precoTotal=round($data['quantidade'] * $data['preco'],2);
				$sub_total=round($sub_total + $precoTotal, 2);
				$total=round($total + $precoTotal, 2);

				$detalheTable .='
							<tr>
							<td>'.$data['cod_servico'].'</td>
							<td colspan="3">'.$data['description'].'</td>
							<td class="textright">'.$data['quantidade'].'</td>
							<td class="textright">'.$data['preco'].'</td>
								<td class="textright">'.$data['perc_desconto'].'</td>
							<td class="textright">'.$precoTotal.'</td>
							<td class="">
								<button class="btn btn-default" onclick="event.preventDefault();del_produt_detalhe('.$data['correlativo'].');"><i class="far fa-trash-alt "></i></button>
							</td>
						</tr>';

			}

			$imposto=round($sub_total * ($iva / 100),2);
			//$tl_sniva=round($sub_total - $imposto, 2);
			$total=round($sub_total + $imposto,2);

			$detalhe_total_venda ='
							<tr>
										<td colspan="7" class="textright">Valor líquido.</td>
										<td class="textright">'.$sub_total.'</td>
									</tr>
										<tr>
										<td colspan="7" class="textright">Desconto(0%).</td>
										<td class="textright">'.'0.00'.'</td>
									</tr>
										<tr>
										<td colspan="7" class="textright">Subtotal Q.</td>
										<td class="textright">'.$sub_total.'</td>
									</tr>
									<tr>
										<td colspan="7" class="textright">IVA('.$iva.')</td>
										<td class="textright">'.$imposto.'</td>
									</tr>
									<tr>
										<td colspan="7" class="textright">Total</td>
										<td class="textright">'.$total.'</td>
									</tr>';

									$arrayData['detalhe']=$detalheTable;
									$arrayData['total']=$detalhe_total_venda;

									echo json_encode($arrayData,JSON_UNESCAPED_UNICODE);
		}
		else{
			$arrayData=0;
		}

		mysqli_close($conexao);
}	
	
exit;
}



//Anular venda
if($_POST['action']=='anularVenda'){
		
		$token_user=$codigoLog;
		$query_del=mysqli_query($conexao,"DELETE FROM tb_detalhe_temp WHERE token_user='$token_user'");
		mysql_close($conexao);
		if($query_del){
			echo "Ok";
		}else{
			echo "error";
		}


	exit;
}
if($_POST['action']=='anularCotacao'){
		
		$token_user=$codigoLog;
		$query_del=mysqli_query($conexao,"DELETE FROM tb_detalhe_temp_cotacao WHERE token_user='$token_user'");
		mysql_close($conexao);
		if($query_del){
			echo "Ok";
		}else{
			echo "error";
		}


	exit;
}

//Registar cliente-venda...
if($_POST['action']=='addCliente')
{

 if(empty($_POST['txtNomeCliente1'])){
		echo 0;
	}
	
else{

	$nuitCl=$_POST['txtNuitCliente1'];
	$nomeCl=$_POST['txtNomeCliente1'];
	$telefoneCl=$_POST['txtTelefoneCliente1'];
	$enderecoCl=$_POST['txtEnderecoCliente1'];
	$usuario_id=$codigoLog;
	$ivaCliente=$_POST['ivaCliente'];
	$tipoCliente=$_POST['tipoCliente'];
	$emailCliente=$_POST['emailCliente'];
			
//$iva=17;
	$codCliente=rand (1000, 9999);

		$cliente=new User();
		$cliente->gravaCliente(array(
		'idCliente'			=>$codCliente,
		'nuitCliente'		=>$nuitCl,
		'nomeCliente'		=>$nomeCl,
		'endereco'			=>$enderecoCl,		
		'contactoCliente'	=>$telefoneCl,
		'iva'				=>$ivaCliente,
		'usuario'			=>$usuario_id,
		'email'				=>$emailCliente,
		'tipo'				=>$tipoCliente,
		'estado'			=>'Activo'
		//'dataRegisto'		=>date('yyyy-mm-dd')
));
$query=mysqli_query($conexao,"SELECT * FROM tb_cliente WHERE idCliente=$codCliente");
$result=mysqli_num_rows($query);
		if($result > 0){
				$data=mysqli_fetch_assoc($query);
				echo json_encode($data,JSON_UNESCAPED_UNICODE);
			}
}
exit;
}


//Processar venda
if($_POST['action']=='processar_venda'){

if(empty($_POST['codCliente'])){
		echo 0;
	}
	else{
		$codCliente=$_POST['codCliente'];
		$desconto_total=$_POST['desconto_total'];
		$token=$codigoLog;

		$dataRegisto=date('Y-m-d');
		
		
		$iva=0;

		$query=mysqli_query($conexao,"SELECT * FROM tb_detalhe_temp WHERE token_user='$token'");
		$result=mysqli_num_rows($query);

		$query_iva=mysqli_query($conexao,"SELECT iva FROM tb_cliente WHERE idCliente= '$codCliente'");
		$result_iva=mysqli_num_rows($query_iva);
		if($result_iva>0){
			$info_iva=mysqli_fetch_assoc($query_iva);
			$iva=$info_iva['iva'];
		}

		if($result > 0){
			$query_processar=mysqli_query($conexao,"CALL processar_factura($codCliente,'$token',$iva,$desconto_total)");
			$result_detalhe=mysqli_num_rows($query_processar);

			if($result_detalhe > 0){
				$data=mysqli_fetch_assoc($query_processar);
				echo json_encode($data,JSON_UNESCAPED_UNICODE);
			}
			else{
				echo "error";
			}
		}
		else{
			echo "error";
		}


	}
	mysqli_close($conexao);

	exit;
}


if($_POST['action']=='processar_contrato'){

	//print_r($_POST);

if(empty($_POST['codCliente'])){
		echo 0;
	}
else if(empty($_POST['tipoContrato'])){
		echo 0;
	}
else if(empty($_POST['valorTotal'])){
		echo 0;
	}
else if(empty($_POST['valorMensal'])){
		echo 0;
	}
else if(empty($_POST['dataAssinatura'])){
		echo 0;
	}
else if(empty($_POST['dataInicio'])){
		echo 0;
	}
else if(empty($_POST['dataVencimentoCont'])){
		echo 0;
	}
else if(empty($_POST['duracoaContrat'])){
		echo 0;
	}
	else{
		$codCliente=$_POST['codCliente'];
		$tipoContrato=$_POST['tipoContrato'];
		$valorTotal=$_POST['valorTotal'];
		$valorMensal=$_POST['valorMensal'];
		$dataAssinatura=$_POST['dataAssinatura'];
		$dataInicio=$_POST['dataInicio'];
		$dataVencimentoCont=$_POST['dataVencimentoCont'];
		$duracoaContrat=$_POST['duracoaContrat'];
		$token=$codigoLog;


		$query=mysqli_query($conexao,"SELECT * FROM tb_detalheContrato_temp WHERE codUsuario=$token");
		$result=mysqli_num_rows($query);

		
		if($result > 0){
		$query_processar=mysqli_query($conexao,"CALL processar_contrato('$tipoContrato',$token,$codCliente,$valorTotal,$valorMensal,'$dataAssinatura','$dataInicio','$dataVencimentoCont',$duracoaContrat)");

			$result_detalhe=mysqli_num_rows($query_processar);

			if($result_detalhe > 0){
				$data=mysqli_fetch_assoc($query_processar);
				echo json_encode($data,JSON_UNESCAPED_UNICODE);
			}
			else{
				echo "error";
			}
		}
		else{
			echo "error";
		}


	}
	mysqli_close($conexao);

	exit;
}


if($_POST['action']=='processar_cotacao'){

if(empty($_POST['codCliente'])){
		echo 0;
	}
	else{
		$codCliente=$_POST['codCliente'];
		$token=$codigoLog;
		$dataRegisto=date('Y-m-d');
		$desconto_t=$_POST['desconto_t'];
		
		
		$iva=0;

		$query=mysqli_query($conexao,"SELECT * FROM tb_detalhe_temp_cotacao WHERE token_user='$token'");
		$result=mysqli_num_rows($query);

		$query_iva=mysqli_query($conexao,"SELECT iva FROM tb_cliente WHERE idCliente= '$codCliente'");
		$result_iva=mysqli_num_rows($query_iva);
		if($result_iva>0){
			$info_iva=mysqli_fetch_assoc($query_iva);
			$iva=$info_iva['iva'];
		}

		if($result > 0){
			$query_processar=mysqli_query($conexao,"CALL processar_cotacao($codCliente,'$token',$iva,$desconto_t)");
			$result_detalhe=mysqli_num_rows($query_processar);

			if($result_detalhe > 0){
				$data=mysqli_fetch_assoc($query_processar);
				echo json_encode($data,JSON_UNESCAPED_UNICODE);
			}
			else{
				echo "error";
			}
		}
		else{
			echo "error";
		}


	}
	mysqli_close($conexao);

	exit;
}


//Anular factura....

if($_POST['action']=='anularFactura'){
	if(!empty($_POST['noFactura'])){
		
		$noFactura=$_POST['noFactura'];
		$query_anular=mysqli_query($conexao,"CALL anular_factura('$noFactura')");
		//mysqli_close($conexao);
		$result=mysqli_num_rows($query_anular);

		if($result > 0){
			
				$data=mysqli_fetch_assoc($query_anular);
				echo json_encode($data,JSON_UNESCAPED_UNICODE);
				exit;
			}
			
		}
		echo "error";
	
	exit;
}

if($_POST['action']=='apagaCliente'){

		if(!empty($_POST['noCliente'])){
		
		$noCliente=$_POST['noCliente'];


$sql = "DELETE FROM  tb_cliente WHERE idCliente=$noCliente";

if (mysqli_query($conexao, $sql)) {
    echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . mysqli_error($conexao);
}	
		}
		echo "error";

	exit;
}

if($_POST['action']=='apagaUsuario'){

		if(!empty($_POST['noFuncionario'])){
		
		$noFuncionario=$_POST['noFuncionario'];


$sql = "DELETE FROM  tb_utilizador WHERE codigo=$noFuncionario";

if (mysqli_query($conexao, $sql)) {
    echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . mysqli_error($conexao);
}	
		}
		echo "error";

	exit;
}




if($_POST['action']=='informCliente'){

		if(!empty($_POST['codigoCliente'])){
			$cod=$_POST['codigoCliente'];

			$query= mysqli_query($conexao,"SELECT * FROM tb_cliente WHERE idCliente = '$cod'");
			mysqli_close($conexao);
			$result=mysqli_num_rows($query);
			$data='';
			if($result>0){
				$data=mysqli_fetch_assoc($query);
				echo json_encode($data,JSON_UNESCAPED_UNICODE);
				exit;
			}

		}
	echo 'error';

	exit;
}




//Agregar prdido

if($_POST['action']=='addPedidoProdutoDetalhe'){


	if(empty($_POST['codProduto']) || empty($_POST['quanti'])){
		echo 'error';
	}
	else{
		$codProduto=$_POST['codProduto'];
		$quantidade=$_POST['quanti'];
		$token_user=$codigoLog;

		
		$query_detalhe_temp=mysqli_query($conexao,"CALL adddetalhe_temp_pedido($codProduto,$quantidade,'$token_user')");
		$result=mysqli_num_rows($query_detalhe_temp);

		$detalheTable='';
		
		$arrayData=array();

		if($result > 0){
			
			while ($data=mysqli_fetch_assoc($query_detalhe_temp)) {

		

$detalheTable .='
							<tr>
							<td>'.$data['cod_produto'].'</td>
							<td colspan="3">'.$data['descricao_produto'].'</td>
							<td>'.$data['quantidade'].'</td>

							<td class="">
								<button class="btn btn-default" onclick="event.preventDefault();del_produt_detalhe('.$data['correlativo'].');"><i class="far fa-trash-alt "></i></button>
							</td>
						</tr>';


			}


							$arrayData['detalhePedido']=$detalheTable;
							echo json_encode($arrayData,JSON_UNESCAPED_UNICODE);
		}
		else{
			echo 'error';
		}

		mysqli_close($conexao);
}	
	
exit;
	}






if($_POST['action']=='actualizar_empresa'){

	if(empty($_POST['txtNome'])){
		echo 'error';
	}
	else if(empty($_POST['txtNuit'])){
		echo 'error';
	}
	else if(empty($_POST['txtProvincia'])){
		echo 'error';
	}
	else if(empty($_POST['txtNacional'])){
		echo 'error';
	}
	else if(empty($_POST['txtCidade'])){
		echo 'error';
	}
	else if(empty($_POST['txtAvenida'])){
		echo 'error';
	}
	else if(empty($_POST['txtNumero'])){
		echo 'error';
	}
	else if(empty($_POST['txtWebSite'])){
		echo 'error';
	}
	else if(empty($_POST['txtTelefone'])){
		echo 'error';
	}
	else if(empty($_POST['txtEmail'])){
		echo 'error';
	}
	else{
	$txtNome=$_POST['txtNome'];
	$txtNuit=$_POST['txtNuit'];
	$txtProvincia=$_POST['txtProvincia'];
	$txtNacional=$_POST['txtNacional'];
	$txtCidade=$_POST['txtCidade'];
	$txtAvenida=$_POST['txtAvenida'];
	$txtNumero=$_POST['txtNumero'];
	$txtWebSite=$_POST['txtWebSite'];
	$txtTelefone=$_POST['txtTelefone'];
	$txtEmail=$_POST['txtEmail'];

		$empresa=new User();
			$empresa->actualizaDadosEmpresa(12342018,array(
				'nome'			=>$txtNome,
				'nuit'			=>$txtNuit,
				'nacional'		=>$txtNacional,
				'provincia'		=>$txtProvincia,	
				'cidade'		=>$txtCidade,
				'avenida'		=>$txtAvenida,
				'nrCasa'		=>$txtNumero,
				'nrTelefone'	=>$txtTelefone,
				'email'			=>$txtEmail,
				'webSite'		=>$txtWebSite
			));

		}

	exit;
}

if($_POST['action']=='addDadosMensalidades'){

if(empty($_POST['nrContrato'])){
		echo 0;
	}
	else if(empty($_POST['nomeMes'])){
		echo 0;
	}
	else if(empty($_POST['dataPagamento'])){
		echo 0;
	}
else{
	$nrContrato=$_POST['nrContrato'];
	$nomeMes=$_POST['nomeMes'];
	$dataPagamento=$_POST['dataPagamento'];
	$estadoM='Nao pago';

	$mensalidade=new User();
		$mensalidade->gravamensalidade_tmp(array(
		'cod_contrato'		=>$nrContrato,
		'nome_mes'			=>$nomeMes,
		'estado'			=>$estadoM,
		'dataPagamento'		=>$dataPagamento
		
		
));
		
$query_detalhe_temp=mysqli_query($conexao,"SELECT * FROM tb_mensalidade_tmp WHERE cod_contrato=$nrContrato");
		$result=mysqli_num_rows($query_detalhe_temp);

		$detalheTable='';	
		$arrayData=array();


if($result > 0){			
			
			while ($data=mysqli_fetch_assoc($query_detalhe_temp)) {

			$detalheTable .='
							<tr>							
							<td>'.$data['cod_contrato'].'</td>
							<td>'.$data['nome_mes'].'</td>
							<td>'.$data['estado'].'</td>
							<td>'.$data['dataPagamento'].'</td>
							<td class="">
								<button class="btn btn-default" data-toggle="tooltip" title="Elimina o produto" onclick="event.preventDefault();del_produt_detalhe('.$data['correlativo'].');"><i class="far fa-trash-alt "></i></button>
							</td>
						</tr>';

						
				

				}
				$arrayData['detalhe']=$detalheTable;							

				echo json_encode($arrayData,JSON_UNESCAPED_UNICODE);
				

}


		
			}
	exit;
}
if($_POST['action']=='dados_contrato'){
if(empty($_POST['cod_cliente'])){
		echo 0;
	}
	else if(empty($_POST['servico'])){
		echo 0;
	}
	else if(empty($_POST['valor_mensal'])){
		echo 0;
	}
	if(empty($_POST['valor_iva'])){
		echo 0;
	}
	else if(empty($_POST['valor_subtotal'])){
		echo 0;
	}
	else if(empty($_POST['nr_meses'])){
		echo 0;
	}
	else if(empty($_POST['valor_total'])){
		echo 0;
	}
	else{
	$cod_cliente=$_POST['cod_cliente'];
	$servico=$_POST['servico'];
	$valor_mensal=$_POST['valor_mensal'];
	$valor_iva=$_POST['valor_iva'];
	$valor_subtotal=$_POST['valor_subtotal'];
	$nr_meses=$_POST['nr_meses'];
	$estadoC='0';
	$valor_total=$_POST['valor_total'];
	$dataRegisto=date('Y/m/d');

	
	$cliente=new User();
		$cliente->gravaDadosContrato(array(
		'cod_cliente'		=>$cod_cliente,
		'cod_usuario'		=>$codigoLog,
		'servico'			=>$servico,
		'valor_mensal'		=>$valor_mensal,
		'iva_mensal'		=>$valor_iva,		
		'sub_total'			=>$valor_subtotal,
		'nr_meses'			=>$nr_meses,
		'estado'			=>$estadoC,
		'valor_total'		=>$valor_total,
		'data_registo'		=>$dataRegisto
));
		//echo 'Gravado com sucesso';

		$query= mysqli_query($conexao,"SELECT cod_cliente, cod_contato FROM tb_contrato ORDER BY cod_contato DESC LIMIT 1");
			mysqli_close($conexao);
			$result=mysqli_num_rows($query);
			$data='';
			if($result>0){
				$data=mysqli_fetch_assoc($query);
			}else{
				$data=0;
			}
	
		echo json_encode($data,JSON_UNESCAPED_UNICODE);

}

exit;
}

if($_POST['action']=='save_mensalidade'){
if(empty($_POST['nrContrato'])){
		echo 0;
	}
	else{
		$nrContrato=$_POST['nrContrato'];


$query_detalhe_temp=mysqli_query($conexao,"CALL mensalidade($nrContrato)");

	$result=mysqli_num_rows($query_detalhe_temp);

		if($result > 0){

				$data=mysqli_fetch_assoc($query_detalhe_temp);
				echo json_encode($data,JSON_UNESCAPED_UNICODE);						
		}

	}

	exit;
}

if($_POST['action']=='apagaMensaltDetalhe'){

	if(empty($_POST['id_detalhe'])){
		echo 0;
	}
	else if(empty($_POST['nrContrato'])){
		echo 0;
	}
	else{
		$id_detalhe=$_POST['id_detalhe'];
		$nrContrato=$_POST['nrContrato'];

		$query_iva=mysqli_query($conexao,"SELECT iva FROM tb_cliente");
		$result_iva=mysqli_num_rows($query_iva);

		$query_detalhe=mysqli_query($conexao,"CALL apaga_mensalidade_temp($id_detalhe,$nrContrato)");
		$result=mysqli_num_rows($query_detalhe);

		$detalheTable='';
		
		$arrayData=array();

	if($result > 0){			
			
			while ($data=mysqli_fetch_assoc($query_detalhe)) {

			$detalheTable .='
							<tr>							
							<td>'.$data['cod_contrato'].'</td>
							<td>'.$data['nome_mes'].'</td>
							<td>'.$data['estado'].'</td>
							<td>'.$data['dataPagamento'].'</td>
							<td class="">
								<button class="btn btn-default" data-toggle="tooltip" title="Elimina o produto" onclick="event.preventDefault();del_produt_detalhe('.$data['correlativo'].');"><i class="far fa-trash-alt "></i></button>
							</td>
						</tr>';

						
				

				}
				$arrayData['detalhe']=$detalheTable;							

				echo json_encode($arrayData,JSON_UNESCAPED_UNICODE);
				

}

}	


	exit;
}
if($_POST['action']=='anular_mensalidade'){
	if(empty($_POST['nrContrato'])){
		echo 'error';
	}
	else{
		$nrContrato=$_POST['nrContrato'];
		$query_detalhe=mysqli_query($conexao,"CALL anular_contrato($nrContrato)");

	echo "Eliminado com sucesso";
	}

	exit;
}

if($_POST['action']=='confirmarUsuario'){
	if(empty($_POST['emailUsuario'])){
		echo 0;
	}
	else if(empty($_POST['passwordConfirm'])){
		echo 0;
	}
	else{
		$emailUsuario=$_POST['emailUsuario'];
		$passwordConfirm=$_POST['passwordConfirm'];

		$user=new User();
		  $login=$user->login($emailUsuario,$passwordConfirm);

      if($login){
        
		echo 1;
      }
      else{
      	echo 2;
      }

	
	}

	exit;
}

if($_POST['action']=='actualizaUsuario'){

if(empty($_POST['emailUsuario'])){
		echo 0;
	}
	else if(empty($_POST['nomeUsuario'])){
		echo 0;
	}
	else if(empty($_POST['telefoneUsuario'])){
		echo 0;
	}
	else{
		$emailUsuario=$_POST['emailUsuario'];
		$nomeUsuario=$_POST['nomeUsuario'];
		$telefoneUsuario=$_POST['telefoneUsuario'];

		$user=new User();
		 $user->actualizarUser($codigoLog, array(
        'name'      =>$nomeUsuario,
        'contact'   =>$telefoneUsuario,
        'username'  =>$emailUsuario

        ));
     }



exit;
}

if($_POST['action']=='seachContrato'){
	if(empty($_POST['contrato'])){
		echo 0;
	}
	else{
		$contrato=$_POST['contrato'];

		$query_detalhe_cont=mysqli_query($conexao,"SELECT con.cod_contrato,con.valor_prestacao,	decont.cod_produto, decont.description, decont.quantidade,
			decont.valor,decont.valor_subtotal, cl.nomeCliente,cl.nuitCliente,
			cl.endereco,cl.contactoCliente, cl.iva,cl.email  from  tb_contrato 
			con INNER JOIN tb_detalhe_contrato decont ON con.cod_contrato= decont.nr_contrato INNER JOIN tb_cliente cl ON cl.idCliente=con.nr_cliente WHERE decont.nr_contrato=$contrato");

	$result=mysqli_num_rows($query_detalhe_cont);

		if($result>0){
				
		$detalheTable='';
		$somaPreco_total=0;
		$iva=0;
		$total=0;
		$arrayData=array();	
			
			$info_iva=mysqli_fetch_assoc($query_detalhe_cont);
			$iva=$info_iva['iva'];
			$sub_total=$info_iva['valor_prestacao'];

			$nomeCl=$info_iva['nomeCliente'];
			$nuitCl=$info_iva['nuitCliente'];
			$enderecoCl=$info_iva['endereco'];
			$contactCl=$info_iva['contactoCliente'];
			$emailCl=$info_iva['email'];

			while ($data=mysqli_fetch_assoc($query_detalhe_cont)) {
				$precoTotal=round($data['quantidade'] * $data['valor'],2);
				$somaPreco_total=round($somaPreco_total + $precoTotal, 2);
				
				$detalheTable.='<tr>
						<td>'.$data['cod_produto'].'</td>
						<td colspan="3">'.$data['description'].'</td>
						<td class="textright">'.$data['quantidade'].'</td>
						<td class="textright">'.$data['valor'].'</td>
						<td class="textright">'.$data['valor_subtotal'].'</td>				
					</tr>';
			}

			$imposto=round($sub_total * ($iva / 100),2);
			
			$total=round($sub_total + $imposto,2);			

						$arrayData['detalhe']=$detalheTable;
						$arrayData['imposto']=$imposto;
						$arrayData['valor_prestacao']=$sub_total;
						$arrayData['valor_total']=$total;
						$arrayData['iva']=$iva;
						$arrayData['nuitCl']=$nuitCl;
						$arrayData['nomeCl']=$nomeCl;
						$arrayData['enderecoCl']=$enderecoCl;
						$arrayData['contactCl']=$contactCl;
						$arrayData['emailCl']=$emailCl;

				
						echo json_encode($arrayData,JSON_UNESCAPED_UNICODE);

	}
		else{
			$arrayData=0;
		}

}

	exit;
}


if($_POST['action']=='processarpagamentoContr'){

		if(empty($_POST['codContrato'])){
		echo 0;
	}
	else if(empty($_POST['valorPrestacao'])){
		echo 0;
	}
	else if(empty($_POST['valorIva'])){
		echo 0;
	}
	else if(empty($_POST['valorPagar'])){
		echo 0;
	}
	else if(empty($_POST['mesPagar'])){
		echo 0;
	}
	else{
		$codContrato=$_POST['codContrato'];
		$valorPrestacao=$_POST['valorPrestacao'];
		$valorIva=$_POST['valorIva'];
		$valorPagar=$_POST['valorPagar'];
		$mesPagar=$_POST['mesPagar'];
		//echo $valorPrestacao;
		 $user=new User();
		 
		$user->gravapagamentocontrato(array(
		'cod_contrato'		=>$codContrato,
		'usuario'			=>$codigoLog,
		'valor_pago'		=>$valorPrestacao,
		'valor_iva'			=>$valorIva,
		'valor_total'		=>$valorPagar,		
		'mes_pago'			=>$mesPagar,
		'data_pagamento'	=>date('Y-m-d')	
	));
$v_total=0;
	$query_detalhe=mysqli_query($conexao,"SELECT total FROM tb_controlo_recebimento_contrato WHERE cod_contrato=$codContrato");

	$result=mysqli_num_rows($query_detalhe);

		if($result>0){	
			
			$valor=mysqli_fetch_assoc($query_detalhe);
			$valor_total=$valor['total'];
			
		 if('Janeiro'==$mesPagar){
		 	$v_total=$valor_total+$valorPrestacao;
		 $user->actualizacontroloRecibemento($codContrato, array(
        'Janeiro'      =>$valorPrestacao,
        'total'			=>$v_total
         ));
       	 }
		 else if('Fevereiro'==$mesPagar){
		 $v_total=$valor_total+$valorPrestacao;
		 $user->actualizacontroloRecibemento($codContrato, array(
        'Feverreiro'      =>$valorPrestacao,
        'total'			=>$v_total
         ));
         }
		 else if('Março'==$mesPagar){
		 $v_total=$valor_total+$valorPrestacao;
		 $user->actualizacontroloRecibemento($codContrato, array(
        'Marco'      =>$valorPrestacao,
        'total'			=>$v_total
         ));
       	 }
		 else if('Abril'==$mesPagar){
		 $v_total=$valor_total+$valorPrestacao;
		 $user->actualizacontroloRecibemento($codContrato, array(
        'Abril'      =>$valorPrestacao,
        'total'			=>$v_total
         ));
       	 }
		 else if('Maio'==$mesPagar){
		 $v_total=$valor_total+$valorPrestacao;
		 $user->actualizacontroloRecibemento($codContrato, array(
        'Maio'      =>$valorPrestacao,
        'total'			=>$v_total
         ));
         } 
		 else if('Junho'==$mesPagar){
		 $v_total=$valor_total+$valorPrestacao;
		 $user->actualizacontroloRecibemento($codContrato, array(
        'Junho'      =>$valorPrestacao,
        'total'			=>$v_total
         ));
      	 }
		 else if('Julho'==$mesPagar){
		 $v_total=$valor_total+$valorPrestacao;
		 $user->actualizacontroloRecibemento($codContrato, array(
        'Julho'      =>$valorPrestacao,
        'total'			=>$v_total
         ));
        }
		 else if('Agosto'==$mesPagar){
		 $v_total=$valor_total+$valorPrestacao;
		 $user->actualizacontroloRecibemento($codContrato, array(
        'Agosto'      =>$valorPrestacao,
        'total'			=>$v_total
         ));
        }
        else if('Setembro'==$mesPagar){
        $v_total=$valor_total+$valorPrestacao;
		 $user->actualizacontroloRecibemento($codContrato, array(
        'Setembro'      =>$valorPrestacao,
        'total'			=>$v_total
         ));
        }
         else if('Outubro'==$mesPagar){
         $v_total=$valor_total+$valorPrestacao;
		 $user->actualizacontroloRecibemento($codContrato, array(
        'Outubro'      =>$valorPrestacao,
        'total'			=>$v_total
         ));
        }
         else if('Novembro'==$mesPagar){
         $v_total=$valor_total+$valorPrestacao;
		 $user->actualizacontroloRecibemento($codContrato, array(
        'Novembro'      =>$valorPrestacao,
        'total'			=>$v_total
         ));
        }
         else if('Dezembro'==$mesPagar){
         $v_total=$valor_total+$valorPrestacao;
		 $user->actualizacontroloRecibemento($codContrato, array(
        'Dezembro'      =>$valorPrestacao,
        'total'			=>$v_total
         ));
        }
		 else{
		 	echo "Os meses não são iguais";
		 }


	$query_contrato=mysqli_query($conexao,"SELECT * FROM tb_contrato WHERE cod_contrato=$codContrato");

	$result_contrato=mysqli_num_rows($query_contrato);

		if($result_contrato>0){	

			$data=mysqli_fetch_assoc($query_contrato);
				echo json_encode($data,JSON_UNESCAPED_UNICODE);			
		}
}

	}
	exit;
}

if($_POST['action']=='descontoFactura'){
	if(empty($_POST['desconto'])){
		echo 0;
	}
	else if(empty($_POST['codCliente'])){
		echo 0;
	}
	else{
		$desconto=$_POST['desconto'];
		$codCliente=$_POST['codCliente'];
		$token_user=$codigoLog;


			$query_iva=mysqli_query($conexao,"SELECT iva FROM tb_cliente WHERE idCliente='$codCliente'");
		$result_iva=mysqli_num_rows($query_iva);

			$query_detalhe_temp=mysqli_query($conexao,"SELECT * FROM tb_detalhe_temp WHERE token_user='$token_user'");

		$result=mysqli_num_rows($query_detalhe_temp);
		$detalheTable='';
		$valor_liquido=0;
		$iva=0;
		$total=0;
		$valor_subtotal=0;
		$valor_desconto=0;
		$arrayData=array();

		if($result > 0){
			if($result_iva > 0){
				$info_iva=mysqli_fetch_assoc($query_iva);
					$iva=$info_iva['iva'];
			
			while ($data=mysqli_fetch_assoc($query_detalhe_temp)) {
				$precoTotal1=round($data['quantidade'] * $data['preco'],2);
				$valor_liquido=round($valor_liquido + $precoTotal1, 2);
				$valor_desconto=round((($valor_liquido * $desconto)/100),2);
				$valor_subtotal=round($valor_liquido-(($valor_liquido * $desconto)/100),2);
				//$total=round($total + $precoTotal1, 2);

			
			}

			$imposto=round($valor_subtotal * ($iva / 100),2);
			//$tl_sniva=round($sub_total - $imposto, 2);
			$total=round($valor_subtotal + $imposto,2);

			$detalhe_total_venda ='
							<tr>
										<td colspan="7" class="textright">Valor líquido Q.</td>
										<td class="textright">'.$valor_liquido.'</td>
									</tr>
									<tr>
										<td colspan="7" class="textright">Desconto(' .$desconto.'%)</td>
										<td class="textright">'.$valor_desconto.'</td>
									</tr>
									<tr>
										<td colspan="7" class="textright">Subtotal</td>
										<td class="textright">'.$valor_subtotal.'</td>
									</tr>
									<tr>
										<td colspan="7" class="textright">IVA('.$iva.')</td>
										<td class="textright">'.$imposto.'</td>
									</tr>
									<tr>
										<td colspan="7" class="textright">Total</td>
										<td class="textright">'.$total.'</td>
									</tr>';

									$arrayData['total']=$detalhe_total_venda;

									echo json_encode($arrayData,JSON_UNESCAPED_UNICODE);
		
}
		}
		else{
			$arrayData=0;
		}

		mysqli_close($conexao);


	}

	exit;
}



if($_POST['action']=='descontoCotacao'){
	if(empty($_POST['desconto'])){
		echo 0;
	}
	else if(empty($_POST['codCliente'])){
		echo 0;
	}
	else{
		$desconto=$_POST['desconto'];
		$codCliente=$_POST['codCliente'];
		$token_user=$codigoLog;


			$query_iva=mysqli_query($conexao,"SELECT iva FROM tb_cliente WHERE idCliente='$codCliente'");
		$result_iva=mysqli_num_rows($query_iva);

			$query_detalhe_temp=mysqli_query($conexao,"SELECT * FROM tb_detalhe_temp_cotacao WHERE token_user='$token_user'");

		$result=mysqli_num_rows($query_detalhe_temp);
		$detalheTable='';
		$valor_liquido=0;
		$iva=0;
		$total=0;
		$valor_subtotal=0;
		$valor_desconto=0;
		$arrayData=array();

		if($result > 0){
			if($result_iva > 0){
				$info_iva=mysqli_fetch_assoc($query_iva);
					$iva=$info_iva['iva'];
			
			while ($data=mysqli_fetch_assoc($query_detalhe_temp)) {
				$precoTotal1=round($data['quantidade'] * $data['preco'],2);
				$valor_liquido=round($valor_liquido + $precoTotal1, 2);
				$valor_desconto=round((($valor_liquido * $desconto)/100),2);
				$valor_subtotal=round($valor_liquido-(($valor_liquido * $desconto)/100),2);
				//$total=round($total + $precoTotal1, 2);

			
			}

			$imposto=round($valor_subtotal * ($iva / 100),2);
			//$tl_sniva=round($sub_total - $imposto, 2);
			$total=round($valor_subtotal + $imposto,2);

			$detalhe_total_venda ='
							<tr>
										<td colspan="7" class="textright">Valor líquido Q.</td>
										<td class="textright">'.$valor_liquido.'</td>
									</tr>
									<tr>
										<td colspan="7" class="textright">Desconto(' .$desconto.'%)</td>
										<td class="textright">'.$valor_desconto.'</td>
									</tr>
									<tr>
										<td colspan="7" class="textright">Subtotal</td>
										<td class="textright">'.$valor_subtotal.'</td>
									</tr>
									<tr>
										<td colspan="7" class="textright">IVA('.$iva.')</td>
										<td class="textright">'.$imposto.'</td>
									</tr>
									<tr>
										<td colspan="7" class="textright">Total</td>
										<td class="textright">'.$total.'</td>
									</tr>';

									$arrayData['total']=$detalhe_total_venda;

									echo json_encode($arrayData,JSON_UNESCAPED_UNICODE);
		
}
		}
		else{
			$arrayData=0;
		}

		mysqli_close($conexao);


	}

	exit;
}




exit;

}

?>
