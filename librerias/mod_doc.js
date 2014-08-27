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
var fecha={
   dateFormat: 'yy-mm-dd',
   changeYear: true,
   changeMonth: true,
   showButtonPanel: true,
   showOtherMonths: true,
   selectOtherMonths: true,
   showWeek: true   
};
function inicio(){	
	var cuantosLi = 0;
        jQuery("ul#nav > li").each(function(index) {
         cuantosLi = cuantosLi+1;
    });
    cuantosLi=cuantosLi+0.5;
	$("ul#nav > li").css('width','calc(100%/'+cuantosLi+')');    	
	$("#bandeja").on("click",defecto);
	$("#docRecibidos").on("click",defecto);
	$("#fechaDoc").datepicker(fecha);
	$("#fechaDoc").val(output);  	
	$("#departamentoDoc").load("../procesos/carga_depar.php");				
	$.ajax({
		type: "POST",
		dataType: 'json',
		url: "../procesos/carga_archivo.php",
        data: "codigo=" + $("#id").val(),
		success: function(response) {			
		   $("#fechaDoc").val(response[1].substr(0,10));
		   $("#estado_archivo").val(response[2]);
		   $("#departamentoDoc").val(response[3]);	
		   $("#asuntoDoc").val(response[4]);
		   $("#observaciones").val(response[5]);
		}
	});    			
	/****/
	function getDoc(frame) {
    	var doc = null;     
     	// IE8 cascading access check
     	try {
        	if (frame.contentWindow) {
            	doc = frame.contentWindow.document;
         	}
     	} catch(err) {
    }
    if (doc) { // successful getting content
         return doc;
    }
    try { // simply checking may throw in ie8 under ssl or mismatched protocol
         doc = frame.contentDocument ? frame.contentDocument : frame.document;
    } catch(err) {
         // last attempt
         doc = frame.document;
    }
    return doc;
 	}
 	$("#btnEnviar").click(function (){ 	
 		if($("#fechaDoc").val()!=""){	
 		$("#menu_medio1").submit(function(e)
		{
			var formObj = $(this);
			var formURL = formObj.attr("action");
			if(window.FormData !== undefined)  // for HTML5 browsers
			{	
				var formData = new FormData(this);		
				formURL=formURL+"?id="+$("#id").val();  
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
		    				alert("Documento Modificado");
		    				window.location.href='doc_enviados.php';
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
   			else  
			{			
				var  iframeId = "unique" + (new Date().getTime());			
				var iframe = $('<iframe src="javascript:false;" name="'+iframeId+'" />');
				iframe.hide();	
				formObj.attr("target",iframeId);
				iframe.appendTo("body");
				iframe.load(function(e)
				{
					var doc = getDoc(iframe[0]);
					var docRoot = doc.body ? doc.body : doc.documentElement;
					var data = docRoot.innerHTML;					
				});
			}
		});
		$("#menu_medio1").submit();		
		}
		else{
			alert("Llene los parametros antes de continuar");
		}			
 	});

}