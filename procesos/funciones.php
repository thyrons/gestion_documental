<?php
    include 'funcionesProcesos.php';        
    if (isset($_REQUEST['funcion'])) {
        $funcion = $_REQUEST['funcion'];        
    }   
    switch ($funcion) {
        case 1:            
            $valor=$_POST['valor'];
            $tabla=$_POST['tabla'];
            $campo=$_POST['campo']; 
            echo buscarCodigo($valor,$tabla,$campo);
        break;    
        case 2:            
            $valor=$_POST['valor'];
            $tabla=$_POST['tabla'];
            $campo=$_POST['campo'];             
            echo buscarNick($valor,$tabla,$campo);
        break;   
        case 3:            
            $valor=$_POST['valor'];
            $tabla=$_POST['tabla'];
            $campo=$_POST['campo'];             
            echo buscarMail($valor,$tabla,$campo);
        break;   
        case 4:            
            $valor=$_POST['valor'];
            $tabla=$_POST['tabla'];
            $campo=$_POST['campo'];             
            echo buscarMail1($valor,$tabla,$campo);
        break;   
        case 5:            
            $valor=$_POST['valor'];
            $tabla=$_POST['tabla'];
            $campo=$_POST['campo'];             
            echo buscarMail1($valor,$tabla,$campo);
        break;   
    }        
?>
