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
    width:300,  
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
    $("#docRecibidos").on("click",defecto);           
    $("#btnHoja").on("click",defecto);      
    $("#btnVer").on("click",defecto);     
    $("#btnDescargar").on("click",defecto);        
    
    $("#btnHoja").click(function(){
        window.open("../reportes/hoja_ruta.php?id="+archivo);      
    });    

    $("#btnDescargar").click(function(){
       window.location.href="../procesos/descarga_historial.php?id="+archivo+"&f="+"1";
    });
    $("#btnVer").click(function(){
        window.open("../procesos/descarga_historial.php?id="+archivo);    
    });
    
    ////////////////////////////////
	 $(window).bind('resize', function() {
        jQuery("#list").setGridWidth($('#menu_medio').width() - 30);
    }).trigger('resize');
	jQuery("#list").jqGrid({
        datatype: "xml",
        url: '../procesos/historial.php?id='+$("#id").val(),        
        colNames: ['id_archivo','Id','Código','Nombre','id_usuario','Usuario','Fecha Cambio','Asunto','Observaciones','id_departamento','Departamento','Peso','Referencia','Estado'],
        colModel:[      
            {name:'archivo.id_archivo',index:'archivo.id_archivo',frozen:true,align:'center',width:50,},
            {name:'id_bitacora',index:'id_bitacora',frozen:true,align:'center',width:50,},
            {name:'codigo_archivo',index:'codigo_archivo',frozen : true,align:'center'},
            {name:'nombre_archivo',index:'nombre_archivo',frozen : true,align:'center'},
            {name:'id_usuario',index:'id_usuario',align:'center',frozen : true,},
            {name:'nombres_usuario',index:'nombres_usuario',frozen : true,align:'center'},
            {name:'fecha_cambio',index:'fecha_cambio',align:'center'},
            {name:'asunto_cambio',index:'asunto_cambio',align:'center'},
            {name:'observaciones',index:'observaciones',align:'center'},
            {name:'id_departamento',index:'id_departamento',align:'center'},
            {name:'nombre_departamento',index:'nombre_departamento',align:'center'},
            {name:'peso',index:'peso',align:'center'},
            {name:'referencia',index:'referencia',align:'center'},
            {name:'archivo.estado',index:'archivo.estado',align:'center'},
        ],          
        rowNum: 10,
        width:600,
        height:200,
        rowList: [10,20,30],
        pager: jQuery('#pager'),        
        sortname: 'id_bitacora',
        shrinkToFit: false,
        sortordezr: 'asc',
        caption: 'Lista de Documentos',
        viewrecords: true,            
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
            archivo=ret.id_bitacora;              
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
        jQuery("#list").jqGrid('hideCol', "archivo.id_archivo");
        jQuery("#list").jqGrid('hideCol', "id_usuario");
        jQuery("#list").jqGrid('hideCol', "codigo_archivo");        
        jQuery("#list").setGridWidth($('#menu_medio').width() - 30);          
        jQuery("#list").jqGrid('setFrozenColumns');
}

