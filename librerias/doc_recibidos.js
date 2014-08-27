$(document).on("ready",inicio);
$(document).tooltip();
function defecto(e){
    e.preventDefault();
};
var archivo=0;
var dialog9=
{
    autoOpen:false,
    resizable:false,    
    draggable:false,    
    modal:true,
    width:200,  
    position: 'center',
    closeOnEscape:false,    

};
var d = new Date();
var cantidad=10;
var month = d.getMonth()+1;
var day = d.getDate();
var output = d.getFullYear() + '-' +
    ((''+month).length<2 ? '0' : '') + month + '-' +
    ((''+day).length<2 ? '0' : '') + day;
function inicio(){	
    var cuantosLi = 0;
        jQuery("ul#nav > li").each(function(index) {
         cuantosLi = cuantosLi+1;
    });
    cuantosLi=cuantosLi+0.5;
    $("ul#nav > li").css('width','calc(100%/'+cuantosLi+')');    
    $("#frmProcesos").dialog(dialog9);	
    $("#bandeja").on("click",defecto);
    $("#doc_recibidos").on("click",defecto);
    $("#administracion").on("click",defecto);
    $("#editar_d").on("click",defecto);
    $("#cambiar_c").on("click",defecto);
    $("#btnModificar").click(function(){
        window.location.href="../paginas/modificar_archivo.php?id="+archivo;
    });
    $("#btnHoja").click(function(){
        window.open("../reportes/hoja_ruta.php?id="+archivo);         
    });
    $("#btnDescargar").click(function(){
       window.location.href="../procesos/descarga.php?id="+archivo+"&f="+"1";
    });
    $("#btnVer").click(function(){
        window.open("../procesos/descarga.php?id="+archivo);    
    });
	$(window).bind('resize', function() {
        jQuery("#list").setGridWidth($('#menu_medio').width() - 30);
    }).trigger('resize');
    jQuery("#list").jqGrid({
        datatype: "xml",
        url: '../procesos/doc_recibidos.php',        
        colNames: ['Id','Nombre','estado','Último cambio','Asunto','Observaciones','Peso','id_departamento','Depatamento','id_usuario','Último Usuario','Estado'],
        colModel:[      
            {name:'archivo.id_archivo',index:'archivo.id_archivo',frozen:true,align:'center',width:50,search:false},
            {name:'nombre_archivo',index:'nombre_archivo',frozen : true,align:'center',search:true},
            {name:'leido',index:'leido',align:'center',frozen:true,search:true},
            {name:'fecha_cambio',index:'fecha_cambio',frozen:true,align:'center',search:false},            
            {name:'asunto_cambio',index:'asunto_cambio',align:'center',search:false},
            {name:'observaciones',index:'observaciones',align:'center',search:false},
            {name:'peso',index:'peso',align:'center',search:false},
            {name:'id_departamento',index:'id_departamento',search:false},            
            {name:'nombre_departamento',index:'nombre_departamento',align:'center',search:false},
            {name:'id_usuario',index:'id_usuario',align:'center',search:false},            
            {name:'nombres_usuario',index:'nombres_usuario',align:'center',search:false},            
            {name:'estado',index:'estado',align:'center',search:false},            
        ],    
        loadComplete: function(data) {          
            var rowData = $("#list").getDataIDs();
            var fil = $("#list").getRowData(); 
            for (var i = 0; i < rowData.length; i++) 
            {
                var dd=fil[i];                                   
                if(dd['leido']=='1')
                {
                    $("#list").jqGrid('setRowData', rowData[i], false, {color:'black'});                    
                    $("#list").jqGrid('setRowData', rowData[i], false, 'negrita');
                }                           
            }
        },         
        rowNum: 10,
        width:600,
        height:200,
        rowList: [10,20,30],
        pager: jQuery('#pager'),        
        sortname: 'archivo.id_archivo',
        shrinkToFit: false,
        sortordezr: 'asc',
        caption: 'Lista de Documentos',
        viewrecords: true,
        onSelectRow: function(rowid) {  
            var gsr = jQuery("#list").jqGrid('getGridParam','selrow');
            var ret = jQuery("#list").jqGrid('getRowData',gsr);        
            //alert(ret.id_usuario)
            $("#list").jqGrid('setRowData', rowid, false, 'normal');
            if(ret.leido=='1'){   
                cambiarEstado(ret.id_usuario,rowid);   
                $.ajax({        
                    type: "POST",       
                    url: "../procesos/numeros.php",     
                    data :"iden="+"r",
                    success: function(response) {     
                        $("#de").text("Documentos Recibidos ("+response+")");       
                    }    
                });                                                  
            }
        },
        ondblClickRow: function(rowid) { 
            var gsr = jQuery("#list").jqGrid('getGridParam','selrow');
            var ret = jQuery("#list").jqGrid('getRowData',gsr);     
            if(ret.estado=="Finalizado"){                
                $("#btnModificar").hide();

            }
            else{
                $("#btnModificar").show();
            }                          
            $("#frmProcesos").dialog('open');
            archivo=rowid;            
        }
        }).jqGrid('navGrid','#pager',{
                add:false,
                edit:false,
                del:false,           
                refresh:true,
                search:true,
                view:false        
        }); 
        jQuery("#list").jqGrid('hideCol', "id_departamento");
        jQuery("#list").jqGrid('hideCol', "id_usuario");
        jQuery("#list").jqGrid('hideCol', "leido");
        jQuery("#list").setGridWidth($('#menu_medio').width() - 30);  
        jQuery("#list").jqGrid('setFrozenColumns');
		
	///
}
function cambiarEstado(usuario,archivo){
    $.ajax({
        type: "POST",
        url: "../procesos/cambiar_estado.php",
        data: "usuario="+usuario+"&archivo="+archivo,
        success: function(response) {
            if(response==0){
                alert("Ocurrio un error al verificar el dato.. Recarge la página por favor")
            }
        }            
    })
}
