<?php
include 'base.php'; 
conectarse();
session_start();
$data=0;
$lista = array();
error_reporting(0);
$palabra=$_POST['palabra'];
$version=$_POST['subversion'];
if($_SESSION['nivel']=="ADMINISTRADOR"){
    $consulta=pg_query("select id_archivo,nombre_doc from archivo,tipo_documento where archivo.id_tipo_doc=tipo_documento.id_tipo_documento");       
    while($row=pg_fetch_row($consulta)){
        $ext="";
        if($version=="on"){
            $consulta1=pg_query("select id_bitacora,fecha_cambio,asunto_cambio,observaciones,nombre_archivo,codigo_archivo,nombre_departamento,referencia,archivo.id_archivo from bitacora,archivo,departamento where bitacora.id_archivo=archivo.id_archivo and departamento.id_departamento=bitacora.id_departamento and archivo.id_archivo='$row[0]'");                        
            while($row1=pg_fetch_row($consulta1)){                 
                $document = '../archivos/'.$row1[7];                     
                $ext = end(explode('.', $document));                 
                $resp=buscar_text($ext,$document);                
                if(preg_match("/".$palabra."/i", $resp))     
                {         
                    $lista[]=$row1[5];  
                    $lista[]=$row1[4];                       
                    $lista[]=$row1[1];                                                    
                    $lista[]=$row1[6];           
                    $lista[]=$row[1];         
                    $lista[]=$row1[0];         
                }
            }
        }
        else{           
            $consulta1=pg_query("select id_bitacora,fecha_cambio,asunto_cambio,observaciones,nombre_archivo,codigo_archivo,nombre_departamento,referencia,archivo.id_archivo from bitacora,archivo,departamento where bitacora.id_archivo=archivo.id_archivo and departamento.id_departamento=bitacora.id_departamento and archivo.id_archivo='$row[0]'order by id_bitacora desc limit 1");                        
            while($row1=pg_fetch_row($consulta1)){
                $document = '../archivos/'.$row1[7];                     
                $ext = end(explode('.', $document));                 
                $resp=buscar_text($ext,$document);                
                if(preg_match("/".$palabra."/i", $resp))     
                {         
                    $lista[]=$row1[5];  
                    $lista[]=$row1[4];                       
                    $lista[]=$row1[1];                                                    
                    $lista[]=$row1[6];           
                    $lista[]=$row[1];         
                    $lista[]=$row1[0];         
                }
            }
        }    
    }
}
else{    
    $consulta=pg_query("select id_archivo,nombre_doc  from archivo,tipo_documento where archivo.id_tipo_doc=tipo_documento.id_tipo_documento and id_creador='$_SESSION[id]'");
    while($row=pg_fetch_row($consulta)){
        $ext="";
        if($version=="on"){           
            $consulta1=pg_query("select id_bitacora,fecha_cambio,asunto_cambio,observaciones,nombre_archivo,codigo_archivo,nombre_departamento,referencia,archivo.id_archivo from bitacora,archivo,departamento where bitacora.id_archivo=archivo.id_archivo and departamento.id_departamento=bitacora.id_departamento and archivo.id_archivo='$row[0]'");                        
            while($row1=pg_fetch_row($consulta1)){
                $document = '../archivos/'.$row1[7];                     
                $ext = end(explode('.', $document));                 
                $resp=buscar_text($ext,$document);                
                if(preg_match("/".$palabra."/i", $resp))     
                {         
                    $lista[]=$row1[5];  
                    $lista[]=$row1[4];                       
                    $lista[]=$row1[1];                                                    
                    $lista[]=$row1[6];           
                    $lista[]=$row[1];         
                    $lista[]=$row1[0];         
                }
            }
        }
        else{           
            $consulta1=pg_query("select id_bitacora,fecha_cambio,asunto_cambio,observaciones,nombre_archivo,codigo_archivo,nombre_departamento,referencia,archivo.id_archivo from bitacora,archivo,departamento where bitacora.id_archivo=archivo.id_archivo and departamento.id_departamento=bitacora.id_departamento and archivo.id_archivo='$row[0]'order by id_bitacora desc limit 1");                        
            while($row1=pg_fetch_row($consulta1)){
                $document = '../archivos/'.$row1[7];                     
                $ext = end(explode('.', $document));                 
                $resp=buscar_text($ext,$document);                
                if(preg_match("/".$palabra."/i", $resp))     
                {         
                    $lista[]=$row1[5];  
                    $lista[]=$row1[4];                       
                    $lista[]=$row1[1];                                                    
                    $lista[]=$row1[6];           
                    $lista[]=$row[1];         
                    $lista[]=$row1[0];         
                }
            }
        }    
    }
}
echo $lista=json_encode($lista);  
function buscar_text($ext,$document){    
     if($ext=='doc'){
        doc_to_text($document);
         $data= doc_to_text($document);       
    }
    else{
        if($ext=='odt'){            
            odt_to_text($document);
            $data=odt_to_text($document);
        }
        else{
            if($ext=='docx'){                
                docx_to_text($document);
                $data=docx_to_text($document);
            }
            else{
                if($ext=='xlsx'){
                    xlsx_to_text($document);
                     $data=xlsx_to_text($document);
                }
                else{
                    if($ext=='pptx'){
                        pptx_to_text($document);
                        $data=pptx_to_text($document);
                    }
                    else{/// si la extension puede ser txt o otras diferentes
                        if($ext=='txt'){
                            $data = file_get_contents($document);
                        }
                        else{
                            if($ext=='pdf'){
                                include 'pdf2text.php';
                                $data = pdf2text ($document);                                
                            }
                            else{
                                $data = file_get_contents($document);
                            }
                        }    
                    }
                }   
            }
   
        }
    }
    return $data;
}       
function doc_to_text($input_file){
    $file_handle = fopen($input_file, "r"); //open the file
    $stream_text = @fread($file_handle, filesize($input_file));
    $stream_line = explode(chr(0x0D),$stream_text);
    $output_text = "";
    foreach($stream_line as $single_line){
        $line_pos = strpos($single_line, chr(0x00));
        if(($line_pos !== FALSE) || (strlen($single_line)==0)){
            $output_text .= "";
        }else{
            $output_text .= $single_line." ";
        }
    }
    $output_text = preg_replace("/[^a-zA-Z0-9\s\,\.\-\n\r\t@\/\_\(\)]/", "", $output_text);
    return $output_text;
}
function odt_to_text($input_file){
    $xml_filename = "content.xml"; //content file name
    $zip_handle = new ZipArchive;
    $output_text = "";
    if(true === $zip_handle->open($input_file)){
        if(($xml_index = $zip_handle->locateName($xml_filename)) !== false){
            $xml_datas = $zip_handle->getFromIndex($xml_index);
            $xml_handle = DOMDocument::loadXML($xml_datas, LIBXML_NOENT | LIBXML_XINCLUDE | LIBXML_NOERROR | LIBXML_NOWARNING);
            $output_text = strip_tags($xml_handle->saveXML());
        }else{
            $output_text .="";
        }
        $zip_handle->close();
    }else{
    $output_text .="";
    }
    return $output_text;
}
 
