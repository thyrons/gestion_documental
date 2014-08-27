$(document).on("ready", inicio);
$(document).tooltip();
function defecto(e){
	e.preventDefault();

};
function inicio (){
	$("#btnBuscartexto").on("click",defecto);
	$("#btnBuscartexto").on("click",buscadorPalabras)
	var cuantosLi = 0;
        jQuery("ul#nav > li").each(function(index) {
         cuantosLi = cuantosLi+1;
    });
    cuantosLi=cuantosLi+0.5;
	$("ul#nav > li").css('width','calc(100%/'+cuantosLi+')');      
}
function buscadorPalabras(){
	$("#tablaNuevo tbody").empty();    
	if($("#textoBuscar").val()!="")
	{
		$.ajax({
			type: "POST",
			url: "../procesos/leer.php",	
		    data: "palabra="+$("#textoBuscar").val()+"&subversion="+$("#subversion:checked").val(),
		    dataType: 'json',
		    success: function(response) {
			 for (var i = 0; i < response.length; i=i+6) {
    			 $("#tablaNuevo tbody").append( "<tr>" +
            	"<td align=center >" + response[i+0] + "</td>" +
            	"<td align=center>" + response[i+1] + "</td>" +	            
            	"<td align=center>" + response[i+2] + "</td>" +                        	
            	"<td align=center>" + response[i+3] + "</td>" +  
            	"<td align=center>" + response[i+4] + "</td>" +  
            	"<td align=center>"+'<a target="_blank" class="estilo" href="../procesos/descarga_bitacora.php?id='+response[i+5]+'">Ver</a>'+" "+'<a href="../procesos/descarga_bitacora.php?id='+response[i+5]+'&amp;f=1" class="estilo">Descargar</a>'+"<tr>");                    
    		};         	
		    }
		});  	
	}
	else{
		alert("Indique una palabra antes de continuar");
		$("#textoBuscar").focus();
	}
}