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
                    <li><a href="#" id='mies'>Nosotros</a></li>
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
                                Ser la entidad pública que ejerce la rectoría y ejecuta políticas, regulaciones, programas y servicios para la inclusión social y atención durante el  ciclo de vida con prioridad en la población de niños, niñas, adolescentes, jóvenes, adultos mayores, personas con discapacidad y aquellos y aquellas que se encuentran en situación de pobreza, a fin de aportar a su movilidad Social y salida de la pobreza.
                            </p>
                        </ul>                        
                    </li>                     
                    <li><a href="#">Visión</a>
                        <ul>
                            <h3>Visión</h3>
                            <p>
                                Establecer y ejecutar políticas, regulaciones, estrategias, programas y servicios para la atención durante el ciclo de vida, protección especial, aseguramiento universal no contributivo, movilidad Social e inclusión económica de grupos de atención prioritaria (niños, niñas, adolescentes, jóvenes, adultos mayores, personas con discapacidad) y aquellos que se encuentran en situación de pobreza y vulnerabilidad.
                            </p>
                        </ul>
                    </li>                     
                    <li><a href="#">Objetivos</a>
                        <ul>
                            <h3>Valores</h3>
                            <p>
                                La gestión del MIES se sustentará en los siguientes valores:
                                <br/>Ética
                                <br/>Transparencia
                                <br/>Responsabilidad
                                <br/>Honestidad
                                <br/>Respeto
                                <br/>Calidad
                                <br/>Calidez
                                <br/>Lealtad
                                <br/>Eficiencia
                                <br/>Eficacia
                                <br/>Compromiso
                                <br/>Trabajo en equipo.

                            </p>
                        </ul>
                    </li>
                    <li><a href="#">Formación Contínua</a>
                        <ul>
                            <h3>Formación Contínua</h3>
                            <p>
                                El Ministerio de Inclusión Económica y Social (MIES) es el responsable de la regulación de los servicios de Desarrollo Infantil Integral (DII) de niñas y niños menores de 3 años. 
                                Con el propósito de mejorar la calidad  de los servicios de atención infantil, la Subsecretaría de Desarrollo Infantil Integral se encuentra implementando la Estrategia de Mejoramiento del Talento Humano, a través de programas de profesionalización y formación continua dirigidos a todo el personal responsable de la operación de las modalidades de atención infantil.
                                Se busca fortalecer sus competencias técnicas y sus mecanismos de trabajo en territorio con otros actores institucionales, articulando  las políticas públicas desde la garantía de los derechos y servicios en las áreas de salud, higiene y nutrición, educación, protección infantil, participación familiar y comunitaria. 
                                La política pública de Desarrollo Infantil determina el cumplimiento de una norma técnica, articulada a una serie de protocolos y herramientas que permiten la implementación y funcionamiento de servicios de calidad para los niños y niñas menores de tres años.
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
            <h2>Copyrigth 2014 Xavier Quilka MIES(Ministerio de Inclusión Económica y Social)</h2>    
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
            <!--<a href="#" id="btnRegistro" class="button glow button-rounded button-flat-action"><i class="fa fa-plus"></i> Registrarse</a>!-->                           
        </div>       
</div>  
</body>
</html>