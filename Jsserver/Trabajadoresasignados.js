

function jsonasignarempleado(){
    return JSON.stringify({
        "Idjefe":       idjefe,
        "Idempleado":   vect
    });
}

function asignarempleado(){
    toastr.options.positionClass = 'toast-top-center';
    alert(jsonasignarempleado());
    jQuery.ajax({
         type: "POST",
         url: servidor+"asiganarempleado", 
         dataType: "json",
         data: jsonasignarempleado(),
         success: function (data, status, jqXHR) {
             
             if(data.estados == 1){ 
                toastr.info('Se Ha Registrado Correctamente');
                setInterval(function(){location.reload();},3000);
             }
         },
         error: function (jqXHR, status) {
            alert("Error asignar empleado");
         }
    });  
}


function jsoncambiarestado(){
    return JSON.stringify({
        "Id_usu":   vect
    });
}

function cambiarestadotipo(){
    toastr.options.positionClass = 'toast-top-center';
    //alert(jsonasignarempleado());
    jQuery.ajax({
         type: "PUT",
         url: servidor+"cambiartipo", 
         dataType: "json",
         data: jsoncambiarestado(),
         success: function (data, status, jqXHR) {
             
             if(data.estados == 1){ 
                //toastr.info('Se Ha Registrado Correctamente');
                //setInterval(function(){location.reload();},3000);
             }
         },
         error: function (jqXHR, status) {
            alert("Error cambiar tipo estado");
         }
    });  
}
