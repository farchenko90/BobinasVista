function notificacion(){
    alertify.error("Todos los campos son obligatorios"); 
    return false;
}
/**
 * Actualizar usuario
 * obtiene true si lo guardo en la base de datos
 */
function modificarrebobinado(){
    jQuery.ajax({
         type: "PUT",
         url: servidor+"rebobinado", 
         dataType: "json",
         data: jsonrebobinadoactualizar(),
         success: function (data, status, jqXHR) {
             if(data.estados == 1){
                alert("Se Ha Actualizado Correctamente");
                location.reload();
             }else{
                //alert("Esta Cedula Se Encuentra Registrada");
             }
         },
         error: function (jqXHR, status) {
             alert("Erro modificar rebobinado");
         }
    });
    
}

/**
 * Json de agregar usuario
 * returna 1 si es true
 */
function jsonrebobinadoactualizar(){                                                
        
    return JSON.stringify({
        "V":                    document.getElementsByName("v")[0].value,
        "Am":                   document.getElementsByName("am")[0].value,
        "Balinera_ref":         document.getElementsByName("balinerasref")[0].value,
        "Cap_marcha":           document.getElementsByName("capmarcha")[0].value,
        "Largo":                document.getElementsByName("largo")[0].value,
        "Conexiones":           document.getElementsByName("cone")[0].value,
        "Cap_arranque":         document.getElementsByName("caparran")[0].value,
        "Sello_mecanico":       document.getElementsByName("sellomec")[0].value,
        "Arr_paso":             document.getElementsByName("paso")[0].value,
        "Arr_espiras":          document.getElementsByName("espiras")[0].value,
        "Arr_calibre":          document.getElementsByName("calibre")[0].value,
        "Arr_peso_por_bobina":  document.getElementsByName("pesobobina")[0].value,
        "Mar_paso":             document.getElementsByName("paso1")[0].value,
        "Mar_espira":           document.getElementsByName("espiras1")[0].value,
        "Mar_calibre":          document.getElementsByName("calibre1")[0].value,
        "Mar_peso_por_bobina":  document.getElementsByName("pesobobi1")[0].value,
        "Num_ranura":           document.getElementsByName("ranura")[0].value,
        "Observaciones":        document.getElementsByName("observaciones")[0].value,
        "Sugerencia":           document.getElementsByName("sugerencias")[0].value,
        "Id_motor":             geturl
    });
    
}

/*
 * Agregar usuario
 * obtiene true si lo guardo en la base de datos
 */
function guardarrebobinado(){
    toastr.options.positionClass = 'toast-top-center';
    var boton = document.getElementById('ocultarboton');
    var boton1 = document.getElementById('modificarboton');
    if(document.getElementsByName("v")[0].value=="" || document.getElementsByName("capmarcha")[0].value=="" ||
      document.getElementsByName("caparran")[0].value=="" || document.getElementsByName("am")[0].value=="" ||
      document.getElementsByName("balinerasref")[0].value=="" || document.getElementsByName("largo")[0].value=="" ||
      document.getElementsByName("sellomec")[0].value=="" || document.getElementsByName("paso")[0].value=="" ||
      document.getElementsByName("espiras")[0].value=="" || document.getElementsByName("calibre")[0].value=="" ||
      document.getElementsByName("pesobobina")[0].value=="" || document.getElementsByName("paso1")[0].value=="" ||
      document.getElementsByName("espiras1")[0].value=="" || document.getElementsByName("calibre1")[0].value=="" ||
      document.getElementsByName("pesobobi1")[0].value=="" || document.getElementsByName("ranura")[0].value=="" ||
      document.getElementsByName("observaciones")[0].value=="" || document.getElementsByName("sugerencias")[0].value==""){
        notificacion(); 
        
    }else{
        jQuery.ajax({
             type: "POST",
             url: servidor+"rebobinado", 
             dataType: "json",
             data: jsonrebobinado(),
             success: function (data, status, jqXHR) {
                 if(data.estados == 1){
                    CambiarEstadomotor();
                    boton.style.display = 'none';
                    boton.style.display = 'block';
                    toastr.info('Se Ha Registrado Esta Funcion De Este Motor Correctamente');
                    setInterval(function(){location.reload();},2000);
                 }else{
                    //alert("Esta Cedula Se Encuentra Registrada");
                 }
             },
             error: function (jqXHR, status) {
                 alert("Erro rebobinado");
             }
        });
    }
        
}

/**
 * Json de agregar usuario
 * returna 1 si es true
 */
