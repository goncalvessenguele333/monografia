<?php


require_once '../FPDF/rotation.php';

require_once '../Core/Init.php';
ini_set('default_charset','UTF-8');
if(isset($_GET['cod_Cliente'])){
  $codCl=$_GET['cod_Cliente'];
}
if(isset($_GET['cod_contrato'])){
  $coFact=$_GET['cod_contrato'];
}
$user=new User();
$dados=new User();
if(!$user->isLoggedIn()){
  Redirect::to('../Index.php');
 }
 $prod=new User();

  class RelatorioFuncionario extends PDF_Rotate
{
function Header()
{
  
  $this->SetFont('Arial','',8);
  $this->Cell(0,10,'Pag. '.$this->PageNo().'/{nb}',0,0,'R');


 
$this->SetXY(9,10);
  
 $prod=new User();

$this->SetTextColor(0,0,0);
$this->Image('../Contents/images/logo.png',11,15,45);
 $this->Ln(20);
if(isset($_GET['cod_Cliente'])){
  $codCl=$_GET['cod_Cliente'];
}
if(isset($_GET['cod_contrato'])){
$coFact=$_GET['cod_contrato'];
}


$dados=new User();
foreach ($dados->listaDadosEmpresa(12342018) as $lista) {
  $this->SetFont('Times','',10); 
  $this->Cell(11,10,escape($lista->avenida).' '.escape($lista->nrCasa)." - ".escape($lista->provincia),0,0,'L');
  $this->Ln(5);
  $this->Cell(11,10,'Tel: '.escape($lista->nrTelefone),0,0,'L');
    $this->Ln(5);
  $this->Cell(11,10,'E_mail: '.escape($lista->email)); 
  $this->Ln(5);
   $this->Cell(11,10,'Nuit.: '.escape($lista->nuit));
    $this->Ln(5);
   }

  // $this->SetXY(100,30);
  //$this->Rect(100,50,98,40);

   $this->SetDrawColor(255,255,255);
  $this->SetXY(10,30);
  $this->Rect(100,30,98,50);
 foreach ($dados->PesquisaCliente($codCl) as $lista) {
   $this->SetFont('Times','B',12);
    $this->Cell(140,10,'',0,0,'C');
    $this->Cell(10,10,utf8_decode('Recibo de pagamento de contrato'),0,0,'C');
    $this->Ln(10);
    $this->SetFont('Times','B',11);
    $this->Cell(100,10,'',0,0,'C');
  $this->Cell(20,10,'Nro:',0,0,'L');

    foreach ($prod->pesquisaContrato($coFact) as $lista1) {     
      $this->Cell(60,10,'MS/SQ - '.$coFact.'/'.escape($lista1->anoAssinatura),0,0,'L');
   
     } 
  
    $this->Ln(7);  
    $this->SetFont('Times','B',11);
     $this->Cell(100,10,'',0,0,'C');   
  $this->Cell(20,10,utf8_decode('Endere??o:'),0,0,'L');
  $this->SetFont('Times','',11);
  $this->Cell(60,10,utf8_decode($lista->endereco),0,0,'L');   
    $this->Ln(7);
$this->SetFont('Times','B',11);
  $this->Cell(100,10,'',0,0,'C');
  $this->Cell(20,10,'Att:',0,0,'L');
  $this->SetFont('Times','',11);
  $this->Cell(60,10,utf8_decode($lista->nomeCliente),0,0,'L');   
    $this->Ln(7);
$this->SetFont('Times','B',11);
  $this->Cell(100,10,'',0,0,'C');
  $this->Cell(20,10,'Telefone:',0,0,'L');
  $this->SetFont('Times','',11);
  $this->Cell(70,10,escape($lista->contactoCliente),0,0,'L');   
  $this->Ln(5);
 }
 
$this->Ln(5); 
}

function RotatedText($x, $y, $txt, $angle)
{
  //Text rotated around its origin
  $this->Rotate($angle,$x,$y);
  $this->Text($x,$y,$txt);
  $this->Rotate(0);
}


function Footer()
{
  /*$this->SetY(-15);
  $this->SetFont('Arial','I',8);
  $this->Cell(0,10,'Pag. '.$this->PageNo().'/{nb}',0,0,'C');*/
}
}

