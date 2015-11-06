function explode(){
    location.reload();   
}

function agregarbobinasecundario(){
    var id = document.getElementById("alerta1");
    toastr.options.positionClass = 'toast-top-center';
    if(document.getElementsByName("tipoconductor")[0].value=="" || document.getElementsByName("medidaconductor")[0].value==""||
      document.getElementsByName("capassecu")[0].value=="" || document.getElementsByName("espitacapas")[0].value=="" || 
      document.getElementsByName("bobinasec")[0].value=="" || document.getElementsByName("n2secu")[0].value=="" ||       document.getElementsByName("aislamientosec")[0].value=="" || document.getElementsByName("refrigesec")[0].value=="" || document.getElementsByName("calibresecu")[0].value=="" || document.getElementsByName("biselsecundario")[0].value=="" || document.getElementsByName("observacionsec")[0].value==""){
        toastr.info('Estos datos son obligatorios');
    }else{
        jQuery.ajax({
             type: "POST",
             url: servidor+"secundario", 
             dataType: "json",
             data: jsonRegistrabobinasecundario(),
             success: function (data, status, jqXHR) {
                 if(data.estado == 1){ 
                    toastr.info('Se Ha Registrado Esta Bobina Segundaria');
                    setInterval(function(){location.reload();},3000);
                 }
             },
             error: function (jqXHR, status) {
                 alert("Erro bobina secundaria");
             }
        });
    }
    
}
/**
 * json de registrar bobinado
 */
function jsonRegistrabobinasecundario(){
    return JSON.stringify({
        "Tipoconductor":        document.getElementsByName("tipoconductor")[0].value,
        "Medidasconductor":     document.getElementsByName("medidaconductor")[0].value,
        "Capas":                document.getElementsByName("capassecu")[0].value,
        "Espiracapas":          document.getElementsByName("espitacapas")[0].value,
        "Bobinas":              document.getElementsByName("bobinasec")[0].value,
        "N2":                   document.getElementsByName("n2secu")[0].value,
        "Aislamientocapa":      document.getElementsByName("aislamientosec")[0].value, 
        "Refrigeracion":        document.getElementsByName("refrigesec")[0].value,
        "Calibrefibra":         document.getElementsByName("calibresecu")[0].value,
        "Bisel":                document.getElementsByName("biselsecundario")[0].value,
        "Observacion":          document.getElementsByName("observacionsec")[0].value,
        "Idrepa":               geturl
    });
}

function actualizarbobinasecundario(){
    var id = document.getElementById("alerta1");
    jQuery.ajax({
         type: "PUT",
         url: servidor+"bobinasegundaria", 
         dataType: "json",
         data: jsonActualizarbobinasecundario(),
         success: function (data, status, jqXHR) {
            if(data.estado == 1){ 
                toastr.info('Actualizado bobina secundaria');
                location.reload();
            }
         },
         error: function (jqXHR, status) {
             alert("Erro bobina secundaria");
         }
    });
}

/**
 * json de actualizar bobinado
 */
function jsonActualizarbobinasecundario(){
    return JSON.stringify({
        "Tipoconductor":        document.getElementsByName("tipoconductor1")[0].value,
        "Medidasconductor":     document.getElementsByName("medidaconductor1")[0].value,
        "Capas":                document.getElementsByName("capassecu1")[0].value,
        "Espiracapas":          document.getElementsByName("espitacapas1")[0].value,
        "Bobinas":              document.getElementsByName("bobinasec1")[0].value,
        "N2":                   document.getElementsByName("n2secu1")[0].value,
        "Aislamientocapa":      document.getElementsByName("aislamientosec1")[0].value, 
        "Refrigeracion":        document.getElementsByName("refrigesec1")[0].value,
        "Calibrefibra":         document.getElementsByName("calibresecu1")[0].value,
        "Bisel":                document.getElementsByName("biselsecundario1")[0].value,
        "Id":                   document.getElementsByName("idsegundario")[0].value,
        "Observacion":          document.getElementsByName("observacionsec1")[0].value
    }); 
}

function datossegundario(id1){
    jQuery.ajax({
         type: "GET",
         url: servidor+"bobinasecundario/"+id1, 
         dataType: "json",
         success: function (data, status, jqXHR) {
             if(data!=null){
                 
                for(var i=0;i < data.length; i++){
                    document.getElementsByName("tipoconductor1")[0].value = data[i].tipoconductor;
                    document.getElementsByName("medidaconductor1")[0].value = data[i].medidasconductor;
                    document.getElementsByName("capassecu1")[0].value = data[i].capas;
                    document.getElementsByName("espitacapas1")[0].value = data[i].espiracapas;
                    document.getElementsByName("bobinasec1")[0].value = data[i].bobina;
                    document.getElementsByName("n2secu1")[0].value = data[i].n2;
                    document.getElementsByName("aislamientosec1")[0].value = data[i].aislamientocapa;
                    document.getElementsByName("refrigesec1")[0].value = data[i].refrigeracion;
                    document.getElementsByName("calibresecu1")[0].value = data[i].calibrefibra;
                    document.getElementsByName("biselsecundario1")[0].value = data[i].bisel;
                    document.getElementsByName("observacionsec1")[0].value = data[i].observacion;
                    document.getElementsByName("idsegundario")[0].value = data[i].idsegundario;
                }
                 
             }

         },
         error: function (jqXHR, status) {
             alert("error buscar user");
         }
    });
    
}