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
<script type="text/javascript" src="../librerias/ubicaciones.js"></script>  

</head>
<body>
    <header>
        <div class="container">           
            <h1 id="logo" class="grid_5 suffix_7"><a href="#">
                <img src="../imagenes/logo.png" /><span>Logotipo</span></a></h1>
            <div class="clear"></div>           
            <div class="grid_12" id="menuPrincipal"> 
          <?php               
                //include("menu.html");                
                include("../procesos/cargar_menu.php")   
            ?>                                                    
            </div>
            <div class="clear"></div>                      
            <div class="grid_12" id="formularios">     
                <form id="form1" method="post">                                 
                    <h2 class="grid_6 suffix_3 prefix_3 omega alpha"><label>INGRESO DE PAÍSES</label></h2> 
                    <div class="grid_6 alpha omega">                                                                       
                        <h3 class="grid_3">Nombre País:</h3>
                        <input type="text" class="grid_3" id="nombre_pais" name="nombre_pais" required/>     
                        <input type="hidden" id="id_pais" name="id_pais"/>     
                        <div id="botones1" class="grid_6 alpha omega">
                            <a href="#" id="btnGuardar" class="button glow button-rounded button-flat-action"><i class="fa fa-save"></i> Guardar</a>
                            <a href="#" id="btnLimpiar" class="button glow button-rounded button-flat-action"><i class="fa fa-eraser"></i> Limpiar</a>                            
                        </div>      
                    </div>
                </form>                               
                <div class="grid_6 alpha omega" id="medio1">                                                                       
                    <table id="list" ></table>
                    <div id="pager"></div> 
                </div>                    
                 <hr class="grid_12 alpha omega">                                                              
                <!-- -->
                <form id="form2" method="post">                                 
                    <h2 class="grid_6 suffix_3 prefix_3 omega alpha"><label>INGRESO DE PROVINCIAS</label></h2> 
                    <div class="grid_6 alpha omega">                                                                       
                        <h3 class="grid_3">Nombre País:</h3>
                        <select type="text" class="grid_3" id="select_pais" name="select_pais" required>                             
                        </select>
                        <br><br>
                        <h3 class="grid_3">Nombre Provincia:</h3>
                        <input type="text" class="grid_3" id="nombre_provincia" name="nombre_provincia" required/>     
                        <input type="hidden" id="id_provincia" name="id_provincia"/>                           
                        <div id="botones2" class="grid_6 alpha omega">
                            <a href="#" id="btnGuardar1" class="button glow button-rounded button-flat-action"><i class="fa fa-save"></i> Guardar</a>
                            <a href="#" id="btnLimpiar1" class="button glow button-rounded button-flat-action"><i class="fa fa-eraser"></i> Limpiar</a>                            
                        </div>      
                    </div>
                </form>                               
                <div class="grid_6 alpha omega" id="medio2">                                                                       
                    <table id="list1" ></table>
                    <div id="pager1"></div> 
                </div>   
                <hr class="grid_12 alpha omega">          
                 <!-- -->
                <form id="form3" method="post">                                 
                    <h2 class="grid_6 suffix_3 prefix_3 omega alpha"><label>INGRESO DE CIUDADES</label></h2> 
                    <div class="grid_6 alpha omega">                                                                       
                        <h3 class="grid_3">Nombre País:</h3>
                        <select type="text" class="grid_3" id="select_pais1" name="select_pais1" required>                             
                        </select>
                        <br><br>
                        <h3 class="grid_3">Nombre Provincia:</h3>
                        <select type="text" class="grid_3" id="select_provincia" name="select_provincia" required>                             
                        </select>
                        <br><br>
                         <h3 class="grid_3">Nombre Ciudad:</h3>
                        <input type="text" class="grid_3" id="nombre_ciudad" name="nombre_ciudad" required/>     
                        <input type="hidden" id="id_ciudad" name="id_ciudad"/>                           
                        <div id="botones3" class="grid_6 alpha omega">
                            <a href="#" id="btnGuardar2" class="button glow button-rounded button-flat-action"><i class="fa fa-save"></i> Guardar</a>
                            <a href="#" id="btnLimpiar2" class="button glow button-rounded button-flat-action"><i class="fa fa-eraser"></i> Limpiar</a>                            
                        </div>      
                    </div>
                </form>                               
                <div class="grid_6 alpha omega" id="medio3">                                                                       
                    <table id="list2" ></table>
                    <div id="pager2"></div> 
                </div>   
                <div class="clear"></div>                                  
                <br>                                                          
            </div>                                                   
            <div class="clear"></div>                                  
        </div>
        <div class="clear"></div>
    </header>
    <footer class="container">
        <div class="grid_12">
            <h2>Copyrigth 2014 Xavier Quilka MIES(Ministerio de Inclusión Económica y Social)</h2>    
        </div>        
    </footer>
</body>
</html>
