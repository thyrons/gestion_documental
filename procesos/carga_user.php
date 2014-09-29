
<?php
	session_start();	
    include 'base.php';
    conectarse();   
    $lista = array();
    $data=0;
	$consulta=pg_query("select id_usuario,cod_usuario,nombres_usuario,telefono_usuario,direccion_usuario,celular_usuario,email_usuario,pais.id_pais,nick_usuario,provincias.id_provincia,id_tipo_usuario,ciudad.id_ciudad,institucion,categorias.id_categoria,departamento.id_departamento,tipo_sangre,fecha_nacimiento,sexo,estado_civil from usuario,tipo_usuario,categorias,ciudad,provincias,pais,departamento where usuario.id_tipo_user=tipo_usuario.id_tipo_usuario and usuario.id_categoria=categorias.id_categoria and usuario.id_ciudad=ciudad.id_ciudad and pais.id_pais=provincias.id_pais and provincias.id_provincia=ciudad.id_provincia and departamento.id_departamento=usuario.id_departamento and usuario.id_usuario='$_SESSION[id]'");    
	while($row=pg_fetch_row($consulta)){							
		$lista[]=$row[0];									
		$lista[]=$row[1];									
		$lista[]=$row[2];									
		$lista[]=$row[3];									
		$lista[]=$row[4];									
		$lista[]=$row[5];									
		$lista[]=$row[6];									
		$lista[]=$row[7];									
		$lista[]=$row[8];									
		$lista[]=$row[9];									
		$lista[]=$row[10];									
		$lista[]=$row[11];									
		$lista[]=$row[12];		
		$lista[]=$row[13];																
		$lista[]=$row[14];	
		$lista[]=$row[15];	
		$lista[]=$row[16];	
		$lista[]=$row[17];	
		$lista[]=$row[18];																
	}	
    echo $lista=json_encode($lista); 
?>
