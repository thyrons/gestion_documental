<?php
include '../procesos/base.php';
$page = $_GET['page']; 
$limit = $_GET['rows']; 
$sidx = $_GET['sidx']; 
$sord = $_GET['sord']; 
$search=$_GET['_search'];


if (!$sidx)
    $sidx = 1;
$result = pg_query("SELECT COUNT(*) AS count FROM usuario, tipo_usuario,pais,provincias,ciudad where usuario.id_tipo_user=tipo_usuario.id_tipo_usuario and pais.id_pais=provincias.id_pais and provincias.id_provincia=ciudad.id_provincia and usuario.id_ciudad=ciudad.id_ciudad"); 
$row = pg_fetch_row($result);
$count = $row[0];
if ($count > 0 && $limit > 0) {
    $total_pages = ceil($count / $limit);
} else {
    $total_pages = 0;
}
if ($page > $total_pages)
    $page = $total_pages;
$start = $limit * $page - $limit;
if ($start < 0)
    $start = 0;		
	if($search=='false'){
        $SQL = "select id_usuario,cod_usuario,nombres_usuario,telefono_usuario,celular_usuario,direccion_usuario,email_usuario,id_tipo_user,nombre_tipo,nick_usuario,pais.id_pais,nombre_pais,provincias.id_provincia,provincias.nombre_provincia,ciudad.id_ciudad,ciudad.nombre_ciudad,institucion,categorias.id_categoria,categorias.nombre_categoria,departamento.id_departamento,departamento.nombre_departamento,tipo_sangre,fecha_nacimiento,sexo,estado_civil from usuario, tipo_usuario,pais,provincias,ciudad,categorias,departamento where usuario.id_tipo_user=tipo_usuario.id_tipo_usuario and pais.id_pais=provincias.id_pais and provincias.id_provincia=ciudad.id_provincia and usuario.id_ciudad=ciudad.id_ciudad and categorias.id_categoria=usuario.id_categoria and departamento.id_departamento=usuario.id_departamento ORDER BY $sidx $sord offset $start limit $limit";	
	}
    else{        
    	$campo=$_GET['searchField'];
    	if($campo=='nombre_user'){
    		$campo='nombres_usuario';
    	}
    	if($campo=='cod_user'){
    		$campo='cod_usuario';
    	}
        if($_GET['searchOper']=='eq'){
        	$SQL = "select id_usuario,cod_usuario,nombres_usuario,telefono_usuario,celular_usuario,direccion_usuario,email_usuario,id_tipo_user,nombre_tipo,nick_usuario,pais.id_pais,nombre_pais,provincias.id_provincia,provincias.nombre_provincia,ciudad.id_ciudad,ciudad.nombre_ciudad,institucion,categorias.id_categoria,categorias.nombre_categoria,departamento.id_departamento,departamento.nombre_departamento,tipo_sangre,fecha_nacimiento,sexo,estado_civil from usuario, tipo_usuario,pais,provincias,ciudad,categorias,departamento where usuario.id_tipo_user=tipo_usuario.id_tipo_usuario and pais.id_pais=provincias.id_pais and provincias.id_provincia=ciudad.id_provincia and usuario.id_ciudad=ciudad.id_ciudad and categorias.id_categoria=usuario.id_categoria and departamento.id_departamento=usuario.id_departamento and $campo = '$_GET[searchString]' ORDER BY $sidx $sord offset $start limit $limit";	
        }
        if($_GET['searchOper']=='ne'){
        	$SQL = "select id_usuario,cod_usuario,nombres_usuario,telefono_usuario,celular_usuario,direccion_usuario,email_usuario,id_tipo_user,nombre_tipo,nick_usuario,pais.id_pais,nombre_pais,provincias.id_provincia,provincias.nombre_provincia,ciudad.id_ciudad,ciudad.nombre_ciudad,institucion,categorias.id_categoria,categorias.nombre_categoria,departamento.id_departamento,departamento.nombre_departamento,tipo_sangre,fecha_nacimiento,sexo,estado_civil from usuario, tipo_usuario,pais,provincias,ciudad,categorias,departamento where usuario.id_tipo_user=tipo_usuario.id_tipo_usuario and pais.id_pais=provincias.id_pais and provincias.id_provincia=ciudad.id_provincia and usuario.id_ciudad=ciudad.id_ciudad and categorias.id_categoria=usuario.id_categoria and departamento.id_departamento=usuario.id_departamento and $campo! = '$_GET[searchString]' ORDER BY $sidx $sord offset $start limit $limit";	
        }
        if($_GET['searchOper']=='bw'){
        	$SQL = "select id_usuario,cod_usuario,nombres_usuario,telefono_usuario,celular_usuario,direccion_usuario,email_usuario,id_tipo_user,nombre_tipo,nick_usuario,pais.id_pais,nombre_pais,provincias.id_provincia,provincias.nombre_provincia,ciudad.id_ciudad,ciudad.nombre_ciudad,institucion,categorias.id_categoria,categorias.nombre_categoria,departamento.id_departamento,departamento.nombre_departamento,tipo_sangre,fecha_nacimiento,sexo,estado_civil from usuario, tipo_usuario,pais,provincias,ciudad,categorias,departamento where usuario.id_tipo_user=tipo_usuario.id_tipo_usuario and pais.id_pais=provincias.id_pais and provincias.id_provincia=ciudad.id_provincia and usuario.id_ciudad=ciudad.id_ciudad and categorias.id_categoria=usuario.id_categoria and departamento.id_departamento=usuario.id_departamento and $campo like '$_GET[searchString]%' ORDER BY $sidx $sord offset $start limit $limit";	
        }
        if($_GET['searchOper']=='bn'){
        	$SQL = "select id_usuario,cod_usuario,nombres_usuario,telefono_usuario,celular_usuario,direccion_usuario,email_usuario,id_tipo_user,nombre_tipo,nick_usuario,pais.id_pais,nombre_pais,provincias.id_provincia,provincias.nombre_provincia,ciudad.id_ciudad,ciudad.nombre_ciudad,institucion,categorias.id_categoria,categorias.nombre_categoria,departamento.id_departamento,departamento.nombre_departamento,tipo_sangre,fecha_nacimiento,sexo,estado_civil from usuario, tipo_usuario,pais,provincias,ciudad,categorias,departamento where usuario.id_tipo_user=tipo_usuario.id_tipo_usuario and pais.id_pais=provincias.id_pais and provincias.id_provincia=ciudad.id_provincia and usuario.id_ciudad=ciudad.id_ciudad and categorias.id_categoria=usuario.id_categoria and departamento.id_departamento=usuario.id_departamento and $campo not like '$_GET[searchString]%' ORDER BY $sidx $sord offset $start limit $limit";	 
        }
        if($_GET['searchOper']=='ew'){  
        	$SQL = "select id_usuario,cod_usuario,nombres_usuario,telefono_usuario,celular_usuario,direccion_usuario,email_usuario,id_tipo_user,nombre_tipo,nick_usuario,pais.id_pais,nombre_pais,provincias.id_provincia,provincias.nombre_provincia,ciudad.id_ciudad,ciudad.nombre_ciudad,institucion,categorias.id_categoria,categorias.nombre_categoria,departamento.id_departamento,departamento.nombre_departamento,tipo_sangre,fecha_nacimiento,sexo,estado_civil from usuario, tipo_usuario,pais,provincias,ciudad,categorias,departamento where usuario.id_tipo_user=tipo_usuario.id_tipo_usuario and pais.id_pais=provincias.id_pais and provincias.id_provincia=ciudad.id_provincia and usuario.id_ciudad=ciudad.id_ciudad and categorias.id_categoria=usuario.id_categoria and departamento.id_departamento=usuario.id_departamento and $campo like '%$_GET[searchString]' ORDER BY $sidx $sord offset $start limit $limit";	
        }
        if($_GET['searchOper']=='en'){
        	$SQL = "select id_usuario,cod_usuario,nombres_usuario,telefono_usuario,celular_usuario,direccion_usuario,email_usuario,id_tipo_user,nombre_tipo,nick_usuario,pais.id_pais,nombre_pais,provincias.id_provincia,provincias.nombre_provincia,ciudad.id_ciudad,ciudad.nombre_ciudad,institucion,categorias.id_categoria,categorias.nombre_categoria,departamento.id_departamento,departamento.nombre_departamento,tipo_sangre,fecha_nacimiento,sexo,estado_civil from usuario, tipo_usuario,pais,provincias,ciudad,categorias,departamento where usuario.id_tipo_user=tipo_usuario.id_tipo_usuario and pais.id_pais=provincias.id_pais and provincias.id_provincia=ciudad.id_provincia and usuario.id_ciudad=ciudad.id_ciudad and categorias.id_categoria=usuario.id_categoria and departamento.id_departamento=usuario.id_departamento and $campo not like '%$_GET[searchString]%' ORDER BY $sidx $sord offset $start limit $limit";	
        }
        if($_GET['searchOper']=='cn'){  
        	$SQL = "select id_usuario,cod_usuario,nombres_usuario,telefono_usuario,celular_usuario,direccion_usuario,email_usuario,id_tipo_user,nombre_tipo,nick_usuario,pais.id_pais,nombre_pais,provincias.id_provincia,provincias.nombre_provincia,ciudad.id_ciudad,ciudad.nombre_ciudad,institucion,categorias.id_categoria,categorias.nombre_categoria,departamento.id_departamento,departamento.nombre_departamento,tipo_sangre,fecha_nacimiento,sexo,estado_civil from usuario, tipo_usuario,pais,provincias,ciudad,categorias,departamento where usuario.id_tipo_user=tipo_usuario.id_tipo_usuario and pais.id_pais=provincias.id_pais and provincias.id_provincia=ciudad.id_provincia and usuario.id_ciudad=ciudad.id_ciudad and categorias.id_categoria=usuario.id_categoria and departamento.id_departamento=usuario.id_departamento and $campo like '%$_GET[searchString]%' ORDER BY $sidx $sord offset $start limit $limit";	
        }
        if($_GET['searchOper']=='nc'){  
        	$SQL = "select id_usuario,cod_usuario,nombres_usuario,telefono_usuario,celular_usuario,direccion_usuario,email_usuario,id_tipo_user,nombre_tipo,nick_usuario,pais.id_pais,nombre_pais,provincias.id_provincia,provincias.nombre_provincia,ciudad.id_ciudad,ciudad.nombre_ciudad,institucion,categorias.id_categoria,categorias.nombre_categoria,departamento.id_departamento,departamento.nombre_departamento,tipo_sangre,fecha_nacimiento,sexo,estado_civil from usuario, tipo_usuario,pais,provincias,ciudad,categorias,departamento where usuario.id_tipo_user=tipo_usuario.id_tipo_usuario and pais.id_pais=provincias.id_pais and provincias.id_provincia=ciudad.id_provincia and usuario.id_ciudad=ciudad.id_ciudad and categorias.id_categoria=usuario.id_categoria and departamento.id_departamento=usuario.id_departamento and $campo not like '%$_GET[searchString]%' ORDER BY $sidx $sord offset $start limit $limit";	
        }
        if($_GET['searchOper']=='in'){ 
        	$SQL = "select id_usuario,cod_usuario,nombres_usuario,telefono_usuario,celular_usuario,direccion_usuario,email_usuario,id_tipo_user,nombre_tipo,nick_usuario,pais.id_pais,nombre_pais,provincias.id_provincia,provincias.nombre_provincia,ciudad.id_ciudad,ciudad.nombre_ciudad,institucion,categorias.id_categoria,categorias.nombre_categoria,departamento.id_departamento,departamento.nombre_departamento,tipo_sangre,fecha_nacimiento,sexo,estado_civil from usuario, tipo_usuario,pais,provincias,ciudad,categorias,departamento where usuario.id_tipo_user=tipo_usuario.id_tipo_usuario and pais.id_pais=provincias.id_pais and provincias.id_provincia=ciudad.id_provincia and usuario.id_ciudad=ciudad.id_ciudad and categorias.id_categoria=usuario.id_categoria and departamento.id_departamento=usuario.id_departamento and $campo like '%$_GET[searchString]%' ORDER BY $sidx $sord offset $start limit $limit";	
        }
        if($_GET['searchOper']=='ni'){
        	$SQL = "select id_usuario,cod_usuario,nombres_usuario,telefono_usuario,celular_usuario,direccion_usuario,email_usuario,id_tipo_user,nombre_tipo,nick_usuario,pais.id_pais,nombre_pais,provincias.id_provincia,provincias.nombre_provincia,ciudad.id_ciudad,ciudad.nombre_ciudad,institucion,categorias.id_categoria,categorias.nombre_categoria,departamento.id_departamento,departamento.nombre_departamento,tipo_sangre,fecha_nacimiento,sexo,estado_civil from usuario, tipo_usuario,pais,provincias,ciudad,categorias,departamento where usuario.id_tipo_user=tipo_usuario.id_tipo_usuario and pais.id_pais=provincias.id_pais and provincias.id_provincia=ciudad.id_provincia and usuario.id_ciudad=ciudad.id_ciudad and categorias.id_categoria=usuario.id_categoria and departamento.id_departamento=usuario.id_departamento and $campo not like '$$_GET[searchString]%' ORDER BY $sidx $sord offset $start limit $limit";	
        }
        //echo $SQL;
    }	
	$result = pg_query($SQL);			
	header("Content-type: text/xml;charset=utf-8");
	$s = "<?xml version='1.0' encoding='utf-8'?>";	
	$s .= "<rows>";
	$s .= "<page>" . $page . "</page>";
	$s .= "<total>" . $total_pages . "</total>";
	$s .= "<records>" . $count . "</records>";
	while ($row = pg_fetch_row($result)) {				
		$s .= "<row id='" . $row[0] . "'>";	
		$s .= "<cell>" . $row[0]. "</cell>";						
		$s .= "<cell>" . $row[1] . "</cell>";				
		$s .= "<cell>" . $row[2] . "</cell>";				
		$s .= "<cell>" . $row[3] . "</cell>";				
		$s .= "<cell>" . $row[4] . "</cell>";				
		$s .= "<cell>" . $row[5] . "</cell>";				
		$s .= "<cell>" . $row[6] . "</cell>";				
		$s .= "<cell>" . $row[7] . "</cell>";				
		$s .= "<cell>" . $row[8] . "</cell>";				
		$s .= "<cell>" . $row[9] . "</cell>";				
		$s .= "<cell>" . $row[10] . "</cell>";				
		$s .= "<cell>" . $row[11] . "</cell>";				
		$s .= "<cell>" . $row[12] . "</cell>";				
		$s .= "<cell>" . $row[13] . "</cell>";	
		$s .= "<cell>" . $row[14] . "</cell>";	
		$s .= "<cell>" . $row[15] . "</cell>";		
		$SQL1 =pg_query("select clave from clave where usuario='$row[0]'");	
		while ($row1 = pg_fetch_row($SQL1)) {				
			$s .= "<cell>" . $row1[0] . "</cell>";	
		}		
		$s .= "<cell>" . $row[16] . "</cell>";			
		$s .= "<cell>" . $row[17] . "</cell>";	
		$s .= "<cell>" . $row[18] . "</cell>";	
		$s .= "<cell>" . $row[19] . "</cell>";			
		$s .= "<cell>" . $row[20] . "</cell>";	
        $s .= "<cell>" . $row[21] . "</cell>";  
        $s .= "<cell>" . $row[22] . "</cell>";  
        $s .= "<cell>" . $row[23] . "</cell>";  
        $s .= "<cell>" . $row[24] . "</cell>";  

		$s .= "</row>";
	}
	$s .= "</rows>";
	echo $s;
	?>
