function notificacion(){
    alertify.error("Todos los campos son obligatorios"); 
    return false;
}
function notificacionaceptar(){
    alertify.success("Se ha registrado el mantenimiento"); 
    return false;
}
/**
 * registrar mantenimiento de controlador
 * de bobinas
 */
function registrarmantenimiento(){
    toastr.options.positionClass = 'toast-top-center';
    var boton = document.getElementById('modificarboton1');
   if(document.getElementsByName("amp")[0].value=="" || document.getElementsByName("voltios")[0].value=="" || document.getElementsByName("balineras")[0].value=="" || document.getElementsByName("sello")[0].value=="" || document.getElementsByName("capacitor")[0].value=="" || document.getElementsByName("marcha")[0].value=="" || document.getElementsByName("otros")[0].value=="" || document.getElementsByName("pruebas")[0].value=="" || document.getElementsByName("observaciones")[0].value==""){
       notificacion();
   }else{
        jQuery.ajax({
             type: "POST",
             url: servidor+"mantenimiento", 
             dataType: "json",
             data: jsonregistrarmantenimiento(),
             success: function (data, status, jqXHR) {
                 if(data.estados == 1){
                    CambiarEstadomotor();
                    toastr.info('Se Ha Registrado Esta Funcion De Este Motor Correctamente');
                    setInterval(function(){location.reload();},2000);
                    boton.style.display = 'inline'; 
                 }
             },
             error: function (jqXHR, status) {
                 alert("Erro motor");
             }
        });
   }
}
/* json de registrar de mantenimiento
 * 
 */
function jsonregistrarmantenimiento(){    
    return JSON.stringify({
        "Id_motor":             geturl,
        "Id_usuario":           document.getElementsByName("c1")[0].value,
        "Amp":                  document.getElementsByName("amp")[0].value,
        "Voltios":              document.getElementsByName("voltios")[0].value,
        "Balineras":            document.getElementsByName("balineras")[0].value,
        "Sello_mecanico":       document.getElementsByName("sello")[0].value,
        "Cap_arranque":         document.getElementsByName("capacitor")[0].value,
        "Cap_marcha":           document.getElementsByName("marcha")[0].value,
        "otros":                document.getElementsByName("otros")[0].value,
        "P_finales":            document.getElementsByName("pruebas")[0].value,
        "Observaciones":        document.getElementsByName("observaciones")[0].value
    });
}

/**
 * Actualizar mantenimiento de controlador
 * de bobinas
 */
function modificarmantenimiento(){
   
    jQuery.ajax({
         type: "PUT",
         url: servidor+"mantenimiento", 
         dataType: "json",
         data: jsonactualizarmantenimiento(),
         success: function (data, status, jqXHR) {
             if(data.estados == 1){
                 alert("Se Ha Actualizado Correctamente");
                 location.reload();
             }
         },
         error: function (jqXHR, status) {
             alert("Erro motor");
         }
    });
   
}
/* json de Actualizar de mantenimiento
 * 
 */
function jsonactualizarmantenimiento(){    
    return JSON.stringify({
        "Amp":                  document.getElementsByName("amp")[0].value,
        "Voltios":              document.getElementsByName("voltios")[0].value,
        "Balineras":            document.getElementsByName("balineras")[0].value,
        "Sello_mecanico":       document.getElementsByName("sello")[0].value,
        "Cap_arranque":         document.getElementsByName("capacitor")[0].value,
        "Cap_marcha":           document.getElementsByName("marcha")[0].value,
        "otros":                document.getElementsByName("otros")[0].value,
        "P_finales":            document.getElementsByName("pruebas")[0].value,
        "Observaciones":        document.getElementsByName("observaciones")[0].value,
        "Id_motor":             geturl
    });
}

/**
 * Cambiamos el estado del motor 
 * si se ha registrado del control de motorres
 */
function CambiarEstadomotor(){
    jQuery.ajax({
         type: "PUT",
         url: servidor+"motores", 
         dataType: "json",
         data: jsoncambiarestado(),
         success: function (data, status, jqXHR) {
             //consultarcuenta();
             if(data.estados == 1){
                 //location.reload();
             }
         },
         error: function (jqXHR, status) {
             alert("Error editar motor");
         }
    });
}
/**
 * json de cambiar estado
 */
function jsoncambiarestado(){
    return JSON.stringify({
        "Id_motores": geturl
    });
}
/**
 * ver estado del motor si es true desactivamos los 
 * campos para no ser modificados
 */
function verestadomotormantenimiento(id){
    jQuery.ajax({
         type: "GET",
         url: servidor+"mantenimiento/"+id, 
         dataType: "json",
         success: function (data, status, jqXHR) {
             if(data!=null){
                
                for(var i=0;i < data.length; i++){
                    document.getElementsByName("amp")[0].value = data[i].Amp;
                    document.getElementById("amp1").disabled = false;
                    document.getElementsByName("voltios")[0].value = data[i].Voltios;
                    document.getElementById("vol1").disabled = false;
                    document.getElementsByName("balineras")[0].value = data[i].Balineras;
                    document.getElementById("balineras1").disabled = false;
                    document.getElementsByName("sello")[0].value = data[i].Sello;
                    document.getElementById("sello1").disabled = false;
                    document.getElementsByName("capacitor")[0].value = data[i].Arranque;
                    document.getElementById("capa1").disabled = false;
                    document.getElementsByName("marcha")[0].value = data[i].Marcha;
                    document.getElementById("marcha1").disabled = false;
                    document.getElementsByName("otros")[0].value = data[i].Otros;
                    document.getElementById("otros1").disabled = false;
                    document.getElementsByName("pruebas")[0].value = data[i].Pruebas;
                    document.getElementById("pruebas1").disabled = false;
                    document.getElementsByName("observaciones")[0].value = data[i].Observa;
                    document.getElementById("obs1").disabled = false;
                    document.getElementById("ocultarboton").style.display = 'none';
                }
                 
             }

         },
         error: function (jqXHR, status) {
             alert("error buscar mantenimiento");
         }
    });
}