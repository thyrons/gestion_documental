$(document).on("ready",inicio);
$(document).tooltip();
var dialog=
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
	
	$("#frmLogin").dialog(dialog);
	$("a").click(function(e){
		e.preventDefault();
	});	
	$("#sistema").click(function (){
		$("#frmLogin").dialog("open");
	});
	$("#mies").click(function (){
		window.open("http://www.inclusion.gob.ec/");
	});
	$("#btnIngresar").on("click",entrar);
	$('input[type=text]').on("keyup",enter);
	$('input[type=password]').on("keyup",enter);
	$("#btnRegistro").click(function (){
		location.href = "../paginas/registro.php";
	});
}
var timerid;
$(window).resize(function () {
    (timerid && clearTimeout(timerid));
    timerid = setTimeout(function () {        
    $("#frmLogin").dialog("option","position","center");
    }, 200);
});
function entrar(){
	var pass=encripta=Base64.encode($("#txtPass").val());//encripto la cadena
	$.ajax({				
		type: "POST",
	    url: "../procesos/login.php",
		data :"user="+$("#txtUser").val()+"&pass="+pass,
	    success: function(data) {
			val=data;
			if(val==0)
			{
				 location.href = "../paginas/bienvenido.php";
			}   
			if(val==1)
			{					
				alert("Error.. clave incorrecta ingrese nuevamente");
				$("#txtPass").focus();
				$("#txtPass").val("");
				$("#frmLogin").effect("shake");	
			}   
			if(val==2){
				alert("Error.. el usuario no exisite");
				$("#txtUser").focus();
				$("#txtUser").val("");
				$("#frmLogin").effect("shake");	
			}
			if(val==3){
				$("#frmLogin").effect("shake");	
				alert("Ingrese un usuario y una clave");
				limpiar();
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