$pdf = new RelatorioFuncionario();
$pdf->AliasNbPages();
$pdf->AddPage(); 

    $pdf->Ln(10);
 
    $pdf->SetFillColor(169,169,169);   
    $pdf->SetFont('Times','B',10);   
   // $pdf->Line(10,80,200,80);
    $pdf->Cell(50,7,"Operador",0,0,'C',1);
    $pdf->Cell(30,7,"Data",0,0,'C',1);
    $pdf->Cell(37,7,"Nuit/Cliente",0,0,'C',1);
    $pdf->Cell(28,7,"Nr cliente",0,0,'C',1);
    $pdf->Cell(20,7,"Cond. Pagto",0,0,'L',1);  
    $pdf->Cell(25,7,utf8_decode("M??s pago"),0,0,'C',1); 
    //$pdf->Line(10,112,200,112);
    $pdf->Ln();

    $pdf->SetFont('Times','',10); 
    $pdf->SetLineWidth(0.3);   
    $dados1=new User();
    if($dados1->isLoggedIn()){
    $codigoF= ($dados1->data()->id); 
    }
    foreach ($dados->FuncionarioLog($codigoF) as $lista) {
  $pdf->Cell(50,7,utf8_decode($lista->name),1,0,'C');
}   
        
       $pdf->Cell(30,7,date('Y-m-d'),1,0,'C');
  
     //$pdf->Line(45,45,200,45);
     foreach ($dados->PesquisaCliente($codCl) as $lista) {
       $pdf->Cell(37,7,escape($lista->nuitCliente),1,0,'C'); 
        $pdf->Cell(28,7,escape($lista->idCliente),1,0,'C'); 
      }
     $pdf->Cell(20,7,"Pronto",1,0,'C'); 
      if(isset($_GET['mesPagar'])){
       

      $pdf->Cell(25,7,utf8_decode($_GET['mesPagar']),1,0,'C');
      }
      $pdf->Ln(3);

       
        $pdf->SetTextColor(0,0,0);
      $pdf->SetFillColor(255,255,255);  
           $pdf->Ln(10);
        $pdf->SetFont('Times','B',10); 
          $pdf->SetLineWidth(0.3);
         $pdf->Cell(25,9,'Ordem',1,0,'C',1);
        $pdf->Cell(165,9,utf8_decode('Descri????o de Servi??os'),1,0,'C',1);
         /*$pdf->Cell(12,9,'Qtd.',1,0,'C',1);
        $pdf->Cell(23,9,utf8_decode('Pre??o Unit.'),1,0,'C',1);
         $pdf->Cell(25,9,utf8_decode('Total L??quido'),1,0,'C',1);*/
     
          //$pdf->Line(10,137.5,200,137.5);

      $pdf->Ln(12);   
      $pdf->SetFillColor(255,255,255);
        $pdf->SetFont('Times','',10);
