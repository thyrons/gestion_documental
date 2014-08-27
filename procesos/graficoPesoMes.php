<?php
include 'base.php';
conectarse();
$lista1;
$lista2;
$contador=0;
$mes=0;
$tem='';
$result = pg_query("SELECT fecha_cambio,peso FROM bitacora");
while($row = pg_fetch_row($result)) {		
	$mes=intval(substr($row[0],5,2));		
	if($mes>=intval($_GET['mes1']) && $mes<=intval($_GET['mes2'])){		
		if($mes=='01'){
			$temp='Enero';
		}
		if($mes=='02'){
			$temp='Febrero';
		}
		if($mes=='03'){
			$temp='Marzo';
		}
		if($mes=='04'){
			$temp='Abril';
		}
		if($mes=='05'){
			$temp='Mayo';
		}
		if($mes=='06'){
			$temp='Junio';
		}
		if($mes=='07'){
			$temp='Julio';
		}
		if($mes=='08'){
			$temp='Agosto';
		}
		if($mes=='09'){
			$temp='Septiembre';
		}
		if($mes=='10'){
			$temp='Octubre';
		}
		if($mes=='11'){
			$temp='Noviembre';
		}
		if($mes=='12'){
			$temp='Diciembre';
		}
		$fecha=$temp;	
		$peso=$row[1];	
		buscar($fecha,$peso);	
	}		
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
		}
		$contador++;
	}	

}
//print_r($lista1);
//print_r($lista2);
for($f=0;$f<count($lista1);$f++){
	echo $lista1[$f] . "/" . ($lista2[$f]/1024). "/" ;
}

?>