function jsonrebobinado(){
    
         return JSON.stringify({
            "Id_motor":             geturl,
            "Id_usuario":           document.getElementsByName("ce1")[0].value,
            "V":                    document.getElementsByName("v")[0].value,
            "Am":                   document.getElementsByName("am")[0].value,
            "Balinera_ref":         document.getElementsByName("balinerasref")[0].value,
            "Cap_marcha":           document.getElementsByName("capmarcha")[0].value,
            "Largo":                document.getElementsByName("largo")[0].value,
            "Conexiones":           document.getElementsByName("cone")[0].value,
            "Cap_arranque":         document.getElementsByName("caparran")[0].value,
            "Sello_mecanico":       document.getElementsByName("sellomec")[0].value,
            "Arr_paso":             document.getElementsByName("paso")[0].value,
            "Arr_espiras":          document.getElementsByName("espiras")[0].value,
            "Arr_calibre":          document.getElementsByName("calibre")[0].value,
            "Arr_peso_por_bobina":  document.getElementsByName("pesobobina")[0].value,
            "Mar_paso":             document.getElementsByName("paso1")[0].value,
            "Mar_espira":           document.getElementsByName("espiras1")[0].value,
            "Mar_calibre":          document.getElementsByName("calibre1")[0].value,
            "Mar_peso_por_bobina":  document.getElementsByName("pesobobi1")[0].value,
            "Num_ranura":           document.getElementsByName("ranura")[0].value,
            "Observaciones":        document.getElementsByName("observaciones")[0].value,
            "Sugerencia":           document.getElementsByName("sugerencias")[0].value,
        });
    
}
/**
 * ver estado del motor en rebobinados si es true desactivamos los 
 * campos para no ser modificados
 */
function verestadomotorrebobinado(id){
    jQuery.ajax({
         type: "GET",
         url: servidor+"rebobinado/"+id, 
         dataType: "json",
         success: function (data, status, jqXHR) {
             if(data!=null){
                
                for(var i=0;i < data.length; i++){
                    
                    document.getElementsByName("v")[0].value = data[i].V;
                    document.getElementById("v1").disabled = false;
                    document.getElementsByName("capmarcha")[0].value = data[i].CapMarcha;
                    document.getElementById("capmarcha1").disabled = false;
                    //document.getElementsByName("cone")[0].value = data[i].Balineras;
                    document.getElementById("cone1").disabled = false;
                    document.getElementsByName("caparran")[0].value = data[i].CapArranque;
                    document.getElementById("caparran1").disabled = false;
                    document.getElementsByName("am")[0].value = data[i].Am;
                    document.getElementById("am1").disabled = false;
                    document.getElementsByName("balinerasref")[0].value = data[i].Balineras;
                    document.getElementById("balinerasref1").disabled = false;
                    document.getElementsByName("largo")[0].value = data[i].Largo;
                    document.getElementById("largo1").disabled = false;
                    document.getElementsByName("sellomec")[0].value = data[i].Sello;
                    document.getElementById("sellomec1").disabled = false;
                    document.getElementsByName("paso")[0].value = data[i].Arr_paso;
                    document.getElementById("paso1").disabled = false;
                    document.getElementsByName("espiras")[0].value = data[i].Arr_esp;
                    document.getElementById("espiras1").disabled = false;
                    document.getElementsByName("calibre")[0].value = data[i].Arr_cal;
                    document.getElementById("calibre1").disabled = false;
                    document.getElementsByName("pesobobina")[0].value = data[i].Arr_pe_bob;
                    document.getElementById("pesobobina1").disabled = false;
                    document.getElementsByName("paso1")[0].value = data[i].Mar_paso;
                    document.getElementById("paso11").disabled = false;
                    document.getElementsByName("espiras1")[0].value = data[i].Mar_espira;
                    document.getElementById("espiras11").disabled = false;
                    document.getElementsByName("calibre1")[0].value = data[i].Mar_calibr;
                    document.getElementById("calibre11").disabled = false;
                    document.getElementsByName("pesobobi1")[0].value = data[i].Mar_pes_bob;
                    document.getElementById("pesobobi11").disabled = false;
                    document.getElementsByName("ranura")[0].value = data[i].Num_ranura;
                    document.getElementById("ranura1").disabled = false;
                    document.getElementsByName("observaciones")[0].value = data[i].Observacio;
                    document.getElementById("observaciones1").disabled = false;
                    document.getElementsByName("sugerencias")[0].value = data[i].sugerencias;
                    document.getElementById("sugerencias1").disabled = false;
                    document.getElementById("ocultarboton").style.display = 'none';
                }
                 
             }else{
                alert("d");
             }

         },
         error: function (jqXHR, status) {
             alert("error buscar user");
         }
    });
}