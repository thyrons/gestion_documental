<?php
session_start();
include '../fdpf/fpdf.php';
include '../procesos/base.php';
conectarse();
//header("Content-Type: text/html; charset=iso-8859-1 ");

class PDF extends FPDF
{
var $widths;
var $aligns;

function SetWidths($w)
{
	//Set the array of column widths
	$this->widths=$w;
}

function SetAligns($a)
{
	//Set the array of column alignments
	$this->aligns=$a;
}

function Row($data)
{
	//Calculate the height of the row
	$nb=0;
	for($i=0;$i<count($data);$i++)
		$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
	$h=6*$nb;
	//Issue a page break first if needed
	$this->CheckPageBreak($h);
	//Draw the cells of the row
	for($i=0;$i<count($data);$i++)
	{
		$w=$this->widths[$i];
		$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'C';
		//Save the current position
		$x=$this->GetX();
		$y=$this->GetY();
		//Draw the border
		
		$this->Rect($x,$y,$w,$h);

		$this->MultiCell($w,6,$data[$i],0,$a,false);
		//Put the position to the right of the cell
		$this->SetXY($x+$w,$y);
	}
	//Go to the next line
	$this->Ln($h);
}

function CheckPageBreak($h)
{
	//If the height h would cause an overflow, add a new page immediately
	if($this->GetY()+$h>$this->PageBreakTrigger)
		$this->AddPage($this->CurOrientation);
}

function NbLines($w,$txt)
{
	//Computes the number of lines a MultiCell of width w will take
	$cw=&$this->CurrentFont['cw'];
	if($w==0)
		$w=$this->w-$this->rMargin-$this->x;
	$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
	$s=str_replace("\r",'',$txt);
	$nb=strlen($s);
	if($nb>0 and $s[$nb-1]=="\n")
		$nb--;
	$sep=-1;
	$i=0;
	$j=0;
	$l=0;
	$nl=1;
	while($i<$nb)
	{
		$c=$s[$i];
		if($c=="\n")
		{
			$i++;
			$sep=-1;
			$j=$i;
			$l=0;
			$nl++;
			continue;
		}
		if($c==' ')
			$sep=$i;
		$l+=$cw[$c];
		if($l>$wmax)
		{
			if($sep==-1)
			{
				if($i==$j)
					$i++;
			}
			else
				$i=$sep+1;
			$sep=-1;
			$j=$i;
			$l=0;
			$nl++;
		}
		else
			$i++;
	}
	return $nl;
}

function Header()
{
	date_default_timezone_set('UTC');
	$fecha= date("Y-m-d");
	$this->SetTextColor(70,119,159);        
	$this->SetFont('Helvetica','B',20);
	$this->Text(105,16,utf8_decode('AUDITORÍA DEL SISTEMA (SISTEMA)'),0,'C', 0);
	$this->Image('../imagenes/logo.png',5,10,82,0,'','http://localhost:8080/gestion_documental/paginas/index.php'); 
	$this->SetFont('Helvetica','B',11);
	$this->SetTextColor(0,0,0);        
	$this->Text(115,23,utf8_decode('Desde: '.$_GET['inicio']),0,'C', 1);
	$this->Text(175,23,utf8_decode('Hasta: '.$_GET['fin']),0,'C', 1);
	$this->Ln(25);
	$this->SetFont('Arial','B',10);
    $this->Cell(130,6,'Nombres del Usuario: '.utf8_decode($_SESSION['nombres']),0,0);
	$this->Cell(70,6,'Codigo: '.$_SESSION['cod'],0,0);
	$this->Cell(130,6,'Institucion: '.utf8_decode($_SESSION['institucion']),0,0);
	$this->Cell(70,6,'Nivel: '.utf8_decode($_SESSION['nivel']),0,1); 	
	$this->Cell(200,6,'Fecha reporte: '.$fecha,0,1);
	
	$this->Ln(5);
	
}

function Footer()
{
	$this->SetY(-15);
	$this->SetFont('Arial','B',8);
	$this->Cell(100,10,'Auditoria sistema (Sistema)',0,0,'L');

}

}			
	$pdf=new PDF('L','mm','A4');
	$pdf->Open();
	$pdf->AddPage();
	$pdf->SetMargins(5,5,5);
	$pdf->Ln(10);

    
	
	$pdf->SetWidths(array(20,25, 30, 20,30,60,60,40));
	$pdf->SetFont('Arial','B',10);
	$pdf->SetFillColor(85,107,47);       
    $pdf->SetTextColor(70,119,159);  

	$pdf->Row(array(utf8_decode('Codigo'), utf8_decode('Tabla'), utf8_decode('Operacion'),utf8_decode('Fecha'),utf8_decode('Usuario'),utf8_decode('Valor Anterior'),utf8_decode('Nuevo Valor'),utf8_decode('Observaciones')));
	
	$fecha_inicio=$_GET['inicio'].' '.'00:00:00';
	$fecha_fin=$_GET['fin'].' '.'23:59:59';

	$sql=pg_query("select id_sistema,tabla,operacion,fecha_cambio,usuario,anterior,nuevo,observacion from auditoria_sistema where fecha_cambio between '$_GET[inicio]' and '$_GET[fin]'");
	$pdf->SetFont('Arial','',8);				
	$pdf->SetFillColor(255,255,255);
    $pdf->SetTextColor(0);	    
	while($row=pg_fetch_row($sql)){
		$pdf->Row(array(utf8_decode($row[0]), utf8_decode($row[1]), utf8_decode($row[2]), utf8_decode($row[3]),utf8_decode($row[4]),utf8_decode($row[5]),utf8_decode($row[6]),utf8_decode($row[7])));	
	}			
	

$pdf->Output();
?>