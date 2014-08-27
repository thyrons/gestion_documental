<?php
    session_start();  
    session_destroy(); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Gestión Documental</title>
<link rel="stylesheet" type="text/css" href="../css/base.css"/>
<link rel="stylesheet" type="text/css" href="../css/grid.css"/>
<link rel="stylesheet" type="text/css" href="../css/normalize.css"/>
<link rel="stylesheet" type="text/css" href="../css/buttons.css"/>
<link rel="stylesheet" type="text/css" href="../css/style.css"/>
<link rel="stylesheet" type="text/css" href="../css/estilos.css"/>
<link rel="stylesheet" type="text/css" href="../css/scroll.css"/>
<link rel="stylesheet" type="text/css" href="../css/font-awesome.css"/>
<link rel="stylesheet" type="text/css" href="../css/jquery-ui-1.10.3.custom.css"/>
<script type="text/javascript" src="../js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.10.3.custom.min.js"></script>
<script type="text/javascript" src="../js/modernizr-2.6.2.min.js"></script>
<script type="text/javascript" src="../js/prefixfree.min.js"></script>
<script type="text/javascript" src="../js/test.js"></script>
<script type="text/javascript" src="../js/jquery.imageScroller.js"></script>
<script type="text/javascript" src="../js/base_64.js"></script>
<script type="text/javascript" src="../js/buttons.js"></script>
<script type="text/javascript" src="../librerias/index.js"></script>  
</head>
<body>
    <header>
        <div class="container">
            <nav class="grid_5 prefix_7">
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#" id='uniandes'>Nosotros</a></li>
                    <li><a href="#" id="sistema">Sistema</a></li>                                        
                </ul>
            </nav>           
            <h1 id="logo" class="grid_12"><a href="#" class="grid_5">
                <img src="../imagenes/logo.png" /><span>Logotipo</span></a>
               
            </h1>                

            <div class="clear"></div>
            <div class="grid_12"  id="galeria">
                <div id='right'>
                    <img src='../imagenes/pre1.jpg' title='Edificio UNIANDES' />
                    <img src='../imagenes/pre2.jpg' title='Canchas Deportivas' />
                    <img src='../imagenes/pre3.jpg' title='Edificio UNIADES' />
                    <img src='../imagenes/pre4.jpg' title='Departamento Financiero' />
                    <img src='../imagenes/pre5.jpg' title='Edificio UNIANDES' />
                    <img src='../imagenes/pre6.jpg' title='Cubiculos Docentes' />
                    <img src='../imagenes/pre7.jpg' title='Auditorio Aristóteles' />
                    <img src='../imagenes/pre8.jpg' title='Laboratorio de Informática' />
                </div>                  
            </div>       
            <div class="grid_12" id="contenidoCentro">  
             <ul class="acordeon">                    
                    <li><a href="#">Misión</a>
                        <ul>
                        <h3>Misión</h3>
                            <p>
                                Somos una carrera de las Ciencias Tecnológicas, que tiene como propósito formar profesionales competitivos y emprendedores, con sólidos conocimientos en el área de las ciencias computación, para resolver problemas relacionados con el tratamiento de la información, con estricta responsabilidad social bajo una visión ética y humanística para contribuir con el desarrollo integral del país.
                            </p>
                        </ul>                        
                    </li>                     
                    <li><a href="#">Visión</a>
                        <ul>
                            <h3>Visión</h3>
                            <p>
                                Ser una carrera reconocida a nivel nacional e internacional, por la calidad y competitividad de sus docentes y graduados, con alto desempeño profesional enfocado al área de computación e informática que trascienda por su relevancia en la investigación y desarrollo de proyectos técnicos mediante el uso eficiente de las Ciencias de la computación en beneficio de la sociedad.
                            </p>
                        </ul>
                    </li>                     
                    <li><a href="#">Objetivos</a>
                        <ul>
                            <h3>Objetivos</h3>
                            <p>
                                El graduado de la Carrera de Sistemas será capaz de desarrollar y evaluar sistemas informáticos, de control, automatización y comunicación cumpliendo estándares internacionales, integrando las ciencias de la computación en diversas áreas para generar soluciones informáticas pertinentes, a través de la investigación y la protección de los derechos de propiedad intelectual con un alto compromiso social.
                            </p>
                        </ul>
                    </li>
                    <li><a href="#">Políticas</a>
                        <ul>
                            <h3>Políticas</h3>
                            <p>
                                Formar profesionales dotados de competencias específicas para resolver problemas informáticos del entorno que contribuyan a la mejora en el proceso de toma de decisiones..
                                La formación de profesionales con valores éticos que contribuya al ejercicio profesional basado en los principios de buena fe, probidad, veracidad, honradez y lealtad.
                                Contribuir a la sociedad con profesionales que estén preparados en la gestión de proyectos informáticos.
                                Promover la vinculación con la sociedad para que nuestros estudiantes y egresados sean agentes del desarrollo económico, social, político en ámbito local, regional y nacional con proyección internacional.
                                El proceso de profesionalización tendrá en el pregrado mallas curriculares acorde con el desarrollo técnico y científico en el área de las ciencias informáticas con un alto nivel de pertinencia con el entorno, por lo que las mismas serán flexibles a los cambios que se producen en la sociedad contemporánea y el reconocimiento de los derechos.
                            </p>
                        </ul>
                    </li>                   
                </ul>                                       
            </div>                
        </div>  
        <div class="clear"></div>                      
    </div>
    <div class="clear"></div>
    </header>
    <footer class="container">
        <div class="grid_12">
            <h2>Copyrigth 2014 Willy Narváez Universidad Regional Autónoma de los Andes "Uniandes"</h2>    
        </div>        
    </footer>
    <div id='frmLogin' title="Ingreso de Usuarios">
        <div class="input-group margin-bottom-sm">
            <span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
            <input class="form-control"  id="txtUser" type="text" placeholder="Nombre Usuario" required>
        </div>        
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-key fa-fw"></i></span>
            <input class="form-control" id="txtPass" type="password" placeholder="Contraseña" required>
        </div>                
        <div id="botones1">
            <a href="#" id="btnIngresar" class="button glow button-rounded button-flat-action"><i class="fa fa-check"></i> Ingresar</a>
            <a href="#" id="btnRegistro" class="button glow button-rounded button-flat-action"><i class="fa fa-plus"></i> Registrarse</a>                            
        </div>       
</div>  
</body>
</html>