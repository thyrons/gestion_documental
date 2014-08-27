<?php    
    include 'base.php'; 
    conectarse();   
    session_start();
    $lista = array();
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
    $cont=0;    
    $contAcceso=0;
    $data=0;
    $codigo="";
    $temp="";
    $consulta=pg_query("select id_usuario from usuario order by id_usuario asc");
    while($row=pg_fetch_row($consulta)){
        $cont=$row[0];
    }    
    $cont=$cont+1;
    $consulta=pg_query("select id_acceso from accesos order by id_acceso asc");
    while($row=pg_fetch_row($consulta)){
        $contAcceso=$row[0];
    }    
    $contAcceso=$contAcceso+1;
    if($_POST["tipo"]=="g"){
        $codigo=$_POST['nombre_user']{0}."".$_POST['categoria_user']{0}."".$_POST['departamento_user']{0}."".$cont;
        pg_query("insert into usuario values('$cont','$codigo','$_POST[nombre_user]','$_POST[dir_user]','$_POST[ciudad_user]','$_POST[tel_user]','$_POST[cel_user]','$_POST[mail_user]','$_POST[tipo_user]','$_POST[user_name]','','$_POST[institucion]','$_POST[categoria_user]','$_POST[departamento_user]')");       
        ////auditoria//
        $sql_audi=pg_query("select id_usuario,cod_usuario,nombres_usuario,direccion_usuario,nombre_ciudad,telefono_usuario,celular_usuario,email_usuario,nombre_tipo,nick_usuario,fecha,institucion,nombre_categoria,nombre_departamento from usuario,ciudad,tipo_usuario,categorias,departamento where usuario.id_ciudad=ciudad.id_ciudad and usuario.id_tipo_user=tipo_usuario.id_tipo_usuario and categorias.id_categoria=usuario.id_categoria and usuario.id_departamento=departamento.id_departamento and usuario.id_usuario='$cont' order by id_usuario asc");
        while ($row_audi=pg_fetch_row($sql_audi)) {
            $nuevo=$row_audi[0].",".$row_audi[1].",".$row_audi[2].",".$row_audi[3].",".$row_audi[4].",".$row_audi[5].",".$row_audi[6].",".$row_audi[7].",".$row_audi[8].",".$row_audi[9].",".$row_audi[10].",".$row_audi[11].",".$row_audi[12].",".$row_audi[13];
            $temp=$row_audi[2];            
        }            
        pg_query("insert into auditoria_sistema values ('$id_audi','$_SESSION[usuario] $_SESSION[id]','$fecha','usuario','Insert','','$nuevo','Creacion de un nuevo usuario')");        
        $id_audi++;
        //////////////  
        pg_query("insert into clave values('$cont','$_POST[clave_user]','$cont')");
        ////auditoria//
        $sql_audi=pg_query("select id_clave,clave,nombres_usuario from clave,usuario where clave.usuario=usuario.id_usuario and clave.usuario='$cont'");
        while ($row_audi=pg_fetch_row($sql_audi)) {
            $nuevo=$row_audi[0].",".$row_audi[1].",".$row_audi[2];
        }            
        pg_query("insert into auditoria_sistema values ('$id_audi','$_SESSION[usuario] $_SESSION[id]','$fecha','clave','Insert','','$nuevo','Creacion de una nueva clave para el usuario')");        
        $id_audi++;
        //////////////  
        $consulta_accesos=pg_query("select nombre_aplicacion from aplicaciones order by id_aplicacion asc");
        while($row_accesos=pg_fetch_row($consulta_accesos)){
            $lista[]=$row_accesos[0];
        }
        /////////////
        if($_POST['tipo_user']=="1"){
            pg_query("insert into accesos values('$contAcceso','$cont','1','a')");
            $nuevo=$contAcceso.",".$temp.",".$lista[0].",".'a';
            pg_query("insert into auditoria_sistema values ('$id_audi','$_SESSION[usuario] $_SESSION[id]','$fecha','accesos','Insert','','$nuevo','Creacion de accesos para el nuevo usuario')");        
            $id_audi++;
            $contAcceso++;                        
            pg_query("insert into accesos values('$contAcceso','$cont','2','a')");
            $nuevo=$contAcceso.",".$temp.",".$lista[1].",".'a';
            pg_query("insert into auditoria_sistema values ('$id_audi','$_SESSION[usuario] $_SESSION[id]','$fecha','accesos','Insert','','$nuevo','Creacion de accesos para el nuevo usuario')");        
            $id_audi++;
            $contAcceso++;
            pg_query("insert into accesos values('$contAcceso','$cont','3','a')");
            $nuevo=$contAcceso.",".$temp.",".$lista[2].",".'a';
            pg_query("insert into auditoria_sistema values ('$id_audi','$_SESSION[usuario] $_SESSION[id]','$fecha','accesos','Insert','','$nuevo','Creacion de accesos para el nuevo usuario')");        
            $id_audi++;
            $contAcceso++;
            pg_query("insert into accesos values('$contAcceso','$cont','4','a')");
            $nuevo=$contAcceso.",".$temp.",".$lista[3].",".'a';
            pg_query("insert into auditoria_sistema values ('$id_audi','$_SESSION[usuario] $_SESSION[id]','$fecha','accesos','Insert','','$nuevo','Creacion de accesos para el nuevo usuario')");        
            $id_audi++;
            $contAcceso++;
            pg_query("insert into accesos values('$contAcceso','$cont','5','a')");
            $nuevo=$contAcceso.",".$temp.",".$lista[4].",".'a';
            pg_query("insert into auditoria_sistema values ('$id_audi','$_SESSION[usuario] $_SESSION[id]','$fecha','accesos','Insert','','$nuevo','Creacion de accesos para el nuevo usuario')");        
            $id_audi++;
            $contAcceso++;
            pg_query("insert into accesos values('$contAcceso','$cont','6','a')");           
            $nuevo=$contAcceso.",".$temp.",".$lista[5].",".'a';
            pg_query("insert into auditoria_sistema values ('$id_audi','$_SESSION[usuario] $_SESSION[id]','$fecha','accesos','Insert','','$nuevo','Creacion de accesos para el nuevo usuario')");        
            $id_audi++;
            $contAcceso++;
            pg_query("insert into accesos values('$contAcceso','$cont','7','a')");           
            $nuevo=$contAcceso.",".$temp.",".$lista[6].",".'a';
            pg_query("insert into auditoria_sistema values ('$id_audi','$_SESSION[usuario] $_SESSION[id]','$fecha','accesos','Insert','','$nuevo','Creacion de accesos para el nuevo usuario')");        
            $id_audi++;
            $contAcceso++;
            pg_query("insert into accesos values('$contAcceso','$cont','8','a')");           
            $nuevo=$contAcceso.",".$temp.",".$lista[7].",".'a';
            pg_query("insert into auditoria_sistema values ('$id_audi','$_SESSION[usuario] $_SESSION[id]','$fecha','accesos','Insert','','$nuevo','Creacion de accesos para el nuevo usuario')");        
            $id_audi++;
            $contAcceso++;
            pg_query("insert into accesos values('$contAcceso','$cont','9','a')");           
            $nuevo=$contAcceso.",".$temp.",".$lista[8].",".'a';
            pg_query("insert into auditoria_sistema values ('$id_audi','$_SESSION[usuario] $_SESSION[id]','$fecha','accesos','Insert','','$nuevo','Creacion de accesos para el nuevo usuario')");        
            $id_audi++;
        }
        else{         
            pg_query("insert into accesos values('$contAcceso','$cont','1','p')");
            $nuevo=$contAcceso.",".$temp.",".$lista[0].",".'p';
            pg_query("insert into auditoria_sistema values ('$id_audi','$_SESSION[usuario] $_SESSION[id]','$fecha','accesos','Insert','','$nuevo','Creacion de accesos para el nuevo usuario')");        
            $id_audi++;
            $contAcceso++;            
            pg_query("insert into accesos values('$contAcceso','$cont','2','p')");
            $nuevo=$contAcceso.",".$temp.",".$lista[1].",".'p';
            pg_query("insert into auditoria_sistema values ('$id_audi','$_SESSION[usuario] $_SESSION[id]','$fecha','accesos','Insert','','$nuevo','Creacion de accesos para el nuevo usuario')");        
            $id_audi++;
            $contAcceso++;
            pg_query("insert into accesos values('$contAcceso','$cont','3','p')");
            $nuevo=$contAcceso.",".$temp.",".$lista[2].",".'p';
            pg_query("insert into auditoria_sistema values ('$id_audi','$_SESSION[usuario] $_SESSION[id]','$fecha','accesos','Insert','','$nuevo','Creacion de accesos para el nuevo usuario')");        
            $id_audi++;
            $contAcceso++;   
            pg_query("insert into accesos values('$contAcceso','$cont','4','a')");
            $nuevo=$contAcceso.",".$temp.",".$lista[3].",".'a';
            pg_query("insert into auditoria_sistema values ('$id_audi','$_SESSION[usuario] $_SESSION[id]','$fecha','accesos','Insert','','$nuevo','Creacion de accesos para el nuevo usuario')");        
            $id_audi++;
            $contAcceso++;
            pg_query("insert into accesos values('$contAcceso','$cont','5','a')");          
            $nuevo=$contAcceso.",".$temp.",".$lista[4].",".'a';
            pg_query("insert into auditoria_sistema values ('$id_audi','$_SESSION[usuario] $_SESSION[id]','$fecha','accesos','Insert','','$nuevo','Creacion de accesos para el nuevo usuario')");        
            $id_audi++;
            $contAcceso++;
            pg_query("insert into accesos values('$contAcceso','$cont','6','a')");          
            $nuevo=$contAcceso.",".$temp.",".$lista[5].",".'a';
            pg_query("insert into auditoria_sistema values ('$id_audi','$_SESSION[usuario] $_SESSION[id]','$fecha','accesos','Insert','','$nuevo','Creacion de accesos para el nuevo usuario')");        
            $id_audi++;
            $contAcceso++;
            pg_query("insert into accesos values('$contAcceso','$cont','7','p')");          
            $nuevo=$contAcceso.",".$temp.",".$lista[6].",".'p';
            pg_query("insert into auditoria_sistema values ('$id_audi','$_SESSION[usuario] $_SESSION[id]','$fecha','accesos','Insert','','$nuevo','Creacion de accesos para el nuevo usuario')");        
            $id_audi++;
            $contAcceso++;
            pg_query("insert into accesos values('$contAcceso','$cont','8','p')");          
            $nuevo=$contAcceso.",".$temp.",".$lista[7].",".'p';
            pg_query("insert into auditoria_sistema values ('$id_audi','$_SESSION[usuario] $_SESSION[id]','$fecha','accesos','Insert','','$nuevo','Creacion de accesos para el nuevo usuario')");        
            $id_audi++;
            $contAcceso++;
            pg_query("insert into accesos values('$contAcceso','$cont','9','p')");          
            $nuevo=$contAcceso.",".$temp.",".$lista[8].",".'p';
            pg_query("insert into auditoria_sistema values ('$id_audi','$_SESSION[usuario] $_SESSION[id]','$fecha','accesos','Insert','','$nuevo','Creacion de accesos para el nuevo usuario')");        
            $id_audi++;
        }
        $data=1;
    }
    if($_POST["tipo"]=="m"){    
        ////auditoria//
        $sql_audi=pg_query("select id_usuario,cod_usuario,nombres_usuario,direccion_usuario,nombre_ciudad,telefono_usuario,celular_usuario,email_usuario,nombre_tipo,nick_usuario,fecha,institucion,nombre_categoria,nombre_departamento from usuario,ciudad,tipo_usuario,categorias,departamento where usuario.id_ciudad=ciudad.id_ciudad and usuario.id_tipo_user=tipo_usuario.id_tipo_usuario and categorias.id_categoria=usuario.id_categoria and usuario.id_departamento=departamento.id_departamento and usuario.id_usuario='$_POST[id_user]' order by id_usuario asc");
        while ($row_audi=pg_fetch_row($sql_audi)) {
            $anterior=$row_audi[0].",".$row_audi[1].",".$row_audi[2].",".$row_audi[3].",".$row_audi[4].",".$row_audi[5].",".$row_audi[6].",".$row_audi[7].",".$row_audi[8].",".$row_audi[9].",".$row_audi[10].",".$row_audi[11].",".$row_audi[12].",".$row_audi[13];               
        }            
        //////////////  
        pg_query("update usuario set id_usuario='$_POST[id_user]',cod_usuario='$_POST[cod_user]',nombres_usuario='$_POST[nombre_user]',direccion_usuario='$_POST[dir_user]',id_ciudad='$_POST[ciudad_user]',telefono_usuario='$_POST[tel_user]',celular_usuario='$_POST[cel_user]',email_usuario='$_POST[mail_user]',id_tipo_user='$_POST[tipo_user]',nick_usuario='$_POST[user_name]',institucion='$_POST[institucion]',id_categoria='$_POST[categoria_user]',id_departamento='$_POST[departamento_user]' where id_usuario='$_POST[id_user]'");
        ////auditoria//
        $sql_audi=pg_query("select id_usuario,cod_usuario,nombres_usuario,direccion_usuario,nombre_ciudad,telefono_usuario,celular_usuario,email_usuario,nombre_tipo,nick_usuario,fecha,institucion,nombre_categoria,nombre_departamento from usuario,ciudad,tipo_usuario,categorias,departamento where usuario.id_ciudad=ciudad.id_ciudad and usuario.id_tipo_user=tipo_usuario.id_tipo_usuario and categorias.id_categoria=usuario.id_categoria and usuario.id_departamento=departamento.id_departamento and usuario.id_usuario='$_POST[id_user]' order by id_usuario asc");
        while ($row_audi=pg_fetch_row($sql_audi)) {
            $nuevo=$row_audi[0].",".$row_audi[1].",".$row_audi[2].",".$row_audi[3].",".$row_audi[4].",".$row_audi[5].",".$row_audi[6].",".$row_audi[7].",".$row_audi[8].",".$row_audi[9].",".$row_audi[10].",".$row_audi[11].",".$row_audi[12].",".$row_audi[13];               
        }    
        pg_query("insert into auditoria_sistema values ('$id_audi','$_SESSION[usuario] $_SESSION[id]','$fecha','usuario','Update','$anterior','$nuevo','Modificacion de los datos del usuario')");                
        $id_audi++;
        //////////////  
        ////auditoria//
        $sql_audi=pg_query("select id_clave,clave,nombres_usuario from clave,usuario where clave.usuario=usuario.id_usuario and clave.usuario='$_POST[id_user]'");
        while ($row_audi=pg_fetch_row($sql_audi)) {
            $anterior=$row_audi[0].",".$row_audi[1].",".$row_audi[2];
        }                    
        //////////////  
        pg_query("update clave set id_clave='$_POST[id_user]',clave='$_POST[clave_user]',usuario='$_POST[id_user]' where id_clave='$_POST[id_user]'");
        ////auditoria//
        $sql_audi=pg_query("select id_clave,clave,nombres_usuario from clave,usuario where clave.usuario=usuario.id_usuario and clave.usuario='$_POST[id_user]'");
        while ($row_audi=pg_fetch_row($sql_audi)) {
            $nuevo=$row_audi[0].",".$row_audi[1].",".$row_audi[2];
        }            
        pg_query("insert into auditoria_sistema values ('$id_audi','$_SESSION[usuario] $_SESSION[id]','$fecha','clave','Update','$anterior','$nuevo','Modificacion de la clave del usuario')");                
        //////////////  
        $data=2;
    }
    if($_POST["tipo"]=="md"){
        ////auditoria//
        $sql_audi=pg_query("select id_usuario,cod_usuario,nombres_usuario,direccion_usuario,nombre_ciudad,telefono_usuario,celular_usuario,email_usuario,nombre_tipo,nick_usuario,fecha,institucion,nombre_categoria,nombre_departamento from usuario,ciudad,tipo_usuario,categorias,departamento where usuario.id_ciudad=ciudad.id_ciudad and usuario.id_tipo_user=tipo_usuario.id_tipo_usuario and categorias.id_categoria=usuario.id_categoria and usuario.id_departamento=departamento.id_departamento and usuario.id_usuario='$_POST[id_user]' order by id_usuario asc");
        while ($row_audi=pg_fetch_row($sql_audi)) {
            $anterior=$row_audi[0].",".$row_audi[1].",".$row_audi[2].",".$row_audi[3].",".$row_audi[4].",".$row_audi[5].",".$row_audi[6].",".$row_audi[7].",".$row_audi[8].",".$row_audi[9].",".$row_audi[10].",".$row_audi[11].",".$row_audi[12].",".$row_audi[13];               
        }            
        //////////////  
        pg_query("update usuario set id_usuario='$_POST[id_user]',cod_usuario='$_POST[cod_user]',nombres_usuario='$_POST[nombre_user]',direccion_usuario='$_POST[dir_user]',id_ciudad='$_POST[ciudad_user]',telefono_usuario='$_POST[tel_user]',celular_usuario='$_POST[cel_user]',email_usuario='$_POST[mail_user]',id_tipo_user='$_POST[tipo_user]',nick_usuario='$_POST[user_name]',institucion='$_POST[institucion]',id_categoria='$_POST[categoria_user]',id_departamento='$_POST[departamento_user]' where id_usuario='$_POST[id_user]'");        
        ////auditoria//
        $sql_audi=pg_query("select id_usuario,cod_usuario,nombres_usuario,direccion_usuario,nombre_ciudad,telefono_usuario,celular_usuario,email_usuario,nombre_tipo,nick_usuario,fecha,institucion,nombre_categoria,nombre_departamento from usuario,ciudad,tipo_usuario,categorias,departamento where usuario.id_ciudad=ciudad.id_ciudad and usuario.id_tipo_user=tipo_usuario.id_tipo_usuario and categorias.id_categoria=usuario.id_categoria and usuario.id_departamento=departamento.id_departamento and usuario.id_usuario='$_POST[id_user]' order by id_usuario asc");
        while ($row_audi=pg_fetch_row($sql_audi)) {
            $nuevo=$row_audi[0].",".$row_audi[1].",".$row_audi[2].",".$row_audi[3].",".$row_audi[4].",".$row_audi[5].",".$row_audi[6].",".$row_audi[7].",".$row_audi[8].",".$row_audi[9].",".$row_audi[10].",".$row_audi[11].",".$row_audi[12].",".$row_audi[13];               
        }            
        //////////////  
        pg_query("insert into auditoria_sistema values ('$id_audi','$_SESSION[usuario] $_SESSION[id]','$fecha','usuario','Update','$anterior','$nuevo','Modificacion de los datos del usuario')");                
        $data=2;
    }
    echo $data;
  
?>
    