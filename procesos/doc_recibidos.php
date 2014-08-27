<?php
	include 'base.php';
	conectarse();
	$page = $_GET['page']; 
	$limit = $_GET['rows']; 
	$sidx = $_GET['sidx']; 
	$sord = $_GET['sord']; 
	$search=$_GET['_search'];
	$cont=0;
	session_start();
    if (!$sidx)
    $sidx = 1;

	$consulta=pg_query("select id_archivo from archivo order by id_archivo asc");
	while($row=pg_fetch_row($consulta)){
		$consulta1=pg_query("select id_archivo from recibidos where id_archivo='".$row[0]."' and id_usuarios='$_SESSION[id]'");	
		//$consulta1=pg_query("select* from recibidos,usuario where id_archivo='".$row[0]."' and recibidos.id_usuarios=usuario.id_usuario and recibidos.leido='1'");	
		while($row1=pg_fetch_row($consulta1)){	
			$cont++;
		}
	}	    		
	if ($cont > 0 && $limit > 0) {
	    $total_pages = ceil($cont / $limit);
	} else {
	    $total_pages = 0;
	}
	if ($page > $total_pages)
	    $page = $total_pages;
	$start = $limit * $page - $limit;
	if ($start < 0)
	    $start = 0;		
	
	header("Content-type: text/xml;charset=utf-8");
		$s = "<?xml version='1.0' encoding='utf-8'?>";	
		$s .= "<rows>";
		$s .= "<page>" . $page . "</page>";
		$s .= "<total>" . $total_pages . "</total>";
		$s .= "<records>" . $cont . "</records>";	
	if($search=='false'){
		$consulta=pg_query("select id_archivo,nombre_archivo,estado from archivo order by id_archivo asc");
	}
    else{        
        if($_GET['searchOper']=='eq'){
        	$consulta=pg_query("select id_archivo,nombre_archivo,estado from archivo where $_GET[searchField] = '$_GET[searchString]' order by id_archivo asc");
        }
        if($_GET['searchOper']=='ne'){  
        	$consulta=pg_query("select id_archivo,nombre_archivo,estado from archivo where $_GET[searchField] != '$_GET[searchString]' order by id_archivo asc");
        }
        if($_GET['searchOper']=='bw'){

        	$consulta=pg_query("select id_archivo,nombre_archivo,estado from archivo where $_GET[searchField] like '$_GET[searchString]%' order by id_archivo asc");
        }
        if($_GET['searchOper']=='bn'){ 
        	$consulta=pg_query("select id_archivo,nombre_archivo,estado from archivo where $_GET[searchField] not like '$_GET[searchString]%' order by id_archivo asc");
        }
        if($_GET['searchOper']=='ew'){  
        	$consulta=pg_query("select id_archivo,nombre_archivo,estado from archivo where $_GET[searchField] like '%$_GET[searchString]' order by id_archivo asc");
        }
        if($_GET['searchOper']=='en'){
        	$consulta=pg_query("select id_archivo,nombre_archivo,estado from archivo where $_GET[searchField] not like '%$_GET[searchString]' order by id_archivo asc");
        }
        if($_GET['searchOper']=='cn'){  
        	$consulta=pg_query("select id_archivo,nombre_archivo,estado from archivo where $_GET[searchField] like '%$_GET[searchString]%' order by id_archivo asc");
        }
        if($_GET['searchOper']=='nc'){           
        	$consulta=pg_query("select id_archivo,nombre_archivo,estado from archivo where $_GET[searchField] not like '%$_GET[searchString]%' order by id_archivo asc");
        }
        if($_GET['searchOper']=='in'){ 
        	$consulta=pg_query("select id_archivo,nombre_archivo,estado from archivo where $_GET[searchField] like '%$_GET[searchString]%' order by id_archivo asc");
        }
        if($_GET['searchOper']=='ni'){
        	$consulta=pg_query("select id_archivo,nombre_archivo,estado from archivo where $_GET[searchField] not like '%$_GET[searchString]%' order by id_archivo asc");
        }
        
    }		
		while($row=pg_fetch_row($consulta)){
			$consulta1=pg_query("select id_recibido,leido from recibidos where id_archivo='".$row[0]."' and id_usuarios='$_SESSION[id]'");							
			while($row1=pg_fetch_row($consulta1)){	
				$s .= "<row id='" . $row[0] . "'>";	
				$s .= "<cell>" . $row[0]. "</cell>";												
				$s .= "<cell>" . $row[1]. "</cell>";												
				$s .= "<cell>" . $row1[1]. "</cell>";	
				$consulta2=pg_query("select id_bitacora,fecha_cambio,asunto_cambio,observaciones,peso,departamento.id_departamento,nombre_departamento,id_usuario from bitacora,departamento where id_archivo='".$row[0]."' and bitacora.id_departamento=departamento.id_departamento order by id_bitacora desc limit 1;");					
				while($row2=pg_fetch_row($consulta2)){	
					$s .= "<cell>" . $row2[1]. "</cell>";												
					$s .= "<cell>" . $row2[2]. "</cell>";												
					$s .= "<cell>" . $row2[3]. "</cell>";												
					$s .= "<cell>" . $row2[4].' bytes'. "</cell>";												
					$s .= "<cell>" . $row2[5]."</cell>";												
					$s .= "<cell>" . $row2[6]. "</cell>";												
					$consulta3=pg_query("select id_usuario,nombres_usuario from usuario where id_usuario='".$row2[7]."'");					
					while($row3=pg_fetch_row($consulta3)){	
						$s .= "<cell>" . $row3[0]. "</cell>";																												
						$s .= "<cell>" . $row3[1]. "</cell>";																												
					}				
				}
				if($row[2]==0){
					$s .= "<cell>" . "En revisión" . "</cell>";							
				}
				else{
					$s .= "<cell>" . "Finalizado" . "</cell>";							
				}			
				$s .= "</row>";			
			}
		}	    			
		$s .= "</rows>";
		echo $s;
?>