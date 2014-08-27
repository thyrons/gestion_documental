$(document).on("ready",inicio);
$(document).tooltip();
function inicio (){
	$.ajax({        
    	type: "POST",    	
    	url: "../procesos/numeros.php",    	
    	data :"iden="+"e",
    	success: function(response) {     
    		$("#dc").text("Documentos Enviados ("+response+")");		
    	}    
    });
    $.ajax({        
    	type: "POST",    	
    	url: "../procesos/numeros.php",    	
    	data :"iden="+"r",
    	success: function(response) {     
    		$("#de").text("Documentos Recibidos ("+response+")");		
    	}    
    });
	

}