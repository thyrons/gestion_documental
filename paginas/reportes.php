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
<script type="text/javascript" src="../js/highcharts.js"></script> 
<script type="text/javascript" src="../js/exporting.js"></script> 
<script type="text/javascript" src="../librerias/reportes.js"></script> 
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
                        <a href="gestion.php" id=""><li>Nuevo Documento</li></a>
                        <hr>
                        <a href="#" id="bandeja"><li>Bandeja</li></a>
                        <hr>
                        <a href="doc_enviados.php"><li id="dc" >Documentos Enviados</li></a>
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
                </div>                   
                <div class="grid_9 alpha omega" id="menu_medio" name="menu_medio">                       
                   <fieldset>
                        <legend>Reporte por fechas</legend>
                        <input id="txt_fecha1" type="text" placeholder="Fecha Inicio" required>
                        <input id="txt_fecha2" type="text" placeholder="Fecha Final" required>
                        <a href="#"  id="btn_reporte_fecha" class="button glow button-rounded button-flat-action"><i class="fa fa-print"></i> Reporte</a>            
                    </fieldset> 
                     <fieldset>
                        <legend>Tipos de documentos</legend>   
                        <select id="tipo">
                            <option value="application/pdf"> Archivos PDF </option>
                            <option value="application/octet-stream"> Aplicaciones ejecutables </option>
                            <option value="application/zip"> Aplicaciones ZIP </option>
                            <option value="application/msword"> Archivos de word 2003 </option>
                            <option value="application/vnd.ms-excel"> Archivos de excel 2003 </option>
                            <option value="application/vnd.ms-powerpoint"> Archivos de power point 2003 </option>
                            <option value="image/gif"> Imágenes gif </option>
                            <option value="image/png"> Imágenes png (image/png) </option>
                            <option value="image/jpg"> Imágenes jpeg (image/jpg) </option>
                            <option value="image/jpg"> Imágenes jpg (image/jpg) </option>
                            <option value="application/vnd.openxmlformats-officedocument.wordprocessingml.document"> Microsoft Office Word 2013 </option>
                            <option value="application/vnd.openxmlformats-officedocument.wordprocessingml.template"> Microsoft Office Plantillas 2013 </option>
                            <option value="application/vnd.openxmlformats-officedocument.presentationml.presentation"> Microsoft Office Power Point 2013 </option>
                            <option value="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"> Microsoft Office Excel 2013 </option>
                        </select>
                        <a href="#" id="btn_reporte_tipo" class="button glow button-rounded button-flat-action"><i class="fa fa-print"></i> Reporte</a>            
                    </fieldset> 
                    <fieldset>
                        <legend>Reporte por dia</legend>
                        <input id="txt_fecha3" type="text" placeholder="Fecha Inicio" required>
                        <input id="txt_fecha4" type="text" placeholder="Fecha Final" required>
                        <a href="#" id="btn_reporte_fecha_num" class="button glow button-rounded button-flat-action"><i class="fa fa-print"></i> Reporte</a>            
                    </fieldset> 
                    <fieldset id='depTipo'>
                        <legend>Reporte por departamento y tipo documento</legend>                        
                        <select  id="departamentoDoc" name="departamentoDoc" >   
                        </select> 
                        <select  id="tipoDoc" name="tipoDoc" >   
                        </select> 
                        <a href="#" id="btn_reporteTipoDoc" class="button glow button-rounded button-flat-action"><i class="fa fa-print"></i> Reporte</a>            
                    </fieldset> 
                    <fieldset>
                        <legend>Tamaño total</legend>                        
                        <input id="txt_fecha5" type="text" placeholder="Fecha Inicio" required>
                        <input id="txt_fecha6" type="text" placeholder="Fecha Final" required>
                        <a href="#" id="btn_reporteTamTotal" class="button glow button-rounded button-flat-action"><i class="fa fa-print"></i> Reporte</a>            
                    </fieldset> 
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
</div>   
<div id='frmGraficoPeso' title="Gráfico estadístico de los archivos subidos por día">
        <div id="chart"></div>                           
        <div id="botones1">                 
            <a href="#" id="btnCerrarVentana" class="button glow button-rounded button-flat-action"><i class="fa fa-eraser"></i> Cerrar Ventana</a>            
        </div>       
</div>