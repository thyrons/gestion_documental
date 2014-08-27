$(document).on("ready", inicio);
$(document).tooltip();
function defecto(e){
	e.preventDefault();
};
function limpiar1(){
	$("#codigo_categoria").val("");
	$("#nombre_categoria").val("");
	$("#id_categoria").val("");
	$("#codigo_categoria").focus();
	$("#btnGuardar1").text("");
	$("#btnGuardar1").append("<i class='fa fa-save'></i> Guardar");
	$("#list1").trigger('reloadGrid');
}
function limpiar2(){
	$("#codigo_departamento").val("");
	$("#nombre_departamento").val("");
	$("#id_departamento").val("");
	$("#codigo_departamento").focus();
	$("#btnGuardar2").text("");
	$("#btnGuardar2").append("<i class='fa fa-save'></i> Guardar");
	$("#list2").trigger('reloadGrid');
}
function limpiar3(){
	$("#codigo_medio").val("");
	$("#nombre_medio").val("");
	$("#id_medio").val("");
	$("#codigo_medio").focus();
	$("#btnGuardar3").text("");
	$("#btnGuardar3").append("<i class='fa fa-save'></i> Guardar");
	$("#list3").trigger('reloadGrid');
}
function limpiar4(){
	$("#codigo_tipo").val("");
	$("#nombre_tipo").val("");
	$("#id_tipo").val("");
	$("#codigo_tipo").focus();
	$("#btnGuardar4").text("");
	$("#btnGuardar4").append("<i class='fa fa-save'></i> Guardar");
	$("#list4").trigger('reloadGrid');
}
function limpiar5(){
	$("#codigo_cliente").val("");
	$("#nombre_cliente").val("");
	$("#id_cliente").val("");
	$("#codigo_cliente").focus();
	$("#btnGuardar5").text("");
	$("#btnGuardar5").append("<i class='fa fa-save'></i> Guardar");
	$("#list5").trigger('reloadGrid');
}
function proceso1(){
	var cont=0;	
	if($("#nombre_categoria").val()==""){
		$("#nombre_categoria").focus();
		cont=1;
	}
	if($("#codigo_categoria").val()==""){
		$("#codigo_categoria").focus();
		cont=2;
	}
	if(cont==0){
		var texto=$("#btnGuardar1").text();		
		if(texto==" Guardar"){		
			$.ajax({
				type: "POST",
				url: "../procesos/categorias.php",
		        data: "codigo=" + $("#codigo_categoria").val() + "&nombre=" + $("#nombre_categoria").val()+"&tipo="+"g",
		        success: function(response) {
		        	var data = response;
		        	if(data==1){
		            	alert("Categroría creada");  
		            	$("#list1").trigger('reloadGrid');
		            	$("#codigo_categoria").val("");     
		            	$("#nombre_categoria").val("");
		            	$("#codigo_categoria").focus();     
		        	}
		        	if(data==2){
		            	alert("Error.. este codigo ya existe");          
		            	$("#codigo_categoria").val("");
		            	$("#codigo_categoria").focus();
		        	}
		        	if(data==3){
		            	alert("Error.. este nombre ya existe");          
		            	$("#nombre_categoria").val("");
		            	$("#nombre_categoria").focus();
		        	}
		        }
			});    	
		}
		if(texto==" Modificar"){
			$.ajax({
			type: "POST",
			url: "../procesos/categorias.php",
	        data: "id="+$("#id_categoria").val()+"&codigo=" + $("#codigo_categoria").val() + "&nombre=" + $("#nombre_categoria").val()+"&tipo="+"m",
	        success: function(response) {
	        	var data = response;
	        	if(data==1){
	            	alert("Categroría Modificada");  
	            	$("#codigo_categoria").val("");     
	            	$("#nombre_categoria").val("");
	            	$("#codigo_categoria").focus();               	 
					$("#btnGuardar1").text("");
					$("#btnGuardar1").append("<i class='fa fa-save'></i> Guardar");	  
					$("#id_categoria").val("");
					$("#list1").trigger('reloadGrid');
	        	}
	        	if(data==2){
		           	alert("Error.. este codigo ya existe");          	           
		           	$("#codigo_categoria").focus();
		        }
		        if(data==3){
		           	alert("Error.. este nombre ya existe");          	           	
		           	$("#nombre_categoria").focus();
		        }        	
	        }
		});    
		}
	}
	if(cont!=0){
		alert("Llene todos los datos antes de continuar");
	}
}
function proceso2(){	
	var cont=0;
	if($("#codigo_departamento").val()==""){
		$("#codigo_departamento").focus();
		cont=1;
	}
	if($("#nombre_departamento").val()==""){
		$("#nombre_departamento").focus();
		cont=2;
	}	
	if(cont==0){
	var texto=$("#btnGuardar2").text();		
	if(texto==" Guardar"){		
		$.ajax({
			type: "POST",
			url: "../procesos/departamento.php",
	        data: "codigo=" + $("#codigo_departamento").val() + "&nombre=" + $("#nombre_departamento").val()+"&tipo="+"g",
	        success: function(response) {
	        	var data = response;
	        	if(data==1){
	            	alert("Departamento creado");  
	            	$("#list2").trigger('reloadGrid');
	            	$("#codigo_departamento").val("");     
	            	$("#nombre_departamento").val("");
	            	$("#codigo_departamento").focus();     
	        	}
	        	if(data==2){
	            	alert("Error.. este codigo ya existe");          
	            	$("#codigo_departamento").val("");
	            	$("#codigo_departamento").focus();
	        	}
	        	if(data==3){
	            	alert("Error.. este nombre ya existe");          
	            	$("#nombre_departamento").val("");
	            	$("#nombre_departamento").focus();
	        	}
	        }
		});    	
	}
	if(texto==" Modificar"){
		$.ajax({
		type: "POST",
		url: "../procesos/departamento.php",
        data: "id="+$("#id_departamento").val()+"&codigo=" + $("#codigo_departamento").val() + "&nombre=" + $("#nombre_departamento").val()+"&tipo="+"m",
        success: function(response) {
        	var data = response;
        	if(data==1){
            	alert("Departamento Modificado");  
            	$("#codigo_departamento").val("");     
            	$("#nombre_departamento").val("");
            	$("#codigo_departamento").focus();               	 
				$("#btnGuardar2").text("");
				$("#btnGuardar2").append("<i class='fa fa-save'></i> Guardar");	  
				$("#id_departamento").val("");
				$("#list2").trigger('reloadGrid');
        	}        	
        	if(data==2){
	           	alert("Error.. este codigo ya existe");          	           
	           	$("#codigo_departamento").focus();
	        }
	        if(data==3){
	           	alert("Error.. este nombre ya existe");          	           	
	           	$("#nombre_departamento").focus();
	        }
        }
	});    
	}
	}	
	if(cont!=0){
		alert("Llene todos los datos antes de continuar");
	}
}
function proceso3(){
	var cont=0;
	if($("#nombre_medio").val()==""){
		$("#nombre_medio").focus();
		cont=1;
	}
	if($("#codigo_medio").val()==""){
		$("#codigo_medio").focus();
		cont=2;
	}	
	if(cont==0){
		var texto=$("#btnGuardar3").text();		
		if(texto==" Guardar"){		
			$.ajax({
				type: "POST",
				url: "../procesos/medio_recepcion.php",
		        data: "codigo=" + $("#codigo_medio").val() + "&nombre=" + $("#nombre_medio").val()+"&tipo="+"g",
		        success: function(response) {
		        	var data = response;
		        	if(data==1){
		            	alert("Medio de recepción creado");  
		            	$("#codigo_medio").val("");     
		            	$("#nombre_medio").val("");
		            	$("#codigo_medio").focus();     
		            	$("#list3").trigger('reloadGrid');
		        	}
		        	if(data==2){
		            	alert("Error.. este codigo ya existe");          
		            	$("#codigo_medio").val("");
		            	$("#codigo_medio").focus();
		        	}
		        	if(data==3){
		            	alert("Error.. este nombre ya existe");          
		            	$("#nombre_medio").val("");
		            	$("#nombre_medio").focus();
		        	}
		        }
			});    	
		}
		if(texto==" Modificar"){
			$.ajax({
			type: "POST",
			url: "../procesos/medio_recepcion.php",
	        data: "id="+$("#id_medio").val()+"&codigo=" + $("#codigo_medio").val() + "&nombre=" + $("#nombre_medio").val()+"&tipo="+"m",
	        success: function(response) {
	        	var data = response;
	        	if(data==1){
	            	alert("Medio de recepción modificado");  
	            	$("#list3").trigger('reloadGrid');
	            	$("#codigo_medio").val("");     
	            	$("#nombre_medio").val("");
	            	$("#codigo_medio").focus();               	 
					$("#btnGuardar3").text("");
					$("#btnGuardar3").append("<i class='fa fa-save'></i> Guardar");	  
					$("#id_medio").val("");
	        	} 
	        	if(data==2){
		           	alert("Error.. este codigo ya existe");          	           
		           	$("#codigo_medio").focus();
		        }
		        if(data==3){
		           	alert("Error.. este nombre ya existe");          	           	
		           	$("#nombre_medio").focus();
		        }       	
	        }
		});    
		}
	}	
	if(cont!=0){
		alert("Llene todos los datos antes de continuar");
	}
}
function proceso4(){
	var cont=0;
	if($("#nombre_doc").val()==""){
		$("#nombre_doc").focus();
		cont=1;
	}
	if($("#codigo_doc").val()==""){
		$("#codigo_doc").focus();
		cont=2;
	}	
	if(cont==0){
		var texto=$("#btnGuardar4").text();		
		if(texto==" Guardar"){		
			$.ajax({
				type: "POST",
				url: "../procesos/tipo_documento.php",
		        data: "codigo=" + $("#codigo_doc").val() + "&nombre=" + $("#nombre_doc").val()+"&tipo="+"g",
		        success: function(response) {
		        	var data = response;
		        	if(data==1){
		            	alert("Tipo Documento creado");  
		            	$("#codigo_doc").val("");     
		            	$("#codigo_doc").val("");
		            	$("#codigo_doc").focus();     
		            	$("#list4").trigger('reloadGrid');
		        	}
		        	if(data==2){
		            	alert("Error.. este codigo ya existe");          
		            	$("#codigo_doc").val("");
		            	$("#codigo_doc").focus();
		        	}
		        	if(data==3){
		            	alert("Error.. este nombre ya existe");          
		            	$("#nombre_doc").val("");
		            	$("#nombre_doc").focus();
		        	}
		        }
			});    	
		}
		if(texto==" Modificar"){
			$.ajax({
			type: "POST",
			url: "../procesos/tipo_documento.php",
	        data: "id="+$("#id_tipo_documento").val()+"&codigo=" + $("#codigo_doc").val() + "&nombre=" + $("#nombre_doc").val()+"&tipo="+"m",
	        success: function(response) {
	        	var data = response;
	        	if(data==1){
	            	alert("Tipo de documento modificado");  
	            	$("#list4").trigger('reloadGrid');
	            	$("#codigo_doc").val("");     
	            	$("#nombre_doc").val("");
	            	$("#codigo_doc").focus();               	 
					$("#btnGuardar4").text("");
					$("#btnGuardar4").append("<i class='fa fa-save'></i> Guardar");	  
					$("#id_tipo_documento").val("");
	        	}      
	        	if(data==2){
		           	alert("Error.. este codigo ya existe");          	           
		           	$("#codigo_doc").focus();
		        }
		        if(data==3){
		           	alert("Error.. este nombre ya existe");          	           	
		           	$("#nombre_doc").focus();
		        }     	
	        }
		});    
		}
	}
	if(cont!=0){
		alert("Llene todos los datos antes de continuar");
	}
}
function proceso5(){
	var cont=0;
	if($("#nombre_tipo").val()==""){
		$("#nombre_tipo").focus();
		cont=1;
	}	
	if(cont==0){
		var texto=$("#btnGuardar5").text();		
		if(texto==" Guardar"){		
			$.ajax({
				type: "POST",
				url: "../procesos/tipo_cliente.php",
		        data: "nombre=" + $("#nombre_tipo").val()+"&tipo="+"g",
		        success: function(response) {
		        	var data = response;
		        	if(data==1){
		            	alert("Tipo cliente creado");  		            	  
		            	$("#nombre_tipo").val("");
		            	$("#nombre_tipo").focus();     
		            	$("#list5").trigger('reloadGrid');
		        	}
		        	if(data==2){
		            	alert("Error.. este codigo ya existe");          
		            	$("#nombre_tipo").val("");
		            	$("#nombre_tipo").focus();
		        	}		        	
		        }
			});    	
		}
		if(texto==" Modificar"){
			$.ajax({
			type: "POST",
			url: "../procesos/tipo_cliente.php",
	        data: "id="+$("#id_tipo_usuario").val()+"&nombre=" + $("#nombre_tipo").val()+"&tipo="+"m",
	        success: function(response) {
	        	var data = response;
	        	if(data==1){
	            	alert("Tipo de documento modificado");  
	            	$("#list5").trigger('reloadGrid');	            	  
	            	$("#nombre_tipo").val("");
	            	$("#nombre_tipo").focus();               	 
					$("#btnGuardar5").text("");
					$("#btnGuardar5").append("<i class='fa fa-save'></i> Guardar");	  
					$("#id_tipo_usuario").val("");
	        	}      
	        	if(data==2){
		           	alert("Error.. este codigo ya existe");          	           
		           	$("#nombre_tipo").focus();
		        }		         	
	        }
		});    
		}
	}
	if(cont!=0){
		alert("Llene todos los datos antes de continuar");
	}
}


