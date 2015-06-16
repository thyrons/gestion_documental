<?php
function conectarse() {
    if (!($conexion = pg_connect("host=localhost dbname=gestion_documental port=5432 user=postgres password=rootdow"))) {			
        exit();
    } else {       
    }
    return $conexion;
}
conectarse();
?>
