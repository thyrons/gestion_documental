<?php
    include 'base.php';
    conectarse();   
    session_start();
    $data=0;
    $codigo=strtoupper($_POST["codigo"]);
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
    $consulta=pg_query("select id_tipo_documento from tipo_documento order by id_tipo_documento asc");////consulta para el id
    while ($row = pg_fetch_row($consulta)) {
    	$cont=$row[0];
    }
    $cont=$cont+1;
    if($_POST['tipo']=='g'){
    	$consulta=pg_query("select id_tipo_documento from tipo_documento where codigo_doc='$codigo'");////consulta para comparar
    	while ($row = pg_fetch_row($consulta)) {
    		$repe=2;
    		$data=2;
    	}
    	$consulta=pg_query("select id_tipo_documento from tipo_documento where nombre_doc='$nombre'");////consulta para comparar
    	while ($row = pg_fetch_row($consulta)) {
    		$repe=3;
    		$data=3;
    	}
    	if($repe==0){
    		pg_query("insert into tipo_documento values('$cont','$codigo','$nombre','Activo')");
    		////auditoria//            
            $nuevo=$cont.",".$codigo.",".$nombre.",".'Activo';
            pg_query("insert into auditoria_sistema values ('$id_audi','$_SESSION[usuario] $_SESSION[id]','$fecha','tipo_documento','Insert','','$nuevo','Nuevo tipo de documento')");        
            //////////////  
            $data=1;
    	}
    }
    if($_POST['tipo']=='m'){  
        $consulta=pg_query("select id_tipo_documento from tipo_documento codigo_doc where codigo_doc='$codigo' and id_tipo_documento not in('$_POST[id]');");
        while ($row = pg_fetch_row($consulta)) {
            $repe=2;
            $data=2;
        }
        $consulta=pg_query("select id_tipo_documento from tipo_documento codigo_doc where nombre_doc='$nombre' and id_tipo_documento not in('$_POST[id]');");
        while ($row = pg_fetch_row($consulta)) {
            $repe=3;
            $data=3;
        }
        if($repe==0){         	
            ////auditoria//
            $sql_audi=pg_query("select * from tipo_documento where id_tipo_documento='$_POST[id]'");
            while ($row_audi=pg_fetch_row($sql_audi)) {
                $anterior=$row_audi[0].",".$row_audi[1].",".$row_audi[2].",".$row_audi[3];                
            }    
            $nuevo=$_POST['id'].",".$codigo.",".$nombre.",".'Activo';
            pg_query("insert into auditoria_sistema values ('$id_audi','$_SESSION[usuario] $_SESSION[id]','$fecha','tipo_documento','Update','$anterior','$nuevo','Modificacion de un tipo de documento')");        
            //////////////  
            pg_query("update tipo_documento set codigo_doc='$codigo',nombre_doc='$nombre' where id_tipo_documento='$_POST[id]'");    	
    	    $data=1;
        }
    }
    echo $data;
?>