function inicio(){	
var cuantosLi = 0;
        jQuery("ul#nav > li").each(function(index) {
         cuantosLi = cuantosLi+1;
    });
    cuantosLi=cuantosLi+0.5;
	$("ul#nav > li").css('width','calc(100%/'+cuantosLi+')');    		
	$('#formularios a').on("click",defecto);
	$("#btnLimpiar1").on("click",limpiar1);
	$("#btnLimpiar2").on("click",limpiar2);
	$("#btnLimpiar3").on("click",limpiar3);
	$("#btnLimpiar4").on("click",limpiar4);
	$("#btnLimpiar5").on("click",limpiar5);
	$("#btnGuardar1").on("click",proceso1);
	$("#btnGuardar2").on("click",proceso2);
	$("#btnGuardar3").on("click",proceso3);
	$("#btnGuardar4").on("click",proceso4);
	$("#btnGuardar5").on("click",proceso5);	
	$(window).bind('resize', function() {
        jQuery("#list1").setGridWidth($('#medio1').width());
    }).trigger('resize');
    $(window).bind('resize', function() {
        jQuery("#list2").setGridWidth($('#medio2').width());
    }).trigger('resize');
    $(window).bind('resize', function() {
        jQuery("#list3").setGridWidth($('#medio3').width());
    }).trigger('resize');
    $(window).bind('resize', function() {
        jQuery("#list4").setGridWidth($('#medio4').width());
    }).trigger('resize');
    $(window).bind('resize', function() {
        jQuery("#list5").setGridWidth($('#medio5').width());
    }).trigger('resize');
	jQuery("#list1").jqGrid({
        url: '../xml/xmlCategoria.php',
        datatype: 'xml',
        colNames: ['Id Categoría', 'Código Categoría','Nombre Categoría'],
        colModel: [
            {name: 'id_categoria', index: 'id_categoria', editable: true, align: 'center', search: false,},            
            {name: 'codigo_categoria', index: 'codigo_categoria', editable: false, align: 'center', search: true,},            
            {name: 'nombre_categoria', index: 'nombre_categoria', editable: false, align: 'center', search: true,},            
        ],
        rowNum: 10,
        rowList: [10,20,30],
              
        pager: jQuery('#pager1'),        
        sortname: 'id_categoria',
        shrinkToFit: true,
        sortordezr: 'asc',
        caption: 'Lista de Categorias',
        viewrecords: true,   
        ondblClickRow:function(){
			var gsr = jQuery("#list1").jqGrid('getGridParam','selrow');			
			jQuery("#list1").jqGrid('GridToForm',gsr,"#form1");			
			$("#btnGuardar1").text("");
			$("#btnGuardar1").append("<i class='fa fa-file-text-o'></i> Modificar");					
		}      
    	}).jqGrid('navGrid', '#pager1',
            {
                add: false,
                edit: false,
                del: false,
                refresh: true,
                search: true,
                view: false,               
            }); 
        jQuery("#list1").setGridWidth($('#medio1').width());   
        /////////////////////////
        jQuery("#list2").jqGrid({
        url: '../xml/xmlDepartamento.php',
        datatype: 'xml',
        colNames: ['Id Departamento', 'Código','Nombre'],
        colModel: [
            {name: 'id_departamento', index: 'id_departamento', editable: true, align: 'center', search: false,},            
            {name: 'codigo_departamento', index: 'codigo_departamento', editable: false, align: 'center', search: true,},
            {name: 'nombre_departamento', index: 'nombre_departamento', editable: false, align: 'center', search: true, },
        ],
        rowNum: 10,
        rowList: [10,20,30],
              
        pager: jQuery('#pager2'),        
        sortname: 'id_departamento',
        shrinkToFit: true,
        sortordezr: 'asc',
        caption: 'Lista de Departamentos',
        viewrecords: true,   
        ondblClickRow:function(){
			var gsr = jQuery("#list2").jqGrid('getGridParam','selrow');			
			jQuery("#list2").jqGrid('GridToForm',gsr,"#form2");			
			$("#btnGuardar2").text("");
			$("#btnGuardar2").append("<i class='fa fa-file-text-o'></i> Modificar");					
		}      
    	}).jqGrid('navGrid', '#pager2',
            {
                add: false,
                edit: false,
                del: false,
                refresh: true,
                search: true,
                view: false,               
            }); 
        jQuery("#list2").setGridWidth($('#medio2').width());   
        //////////////////////////
        jQuery("#list3").jqGrid({
        url: '../xml/xmlMedio.php',
        datatype: 'xml',
        colNames: ['Id Medio de recepción', 'Código','Medio de recepción'],
        colModel: [
            {name: 'id_medio', index: 'id_medio', editable: true, align: 'center', search: false,},            
            {name: 'codigo_medio', index: 'codigo_medio', editable: false, align: 'center', search: true,},
            {name: 'nombre_medio', index: 'nombre_medio', editable: false, align: 'center', search: true, },
        ],
         rowNum: 10,
        rowList: [10,20,30],
              
        pager: jQuery('#pager3'),        
        sortname: 'id_medio',
        shrinkToFit: true,
        sortordezr: 'asc',
        caption: 'Lista de Medios de recepción',
        viewrecords: true,   
        ondblClickRow:function(){
			var gsr = jQuery("#list3").jqGrid('getGridParam','selrow');			
			jQuery("#list3").jqGrid('GridToForm',gsr,"#form3");			
			$("#btnGuardar3").text("");
			$("#btnGuardar3").append("<i class='fa fa-file-text-o'></i> Modificar");					
		}      
    	}).jqGrid('navGrid', '#pager3',
            {
                add: false,
                edit: false,
                del: false,
                refresh: true,
                search: true,
                view: false,               
            }); 
        jQuery("#list3").setGridWidth($('#medio3').width());   
        //////////////////////
        jQuery("#list4").jqGrid({
        url: '../xml/xmlTipoDocumento.php',
        datatype: 'xml',
        colNames: ['Id Tipo Documento', 'Código','Tipo Documento'],
        colModel: [
            {name: 'id_tipo_documento', index: 'id_tipo_documento', editable: true, align: 'center', search: false,},                                    
            {name: 'codigo_doc', index: 'codigo_doc', editable: false, align: 'center', search: true,},
            {name: 'nombre_doc', index: 'nombre_doc', editable: false, align: 'center', search: true, },
        ],
        rowNum: 10,
        rowList: [10,20,30],
              
        pager: jQuery('#pager4'),        
        sortname: 'id_tipo_documento',
        shrinkToFit: true,
        sortordezr: 'asc',
        caption: 'Lista de Tipos de Documentos',
        viewrecords: true,   
        ondblClickRow:function(){
			var gsr = jQuery("#list4").jqGrid('getGridParam','selrow');			
			jQuery("#list4").jqGrid('GridToForm',gsr,"#form4");			
			$("#btnGuardar4").text("");
			$("#btnGuardar4").append("<i class='fa fa-file-text-o'></i> Modificar");					
		}      
    	}).jqGrid('navGrid', '#pager4',
            {
                add: false,
                edit: false,
                del: false,
                refresh: true,
                search: true,
                view: false,               
            }); 
        jQuery("#list4").setGridWidth($('#medio4').width()); 
        ////////////////////  
        jQuery("#list5").jqGrid({
        url: '../xml/xmlCliente.php',
        datatype: 'xml',
        colNames: ['Id Usuario','Nombre usuario'],
        colModel: [
            {name: 'id_tipo_usuario', index: 'id_tipo_usuario', editable: true, align: 'center', search: true,},                        
            {name: 'nombre_tipo', index: 'nombre_tipo', editable: false, align: 'center', search: true, },
        ],
        rowNum: 10,
        rowList: [10,20,30],
              
        pager: jQuery('#pager5'),        
        sortname: 'id_tipo_usuario',
        shrinkToFit: true,
        sortordezr: 'asc',
        caption: 'Lista de Tipos de usuarios',
        viewrecords: true,   
        ondblClickRow:function(){
			var gsr = jQuery("#list5").jqGrid('getGridParam','selrow');			
			jQuery("#list5").jqGrid('GridToForm',gsr,"#form5");			
			$("#btnGuardar5").text("");
			$("#btnGuardar5").append("<i class='fa fa-file-text-o'></i> Modificar");					
		}      
    	}).jqGrid('navGrid', '#pager5',
            {
                add: false,
                edit: false,
                del: false,
                refresh: true,
                search: true,
                view: false,               
            }); 
        jQuery("#list5").setGridWidth($('#medio5').width());   
        
	}