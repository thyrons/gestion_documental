$(document).on("ready",inicio);
$(document).tooltip();
var dialog9=
{
	autoOpen:false,
	resizable:false,	
	draggable:false,	
	modal:true,
	width:290,	
	position: 'center',
	closeOnEscape:false,	

};
function inicio(){
	$("#frmCambioPass").dialog(dialog9);
	$("#btnNuevaPass").click(function(e){
		e.preventDefault();
	});	
	$("#cambiar_c").click(function (){
		$("#frmCambioPass").dialog("open");
		$.ajax({				
			type: "POST",
			dataType: 'json',
	    	url: "../procesos/carga_pass.php",			
		    success: function(data) {	
		    	$("#txtPass1").val(data[0]);
		    	$("#txtPass2").focus();
			}
		}); 	
	});
	$("#btnNuevaPass").on("click",entrar);	
	$('input[type=password]').on("keyup",enter);	
}
var timerid;
$(window).resize(function () {
    (timerid && clearTimeout(timerid));
    timerid = setTimeout(function () {        
    $("#frmCambioPass").dialog("option","position","center");
    }, 200);
});
function entrar(){
	var pass=encripta=Base64.encode($("#txtPass2").val());//encripto la cadena
	var pass1=encripta=Base64.encode($("#txtPass3").val());
	$.ajax({				
		type: "POST",
	    url: "../procesos/cambio_pass.php",
		data :"pass="+pass+"&pass1="+pass1,
	    success: function(data) {
			val=data;
			if(val==0)
			{
				 alert("Contraseña cambiada con exito");
				 $("#txtPass1").val("");
				 $("#txtPass2").val("");
				 $("#txtPass3").val("");
				 $("#frmCambioPass").dialog("close");				 
			}   
			if(val==1)
			{					
				alert("Error.. clave incorrecta ingrese nuevamente");
				$("#txtPass2").focus();
				$("#txtPass2").val("");
				$("#txtPass3").val("");
				$("#frmCambioPass").effect("shake");	
			}   
			
		}
	}); 	
}
function enter(event){
	if (event.which == 13 || event.keyCode == 13) {
    	entrar();
    	return false;
    }
    return true;
}