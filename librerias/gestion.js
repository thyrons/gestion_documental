$(document).on("ready",inicio);
$(document).tooltip();
function defecto(e){
	e.preventDefault();
};
var d = new Date();
var month = d.getMonth()+1;
var day = d.getDate();
var output = d.getFullYear() + '-' +
    ((''+month).length<2 ? '0' : '') + month + '-' +
    ((''+day).length<2 ? '0' : '') + day;
var dialog=
{
	autoOpen:false,
	resizable:false,	
	draggable:false,	
	modal:true,
	width:600,	
	position: 'center',
	closeOnEscape:false,	
};
var dialog1=
{
	autoOpen:false,
	resizable:false,	
	draggable:false,	
	modal:true,
	width:400,	
	position: 'center',
	closeOnEscape:false,	
};
var fecha={
   dateFormat: 'yy-mm-dd',
   changeYear: true,
   changeMonth: true,
   showButtonPanel: true,
   showOtherMonths: true,
   selectOtherMonths: true,
   showWeek: true   
};
function fn_dar_eliminar(e){
    $("a.elimina").click(function(){
         id = $(this).parents("tr").find("td").eq(0).html();        
        $(this).parents("tr").fadeOut("normal", function(){
            $(this).remove();                         
        })        
    });
}
function inicio(){
	var cuantosLi = 0;
        jQuery("ul#nav > li").each(function(index) {
         cuantosLi = cuantosLi+1;
    });
    cuantosLi=cuantosLi+0.5;
	$("ul#nav > li").css('width','calc(100%/'+cuantosLi+')');    
    
	$("#bandeja").on("click",defecto);
	$("#btnBuscar1").on("click",defecto);
	$("#btnMeta").on("click",defecto);
	$("#btnAgregarMeta").on("click",defecto);
	$("#doc_recibidos").on("click",defecto);
	$("#administracion").on("click",defecto);
	$("#editar_d").on("click",defecto);
	$("#cambiar_c").on("click",defecto);
	$("#fechaDoc").datepicker(fecha);
	$("#fechaDoc").val(output);  
	$("#tipoDoc").load("../procesos/carga_tipodoc.php");
	$("#departamentoDoc").load("../procesos/carga_depar.php");
	$("#buscar_p").keyup(function (){
		 $("#list").jqGrid('setGridParam',{url:'../xml/buscador_usuario.php?campo='+$("#buscador_por").val()+"&valor="+$("#buscar_p").val(),datatype:'xml'}).trigger('reloadGrid');         
	});
	$("#frmBuscador").dialog(dialog);
	$("#btnBuscar1").click(function (){
		$("#frmBuscador").dialog("open");
	});
	$("#frmMeta").dialog(dialog1);
	$("#btnMeta").click(function (){
		$("#frmMeta").dialog("open");
	});
	jQuery("#list").jqGrid({
		datatype: "xml",
		colNames: ['Id','Código','Nombres Completos','Nivel','Nombre Usuario','Institucion'],
		colModel:[		
			{name:'id_usuario',index:'id_usuario',align:'center',frozen:true},
			{name:'cod_usuario',index:'cod_usuario',align:'center',frozen : true},
			{name:'nombres_usuario',index:'nombres_usuario',align:'center'},
			{name:'nombre_tipo',index:'nombre_tipo',align:'center'},
			{name:'nick_usuario',index:'nick_usuario',align:'center',frozen:true},										
			{name:'institucion',index:'institucion',align:'center',frozen:true},
		],      	
		rowNum: 10,
		width:580,
        rowList: [10,20,30],
		pager: jQuery('#pager'),        
        sortname: 'id_usuario',
        shrinkToFit: true,
        sortordezr: 'asc',
        caption: 'Lista de Usuarios',
        viewrecords: true,   
        ondblClickRow: function(rowid) {			 
			var id = jQuery("#list").jqGrid('getGridParam','selrow');
            jQuery('#list').jqGrid('restoreRow',id);
            var ret = jQuery("#list").jqGrid('getRowData', id); 
            var estado=repetidos(ret.id_usuario)          
            if(estado==0){            
            	$("#tablaNuevo tbody").append( "<tr>" +
            	"<td align=center>" +"Para: " + "</td>" +
            	"<td align=center>" + ret.nombre_tipo + "</td>" +	            
            	"<td align=center>" + ret.nick_usuario + "</td>" +            
            	"<td align=center>" + ret.institucion + "</td>" +
            	"<td align=center style='display: none'>" + ret.id_usuario + "</td>" +
            	"<td align=center>" + " <a class='elimina'><img src='../imagenes/cancel.png' onclick='return fn_dar_eliminar(event)'/>"  + "</td>" + "</tr>" );
            }
			        
   		}   		
		}).jqGrid('navGrid','#pager',{
				add:false,
    	        edit:false,
        	    del:false,           
            	refresh:true,
				search:false,
	            view:true        
		});	
		$("#btnAgregarMeta").click(function (){
			if($("#NombreM").val()!="" && $("#DescM").val()!=""){					
				$("#tablaMeta tbody").append( "<tr>" +
            	"<td align=center>" +$("#NombreM").val() + "</td>" +               
            	"<td align=center>" + $("#DescM").val()+ "</td>" +           
            	"<td align=center>" + " <a class='elimina'><img src='../imagenes/cancel.png' onclick='return fn_dar_eliminar(event)'/>"  + "</td>" + "</tr>" );
			}
			else{
				alert("Llene los campos antes de continuar");
			}
		});
	
	function getDoc(frame) {
    	var doc = null;     
     	
     	try {
        	if (frame.contentWindow) {
            	doc = frame.contentWindow.document;
         	}
     	} catch(err) {
    }
    if (doc) { 
         return doc;
    }
    try { 
         doc = frame.contentDocument ? frame.contentDocument : frame.document;
    } catch(err) {
       
         doc = frame.document;
    }
    return doc;
 	}
 	$("#btnEnviar").click(function (){
 		if($("#nombre_doc").val()!="" && $("#archivoDoc").val()!="" && $("#fechaDoc").val()!=""){
 			$("#menu_medio").submit(function(e)
			{
				var formObj = $(this);
				var formURL = formObj.attr("action");
				if(window.FormData !== undefined)  
				{	
					var formData = new FormData(this);
					cont=0; 
   					var vect1 = new Array();             
    				var vect2 = new Array();      	
    				var vect3 = new Array();      	
    				$("#tablaNuevo tbody tr").each(function (index3) {                                                                 
        				$(this).children("td").each(function (index3) {                               
            				switch (index3) {                                            
                				case 4:
                    				vect1[cont] = $(this).text();                                       
                				break;      	                                                                                                                    
            				}                                          
		        		});
        				cont++;                
    				});
    				cont=0; 
    				$("#tablaMeta tbody tr").each(function (index3) {                                                                 
        				$(this).children("td").each(function (index3) {                               
            				switch (index3) {                                            
                				case 0:
                    				vect2[cont] = $(this).text();                                       
                				break;                                                                                                                          
                				case 1:
                    				vect3[cont] = $(this).text();                                       
                				break;                                                                                                                          
            				}                                          
        				});
        				cont++;                
    				});    
    			formURL=formURL+"?vector1="+vect1+"&vector2="+vect2+"&vector3="+vect3;  
    			$("#btnEnviar").text("");
    			$("#btnEnviar").css({"background":"#F0F4F7"});
    			$("#btnEnviar").attr("disabled",true);
				$("#btnEnviar").append("<i class='fa fa-spinner'></i> Enviando...");	 	
				$.ajax({
        			url: formURL,
					type: "POST",
					data:  formData,
					mimeType:"multipart/form-data",
					contentType: false,
    	    		cache: false,
					processData:false,
					success: function(data, textStatus, jqXHR)
		    		{
		    			var res=data;
		    			if(res==0){
		    				alert("Documento Enviado");
		    				location.reload();
		    			}
		    			else{
		    				alert("Error al momento de guardar el archivo recarge la página e intente nuevamente");
		    			}
				    },
				  	error: function(jqXHR, textStatus, errorThrown) 
	    			{
	    			} 	        
	   			});
        	e.preventDefault();
   		}
   		else  //for olden browsers
		{
			//generate a random id
			var  iframeId = "unique" + (new Date().getTime());
			//create an empty iframe
			var iframe = $('<iframe src="javascript:false;" name="'+iframeId+'" />');
			//hide it
			iframe.hide();
			//set form target to iframe
			formObj.attr("target",iframeId);
			//Add iframe to body
			iframe.appendTo("body");
			iframe.load(function(e)
			{
				var doc = getDoc(iframe[0]);
				var docRoot = doc.body ? doc.body : doc.documentElement;
				var data = docRoot.innerHTML;
				//data return from server.			
			});
		}
		});
		$("#menu_medio").submit();
	}
	else{
		alert("Llene los parametros antes de continuar");
	}
 	});

}
function repetidos(id){
	var repe=0;
	cont=0; 
	$("#tablaNuevo tbody tr").each(function (index3) {                                                                 
        $(this).children("td").each(function (index3) {                               
        	switch (index3) {                                            
        		case 4:
        			if($(this).text()==id){        				
        				repe++;
        			}        			
        		break;      	                                                                                                                    
    		}                                          
		});
    cont++;                
   	});	
   	if(repe>0){
   		alert("Error este usuario ya esta agregado");
        repe=1;
    }
    else{
    	repe=0;
    }   	
   	return repe;
}