<?php
    session_start();
    $data=0;
    error_reporting(0);
    include 'base.php';    
	conectarse();      
	/////////id de la auditoria////////////        
    $id_audi=0;
    $sql_audi=pg_query("select id_sistema from auditoria_sistema order by id_sistema ASC");
    while($row_audi=pg_fetch_row($sql_audi)){
        $id_audi=$row_audi[0];
    }
    $id_audi=$id_audi+1;
    /////////////////////////////////////// 
	date_default_timezone_set('America/Guayaquil');
	$fecha=date('Y-m-d H:i:s', time());   
	$extra=date('YmdHis', time());     
   	if(!empty($_FILES['archivoDoc']["name"]))
   	{
   		/*datos del archivo*/
   		$extension = explode(".", $_FILES["archivoDoc"]["name"]); 
		$extension = end($extension);
    	$type = $_FILES["archivoDoc"]["type"];
		$tmp_name = $_FILES["archivoDoc"]["tmp_name"];			
		$size = $_FILES["archivoDoc"]["size"];
		$nombre = basename($_FILES["archivoDoc"]["name"],".".$extension);   	    
		$fp = fopen($tmp_name, "rb");		
	  	$buffer = fread($fp, filesize($tmp_name));
		fclose($fp);				
		$buffer=pg_escape_bytea($buffer);		
	}
	else{
		$consulta=pg_query("select id_bitacora,archivo_bytea,peso,referencia,tipo from bitacora where id_archivo='$_GET[id]' order by id_bitacora desc limit 1");	
		while($row=pg_fetch_row($consulta)){
			$id_bitacora=$row[0];
			$buffer=$row[1];
			$peso=$row[2];
			$referencia=$row[3];
			$tipo=$row[4];
		}

	}
	/***********/
	$fecha_doc=$_POST['fechaDoc'];
	$departamento_doc=$_POST['departamentoDoc'];	
	$asunto_doc=$_POST['asuntoDoc'];	     
	$estado_doc=$_POST['estado_archivo'];	     
	$observaciones=$_POST['observaciones'];	     	
	$contador1=0;
	/*modificar el archivo*/	
	////auditoria//
    $sql_audi=pg_query("select id_archivo,nombre_archivo,codigo_archivo,nombre_doc,nombres_usuario,archivo.estado from archivo,tipo_documento,usuario where archivo.id_tipo_doc=tipo_documento.id_tipo_documento and archivo.id_creador=usuario.id_usuario and id_archivo='$_GET[id]'");
    while ($row_audi=pg_fetch_row($sql_audi)) {
        $anterior=$row_audi[0].",".$row_audi[1].",".$row_audi[2].",".$row_audi[3].",".$row_audi[4].",".$row_audi[5];               
    }            
    //////////////  
	pg_query("update archivo set estado='$estado_doc' where id_archivo='$_GET[id]'");
	////auditoria//
    $sql_audi=pg_query("select id_archivo,nombre_archivo,codigo_archivo,nombre_doc,nombres_usuario,archivo.estado from archivo,tipo_documento,usuario where archivo.id_tipo_doc=tipo_documento.id_tipo_documento and archivo.id_creador=usuario.id_usuario and id_archivo='$_GET[id]'");
    while ($row_audi=pg_fetch_row($sql_audi)) {
        $nuevo=$row_audi[0].",".$row_audi[1].",".$row_audi[2].",".$row_audi[3].",".$row_audi[4].",".$row_audi[5];               
    }                
    pg_query("insert into auditoria_sistema values ('$id_audi','$_SESSION[usuario] $_SESSION[id]','$fecha','archivo','Update','$anterior','$nuevo','Modificacion del archivo por el usuario')");                
	$id_audi++;
	/////////////////		  
	$consulta=pg_query("select id_bitacora from bitacora order by id_bitacora asc");
	while ($row = pg_fetch_row($consulta)) {
		$contador1=$row[0];
	}
	$contador1=$contador1+1;
	if(!empty($_FILES['archivoDoc']["name"]))
   	{
   		$nombre=$nombre.$extra.$_GET['id'].".".$extension;
		move_uploaded_file($_FILES["archivoDoc"]["tmp_name"],"../archivos/" .$nombre);
		pg_query("insert into bitacora values('$contador1','$_GET[id]','$fecha','$asunto_doc','$departamento_doc','".$_SESSION['id']."','$buffer','$observaciones','$size','$nombre','$type')");		
   		////auditoria//
    	$sql_audi=pg_query("select id_bitacora,nombre_archivo,fecha_cambio,asunto_cambio,nombre_departamento,nombres_usuario,observaciones,peso,referencia,tipo from bitacora,archivo,departamento,usuario where bitacora.id_archivo=archivo.id_archivo and bitacora.id_departamento=departamento.id_departamento and bitacora.id_usuario=usuario.id_usuario and bitacora.id_bitacora='$contador1'");
    	while ($row_audi=pg_fetch_row($sql_audi)) {
        	$nuevo=$row_audi[0].",".$row_audi[1].",".$row_audi[2].",".$row_audi[3].",".$row_audi[4].",".$row_audi[5].",'',".$row_audi[6].",".$row_audi[7].",".$row_audi[8].",".$row_audi[9].",".$row_audi[10];
    	}  
    	pg_query("insert into auditoria_sistema values ('$id_audi','$_SESSION[usuario] $_SESSION[id]','$fecha','bitacora','Insert','','$nuevo','Nueva version del archivo subido por el usuario')");                  
    	$id_audi++;
    	//////////////      	
   	}	
   	else{
   		pg_query("insert into bitacora values ('$contador1','$_GET[id]','$fecha','$asunto_doc','$departamento_doc','".$_SESSION['id']."','$buffer','$observaciones','$peso','$referencia','$tipo')");	   		
   		////auditoria//
    	$sql_audi=pg_query("select id_bitacora,nombre_archivo,fecha_cambio,asunto_cambio,nombre_departamento,nombres_usuario,observaciones,peso,referencia,tipo from bitacora,archivo,departamento,usuario where bitacora.id_archivo=archivo.id_archivo and bitacora.id_departamento=departamento.id_departamento and bitacora.id_usuario=usuario.id_usuario and bitacora.id_bitacora='$contador1'");
    	while ($row_audi=pg_fetch_row($sql_audi)) {
        	$nuevo=$row_audi[0].",".$row_audi[1].",".$row_audi[2].",".$row_audi[3].",".$row_audi[4].",".$row_audi[5].",'',".$row_audi[6].",".$row_audi[7].",".$row_audi[8].",".$row_audi[9].",".$row_audi[10];
    	}            
    	pg_query("insert into auditoria_sistema values ('$id_audi','$_SESSION[usuario] $_SESSION[id]','$fecha','bitacora','Insert','','$nuevo','Nueva version del archivo subido por el usuario')");                  
    	$id_audi++;
    	//////////////      	
   	}					
	/////cambiar los estados a los destinatarios//
	$consulta1=	pg_query("select * from recibidos where id_archivo='$_GET[id]'");
	while($row=pg_fetch_row($consulta1)){
		////auditoria//
    	$sql_audi=pg_query("select id_recibido,nombre_archivo,nombres_usuario,recibidos.estado,leido from recibidos,archivo,usuario where recibidos.id_archivo=archivo.id_archivo and recibidos.id_usuarios=usuario.id_usuario and id_recibido='$row[0]'");
    	while ($row_audi=pg_fetch_row($sql_audi)) {
        	$anterior=$row_audi[0].",".$row_audi[1].",".$row_audi[2].",".$row_audi[3].",".$row_audi[4];
    	}            
    	/////////
		pg_query("update recibidos set leido='1' where id_recibido='$row[0]'");
		////auditoria//
    	$sql_audi=pg_query("select id_recibido,nombre_archivo,nombres_usuario,recibidos.estado,leido from recibidos,archivo,usuario where recibidos.id_archivo=archivo.id_archivo and recibidos.id_usuarios=usuario.id_usuario and id_recibido='$row[0]'");
    	while ($row_audi=pg_fetch_row($sql_audi)) {
        	$nuevo=$row_audi[0].",".$row_audi[1].",".$row_audi[2].",".$row_audi[3].",".$row_audi[4];
    	}            
    	/////////
    	pg_query("insert into auditoria_sistema values ('$id_audi','$_SESSION[usuario] $_SESSION[id]','$fecha','recibidos','Update','$anterior','$nuevo','Modificacion de los estados del archivos a los usuarios ')");        
    	$id_audi++;
	}	
	echo $data;
?>
