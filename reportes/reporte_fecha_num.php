<?php
session_start();
include '../fdpf/fpdf.php';
include '../procesos/base.php';
conectarse();
//header("Content-Type: text/html; charset=iso-8859-1 ");
date_default_timezone_set('UTC');
$fecha= date("Y-m-d");

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
 	$this->SetTextColor(70,119,159);         
	$this->SetFont('Helvetica','B',25);
	$this->Text(110,20,'REPORTE POR FECHAS',0,'C', 0);
	$this->Image('../imagenes/logo.png',20,10,82,0,'','http://localhost:8080/gestion_documental/paginas/index.php'); 
	$this->Ln(30);
}

function Footer()
{
	$this->SetY(-15);
	$this->SetFont('Arial','B',8);
	$this->Cell(100,10,'Reporte por fechas',0,0,'L');

}

}			
	$pdf=new PDF('L','mm','A4');
	$pdf->Open();
	$pdf->AddPage();
	$pdf->SetMargins(20,20,20);
	$pdf->Ln(10);
	
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(140,8,'Nombres del Usuario: '.utf8_decode($_SESSION['nombres']),1,0);
	$pdf->Cell(60,8,'Codigo: '.$_SESSION['cod'],1,0);
	$pdf->Cell(70,8,'Nivel: '.utf8_decode($_SESSION['nivel']),1,1); 	
	$pdf->Cell(170,8,'Institucion: '.utf8_decode($_SESSION['institucion']),1,0);
	$pdf->Cell(100,8,'Fecha reporte: '.$fecha,1,0);
	
	$pdf->Ln(10);
	$cont=0;
	$fecha1=$_GET['fecha_ini'];
	$fecha2=$_GET['fecha_fin'];
	$repetidas=0;
	$consulta1=pg_query("select id_archivo,nombre_archivo,codigo_archivo from archivo where id_creador='$_SESSION[id]'");      					
	while($row1=pg_fetch_row($consulta1)){							

		while($fecha1<=$fecha2){			
			$temp1=$fecha1." "."00:00:00";
			$temp2=$fecha1." "."23:59:59";	
			$pdf->SetWidths(array(60, 80, 30, 40, 60));
			$pdf->SetFont('Arial','B',10);
			$pdf->SetFillColor(85,107,47);
	    	$pdf->SetTextColor(70,119,159);    	
			$strConsulta =pg_query("select id_bitacora,referencia,asunto_cambio,nombre_departamento,fecha_cambio,nombres_usuario from bitacora,usuario,departamento where bitacora.id_usuario=usuario.id_usuario and bitacora.id_departamento=departamento.id_departamento and bitacora.id_archivo='$row1[0]';");
			while($fila=pg_fetch_row($strConsulta)){						
				$sql=pg_query("select * from bitacora where id_bitacora='$fila[0]' and fecha_cambio between '$temp1' and '$temp2'");																			
				$numfilas = pg_num_rows($sql);												
				for ($i=0; $i<$numfilas; $i++)
				{
					if($cont==0){						
						$pdf->Row(array(utf8_decode('Nombre:'.' '.$row1[1]), utf8_decode('Código:'.' '.$row1[2])));											    	
						$cont=1;
						$pdf->Ln(5);		
					}											
					if($repetidas==0){
						$pdf->Row(array(utf8_decode('Nombre Archivo'), utf8_decode('Asunto'), utf8_decode('Destino'), utf8_decode('Fecha cambio'), utf8_decode('Modificador por:')));				
						$repetidas=1;						
					}																
					$pdf->SetFont('Arial','',10);				
					$pdf->SetFillColor(255,255,255);
			   		$pdf->SetTextColor(0);
					$pdf->Row(array(utf8_decode($fila[1]), utf8_decode($fila[2]), utf8_decode($fila[3]), utf8_decode($fila[4]), utf8_decode($fila[5])));
					$pdf->Ln(5);						
				}
				
			}				
																													
			$fecha1 = strtotime ( '+1 day' , strtotime ( $fecha1 ) ) ;
			$fecha1 = date ( 'Y-m-d' , $fecha1 );			
			$repetidas=0;				
		}
		$cont=0;
		$fecha1=$_GET['fecha_ini'];
		$fecha2=$_GET['fecha_fin'];

	}				
	$pdf->Output();

?>