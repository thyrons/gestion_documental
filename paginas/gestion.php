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
<script type="text/javascript" src="../librerias/gestion.js"></script> 
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
                <div class="grid_3 alhpa omega" id="    ">
                    <ul id="menuGestion">
                        <a href="gestion.php" id="docRecibidos"><li>Nuevo Documento</li></a>
                        <hr>
                        <a href="#" id="bandeja"><li>Bandeja</li></a>
                        <hr>
                        <a href="doc_enviados.php"><li id="dc">Documentos Enviados</li></a>
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
                        <a href="datos_personales.php" id=""><li>Editar Datos Personales</li></a>
                        <br>
                        <a href="#" id="cambiar_c"><li>Cambiar contraseña</li></a>
                        <br>
                        <a href="../procesos/salir_sistema.php"><li>Salir</li></a>
                    </ul>
                    <button id="btnEnviar" class="button glow button-rounded button-flat-action"><i class="fa fa-sign-out"></i> Guardar Archivo</button>                           
                        
                </div>                    
                <form class="grid_9 alpha omega" id="menu_medio" name="menu_medio" 
            enctype="multipart/form-data" method="post" action="../procesos/guardarDoc.php">                       
                    <div class="grid_9 alpha omega">
                        <div class="grid_7 alpha omega">
                            <table id="tablaNuevo" class="tablaNuevo">                                
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Tipo Usuario</th>
                                        <th>Usuario</th>
                                        <th>Institución</th>
                                        <th style="display: none">id</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><b>De:</b></td>                                        
                                        <td><?php
                                            echo $_SESSION['nivel'];                    
                                        ?></td>
                                        <td><?php
                                            echo $_SESSION['usuario'];                    
                                        ?></td>
                                        <td><?php
                                            echo $_SESSION['institucion'];                    
                                        ?></td>
                                        <td style="display: none"><?php
                                            echo $_SESSION['id'];                    
                                        ?></td>                                       
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="grid_2 alpha omega">
                            <a href="#" id="btnBuscar1" class="button glow button-rounded button-flat-action"><i class="fa fa-search"></i> Buscar</a>                            
                        </div>

                    </div>
                    <div class="clear"></div>
                    <hr>                   
                    <div class="grid_9 alpha omega" id="datosArchivo">                                                
                        <h4 align="center" class="grid_9 alpha omega"><label>DATOS DEL DOCUMENTO</h4>                       
                        <h3 class="grid_2"><label for="fechaDoc">Nombre del documento:</label></h3>
                        <input type="text" class="grid_6" id="nombre_doc" name="nombre_doc" required/>                                                 
                        <div class="clear"></div><br>
                        <h3 class="grid_2"><label for="tipoDoc">Seleccione :</label></h3>
                        <input class="grid_6" type="file" name="archivoDoc" id="archivoDoc" value="" placeholder="Seleccione una archivo" required>                   
                        <div class="clear"></div><br>
                        <h3 class="grid_2"><label for="fechaDoc">Fecha de Registro:</label></h3>
                        <input type="text" class="grid_2" id="fechaDoc" name="fechaDoc" required/>                                                 
                        <h3 class="grid_2"><label for="tipoDoc">Tipo documento:</label></h3>
                        <select class="grid_3" id="tipoDoc" name="tipoDoc" >
                        </select>
                        <div class="clear"></div><br>
                        <h3 class="grid_2"><label for="departamentoDoc">Departamento:</label></h3>
                        <select class="grid_2" id="departamentoDoc" name="departamentoDoc" >   
                        </select>                                              
                        <h3 class="grid_2"><label for="asuntoDoc">Asunto:</label></h3>
                        <textarea class="grid_3 alpha omega" id="asuntoDoc" name="asuntoDoc" ></textarea>                            
                        <div class="clear"></div><br>
                        <h3 class="grid_2"><label for="estado_archivo">Estado:</label></h3>
                        <select class="grid_2" id="estado_archivo" name="estado_archivo" >   
                            <option value="0">En revisión</option>
                            <option value="1">Finalizado</option>                            
                        </select>                                              
                        <h3 class="grid_2"><label for="observaciones_archivo">Observaciones:</label></h3>
                        <textarea class="grid_3 alpha omega" id="observaciones_archivo" rows="4" name="observaciones_archivo" ></textarea>                            
                        <div class="clear"></div>
                        <hr>
                        <div  class="grid_5 alpha omega prefix_2">
                        <table id="tablaMeta">                            
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>                                    
                                </tr>
                            </tbody>
                        </table>
                        </div>
                         <div class="grid_2 alpha omega">
                            <a href="#" id="btnMeta" class="button glow button-rounded button-flat-action"><i class="fa fa-plus-square"></i> MetaDatos</a>                            
                        </div>                        
                    </div>
                </form>                                   
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
<div id='frmBuscador' title="Búsqueda de usuarios">   
    <h3 align="center">BÚSQUEDA DE USUARIOS</h3>                     
        <label class="label_b">Buscar por:</label>         
        <select id="buscador_por">
            <option value="nombres_usuario">Nombres Completos</option>
            <option value="nick_usuario">Nombre Usuario</option>      
            <option value="nombre_tipo">Categoría</option>                
        </select>  
    <input  id="buscar_p"/>            
    <br>         
    <table id="list" align="center"></table>
    <div id="pager"></div> 
    <br>                                  
</div>  
<div id='frmMeta' title="Ingreso de Metados">   
    <h3 align="center">METADATOS DEL DOCUMENTO</h3>                             
        <input type="text" name="" id="NombreM" placeholder="Nombre Etiqueta">        
        <input type="text" name="" id="DescM" placeholder="Descripcion de la Etiqueta">
        <br>
        <a href="#" id="btnAgregarMeta" class="button glow button-rounded button-flat-action"><i class="fa fa-sign-out"></i> Agregar</a>                                       
        <br>                                  
</div>  
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