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
                        <legend>Reporte Auditoría (base datos)</legend>
                        <input id="txt_fecha1" type="text" placeholder="Fecha Inicio" required>
                        <input id="txt_fecha2" type="text" placeholder="Fecha Final" required>
                        <a href="#"  id="btn_reporte_base_datos" class="button glow button-rounded button-flat-action"><i class="fa fa-print"></i> Reporte</a>            
                    </fieldset> 
                     <fieldset>
                        <legend>Reporte Auditoría (sistema)</legend>
                        <input id="txt_fecha3" type="text" placeholder="Fecha Inicio" required>
                        <input id="txt_fecha4" type="text" placeholder="Fecha Final" required>
                        <a href="#"  id="btn_reporte_sistema" class="button glow button-rounded button-flat-action"><i class="fa fa-print"></i> Reporte</a>                
                    </fieldset> 
                    <fieldset>
                        <legend>Cantidad de  KBs por usuario</legend>
                        <input id="txt_fecha5" type="text" placeholder="Fecha Inicio" required>
                        <input id="txt_fecha6" type="text" placeholder="Fecha Final" required>
                        <a href="#" id="btn_reporte_usuario_peso" class="button glow button-rounded button-flat-action"><i class="fa fa-print"></i> Reporte</a>            
                    </fieldset>                    
                    <fieldset>
                        <legend>Cantidad KBs por departamento</legend>                        
                        <input id="txt_fecha7" type="text" placeholder="Fecha Inicio" required>
                        <input id="txt_fecha8" type="text" placeholder="Fecha Final" required>
                        <a href="#" id="btn_reporteDepartamento" class="button glow button-rounded button-flat-action"><i class="fa fa-print"></i> Reporte</a>            
                    </fieldset> 
                     <fieldset id='depTipo'>
                        <legend>Cantidad de KBs por mes</legend>                        
                        <select  id="mes1" name="mes1" >   
                            <option value="01">Enero</option>
                            <option value="02">Febrero</option>
                            <option value="03">Marzo</option>
                            <option value="04">Abril</option>
                            <option value="05">Mayo</option>
                            <option value="06">Junio</option>
                            <option value="07">Julio</option>
                            <option value="08">Agosto</option>
                            <option value="09">Septiembre</option>
                            <option value="10">Octubre</option>
                            <option value="11">Noviembre</option>
                            <option value="12">Diciembre</option>
                        </select> 
                        <select  id="mes2" name="mes2" >   
                            <option value="01">Enero</option>
                            <option value="02">Febrero</option>
                            <option value="03">Marzo</option>
                            <option value="04">Abril</option>
                            <option value="05">Mayo</option>
                            <option value="06">Junio</option>
                            <option value="07">Julio</option>
                            <option value="08">Agosto</option>
                            <option value="09">Septiembre</option>
                            <option value="10">Octubre</option>
                            <option value="11">Noviembre</option>
                            <option value="12">Diciembre</option>
                        </select> 
                        <a href="#" id="btn_reporteMes" class="button glow button-rounded button-flat-action"><i class="fa fa-print"></i> Reporte</a>            
                    </fieldset> 
                    <fieldset>
                        <legend>Reporte de usuarios del Sistema</legend> 
                        <label>Usuarios almacenados en la base de datos</label>
                        <a href="#" id="btn_reporteUsuarios" class="button glow button-rounded button-flat-action"><i class="fa fa-print"></i> Reporte Usuarios</a>                                                                              
                    </fieldset> 
                    <fieldset>
                        <legend>Descargar Archivos de la base</legend> 
                        <input id="totalArchivos" type="text" readonly>
                        <input id="totalKbs" type="text" readonly>                                                                       
                    </fieldset> 
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
<div id='frmGraficoPeso' title="">
        <div id="chart"></div>                           
        <div id="botones1">                 
            <a href="#" id="btnCerrarVentana" class="button glow button-rounded button-flat-action"><i class="fa fa-eraser"></i> Cerrar Ventana</a>            
        </div>       
</div>