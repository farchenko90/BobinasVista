function explode(){
    location.reload();   
}
/**
 * agregamos a la base de datos los campos del bobinado
 */
function agregarbobinaprimaria(){
    toastr.options.positionClass = 'toast-top-center';
    var id = document.getElementById("alerta");
    if(document.getElementsByName("calibre")[0].value=="" || document.getElementsByName("espiracapa")[0].value=="" ||
      document.getElementsByName("opciones")[0].value=="" || document.getElementsByName("aislamiento")[0].value=="" ||
      document.getElementsByName("refrigreacion")[0].value=="" || document.getElementsByName("calibrefibra")[0].value=="" ||
      document.getElementsByName("bisel")[0].value=="" || document.getElementsByName("largo")[0].value=="" || 
      document.getElementsByName("ancho")[0].value=="" || document.getElementsByName("altura")[0].value=="" ||
      document.getElementsByName("n2")[0].value=="" || document.getElementsByName("espiratotal")[0].value=="" ||
      document.getElementsByName("tap")[0].value==""){
        toastr.warning('Los Campos Marcados Con * Son Obligatorios','Error');
    }else{
        jQuery.ajax({
             type: "POST",
             url: servidor+"bobinapri", 
             dataType: "json",
             data: jsonRegistrabobinaprimaria(),
             success: function (data, status, jqXHR) {
                 if(data.estado == 1){ 
                    toastr.info('Se Ha Registrado Esta Bobina Primaria');
                    setInterval(function(){location.reload();},3000);
                 }
             },
             error: function (jqXHR, status) {
                 alert("Erro bobina primaria");
             }
        });
    }
}
/**
 * json de registrar bobinado
 */
function jsonRegistrabobinaprimaria(){  
    return JSON.stringify({
        "Calibrealambre":       document.getElementsByName("calibre")[0].value,
        "Espiracapa":           document.getElementsByName("espiracapa")[0].value,
        "Tipo":                 document.getElementsByName("opciones")[0].value,
        "Aislamiento":          document.getElementsByName("aislamiento")[0].value,
        "Refrigeracion":        document.getElementsByName("refrigreacion")[0].value,
        "Calibrefibra":         document.getElementsByName("calibrefibra")[0].value,
        "Bisel":                document.getElementsByName("bisel")[0].value, 
        "Largo":                document.getElementsByName("largo")[0].value,
        "Ancho":                document.getElementsByName("ancho")[0].value,
        "Altura":               document.getElementsByName("altura")[0].value,
        "N2":                   document.getElementsByName("n2")[0].value,
        "Espirototal":          document.getElementsByName("espiratotal")[0].value,
        "Tap":                  document.getElementsByName("tap")[0].value,
        "Idrepa":               geturl
    });
}

/**
 * actualizar a la base de datos los campos del bobinado
 */
function actualizarbobinaprimaria(){
    var id = document.getElementById("alerta");
    jQuery.ajax({
         type: "PUT",
         url: servidor+"bobinaprimaria", 
         dataType: "json",
         data: jsonActualizarbobinaprimaria(),
         success: function (data, status, jqXHR) {
             if(data.estado == 1){ 
                toastr.info('Se Ha Actualizado Esta Bobina Primaria');
                setInterval(function(){location.reload();},3000);
             }
         },
         error: function (jqXHR, status) {
             alert("Erro bobina primaria");
         }
    });
}

/**
 * json de actualizar bobinado
 */
function jsonActualizarbobinaprimaria(){  
    return JSON.stringify({
        "Calibrealambre":       document.getElementsByName("calibre1")[0].value,
        "Espiracapa":           document.getElementsByName("espiracapa1")[0].value,
        "Tipo":                 document.getElementsByName("opciones1")[0].value,
        "Aislamiento":          document.getElementsByName("aislamiento1")[0].value,
        "Refrigeracion":        document.getElementsByName("refrigreacion1")[0].value,
        "Calibrefibra":         document.getElementsByName("calibrefibra1")[0].value,
        "Bisel":                document.getElementsByName("bisel1")[0].value, 
        "Largo":                document.getElementsByName("largo1")[0].value,
        "Ancho":                document.getElementsByName("ancho1")[0].value,
        "Altura":               document.getElementsByName("altura1")[0].value,
        "N2":                   document.getElementsByName("n21")[0].value,
        "Espirototal":          document.getElementsByName("espiratotal1")[0].value,
        "Tap":                  document.getElementsByName("tap1")[0].value,
        "Id":                   document.getElementsByName("idprimario")[0].value
    });
}


function datosprimario(id){
    jQuery.ajax({
         type: "GET",
         url: servidor+"bobinaprimario/"+id, 
         dataType: "json",
         success: function (data, status, jqXHR) {
             if(data!=null){
                 
                for(var i=0;i < data.length; i++){
                    document.getElementsByName("calibre1")[0].value = data[i].calibrealambre;
                    document.getElementsByName("espiracapa1")[0].value = data[i].espiracapa;
                    document.getElementsByName("opciones1")[0].value = data[i].tipo;
                    document.getElementsByName("aislamiento1")[0].value = data[i].aislamiento;
                    document.getElementsByName("refrigreacion1")[0].value = data[i].refrigeracion;
                    document.getElementsByName("calibrefibra1")[0].value = data[i].calibrefibra;
                    document.getElementsByName("bisel1")[0].value = data[i].bisel;
                    document.getElementsByName("largo1")[0].value = data[i].largo;
                    document.getElementsByName("ancho1")[0].value = data[i].ancho;
                    document.getElementsByName("altura1")[0].value = data[i].altura;
                    document.getElementsByName("n21")[0].value = data[i].n2;
                    document.getElementsByName("espiratotal1")[0].value = data[i].espiraltotal;
                    document.getElementsByName("tap1")[0].value = data[i].tap;
                }
                 
             }

         },
         error: function (jqXHR, status) {
             alert("error buscar user");
         }
    });
    
}