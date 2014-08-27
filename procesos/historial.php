<?php
include 'base.php';
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
$result = pg_query("SELECT COUNT(*) AS count from bitacora where id_archivo='$_GET[id]'"); 
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
	$SQL = " select archivo.id_archivo,bitacora.id_bitacora,codigo_archivo,nombre_archivo,usuario.id_usuario,usuario.nombres_usuario,fecha_cambio,asunto_cambio,observaciones,departamento.id_departamento,nombre_departamento,peso,referencia,archivo.estado from archivo,bitacora,usuario,departamento where archivo.id_archivo='$_GET[id]' and bitacora.id_usuario=usuario.id_usuario and departamento.id_departamento=bitacora.id_departamento and archivo.id_archivo=bitacora.id_archivo ORDER BY $sidx $sord offset $start limit $limit";	
	$result = pg_query($SQL);				
	header("Content-type: text/xml;charset=utf-8");
	$s = "<?xml version='1.0' encoding='utf-8'?>";	
	$s .= "<rows>";
	$s .= "<page>" . $page . "</page>";
	$s .= "<total>" . $total_pages . "</total>";
	$s .= "<records>" . $count . "</records>";
	while ($row = pg_fetch_row($result)) {		
		$s .= "<row id='" . $row[1] . "'>";	
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
		$s .= "<cell>" . $row[11] ." bytes". "</cell>";
		$s .= "<cell>" . $row[12] . "</cell>";
		if($row[13]==0){
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

