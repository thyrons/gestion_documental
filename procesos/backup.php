<?php
session_start();
backup();
  function dl_file($file){
     date_default_timezone_set('America/Guayaquil');
     $fecha=date('Y-m-d H:i:s', time());   
     if (!is_file($file)) { die("<b>404 File not found!</b>"); }
     $len = filesize($file);     
     $filename = basename($file);
     $temp=explode('.', $filename);
     $nombre=$temp[0].'-'.$fecha.'.'.'sql';
     $file_extension = strtolower(substr(strrchr($filename,"."),1));
     $ctype="application/force-download";
     header("Pragma: public");
     header("Expires: 0");
     header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
     header("Cache-Control: public");
     header("Content-Description: File Transfer");
     header("Content-Type: $ctype");
     $header="Content-Disposition: attachment; filename=".$nombre.";";
     header($header );
     header("Content-Transfer-Encoding: binary");
     header("Content-Length: ".$len);
     @readfile($file);
     exit;
  }

  function backup(){       
    $dbname = "gestion_documental"; //database name
    $dbconn = pg_pconnect("host=localhost port=5432 dbname=$dbname user=postgres password=root"); //connectionstring
    if (!$dbconn) {
      echo "Can't connect.\n";
    exit;
    }
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
    pg_query("insert into auditoria_sistema values ('$id_audi','$_SESSION[usuario] $_SESSION[id]','$fecha','','Backup','','','Respaldo de la base de datos por el usuario $_SESSION[nombres]')");        
    //////////////  
    $consulta=pg_query("select  max(pk_audit) as maximo from tbl_audit");
    while($row=pg_fetch_row($consulta)){
      $max=$row[0];
    }
    $max=$max+1;
    //////////////
    $back = fopen("$dbname.sql","w");
    /////////////////    
    $str="";
    $str .= "\nCREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog" .";";
    $str .= "\nCOMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language'" .";";
    $str .= "\nSET search_path = public, pg_catalog" .";";
    $str .= "\nSET client_encoding=LATIN1" . ";";
    ////////////
    $str .= "\nCREATE FUNCTION fn_log_audit() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
  IF (TG_TABLE_NAME = 'bitacora') THEN
    IF (TG_OP = 'DELETE') THEN
      INSERT INTO tbl_audit (\"nombre_tabla\", \"operacion\", \"valor_anterior\", \"valor_nuevo\", \"fecha_cambio\", \"usuario\")
             VALUES (TG_TABLE_NAME, 'D', (OLD.id_bitacora,OLD.id_archivo,OLD.fecha_cambio,OLD.asunto_cambio,OLD.id_departamento,OLD.id_usuario,OLD.observaciones,OLD.peso,OLD.referencia,OLD.tipo), NULL, now(), USER);
      RETURN OLD;
    ELSIF (TG_OP = 'UPDATE') THEN
      INSERT INTO tbl_audit (\"nombre_tabla\", \"operacion\", \"valor_anterior\", \"valor_nuevo\", \"fecha_cambio\", \"usuario\")
             VALUES (TG_TABLE_NAME, 'U', (OLD.id_bitacora,OLD.id_archivo,OLD.fecha_cambio,OLD.asunto_cambio,OLD.id_departamento,OLD.id_usuario,OLD.observaciones,OLD.peso,OLD.referencia,OLD.tipo) ,(NEW.id_bitacora,NEW.id_archivo,NEW.fecha_cambio,NEW.asunto_cambio,NEW.id_departamento,NEW.id_usuario,NEW.observaciones,NEW.peso,NEW.referencia,NEW.tipo) , now(), USER);
      RETURN NEW;
    ELSIF (TG_OP = 'INSERT') THEN
      INSERT INTO tbl_audit (\"nombre_tabla\", \"operacion\", \"valor_anterior\", \"valor_nuevo\", \"fecha_cambio\", \"usuario\")
             VALUES (TG_TABLE_NAME, 'I', NULL, (NEW.id_bitacora,NEW.id_archivo,NEW.fecha_cambio,NEW.asunto_cambio,NEW.id_departamento,NEW.id_usuario,NEW.observaciones,NEW.peso,NEW.referencia,NEW.tipo), now(), USER);
      RETURN NEW;
    END IF;
    RETURN NULL;
  else  
    IF (TG_OP = 'DELETE') THEN
      INSERT INTO tbl_audit (\"nombre_tabla\", \"operacion\", \"valor_anterior\", \"valor_nuevo\", \"fecha_cambio\", \"usuario\")
             VALUES (TG_TABLE_NAME, 'D', OLD, NULL, now(), USER);
      RETURN OLD;
    ELSIF (TG_OP = 'UPDATE') THEN
      INSERT INTO tbl_audit (\"nombre_tabla\", \"operacion\", \"valor_anterior\", \"valor_nuevo\", \"fecha_cambio\", \"usuario\")
             VALUES (TG_TABLE_NAME, 'U', OLD, NEW, now(), USER);
      RETURN NEW;
    ELSIF (TG_OP = 'INSERT') THEN
      INSERT INTO tbl_audit (\"nombre_tabla\", \"operacion\", \"valor_anterior\", \"valor_nuevo\", \"fecha_cambio\", \"usuario\")
             VALUES (TG_TABLE_NAME, 'I', NULL, NEW, now(), USER);
      RETURN NEW;
    END IF;
    RETURN NULL;
  
  end if;
END;
$$;";
$str .= "\nLANGUAGE 'plpgsql' VOLATILE COST 100;";
$str .= "\nALTER FUNCTION public.fn_log_audit() OWNER TO postgres;";
    ///////////
    $table = 'accesos';
    $str .= "\n--\n";
    $str .= "-- Estrutura de la tabla '$table'";
    $str .= "\n--\n";
    $str .= "\nDROP TABLE $table CASCADE;";
    $str .= "\nCREATE TABLE $table (";    
    $str .= "\n" . 'id_acceso' . " " . 'int4' . " " . 'NOT NULL' . ",";
    $str .= "\n" . 'id_usuario' . " " . 'int4' . ",";
    $str .= "\n" . 'id_aplicacion' . " " . 'int4' . ",";
    $str .= "\n" . 'estado' . " " . 'text';
    $str=rtrim($str, ",");  
    $str .= "\n);\n";
    $str .= "\n--\n";
    $str .= "-- Creating data for '$table'";
    $str .= "\n--\n\n";

    $res3 = pg_query("SELECT * FROM $table");
    while($r = pg_fetch_row($res3))
    {
      $sql = "INSERT INTO $table VALUES ('";
      $sql .= utf8_decode(implode("','",$r));
      $sql .= "');";
      $str = str_replace("''","NULL",$str);
      $str .= $sql;  
      $str .= "\n";
    }       
     $res1 = pg_query("SELECT pg_index.indisprimary,
            pg_catalog.pg_get_indexdef(pg_index.indexrelid)
        FROM pg_catalog.pg_class c, pg_catalog.pg_class c2,
            pg_catalog.pg_index AS pg_index
        WHERE c.relname = '$table'
            AND c.oid = pg_index.indrelid
            AND pg_index.indexrelid = c2.oid
            AND pg_index.indisprimary");
    while($r = pg_fetch_row($res1))
    {
      $str .= "\n\n--\n";
      $str .= "-- Creating index for '$table'";
      $str .= "\n--\n\n";
      $t = str_replace("CREATE UNIQUE INDEX", "", $r[1]);
      $t = str_replace("USING btree", "|", $t);      
      $t = str_replace("ON", "|", $t);
      $Temparray = explode("|", $t);
      $str .= "ALTER TABLE ONLY ". $Temparray[1] . " ADD CONSTRAINT " . $Temparray[0] . " PRIMARY KEY " . $Temparray[2] .";\n";
    } 
    $table = 'aplicaciones';
    $str .= "\n--\n";
    $str .= "-- Estrutura de la tabla '$table'";
    $str .= "\n--\n";
    $str .= "\nDROP TABLE $table CASCADE;";
    $str .= "\nCREATE TABLE $table (";
    $str .= "\n" . 'id_aplicacion' . " " . 'int4' . " " . 'NOT NULL' . ",";
    $str .= "\n" . 'nombre_aplicacion' . " " . 'text' . ",";
    $str .= "\n" . 'direccion' . " " . 'text';    
    $str=rtrim($str, ",");  
    $str .= "\n);\n";
    $str .= "\n--\n";
    $str .= "-- Creating data for '$table'";
    $str .= "\n--\n\n";
    $res3 = pg_query("SELECT * FROM $table");
    while($r = pg_fetch_row($res3))
    {
      $sql = "INSERT INTO $table VALUES ('";
      $sql .= utf8_decode(implode("','",$r));
      $sql .= "');";
      $str = str_replace("''","NULL",$str);
      $str .= $sql;  
      $str .= "\n";
    }       
     $res1 = pg_query("SELECT pg_index.indisprimary,
            pg_catalog.pg_get_indexdef(pg_index.indexrelid)
        FROM pg_catalog.pg_class c, pg_catalog.pg_class c2,
            pg_catalog.pg_index AS pg_index
        WHERE c.relname = '$table'
            AND c.oid = pg_index.indrelid
            AND pg_index.indexrelid = c2.oid
            AND pg_index.indisprimary");
    while($r = pg_fetch_row($res1))
    {
      $str .= "\n\n--\n";
      $str .= "-- Creating index for '$table'";
      $str .= "\n--\n\n";
      $t = str_replace("CREATE UNIQUE INDEX", "", $r[1]);
      $t = str_replace("USING btree", "|", $t);
      // Next Line Can be improved!!!
      $t = str_replace("ON", "|", $t);
      $Temparray = explode("|", $t);
      $str .= "ALTER TABLE ONLY ". $Temparray[1] . " ADD CONSTRAINT " . $Temparray[0] . " PRIMARY KEY " . $Temparray[2] .";\n";
    }     
    $table = 'archivo';
    $str .= "\n--\n";
    $str .= "-- Estrutura de la tabla '$table'";
    $str .= "\n--\n";
    $str .= "\nDROP TABLE $table CASCADE;";
    $str .= "\nCREATE TABLE $table (";
    $str .= "\n" . 'id_archivo' . " " . 'int4' . " " . 'NOT NULL' . ",";
    $str .= "\n" . 'nombre_archivo' . " " . 'text' . ",";    
    $str .= "\n" . 'codigo_archivo' . " " . 'text' . ",";    
    $str .= "\n" . 'id_tipo_doc' . " " . 'int4' . ",";    
    $str .= "\n" . 'id_creador' . " " . 'int4' . ",";    
    $str .= "\n" . 'estado' . " " . 'text';    
    $str=rtrim($str, ",");  
    $str .= "\n);\n";
    $str .= "\n--\n";
    $str .= "-- Creating data for '$table'";
    $str .= "\n--\n\n";
    $res3 = pg_query("SELECT * FROM $table");
    while($r = pg_fetch_row($res3))
    {
      $sql = "INSERT INTO $table VALUES ('";
      $sql .= utf8_decode(implode("','",$r));
      $sql .= "');";
      $str = str_replace("''","NULL",$str);
      $str .= $sql;  
      $str .= "\n";
    }       
     $res1 = pg_query("SELECT pg_index.indisprimary,
            pg_catalog.pg_get_indexdef(pg_index.indexrelid)
        FROM pg_catalog.pg_class c, pg_catalog.pg_class c2,
            pg_catalog.pg_index AS pg_index
        WHERE c.relname = '$table'
            AND c.oid = pg_index.indrelid
            AND pg_index.indexrelid = c2.oid
            AND pg_index.indisprimary");
    while($r = pg_fetch_row($res1))
    {
      $str .= "\n\n--\n";
      $str .= "-- Creating index for '$table'";
      $str .= "\n--\n\n";
      $t = str_replace("CREATE UNIQUE INDEX", "", $r[1]);
      $t = str_replace("USING btree", "|", $t);
      // Next Line Can be improved!!!
      $t = str_replace("ON", "|", $t);
      $Temparray = explode("|", $t);
      $str .= "ALTER TABLE ONLY ". $Temparray[1] . " ADD CONSTRAINT " . $Temparray[0] . " PRIMARY KEY " . $Temparray[2] .";\n";      
  } 
    $table = 'auditoria_sistema';
    $str .= "\n--\n";
    $str .= "-- Estrutura de la tabla '$table'";
    $str .= "\n--\n";
    $str .= "\nDROP TABLE $table CASCADE;";
    $str .= "\nCREATE TABLE $table (";
    $str .= "\n" . 'id_sistema' . " " . 'int4' . " " . 'NOT NULL' . ",";
    $str .= "\n" . 'usuario' . " " . 'text' . ",";    
    $str .= "\n" . 'fecha_cambio' . " " . 'text' . ",";    
    $str .= "\n" . 'tabla' . " " . 'text' . ",";    
    $str .= "\n" . 'operacion' . " " . 'text' . ",";    
    $str .= "\n" . 'anterior' . " " . 'text' . ",";    
    $str .= "\n" . 'nuevo' . " " . 'text' . ",";    
    $str .= "\n" . 'observacion' . " " . 'text';    
    $str=rtrim($str, ",");  
    $str .= "\n);\n";
    $str .= "\n--\n";
    $str .= "-- Creating data for '$table'";
    $str .= "\n--\n\n";
    $res3 = pg_query("SELECT * FROM $table");
    while($r = pg_fetch_row($res3))
    {
      $sql = "INSERT INTO $table VALUES ('";
      $sql .= utf8_decode(implode("','",$r));
      $sql .= "');";
      $str = str_replace("''","NULL",$str);
      $str .= $sql;  
      $str .= "\n";
    }       
     $res1 = pg_query("SELECT pg_index.indisprimary,
            pg_catalog.pg_get_indexdef(pg_index.indexrelid)
        FROM pg_catalog.pg_class c, pg_catalog.pg_class c2,
            pg_catalog.pg_index AS pg_index
        WHERE c.relname = '$table'
            AND c.oid = pg_index.indrelid
            AND pg_index.indexrelid = c2.oid
            AND pg_index.indisprimary");
    while($r = pg_fetch_row($res1))
    {
      $str .= "\n\n--\n";
      $str .= "-- Creating index for '$table'";
      $str .= "\n--\n\n";
      $t = str_replace("CREATE UNIQUE INDEX", "", $r[1]);
      $t = str_replace("USING btree", "|", $t);
      // Next Line Can be improved!!!
      $t = str_replace("ON", "|", $t);
      $Temparray = explode("|", $t);
      $str .= "ALTER TABLE ONLY ". $Temparray[1] . " ADD CONSTRAINT " . $Temparray[0] . " PRIMARY KEY " . $Temparray[2] .";\n";      
  }  
    $table = 'bitacora';
    $str .= "\n--\n";
    $str .= "-- Estrutura de la tabla '$table";
    $str .= "\n--\n";
    $str .= "\nDROP TABLE $table CASCADE;";
    $str .= "\nCREATE TABLE $table (";
    $str .= "\n" . 'id_bitacora' . " " . 'int4' . " " . 'NOT NULL' . ",";
    $str .= "\n" . 'id_archivo' . " " . 'int4' . ",";    
    $str .= "\n" . 'fecha_cambio' . " " . 'text' . ",";    
    $str .= "\n" . 'asunto_cambio' . " " . 'text' . ",";    
    $str .= "\n" . 'id_departamento' . " " . 'int4' . ",";    
    $str .= "\n" . 'id_usuario' . " " . 'int4' . ",";       
    $str .= "\n" . 'archivo_bytea' . " " . 'bytea' . ",";   
    $str .= "\n" . 'observaciones' . " " . 'text' . ",";        
    $str .= "\n" . 'peso' . " " . 'text' . ",";    
    $str .= "\n" . 'referencia' . " " . 'text' . ",";    
    $str .= "\n" . 'tipo' . " " . 'text';          
    $str=rtrim($str, ",");  
    $str .= "\n);\n";
    $str .= "\n--\n";
    $str .= "-- Creating data for '$table'";
    $str .= "\n--\n\n";
    $res3 = pg_query("SELECT * FROM $table");
    while($r = pg_fetch_row($res3))
    {
      $sql = "INSERT INTO $table VALUES ('";
      $sql .= utf8_decode(implode("','",$r));
      $sql .= "');";
      $str = str_replace("''","NULL",$str);
      $str .= $sql;  
      $str .= "\n";
    }       
     $res1 = pg_query("SELECT pg_index.indisprimary,
            pg_catalog.pg_get_indexdef(pg_index.indexrelid)
        FROM pg_catalog.pg_class c, pg_catalog.pg_class c2,
            pg_catalog.pg_index AS pg_index
        WHERE c.relname = '$table'
            AND c.oid = pg_index.indrelid
            AND pg_index.indexrelid = c2.oid
            AND pg_index.indisprimary");
    while($r = pg_fetch_row($res1))
    {
    $str .= "\n\n--\n";
    $str .= "-- Creating index for '$table'";
    $str .= "\n--\n\n";
    $t = str_replace("CREATE UNIQUE INDEX", "", $r[1]);
    $t = str_replace("USING btree", "|", $t);
    // Next Line Can be improved!!!
    $t = str_replace("ON", "|", $t);
    $Temparray = explode("|", $t);
    $str .= "ALTER TABLE ONLY ". $Temparray[1] . " ADD CONSTRAINT " . 
$Temparray[0] . " PRIMARY KEY " . $Temparray[2] .";\n";
  }  
  $table = 'categorias';
    $str .= "\n--\n";
    $str .= "-- Estrutura de la tabla  '$table'";
    $str .= "\n--\n";
    $str .= "\nDROP TABLE $table CASCADE;";
    $str .= "\nCREATE TABLE $table (";
    $str .= "\n" . 'id_categoria' . " " . 'int4' . " " . 'NOT NULL' . ",";    
    $str .= "\n" . 'nombre_categoria' . " " . 'text' . ",";      
    $str .= "\n" . 'codigo_categoria' . " " . 'text' . ",";      
    $str .= "\n" . 'estado' . " " . 'text';      
    $str=rtrim($str, ",");  
    $str .= "\n);\n";
    $str .= "\n--\n";
    $str .= "-- Creating data for '$table'";
    $str .= "\n--\n\n";
    $res3 = pg_query("SELECT * FROM $table");
    while($r = pg_fetch_row($res3))
    {
      $sql = "INSERT INTO $table VALUES ('";
      $sql .= utf8_decode(implode("','",$r));
      $sql .= "');";
      $str = str_replace("''","NULL",$str);
      $str .= $sql;  
      $str .= "\n";
    }       
     $res1 = pg_query("SELECT pg_index.indisprimary,
            pg_catalog.pg_get_indexdef(pg_index.indexrelid)
        FROM pg_catalog.pg_class c, pg_catalog.pg_class c2,
            pg_catalog.pg_index AS pg_index
        WHERE c.relname = '$table'
            AND c.oid = pg_index.indrelid
            AND pg_index.indexrelid = c2.oid
            AND pg_index.indisprimary");
    while($r = pg_fetch_row($res1))
    {
    $str .= "\n\n--\n";
    $str .= "-- Creating index for '$table'";
    $str .= "\n--\n\n";
    $t = str_replace("CREATE UNIQUE INDEX", "", $r[1]);
    $t = str_replace("USING btree", "|", $t);
    // Next Line Can be improved!!!
    $t = str_replace("ON", "|", $t);
    $Temparray = explode("|", $t);
    $str .= "ALTER TABLE ONLY ". $Temparray[1] . " ADD CONSTRAINT " . 
$Temparray[0] . " PRIMARY KEY " . $Temparray[2] .";\n";
  }  
  $table = 'ciudad';
    $str .= "\n--\n";
    $str .= "-- Estrutura de la tabla '$table'";
    $str .= "\n--\n";
    $str .= "\nDROP TABLE $table CASCADE;";
    $str .= "\nCREATE TABLE $table (";
    $str .= "\n" . 'id_ciudad' . " " . 'int4' . " " . 'NOT NULL' . ",";    
    $str .= "\n" . 'nombre_ciudad' . " " . 'text' . ",";      
    $str .= "\n" . 'id_provincia' . " " . 'int4';          
    $str=rtrim($str, ",");  
    $str .= "\n);\n";
    $str .= "\n--\n";
    $str .= "-- Creating data for '$table'";
    $str .= "\n--\n\n";
    $res3 = pg_query("SELECT * FROM $table");
    while($r = pg_fetch_row($res3))
    {
      $sql = "INSERT INTO $table VALUES ('";
      $sql .= utf8_decode(implode("','",$r));
      $sql .= "');";
      $str = str_replace("''","NULL",$str);
      $str .= $sql;  
      $str .= "\n";
    }       
     $res1 = pg_query("SELECT pg_index.indisprimary,
            pg_catalog.pg_get_indexdef(pg_index.indexrelid)
        FROM pg_catalog.pg_class c, pg_catalog.pg_class c2,
            pg_catalog.pg_index AS pg_index
        WHERE c.relname = '$table'
            AND c.oid = pg_index.indrelid
            AND pg_index.indexrelid = c2.oid
            AND pg_index.indisprimary");
    while($r = pg_fetch_row($res1))
    {
    $str .= "\n\n--\n";
    $str .= "-- Creating index for '$table'";
    $str .= "\n--\n\n";
    $t = str_replace("CREATE UNIQUE INDEX", "", $r[1]);
    $t = str_replace("USING btree", "|", $t);
    // Next Line Can be improved!!!
    $t = str_replace("ON", "|", $t);
    $Temparray = explode("|", $t);
    $str .= "ALTER TABLE ONLY ". $Temparray[1] . " ADD CONSTRAINT " . 
$Temparray[0] . " PRIMARY KEY " . $Temparray[2] .";\n";
  } 
  $table = 'clave';
    $str .= "\n--\n";
    $str .= "-- Estrutura de la tabla '$table'";
    $str .= "\n--\n";
    $str .= "\nDROP TABLE $table CASCADE;";
    $str .= "\nCREATE TABLE $table (";
    $str .= "\n" . 'id_clave' . " " . 'int4' . " " . 'NOT NULL' . ",";    
    $str .= "\n" . 'clave' . " " . 'text' . ",";      
    $str .= "\n" . 'usuario' . " " . 'int4';          
    $str=rtrim($str, ",");  
    $str .= "\n);\n";
    $str .= "\n--\n";
    $str .= "-- Creating data for '$table'";
    $str .= "\n--\n\n";
    $res3 = pg_query("SELECT * FROM $table");
    while($r = pg_fetch_row($res3))
    {
      $sql = "INSERT INTO $table VALUES ('";
      $sql .= utf8_decode(implode("','",$r));
      $sql .= "');";
      $str = str_replace("''","NULL",$str);
      $str .= $sql;  
      $str .= "\n";
    }       
     $res1 = pg_query("SELECT pg_index.indisprimary,
            pg_catalog.pg_get_indexdef(pg_index.indexrelid)
        FROM pg_catalog.pg_class c, pg_catalog.pg_class c2,
            pg_catalog.pg_index AS pg_index
        WHERE c.relname = '$table'
            AND c.oid = pg_index.indrelid
            AND pg_index.indexrelid = c2.oid
            AND pg_index.indisprimary");
    while($r = pg_fetch_row($res1))
    {
    $str .= "\n\n--\n";
    $str .= "-- Creating index for '$table'";
    $str .= "\n--\n\n";
    $t = str_replace("CREATE UNIQUE INDEX", "", $r[1]);
    $t = str_replace("USING btree", "|", $t);
    // Next Line Can be improved!!!
    $t = str_replace("ON", "|", $t);
    $Temparray = explode("|", $t);
    $str .= "ALTER TABLE ONLY ". $Temparray[1] . " ADD CONSTRAINT " . 
$Temparray[0] . " PRIMARY KEY " . $Temparray[2] .";\n";
  } 
  $table = 'departamento';
    $str .= "\n--\n";
    $str .= "-- Estrutura de la tabla '$table'";
    $str .= "\n--\n";
    $str .= "\nDROP TABLE $table CASCADE;";
    $str .= "\nCREATE TABLE $table (";
    $str .= "\n" . 'id_departamento' . " " . 'int4' . " " . 'NOT NULL' . ",";    
    $str .= "\n" . 'codigo_departamento' . " " . 'text' . ",";      
    $str .= "\n" . 'nombre_departamento' . " " . 'text' . ",";      
    $str .= "\n" . 'estado' . " " . 'text';          
    $str=rtrim($str, ",");  
    $str .= "\n);\n";
    $str .= "\n--\n";
    $str .= "-- Creating data for '$table'";
    $str .= "\n--\n\n";
    $res3 = pg_query("SELECT * FROM $table");
    while($r = pg_fetch_row($res3))
    {
      $sql = "INSERT INTO $table VALUES ('";      
      $sql .= utf8_decode(implode("','",$r));
      $sql .= "');";
      $str = str_replace("''","NULL",$str);
      $str .= $sql;  
      $str .= "\n";
    }       
     $res1 = pg_query("SELECT pg_index.indisprimary,
            pg_catalog.pg_get_indexdef(pg_index.indexrelid)
        FROM pg_catalog.pg_class c, pg_catalog.pg_class c2,
            pg_catalog.pg_index AS pg_index
        WHERE c.relname = '$table'
            AND c.oid = pg_index.indrelid
            AND pg_index.indexrelid = c2.oid
            AND pg_index.indisprimary");
    while($r = pg_fetch_row($res1))
    {
    $str .= "\n\n--\n";
    $str .= "-- Creating index for '$table'";
    $str .= "\n--\n\n";
    $t = str_replace("CREATE UNIQUE INDEX", "", $r[1]);
    $t = str_replace("USING btree", "|", $t);
    // Next Line Can be improved!!!
    $t = str_replace("ON", "|", $t);
    $Temparray = explode("|", $t);
    $str .= "ALTER TABLE ONLY ". $Temparray[1] . " ADD CONSTRAINT " . 
$Temparray[0] . " PRIMARY KEY " . $Temparray[2] .";\n";
  } 
  $table = 'medio_recepcion';
    $str .= "\n--\n";
    $str .= "-- Estrutura de la tabla '$table'";
    $str .= "\n--\n";
    $str .= "\nDROP TABLE $table CASCADE;";
    $str .= "\nCREATE TABLE $table (";
    $str .= "\n" . 'id_medio' . " " . 'int4' . " " . 'NOT NULL' . ",";    
    $str .= "\n" . 'codigo_medio' . " " . 'text' . ",";      
    $str .= "\n" . 'nombre_medio' . " " . 'text' . ",";      
    $str .= "\n" . 'estado' . " " . 'text';          
    $str=rtrim($str, ",");  
    $str .= "\n);\n";
    $str .= "\n--\n";
    $str .= "-- Creating data for '$table'";
    $str .= "\n--\n\n";
    $res3 = pg_query("SELECT * FROM $table");
    while($r = pg_fetch_row($res3))
    {
      $sql = "INSERT INTO $table VALUES ('";
      $sql .= utf8_decode(implode("','",$r));
      $sql .= "');";
      $str = str_replace("''","NULL",$str);
      $str .= $sql;  
      $str .= "\n";
    }       
     $res1 = pg_query("SELECT pg_index.indisprimary,
            pg_catalog.pg_get_indexdef(pg_index.indexrelid)
        FROM pg_catalog.pg_class c, pg_catalog.pg_class c2,
            pg_catalog.pg_index AS pg_index
        WHERE c.relname = '$table'
            AND c.oid = pg_index.indrelid
            AND pg_index.indexrelid = c2.oid
            AND pg_index.indisprimary");
    while($r = pg_fetch_row($res1))
    {
    $str .= "\n\n--\n";
    $str .= "-- Creating index for '$table'";
    $str .= "\n--\n\n";
    $t = str_replace("CREATE UNIQUE INDEX", "", $r[1]);
    $t = str_replace("USING btree", "|", $t);
    // Next Line Can be improved!!!
    $t = str_replace("ON", "|", $t);
    $Temparray = explode("|", $t);
    $str .= "ALTER TABLE ONLY ". $Temparray[1] . " ADD CONSTRAINT " . 
$Temparray[0] . " PRIMARY KEY " . $Temparray[2] .";\n";
  } 
  $table = 'metas';
    $str .= "\n--\n";
    $str .= "-- Estrutura de la tabla '$table'";
    $str .= "\n--\n";
    $str .= "\nDROP TABLE $table CASCADE;";
    $str .= "\nCREATE TABLE $table (";
    $str .= "\n" . 'id_meta' . " " . 'int4' . " " . 'NOT NULL' . ",";    
    $str .= "\n" . 'nombre_meta' . " " . 'text' . ",";      
    $str .= "\n" . 'descripcion_meta' . " " . 'text' . ",";      
    $str .= "\n" . 'id_archivo' . " " . 'int4';          
    $str=rtrim($str, ",");  
    $str .= "\n);\n";
    $str .= "\n--\n";
    $str .= "-- Creating data for '$table'";
    $str .= "\n--\n\n";
    $res3 = pg_query("SELECT * FROM $table");
    while($r = pg_fetch_row($res3))
    {
      $sql = "INSERT INTO $table VALUES ('";
      $sql .= utf8_decode(implode("','",$r));
      $sql .= "');";
      $str = str_replace("''","NULL",$str);
      $str .= $sql;  
      $str .= "\n";
    }       
     $res1 = pg_query("SELECT pg_index.indisprimary,
            pg_catalog.pg_get_indexdef(pg_index.indexrelid)
        FROM pg_catalog.pg_class c, pg_catalog.pg_class c2,
            pg_catalog.pg_index AS pg_index
        WHERE c.relname = '$table'
            AND c.oid = pg_index.indrelid
            AND pg_index.indexrelid = c2.oid
            AND pg_index.indisprimary");
    while($r = pg_fetch_row($res1))
    {
    $str .= "\n\n--\n";
    $str .= "-- Creating index for '$table'";
    $str .= "\n--\n\n";
    $t = str_replace("CREATE UNIQUE INDEX", "", $r[1]);
    $t = str_replace("USING btree", "|", $t);
    // Next Line Can be improved!!!
    $t = str_replace("ON", "|", $t);
    $Temparray = explode("|", $t);
    $str .= "ALTER TABLE ONLY ". $Temparray[1] . " ADD CONSTRAINT " . 
$Temparray[0] . " PRIMARY KEY " . $Temparray[2] .";\n";
  } 
  $table = 'pais';
    $str .= "\n--\n";
    $str .= "-- Estrutura de la tabla '$table'";
    $str .= "\n--\n";
    $str .= "\nDROP TABLE $table CASCADE;";
    $str .= "\nCREATE TABLE $table (";
    $str .= "\n" . 'id_pais' . " " . 'int4' . " " . 'NOT NULL' . ",";    
    $str .= "\n" . 'nombre_pais' . " " . 'text';                  
    $str=rtrim($str, ",");  
    $str .= "\n);\n";
    $str .= "\n--\n";
    $str .= "-- Creating data for '$table'";
    $str .= "\n--\n\n";
    $res3 = pg_query("SELECT * FROM $table");
    while($r = pg_fetch_row($res3))
    {
      $sql = "INSERT INTO $table VALUES ('";
      $sql .= utf8_decode(implode("','",$r));
      $sql .= "');";
      $str = str_replace("''","NULL",$str);
      $str .= $sql;  
      $str .= "\n";
    }       
     $res1 = pg_query("SELECT pg_index.indisprimary,
            pg_catalog.pg_get_indexdef(pg_index.indexrelid)
        FROM pg_catalog.pg_class c, pg_catalog.pg_class c2,
            pg_catalog.pg_index AS pg_index
        WHERE c.relname = '$table'
            AND c.oid = pg_index.indrelid
            AND pg_index.indexrelid = c2.oid
            AND pg_index.indisprimary");
    while($r = pg_fetch_row($res1))
    {
    $str .= "\n\n--\n";
    $str .= "-- Creating index for '$table'";
    $str .= "\n--\n\n";
    $t = str_replace("CREATE UNIQUE INDEX", "", $r[1]);
    $t = str_replace("USING btree", "|", $t);
    // Next Line Can be improved!!!
    $t = str_replace("ON", "|", $t);
    $Temparray = explode("|", $t);
    $str .= "ALTER TABLE ONLY ". $Temparray[1] . " ADD CONSTRAINT " . 
$Temparray[0] . " PRIMARY KEY " . $Temparray[2] .";\n";
  } 
  $table = 'provincias';
    $str .= "\n--\n";
    $str .= "-- Estrutura de la tabla '$table'";
    $str .= "\n--\n";
    $str .= "\nDROP TABLE $table CASCADE;";
    $str .= "\nCREATE TABLE $table (";
    $str .= "\n" . 'id_provincia' . " " . 'int4' . " " . 'NOT NULL' . ",";    
    $str .= "\n" . 'nombre_provincia' . " " . 'text' . ",";                  
    $str .= "\n" . 'id_pais' . " " . 'int4';                  
    $str=rtrim($str, ",");  
    $str .= "\n);\n";
    $str .= "\n--\n";
    $str .= "-- Creating data for '$table'";
    $str .= "\n--\n\n";
    $res3 = pg_query("SELECT * FROM $table");
    while($r = pg_fetch_row($res3))
    {
      $sql = "INSERT INTO $table VALUES ('";
      $sql .= utf8_decode(implode("','",$r));
      $sql .= "');";
      $str = str_replace("''","NULL",$str);
      $str .= $sql;  
      $str .= "\n";
    }       
     $res1 = pg_query("SELECT pg_index.indisprimary,
            pg_catalog.pg_get_indexdef(pg_index.indexrelid)
        FROM pg_catalog.pg_class c, pg_catalog.pg_class c2,
            pg_catalog.pg_index AS pg_index
        WHERE c.relname = '$table'
            AND c.oid = pg_index.indrelid
            AND pg_index.indexrelid = c2.oid
            AND pg_index.indisprimary");
    while($r = pg_fetch_row($res1))
    {
    $str .= "\n\n--\n";
    $str .= "-- Creating index for '$table'";
    $str .= "\n--\n\n";
    $t = str_replace("CREATE UNIQUE INDEX", "", $r[1]);
    $t = str_replace("USING btree", "|", $t);
    // Next Line Can be improved!!!
    $t = str_replace("ON", "|", $t);
    $Temparray = explode("|", $t);
    $str .= "ALTER TABLE ONLY ". $Temparray[1] . " ADD CONSTRAINT " . 
$Temparray[0] . " PRIMARY KEY " . $Temparray[2] .";\n";
  } 
  $table = 'recibidos';
    $str .= "\n--\n";
    $str .= "-- Estrutura de la tabla '$table'";
    $str .= "\n--\n";
    $str .= "\nDROP TABLE $table CASCADE;";
    $str .= "\nCREATE TABLE $table (";
    $str .= "\n" . 'id_recibido' . " " . 'int4' . " " . 'NOT NULL' . ",";    
    $str .= "\n" . 'id_archivo' . " " . 'int4' . ",";                  
    $str .= "\n" . 'id_usuarios' . " " . 'int4' . ",";                  
    $str .= "\n" . 'estado' . " " . 'text' . ",";                  
    $str .= "\n" . 'leido' . " " . 'int4';    

    $str=rtrim($str, ",");  
    $str .= "\n);\n";
    $str .= "\n--\n";
    $str .= "-- Creating data for '$table'";
    $str .= "\n--\n\n";
    $res3 = pg_query("SELECT * FROM $table");
    while($r = pg_fetch_row($res3))
    {
      $sql = "INSERT INTO $table VALUES ('";
      $sql .= utf8_decode(implode("','",$r));
      $sql .= "');";
      $str = str_replace("''","NULL",$str);
      $str .= $sql;  
      $str .= "\n";
    }       
     $res1 = pg_query("SELECT pg_index.indisprimary,
            pg_catalog.pg_get_indexdef(pg_index.indexrelid)
        FROM pg_catalog.pg_class c, pg_catalog.pg_class c2,
            pg_catalog.pg_index AS pg_index
        WHERE c.relname = '$table'
            AND c.oid = pg_index.indrelid
            AND pg_index.indexrelid = c2.oid
            AND pg_index.indisprimary");
    while($r = pg_fetch_row($res1))
    {
    $str .= "\n\n--\n";
    $str .= "-- Creating index for '$table'";
    $str .= "\n--\n\n";
    $t = str_replace("CREATE UNIQUE INDEX", "", $r[1]);
    $t = str_replace("USING btree", "|", $t);
    // Next Line Can be improved!!!
    $t = str_replace("ON", "|", $t);
    $Temparray = explode("|", $t);
    $str .= "ALTER TABLE ONLY ". $Temparray[1] . " ADD CONSTRAINT " . 
$Temparray[0] . " PRIMARY KEY " . $Temparray[2] .";\n";
  } 
  $table = 'tipo_documento';
    $str .= "\n--\n";
    $str .= "-- Estrutura de la tabla '$table'";
    $str .= "\n--\n";
    $str .= "\nDROP TABLE $table CASCADE;";
    $str .= "\nCREATE TABLE $table (";
    $str .= "\n" . 'id_tipo_documento' . " " . 'int4' . " " . 'NOT NULL' . ",";    
    $str .= "\n" . 'codigo_doc' . " " . 'text' . ",";                  
    $str .= "\n" . 'nombre_doc' . " " . 'text' . ",";                  
    $str .= "\n" . 'estado_doc' . " " . 'text';                      

    $str=rtrim($str, ",");  
    $str .= "\n);\n";
    $str .= "\n--\n";
    $str .= "-- Creating data for '$table'";
    $str .= "\n--\n\n";
    $res3 = pg_query("SELECT * FROM $table");
    while($r = pg_fetch_row($res3))
    {
      $sql = "INSERT INTO $table VALUES ('";
      $sql .= utf8_decode(implode("','",$r));
      $sql .= "');";
      $str = str_replace("''","NULL",$str);
      $str .= $sql;  
      $str .= "\n";
    }       
     $res1 = pg_query("SELECT pg_index.indisprimary,
            pg_catalog.pg_get_indexdef(pg_index.indexrelid)
        FROM pg_catalog.pg_class c, pg_catalog.pg_class c2,
            pg_catalog.pg_index AS pg_index
        WHERE c.relname = '$table'
            AND c.oid = pg_index.indrelid
            AND pg_index.indexrelid = c2.oid
            AND pg_index.indisprimary");
    while($r = pg_fetch_row($res1))
    {
    $str .= "\n\n--\n";
    $str .= "-- Creating index for '$table'";
    $str .= "\n--\n\n";
    $t = str_replace("CREATE UNIQUE INDEX", "", $r[1]);
    $t = str_replace("USING btree", "|", $t);
    // Next Line Can be improved!!!
    $t = str_replace("ON", "|", $t);
    $Temparray = explode("|", $t);
    $str .= "ALTER TABLE ONLY ". $Temparray[1] . " ADD CONSTRAINT " . 
$Temparray[0] . " PRIMARY KEY " . $Temparray[2] .";\n";
  } $table = 'tbl_audit';
    $str .= "\n--\n";
    $str .= "-- Estrutura de la tabla '$table'";
    $str .= "\n--\n";
    $str .= "\nDROP TABLE $table CASCADE;";
    $str.="\nCREATE SEQUENCE tbl_audit_pk_audit_seq
    START WITH $max
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;";
    $str .= "\nCREATE TABLE $table (";
    $str .= "\n" . 'pk_audit' . " " . 'int4' . " " . "NOT NULL DEFAULT nextval('tbl_audit_pk_audit_seq'::regclass) " . ",";    
    $str .= "\n" . 'nombre_tabla' . " " . 'text' . " " .'NOT NULL' . ",";                  
    $str .= "\n" . 'operacion' . " " . 'character(1)' . " " . 'NOT NULL' .",";                  
    $str .= "\n" . 'valor_anterior' . " " . 'text' . ",";                  
    $str .= "\n" . 'valor_nuevo' . " " . 'text' . ",";                  
    $str .= "\n" . 'fecha_cambio' . " " . 'timestamp' . " " .'NOT NULL' . ",";                  
    $str .= "\n" . 'usuario' . " " . 'text' . " " .'NOT NULL' ;                      

    $str=rtrim($str, ",");  
    $str .= "\n);\n";
    $str .= "\n--\n";
    $str .= "-- Creating data for '$table'";
    $str .= "\n--\n\n";
    $res3 = pg_query("SELECT * FROM $table");
    while($r = pg_fetch_row($res3))
    {
      $sql = "INSERT INTO $table VALUES ('";
      $sql .= utf8_decode(implode("','",$r));
      $sql .= "');";
      $str = str_replace("''","NULL",$str);
      $str .= $sql;  
      $str .= "\n";
    }       
     $res1 = pg_query("SELECT pg_index.indisprimary,
            pg_catalog.pg_get_indexdef(pg_index.indexrelid)
        FROM pg_catalog.pg_class c, pg_catalog.pg_class c2,
            pg_catalog.pg_index AS pg_index
        WHERE c.relname = '$table'
            AND c.oid = pg_index.indrelid
            AND pg_index.indexrelid = c2.oid
            AND pg_index.indisprimary");
    while($r = pg_fetch_row($res1))
    {
    $str .= "\n\n--\n";
    $str .= "-- Creating index for '$table'";
    $str .= "\n--\n\n";
    $t = str_replace("CREATE UNIQUE INDEX", "", $r[1]);
    $t = str_replace("USING btree", "|", $t);
    // Next Line Can be improved!!!
    $t = str_replace("ON", "|", $t);
    $Temparray = explode("|", $t);
    $str .= "ALTER TABLE ONLY ". $Temparray[1] . " ADD CONSTRAINT " . 
$Temparray[0] . " PRIMARY KEY " . $Temparray[2] .";\n";
  } 
  $table = 'tipo_documento';
    $str .= "\n--\n";
    $str .= "-- Estrutura de la tabla '$table'";
    $str .= "\n--\n";
    $str .= "\nDROP TABLE $table CASCADE;";
    $str .= "\nCREATE TABLE $table (";
    $str .= "\n" . 'id_tipo_documento' . " " . 'int4' . " " . 'NOT NULL' . ",";    
    $str .= "\n" . 'codigo_doc' . " " . 'text' . ",";                  
    $str .= "\n" . 'nombre_doc' . " " . 'text' . ",";                  
    $str .= "\n" . 'estado_doc' . " " . 'text';                      

    $str=rtrim($str, ",");  
    $str .= "\n);\n";
    $str .= "\n--\n";
    $str .= "-- Creating data for '$table'";
    $str .= "\n--\n\n";
    $res3 = pg_query("SELECT * FROM $table");
    while($r = pg_fetch_row($res3))
    {
      $sql = "INSERT INTO $table VALUES ('";
      $sql .= utf8_decode(implode("','",$r));
      $sql .= "');";
      $str = str_replace("''","NULL",$str);
      $str .= $sql;  
      $str .= "\n";
    }       
     $res1 = pg_query("SELECT pg_index.indisprimary,
            pg_catalog.pg_get_indexdef(pg_index.indexrelid)
        FROM pg_catalog.pg_class c, pg_catalog.pg_class c2,
            pg_catalog.pg_index AS pg_index
        WHERE c.relname = '$table'
            AND c.oid = pg_index.indrelid
            AND pg_index.indexrelid = c2.oid
            AND pg_index.indisprimary");
    while($r = pg_fetch_row($res1))
    {
    $str .= "\n\n--\n";
    $str .= "-- Creating index for '$table'";
    $str .= "\n--\n\n";
    $t = str_replace("CREATE UNIQUE INDEX", "", $r[1]);
    $t = str_replace("USING btree", "|", $t);
    // Next Line Can be improved!!!
    $t = str_replace("ON", "|", $t);
    $Temparray = explode("|", $t);
    $str .= "ALTER TABLE ONLY ". $Temparray[1] . " ADD CONSTRAINT " . 
$Temparray[0] . " PRIMARY KEY " . $Temparray[2] .";\n";
  } 
  $table = 'tipo_usuario';
    $str .= "\n--\n";
    $str .= "-- Estrutura de la tabla '$table'";
    $str .= "\n--\n";
    $str .= "\nDROP TABLE $table CASCADE;";
    $str .= "\nCREATE TABLE $table (";
    $str .= "\n" . 'id_tipo_usuario' . " " . 'int4' . " " . 'NOT NULL' . ",";    
    $str .= "\n" . 'nombre_tipo' . " " . 'text';                      

    $str=rtrim($str, ",");  
    $str .= "\n);\n";
    $str .= "\n--\n";
    $str .= "-- Creating data for '$table'";
    $str .= "\n--\n\n";
    $res3 = pg_query("SELECT * FROM $table");
    while($r = pg_fetch_row($res3))
    {
      $sql = "INSERT INTO $table VALUES ('";
      $sql .= utf8_decode(implode("','",$r));
      $sql .= "');";
      $str = str_replace("''","NULL",$str);
      $str .= $sql;  
      $str .= "\n";
    }       
     $res1 = pg_query("SELECT pg_index.indisprimary,
            pg_catalog.pg_get_indexdef(pg_index.indexrelid)
        FROM pg_catalog.pg_class c, pg_catalog.pg_class c2,
            pg_catalog.pg_index AS pg_index
        WHERE c.relname = '$table'
            AND c.oid = pg_index.indrelid
            AND pg_index.indexrelid = c2.oid
            AND pg_index.indisprimary");
    while($r = pg_fetch_row($res1))
    {
    $str .= "\n\n--\n";
    $str .= "-- Creating index for '$table'";
    $str .= "\n--\n\n";
    $t = str_replace("CREATE UNIQUE INDEX", "", $r[1]);
    $t = str_replace("USING btree", "|", $t);
    // Next Line Can be improved!!!
    $t = str_replace("ON", "|", $t);
    $Temparray = explode("|", $t);
    $str .= "ALTER TABLE ONLY ". $Temparray[1] . " ADD CONSTRAINT " . 
$Temparray[0] . " PRIMARY KEY " . $Temparray[2] .";\n";
  } 
  $table = 'usuario';
    $str .= "\n--\n";
    $str .= "-- Estrutura de la tabla '$table'";
    $str .= "\n--\n";
    $str .= "\nDROP TABLE $table CASCADE;";
    $str .= "\nCREATE TABLE $table (";
    $str .= "\n" . 'id_usuario' . " " . 'int4' . " " . 'NOT NULL' . ",";    
    $str .= "\n" . 'cod_usuario' . " " . 'text' . ",";                      
    $str .= "\n" . 'nombres_usuario' . " " . 'text' . ",";                      
    $str .= "\n" . 'direccion_usuario' . " " . 'text' . ",";                      
    $str .= "\n" . 'id_ciudad' . " " . 'int4' . ",";                      
    $str .= "\n" . 'telefono_usuario' . " " . 'text' . ",";                      
    $str .= "\n" . 'celular_usuario' . " " . 'text' . ",";                      
    $str .= "\n" . 'email_usuario' . " " . 'text' . ",";                      
    $str .= "\n" . 'id_tipo_user' . " " . 'int4' . ",";                      
    $str .= "\n" . 'nick_usuario' . " " . 'text' . ",";                      
    $str .= "\n" . 'fecha' . " " . 'text' . ",";                      
    $str .= "\n" . 'institucion' . " " . 'text' . ",";                      
    $str .= "\n" . 'id_categoria' . " " . 'int4' . ",";                          
    $str .= "\n" . 'id_departamento' . " " . 'int4' . ",";  
    $str .= "\n" . 'tipo_sangre' . " " . 'text' . ",";  
    $str .= "\n" . 'fecha_nacimiento' . " " . 'text' . ",";  
    $str .= "\n" . 'sexo' . " " . 'text' . ",";  
    $str .= "\n" . 'estado_civil' . " " . 'text';  
    $str=rtrim($str, ",");  
    $str .= "\n);\n";    
    $str .= "\n--\n";    
    $str .= "-- Creating data for '$table'";
    $str .= "\n--\n\n";
    $res3 = pg_query("SELECT * FROM $table");
    while($r = pg_fetch_row($res3))
    {
      $sql = "INSERT INTO $table VALUES ('";
      $sql .= utf8_decode(implode("','",$r));
      $sql .= "');";
      $str = str_replace("''","NULL",$str);
      $str .= $sql;  
      $str .= "\n";
    }       
     $res1 = pg_query("SELECT pg_index.indisprimary,
            pg_catalog.pg_get_indexdef(pg_index.indexrelid)
        FROM pg_catalog.pg_class c, pg_catalog.pg_class c2,
            pg_catalog.pg_index AS pg_index
        WHERE c.relname = '$table'
            AND c.oid = pg_index.indrelid
            AND pg_index.indexrelid = c2.oid
            AND pg_index.indisprimary");
    while($r = pg_fetch_row($res1))
    {
    $str .= "\n\n--\n";
    $str .= "-- Creating index for '$table'";
    $str .= "\n--\n\n";
    $t = str_replace("CREATE UNIQUE INDEX", "", $r[1]);
    $t = str_replace("USING btree", "|", $t);
    // Next Line Can be improved!!!
    $t = str_replace("ON", "|", $t);
    $Temparray = explode("|", $t);
    $str .= "ALTER TABLE ONLY ". $Temparray[1] . " ADD CONSTRAINT " . 
$Temparray[0] . " PRIMARY KEY " . $Temparray[2] .";\n";
  } 
  //////////////////////////////
  
  /////////////////////////////// 
  $res = pg_query(" SELECT
  cl.relname AS tabela,ct.conname,
   pg_get_constraintdef(ct.oid)
   FROM pg_catalog.pg_attribute a
   JOIN pg_catalog.pg_class cl ON (a.attrelid = cl.oid AND cl.relkind = 'r')
   JOIN pg_catalog.pg_namespace n ON (n.oid = cl.relnamespace)
   JOIN pg_catalog.pg_constraint ct ON (a.attrelid = ct.conrelid AND
   ct.confrelid != 0 AND ct.conkey[1] = a.attnum)
   JOIN pg_catalog.pg_class clf ON (ct.confrelid = clf.oid AND 
clf.relkind = 'r')
   JOIN pg_catalog.pg_namespace nf ON (nf.oid = clf.relnamespace)
   JOIN pg_catalog.pg_attribute af ON (af.attrelid = ct.confrelid AND
   af.attnum = ct.confkey[1]) order by cl.relname ");
  while($row = pg_fetch_row($res))
  {
    $str .= "\n\n--\n";
    $str .= "-- Creating relacionships for '".$row[0]."'";
    $str .= "\n--\n\n";
    $str .= "ALTER TABLE ONLY ".$row[0] . " ADD CONSTRAINT " . $row[1] . 
" " . $row[2] . ";";
  }     
  ////////////////////
  

  /////////////////
  $str .= "\nCREATE TRIGGER tbl_accesos_tg_audit AFTER INSERT OR DELETE OR UPDATE ON accesos FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();";
  $str .= "\nCREATE TRIGGER tbl_aplicaciones_tg_audit AFTER INSERT OR DELETE OR UPDATE ON aplicaciones FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();";
  $str .= "\nCREATE TRIGGER tbl_archivo_tg_audit AFTER INSERT OR DELETE OR UPDATE ON archivo FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();";
  $str .= "\nCREATE TRIGGER tbl_bitacora_tg_audit AFTER INSERT OR DELETE OR UPDATE ON bitacora FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();";
  $str .= "\nCREATE TRIGGER tbl_categorias_tg_audit AFTER INSERT OR DELETE OR UPDATE ON categorias FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();";
  $str .= "\nCREATE TRIGGER tbl_ciudad_tg_audit AFTER INSERT OR DELETE OR UPDATE ON ciudad FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();";
  $str .= "\nCREATE TRIGGER tbl_clave_tg_audit AFTER INSERT OR DELETE OR UPDATE ON clave FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();";
  $str .= "\nCREATE TRIGGER tbl_departamento_tg_audit AFTER INSERT OR DELETE OR UPDATE ON departamento FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();";
  $str .= "\nCREATE TRIGGER tbl_medio_recepcion_tg_audit AFTER INSERT OR DELETE OR UPDATE ON medio_recepcion FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();";
  $str .= "\nCREATE TRIGGER tbl_metas_tg_audit AFTER INSERT OR DELETE OR UPDATE ON metas FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();";
  $str .= "\nCREATE TRIGGER tbl_pais_tg_audit AFTER INSERT OR DELETE OR UPDATE ON pais FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();";
  $str .= "\nCREATE TRIGGER tbl_provincias_tg_audit AFTER INSERT OR DELETE OR UPDATE ON provincias FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();";
  $str .= "\nCREATE TRIGGER tbl_recibidos_tg_audit AFTER INSERT OR DELETE OR UPDATE ON recibidos FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();";
  $str .= "\nCREATE TRIGGER tbl_tipo_documento_tg_audit AFTER INSERT OR DELETE OR UPDATE ON tipo_documento FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();";
  $str .= "\nCREATE TRIGGER tbl_tipo_usuario_tg_audit AFTER INSERT OR DELETE OR UPDATE ON tipo_usuario FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();";
  $str .= "\nCREATE TRIGGER tbl_usuario_tg_audit AFTER INSERT OR DELETE OR UPDATE ON usuario FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();";
  ////////////////  
  fwrite($back,$str);
  fclose($back);
  dl_file("$dbname.sql");
  
}

?>
 