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
<script type="text/javascript" src="../librerias/historial.js"></script> 
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
                        <a href="#" id="docRecibidos"><li>Historial del documento</li></a>
                        <br>                                                                 
                        <hr>                                               
                        <a href="doc_enviados.php"><li>Volver</li></a>    
                        <input type="hidden" id="id" value="<?php echo $_GET['id']?>">                 
                    </ul>                                                             
                </div>                    
                <div id="menu_medio" class="grid_9 alpha omega">    
                    <h4 align="center"><label>HISTORIAL DEL ARCHIVO</label></h4>
                                    
                    <table id="list"></table>                                      
                    <div id="pager"></div>                          
                    
               </div>                                                                  
            </div>                                                   
        </div>        
    </header>
    <div id='frmProcesos' title="Procesos">                                          
        <a href="#" id="btnHoja" class="button glow button-rounded button-flat-action"><i class="fa fa-bolt"></i> Hoja de Ruta</a>                                       
        <br><br>                                                                  
        <a href="#" id="btnVer" class="button glow button-rounded button-flat-action"><i class="fa fa-file-text-o"></i> Ver Archivo</a>                                      
                                                      
        <br><br>                                      
        <a href="#" id="btnDescargar" class="button glow button-rounded button-flat-action"><i class="fa fa-download"></i> Descargar Archivo</a>                                       
                                                      
</div>
    <footer class="container">
        <div class="grid_12">
            <h2>Copyrigth 2014 Xavier Quilka MIES(Ministerio de Inclusión Económica y Social)</h2>    
        </div>        
    </footer>
</body>
</html>
