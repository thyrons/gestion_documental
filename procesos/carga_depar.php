<?php
include 'base.php';
conectarse();
$data="";
$cont=0;
$consulta = pg_query("select id_departamento,nombre_departamento from departamento");   
while ($row = pg_fetch_row($consulta)) {
	echo "<option value='$row[0]'>$row[1]</option>";
}
?>



	