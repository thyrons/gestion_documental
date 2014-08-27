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
    $consulta=pg_query("select id_departamento from departamento order by id_departamento asc");////consulta para el id
    while ($row = pg_fetch_row($consulta)) {
    	$cont=$row[0];
    }
    $cont=$cont+1;
    if($_POST['tipo']=='g'){
    	$consulta=pg_query("select id_departamento from departamento where codigo_departamento='$codigo'");////consulta para comparar
    	while ($row = pg_fetch_row($consulta)) {
    		$repe=2;
    		$data=2;
    	}
    	$consulta=pg_query("select id_departamento from departamento where nombre_departamento='$nombre'");////consulta para comparar
    	while ($row = pg_fetch_row($consulta)) {
    		$repe=3;
    		$data=3;
    	}
    	if($repe==0){
    		pg_query("insert into departamento values('$cont','$codigo','$nombre','Activo')");
    		////auditoria////////
            $nuevo=$cont.','.$codigo.','.$nombre.','.'Activo';
            pg_query("insert into auditoria_sistema values ('$id_audi','$_SESSION[usuario] $_SESSION[id]','$fecha','departamento','Insert','','$nuevo','Ingreso de un nuevo departamento')");        
            /////////////////
            $data=1;
    	}
    }
    if($_POST['tipo']=='m'){  
        $consulta=pg_query("select id_departamento from departamento where codigo_departamento='$codigo' and id_departamento not in('$_POST[id]');");
        while ($row = pg_fetch_row($consulta)) {
            $repe=2;
            $data=2;
        }
        $consulta=pg_query("select id_departamento from departamento where nombre_departamento='$nombre' and id_departamento not in('$_POST[id]');");
        while ($row = pg_fetch_row($consulta)) {
            $repe=3;
            $data=3;
        }
        if($repe==0){            
            ////auditoria////////            
            $sql_audi=pg_query("select id_departamento,codigo_departamento,nombre_departamento,estado from departamento  where id_departamento='$_POST[id]';");
              while ($row_audi=pg_fetch_row($sql_audi)) {
                $anterior=$row_audi[0].','.$row_audi[1].','.$row_audi[2].','.$row_audi[3];
            }  
            $nuevo=$_POST['id'].','.$nombre.','.$codigo.','.'Activo';
            pg_query("insert into auditoria_sistema values ('$id_audi','$_SESSION[usuario] $_SESSION[id]','$fecha','departamento','Update','$anterior','$nuevo','Modificación del registro')");        
            /////////////////
            pg_query("update departamento set codigo_departamento='$codigo',nombre_departamento='$nombre' where id_departamento='$_POST[id]'");     
            $data=1;    
        }
    	
    }
    echo $data;
?>
