<?php
    session_start();          
    if (empty($_SESSION['id'])) {
    header('Location: index.php');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Gestión Documental</title>
<link rel="stylesheet" type="text/css" href="../css/base.css"/>
<link rel="stylesheet" type="text/css" href="../css/grid.css"/>
<link rel="stylesheet" type="text/css" href="../css/normalize.css"/>
<link rel="stylesheet" type="text/css" href="../css/style.css"/>
<link rel="stylesheet" type="text/css" href="../css/estilos.css"/>
<link rel="stylesheet" type="text/css" href="../css/font-awesome.css"/>
<link rel="stylesheet" type="text/css" href="../css/buttons.css"/>
<link rel="stylesheet" type="text/css" href="../css/jquery-ui-1.10.3.custom.css"/>
<link rel="stylesheet" type="text/css" href="../css/ui.jqgrid.css"/>
<link rel="stylesheet" type="text/css" href="../css/menu.css"/>
<script type="text/javascript" src="../js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.10.3.custom.min.js"></script>
<script type="text/javascript" src="../js/jquery.jqGrid.min.js"></script>
<script type="text/javascript" src="../js/grid.locale-es.js"></script>
<script type="text/javascript" src="../js/modernizr-2.6.2.min.js"></script>
<script type="text/javascript" src="../js/prefixfree.min.js"></script>
<script type="text/javascript" src="../js/base_64.js"></script> 
<script type="text/javascript" src="../librerias/mod_user.js"></script> 
<script type="text/javascript" src="../librerias/funciones.js"></script> 
<script type="text/javascript" src="../librerias/cambioPass.js"></script> 
<script type="text/javascript" src="../librerias/num_envios.js"></script> 
</head>
<body>
    <header>
        <div class="container">           
            <h1 id="logo" class="grid_5 suffix_7"><a href="#">
                <img src="../imagenes/logo.png" /><span>Logotipo</span></a>                       
            </h1>
            <div class="grid_12" id="usuario">
                <label class="grid_2" for="datosUser">Usuario:</label>
                <input class="grid_10" type="text" name="datosUser" id="datosUser" value="<?php
                $var= "   ".$_SESSION['nombres']." / Código : ".$_SESSION['cod']."/ Tipo Usuario : ".$_SESSION['nivel']." / Nombre Usuario : ".$_SESSION['usuario'];                    
                echo $var;
                ?>" readonly>            
            </div>            
            <div class="clear"></div>           
            <div class="grid_12" id="menuPrincipal"> 
          <?php               
                //include("menu.html");                
                include("../procesos/cargar_menu.php")   
            ?>                                               
            </div>
            <div class="clear"></div>                      
            <div class="grid_12" id="formularios">     
                <div class="grid_3 alhpa omega" id="menu_lateral">
                    <ul id="menuGestion">
                        <a href="gestion.php"><li>Nuevo Documento</li></a>
                        <hr>
                        <a href="#" id="bandeja"><li>Bandeja</li></a>
                        <hr>
                        <a href="doc_enviados.php" id=""><li id="dc">Documentos Enviados</li></a>
                        <br>
                        <a href="doc_recibidos.php" id=""><li id="de">Documentos Recibidos</li></a>
                        <br>
                         <?php
                        if($_SESSION['nivel']=="ADMINISTRADOR"){
                            echo " <a href='administracion.php' id=''> <li>Administración</li></a>";
                        }
                        else{
                            echo "<a href='administracion.php' id='administracion'><li>Administración</li></a>";   
                        }      
                        ?>
                        <hr>
                        <a href="datos_personales.php" id="docRecibidos"><li>Editar Datos Personales</li></a>
                        <br>
                        <a href="#" id="cambiar_c"><li>Cambiar contraseña</li></a>
                        <br>
                        <a href="../procesos/salir_sistema.php"><li>Salir</li></a>
                        <input type="hidden" id="contador" value="0">
                    </ul>                                                             
                </div>                    
               <div id="menu_medio" class="grid_9 alpha omega">
                    <form id="form1" method="post">                                 
                        <h2 class="grid_5 suffix_2 prefix_2 omega alpha"><label>INGRESO DE USUARIOS</label></h2>           <input type="hidden" class="grid_3" id="id_user" name="id_user" required/>     
                        <br>
                        <h3 class="grid_2" ><label for="cod_user">Cod. Usuario:</label></h3>
                        <input type="text" class="grid_2" id="cod_user" name="cod_user" readonly />                   
                        <h3 class="grid_2"><label for="nombre_user">Nombre Completo:</label></h3>
                        <input type="text" class="grid_3" id="nombre_user" name="nombre_user" required/>                   
                        <div class="clear"></div><br>
                        <h3 class="grid_2"><label for="tel_user">Nro. Teléfono:</label></h3>
                        <input type="text" class="grid_2" id="tel_user" name="tel_user" />
                        <h3 class="grid_2"><label for="dir_user">Dirección Usuario:</label></h3>
                        <input type="text" class="grid_3" id="dir_user" name="dir_user" required/>
                        <div class="clear"></div><br>
                        <h3 class="grid_2"><label for="cel_user">Nro. Celular:</label></h3>
                        <input type="text" class="grid_2" id="cel_user" name="cel_user" />
                        <h3 class="grid_2"><label for="mail_user">Email Usuario:</label></h3>
                        <input type="email" class="grid_3" id="mail_user" name="mail_user" required/>
                        <div class="clear"></div><br>
                        <h3 class="grid_2"><label for="pais_user">Pais:</label></h3>
                        <select class="grid_2" id="pais_user" name="pais_user" required>

                        </select>
                        <h3 class="grid_2"><label for="user_name">Nombre Usuario:</label></h3>
                        <input type="text" class="grid_3" id="user_name" name="user_name" required />
                        <div class="clear"></div><br>
                        <h3 class="grid_2"><label for="provincia_user">Provincia:</label></h3>
                        <select  class="grid_2" id="provincia_user" name="provincia_user" required >
                        </select>
                        <h3 class="grid_2"><label for="tipo_user">Tipo Usuario:</label></h3>
                        <select class="grid_3" id="tipo_user" name="tipo_user" required >
                        </select>
                        <div class="clear"></div><br>
                        <h3 class="grid_2"><label for="ciudad_user">Ciudad:</label></h3>
                        <select  class="grid_2" id="ciudad_user" name="ciudad_user" required>
                        </select>
                        <h3 class="grid_2"><label for="institucion">Institución:</label></h3>
                        <input type="text" class="grid_3" id="institucion" name="institucion" required/>                    
                        <div class="clear"></div><br>                    
                        <h3 class="grid_2"><label for="categoria_user">Categoría:</label></h3>
                        <select  class="grid_2" id="categoria_user" name="categoria_user" required>
                        </select>                        
                        <h3 class="grid_2"><label for="departamento_user">Departamento:</label></h3>
                        <select class="grid_3" id="departamento_user" name="departamento_user">                    
                        </select>                    
                        <div class="clear"></div><br>
                        <h3 class="grid_2"><label for="tipo_sangre_user">Tipo de Sangre:</label></h3>
                        <select class="grid_2" id="tipo_sangre_user" name="tipo_sangre_user" required>                    
                            <option value="o-"> O -</option>
                            <option value="o+"> O +</option>
                            <option value="a-"> A -</option>
                            <option value="a+"> A +</option>
                            <option value="b-"> B -</option>
                            <option value="b+"> B +</option>
                            <option value="ab-"> AB -</option>
                            <option value="ab+"> AB +</option>
                        </select>
                        <h3 class="grid_2"><label for="fecha_nacimiento">Fecha Nacimiento:</label></h3>
                        <input type="text" class="grid_3" id="fecha_nacimiento" name="fecha_nacimiento" required/>                                
                        <div class="clear"></div><br>
                        <h3 class="grid_2"><label for="sexo">Sexo:</label></h3>
                        <select class="grid_2" id="sexo" name="sexo" required>                    
                            <option value="masculino"> Masculino</option>   
                            <option value="femenino"> Femenino</option>
                        </select>
                        <h3 class="grid_2"><label for="estado_civil">Estado Civil:</label></h3>
                        <select class="grid_3" id="estado_civil" name="estado_civil" required>                    
                            <option value="soltero"> Soltero (a)</option>   
                            <option value="casado"> Casado (a)</option>
                            <option value="divorciado"> Divorciado (a)</option>
                            <option value="viudo"> Viudo (a)</option>
                        </select>
                        <div class="clear"></div><br>
                        <div id="botones" class="grid_5 prefix_3 alpha omega">
                            <button id="bntModificar" class="button glow button-rounded button-flat-action"><i class="fa fa-save"></i> Modificar datos usuario</button>                        
                        </div>    
                    </form>                       
               </div>                        
            </div>                                                   
        </div>        
    </header>
    <footer class="container">
        <div class="grid_12">
            <h2>Copyrigth 2014 Willy Narváez Universidad Regional Autónoma de los Andes "Uniandes"</h2> 
        </div>        
    </footer>
</body>
</html>
<div id='frmCambioPass' title="Cambio de clave de acceso">
        <div class="input-group margin-bottom-sm">
            <span class="input-group-addon"><i class="fa fa-key fa-fw"></i></span>
            <input class="form-control"  id="txtPass1" type="password" readonly>
        </div>        
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-key fa-fw"></i></span>
            <input class="form-control" id="txtPass2" type="password" placeholder="Ingrese Contraseña actual" required>
        </div>  
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-key fa-fw"></i></span>
            <input class="form-control" id="txtPass3" type="password" placeholder="Nueva Contraseña" required>
        </div>                              
        <div id="botones1">
            <a href="#" id="btnNuevaPass" class="button glow button-rounded button-flat-action"><i class="fa fa-check"></i> Cambiar Clave</a>            
        </div>       