<?php
include 'base.php';
conectarse();
$data="";
$cont=0;
$consulta = pg_query("select id_tipo_documento,nombre_doc from tipo_documento");   
while ($row = pg_fetch_row($consulta)) {
	echo "<option value='$row[0]'>$row[1]</option>";
}
?>



	