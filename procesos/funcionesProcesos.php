<?php    
    include 'base.php'; 
    conectarse();   
    session_start();
    function buscarCodigo($valor,$tabla,$campo){    
        $cont=0;        
        $consulta=pg_query("select * from $tabla where $campo='$valor'");
        while ($row = pg_fetch_row($consulta)) {       
            $cont=1;
        }        
        return $cont;
    }
    function buscarNick($valor,$tabla,$campo){    
        $cont=0;              
        $consulta=pg_query("select * from $tabla where $campo='$valor'");
        while ($row = pg_fetch_row($consulta)) {       
            $cont=1;
        }        
        return $cont;
    }    
    function buscarMail($valor,$tabla,$campo){    
        $cont=0;               
        $consulta=pg_query("select * from $tabla where $campo='$valor'");
        while ($row = pg_fetch_row($consulta)) {       
            $cont=1;
        }        
        return $cont;
    }
    function buscarNick1($valor,$tabla,$campo){    
        $cont=0;      
        $consulta=pg_query("select * from $tabla where $campo='$valor' and id_usuario not in'$_session[id]'");
        while ($row = pg_fetch_row($consulta)) {       
            $cont=1;
        }        
        return $cont;
    }
    function buscarMail1($valor,$tabla,$campo){    
        $cont=0;               
        $consulta=pg_query("select * from $tabla where $campo='$valor' and id_usuario not in'$_session[id]'");
        while ($row = pg_fetch_row($consulta)) {       
            $cont=1;
        }        
        return $cont;
    }
    ?>
    