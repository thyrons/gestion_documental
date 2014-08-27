<?php
	error_reporting(0);
	session_start();
	$f=isset($_REQUEST['f'])?$_REQUEST['f']:0;	
	$id=isset($_REQUEST['id'])?$_REQUEST['id']:0;
	
	$link = pg_connect("host=localhost user=postgres password=root dbname=gestion_documental") or die(pg_last_error($link));
	$sql="select id_bitacora,id_archivo,referencia, coalesce(archivo_bytea,'-1') as archivo_bytea from bitacora where id_archivo='$id' order by id_bitacora desc limit 1;";
	/////////id de la auditoria////////////
    date_default_timezone_set('UTC');
    $fecha=date("Y-m-d");
    $id_audi=0;
    $sql_audi=pg_query("select id_sistema from auditoria_sistema order by id_sistema ASC");
    while($row_audi=pg_fetch_row($sql_audi)){
        $id_audi=$row_audi[0];
    }
    $id_audi=$id_audi+1;    
    ////auditoria//                
    pg_query("insert into auditoria_sistema values ('$id_audi','$_SESSION[usuario] $_SESSION[id]','$fecha','','Descarga de archivos','','','Descarga del documento por el usuario $_SESSION[nombres]')");        
    //////////////  
	$result=pg_query($sql);
	/**/
	$consulta1="select descripcion_meta from metas where id_archivo='$id' and nombre_meta='tipo'";	
	$consulta2="select descripcion_meta from metas where id_archivo='$id' and nombre_meta='peso'";	
	$result1=pg_query($consulta1);
	$result2=pg_query($consulta2);
	$result1=pg_query($link, $consulta1);
	$result2=pg_query($link, $consulta2);
	$result=pg_query($link, $sql);
	# Si no existe, redirecciona a la página principal
	if(!$result || pg_num_rows($result)<1){
		header("Location: ../paginas/doc_enviados.php");
		exit();
	}
	# Recupera los atributos del archivo
	$row=pg_fetch_array($result,0);
	pg_free_result($result);
	$row1=pg_fetch_array($result1,0);
	pg_free_result($result1);
	$row2=pg_fetch_array($result2,0);
	pg_free_result($result2);
	# Para determinar si archivo a bajar fue ingresado al campo archivo_oid (es de tipo "oid")
	$isoid=false;
	if($row['archivo_bytea']==-1) $isoid=true;
	//if($row['archivo_oid']==-1) $isoid=true;
	if($row['archivo_bytea']==-1) die('No existe el archivo para mostrar o bajar');
	if($isoid){
		# Inicia la transacción
		pg_query($link, "begin");
		# Abre el objeto blob
		//$file=pg_lo_open($link, $row['archivo_oid'], "r");
	}
	else{
		# Hace el proceso inverso a pg_escape_bytea, para que el archivo esté en su estado original
		$file=pg_unescape_bytea($row['archivo_bytea']);
		

	}	

	# Envío de cabeceras	
	if($f==1){
		header("Cache-control: private");
		header("Content-type: $row1[descripcion_meta]");

		header("Content-Disposition: attachment; filename=\"$row[referencia]\"");
		header("Content-length: $row2[descripcion_meta]");
		header("Expires: ".gmdate("D, d M Y H:i:s", mktime(date("H")+2, date("i"), date("s"), date("m"), date("d"), date("Y")))." GMT");
		header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
		header("Cache-Control: no-cache, must-revalidate");
		header("Pragma: no-cache");
	
		if($isoid){
		# Imprime el contenido del objeto blob
			pg_lo_read_all($file);
		# Cierra el objeto
			pg_lo_close($file);
		# Compromete la transacción
			pg_query($link, "commit");
		}
		else{
		# Imprime el contenido del archivo
			print $file;
		}
		pg_close($link);
	}
	else{

		echo "<iframe src='../archivos/$row[referencia]' width=100% height=100%></iframe>";
	}
	
?>
