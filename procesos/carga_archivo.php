
<?php
	session_start();	
    include 'base.php';
    conectarse();   
    $lista = array();
    $data=0;
	$consulta=pg_query("select archivo.id_archivo,fecha_cambio,estado,id_departamento,asunto_cambio,observaciones from archivo,bitacora where archivo.id_archivo=bitacora.id_archivo and archivo.id_archivo='$_POST[codigo]' order by id_bitacora desc limit 1");    
	while($row=pg_fetch_row($consulta)){							
		$lista[]=$row[0];									
		$lista[]=$row[1];									
		$lista[]=$row[2];									
		$lista[]=$row[3];									
		$lista[]=$row[4];									
		$lista[]=$row[5];									
	}	
    echo $lista=json_encode($lista); 
?>
