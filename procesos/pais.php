<?php
    include 'base.php';
    session_start();
    conectarse();   
    $data=0; 
    $nombre=ucwords(strtolower($_POST["pais"]));      
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
    $consulta=pg_query("select id_pais from pais order by id_pais asc");////consulta para el id
    while ($row = pg_fetch_row($consulta)) {
    	$cont=$row[0];
    }
    $cont=$cont+1;
    if($_POST['tipo']=='g'){
    	$consulta=pg_query("select id_pais from pais where nombre_pais='$nombre'");////consulta para comparar
    	while ($row = pg_fetch_row($consulta)) {
    		$repe=2;
    		$data=2;
    	}    	
    	if($repe==0){
    		pg_query("insert into pais values('$cont','$nombre')");
    		////auditoria////////
            $nuevo=$cont.','.$nombre;
            pg_query("insert into auditoria_sistema values ('$id_audi','$_SESSION[usuario] $_SESSION[id]','$fecha','pais','Insert','','$nuevo','Ingreso de paises')");        
            /////////////////
            $data=1;
    	}
    }
    if($_POST['tipo']=='m'){    
        $consulta=pg_query("select id_pais from pais where nombre_pais='$nombre' and id_pais not in('$_POST[id]');");
        while ($row = pg_fetch_row($consulta)) {
            $repe=2;
            $data=2;
        }        
        if($repe==0){	
            ////auditoria////////            
            $sql_audi=pg_query("select id_pais,nombre_pais from pais where id_pais='$_POST[id]';");
              while ($row_audi=pg_fetch_row($sql_audi)) {
                $anterior=$row_audi[0].','.$row_audi[1];
            }  
            $nuevo=$_POST['id'].','.$nombre;
            pg_query("insert into auditoria_sistema values ('$id_audi','$_SESSION[usuario] $_SESSION[id]','$fecha','pais','Update','$anterior','$nuevo','Modificación de la tabla país')");        
            /////////////////
    	    pg_query("update pais set nombre_pais='$nombre' where id_pais='$_POST[id]'");    	
    	    $data=1;
        }
    }
    echo $data;
?>
