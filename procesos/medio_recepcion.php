<?php
    include 'base.php';
    session_start();
    conectarse();   
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
    $consulta=pg_query("select id_medio from medio_recepcion order by id_medio asc");////consulta para el id
    while ($row = pg_fetch_row($consulta)) {
    	$cont=$row[0];
    }
    $cont=$cont+1;
    if($_POST['tipo']=='g'){
    	$consulta=pg_query("select id_medio from medio_recepcion where codigo_medio='$codigo'");////consulta para comparar
    	while ($row = pg_fetch_row($consulta)) {
    		$repe=2;
    		$data=2;
    	}
    	$consulta=pg_query("select id_medio from medio_recepcion where nombre_medio='$nombre'");////consulta para comparar
    	while ($row = pg_fetch_row($consulta)) {
    		$repe=3;
    		$data=3;
    	}
    	if($repe==0){
    		pg_query("insert into medio_recepcion values('$cont','$codigo','$nombre','Activo')");
    		////auditoria//            
            $nuevo=$cont.",".$codigo.",".$nombre.","."Activo";            
            pg_query("insert into auditoria_sistema values ('$id_audi','$_SESSION[usuario] $_SESSION[id]','$fecha','medio_recepcion','Insert','','$nuevo','Ingreso de un nuevo medio de recepcion ingresado por el usuario')");        
            //////////////  
            $data=1;
    	}
    }
    if($_POST['tipo']=='m'){    
        $consulta=pg_query("select id_medio from medio_recepcion where codigo_medio='$codigo' and id_medio not in('$_POST[id]');");
        while ($row = pg_fetch_row($consulta)) {
            $repe=2;
            $data=2;
        }
        $consulta=pg_query("select id_medio from medio_recepcion where nombre_medio='$nombre' and id_medio not in('$_POST[id]');");
        while ($row = pg_fetch_row($consulta)) {
            $repe=3;
            $data=3;
        }
        if($repe==0){   	
            ////auditoria//
            $sql_audi=pg_query("select * from medio_recepcion where id_medio='$_POST[id]'");
            while ($row_audi=pg_fetch_row($sql_audi)) {
                $anterior=$row_audi[0].",".$row_audi[1].",".$row_audi[2].",".$row_audi[3];                
            }    
            $nuevo=$_POST['id'].",".$codigo.",".$nombre.",".'Activo';     
            pg_query("insert into auditoria_sistema values ('$id_audi','$_SESSION[usuario] $_SESSION[id]','$fecha','medio_recepcion','Update','$anterior','$nuevo','Modificacion de un medio de repecion por el usuario')");        
            //////////////   
    	   pg_query("update medio_recepcion set codigo_medio='$codigo',nombre_medio='$nombre' where id_medio='$_POST[id]'");    	
    	   $data=1;
        }
    }
    echo $data;
?>
