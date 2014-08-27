$(document).on("ready", inicio);
$(document).tooltip();
function defecto(e){
	e.preventDefault();
};
var dialog1=
{
    autoOpen:false,
    resizable:false,    
    draggable:false,    
    modal:true,
    width:600,  
    position: 'center',
    closeOnEscape:false,    
};
function inicio (){
    var cuantosLi = 0;
        jQuery("ul#nav > li").each(function(index) {
         cuantosLi = cuantosLi+1;
    });
    cuantosLi=cuantosLi+0.5;
    $("ul#nav > li").css('width','calc(100%/'+cuantosLi+')');    
    $("#frmBuscador").dialog(dialog1);
    $("#btnBuscarUser").click(function (){
        $("#frmBuscador").dialog("open");
    });   
    $("#buscar_p").keyup(function (){
         $("#list").jqGrid('setGridParam',{url:'../xml/buscador_usuario.php?campo='+$("#buscador_por").val()+"&valor="+$("#buscar_p").val(),datatype:'xml'}).trigger('reloadGrid');         
    }); 
    /////////////////
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
        shrinkToFit: false,
        sortordezr: 'asc',
        caption: 'Lista de Usuarios',
        viewrecords: true,   
        ondblClickRow: function(rowid) {             
            var id = jQuery("#list").jqGrid('getGridParam','selrow');
            jQuery('#list').jqGrid('restoreRow',id);
            var ret = jQuery("#list").jqGrid('getRowData', id); 
            $("#nombreUsuario").val(ret.nombres_usuario);
            $("#repetir").val(ret.id_usuario);
            $("#tablaNuevo tbody tr").empty();
            cargarDatos(ret.id_usuario);   
            $("#frmBuscador").dialog('close');
        }           
        }).jqGrid('navGrid','#pager',{
                add:false,
                edit:false,
                del:false,           
                refresh:true,
                search:false,
                view:true        
        }); 
    /////////////////	
    $("#btnGuardar").on("click",guardar_cambios);
}

function guardar_cambios(){
	cont=0; 
	var vect1 = new Array();             
    var vect2 = new Array();      	
    var vect3 = new Array();      	

    $("#tablaNuevo tbody tr").each(function (index3) {                                                                 
    	$(this).children("td").each(function (index3) {                               
    		switch (index3) {                                            
            	case 0:
                	vect1[cont] = $(this).text();                                       
                break;      	                                                                                                                    
                case 1:
                	vect2[cont] = $(this).text();                                       
                break;      	                                                                                                                                    	                                                                                                                    
            }                                          
		});
        cont++;                
    });
    cont1=0;
   	$('.box').each(function(){
   		var checkbox = $(this);
   		if(checkbox.is(':checked')){
   			vect3[cont1]='a';
   		}   
   		else{
   			vect3[cont1]='p';
   		}
   		cont1++;
	});
    
	$.ajax({        
    	type: "POST",
    	dataType: 'json',
    	data: "vect1="+vect1+"&vect2="+vect2+"&vect3="+vect3+"&id="+$("#repetir").val(),
    	url: "../procesos/modificaAccesos.php",    	
    	success: function(response) {     
    		if(response==1){
    			alert("Datos Actualizados recarge la página para ver los cambios");
    			location.reload();
    		}
    	}                   
    }); 
}
function cargarDatos(id){
    $.ajax({        
        type: "POST",
        dataType: 'json',
        data:"id="+id,
        url: "../procesos/cargaAccesos.php",        
        success: function(response) {     
            var cont=1;
            for (var i = 0; i < response.length; i=i+4) {
                if(response[i+3]=="a"){
                    $("#tablaNuevo tbody").append( "<tr>" +
                    "<td align=center >" + response[i+2] + "</td>" +
                    "<td align=center>" + response[i+1] + "</td>" +             
                    "<td align=center>" + "<input type='checkbox' class='box' name='' id='"+cont+"' value='' checked=''>" + "</td>" + "<tr>");
                }
                else{
                    $("#tablaNuevo tbody").append( "<tr>" +
                    "<td align=center >" + response[i+2] + "</td>" +
                    "<td align=center>" + response[i+1] + "</td>" +             
                    "<td align=center>" + "<input type='checkbox' name='' class='box' id='"+cont+"' value=''>" + "</td>" + "<tr>");
                }
                cont++;              
            };
        }                   
    }); 
}