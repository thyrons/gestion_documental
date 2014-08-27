$(document).on("ready", inicio);
$(document).tooltip();
function defecto(e){
	e.preventDefault();
};
function buscador(e){
	$("#buscador").show("blind", { direction: "horizontal" }, 1000);
}	
function limpiar(){
	$("#codigo").val("");
	$("#nombre").val("");
	$("#codigo").focus();
	$("#btnGuardar").text("");
	$("#btnGuardar").append("<i class='fa fa-save'></i> Guardar");	  
	$("#id_medio").val("");
}
function proceso(){
	var cont=0;
	if($("#nombre").val()==""){
		$("#nombre").focus();
		cont=1;
	}
	if($("#codigo").val()==""){
		$("#codigo").focus();
		cont=2;
	}	
	if(cont==0){
		var texto=$("#btnGuardar").text();		
		if(texto==" Guardar"){		
			$.ajax({
				type: "POST",
				url: "../procesos/medio_recepcion.php",
		        data: "codigo=" + $("#codigo").val() + "&nombre=" + $("#nombre").val()+"&tipo="+"g",
		        success: function(response) {
		        	var data = response;
		        	if(data==1){
		            	alert("Tipo Documento creado");  
		            	$("#codigo").val("");     
		            	$("#nombre").val("");
		            	$("#codigo").focus();     
		            	$("#list").trigger('reloadGrid');
		        	}
		        	if(data==2){
		            	alert("Error.. este codigo ya existe");          
		            	$("#codigo").val("");
		            	$("#codigo").focus();
		        	}
		        	if(data==3){
		            	alert("Error.. este nombre ya existe");          
		            	$("#nombre").val("");
		            	$("#nombre").focus();
		        	}
		        }
			});    	
		}
		if(texto==" Modificar"){
			$.ajax({
			type: "POST",
			url: "../procesos/medio_recepcion.php",
	        data: "id="+$("#id_medio").val()+"&codigo=" + $("#codigo").val() + "&nombre=" + $("#nombre").val()+"&tipo="+"m",
	        success: function(response) {
	        	var data = response;
	        	if(data==1){
	            	alert("Tipo de documento modificado");  
	            	$("#list").trigger('reloadGrid');
	            	$("#codigo").val("");     
	            	$("#nombre").val("");
	            	$("#codigo").focus();               	 
					$("#btnGuardar").text("");
					$("#btnGuardar").append("<i class='fa fa-save'></i> Guardar");	  
					$("#id_medio").val("");
	        	} 
	        	if(data==2){
		           	alert("Error.. este codigo ya existe");          	           
		           	$("#codigo").focus();
		        }
		        if(data==3){
		           	alert("Error.. este nombre ya existe");          	           	
		           	$("#nombre").focus();
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
	$("#btnLimpiar").on("click",limpiar);
	$("#btnBuscar").on("click",buscador);	
	$('a').on("click",defecto);
	$("#btnGuardar").on("click",proceso);	
	 $(window).bind('resize', function() {
        jQuery("#list").setGridWidth($('#formularios').width() - 30);
    }).trigger('resize');
	jQuery("#list").jqGrid({
        url: '../xml/xmlMedio.php',
        datatype: 'xml',
        colNames: ['Id Medio de recepción', 'Código','Medio de recepción'],
        colModel: [
            {name: 'id_medio', index: 'id_medio', editable: true, align: 'center', search: false,},            
            {name: 'codigo', index: 'codigo', editable: false, align: 'center', search: false,},
            {name: 'nombre', index: 'nombre', editable: false, align: 'center', search: false, },
        ],
        rowNum: 10,
        rowList: [10,20,30],
        width: null,        
        pager: jQuery('#pager'),        
        sortname: 'id_medio',
        shrinkToFit: true,
        sortordezr: 'asc',
        caption: 'Lista de Medios de recepción',
        viewrecords: true,   
        ondblClickRow:function(){
			var gsr = jQuery("#list").jqGrid('getGridParam','selrow');			
			jQuery("#list").jqGrid('GridToForm',gsr,"#formularios");
			$("#buscador").hide("blind", { direction: "horizontal" }, 1000);
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
                view: true,               
            }); 
        jQuery("#list").setGridWidth($('#formularios').width() - 30);   
	}