<?php
include 'base.php';
conectarse();
$data="";
$cont=0;
if(isset($_GET['idp'])){
	$consulta = pg_query("select id_provincia,nombre_provincia from provincias where id_pais='$_GET[id]'");   
	while ($row = pg_fetch_row($consulta)) {
		if($row[0]==$_GET['idp']){
			echo "<option value='$row[0]' selected>$row[1]</option>";
		}
		else{
			echo "<option value='$row[0]'>$row[1]</option>";	
		}
	}
}
else{
	$consulta = pg_query("select id_provincia,nombre_provincia from provincias where id_pais='$_GET[id]'");   
	while ($row = pg_fetch_row($consulta)) {
		echo "<option value='$row[0]'>$row[1]</option>";
	}
}
?>



	