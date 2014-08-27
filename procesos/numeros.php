<?php
	session_start();	
    include 'base.php';
    conectarse();       
    $cont=0;
    if($_POST['iden']=='e')
    {
		$consulta=pg_query("select id_archivo from archivo where id_creador='$_SESSION[id]'");    
		$cont=pg_num_rows($consulta);
	}
	if($_POST['iden']=='r')
    {
	   	$consulta=pg_query("select id_archivo from archivo order by id_archivo asc");
		while($row=pg_fetch_row($consulta)){
			$consulta1=pg_query("select id_recibido from recibidos where id_archivo='".$row[0]."' and id_usuarios='$_SESSION[id]' and leido='1'");	
			//$consulta1=pg_query("select* from recibidos,usuario where id_archivo='".$row[0]."' and recibidos.id_usuarios=usuario.id_usuario and recibidos.leido='1'");	
			while($row1=pg_fetch_row($consulta1)){	
				$cont++;
			}
		}	    
	}	
    echo $cont;
?>
