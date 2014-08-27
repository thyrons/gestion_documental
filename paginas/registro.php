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
<script type="text/javascript" src="../librerias/usuarios.js"></script>  
<script type="text/javascript" src="../librerias/funciones.js"></script>  
</head>
<body>
    <header>
        <div class="container">           
            <h1 id="logo" class="grid_5 suffix_7"><a href="#">
                <img src="../imagenes/logo.png" /><span>Logotipo</span></a></h1>
            <div class="clear"></div>           
            <div class="grid_12" id="menuPrincipal"> 
            
            </div>
            <div class="clear"></div>                      
            <div class="grid_12" id="formularios">     
                <form id="form1" method="post">                                 
                    <h2 class="grid_6 suffix_3 prefix_3 omega alpha"><label>INGRESO DE USUARIOS</label></h2>           <input type="hidden" class="grid_3" id="id_user" name="id_user" required/>     
                    <h3 class="grid_2" ><label for="cod_user">Código Usuario:</label></h3>
                    <input type="text" class="grid_3" id="cod_user" name="cod_user" readonly />
                    <h3 class="grid_3"><label for="nombre_user">Nombre Completo:</label></h3>
                    <input type="text" class="grid_4" id="nombre_user" name="nombre_user" required/>                   
                    <div class="clear"></div><br>
                    <h3 class="grid_2"><label for="tel_user">Teléfono Usuario:</label></h3>
                    <input type="text" class="grid_3" id="tel_user" name="tel_user" />
                    <h3 class="grid_3"><label for="dir_user">Dirección Usuario:</label></h3>
                    <input type="text" class="grid_4" id="dir_user" name="dir_user" required/>
                    <div class="clear"></div><br>
                    <h3 class="grid_2"><label for="cel_user">Celular Usuario:</label></h3>
                    <input type="text" class="grid_3" id="cel_user" name="cel_user" />
                    <h3 class="grid_3"><label for="mail_user">Email Usuario:</label></h3>
                    <input type="email" class="grid_4" id="mail_user" name="mail_user" required/>
                    <div class="clear"></div><br>
                    <h3 class="grid_2"><label for="pais_user">Pais:</label></h3>
                    <select class="grid_3" id="pais_user" name="pais_user" required>

                    </select>
                    <h3 class="grid_3"><label for="user_name">Nombre Usuario:</label></h3>
                    <input type="text" class="grid_4" id="user_name" name="user_name" required />
                    <div class="clear"></div><br>
                    <h3 class="grid_2"><label for="provincia_user">Provincia:</label></h3>
                    <select  class="grid_3" id="provincia_user" name="provincia_user" required >
                    </select>
                    <h3 class="grid_3"><label for="tipo_user">Tipo Usuario:</label></h3>
                    <select class="grid_4" id="tipo_user" name="tipo_user" required >
                    </select>
                    <div class="clear"></div><br>
                    <h3 class="grid_2"><label for="ciudad_user">Ciudad:</label></h3>
                    <select  class="grid_3" id="ciudad_user" name="ciudad_user" required>
                    </select>
                    <h3 class="grid_3"><label for="clave_user">Contraseña:</label></h3>
                    <input type="password" class="grid_4" id="clave_user" name="clave_user" required/>
                    <div class="clear"></div><br>
                    <h3 class="grid_2"><label for="categoria_user">Categoría:</label></h3>
                    <select  class="grid_3" id="categoria_user" name="categoria_user" required>
                    </select>
                    <h3 class="grid_3"><label for="institucion">Institución:</label></h3>
                    <input type="text" class="grid_4" id="institucion" name="institucion" required/>                    
                    <div class="clear"></div><br>                    
                    <h3 class="grid_2"><label for="departamento_user">Departamento:</label></h3>
                    <select class="grid_3" id="departamento_user" name="departamento_user">                    
                    </select>
                    <div class="clear"></div><br>                                        
                    <div id="botones" class="grid_8 prefix_4 alpha omega">
                        <button id="btnGuardar" class="button glow button-rounded button-flat-action"><i class="fa fa-save"></i> Guardar</button>
                        <button id="btnLimpiar" class="button glow button-rounded button-flat-action"><i class="fa fa-eraser"></i> Limpiar</button>                                       
                        <button id="bntVolover" class="button glow button-rounded button-flat-action"><i class="fa fa-backward"></i> Regresar</button>                                       
                    </div>    
                </form>                      
                <div class="clear"></div><br>                   
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
