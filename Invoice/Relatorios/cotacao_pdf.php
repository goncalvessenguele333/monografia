<?php

require_once '../FPDF/fpdf.php';

require_once '../Core/Init.php';
$user=new Funcionario();
if(!$user->isLoggedIn()){
  Redirect::to('Login.php');
 }

  class RelatorioFuncionario extends FPDF
{
function Header()
{
  $this->SetXY(9,10);
  $this->Rect(9,10,192,280);
 $num= rand(1000000000,9999999999);
  
$this->Image('../Images/logotipo.png',11,15,45);
 $this->Ln(17);
if(isset($_GET['cod_Cliente'])){
  $codCl=$_GET['cod_Cliente'];
}
if(isset($_GET['cod_Factura'])){
  $coFact=$_GET['cod_Factura'];
}

$dados=new Funcionario();
foreach ($dados->listaDadosEmpresa() as $lista) {
  $this->SetFont('Times','B',8);
 $this->Cell(11,10,'Nuit: '.escape($lista->nuit).', Alvara: '.escape($lista->nrAlvara),0,0,'L');
   $this->Ln(5);
  $this->Cell(11,10,'Av. : '.escape($lista->avenida).' nr: '.escape($lista->nrCasa),0,0,'L');
  $this->Ln(5);
  $this->Cell(11,10,'E_mail: '.escape($lista->email).'  Web site: '.escape($lista->webSite),0,0,'L');
  $this->Ln(5);
 $this->Cell(11,10,'Contactos: '.escape($lista->nrTelefone),0,0,'L');
   $this->Ln(5);
  $this->Cell(11,10,escape($lista->provincia)." - ".escape($lista->cidade),0,0,'L');
  $this->Ln(5);
   }
   $this->SetXY(100,10);
  $this->Rect(100,20,98,40);
 $this->Ln();
 foreach ($dados->PesquisaCliente($codCl) as $lista) {
    $this->SetFont('Times','',12);
    $this->Cell(90,10,'',0,0,'C');
  $this->Cell(10,10,'Exmo(s). Sr(s): '.escape($lista->nomeCliente),0,0,'L');
    $this->Ln(10);  
     $this->Cell(90,10,'',0,0,'C');   
  $this->Cell(10,10,'Morada: '.escape($lista->endereco),0,0,'L');
    $this->Ln(10); 
     $this->Cell(90,10,'',0,0,'C');
  $this->Cell(10,10,'Nuit: '.escape($lista->nuitCliente),0,0,'L');
    $this->Ln(10);
     $this->Cell(90,10,'',0,0,'C');

  $this->Cell(10,10,'Contacto: '.escape($lista->contactoCliente),0,0,'L');
    $this->Ln(5);
 }
 
$this->Ln(5);
    

  $this->SetFont('Times','',18);  
   $this->Cell(190,10,'COTACAO',0,0,'R');
      $this->Ln(10);

    $this->SetFont('Times','',12);
    $this->Cell(40,10,'',0,0,'R');
       $this->Cell(80,10,'Data & Horas: '.date("Y-m-d h:i:sa"),1,0,'C');
      $this->SetFont('Times','',18);
       $this->SetTextColor(250,1,88);
    $this->Cell(65,2, 'Nr: '.$coFact,0,0,'R');
    $this->Ln(10);

 $this->SetFillColor(255,255,255);
        $this->SetTextColor(0,0,0);
        $this->SetFont('Arial','',11);
         $this->Cell(190,10,'Em conformidade com a presada consulta de V.Excia,temos o prazer de oferecer os nossos melhores precos',0,0,'C');
           $this->Ln(10);
        $this->SetFont('Arial','B',11);
        $this->Cell(15,10,'Quant.',1,0,'C',1);
        $this->Cell(115,10,'Descricao',1,0,'C',1);
        $this->Cell(30,10,'P. Unitario',1,0,'C',1);
         $this->Cell(30,10,'Total',1,0,'C',1);
          $this->Ln();   
$prod=new Produto();
$this->SetFont('Arial','',11);
foreach ($prod->detalheCotacao($coFact) as $lista) {
              $this->Cell(15,10,escape($lista->quantidade),1,0,'C',1);
            $this->Cell(115,10,escape($lista->descricao_produto),1,0,'C',1);
            $this->Cell(30,10,escape($lista->preco),1,0,'C',1);
             $this->Cell(30,10,escape($lista->subtotal_prod),1,0,'C',1);
              $this->Ln(8);   
  }
 $this->Ln(4); 
        foreach ($prod->detalheTotalCotacao($coFact) as $lista) {
          $this->Cell(160,10,'SUB-TOTAL',0,0,'R',1);
         $this->Cell(30,10,escape($lista->subtotal_factura),1,0,'C',1);
         $this->Ln(8); 
         $this->Cell(160,10,'IVA 17%',0,0,'R',1);
         $this->Cell(30,10,escape($lista->iva_factura),1,0,'C',1);
         $this->Ln(8);
         $this->Cell(160,10,'TOTAL',0,0,'R',1);
         $this->Cell(30,10,escape($lista->total_factura),1,0,'C',1);
         $this->Ln(8); 
 }

 if($dados->isLoggedIn()){
$codigoF= ($dados->data()->codigo); 
}
 $this->SetFont('Times','',10);
 $this->Cell(130,10,'',0,0,'R');
  $this->Cell(60,10,'V.Excia, Atenciosamente',0,0,'C');
  $this->Ln();
  $this->Cell(130,10,'',0,0,'R');
  $this->Cell(60,10,'__________________________',0,0,'C');
  $this->Ln();
  $this->Cell(130,10,'',0,0,'R');
  foreach ($dados->FuncionarioLog($codigoF) as $lista) {
  $this->Cell(60,10,escape($lista->nome)." ".escape($lista->apelido),0,0,'C');
}
  $this->Ln();
    $this->SetFont('Times','B',8);
    $this->Cell(100,10,'Relacoes das nossas contas',0,0,'L');
     $this->Ln(5);
 $this->Cell(30,10,'BCI Conta nr: ',0,0,'C');
  $this->SetFont('Times','',8);
   
  $this->Cell(30,10,'13127582410001',0,0,'L'); 
  $this->SetFont('Times','B',8);
 $this->Cell(10,10,'NIB: ',0,0,'L');
  $this->SetFont('Times','',8);
  $this->Cell(50,10,'000800003127582410195',0,0,'L');   
  $this->Ln(5);
    $this->SetFont('Times','B',8);
 $this->Cell(30,10,'BIM Conta nr: ',0,0,'C');
  $this->SetFont('Times','',8);
  $this->Cell(30,10,'65260243',0,0,'L'); 
  $this->SetFont('Times','B',8);
 $this->Cell(10,10,'NIB: ',0,0,'L');
  $this->SetFont('Times','',8);
  $this->Cell(50,10,'00010000000526024357',0,0,'L');    
  $this->Ln(5);
    $this->SetFont('Times','B',8);
 $this->Cell(30,10,'MOZA Conta nr: ',0,0,'C');
  $this->SetFont('Times','',8);
  $this->Cell(30,10,'543568310001',0,0,'L'); 
  $this->SetFont('Times','B',8);
 $this->Cell(10,10,'NIB: ',0,0,'L');
  $this->SetFont('Times','',8);
  $this->Cell(50,10,'003400000543568310134',0,0,'L');     


}
function Footer()
{
  $this->SetY(-15);
  $this->SetFont('Arial','I',8);
  $this->Cell(0,10,'Pag. '.$this->PageNo().'/{nb}',0,0,'C');
}
}

$pdf = new RelatorioFuncionario();
$pdf->AliasNbPages();
$pdf->AddPage(); 
$pdf->SetFont('Arial','',10);
$pdf->Output();



?>