function docx_to_text($input_file){
    $xml_filename = "word/document.xml"; //content file name
    $zip_handle = new ZipArchive;
    $output_text = "";
    if(true === $zip_handle->open($input_file)){
        if(($xml_index = $zip_handle->locateName($xml_filename)) !== false){
            $xml_datas = $zip_handle->getFromIndex($xml_index);
            $xml_handle = DOMDocument::loadXML($xml_datas, LIBXML_NOENT | LIBXML_XINCLUDE | LIBXML_NOERROR | LIBXML_NOWARNING);
            $output_text = strip_tags($xml_handle->saveXML());
        }else{
            $output_text .="";
        }
        $zip_handle->close();
    }else{
    $output_text .="";
    }
    return $output_text;
}
 
function pptx_to_text($input_file){
    $zip_handle = new ZipArchive;
    $output_text = "";
    if(true === $zip_handle->open($input_file)){
        $slide_number = 1; //loop through slide files
        while(($xml_index = $zip_handle->locateName("ppt/slides/slide".$slide_number.".xml")) !== false){
            $xml_datas = $zip_handle->getFromIndex($xml_index);
            $xml_handle = DOMDocument::loadXML($xml_datas, LIBXML_NOENT | LIBXML_XINCLUDE | LIBXML_NOERROR | LIBXML_NOWARNING);
            $output_text .= strip_tags($xml_handle->saveXML());
            $slide_number++;
        }
        if($slide_number == 1){
            $output_text .="";
        }
        $zip_handle->close();
    }else{
    $output_text .="";
    }
    return $output_text;
}
function xlsx_to_text($input_file){
    $xml_filename = "xl/sharedStrings.xml"; //content file name
    $zip_handle = new ZipArchive;
    $output_text = "";
    if(true === $zip_handle->open($input_file)){
        if(($xml_index = $zip_handle->locateName($xml_filename)) !== false){
            $xml_datas = $zip_handle->getFromIndex($xml_index);
            $xml_handle = DOMDocument::loadXML($xml_datas, LIBXML_NOENT | LIBXML_XINCLUDE | LIBXML_NOERROR | LIBXML_NOWARNING);
            $output_text = strip_tags($xml_handle->saveXML());
        }else{
            $output_text .="";
        }
        $zip_handle->close();
    }else{
    $output_text .="";
    }
    return $output_text;
}
?>