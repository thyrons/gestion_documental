<?php
include 'base.php';
conectarse();
session_start();
$fecha1=$_GET['fecha1']. " "."00:00:00";
$fecha2=$_GET['fecha2']." "."23:59:59";
$lista1;
$lista2;
$contador=0;
$result = pg_query("SELECT fecha_cambio,peso FROM bitacora where fecha_cambio between '$fecha1' and '$fecha2' and id_usuario='$_SESSION[id]'");
while($row = pg_fetch_row($result)) {	
	$fecha=date("Y-m-d",strtotime($row[0]));	
	$peso=$row[1];	
	buscar($fecha,$peso);	
}
function buscar($fecha,$peso){
	global $contador,$lista1,$lista2;	
	if($contador==0){
		$lista1[$contador]=$fecha;
		$lista2[$contador]=$peso;
		$contador++;		
	}
	else{		
		$tam = count($lista1);				
		$repe=0;
		$pos=0;
		for($i=0;$i<$tam;$i++){		
			if($fecha==$lista1[$i]){				
				$repe=1;
				$pos=$i;
			}
		}
		if($repe==1){
			$lista2[$pos]=($lista2[$pos]+$peso);			
		}
		else{			
			$lista1[$contador]=$fecha;
			$lista2[$contador]=$peso;
			$contador++;
		}
	}	

}
//print_r($lista1);
//print_r($lista2);
for($f=0;$f<count($lista1);$f++){
	echo $lista1[$f] . "/" . number_format(($lista2[$f]/1024), 2, '.', ''). "/" ;
}

?>