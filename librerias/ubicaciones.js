$(document).on("ready", inicio);
$(document).tooltip();
function defecto(e){
	e.preventDefault();
};
function limpiar(){
	$("#nombre_pais").val("");
	$("#id_pais").val("");
	$("#nombre_pais").focus();
	$("#btnGuardar").text("");
	$("#btnGuardar").append("<i class='fa fa-save'></i> Guardar");
	$("#list").trigger('reloadGrid');
}
function limpiar1(){
	$("#nombre_provincia").val("");
	$("#id_provincia").val("");
	$("#nombre_provincia").focus();
	$("#btnGuardar1").text("");	
	$("#btnGuardar1").append("<i class='fa fa-save'></i> Guardar");
	$("#list1").trigger('reloadGrid');
}
function limpiar2(){
	$("#nombre_ciudad").val("");
	$("#id_ciudad").val("");
	$("#nombre_ciudad").focus();
	$("#btnGuardar2").text("");
	$("#btnGuardar2").append("<i class='fa fa-save'></i> Guardar");
	$("#list2").trigger('reloadGrid');
}
function proceso(){
	var cont=0;
	if($("#nombre_pais").val()==""){
		$("#nombre_pais").focus();
		cont=1;
	}	
	if(cont==0){
		var texto=$("#btnGuardar").text();		
		if(texto==" Guardar"){		
			$.ajax({
				type: "POST",
				url: "../procesos/pais.php",
		        data: "pais=" + $("#nombre_pais").val() + "&tipo="+"g",
		        success: function(response) {
		        	var data = response;
		        	if(data==1){
		            	alert("País Creado");  
		            	$("#list").trigger('reloadGrid');
		            	$("#nombre_pais").val("");     		            	
		            	$("#nombre_pais").focus();  
		            	$("#select_pais").load("../procesos/carga_pais.php");   
		            	$("#select_pais1").load("../procesos/carga_pais.php",function (){
							$("#select_provincia").load("../procesos/carga_provincia.php?id="+$("#select_pais1").val()+"&idp="+$("#select_provincia").val());
						});	
		        	}		        	
		        	if(data==2){
		            	alert("Error.. este nombre ya existe");          
		            	$("#nombre_pais").val("");
		            	$("#nombre_pais").focus();
		        	}
		        }
			});    	
		}
		if(texto==" Modificar"){
			$.ajax({
			type: "POST",
			url: "../procesos/pais.php",
	        data: "id="+$("#id_pais").val()+"&pais=" + $("#nombre_pais").val() + "&tipo="+"m",
	        success: function(response) {
	        	var data = response;
	        	if(data==1){
	            	alert("País Modificado");  
	            	$("#nombre_pais").val("");     	            	
	            	$("#nombre_pais").focus();               	 
					$("#btnGuardar").text("");
					$("#btnGuardar").append("<i class='fa fa-save'></i> Guardar");	  
					$("#id_pais").val("");
					$("#list").trigger('reloadGrid');
					$("#select_pais").load("../procesos/carga_pais.php");   
		            	$("#select_pais1").load("../procesos/carga_pais.php",function (){
							$("#select_provincia").load("../procesos/carga_provincia.php?id="+$("#select_pais1").val()+"&idp="+$("#select_provincia").val());
					});	
	        	}	        	
		        if(data==2){
		           	alert("Error.. este nombre ya existe");          	           	
		           	$("#nombre_pais").focus();
		        }        	
	        }
		});    
		}
	}
	if(cont!=0){
		alert("Llene todos los datos antes de continuar");
	}
}
function proceso1(){
	var cont=0;
	if($("#nombre_provincia").val()==""){
		$("#nombre_provincia").focus();
		cont=1;
	}	
	if(cont==0){
		var texto=$("#btnGuardar1").text();		
		if(texto==" Guardar"){		
			$.ajax({
				type: "POST",
				url: "../procesos/provincia.php",
		        data: "id_p="+$("#select_pais").val()+ "&nc="+$("#select_pais option:selected").text()+"&provincia=" + $("#nombre_provincia").val() + "&tipo="+"g",
		        success: function(response) {
		        	var data = response;
		        	if(data==1){
		            	alert("Provincia Creada");  
		            	$("#list1").trigger('reloadGrid');
		            	$("#nombre_provincia").val("");     		            			            	
		            	$("#nombre_provincia").focus();   
		            	$("#select_pais1").load("../procesos/carga_pais.php",function (){
							$("#select_provincia").load("../procesos/carga_provincia.php?id="+$("#select_pais1").val()+"&idp="+$("#select_provincia").val());
						});	
		        	}		        	
		        	if(data==2){
		            	alert("Error.. este nombre ya existe");          
		            	$("#nombre_provincia").val("");
		            	$("#nombre_provincia").focus();
		        	}
		        }
			});    	
		}
		if(texto==" Modificar"){
			$.ajax({
			type: "POST",
			url: "../procesos/provincia.php",
	        data: "id_p="+$("#select_pais").val()+"&id="+$("#id_provincia").val()+ "&nc="+$("#select_pais option:selected").text()+"&provincia=" + $("#nombre_provincia").val() + "&tipo="+"m",
	        success: function(response) {
	        	var data = response;
	        	if(data==1){
	            	alert("Provincia Modificada");  
	            	$("#nombre_provincia").val("");     	            	
	            	$("#nombre_provincia").focus();               	 
					$("#btnGuardar1").text("");
					$("#btnGuardar1").append("<i class='fa fa-save'></i> Guardar");	  
					$("#id_provincia").val("");
					$("#list1").trigger('reloadGrid');
					$("#select_pais1").load("../procesos/carga_pais.php",function (){
						$("#select_provincia").load("../procesos/carga_provincia.php?id="+$("#select_pais1").val()+"&idp="+$("#select_provincia").val());
					});	
	        	}	        	
		        if(data==2){
		           	alert("Error.. este nombre ya existe");          	           	
		           	$("#nombre_provincia").focus();
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
	if($("#nombre_ciudad").val()==""){
		$("#nombre_ciudad").focus();
		cont=1;
	}	
	if(cont==0){
		var texto=$("#btnGuardar2").text();		
		if(texto==" Guardar"){		
			$.ajax({
				type: "POST",
				url: "../procesos/ciudad.php",
		        data: "id_p="+$("#select_pais1").val()+"&provincia=" + $("#select_provincia").val()+"&ciudad="+$("#nombre_ciudad").val() + "&nc="+$("#select_provincia option:selected").text()+"&tipo="+"g",
		        success: function(response) {
		        	var data = response;
		        	if(data==1){
		            	alert("Ciudad Creada");  
		            	$("#list2").trigger('reloadGrid');
		            	$("#nombre_ciudad").val("");     		            			            	
		            	$("#nombre_ciudad").focus();   
		            	
		        	}		        	
		        	if(data==2){
		            	alert("Error.. este nombre ya existe");          
		            	$("#nombre_ciudad").val("");
		            	$("#nombre_ciudad").focus();
		        	}
		        }
			});    	
		}
		if(texto==" Modificar"){
			$.ajax({
			type: "POST",
			url: "../procesos/ciudad.php",
	         data: "id_p="+$("#select_pais1").val()+"&provincia=" + $("#select_provincia").val()+"&ciudad="+$("#nombre_ciudad").val() +"&id_ciudad="+$("#id_ciudad").val()+ "&nc="+$("#select_provincia option:selected").text()+ "&tipo="+"m",
	        success: function(response) {
	        	var data = response;
	        	if(data==1){
	            	alert("Provincia Modificada");  
	            	$("#nombre_ciudad").val("");     	            	
	            	$("#nombre_ciudad").focus();               	 
					$("#btnGuardar2").text("");
					$("#btnGuardar2").append("<i class='fa fa-save'></i> Guardar");	  
					$("#id_ciudad").val("");
					$("#list2").trigger('reloadGrid');					
	        	}	        	
		        if(data==2){
		           	alert("Error.. este nombre ya existe");          	           	
		           	$("#nombre_provincia").focus();
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
	$("#select_pais").load("../procesos/carga_pais.php");
	$("#select_pais1").load("../procesos/carga_pais.php",function (){
		$("#select_provincia").load("../procesos/carga_provincia.php?id="+$("#select_pais1").val());
	});	
	$("#select_pais1").change(function (){
		$("#select_provincia").load("../procesos/carga_provincia.php?id="+$("#select_pais1").val());
	})
	$('#formularios a').on("click",defecto);	
	$("#btnLimpiar").on("click",limpiar);
	$("#btnLimpiar1").on("click",limpiar1);
	$("#btnLimpiar2").on("click",limpiar2);
	$("#btnGuardar").on("click",proceso);
	$("#btnGuardar1").on("click",proceso1);
	$("#btnGuardar2").on("click",proceso2);
	$(window).bind('resize', function() {
        jQuery("#list").setGridWidth($('#medio1').width());
    }).trigger('resize');
    $(window).bind('resize', function() {
        jQuery("#list1").setGridWidth($('#medio2').width());
    }).trigger('resize');
    $(window).bind('resize', function() {
        jQuery("#list2").setGridWidth($('#medio3').width());
    }).trigger('resize');
	jQuery("#list").jqGrid({
        url: '../xml/xmlPais.php',
        datatype: 'xml',
        colNames: ['Id Pais', 'Nombre País'],
        colModel: [
            {name: 'id_pais', index: 'id_pais', editable: true, align: 'center', search: false,},            
            {name: 'nombre_pais', index: 'nombre_pais', editable: false, align: 'center', search: true,},            
        ],
        rowNum: 10,
        rowList: [10,20,30],
              
        pager: jQuery('#pager'),        
        sortname: 'id_pais',
        shrinkToFit: true,
        sortordezr: 'asc',
        caption: 'Lista de Países',
        viewrecords: true,   
        ondblClickRow:function(){
			var gsr = jQuery("#list").jqGrid('getGridParam','selrow');			
			jQuery("#list").jqGrid('GridToForm',gsr,"#form1");			
			$("#btnGuardar").text("");
			$("#btnGuardar").append("<i class='fa fa-file-text-o'></i> Modificar");					
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
        jQuery("#list").setGridWidth($('#medio1').width());   
        /////////////////////////
        jQuery("#list1").jqGrid({
        url: '../xml/xmlProvincia.php',
        datatype: 'xml',
        colNames: ['Id Provincia', 'Nombre Provincia','Id País','Nombre País'],
        colModel: [
        	{name: 'id_provincia', index: 'id_provincia', editable: true, align: 'center', search: false,},            
            {name: 'nombre_provincia', index: 'nombre_provincia', editable: false, align: 'center', search: true,},                           
            {name:'select_pais',index:'select_pais',search:false,editable:false,hidden:true,editrules: {edithidden:false},align:'center',frozen:false},                       
            {name: 'nombre_pais', index: 'nombre_pais', editable: false, align: 'center', search: true,},            
        ],
        rowNum: 10,
        rowList: [10,20,30],
        
        pager: jQuery('#pager1'),        
        sortname: 'id_provincia',
        shrinkToFit: true,
        sortordezr: 'asc',
        caption: 'Lista de Provincias',
        viewrecords: true,   
        ondblClickRow:function(){
			var gsr = jQuery("#list1").jqGrid('getGridParam','selrow');			
			jQuery("#list1").jqGrid('GridToForm',gsr,"#form2");			
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
        jQuery("#list1").setGridWidth($('#medio2').width());   
        //////////////////
        jQuery("#list2").jqGrid({
        url: '../xml/xmlCiudad.php',
        datatype: 'xml',
        colNames: ['Id Ciudad', 'Nombre Ciudad','Id Provincia','Nombre Provincia','Id País','Nombre País'],
        colModel: [
        	{name: 'id_ciudad', index: 'id_ciudad', editable: true, align: 'center', search: false,},            
            {name: 'nombre_ciudad', index: 'nombre_ciudad', editable: false, align: 'center', search: true,},                           
        	{name:'id_prov',index:'id_prov',search:false,editable:false,hidden:true,editrules: {edithidden:false},align:'center',frozen:false},                               	
            {name: 'nombre_provincia', index: 'nombre_provincia', editable: false, align: 'center', search: true,},                           
            {name:'select_pais1',index:'select_pais1',search:false,editable:false,hidden:true,editrules: {edithidden:false},align:'center',frozen:false},                       
            {name: 'nombre_pais1', index: 'nombre_pais1', editable: false, align: 'center', search: true,},            
        ],
        rowNum: 10,
        rowList: [10,20,30],
       
        pager: jQuery('#pager2'),        
        sortname: 'id_ciudad',
        shrinkToFit: true,
        sortordezr: 'asc',
        caption: 'Lista de Ciudades',
        viewrecords: true,   
        ondblClickRow:function(){
			var gsr = jQuery("#list2").jqGrid('getGridParam','selrow');	
			var ret = jQuery("#list2").jqGrid('getRowData',gsr);		
			jQuery("#list2").jqGrid('GridToForm',gsr,"#form3");						
			$("#select_provincia").load("../procesos/carga_provincia.php?id="+$("#select_pais1").val()+"&idp="+ret.id_prov);
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
        jQuery("#list2").setGridWidth($('#medio3').width());   
	}