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
<script type="text/javascript" src="../librerias/varios.js"></script>  

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
                <form id="form1" method="post"><!--form1-->
                    <h2 class="grid_6 suffix_3 prefix_3 omega alpha"><label>INGRESO DE CATEGORÍAS</label></h2> 
                    <div class="grid_6 alpha omega">                                    
                        <h3 class="grid_3">Código Categoría:</h3>
                        <input type="text" class="grid_3" id="codigo_categoria" name="codigo_categoria" required/>                      
                        <br><br>
                         <h3 class="grid_3">Nombre Categoría:</h3>       
                         <input type="text" class="grid_3" id="nombre_categoria" name="nombre_categoria" required/>                          
                        <br><br>                        
                        <input type="hidden" id="id_categoria" name="id_categoria"/>     
                        <div id="botones1" class="grid_6 alpha omega">
                            <a href="#" id="btnGuardar1" class="button glow button-rounded button-flat-action"><i class="fa fa-save"></i> Guardar</a>
                            <a href="#" id="btnLimpiar1" class="button glow button-rounded button-flat-action"><i class="fa fa-eraser"></i> Limpiar</a>
                        </div>      
                    </div>
                </form>                               
                <div class="grid_6 alpha omega" id="medio1">     
                    <table id="list1" ></table>
                    <div id="pager1"></div> 
                </div>                    
                 <hr class="grid_12 alpha omega"><!--fin form1-->              
                <!-- -->
                <form id="form2" method="post"><!--form2-->                         
                    <h2 class="grid_6 suffix_3 prefix_3 omega alpha"><label>INGRESO DE DEPARTAMENTOS</label></h2>
                    <div class="grid_6 alpha omega">                             
                        <h3 class="grid_3">Código Departamento:</h3>
                        <input type="text" class="grid_3" id="codigo_departamento" name="codigo_departamento" required/>                      
                        <br><br>
                        <h3 class="grid_3">Nombre Departamento:</h3>       
                        <input type="text" class="grid_3" id="nombre_departamento" name="nombre_departamento" required/>                          
                        <br><br>                        
                        <input type="hidden" id="id_departamento" name="id_departamento"/>
                        <div id="botones2" class="grid_6 alpha omega">
                            <a href="#" id="btnGuardar2" class="button glow button-rounded button-flat-action"><i class="fa fa-save"></i> Guardar</a>
                            <a href="#" id="btnLimpiar2" class="button glow button-rounded button-flat-action"><i class="fa fa-eraser"></i> Limpiar</a>
                        </div>      
                    </div>
                </form>                               
                <div class="grid_6 alpha omega" id="medio2">                    
                    <table id="list2" ></table>
                    <div id="pager2"></div> 
                </div>   
                <hr class="grid_12 alpha omega">   <!--fin form2-->                       
                 <!-- -->
                <form id="form3" method="post"> <!--form3-->                                 
                    <h2 class="grid_6 suffix_3 prefix_3 omega alpha"><label>INGRESO DE MEDIOS DE RECEPCIÓN</label></h2> 
                        <div class="grid_6 alpha omega">                                       
                        <h3 class="grid_3">Código Medio recepción:</h3>       
                        <input type="text" class="grid_3" id="codigo_medio" name="codigo_medio" required/>                          
                        <br><br>   
                        <h3 class="grid_3">Nombre Medio recepción:</h3>
                        <input type="text" class="grid_3" id="nombre_medio" name="nombre_medio" required/>                      
                        <br><br>                                            
                        <input type="hidden" id="id_medio" name="id_medio"/>
                        <div id="botones3" class="grid_6 alpha omega">
                            <a href="#" id="btnGuardar3" class="button glow button-rounded button-flat-action"><i class="fa fa-save"></i> Guardar</a>
                            <a href="#" id="btnLimpiar3" class="button glow button-rounded button-flat-action"><i class="fa fa-eraser"></i> Limpiar</a>                            
                        </div>      
                    </div>
                </form>                               
                <div class="grid_6 alpha omega" id="medio3">      
                    <table id="list3" ></table>
                    <div id="pager3"></div> 
                </div> 
                 <hr class="grid_12 alpha omega">    <!--fin form3-->
                  <!-- -->
                <form id="form4" method="post">             <!--form4-->                    
                    <h2 class="grid_6 suffix_3 prefix_3 omega alpha"><label>INGRESO DE TIPOS DE DOCUMENTOS</label></h2>
                    <div class="grid_6 alpha omega">                             
                        <h3 class="grid_3">Código Tipo documento:</h3>
                        <input type="text" class="grid_3" id="codigo_doc" name="codigo_doc" required/>                      
                        <br><br>
                        <h3 class="grid_3">Nombre Tipo documento:</h3>       
                        <input type="text" class="grid_3" id="nombre_doc" name="nombre_doc" required/>                          
                        <br><br>                        
                        <input type="hidden" id="id_tipo_documento" name="id_tipo_documento"/>
                        <div id="botones4" class="grid_6 alpha omega">
                            <a href="#" id="btnGuardar4" class="button glow button-rounded button-flat-action"><i class="fa fa-save"></i> Guardar</a>
                            <a href="#" id="btnLimpiar4" class="button glow button-rounded button-flat-action"><i class="fa fa-eraser"></i> Limpiar</a> 
                        </div>      
                    </div>
                </form>                               
                <div class="grid_6 alpha omega" id="medio4">                    
                    <table id="list4" ></table>
                    <div id="pager4"></div> 
                </div>    
                <hr class="grid_12 alpha omega">    <!--fin form4-->
                  <!-- -->
                <form id="form5" method="post">  <!--form5-->                               
                    <h2 class="grid_6 suffix_3 prefix_3 omega alpha"><label>INGRESO DE TIPOS DE CLIENTES</label></h2>
                    <div class="grid_6 alpha omega">                                                     
                        <h3 class="grid_3">Nombre Tipo cliente:</h3>       
                        <input type="text" class="grid_3" id="nombre_tipo" name="nombre_tipo" required/>                          
                        <br><br>                        
                        <input type="hidden" id="id_tipo_usuario" name="id_tipo_usuario"/>
                        <div id="botones5" class="grid_6 alpha omega">
                            <a href="#" id="btnGuardar5" class="button glow button-rounded button-flat-action"><i class="fa fa-save"></i> Guardar</a>
                            <a href="#" id="btnLimpiar5" class="button glow button-rounded button-flat-action"><i class="fa fa-eraser"></i> Limpiar</a>              
                        </div>      
                    </div>
                </form>                               
                <div class="grid_6 alpha omega" id="medio5">                    
                    <table id="list5" ></table>
                    <div id="pager5"></div> 
                </div>    <!--fin form5-->
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
