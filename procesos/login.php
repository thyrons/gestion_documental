<?php
  include 'base.php';	
  $data=0;
  conectarse();
	session_start();
  
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
	if(trim($_POST["user"]) != "" && trim($_POST["pass"]) != "")
	{
		$usuario = $_POST["user"];
 		$password = $_POST["pass"];   
 		$result = pg_query("select clave,nick_usuario,nombre_tipo,id_usuario,nombres_usuario, cod_usuario,institucion from usuario,tipo_usuario,clave where usuario.id_tipo_user=tipo_usuario.id_tipo_usuario and clave.usuario=usuario.id_usuario and usuario.nick_usuario='$usuario'");
 		if($row = pg_fetch_array($result)){
  			if($row["clave"] == $password){
   				$_SESSION["usuario"] = $row[1];
   				$_SESSION["id"] = $row[3];   					
          $_SESSION["nivel"] = $row[2]; 
          $_SESSION["nombres"] = $row[4]; 
          $_SESSION["cod"] = $row[5]; 
          $_SESSION["institucion"] = $row[6]; 
          ////auditoria//
          $sql_audi=pg_query("select id_usuario,cod_usuario,nombres_usuario,direccion_usuario,nombre_ciudad,telefono_usuario,celular_usuario,email_usuario,nombre_tipo,nick_usuario,fecha,institucion,nombre_categoria,nombre_departamento from usuario,ciudad,tipo_usuario,categorias,departamento where usuario.id_ciudad=ciudad.id_ciudad and usuario.id_tipo_user=tipo_usuario.id_tipo_usuario and categorias.id_categoria=usuario.id_categoria and usuario.id_departamento=departamento.id_departamento and usuario.id_usuario='$row[3]';");
          while ($row_audi=pg_fetch_row($sql_audi)) {
            $anterior=$row_audi[0].",".$row_audi[1].",".$row_audi[2].",".$row_audi[3].",".$row_audi[4].",".$row_audi[5].",".$row_audi[6].",".$row_audi[7].",".$row_audi[8].",".$row_audi[9].",".$row_audi[10].",".$row_audi[11].",".$row_audi[12].",".$row_audi[13];
            $nuevo=$row_audi[0].",".$row_audi[1].",".$row_audi[2].",".$row_audi[3].",".$row_audi[4].",".$row_audi[5].",".$row_audi[6].",".$row_audi[7].",".$row_audi[8].",".$row_audi[9].",".$fecha.",".$row_audi[11].",".$row_audi[12].",".$row_audi[13];
          }          
          //////////////
          pg_query("insert into auditoria_sistema values ('$id_audi','$row[1] $row[3]','$fecha','usuario','Update','$anterior','$nuevo','Ingreso del usuario al sistema')");  
          pg_query("update usuario set fecha='$fecha' where id_usuario='$row[3]'");           
          $data=0;
  			}else{
   				//echo 'Password incorrecto';
   				$data=1;
  			}
 		}else{
  			//echo 'Usuario no existente en la base de datos';
  			$data=2;
 		}
 		pg_free_result($result);
	}else{
 		//echo 'Debe especificar un usuario y password';
 		$data=3;
	}
	pg_close();	
	echo $data;	
?>