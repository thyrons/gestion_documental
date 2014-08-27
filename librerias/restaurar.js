$(document).on("ready",inicio);
$(document).tooltip();
function defecto(e){
    e.preventDefault();
};
var archivo=0;
var estado=0;
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
    $("#btnRestaurar").on("click",defecto);     
    $("#btnHistorial").on("click",defecto);
    $("#btnHoja").on("click",defecto);     
    $("#btnVer").on("click",defecto);     
    $("#btnDescargar").on("click",defecto);     

    $("#btnRestaurar").click(function(){
    $.ajax({
            type: "POST",
            url: "../procesos/estados.php",
            data: "id_archivo="+archivo+"&estado="+estado,
            success: function(response) {
                var data = response;
                if(data==1){
                    $("#list").trigger('reloadGrid');
                    alert("Datos Actualizados");                    
                }
                else{
                    $("#list").trigger('reloadGrid');
                    alert("Error al momento de actualizar");                
                }
                $("#frmProcesos").dialog('close');
            }
        });         
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
    $("#btnHistorial").click(function(){
        window.location.href="../paginas/historial.php?id="+archivo;
    });
    
    ////////////////////////////////
	 $(window).bind('resize', function() {
        jQuery("#list").setGridWidth($('#menu_medio').width() - 30);
    }).trigger('resize');
	jQuery("#list").jqGrid({
        datatype: "xml",
        url: '../xml/xml_estado.php',        
        colNames: ['Id','Código','Nombre','id_departamento','Departamento','Fecha','Asunto','Observaciones','Peso','id_usuario','Último usuario','Estado'],
        colModel:[      
            {name:'archivo.id_archivo',index:'archivo.id_archivo',frozen:true,align:'center',width:50,search:false},
            {name:'codigo_archivo',index:'codigo_archivo',frozen : true,align:'center',search:true},
            {name:'nombre_archivo',index:'nombre_archivo',align:'center',frozen:true,search:true},
            {name:'id_departamento',index:'id_departamento',frozen:true,search:false},
            {name:'nombre_departamento',index:'nombre_departamento',align:'center',search:false},
            {name:'fecha_cambio',index:'fecha_cambio',align:'center',search:false},            
            {name:'asunto_cambio',index:'asunto_cambio',align:'center',search:false},            
            {name:'observaciones',index:'observaciones',align:'center',search:false},  
            {name:'peso',index:'peso',align:'center',search:false},  
            {name:'id_usuario',index:'id_usuario',align:'center',search:false},
            {name:'ultimo_usuario',index:'ultimo_usuario',align:'center',search:false},
            {name:'estado',index:'estado',align:'center',search:false},
        ],          
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
        ondblClickRow: function(rowid) {     
            var gsr = jQuery("#list").jqGrid('getGridParam','selrow');
            var ret = jQuery("#list").jqGrid('getRowData',gsr);                 
            $("#frmProcesos").dialog('open');
            estado=ret.estado;
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
        jQuery("#list").setGridWidth($('#menu_medio').width() - 30);          
        jQuery("#list").jqGrid('setFrozenColumns');
}

