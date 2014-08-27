
<?php
	session_start();	    
    include 'base.php';
    conectarse();       
    $data=0;	
    /////////id de la auditoria////////////
    date_default_timezone_set('UTC');
    $fecha=date("Y-m-d");
    $id_audi=0;
    $sql_audi=pg_query("select id_sistema from auditoria_sistema order by id_sistema ASC");
    while($row_audi=pg_fetch_row($sql_audi)){
        $id_audi=$row_audi[0];
    }
    $id_audi=$id_audi+1;
    ///////////////////////////////////////
    $id=$_POST['id_archivo'];
    if($_POST['estado']=='Finalizado'){
        ////auditoria//
        $sql_audi=pg_query("select id_archivo,nombre_archivo,codigo_archivo,nombre_doc,nombres_usuario,archivo.estado  from archivo,tipo_documento,usuario where archivo.id_tipo_doc=tipo_documento.id_tipo_documento and archivo.id_creador=usuario.id_usuario and archivo.id_archivo='$id';");
        while ($row_audi=pg_fetch_row($sql_audi)) {
            $anterior=$row_audi[0].",".$row_audi[1].",".$row_audi[2].",".$row_audi[3].",".$row_audi[4].",".$row_audi[5];                
            $nuevo=$row_audi[0].",".$row_audi[1].",".$row_audi[2].",".$row_audi[3].",".$row_audi[4].",".'0';                
        }            
        pg_query("insert into auditoria_sistema values ('$id_audi','$_SESSION[usuario] $_SESSION[id]','$fecha','archivo','Update','$anterior','$nuevo','Cambio de estado de los documentos por el usuario')");        
        ////////////// 
        
        pg_query("update archivo set estado='0' where id_archivo='$id'");
        $data=1;
    }
    else{
        ////auditoria//
        $sql_audi=pg_query("select id_archivo,nombre_archivo,codigo_archivo,nombre_doc,nombres_usuario,archivo.estado  from archivo,tipo_documento,usuario where archivo.id_tipo_doc=tipo_documento.id_tipo_documento and archivo.id_creador=usuario.id_usuario and archivo.id_archivo='$id';");
        while ($row_audi=pg_fetch_row($sql_audi)) {
            $anterior=$row_audi[0].",".$row_audi[1].",".$row_audi[2].",".$row_audi[3].",".$row_audi[4].",".$row_audi[5];                
            $nuevo=$row_audi[0].",".$row_audi[1].",".$row_audi[2].",".$row_audi[3].",".$row_audi[4].",".'1';                
        }            
        pg_query("insert into auditoria_sistema values ('$id_audi','$_SESSION[usuario] $_SESSION[id]','$fecha','archivo','Update','$anterior','$nuevo','Cambio de estado de los documentos por el usuario')");        
        ////////////// 
        pg_query("update archivo set estado='1' where id_archivo='$id'");
        $data=1;    
    }    


    echo $data;    
?>
