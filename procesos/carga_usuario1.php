<?php
include 'base.php';
conectarse();
$data="";
$cont=0;
$consulta = pg_query("select id_tipo_usuario,nombre_tipo from tipo_usuario where id_tipo_usuario not in ('1') order by nombre_tipo asc");   
while ($row = pg_fetch_row($consulta)) {
	echo "<option value='$row[0]'>$row[1]</option>";
}
?>


	