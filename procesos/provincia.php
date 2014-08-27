<?php
    include 'base.php';
    session_start();
    conectarse();   
    $data=0; 
    $nombre=ucwords(strtolower($_POST["provincia"]));      
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
    $consulta=pg_query("select id_provincia from provincias order by id_provincia asc");////consulta para el id
    while ($row = pg_fetch_row($consulta)) {
    	$cont=$row[0];
    }
    $cont=$cont+1;
    if($_POST['tipo']=='g'){
    	$consulta=pg_query("select id_provincia from provincias,pais where provincias.id_pais=pais.id_pais and provincias.nombre_provincia='$nombre' and provincias.id_pais='$_POST[id_p]'");////consulta para comparar
    	while ($row = pg_fetch_row($consulta)) {
    		$repe=2;
    		$data=2;
    	}    	
    	if($repe==0){
    		pg_query("insert into provincias values('$cont','$nombre','$_POST[id_p]')");
    		////auditoria//            
            $nuevo=$cont.",".$nombre.",".$_POST['nc'];            
            pg_query("insert into auditoria_sistema values ('$id_audi','$_SESSION[usuario] $_SESSION[id]','$fecha','ciudad','Insert','','$nuevo','Ingreso de una provincia nueva')");        
            //////////////  
            $data=1;
    	}
    }
    if($_POST['tipo']=='m'){    
        $consulta=pg_query("select id_provincia from provincias,pais where provincias.id_pais=pais.id_pais and provincias.nombre_provincia='$nombre' and provincias.id_pais='$_POST[id_p]' and provincias.id_provincia not in('$_POST[id]')");
        while ($row = pg_fetch_row($consulta)) {
            $repe=2;
            $data=2;
        }        
        if($repe==0){	
            ////auditoria//
            $sql_audi=pg_query("select pais.id_pais,nombre_pais,nombre_provincia from pais, provincias where pais.id_pais=provincias.id_pais and id_provincia='$_POST[id]'");
              while ($row_audi=pg_fetch_row($sql_audi)) {
                $anterior=$_POST['id'].",".$row_audi[2].",".$row_audi[1];                
            }    
            $nuevo=$_POST['id'].",".$nombre.",".$_POST['nc'];
            pg_query("insert into auditoria_sistema values ('$id_audi','$_SESSION[usuario] $_SESSION[id]','$fecha','provincia','Update','$anterior','$nuevo','Modificación de una provincia por el usuario')");        
            //////////////  
    	   pg_query("update provincias set nombre_provincia='$nombre', id_pais='$_POST[id_p]' where id_provincia='$_POST[id]'");    	
    	   $data=1;
        }
    }
    echo $data;
?>
