$(document).on("ready", inicio);
$(document).tooltip();
function defecto(e){
	e.preventDefault();
};
function inicio(){	
	var cuantosLi = 0;
        jQuery("ul#nav > li").each(function(index) {
         cuantosLi = cuantosLi+1;
    });
    cuantosLi=cuantosLi+0.5;
	$("ul#nav > li").css('width','calc(100%/'+cuantosLi+')');    
	$("#tipo_user").load("../procesos/carga_usuario.php");
	$("#pais_user").load("../procesos/carga_pais.php");	////carga pais ciudad provincia
	$("#pais_user").change(function (){
		$("#provincia_user").load("../procesos/carga_provincia.php?id="+$("#pais_user").val(),function (){
			$("#ciudad_user").load("../procesos/carga_ciudad.php?id="+$("#provincia_user").val());
		});
	});	////carga pais ciudad provincia
	$("#provincia_user").change(function (){		
		$("#ciudad_user").load("../procesos/carga_ciudad.php?id="+$("#provincia_user").val());

	});	////carga pais ciudad provincia
	$("#categoria_user").load("../procesos/carga_categorias.php");
	$("#departamento_user").load("../procesos/carga_depar.php");
	$('#administracion').on("click",defecto);		
	$('#bandeja').on("click",defecto);		
	$("#cambiar_c").on("click",defecto);
	
	
	$.ajax({
		type: "POST",
		dataType: 'json',
		url: "../procesos/carga_user.php",		
		success: function(response) {
	        var data = response;
	        $("#id_user").val(data[0]);
	        $("#cod_user").val(data[1]);
	        $("#nombre_user").val(data[2]);
	        $("#tel_user").val(data[3]);
	        $("#dir_user").val(data[4]);
	        $("#cel_user").val(data[5]);
	        $("#mail_user").val(data[6]);
	        $("#pais_user").val(data[7]);
	        $("#user_name").val(data[8]);	        
	        $("#provincia_user").load("../procesos/carga_provincia.php?id="+data[7]+"&idp="+data[9],function (){
				$("#ciudad_user").load("../procesos/carga_ciudad.php?id="+data[9]+"&idc="+data[11]);
			});	 	
	        $("#tipo_user").val(data[10]);    
	        $("#institucion").val(data[12]);
	        $("#categoria_user").val(data[13]);
	        $("#departamento_user").val(data[14]);
	    }
	}); 
	/* carga el usuario a modifcar*/

	////////////////////////////////
   	$("#bntModificar").on("click",proceso);   	   	
   	$("#user_name").blur(function (e){
   		nick($("#user_name").val(),"usuario","nick_usuario",4,e);
   	});
   	$("#mail_user").blur(function (e){
   		mail($("#mail_user").val(),"usuario","email_usuario",5,e);
   	});   	
   	
}
function proceso(){
	if($("#nombre_user").val()!="" && $("#dir_user").val()!="" && $("#mail_user").val()!="" && $("#user_name").val()!="" && $("#clave_user").val()!=""){
		var texto=$("#bntModificar").text();			
			$("#form1").submit(function (e){		
				e.preventDefault();
				var valores = $("#form1").serialize();
				$.ajax({
					type: "POST",
					url: "../procesos/procesos_user.php",
		        	data: valores+"&tipo="+"md",
		        	success: function(response) {
		        		var data = response;
		        		if(data==2){		            		
		            		alert("Datos Modificados vuelva a iniciar session para realizar los cambios");
		            		window.location.href="index.php";
			        	}		        			        	
			        }
				});    	
			});			
	}
	else{
		alert("Llene los campos requeridos antes de continuar");
	}			
}