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
<script type="text/javascript" src="../librerias/mod_doc.js"></script> 
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
                        <a href="#" id="docRecibidos"><li>Modificar Documento</li></a>
                        <br>                                                                 
                        <hr>                                               
                        <a href="doc_enviados.php"><li>Volver</li></a>    
                        <input type="hidden" id="id" value="<?php echo $_GET['id']?>">                    
                    </ul>                                                             
                </div>                    
               <form class="grid_9 alpha omega" id="menu_medio1" name="menu_medio1" 
            enctype="multipart/form-data" method="post" action="../procesos/modificar_Doc.php">                                           
                    <div class="clear"></div><br>                      
                    <div class="grid_9 alpha omega" id="datosArchivo">
                        <h4 class="grid_9 alpha omega"><label>MODIFICACIÓN O VISUALIZACIÓN DEL ARCHIVO</label></h4>                       
                        <h3 class="grid_2"><label for="fechaDoc">Fecha de Registro:</label></h3>
                        <input type="text" class="grid_2" id="fechaDoc" name="fechaDoc" required/>                                                 
                        <h3 class="grid_2"><label for="estado_archivo">Estado:</label></h3>
                        <select class="grid_3" id="estado_archivo" name="estado_archivo" >   
                            <option value="0">En revisión</option>
                            <option value="1">Finalizado</option>                            
                        </select>                         
                        <div class="clear"></div><br>
                        <h3 class="grid_2"><label for="departamentoDoc">Departamento:</label></h3>
                        <select class="grid_2" id="departamentoDoc" name="departamentoDoc" >   
                        </select>                                              
                        <h3 class="grid_2"><label for="asuntoDoc">Asunto:</label></h3>
                        <textarea class="grid_3 alpha omega" id="asuntoDoc" name="asuntoDoc" ></textarea>
                        <div class="clear"></div><br>
                        <h3 class="grid_2"><label for="observaciones">Observaciones:</label></h3>
                        <textarea class="grid_6 alpha omega" id="observaciones" rows="3" name="observaciones" ></textarea>
                        <div class="clear"></div><br>
                        <h3 class="grid_2"><label for="archivoDoc">Seleccione:</label></h3>
                        <input class="grid_6" type="file" name="archivoDoc" id="archivoDoc" value="" placeholder="Seleccione una archivo" >                       
                        <div class="clear"></div><br>
                    </div>                    
                </form>   
                <div class="grid_7 alpha omega prefix_4" align="center">
                    <button id="btnEnviar" class="button glow button-rounded button-flat-action"><i class="fa fa-sign-out"></i> Modificar Archivo</button>                           
                    <a id="btnMostrar" target="_blank" href="../procesos/descarga.php?id=<?php echo $_GET['id']?>" class="button glow button-rounded button-flat-action"><i class="fa fa-copy"></i> Mostar Archivo</a>                          
                    <a id="btnDescargar" target="_blank" href="../procesos/descarga.php?id=<?php echo $_GET['id']?>&amp;f=1" class="button glow button-rounded button-flat-action"><i class="fa fa-file"></i> Descargar Archivo</a>                           
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
