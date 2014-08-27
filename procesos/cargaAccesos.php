<?php
	include 'base.php'; 
    session_start();
    conectarse();   
   	$lista = array();
    $data=0;          
    $consulta=pg_query("select id_acceso,nombre_aplicacion,aplicaciones.id_aplicacion,estado from accesos,aplicaciones where id_usuario='$_POST[id]' and accesos.id_aplicacion=aplicaciones.id_aplicacion order by id_acceso asc");
    while($row=pg_fetch_row($consulta)){							
		$lista[]=$row[0];									
		$lista[]=$row[1];									
		$lista[]=$row[2];									
		$lista[]=$row[3];																													
	}	
    echo $lista=json_encode($lista); 
     

?>