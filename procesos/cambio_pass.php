<?php    
    include 'base.php'; 
    session_start();
    conectarse();   
    $cont=0;    
    $data=0;
    $codigo="";
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
    $consulta=pg_query("select id_clave,clave from clave where usuario='$_SESSION[id]'");   
    while($row=pg_fetch_row($consulta)){
        if($_POST['pass']==$row[1])
        {
            ////auditoria//
            $sql_audi=pg_query("select id_clave,clave,nombres_usuario,id_usuario from clave,usuario where usuario.id_usuario=clave.usuario and usuario='$_SESSION[id]'");
              while ($row_audi=pg_fetch_row($sql_audi)) {
                $anterior=$row_audi[0].",".$row_audi[1].",".$row_audi[2];
                $nuevo=$row_audi[0].",".$_POST['pass1'].",".$row_audi[2];
            }    
            pg_query("insert into auditoria_sistema values ('$id_audi','$_SESSION[usuario] $_SESSION[id]','$fecha','clave','Update','$anterior','$nuevo','Cambio de la clave por el usuario de la actual')");        
            //////////////
            pg_query("update clave set clave='$_POST[pass1]' where id_clave='$row[0]'");
            $data=0;
        }
        else{
            $data=1;   
        }
    }
   
    echo $data;
   
?>