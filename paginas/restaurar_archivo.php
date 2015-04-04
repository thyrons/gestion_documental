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
<script type="text/javascript" src="../librerias/restaurar.js"></script> 
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
                        <a href="doc_enviados.php" id="docRecibidos"><li id="dc">Documentos Enviados</li></a>
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
                        <input type="hidden" id="contador" value="0">
                    </ul>                                                             
                </div>                    
               <div id="menu_medio" class="grid_9 alpha omega">                        
                    <table id="list"></table>                                      
                    <div id="pager"></div>                          
                    <div class="clear"></div><br>                    
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
<div id='frmProcesos' title="Procesos">                                          
        <a href="#" id="btnHoja" class="button glow button-rounded button-flat-action"><i class="fa fa-bolt"></i> Hoja de Ruta</a>                                       
        <br><br>                                                                  
        <a href="#" id="btnVer" class="button glow button-rounded button-flat-action"><i class="fa fa-file-text-o"></i> Ver Archivo</a>                                       
        <br><br>      
        <a href="#" id="btnHistorial" class="button glow button-rounded button-flat-action"><i class="fa fa-files-o"></i> Historial</a>                                               
        <br><br>                                      
        <a href="#" id="btnDescargar" class="button glow button-rounded button-flat-action"><i class="fa fa-download"></i> Descargar Archivo</a>                                       
        <br><br>      
        <a href="#" id="btnRestaurar" class="button glow button-rounded button-flat-action"><i class="fa fa-undo"></i> Cambiar Estado</a>                                               
</div> 