<?php
include '../procesos/base.php';
conectarse();
$page = $_GET['page']; 
$limit = $_GET['rows']; 
$sidx = $_GET['sidx']; 
$sord = $_GET['sord']; 
$search=$_GET['_search'];
session_start();	
//$consulta=pg_query("select * from archivo,bitacora,departamento where bitacora.id_usuario='$_SESSION[id]' and bitacora.id_departamento=departamento.id_departamento and archivo.id_archivo=bitacora.id_archivo and bitacora.estado='1'");		
if (!$sidx)
    $sidx = 1;
$result = pg_query("SELECT COUNT(*) AS count from archivo"); 
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
        $SQL = "select id_archivo,codigo_archivo,nombre_archivo,estado from archivo ORDER BY $sidx $sord offset $start limit $limit";	
	}
    else{        
        if($_GET['searchOper']=='eq'){
        	$SQL = "select id_archivo,codigo_archivo,nombre_archivo,estado from archivo where $_GET[searchField] = '$_GET[searchString]' ORDER BY $sidx $sord offset $start limit $limit";	
        }
        if($_GET['searchOper']=='ne'){  
        	$SQL = "select id_archivo,codigo_archivo,nombre_archivo,estado from archivo where $_GET[searchField] != '$_GET[searchString]' ORDER BY $sidx $sord offset $start limit $limit";	
        }
        if($_GET['searchOper']=='bw'){
        	$SQL = "select id_archivo,codigo_archivo,nombre_archivo,estado from archivo where $_GET[searchField] like '$_GET[searchString]%'  ORDER BY $sidx $sord offset $start limit $limit";	
        }
        if($_GET['searchOper']=='bn'){ 
        	$SQL = "select id_archivo,codigo_archivo,nombre_archivo,estado from archivo where $_GET[searchField] not like '$_GET[searchString]%' ORDER BY $sidx $sord offset $start limit $limit";	
        }
        if($_GET['searchOper']=='ew'){  
        	$SQL = "select id_archivo,codigo_archivo,nombre_archivo,estado from archivo where $_GET[searchField] like '%$_GET[searchString]' ORDER BY $sidx $sord offset $start limit $limit";	
        }
        if($_GET['searchOper']=='en'){
        	$SQL = "select id_archivo,codigo_archivo,nombre_archivo,estado from archivo where $_GET[searchField] not like '%$_GET[searchString]' ORDER BY $sidx $sord offset $start limit $limit";	
        }
        if($_GET['searchOper']=='cn'){  
        	$SQL = "select id_archivo,codigo_archivo,nombre_archivo,estado from archivo where $_GET[searchField] like '%$_GET[searchString]%' ORDER BY $sidx $sord offset $start limit $limit";	
        }
        if($_GET['searchOper']=='nc'){           
        	$SQL = "select id_archivo,codigo_archivo,nombre_archivo,estado from archivo where $_GET[searchField] not like '%$_GET[searchString]%' ORDER BY $sidx $sord offset $start limit $limit";	
        }
        if($_GET['searchOper']=='in'){ 
        	$SQL = "select id_archivo,codigo_archivo,nombre_archivo,estado from archivo where $_GET[searchField] like '%$_GET[searchString]%' ORDER BY $sidx $sord offset $start limit $limit";	
        }
        if($_GET['searchOper']=='ni'){
        	$SQL = "select id_archivo,codigo_archivo,nombre_archivo,estado from archivo where $_GET[searchField] not like '%$_GET[searchString]%' ORDER BY $sidx $sord offset $start limit $limit";	
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

		$consulta2=pg_query("select departamento.id_departamento,nombre_departamento,fecha_cambio,asunto_cambio,observaciones,peso,id_usuario from bitacora,departamento where id_archivo='".$row[0]."' and bitacora.id_departamento=departamento.id_departamento order by id_bitacora desc limit 1;");					
		while($row2=pg_fetch_row($consulta2)){	
			$s .= "<cell>" . $row2[0]. "</cell>";																													
			$s .= "<cell>" . $row2[1]. "</cell>";																													
			$s .= "<cell>" . $row2[2]. "</cell>";																													
			$s .= "<cell>" . $row2[3]. "</cell>";																													
			$s .= "<cell>" . $row2[4]. "</cell>";	
			$s .= "<cell>" . $row2[5]." bytes". "</cell>";	
			$consulta3=pg_query("select id_usuario,nombres_usuario from usuario where id_usuario='".$row2[6]."'");					
			while($row3=pg_fetch_row($consulta3)){	
				$s .= "<cell>" . $row3[0]. "</cell>";																												
				$s .= "<cell>" . $row3[1]. "</cell>";																												
			}	

		}
		if($row[3]==0){
			$s .= "<cell>" . "En revisión" . "</cell>";							
		}
		else{
			$s .= "<cell>" . "Finalizado" . "</cell>";							
		}		
		$s .= "</row>";
	}
	$s .= "</rows>";
	echo $s;
	?>
