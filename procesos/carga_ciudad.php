<?php
include 'base.php';
conectarse();
$data="";
$cont=0;
if(isset($_GET['idc'])){
	$consulta = pg_query("select id_ciudad,nombre_ciudad from ciudad where id_provincia='$_GET[id]'");   
	while ($row = pg_fetch_row($consulta)) {
		if($row[0]==$_GET['idc']){
			echo "<option value='$row[0]' selected>$row[1]</option>";
		}
		else{
			echo "<option value='$row[0]'>$row[1]</option>";	
		}
	}
}
else{
	$consulta = pg_query("select id_ciudad,nombre_ciudad from ciudad where id_provincia='$_GET[id]'");   
	while ($row = pg_fetch_row($consulta)) {
		echo "<option value='$row[0]'>$row[1]</option>";
	}
}
?>


