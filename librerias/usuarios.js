$(document).on("ready", inicio);
$(document).tooltip();
var d = new Date();
var month = d.getMonth()+1;
var day = d.getDate();
var output = d.getFullYear() + '-' +
    ((''+month).length<2 ? '0' : '') + month + '-' +
    ((''+day).length<2 ? '0' : '') + day;
var fecha={
   dateFormat: 'yy-mm-dd',
   changeYear: true,
   changeMonth: true,
   showButtonPanel: true,
   showOtherMonths: true,
   selectOtherMonths: true,   
};
function defecto(e){
	e.preventDefault();
};
function limpiar(){	
	$("input").val("");
	$("#btnGuardar").text("");
	$("#btnGuardar").append("<i class='fa fa-save'></i> Guardar");
	$("#medioUser").hide("slow");	
	$("#list").trigger('reloadGrid');
}
function buscar(){			
	$("#list").trigger('reloadGrid');
	$("#medioUser").show("slow");	
}
function inicio(){	
	$( "#fecha_nacimiento" ).val(output);
	$( "#fecha_nacimiento" ).datepicker(fecha);
	var cuantosLi = 0;
        jQuery("ul#nav > li").each(function(index) {
         cuantosLi = cuantosLi+1;
    });
    cuantosLi=cuantosLi+0.5;
	$("ul#nav > li").css('width','calc(100%/'+cuantosLi+')');    
	$("#bntVolover").click(function (){
		location.href='index.php';
	});
	$("#btnLimpiar").on("click",limpiar);
	$("#btnBuscar").on("click",buscar);
	var pag=document.URL;
	pag=pag.substr(-12);
	if(pag=="registro.php"){
		$("#tipo_user").load("../procesos/carga_usuario1.php");
	}	
	else{
		$("#tipo_user").load("../procesos/carga_usuario.php");
	}
	$("#pais_user").load("../procesos/carga_pais.php",function (){
		$("#provincia_user").load("../procesos/carga_provincia.php?id="+$("#pais_user").val(),function (){
			$("#ciudad_user").load("../procesos/carga_ciudad.php?id="+$("#provincia_user").val());
		});
	});	////carga pais ciudad provincia
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
	$('#formularios a').on("click",defecto);		
	
	$(window).bind('resize', function() {
        jQuery("#list").setGridWidth($('#medioUser').width()-50);
    }).trigger('resize');  
	jQuery("#list").jqGrid({
        url: '../xml/xmlUsuario.php',
        datatype: 'xml',
        colNames: ['Id Pais', 'Código Usuario', 'Nombres Completos', 'Teléfono', 'Celular', 'Dirección', 'Correo Electrónico', 'id_tipo_user', 'Tipo de Usuario','Nombre de usuario','id_pais', 'Nombre País', 'id_provincia', 'Nombre Provincia','id_ciudad','Nombre Ciudad','Contraseña','Institución','id_categoria','Categoría','id_departamento','Departamento','Tipo Sangre','Fecha Nacimiento','Sexo','Estado Civil'],
        colModel: [
            {name: 'id_user', index: 'id_user', editable: true, align: 'center', search: false,editoptions: {readonly: 'readonly', size: 40}, editrules: {edithidden: false}},            
            {name: 'cod_user', index: 'cod_user', editable: false, align: 'center', search: true,},            
            {name: 'nombre_user', index: 'nombre_user', editable: false, align: 'center', search: true,},            
            {name: 'tel_user', index: 'tel_user', editable: false, align: 'center', search: false,},            
            {name: 'cel_user', index: 'cel_user', editable: false, align: 'center', search: false,},            
            {name: 'dir_user', index: 'dir_user', editable: false, align: 'center', search: false,},                        
            {name: 'mail_user', index: 'mail_user', editable: false, align: 'center', search: false,},            
            {name: 'id_tipo_user', index: 'id_tipo_user', editable: false, align: 'center', search: false,editoptions: {readonly: 'readonly', size: 40},hidden: true, editrules: {edithidden: false}},                        
            {name: 'tipo_user', index: 'tipo_user', editable: false, align: 'center', search: false,},                        
            {name: 'user_name', index: 'user_name', editable: false, align: 'center', search: false,},            
            {name: 'id_pais_user', index: 'id_pais_user', editable: false, align: 'center', search: false,editoptions: {readonly: 'readonly', size: 40},hidden: true, editrules: {edithidden: false}},                        
            {name: 'pais_user', index: 'pais_user', editable: false, align: 'center', search: false,},                        
            {name: 'id_provincia_user', index: 'id_provincia_user', editable: false, align: 'center', search: false,editoptions: {readonly: 'readonly', size: 40},hidden: true, editrules: {edithidden: false}},                        
            {name: 'provincia_user', index: 'provincia_user', editable: false, align: 'center', search: false,},                        
            {name: 'id_ciudad_user', index: 'id_ciudad_user', editable: false, align: 'center', search: false,editoptions: {readonly: 'readonly', size: 40},hidden: true, editrules: {edithidden: false}},                        
            {name: 'ciudad_user', index: 'ciudad_user', editable: false, align: 'center', search: false,},                        
            {name: 'clave_user', index: 'clave_user', editable: false, align: 'center', search: false,editoptions: {readonly: 'readonly', size: 40},hidden: true, editrules: {edithidden: false}},                        
            {name: 'institucion', index: 'institucion', editable: false, align: 'center', search: false,},     
            {name: 'id_categoria_user', index: 'id_categoria_user', editable: false, align: 'center', search: false,editoptions: {readonly: 'readonly', size: 40},hidden: true, editrules: {edithidden: false}},                        
            {name: 'categoria_user', index: 'categoria_user', editable: false, align: 'center', search: false,},                        
            {name: 'id_departamento', index: 'id_departamento', editable: false, align: 'center', search: false,editoptions: {readonly: 'readonly', size: 40},hidden: true, editrules: {edithidden: false}},                        
            {name: 'departamento_user', index: 'departamento_user', editable: false, align: 'center', search: false,editoptions: {readonly: 'readonly', size: 40}},                        
            {name: 'tipo_sangre_user', index: 'tipo_sangre_user', editable: false, align: 'center', search: false,},                        
            {name: 'fecha_nacimiento', index: 'fecha_nacimiento', editable: false, align: 'center', search: false,},                        
            {name: 'sexo', index: 'sexo', editable: false, align: 'center', search: false,},                        
            {name: 'estado_civil', index: 'estado_civil', editable: false, align: 'center', search: false,},                        
        ],
        rowNum: 10,
        rowList: [10,20,30],
              
        pager: jQuery('#pager'),        
        sortname: 'id_usuario',
        shrinkToFit: false,
        sortordezr: 'asc',
        caption: 'Lista de Países',
        viewrecords: true,   
        ondblClickRow:function(){
			var gsr = jQuery("#list").jqGrid('getGridParam','selrow');			
			var ret = jQuery("#list").jqGrid('getRowData',gsr);				
			jQuery("#list").jqGrid('GridToForm',gsr,"#form1");			
			$("#btnGuardar").text("");
			$("#btnGuardar").append("<i class='fa fa-file-text-o'></i> Modificar");
			$("#provincia_user").load("../procesos/carga_provincia.php?id="+$("#pais_user").val()+"&idp="+ret.id_provincia_user,function (){
				$("#ciudad_user").load("../procesos/carga_ciudad.php?id="+$("#provincia_user").val()+"&idc="+ret.id_provincia_user);
			});	
			$("#btnGuardar").text("");
			$("#btnGuardar").append("<i class='fa fa-file-text-o'></i> Modificar");	 	
			$("#medioUser").hide("fast");			
		}      
    	}).jqGrid('navGrid', '#pager',
            {
                add: false,
                edit: false,
                del: false,
                refresh: true,
                search: true,
                view: false,               
        }); 
   	jQuery("#list").setGridWidth($('#medioUser').width()-50);    
   	$("#btnGuardar").on("click",proceso);   	
   	$("#cod_user").blur(function (e){
   		codigo($("#cod_user").val(),"usuario","cod_usuario",1,e);
   	});
   	$("#user_name").blur(function (e){
   		var texto=$("#btnGuardar").text();		
		if(texto==" Guardar"){	
   			nick($("#user_name").val(),"usuario","nick_usuario",2,e);
   		}
   		else{   			
   			nick($("#user_name").val(),"usuario","nick_usuario",4,e);	
   		}
   	});
   	$("#mail_user").blur(function (e){
   		var texto=$("#btnGuardar").text();		
		if(texto==" Guardar"){	
   			mail($("#mail_user").val(),"usuario","email_usuario",3,e);
   		}
   		else{
   			mail($("#mail_user").val(),"usuario","email_usuario",5,e);	
   		}
   	});
   	$("#clave_user").focus(function (){
   		$("#clave_user").val("");
   	});
   	$("#clave_user").blur(function (e){   		
   		$("#clave_user").val(encripta=Base64.encode($("#clave_user").val()));//encripto la cadena
   	});
   	
}
function proceso(){
	if($("#nombre_user").val()!="" && $("#dir_user").val()!="" && $("#mail_user").val()!="" && $("#user_name").val()!="" && $("#clave_user").val()!="" && $("#fecha_nacimiento").val()!=""){
		var texto=$("#btnGuardar").text();		
		if(texto==" Guardar"){	
			$("#form1").submit(function (e){		
				e.preventDefault();
				var valores = $("#form1").serialize();
				$.ajax({
					type: "POST",
					url: "../procesos/procesos_user.php",
		        	data: valores+"&tipo="+"g",
		        	success: function(response) {
		        		var data = response;
		        		if(data==1){		            		
		            		alert("Datos Guardados");
		            		location.reload();
//		            		location.href='index.php';
			        	}		        			        	
			        }
				});    	
			});
		}
		if(texto==" Modificar"){	
			$("#form1").submit(function (e){		
				e.preventDefault();
				var valores = $("#form1").serialize();
				$.ajax({
					type: "POST",
					url: "../procesos/procesos_user.php",
		        	data: valores+"&tipo="+"m",
		        	success: function(response) {
		        		var data = response;
		        		if(data==2){		            		
		            		alert("Datos Modificados");
		            		location.reload();
			        	}		        			        	
			        }
				});
			});	
		}
	}
	else{
		alert("Llene los campos requeridos antes de continuar");
	}			
}