<?php
    session_start();
    $data=0;
    include 'base.php';
    //error_reporting(0);
	conectarse();
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
    $cadena1=$_GET['vector1'];
    $cadena2=$_GET['vector2'];
    $cadena3=$_GET['vector3']; 
    date_default_timezone_set('America/Guayaquil');
	$fecha=date('Y-m-d H:i:s', time());   
	$extra=date('YmdHis', time()); 
    if($cadena1{0}==","){
    	$cadena1=substr($cadena1, 1);
    }  
    if(strlen($_GET['vector2'])>0)
    	{  
	    if($cadena2{0}==","){
    		$cadena2=substr($cadena2, 1);
    	}    
    	if($cadena3{0}==","){
	    	$cadena3=substr($cadena3, 1);
    	}        
	}
    $lista1 = explode(",", $cadena1);    
    $lista2 = explode(",", $cadena2);   
    $lista3 = explode(",", $cadena3);
    $cont = count($lista2);
    $cont1 = count($lista1);
    
   /*datos del archivo*/   	
	$extension = explode(".", $_FILES["archivoDoc"]["name"]); 

	$extension = end($extension);
    $type = $_FILES["archivoDoc"]["type"];
	$tmp_name = $_FILES["archivoDoc"]["tmp_name"];	
	$size = $_FILES["archivoDoc"]["size"];
	$nombre = basename($_FILES["archivoDoc"]["name"],".".$extension);

		
	$tipo_doc=$_POST['tipoDoc'];
	$fecha_doc=$_POST['fechaDoc'];
	$departamento_doc=$_POST['departamentoDoc'];	
	$asunto_doc=$_POST['asuntoDoc'];	
	$fp = fopen($tmp_name, "rb");
  	$buffer = fread($fp, filesize($tmp_name));

	fclose($fp);		
	$buffer=pg_escape_bytea($buffer);
	//echo $buffer;
	/***********/
	$contador=0;
	$contador1=0;
	$contador2=0;
	$contador3=0;
	/*guardo el archivo*/	
	$consulta=pg_query("select id_archivo from archivo order by id_archivo asc");
	while ($row = pg_fetch_row($consulta)) {
		$contador=$row[0];		
	}
	$contador=$contador+1;		
	/**metadatos*/
	$consulta=pg_query("select id_meta from metas order by id_meta asc");
	while ($row = pg_fetch_row($consulta)) {
		$contador1=$row[0];
	}
	$contador1=$contador1+1;	
	///////////////
	$consulta=pg_query("select id_bitacora from bitacora order by id_bitacora asc");
	while ($row = pg_fetch_row($consulta)) {
		$contador3=$row[0];
	}	
	$contador3=$contador3+1;
	$codigo_documento=$nombre{0}."-".$fecha_doc."-".$extension."-".$contador."-".$contador3;	
	////////////////////////	
	$nombre=$nombre.$extra.$contador.".".$extension;
	move_uploaded_file($_FILES["archivoDoc"]["tmp_name"],"../archivos/" .$nombre);	
	pg_query("insert into archivo values('$contador','$_POST[nombre_doc]','$codigo_documento','$tipo_doc','".$lista1[0]."','$_POST[estado_archivo]')");	
	////auditoria//
	$sql_audi=pg_query("select id_archivo,nombre_archivo,codigo_archivo,tipo_documento,usuario.nombres_usuario,archivo.estado from archivo,tipo_documento,usuario where archivo.id_tipo_doc=tipo_documento.id_tipo_documento and archivo.id_creador=usuario.id_usuario and archivo.id_archivo='$contador'");            
	while($row_audi=pg_fetch_row($sql_audi))
	{
    	$nuevo=$row_audi[0].",".$row_audi[1].",".$row_audi[2].",".$row_audi[3].",".$row_audi[4].",".$row_audi[5];
	}	
    pg_query("insert into auditoria_sistema values ('$id_audi','$_SESSION[usuario] $_SESSION[id]','$fecha','archivo','Insert','','$nuevo','Creación de un archivo nuevo por el usuario')");        
    $id_audi++;
    ////////////// 
	pg_query("insert into bitacora values('$contador3','$contador','$fecha','$asunto_doc','$departamento_doc','".$lista1[0]."','$buffer','$_POST[observaciones_archivo]','$size','$nombre','$type')");
	////auditoria//
	$sql_audi=pg_query("select id_bitacora,nombre_archivo,fecha_cambio,asunto_cambio,nombre_departamento,nombres_usuario,observaciones,peso,referencia,tipo from bitacora,archivo,departamento,usuario where bitacora.id_archivo=archivo.id_archivo and bitacora.id_departamento=departamento.id_departamento and bitacora.id_usuario=usuario.id_usuario and bitacora.id_bitacora='$contador3'");            
	while($row_audi=pg_fetch_row($sql_audi))
	{
    	$nuevo=$row_audi[0].",".$row_audi[1].",".$row_audi[2].",".$row_audi[3].",".$row_audi[4].",".$row_audi[5].",'',".$row_audi[6].",".$row_audi[7].",".$row_audi[8].",".$row_audi[9];
	}	
    pg_query("insert into auditoria_sistema values ('$id_audi','$_SESSION[usuario] $_SESSION[id]','$fecha','bitacora','Insert','','$nuevo','Nueva versión del archivo original')");        
    $id_audi++;
    //////////////  
	$total=strlen($_GET['vector2']);
	if($total>0){
		for($i=0;$i<$cont;$i=$i+2){	
			pg_query("insert into metas values('$contador1','$lista2[$i]','$lista3[$i]','$contador')");
			////auditoria//
			$sql_audi=pg_query("select id_meta,nombre_meta,descripcion_meta,nombre_archivo from metas,archivo where metas.id_archivo=archivo.id_archivo and metas.id_meta='$contador1'");            
			while($row_audi=pg_fetch_row($sql_audi))
			{
		    	$nuevo=$row_audi[0].",".$row_audi[1].",".$row_audi[2].",".$row_audi[3];
			}	
		    pg_query("insert into auditoria_sistema values ('$id_audi','$_SESSION[usuario] $_SESSION[id]','$fecha','metas','Insert','','$nuevo','Creación de una meta para el archivo creado')");        
		    $id_audi++;
		    ////////////// 
			$contador1=$contador1+1;			

		}
	}
	pg_query("insert into metas values('$contador1','nombre','$nombre','$contador')");
	////auditoria//
	$sql_audi=pg_query("select id_meta,nombre_meta,descripcion_meta,nombre_archivo from metas,archivo where metas.id_archivo=archivo.id_archivo and metas.id_meta='$contador1'");            
	while($row_audi=pg_fetch_row($sql_audi))
	{
	  	$nuevo=$row_audi[0].",".$row_audi[1].",".$row_audi[2].",".$row_audi[3];
	}	
	pg_query("insert into auditoria_sistema values ('$id_audi','$_SESSION[usuario] $_SESSION[id]','$fecha','metas','Insert','','$nuevo','Creación de una meta para el archivo creado')");        
	$id_audi++;
	////////////// 
	$contador1=$contador1+1;
	pg_query("insert into metas values('$contador1','tipo','$type','$contador')");
	////auditoria//
	$sql_audi=pg_query("select id_meta,nombre_meta,descripcion_meta,nombre_archivo from metas,archivo where metas.id_archivo=archivo.id_archivo and metas.id_meta='$contador1'");            
	while($row_audi=pg_fetch_row($sql_audi))
	{
	  	$nuevo=$row_audi[0].",".$row_audi[1].",".$row_audi[2].",".$row_audi[3];
	}	
	pg_query("insert into auditoria_sistema values ('$id_audi','$_SESSION[usuario] $_SESSION[id]','$fecha','metas','Insert','','$nuevo','Creación de una meta para el archivo creado')");        
	$id_audi++;
	////////////// 
	$contador1=$contador1+1;
	pg_query("insert into metas values('$contador1','peso','$size','$contador')");
	////auditoria//
	$sql_audi=pg_query("select id_meta,nombre_meta,descripcion_meta,nombre_archivo from metas,archivo where metas.id_archivo=archivo.id_archivo and metas.id_meta='$contador1'");            
	while($row_audi=pg_fetch_row($sql_audi))
	{
	   	$nuevo=$row_audi[0].",".$row_audi[1].",".$row_audi[2].",".$row_audi[3];
	}	
	pg_query("insert into auditoria_sistema values ('$id_audi','$_SESSION[usuario] $_SESSION[id]','$fecha','metas','Insert','','$nuevo','Creación de una meta para el archivo creado')");        
	$id_audi++;
	////////////// 
	$contador1=$contador1+1;
	////////////		
	$consulta=pg_query("select * from recibidos order by id_recibido asc");
	while ($row = pg_fetch_row($consulta)) {
		$contador2=$row[0];
	}
	$contador2=$contador2+1;	
	/////////
	for ($i=0; $i < $cont1; $i++) { 
		pg_query("insert into recibidos values('$contador2','$contador','".$lista1[$i]."','Enviado','1')");
		////auditoria//
		$sql_audi=pg_query("select id_recibido,nombre_archivo,nombres_usuario,recibidos.estado,leido from recibidos,archivo,usuario where recibidos.id_archivo=archivo.id_archivo and recibidos.id_usuarios=usuario.id_usuario and id_recibido='$contador2'");            
		while($row_audi=pg_fetch_row($sql_audi))
		{
		   	$nuevo=$row_audi[0].",".$row_audi[1].",".$row_audi[2].",".$row_audi[3];
		}	
		pg_query("insert into auditoria_sistema values ('$id_audi','$_SESSION[usuario] $_SESSION[id]','$fecha','recibidos','Insert','','$nuevo','Envio del archivo subido a todos los usuarios relacionados')");        
		$id_audi++;
		////////////// 
		$contador2=$contador2+1;	
	}		
	echo $data;
?>
