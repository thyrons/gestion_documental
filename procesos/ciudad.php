<?php
    include 'base.php';
    session_start();
    conectarse();   
    $data=0; 
    $nombre=ucwords(strtolower($_POST["ciudad"]));      
    $cont=0;
    $repe=0;
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
    $consulta=pg_query("select id_ciudad from ciudad order by id_ciudad asc");////consulta para el id
    while ($row = pg_fetch_row($consulta)) {
    	$cont=$row[0];
    }
    $cont=$cont+1;
    if($_POST['tipo']=='g'){
    	$consulta=pg_query("select id_ciudad from ciudad,provincias where ciudad.id_provincia=provincias.id_provincia and ciudad.nombre_ciudad='$nombre' and ciudad.id_provincia='$_POST[provincia]'");////consulta para comparar
    	while ($row = pg_fetch_row($consulta)) {
    		$repe=2;
    		$data=2;
    	}    	
    	if($repe==0){
    		pg_query("insert into ciudad values('$cont','$nombre','$_POST[provincia]')");
    		////auditoria//            
            $nuevo=$cont.",".$nombre.",".$_POST['nc'];            
            pg_query("insert into auditoria_sistema values ('$id_audi','$_SESSION[usuario] $_SESSION[id]','$fecha','ciudad','Insert','','$nuevo','Ingreso de una ciudad nueva')");        
            //////////////  
            $data=1;
    	}
    }
    if($_POST['tipo']=='m'){    
        $consulta=pg_query("select id_ciudad from ciudad,provincias where ciudad.id_provincia=provincias.id_provincia and ciudad.nombre_ciudad='$nombre' and ciudad.id_provincia='$_POST[provincia]' and ciudad.id_ciudad not in('$_POST[id_ciudad]')");
        while ($row = pg_fetch_row($consulta)) {
            $repe=2;
            $data=2;
        }        
        if($repe==0){
            ////auditoria//
            $sql_audi=pg_query("select id_ciudad,nombre_ciudad,nombre_provincia from ciudad,provincias where ciudad.id_provincia=provincias.id_provincia and ciudad.id_ciudad='$_POST[id_ciudad]'");
            while ($row_audi=pg_fetch_row($sql_audi)) {
                $anterior=$row_audi[0].",".$row_audi[1].",".$row_audi[2];                
            }    
            $nuevo=$_POST['id_ciudad'].",".$nombre.",".$_POST['nc'];
            pg_query("insert into auditoria_sistema values ('$id_audi','$_SESSION[usuario] $_SESSION[id]','$fecha','ciudad','Update','$anterior','$nuevo','Modificacion de una ciudad por el usuario')");        
            //////////////	
    	   pg_query("update ciudad set nombre_ciudad='$nombre', id_provincia='$_POST[provincia]' where id_ciudad='$_POST[id_ciudad]'");    	
    	   $data=1;
        }
    }
    echo $data;
?>
