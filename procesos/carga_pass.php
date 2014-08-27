<?php
	session_start();	
    include 'base.php';
    conectarse();   
    $lista = array();
    $data=0;
	$consulta=pg_query("select clave from clave where usuario='$_SESSION[id]'");    
	while($row=pg_fetch_row($consulta)){							
		$lista[]=$row[0];															
	}	
    echo $lista=json_encode($lista); 
?>