foreach ($prod->detalheContrato($coFact) as $lista) { 
            $pdf->Cell(25,9,escape($lista->cod_produto),0,0,'C',1);
          $xPos=$pdf->GetX();
           $yPos=$pdf->GetY();

            $pdf->MultiCell(165,5,utf8_decode($lista->description),0);
            $pdf->SetXY($xPos + 165, $yPos);
             /*$pdf->Cell(12,10,escape($lista->quantidade),0,0,'C',1);
            $pdf->Cell(23,10,escape($lista->valor),0,0,'C',1);
             $pdf->Cell(20,10,escape($lista->valor_subtotal),0,0,'L',1);*/
              $pdf->Ln(10);   
  }

    $pdf->Ln(13);
     $pdf->SetTextColor(0,0,0);
      $pdf->SetFillColor(255,255,255);  
           $pdf->Ln(10);
        $pdf->SetFont('Times','B',10); 
          $pdf->SetLineWidth(0.5);
         $pdf->Cell(15,5,'',0,0,'L',1);
        $pdf->Cell(113,5,utf8_decode('Termos e Condi????es'),0,0,'L',1);
         $pdf->Cell(12,5,'',0,0,'C',1);
        $pdf->Cell(23,5,'',0,0,'C',1);
         $pdf->Cell(25,5,'',0,0,'C',1);
         $pdf->Ln(5);
           $pdf->SetTextColor(0,0,0);
      $pdf->SetFillColor(255,255,255);  
          $pdf->SetFont('Times','',10); 
          $pdf->SetLineWidth(0.5);
         $pdf->Cell(15,5,'',0,0,'L',1);

          $xPos=$pdf->GetX();
           $yPos=$pdf->GetY();
            $pdf->MultiCell(113,5,utf8_decode('Entrga imediata alvo ruptura de stock. ?? aplic??vel garantia stardard do fabricante salvo indica????o contr??ria'),0);
            $pdf->SetXY($xPos + 115, $yPos);
        
         $pdf->Cell(12,5,'',0,0,'C',1);
        $pdf->Cell(23,5,'',0,0,'C',1);
         $pdf->Cell(25,5,'',0,0,'C',1);
         $pdf->Ln(10);
  $pdf->Cell(20,5,"__________________________________________________________________________________________________________",0,0,'L'); 
 $pdf->Ln(5); 
 


 
        foreach ($prod->pesquisaContrato($coFact) as $lista) {

        $pdf->SetFont('Times','I',10);
          $pdf->Cell(110,3,'Documento processado por Computador / @BIS Software',0,0,'L',1);
           $pdf->SetFont('Times','',10);
          $pdf->Cell(60,3,utf8_decode('Valor de presta????o: '),0,0,'R',1);
          $pdf->Cell(20,3,escape($lista->valor_prestacao),0,0,'L',1);
           $pdf->Ln(3);
           $pdf->Cell(140,3,"",0,0,'L'); 
           $pdf->Cell(50,3,"___________________________",0,0,'R'); 
          $pdf->Ln(5); 
          
           $pdf->SetFont('Times','B',10);
           $pdf->Cell(110,3,'Quadro Resumo do IVA',0,0,'L',1);
                $pdf->SetFont('Times','',10);          
          $pdf->Cell(60,3,'Descontos(%): ',0,0,'R',1);
          $pdf->Cell(20,3,"0.00",0,0,'L',1);
           $pdf->Ln(3);
            $pdf->Cell(140,3,"",0,0,'L');
           $pdf->Cell(50,3,"___________________________",0,0,'R'); 
          $pdf->Ln(5); 
            $pdf->SetFont('Times','B',10);
            $pdf->Cell(20,3,'Taxa',0,0,'L',1); 
            $pdf->Cell(25,3,utf8_decode('Incid??ncia'),0,0,'L',1);
            $pdf->Cell(40,3,'Taxa IVA',0,0,'L',1);
            $pdf->Cell(50,3,utf8_decode('Motivo de Isen????o'),0,0,'L',1);
            $pdf->SetFont('Times','',11);
            $pdf->Cell(35,3,utf8_decode('Valor de presta????o: '),0,0,'L',1);
            $pdf->Cell(20,3,escape($lista->valor_prestacao),0,0,'L',1);
            $pdf->Ln(3);
              $pdf->SetFont('Times','',10);
            $pdf->Cell(140,3,"__________________________________________________________________",0,0,'L'); 
             $pdf->Cell(50,3,"___________________________",0,0,'R'); 
          $pdf->Ln(5);    

            $valor_iva=0;
            $valor_total=0;

         foreach ($dados->PesquisaCliente($codCl) as $listaI) {
          $pdf->Cell(20,3,escape($listaI->iva).'%',0,0,'L',1);
        $valor_iva=$lista->valor_prestacao*($listaI->iva/100);
        $valor_total=(($lista->valor_prestacao+  $valor_iva));
        }
           $pdf->Cell(25,3,escape($lista->valor_prestacao),0,0,'L',1);
           $pdf->Cell(40,3,$valor_iva.".00",0,0,'L',1);
             $pdf->Cell(60,3,'',0,0,'L',1);
            foreach ($dados->PesquisaCliente($codCl) as $listaI) {
          $pdf->Cell(25,3,'IVA('.escape($listaI->iva).'%):',0,0,'L',1);
      
        }



        $pdf->Cell(20,3, $valor_iva.".00",0,0,'C',1);
          $pdf->Ln(3);
           $pdf->Cell(140,3,"__________________________________________________________________",0,0,'L'); 
            $pdf->Cell(50,3,"___________________________",0,0,'R'); 
      $pdf->Ln(5);
       $pdf->SetFont('Times','B',10);
          $pdf->Cell(170,3,'Valor pago: ',0,0,'R',1);
          $pdf->Cell(20,3, $valor_total.".00",0,0,'C',1);   
        $pdf->Ln(3);
            $pdf->Cell(140,3,"",0,0,'L'); 
           $pdf->Cell(50,3,"___________________________",0,0,'R'); 
        
         $pdf->Ln(); 

         

 }

 $pdf->Ln(3); 
 $pdf->SetFont('Times','',10);
 $pdf->Cell(31,8,'Cheque a ordem da ',0,0,'L');
   $pdf->SetFont('Times','B',10);
  $pdf->Cell(130,8,utf8_decode('Multicast Servi??os, EI '),0,0,'L');
 $pdf->Ln(5);
  $pdf->SetFont('Times','',10);
  $pdf->SetTextColor(0,0,0);   
 $pdf->Cell(130,8,utf8_decode('Pagamento por feito por Cheque, Deposito ou Transfer??ncia Banc??ria:'),0,0,'L');
 $pdf->SetFont('Times','',10);
   $pdf->Ln(4);
 $pdf->Cell(140,3,"__________________________________________________________________",0,0,'L'); 
  $pdf->Ln(5);
    $pdf->SetFont('Times','B',10);
  $pdf->Cell(35,8,'Banco: ',0,0,'L');
  $pdf->Cell(30,8,'Conta',0,0,'L'); 
  $pdf->Cell(65,8,'NIB: ',0,0,'C');

   $pdf->SetFont('Times','',10);
 
  $pdf->Ln(5);
   $pdf->SetFont('Times','',10);
 $pdf->Cell(35,8,'Standard Bank, SA ',0,0,'L');
  $pdf->Cell(30,8,'112858161003',0,0,'L'); 
  $pdf->Cell(65,8,'000301120858168100396',0,0,'C');

 $pdf->Cell(60,8,'____________________________',0,0,'C'); 

  $pdf->Ln(7);  

  $pdf->Cell(130,8,' IBAM: MZ59000301120858168100396 | SWIFT: SBICMZMX | C/M??vel: 833211705',0,0,'L');
    
 $pdf->Cell(60,8,'Assinatura e carimbo',0,0,'C');  



$pdf->Output();



?>
