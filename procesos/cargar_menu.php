<?php       
 	include 'base.php';                 
    $cont=0;
    conectarse();     
    $contador=0;           
    $consulta=pg_query("select id_acceso,id_aplicacion,estado from accesos where id_usuario='$_SESSION[id]' order by id_acceso asc");
                while($row=pg_fetch_row($consulta)){
                    $matrizA[$cont]=$row[1];
                    $matrizB[$cont]=$row[2];                    
                    $cont++;
                }

                ////////dibujo el menu///                
                echo "<ul id='nav'>";
                echo "<li><a href='../paginas/bienvenido.php'><img src='../imagenes/home.png' /> Inicio</a></li>";
                $contador++;
                /////////////
                if($matrizB[0]=="a"){
                    echo "<li><a href=' ubicaciones.php'><span><img src='../imagenes/top3.png' /> Ubicaciones</span></a>";
                    $contador++;
                    echo "<div class='subs'>";
                    echo "<div class='col'>";
                    echo "<ul>";
                    echo "<li><a href='ubicaciones.php'><img src='../imagenes/bub.png' /> Países</a></li>";
                    echo "<li><a href='ubicaciones.php'><img src='../imagenes/bub.png' /> Provincias</a></li>";
                    echo "<li><a href='ubicaciones.php'><img src='../imagenes/bub.png' /> Ciudades</a></li>";    
                    echo "</ul>";
                    echo "</div>";              
                    echo "</div>";
                    echo "</li>";
                }
                ///////////
                if($matrizB[1]=='a')
                {
                    echo "<li><a href='varios.php'><span><img src='../imagenes/top4.png' /> Ingr. Varios</span></a>";
                    $contador++;
                    echo "<div class='subs'>";
                    echo "<div class='col'>";
                    echo "<ul>";
                    echo "<li><a href='varios.php'><img src='../imagenes/bub.png' /> Categorías</a></li>";
                    echo "<li><a href='varios.php'><img src='../imagenes/bub.png' /> Departamentos</a></li>";
                    echo "<li><a href='varios.php'><img src='../imagenes/bub.png' /> Recepción</a></li>";
                    echo "<li><a href='varios.php'><img src='../imagenes/bub.png' /> Tipos documentos</a></li>";    
                    echo "<li><a href='varios.php'><img src='../imagenes/bub.png' /> Tipos Usuarios</a></li>";   
                    if($matrizB[2]=='a'){
                        echo "<li><a href='usuarios.php'><img src='../imagenes/bub.png' /> Nuevos Usuarios</a></li>";
                    }
                    echo "</ul>";
                    echo "</div>";              
                    echo "</div>";
                    echo " </li>";
                }
                else{
                    if($matrizB[2]=='a'){
                        echo "<li><a href='usuarios.php'><img src='../imagenes/top3.png' /> Nuevos Usuarios</a></li>";                                                                               
                    }
                }
                ////////
                echo "<li><a href='gestion.php'><img src='../imagenes/top3.png' /> Gestión</a>";
                $contador++;
                echo "<div class='subs'>";
                echo "<div class='col'>";
                echo "<ul>";
                echo "<li><a href='gestion.php'><img src='../imagenes/bub.png' /> Enviar Documento</a></li>";
                echo "<li><a href='doc_enviados.php'><img src='../imagenes/bub.png' /> Doc. Enviados</a></li>";
                echo "<li><a href='doc_recibidos.php'><img src='../imagenes/bub.png' /> Doc. Recibidos</a></li>";                      
                if($matrizB[8]=='a'){
                    echo "<li><a href='restaurar_archivo.php'><img src='../imagenes/bub.png' /> Restaurar</a></li>";                      
                }
                echo "</ul>";
                echo "</div>";           
                echo "</div>";
                echo "</li>";    
                ///////////
                ///////////
                if($matrizB[3]=='a')                    
                {
                    echo "<li><a href='reportes.php'><img src='../imagenes/top2.png' /> Reportes</a>";                   
                    $contador++;
                    if($matrizB[4]=='a'){
                        echo "<div class='subs'>";
                        echo "<div class='col'>";
                        echo "<ul>";
                        echo "<li><a href='buscarTexto.php'><img src='../imagenes/bub.png' /> Buscar palabras</a></li>";
                        if($matrizB[6]=='a'){
                            echo "<li><a href='../procesos/backup.php'><img src='../imagenes/bub.png' /> Respaldo</a></li>";
                        }   
                        if($matrizB[7]=='a'){
                            echo "<li><a href='graficos.php'><img src='../imagenes/bub.png' /> Gráficos</a></li>";
                        }    
                        echo "</ul>";
                        echo "</div>";
                        echo "</div>";
                    }                      
                    echo "</li>";
                }
                else{                  
                    if($matrizB[4]=='a'){
                        echo "<li><a href='#'><img src='../imagenes/top2.png' /> Reportes</a>";                   
                        $contador++;
                        echo "<div class='subs'>";
                        echo "<div class='col'>";
                        echo "<ul>";
                        echo "<li><a href='buscarTexto.php'><img src='../imagenes/bub.png' /> Buscar palabras</a></li>";
                        if($matrizB[6]=='a'){
                            echo "<li><a href='../procesos/backup.php'><img src='../imagenes/bub.png' /> Respaldo</a></li>";
                        }
                        if($matrizB[7]=='a'){
                            echo "<li><a href='graficos.php'><img src='../imagenes/bub.png' /> Gráficos</a></li>";
                        } 
                        echo "</ul>";
                        echo "</div>";
                        echo "</div>";
                        echo "</li>";     
                    }
                    else{
                        if($matrizB[6]=='a'){
                            echo "<li><a href='#'><img src='../imagenes/top2.png' /> Reportes</a>";                   
                            $contador++;
                            echo "<div class='subs'>";
                            echo "<div class='col'>";
                            echo "<ul>";                    
                            echo "<li><a href='../procesos/backup.php'><img src='../imagenes/bub.png' /> Respaldo</a></li>";                        
                            echo "</ul>";
                            echo "</div>";
                            echo "</div>";
                            echo "</li>";     
                        }       
                    }                                                                                                 
                }                  
                              
                /////////////
                if($matrizB[5]=='a'){
                    echo "<li><a href='datos_personales.php' id=''><img src='../imagenes/top4.png' /> Datos usuario</a>";                    
                    $contador++;
                    echo "<div class='subs'>";                    
                    echo "<div class='col'>";
                    echo "<ul>";
                    echo "<li><a href='../procesos/salir_sistema.php'><img src='../imagenes/bub.png' /> Salir del Sistema</a></li>";
                    echo "</ul>";
                    echo "</div>";
                    echo "</div>";
                    echo "</li>";
                    
                }
                else{
                    echo "<li><a href='#' id=''><img src='../imagenes/top4.png' /> Datos usuario</a>";                    
                    $contador++;
                    echo "<div class='subs'>";                    
                    echo "<div class='col'>";
                    echo "<ul>";
                    echo "<li><a href='salir_sistema.php'><img src='../imagenes/bub.png' /> Salir del Sistema</a></li>";
                    echo "</ul>";
                    echo "</div>";
                    echo "</div>";
                    echo "</li>";                    
                }
                echo "</ul>";
                ////////////////////////
?>