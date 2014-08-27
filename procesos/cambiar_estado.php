
<?php
	session_start();	
    include 'base.php';
    conectarse();       
    $data=0;	
    $id=0;
    date_default_timezone_set('UTC');
    $fecha=date("Y-m-d");
    /////////id de la auditoria////////////
    $id_audi=0;
    $sql_audi=pg_query("select id_sistema from auditoria_sistema order by id_sistema ASC");
    while($row_audi=pg_fetch_row($sql_audi)){
        $id_audi=$row_audi[0];
    }
    $id_audi=$id_audi+1;
    ///////////////////////////////////////
    $consulta=pg_query("select id_recibido from recibidos where id_usuarios='$_POST[usuario]' and id_archivo='$_POST[archivo]'");
    while($row=pg_fetch_row($consulta)){
		$id=$row[0];
		$data=1;
    }
    ////auditoria//
    $sql_audi=pg_query("select id_recibido,nombre_archivo,nombres_usuario,recibidos.estado,leido from recibidos,archivo,usuario where recibidos.id_archivo=archivo.id_archivo and recibidos.id_usuarios=usuario.id_usuario and recibidos.id_usuarios='$_POST[usuario]' and archivo.id_archivo='$_POST[archivo]';");
    while ($row_audi=pg_fetch_row($sql_audi)) {
        $anterior=$row_audi[0].",".$row_audi[1].",".$row_audi[2].",".$row_audi[3].",".$row_audi[4];
        $nuevo=$row_audi[0].",".$row_audi[1].",".$row_audi[2].",".$row_audi[3].","."0";
    }  
    pg_query("insert into auditoria_sistema values ('$id_audi','$_SESSION[usuario] $_SESSION[id] ','$fecha','recibidos','Update','$anterior','$nuevo','El documento enviado ha sido chequeado por el o los destinatarios')");  
    //////////////        
    pg_query("update recibidos set leido='0' where id_recibido='$id'");

    echo $data;    
?>
