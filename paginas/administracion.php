<?php
    session_start();          
    if (empty($_SESSION['id']) || $_SESSION['nivel']!="ADMINISTRADOR") {
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
<script type="text/javascript" src="../librerias/cargarAdministracion.js"></script> 
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
                        <a href="administracion.php" id="docRecibidos"><li>Administración</li></a>
                        <hr>                      
                        <a href="datos_personales.php" id=""><li>Editar Datos Personales</li></a>
                        <br>
                        <a href="#" id="cambiar_c"><li>Cambiar contraseña</li></a>
                        <br>
                        <a href="../procesos/salir_sistema.php"><li>Salir</li></a>
                        <input type="hidden" id="contador" value="0">
                    </ul>                                                             
                </div>                    
               <div id="menu_medio" class="grid_9 alpha omega">
                    <div class="clear"></div><br>
                    <div class="grid_9" align="center">
                        <input type="text" class="grid_5" readonly  name="nombreUsuario" id="nombreUsuario" value="" placeholder="">                        
                        <input type="hidden" id="repetir" value="">
                        <div class="4">
                            <button id="btnBuscarUser" class="button glow button-rounded button-flat-action"><i class="fa fa-search"></i> Buscar Usuario</button>                           
                        </div>
                    </div>                    
                    <div class="grid_9 alpha omega" align="center">
                        <table id="tablaNuevo" >                    
                            <thead>
                                <tr>                                
                                    <th>Código Acceso</th>
                                    <th>Acceso</th>                     
                                    <th>Estado</th>                                                                                            
                                </tr>
                            </thead>
                            <tbody>
                               <tr>
                               </tr>
                            </tbody>
                        </table>                   
                    </div>  
                     <div class="clear"></div><br>                                     
                     <div class="grid_9 alpha omega" align="center">
                        <button id="btnGuardar"  class="button glow button-rounded button-flat-action"><i class="fa fa-save"></i> Guardar Cambios</button> 
                     </div>
                    
               </div>                                       
            </div>                                                   
        </div>        
    </header>
    <footer class="container">
        <div class="grid_12">
            <h2>Copyrigth 2014 Xavier Quilka MIES(Ministerio de Inclusión Económica y Social)</h2>    
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
</div>  
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