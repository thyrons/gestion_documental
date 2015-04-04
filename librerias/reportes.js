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
};
var dialogo=
{
  autoOpen:false,
  resizable:false,  
  draggable:false,  
  modal:true,   
  position: 'top',
  closeOnEscape:false,  
  width:800,
  //title:'Gráfico estadístico de los archivos subidos por día',

};
function inicio(){
  var cuantosLi = 0;
        jQuery("ul#nav > li").each(function(index) {
         cuantosLi = cuantosLi+1;
    });
    cuantosLi=cuantosLi+0.5;
  $("ul#nav > li").css('width','calc(100%/'+cuantosLi+')');    
  $("#bandeja").on("click",defecto);      
  $("#doc_recibidos").on("click",defecto);
  $("#administracion").on("click",defecto);
  $("#editar_d").on("click",defecto);
  $("#cambiar_c").on("click",defecto);
  $("#btn_reporte_fecha").on("click",defecto);
  $("#btn_reporte_fecha_num").on("click",defecto);
  $("#btn_reporte_tipo").on("click",defecto);
  $("#btn_reporte_base_datos").on("click",defecto);
  $("#btn_reporte_sistema").on("click",defecto);
  $("#btn_reporteTipoDoc").on("click",defecto);
  $("#btn_reporteTamTotal").on("click",defecto);
  $("#btnCerrarVentana").on("click",defecto);
  $("#btn_reporte_usuario_peso").on("click",defecto);
  $("#btn_reporteDepartamento").on("click",defecto);
  $("#btn_reporteMes").on("click",defecto);
  $("#btn_reporteUsuarios").on("click",defecto);
 
  $("#frmGraficoPeso").dialog(dialogo);  
  $( "#txt_fecha1" ).val(output);
  $( "#txt_fecha2" ).val(output);
  $( "#txt_fecha3" ).val(output);
  $( "#txt_fecha4" ).val(output);
  $( "#txt_fecha5" ).val(output);
  $( "#txt_fecha6" ).val(output);
  $( "#txt_fecha7" ).val(output);
  $( "#txt_fecha8" ).val(output);
  $( "#txt_fecha1" ).datepicker({
      defaultDate: "+1w",
      changeMonth: true,
      numberOfMonths: 1,
      dateFormat: 'yy-mm-dd',
      changeYear: true,       
      showButtonPanel: true,
      showOtherMonths: true,
      selectOtherMonths: true,   
      onClose: function( selectedDate ) {
        $( "#txt_fecha2" ).datepicker( "option", "minDate", selectedDate );
      }
    });
    $( "#txt_fecha2" ).datepicker({
       defaultDate: "+1w",
      changeMonth: true,
      numberOfMonths: 1,
      dateFormat: 'yy-mm-dd',
      changeYear: true,       
      showButtonPanel: true,
      showOtherMonths: true,
      selectOtherMonths: true,   
      onClose: function( selectedDate ) {
        $( "#txt_fecha1" ).datepicker( "option", "maxDate", selectedDate );
      }
    });
    $( "#txt_fecha3" ).datepicker({
      defaultDate: "+1w",
      changeMonth: true,
      numberOfMonths: 1,
      dateFormat: 'yy-mm-dd',
      changeYear: true,       
      showButtonPanel: true,
      showOtherMonths: true,
      selectOtherMonths: true,   
      onClose: function( selectedDate ) {
        $( "#txt_fecha4" ).datepicker( "option", "minDate", selectedDate );
      }
    });
    $( "#txt_fecha4" ).datepicker({
       defaultDate: "+1w",
      changeMonth: true,
      numberOfMonths: 1,
      dateFormat: 'yy-mm-dd',
      changeYear: true,       
      showButtonPanel: true,
      showOtherMonths: true,
      selectOtherMonths: true,   
      onClose: function( selectedDate ) {
        $( "#txt_fecha3" ).datepicker( "option", "maxDate", selectedDate );
      }
    });
    $( "#txt_fecha5" ).datepicker({
      defaultDate: "+1w",
      changeMonth: true,
      numberOfMonths: 1,
      dateFormat: 'yy-mm-dd',
      changeYear: true,       
      showButtonPanel: true,
      showOtherMonths: true,
      selectOtherMonths: true,   
      onClose: function( selectedDate ) {
        $( "#txt_fecha6" ).datepicker( "option", "minDate", selectedDate );
      }
    });
    $( "#txt_fecha6" ).datepicker({
       defaultDate: "+1w",
      changeMonth: true,
      numberOfMonths: 1,
      dateFormat: 'yy-mm-dd',
      changeYear: true,       
      showButtonPanel: true,
      showOtherMonths: true,
      selectOtherMonths: true,   
      onClose: function( selectedDate ) {
        $( "#txt_fecha5" ).datepicker( "option", "maxDate", selectedDate );
      }
    });
    $( "#txt_fecha7" ).datepicker({
      defaultDate: "+1w",
      changeMonth: true,
      numberOfMonths: 1,
      dateFormat: 'yy-mm-dd',
      changeYear: true,       
      showButtonPanel: true,
      showOtherMonths: true,
      selectOtherMonths: true,   
      onClose: function( selectedDate ) {
        $( "#txt_fecha8" ).datepicker( "option", "minDate", selectedDate );
      }
    });
    $( "#txt_fecha8" ).datepicker({
       defaultDate: "+1w",
      changeMonth: true,
      numberOfMonths: 1,
      dateFormat: 'yy-mm-dd',
      changeYear: true,       
      showButtonPanel: true,
      showOtherMonths: true,
      selectOtherMonths: true,   
      onClose: function( selectedDate ) {
        $( "#txt_fecha7" ).datepicker( "option", "maxDate", selectedDate );
      }
    });
    $("#tipoDoc").load("../procesos/carga_tipodoc.php");
    $("#departamentoDoc").load("../procesos/carga_depar.php");
    ////////////////////////////////////////////////////
    $("#btn_reporte_fecha").click(function (){
      window.open("../reportes/reporte_fecha.php?fecha_ini="+$("#txt_fecha1").val()+"&fecha_fin="+$("#txt_fecha2").val());
    });
     $("#btn_reporte_tipo").click(function (){
      window.open("../reportes/reporte_tipo.php?tipo="+$("#tipo").val());
    });
      $("#btn_reporte_fecha_num").click(function (){
      window.open("../reportes/reporte_fecha_num.php?fecha_ini="+$("#txt_fecha3").val()+"&fecha_fin="+$("#txt_fecha4").val());
    });
    $("#btn_reporteTipoDoc").click(function (){
      window.open("../reportes/reporte_tipo_doc.php?dep="+$("#departamentoDoc").val()+"&doc="+$("#tipoDoc").val());
    });
    $("#btn_reporte_base_datos").click(function (){
      window.open("../reportes/auditoria_sistema.php?inicio="+$("#txt_fecha1").val()+"&fin="+$("#txt_fecha2").val());
    });
    $("#btn_reporte_sistema").click(function (){
      window.open("../reportes/auditoria_interna.php?inicio="+$("#txt_fecha1").val()+"&fin="+$("#txt_fecha2").val());
    });
    $("#btn_reporteUsuarios").click(function (){
      window.open("../reportes/reporte_usuarios.php");
    });

    $("#btnCerrarVentana").click(function (){
        $("#frmGraficoPeso").dialog('close'); 
    });      
    $("#btn_reporteTamTotal").click(function (){
      var months = [];
      var days = [];
      var switch1 = true;
      $.get('../procesos/graficoPeso.php?fecha1='+$("#txt_fecha5").val()+'&fecha2='+$("#txt_fecha6").val(), function(data) {

        data = data.split('/');
        for (var i in data) {
          if (switch1 == true) {
            months.push(data[i]);
            switch1 = false;
          } else {
            days.push(parseFloat(data[i]));
            switch1 = true;
          }

        }
        months.pop();

        $('#chart').highcharts({
          chart : {
            type : 'spline',

          },
          title : {
            text : 'Gráfico de las cantidad de KB subidos por día'
          },
          subtitle : {
            text : 'Fuente:Todos los usuarios del sistema'
          },
          xAxis : {
            title : {
              text : 'Días en el rango'
            },
            categories : months
          },
          yAxis : {
            title : {
              text : 'Peso en KB'
            },
            labels : {
              formatter : function() {
                return this.value + ' KB'
              }
            },
            
          },
          tooltip : {
            crosshairs : true,
            shared : true,
            valueSuffix : ''
          },
          plotOptions : {
            spline : {
              marker : {
                radius : 4,
                lineColor : '#666666',
                lineWidth : 1
              }
            }
          },
          series : [{
            name : 'Peso',
            data : days
          },{
            type: 'column',
            name: 'Peso por día',
            data: days, 
            pointWidth: 18, 
           
            color: '#334FBD',
            dataLabels: {
              enabled: true,
              rotation: -90,
              color: '#FFFFFF',
              align: 'right',
              x: 4,
              y: 10,
              style: {
                fontSize: '10px',
                fontFamily: 'Verdana, sans-serif',
                textShadow: '0 0 3px black'
              }
            },                             
          },]
        });
      });
    $("#frmGraficoPeso").parent().find("span.ui-dialog-title").html('Gráfico estadístico de los archivos subidos por día'); 
    $("#frmGraficoPeso").dialog('open');
  });
$("#btn_reporte_usuario_peso").click(function (){
      var months = [];
      var days = [];
      var switch1 = true;
      $.get('../procesos/graficoPesoUsuario.php?fecha1='+$("#txt_fecha5").val()+'&fecha2='+$("#txt_fecha6").val(), function(data) {

        data = data.split('/');
        for (var i in data) {
          if (switch1 == true) {
            months.push(data[i]);
            switch1 = false;
          } else {
            days.push(parseFloat(data[i]));
            switch1 = true;
          }

        }
        months.pop();

        $('#chart').highcharts({
          chart : {
            type : 'spline',

          },
          title : {
            text : 'Cantidad de Kbs por usuario'
          },
          subtitle : {
            text : 'Fuente:Todos los usuarios del sistema'
          },
          xAxis : {
            title : {
              text : 'Usuarios'
            },
            categories : months
          },
          yAxis : {
            title : {
              text : 'Peso en KB'
            },
            labels : {
              formatter : function() {
                return this.value + ' KB'
              }
            },
            
          },
          tooltip : {
            crosshairs : true,
            shared : true,
            valueSuffix : ''
          },
          plotOptions : {
            spline : {
              marker : {
                radius : 4,
                lineColor : '#666666',
                lineWidth : 1
              }
            }
          },
          series : [{
            name : 'Peso',
            data : days
          },{
            type: 'column',
            name: 'Usuario',
            data: days, 
            pointWidth: 18, 
           
            color: '#334FBD',
            dataLabels: {
              enabled: true,
              rotation: -90,
              color: '#FFFFFF',
              align: 'right',
              x: 4,
              y: 10,
              style: {
                fontSize: '10px',
                fontFamily: 'Verdana, sans-serif',
                textShadow: '0 0 3px black'
              }
            },                             
          },]
        });
      });
    $("#frmGraficoPeso").parent().find("span.ui-dialog-title").html('Cantidad de Kbs por usuario'); 
    $("#frmGraficoPeso").dialog('open');
  });
$("#btn_reporteDepartamento").click(function (){
      var months = [];
      var days = [];
      var switch1 = true;
      $.get('../procesos/graficoPesoDepartamento.php?fecha1='+$("#txt_fecha7").val()+'&fecha2='+$("#txt_fecha8").val(), function(data) {

        data = data.split('/');
        for (var i in data) {
          if (switch1 == true) {
            months.push(data[i]);
            switch1 = false;
          } else {
            days.push(parseFloat(data[i]));
            switch1 = true;
          }

        }
        months.pop();

        $('#chart').highcharts({
          chart : {
            type : 'spline',

          },
          title : {
            text : 'Cantidad de Kbs por departamento'
          },
          subtitle : {
            text : 'Fuente:Todos los departamentos del sistema'
          },
          xAxis : {
            title : {
              text : 'Departamentos'
            },
            categories : months
          },
          yAxis : {
            title : {
              text : 'Peso en KB'
            },
            labels : {
              formatter : function() {
                return this.value + ' KB'
              }
            },
            
          },
          tooltip : {
            crosshairs : true,
            shared : true,
            valueSuffix : ''
          },
          plotOptions : {
            spline : {
              marker : {
                radius : 4,
                lineColor : '#666666',
                lineWidth : 1
              }
            }
          },
          series : [{
            name : 'Peso',
            data : days
          },{
            type: 'column',
            name: 'Departamento',
            data: days, 
            pointWidth: 18, 
           
            color: '#334FBD',
            dataLabels: {
              enabled: true,
              rotation: -90,
              color: '#FFFFFF',
              align: 'right',
              x: 4,
              y: 10,
              style: {
                fontSize: '10px',
                fontFamily: 'Verdana, sans-serif',
                textShadow: '0 0 3px black'
              }
            },                             
          },]
        });
      });
    $("#frmGraficoPeso").parent().find("span.ui-dialog-title").html('Cantidad de Kbs por departamento'); 
    $("#frmGraficoPeso").dialog('open');
  });
$("#btn_reporteMes").click(function (){
      var months = [];
      var days = [];
      var switch1 = true;
      $.get('../procesos/graficoPesoMes.php?mes1='+$("#mes1").val()+'&mes2='+$("#mes2").val()+'&fecha1='+$("#mes1 option:selected").text()+'&fecha2='+$("#mes2 option:selected").text(), function(data) {

        data = data.split('/');
        for (var i in data) {
          if (switch1 == true) {
            months.push(data[i]);
            switch1 = false;
          } else {
            days.push(parseFloat(data[i]));
            switch1 = true;
          }

        }
        months.pop();

        $('#chart').highcharts({
          chart : {
            type : 'spline',

          },
          title : {
            text : 'Cantidad de Kbs por mes'
          },
          subtitle : {
            text : 'Fuente:Todos los archivos del sistema'
          },
          xAxis : {
            title : {
              text : 'Meses'
            },
            categories : months
          },
          yAxis : {
            title : {
              text : 'Peso en KB'
            },
            labels : {
              formatter : function() {
                return this.value + ' KB'
              }
            },
            
          },
          tooltip : {
            crosshairs : true,
            shared : true,
            valueSuffix : ''
          },
          plotOptions : {
            spline : {
              marker : {
                radius : 4,
                lineColor : '#666666',
                lineWidth : 1
              }
            }
          },
          series : [{
            name : 'Peso',
            data : days
          },{
            type: 'column',
            name: 'Meses',
            data: days, 
            pointWidth: 18, 
           
            color: '#334FBD',
            dataLabels: {
              enabled: true,
              rotation: -90,
              color: '#FFFFFF',
              align: 'right',
              x: 4,
              y: 10,
              style: {
                fontSize: '10px',
                fontFamily: 'Verdana, sans-serif',
                textShadow: '0 0 3px black'
              }
            },                             
          },]
        });
      });
    $("#frmGraficoPeso").parent().find("span.ui-dialog-title").html('Cantidad de Kbs por mes'); 
    $("#frmGraficoPeso").dialog('open');
  });
  ///////////////////////////
  $.ajax({
    type: "POST",
    dataType: 'json',
    url: "../procesos/totales.php",    
    success: function(response) {
      var data=response;
      $("#totalArchivos").val(" "+data[0]+" Archivo(s)");
      $("#totalKbs").val(" "+data[1]+" Kbs");
    }  
  }); 
  /////////////////////////////
}