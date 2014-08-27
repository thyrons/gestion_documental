<?php
	session_start();	
    include 'base.php';
    conectarse();   
    $lista = array();
    $data=0;
	$consulta=pg_query("select count(id_bitacora) from bitacora");    
	while($row=pg_fetch_row($consulta)){							
		$lista[]=$row[0];															
	}	
	$consulta=pg_query("select sum(cast(peso as numeric)) from bitacora");    
	while($row=pg_fetch_row($consulta)){							
		$lista[]=$row[0];															
	}	
    echo $lista=json_encode($lista); 
?>
