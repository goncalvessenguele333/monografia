<?php


require_once '../FPDF/rotation.php';
ini_set('default_charset','UTF-8');
require_once '../Core/Init.php';

if(isset($_GET['cod_Cliente'])){
  $codCl=$_GET['cod_Cliente'];
}
if(isset($_GET['cod_Factura'])){
  $coFact=$_GET['cod_Factura'];
}
$user=new User();
$dados=new User();
if(!$user->isLoggedIn()){
  Redirect::to('Index.php');
 }
 $prod=new User();

  class RelatorioFuncionario extends PDF_Rotate
{
function Header()
{
  
  $this->SetFont('Arial','',8);
  $this->Cell(0,10,'Pag. '.$this->PageNo().'/{nb}',0,0,'R');


  if(isset($_GET['cod_Factura'])){
  $coFact=$_GET['cod_Factura'];
}
$this->SetXY(9,10);
  
 $prod=new User();
  
  foreach ($prod->detalheTotalFactura($coFact) as $lista) {
    if(escape($lista->estado==2)) {
      $this->SetFont('Arial','B',40);
      $this->SetTextColor(255,192,203);
      $this->RotatedText(50,90,'Factura anulada',40);
    }
  }

  // $this->SetXY(100,30);
  //$this->Rect(100,50,98,40);

   $this->SetDrawColor(255,255,255);
  $this->SetXY(10,30);
  $this->Rect(100,30,98,30);
  
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


$pdf->SetTextColor(0,0,0);
$pdf->Image('../Contents/images/logo.png',11,15,45);

$dados=new User();
foreach ($dados->listaDadosEmpresa(12342018) as $lista) {
  $pdf->SetFont('Times','',10); 
  $pdf->Cell(11,10,escape($lista->avenida).' nr: '.escape($lista->nrCasa)." - ".escape($lista->provincia),0,0,'L');
  $pdf->Ln(5);
  $pdf->Cell(11,10,'Tel: '.escape($lista->nrTelefone),0,0,'L');
    $pdf->Ln(5);
  $pdf->Cell(11,10,'E_mail: '.escape($lista->email)); 
  $pdf->Ln(5);
   $pdf->Cell(11,10,'Nuit.: '.escape($lista->nuit));
    $pdf->Ln(5);
   }




    $pdf->Ln(10);
  $pdf->SetTextColor(0,0,0); 
  $pdf->SetFont('Times','B',11);  
  $pdf->Cell(120,10,"Facturado a:",0,0,'L');
    $pdf->Cell(30,10,"Factura# ",0,0,'L');
     $pdf->SetTextColor(0,0,0); 
      $pdf->Cell(40,10,'MS-'.$coFact.'/'.date('Y'),0,0,'L');
     $pdf->Ln(8);
      $pdf->SetFont('Times','',11);
      foreach ($dados->PesquisaCliente($codCl) as $lista) {
    $pdf->Cell(120,10,utf8_decode($lista->nomeCliente),0,0,'L');
  } 
  $pdf->SetFont('Times','B',11);  
    $pdf->Cell(30,10,"Data: ",0,0,'L');
     $pdf->SetFont('Times','',11);      
     foreach ($prod->detalheTotalFactura($coFact) as $lista) {     
       $pdf->Cell(30,7,escape($lista->dataVenda),0,0,'L');
     } 
      $pdf->Ln(8);
       $pdf->SetFont('Times','B',11);  
    $pdf->Cell(20,10,"Morada: ",0,0,'L');
     $pdf->SetFont('Times','',11);  
     foreach ($dados->PesquisaCliente($codCl) as $lista) {
    $pdf->Cell(120,10,escape($lista->endereco),0,0,'L');
  }

      $pdf->Ln(15);
      $pdf->SetDrawColor(0,0,0);
      $pdf->SetLineWidth(0.3);
      $pdf->Line(10,89,198,89);
    $pdf->SetTextColor(0,0,0);   
    $pdf->SetFont('Times','B',11);   

    $pdf->Cell(40,7,"V/Nuit",0,0,'L');
      $pdf->Cell(45,7,utf8_decode("Condição de pagamento"),0,0,'L');
    $pdf->Cell(35,7,"Nr do Cliente",0,0,'C');
    $pdf->Cell(35,7,"Moeda",0,0,'C');
    $pdf->Cell(35,7,utf8_decode("Câmbio"),0,0,'C');  
   
    $pdf->Ln();
 $pdf->SetTextColor(0,0,0);  
    $pdf->SetFont('Times','',11);    
    $dados1=new User();
    if($dados1->isLoggedIn()){
    $codigoF= ($dados1->data()->id); 
    }
     foreach ($dados->PesquisaCliente($codCl) as $lista) {
  $pdf->Cell(40,7,escape($lista->nuitCliente),0,0,'L');
}   
     //$pdf->Line(45,45,200,45);
      $pdf->Cell(45,7,"Factura 07 dias",0,0,'C');
      foreach ($dados->PesquisaCliente($codCl) as $lista) {
  $pdf->Cell(35,7,escape($lista->idCliente),0,0,'C');
}   
     $pdf->Cell(35,7,"MZN",0,0,'C');  
      $pdf->Cell(35,7,"1.00",0,0,'C');
      $pdf->Ln(2);
$pdf->SetFont('Times','B',11);
       $pdf->Cell(40,7,"____________________",0,0,'L');
       $pdf->Cell(45,7,"______________",0,0,'C');     
      $pdf->Cell(35,7,"_______________",0,0,'C');  
     $pdf->Cell(35,7,"_________________",0,0,'C');  
      $pdf->Cell(35,7,"________________",0,0,'C');
    
   
$pdf->SetTextColor(0,0,0);
 
 
   
  
  
    $pdf->Ln();
   
       $pdf->Cell(20,3,"_________________________________________________________________________________________________",0,0,'L');  
       // $pdf->SetFillColor(192,192,192);
        $pdf->SetTextColor(0,0,0);
       
           $pdf->Ln(14);
            $pdf->SetFillColor(192,192,192);
        $pdf->SetFont('Times','B',11); 
          $pdf->SetLineWidth(0.5);
         $pdf->Cell(18,12,utf8_decode('Serviço'),0,0,'C',1);
        $pdf->Cell(95,12,utf8_decode('Descrição'),0,0,'C',1);
         $pdf->Cell(12,12,'Qtd.',0,0,'C',1);
        $pdf->Cell(23,12,utf8_decode('P. Unitário'),0,0,'L',1);
          $pdf->Cell(15,12,utf8_decode('Desc. %'),0,0,'C',1);
         $pdf->Cell(25,12,utf8_decode('Total Líquido'),0,0,'C',1);
      $pdf->SetTextColor(0,0,0);
          //$pdf->Line(10,137.5,200,137.5);

      $pdf->Ln(16);   
     
        $pdf->SetFont('Times','',11);
foreach ($prod->detalheFactura($coFact) as $lista) { 
            $pdf->Cell(18,5,escape($lista->cod_produto),0,0,'C');
          $xPos=$pdf->GetX();
           $yPos=$pdf->GetY();

            $pdf->MultiCell(95,5,utf8_decode($lista->description),0);
            $pdf->SetXY($xPos + 95, $yPos);
             $pdf->Cell(12,5,escape($lista->quantidade),0,0,'C');
            $pdf->Cell(23,5,escape($lista->preco),0,0,'C');
             $pdf->Cell(20,5,escape($lista->perc_desconto),0,0,'C');
             $pdf->Cell(20,5,escape($lista->subtotal_prod),0,0,'L');
              $pdf->Ln(11);   
  }
  $pdf->Ln();   
  $pdf->SetFont('Times','B',11);
  $pdf->Cell(20,5,"_________________________________________________________________________________________________",0,0,'L'); 
 $pdf->Ln(5); 
 
        foreach ($prod->detalheTotalFactura($coFact) as $lista) {

        $pdf->SetFont('Times','I',11);
          $pdf->Cell(110,8,'Documento processado por Computador / @BIS Software',0,0,'L');
           $pdf->SetFont('Times','',11);
          $pdf->Cell(60,8,utf8_decode('Total Líquido: '),0,0,'R');
          $pdf->Cell(20,8,escape($lista->subtotal_factura),0,0,'L');
           $pdf->Ln(3);
            $pdf->Cell(140,5,"",0,0,'L'); 
             $pdf->SetFont('Times','B',11);
           $pdf->Cell(50,5,"_________________________",0,0,'R'); 
          $pdf->Ln(3); 
          
           $pdf->SetFont('Times','B',11);
           $pdf->Cell(110,8,'Quadro Resumo do IVA',0,0,'L');
                $pdf->SetFont('Times','',11);          
        $pdf->Cell(60,8,utf8_decode('Desc.('.escape($lista->perc_desconto).'%): '),0,0,'R');

      $valor_desconto= round(escape($lista->subtotal_factura * escape($lista->perc_desconto))/100);

          $pdf->Cell(20,8,$valor_desconto.'.00',0,0,'L');
           $pdf->Ln(3);
            $pdf->Cell(140,5,"",0,0,'L'); 
             $pdf->SetFont('Times','B',11);
           $pdf->Cell(50,5,"_________________________",0,0,'R'); 
          $pdf->Ln(3); 
            $pdf->SetFont('Times','B',11);
            $pdf->Cell(20,8,'Taxa',0,0,'L'); 
            $pdf->Cell(25,8,utf8_decode('Incidência'),0,0,'L');
            $pdf->Cell(40,8,'Taxa IVA',0,0,'L');
            $pdf->Cell(60,8,utf8_decode('Motivo de Isenção'),0,0,'L');
            $pdf->SetFont('Times','',11);
            $pdf->Cell(25,8,'Sub.Total: ',0,0,'R');
            $pdf->Cell(20,8,escape($lista->subTotal_descontado),0,0,'L');
            $pdf->Ln(3);  
             $pdf->SetFont('Times','B',11);    
            $pdf->Cell(100,5,"_________________________________________________________________",0,0,'L'); 
            $pdf->Cell(30,5,"",0,0,'L');
             $pdf->SetFont('Times','B',11);
          $pdf->Cell(60,5,"_________________________",0,0,'R');
          $pdf->Ln(3);  
           $pdf->SetFont('Times','',11);       
         foreach ($dados->PesquisaCliente($codCl) as $listaI) {
          $pdf->Cell(20,8,escape($listaI->iva).'%',0,0,'L');
        }
           $pdf->Cell(25,8,escape($lista->subTotal_descontado),0,0,'L');
            $pdf->Cell(40,8,escape($lista->iva_factura),0,0,'L');
             $pdf->Cell(60,8,'',0,0,'L');
            foreach ($dados->PesquisaCliente($codCl) as $listaI) {
          $pdf->Cell(25,8,'IVA('.escape($listaI->iva).'%):',0,0,'R');
        }
         $pdf->Cell(20,8,escape($lista->iva_factura),0,0,'C');
          $pdf->Ln(3);
           $pdf->SetFont('Times','B',11);
      $pdf->Cell(100,5,"_________________________________________________________________",0,0,'L'); 
      $pdf->Cell(30,5,"",0,0,'L');
      $pdf->Cell(60,5,"_________________________",0,0,'R');
      $pdf->Ln(3);
       $pdf->SetFont('Times','B',11);

          $pdf->Cell(170,10,'TOTAL(MZN): ',0,0,'R');
          $pdf->Cell(20,10,escape($lista->total_factura),0,0,'C');   
        $pdf->Ln(3);
            $pdf->Cell(140,5,"",0,0,'L'); 
           $pdf->Cell(50,5,"_________________________",0,0,'R'); 
        
         $pdf->Ln(); 

         

 }

 $pdf->SetFont('Times','',11);
  $pdf->Cell(31,8,'Cheque a ordem da: ',0,0,'L');
  $pdf->SetFont('Times','B',11);
  $pdf->Cell(95,8,utf8_decode(' Multicast Serviços, EI '),0,0,'L');
  $pdf->Ln();
  $pdf->SetTextColor(0,0,0);
  $pdf->SetFont('Times','',11);   
 $pdf->Cell(130,8,utf8_decode('Pagamento por feito por Cheque, Deposito ou Transferência Bancária:'),0,0,'L');
 $pdf->Ln(3); 
  $pdf->SetFont('Times','B',11);
  $pdf->Cell(20,5,"_________________________________________________________________",0,0,'L'); 
 $pdf->SetFont('Times','',11);
 
  $pdf->Ln(5);
    $pdf->SetFont('Times','B',11);
  $pdf->Cell(30,10,'Banco: ',0,0,'L');
  $pdf->Cell(40,10,'Conta',0,0,'L'); 
  $pdf->Cell(60,10,'NIB: ',0,0,'C');

   $pdf->SetFont('Times','',10);
 
  $pdf->Ln(8);
   $pdf->SetFont('Times','',11);
 $pdf->Cell(30,10,'Standard Bank, SA ',0,0,'L');
  $pdf->Cell(40,10,'1128581681003',0,0,'C'); 
  $pdf->Cell(60,10,'000301120858168100396',0,0,'R');
   $pdf->Ln();
    $pdf->SetFont('Times','B',10);
   $pdf->Cell(60,8,'IBAM - MZ59000301120858168100396 | ',0,0,'L');

  $pdf->Cell(35,8,' SWIFT - SBICMZMX | ',0,0,'L');
 $pdf->Cell(40,8,utf8_decode(' C/Móvel: 833211705 '),0,0,'L');
 $pdf->Cell(55,8,'____________________________',0,0,'R');  
  $pdf->Ln(5);   
  $pdf->Cell(135,8,'',0,0,'L');
   $pdf->SetFont('Times','',11);
 $pdf->Cell(55,8,'Assinatura e carimbo',0,0,'C');
  $pdf->Ln(8);   

 $pdf->SetTextColor(0,0,0);
  $dados1=new User();
    if($dados1->isLoggedIn()){
    $codigoF= ($dados1->data()->username); 
    }
    foreach ($dados1->FuncionarioLog($codigoF) as $lista) {
       $pdf->Cell(65,10,"(".escape($lista->name).")",0,0,'C');
    }
  
 $pdf->Ln(10);

 $pdf->SetTextColor(0,0,0);
 $pdf->SetFont('Times','B',11);   
  $pdf->Cell(140,8,utf8_decode('Obrigado por ter escolhido a Multicast Serviços, EI '),0,0,'C');

$pdf->Output();



?>
