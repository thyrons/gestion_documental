<?php    
    include 'base.php'; 
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
    conectarse();   
    $data=0;     
    $cont=0;
    $r=0;
    $contador=0;
    $c=0;
    $cadena1=$_POST['vect1'];
    $cadena2=$_POST['vect2'];
    $cadena3=$_POST['vect3']; 
    if($cadena1{0}==","){
        $cadena1=substr($cadena1, 1);
    }     
    if($cadena2{0}==","){
        $cadena2=substr($cadena2, 1);
    }    
    if($cadena3{0}==","){
        $cadena3=substr($cadena3, 1);
    }        
    while($r==0){
      if($cadena1{$contador}==","){
        $c++;        
      }
      else{
        $r=1;
      }
      $contador++;
    }
    $cadena1=substr($cadena1,$c);
    $cadena2=substr($cadena2,$c);
    
    $lista1 = explode(",", $cadena1);    
    $lista2 = explode(",", $cadena2);   
    $lista1 = explode(",,", $cadena1);    
    $lista1 = explode(",,", $cadena1);    
    $lista2 = explode(",,", $cadena2);   
    $lista3 = explode(",", $cadena3);



   //print "<pre>"; print_r($lista2); print "</pre>\n";
   //echo "select * from accesos where id_usuario='$_SESSION[id]' order by id_acceso asc";
   $consulta=pg_query("select id_acceso,accesos.id_usuario,nombres_usuario,aplicaciones.id_aplicacion,nombre_aplicacion,accesos.estado from accesos,usuario,aplicaciones where accesos.id_usuario=usuario.id_usuario and accesos.id_aplicacion=aplicaciones.id_aplicacion and accesos.id_usuario='$_POST[id]' order by id_acceso asc");
   while($row=pg_fetch_row($consulta)){
      $anterior=$row[0].",".$row[2].",".$row[4].",".$row[5];      
      $nuevo=$lista1[$cont].",".$row[2].",".$row[4].",".$lista3[$cont];
      pg_query("insert into auditoria_sistema values ('$id_audi','$_SESSION[usuario] $_SESSION[id]','$fecha','accesos','Update','$anterior','$nuevo','Modificacion de un acceso del usuario por algun administrador')");        
      $id_audi++;
      pg_query("update accesos set estado='$lista3[$cont]' where id_acceso='$lista1[$cont]' ");
      $cont++;
   }
   $data='1';
   echo $data;
   
?>
    