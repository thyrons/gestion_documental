<?php
    include 'base.php';
    session_start();
    conectarse();   
    $data=0;    
    $nombre=strtoupper($_POST["nombre"]);
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
    $consulta=pg_query("select id_tipo_usuario from tipo_usuario order by id_tipo_usuario asc");////consulta para el id
    while ($row = pg_fetch_row($consulta)) {
    	$cont=$row[0];
    }
    $cont=$cont+1;
    if($_POST['tipo']=='g'){    	
    	$consulta=pg_query("select id_tipo_usuario from tipo_usuario where nombre_tipo='$nombre'");////consulta para comparar
    	while ($row = pg_fetch_row($consulta)) {
    		$repe=2;
    		$data=2;
    	}
    	if($repe==0){
    		pg_query("insert into tipo_usuario values('$cont','$nombre')");
    		////auditoria//            
            $nuevo=$cont.",".$nombre;
            pg_query("insert into auditoria_sistema values ('$id_audi','$_SESSION[usuario] $_SESSION[id]','$fecha','tipo_usuario','Insert','','$nuevo','Nuevo tipo de usuario')");        
            //////////////  
            $data=1;
    	}
    }
    if($_POST['tipo']=='m'){          
        $consulta=pg_query("select id_tipo_usuario from tipo_usuario codigo_doc where nombre_tipo='$nombre' and id_tipo_usuario not in('$_POST[id]');");
        while ($row = pg_fetch_row($consulta)) {
            $repe=2;
            $data=2;
        }
        if($repe==0){         	
        	////auditoria//
            $sql_audi=pg_query("select * from tipo_usuario where id_tipo_usuario='$_POST[id]'");
            while ($row_audi=pg_fetch_row($sql_audi)) {
                $anterior=$row_audi[0].",".$row_audi[1];                
            }    
            $nuevo=$_POST['id'].",".$nombre;
            pg_query("insert into auditoria_sistema values ('$id_audi','$_SESSION[usuario] $_SESSION[id]','$fecha','tipo_usuario','Update','$anterior','$nuevo','Modificacion de un tipo de usuario')");        
            //////////////  
            pg_query("update tipo_usuario set nombre_tipo='$nombre' where id_tipo_usuario='$_POST[id]'");    	
    	    
            $data=1;
        }
    }
    echo $data;
?>
