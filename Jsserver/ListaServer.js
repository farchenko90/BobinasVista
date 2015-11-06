function explode(){
    location.reload();   
}
/**
 * mostramos la opcion de otros al cambiar a cual
 */
function mostrarcual(){
    var opc = document.getElementById("opcion");
    var ch = document.getElementById("otros");
    if(ch.checked == true){
        opc.style.display = 'block';
    }else{
        opc.style.display = 'none';
    }
}

/**
 * json de guardar lista
 */
function jsonregistrolista(){
    return JSON.stringify({
        "Lista_lista":          vec,
        "Id_tra_lista":         idmax,
        "Cual_lista":           document.getElementsByName("txtcual")[0].value,
        "Observacion_lista":    document.getElementById("obser").value
    });
}
/**
 * agregamos a la base de datos los campos de la lista
 */
function agregarlista(){
    //alert(jsonregistrolista());
    var id = document.getElementById("alerta");
    jQuery.ajax({
         type: "POST",
         url: servidor+"lista", 
         dataType: "json",
         data: jsonregistrolista(),
         success: function (data, status, jqXHR) {
             if(data.estado == 1){ 
                toastr.info('Se Ha Registrado Este Transformador Correctamente');
                setInterval(function(){location.reload();},2000);
             }
         },
         error: function (jqXHR, status) {
             alert("Erro lista");
         }
    });
}

