<?php


require_once '../FPDF/rotation.php';

require_once '../Core/Init.php';
ini_set('default_charset','UTF-8');
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
  //$this->Rect(9,10,192,280);
 //$num= rand(1000000000,9999999999);


 $prod=new User();

$this->SetTextColor(0,0,0);
$this->Image('../Contents/images/logo.png',11,15,45);
 $this->Ln(20);
if(isset($_GET['cod_Cliente'])){
  $codCl=$_GET['cod_Cliente'];
}
if(isset($_GET['cod_Factura'])){
  $coFact=$_GET['cod_Factura'];
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
    $this->Cell(150,10,'',0,0,'C');
    $this->Cell(40,10,utf8_decode('COTAÇÃO'),0,0,'C');
    $this->Ln(10);
    $this->SetFont('Times','B',11);
    $this->Cell(120,10,'',0,0,'C');
  $this->Cell(30,10,'Nro:',0,0,'L');
    foreach ($prod->detalheTotal_cotacao($coFact) as $lista1) {     
        $this->Cell(40,10,'MS/SQ - '.$coFact.'/'.escape($lista1->ano),0,0,'L');  
     } 
  
    $this->Ln(7);  
    $this->SetFont('Times','B',11);
     $this->Cell(120,10,'',0,0,'C');   
  $this->Cell(30,10,utf8_decode('Endereço:'),0,0,'L');
  $this->SetFont('Times','',11);
  $this->Cell(40,10,utf8_decode($lista->endereco),0,0,'L');   
    $this->Ln(7);
$this->SetFont('Times','B',11);
  $this->Cell(120,10,'',0,0,'C');
  $this->Cell(30,10,'Att:',0,0,'L');
  $this->SetFont('Times','',11);
  $this->Cell(40,10,utf8_decode($lista->nomeCliente),0,0,'L');   
    $this->Ln(7);
$this->SetFont('Times','B',11);
  $this->Cell(120,10,'',0,0,'C');
  $this->Cell(30,10,'Telefone:',0,0,'L');
  $this->SetFont('Times','',11);
  $this->Cell(40,10,escape($lista->contactoCliente),0,0,'L');   
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
 
    $pdf->SetFillColor(192,192,192);   
    $pdf->SetFont('Times','B',10);   
   // $pdf->Line(10,80,200,80);
    $pdf->Cell(50,7,"Operador",0,0,'C',1);
    $pdf->Cell(30,7,"Data",0,0,'C',1);
    $pdf->Cell(37,7,"Nuit/Cliente",0,0,'C',1);
    $pdf->Cell(28,7,"Nr cliente",0,0,'C',1);
    $pdf->Cell(25,7,"Cond. Pagto",0,0,'L',1);  
    $pdf->Cell(20,7,"Validade",0,0,'C',1); 
    //$pdf->Line(10,112,200,112);
    $pdf->Ln();

    $pdf->SetFont('Times','',10); 
    $pdf->SetLineWidth(0.3);   
    $dados1=new User();
    if($dados1->isLoggedIn()){
    $codigoF= ($dados1->data()->id); 
    }
    foreach ($dados->FuncionarioLog($codigoF) as $lista) {
  $pdf->Cell(50,7,utf8_decode($lista->name),0,0,'C');
}   
     foreach ($prod->detalheTotal_cotacao($coFact) as $lista) {     
       $pdf->Cell(30,7,escape($lista->dataVenda),0,0,'C');
     } 
     //$pdf->Line(45,45,200,45);
     foreach ($dados->PesquisaCliente($codCl) as $lista) {
       $pdf->Cell(37,7,escape($lista->nuitCliente),0,0,'C'); 
        $pdf->Cell(28,7,escape($lista->idCliente),0,0,'C'); 
      }
     $pdf->Cell(25,7,"Pronto",0,0,'C');  
      $pdf->Cell(20,7,"07 dias",0,0,'C');
      $pdf->Ln(8);

       
        $pdf->SetTextColor(0,0,0);
      $pdf->SetFillColor(192,192,192);  
           $pdf->Ln(10);
        $pdf->SetFont('Times','B',10); 
          $pdf->SetLineWidth(0.3);
         $pdf->Cell(15,9,'Ordem',0,0,'C',1);
        $pdf->Cell(95,9,utf8_decode('Descrição/Refª'),0,0,'C',1);
         $pdf->Cell(12,9,'Qtd.',0,0,'C',1);
        $pdf->Cell(23,9,utf8_decode('Preço Unit.'),0,0,'C',1);
            $pdf->Cell(20,9,utf8_decode('Desconto.'),0,0,'C',1);
         $pdf->Cell(25,9,utf8_decode('Total Líquido'),0,0,'C',1);
     
          //$pdf->Line(10,137.5,200,137.5);

      $pdf->Ln(12);   
      $pdf->SetFillColor(255,255,255);
        $pdf->SetFont('Times','',10);
foreach ($prod->detalheCotacao($coFact) as $lista) { 
            $pdf->Cell(15,9,escape($lista->cod_servico),0,0,'C',1);
          $xPos=$pdf->GetX();
           $yPos=$pdf->GetY();

            $pdf->MultiCell(95,10,utf8_decode($lista->description),0);
            $pdf->SetXY($xPos + 95, $yPos);
             $pdf->Cell(12,10,escape($lista->quantidade),0,0,'C',1);
            $pdf->Cell(23,10,escape($lista->preco),0,0,'C',1);

            $desconto=escape($lista->subtotal_prod) * escape($lista->perc_desconto)/100;
              $pdf->Cell(20,10, $desconto.'.00',0,0,'C',1);
              $valor_subtotal=(escape($lista->subtotal_prod)-$desconto);
             $pdf->Cell(25,10,$valor_subtotal.'.00',0,0,'C',1);
              $pdf->Ln();   
  }

    $pdf->Ln(10);
     $pdf->SetTextColor(0,0,0);
      $pdf->SetFillColor(255,255,255);  
           $pdf->Ln(10);
        $pdf->SetFont('Times','B',10); 
          $pdf->SetLineWidth(0.5);
         $pdf->Cell(15,5,'',0,0,'L',1);
        $pdf->Cell(113,5,utf8_decode('Termos e Condições'),0,0,'L',1);
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
            $pdf->MultiCell(113,5,utf8_decode('Entrga imediata alvo ruptura de stock. É aplicável garantia stardard do fabricante salvo indicação contrária'),0);
            $pdf->SetXY($xPos + 115, $yPos);
        
         $pdf->Cell(12,5,'',0,0,'C',1);
        $pdf->Cell(23,5,'',0,0,'C',1);
         $pdf->Cell(25,5,'',0,0,'C',1);
         $pdf->Ln(18);
           $pdf->SetFont('Times','B',10);
  $pdf->Cell(20,5,"__________________________________________________________________________________________________________",0,0,'L'); 
 $pdf->Ln(5); 
 


 
        foreach ($prod->detalheTotal_cotacao($coFact) as $lista) {

        $pdf->SetFont('Times','I',10);
          $pdf->Cell(110,3,'Documento processado por Computador / @BIS Software',0,0,'L',1);
           $pdf->SetFont('Times','',10);
          $pdf->Cell(60,3,utf8_decode('Total Líquido: '),0,0,'R',1);
          $pdf->Cell(20,3,escape($lista->subtotal_factura),0,0,'L',1);
           $pdf->Ln(3);
           $pdf->Cell(140,3,"",0,0,'L'); 
             $pdf->SetFont('Times','B',10);
           $pdf->Cell(50,3,"___________________________",0,0,'R'); 
          $pdf->Ln(5); 
          
           $pdf->SetFont('Times','B',10);
           $pdf->Cell(110,3,'Quadro Resumo do IVA',0,0,'L',1);
                $pdf->SetFont('Times','',10);          
          $pdf->Cell(60,3,'Desc.('.escape($lista->perc_desconto).'%): ',0,0,'R',1);

          $v_desconto=round((escape($lista->subtotal_factura)*(escape($lista->perc_desconto)/100)));

          $pdf->Cell(20,3,$v_desconto,0,0,'L',1);
           $pdf->Ln(3);
            $pdf->Cell(140,3,"",0,0,'L'); 
              $pdf->SetFont('Times','B',10);
           $pdf->Cell(50,3,"___________________________",0,0,'R'); 
          $pdf->Ln(5); 
            $pdf->SetFont('Times','B',10);
            $pdf->Cell(20,3,'Taxa',0,0,'L',1); 
            $pdf->Cell(25,3,utf8_decode('Incidência'),0,0,'L',1);
            $pdf->Cell(40,3,'Taxa IVA',0,0,'L',1);
            $pdf->Cell(60,3,utf8_decode('Motivo de Isenção'),0,0,'L',1);
            $pdf->SetFont('Times','',11);
            $pdf->Cell(25,3,'Sub.Total: ',0,0,'L',1);
            $pdf->Cell(20,3,escape($lista->valor_descontado),0,0,'L',1);
            $pdf->Ln(3);
              $pdf->SetFont('Times','B',10);
            $pdf->Cell(140,3,"__________________________________________________________________",0,0,'L'); 
             $pdf->Cell(50,3,"___________________________",0,0,'R'); 
          $pdf->Ln(5);    
            $pdf->SetFont('Times','',10);     
         foreach ($dados->PesquisaCliente($codCl) as $listaI) {
          $pdf->Cell(20,3,escape($listaI->iva).'%',0,0,'L',1);
        }
           $pdf->Cell(25,3,escape($lista->valor_descontado),0,0,'L',1);
            $pdf->Cell(40,3,escape($lista->iva_factura),0,0,'L',1);
             $pdf->Cell(60,3,'',0,0,'L',1);
            foreach ($dados->PesquisaCliente($codCl) as $listaI) {
          $pdf->Cell(25,3,'IVA('.escape($listaI->iva).'%):',0,0,'L',1);
        }
         $pdf->Cell(20,3,escape($lista->iva_factura),0,0,'C',1);
          $pdf->Ln(3);
            $pdf->SetFont('Times','B',10);
           $pdf->Cell(140,3,"__________________________________________________________________",0,0,'L'); 
            $pdf->Cell(50,3,"___________________________",0,0,'R'); 
      $pdf->Ln(5);
       $pdf->SetFont('Times','B',10);
          $pdf->Cell(170,3,'TOTAL(MZN): ',0,0,'R',1);
          $pdf->Cell(20,3,escape($lista->total_factura),0,0,'C',1);   
        $pdf->Ln(3);
            $pdf->Cell(140,3,"",0,0,'L'); 
              $pdf->SetFont('Times','B',10);
           $pdf->Cell(50,3,"___________________________",0,0,'R'); 
        
         $pdf->Ln(); 

         

 }

 $pdf->Ln(3); 
 $pdf->SetFont('Times','',10);
 $pdf->Cell(31,8,'Cheque a ordem da ',0,0,'L');
   $pdf->SetFont('Times','B',10);
  $pdf->Cell(130,8,utf8_decode('Multicast Serviços, EI '),0,0,'L');
 $pdf->Ln(5);
  $pdf->SetFont('Times','',10);
  $pdf->SetTextColor(0,0,0);   
 $pdf->Cell(130,8,utf8_decode('Pagamento por feito por Cheque, Deposito ou Transferência Bancária:'),0,0,'L');
 $pdf->SetFont('Times','',10);
   $pdf->Ln(4);
     $pdf->SetFont('Times','B',10);
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
  $pdf->SetFont('Times','B',10);
 $pdf->Cell(60,8,'____________________________',0,0,'C'); 

  $pdf->Ln(7);  

  $pdf->Cell(130,8,utf8_decode(' IBAM: MZ59000301120858168100396 | SWIFT: SBICMZMX | C/Móvel: 833211705'),0,0,'L');
    
 $pdf->Cell(60,8,'Assinatura e carimbo',0,0,'C');  



$pdf->Output();



?>
