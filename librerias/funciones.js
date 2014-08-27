function codigo(valor,tabla,campo,funcion,e){	
	var idcampo=e.currentTarget.id;
	var resp;
	$.ajax({		
		type: "POST",
		url: "../procesos/funciones.php",
      	data: "valor="+valor+"&tabla="+tabla+"&campo="+campo+"&funcion="+funcion,
		success: function(ex) {
		 	resp=ex; 
		 	resp=$.trim(resp);
		 	if(resp==1){		 		
		 		alert("Éste código ya esta en uso seleccione otro");
		 		$("#"+idcampo).focus();
		 		$("#"+idcampo).val("");
		 	}
		}		
	});	
}
function nick(valor,tabla,campo,funcion,e){	
	var idcampo=e.currentTarget.id;
	var resp;
	$.ajax({		
		type: "POST",
		url: "../procesos/funciones.php",
      	data: "valor="+valor+"&tabla="+tabla+"&campo="+campo+"&funcion="+funcion,
		success: function(ex) {
		 	resp=ex; 
		 	resp=$.trim(resp);
		 	if(resp==1){		 		
		 		alert("Éste nombre de usuario ya esta en uso seleccione otro");
		 		$("#"+idcampo).focus();
		 		$("#"+idcampo).val("");
		 	}
		}		
	});	
}
function mail(valor,tabla,campo,funcion,e){	
	var idcampo=e.currentTarget.id;
	var resp;
	$.ajax({		
		type: "POST",
		url: "../procesos/funciones.php",
      	data: "valor="+valor+"&tabla="+tabla+"&campo="+campo+"&funcion="+funcion,
		success: function(ex) {
		 	resp=ex; 
		 	resp=$.trim(resp);
		 	if(resp==1){		 		
		 		alert("Éste correo electrónico ya esta en uso seleccione otro");
		 		$("#"+idcampo).focus();
		 		$("#"+idcampo).val("");
		 	}
		}		
	});	
}
function nick1(valor,tabla,campo,funcion,e){	
	var idcampo=e.currentTarget.id;
	var resp;
	$.ajax({		
		type: "POST",
		url: "../procesos/funciones.php",
      	data: "valor="+valor+"&tabla="+tabla+"&campo="+campo+"&funcion="+funcion,
		success: function(ex) {
		 	resp=ex; 
		 	resp=$.trim(resp);
		 	if(resp==1){		 		
		 		alert("Éste nombre de usuario ya esta en uso seleccione otro");
		 		$("#"+idcampo).focus();
		 		$("#"+idcampo).val("");
		 	}
		}		
	});	
}
function mail1(valor,tabla,campo,funcion,e){	
	var idcampo=e.currentTarget.id;
	var resp;
	$.ajax({		
		type: "POST",
		url: "../procesos/funciones.php",
      	data: "valor="+valor+"&tabla="+tabla+"&campo="+campo+"&funcion="+funcion,
		success: function(ex) {
		 	resp=ex; 
		 	resp=$.trim(resp);
		 	if(resp==1){		 		
		 		alert("Éste correo electrónico ya esta en uso seleccione otro");
		 		$("#"+idcampo).focus();
		 		$("#"+idcampo).val("");
		 	}
		}		
	});	
}