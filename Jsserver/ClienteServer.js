
 /*
 * json de registrar cliente para transformador
 * 
 */
function jsonregistrarclientetrans(){    
    return JSON.stringify({
        "Nom_cliente":      document.getElementsByName("nomb_user")[0].value,
        "Cedula":           document.getElementsByName("ced_user")[0].value,
        "Telefono":         document.getElementsByName("tele_user")[0].value,
        "Direccion":        document.getElementsByName("dire_user")[0].value,
        "Apellido":         document.getElementsByName("ape_user")[0].value,
        "Fecha_ingre":      document.getElementsByName("fecha_user")[0].value,
        "Ciudad":           document.getElementsByName("ciu_user")[0].value,
        "Email":            document.getElementsByName("emai_user")[0].value
    });
}
/**
 * registra cliente del motor
 * 
 */
 var id_clientetran;
function registrarclientetrans(){
    var f = new Date(); 
    var fentrega1 = f.getFullYear() + "-" +(f.getMonth() +1) + "-"  + (f.getDate()+1) ;
    var finicial = document.getElementsByName('fentrega')[0].value;
    var ffinal = document.getElementsByName('fterminacion')[0].value; 
   if(document.getElementsByName("nomb_user")[0].value=="" || document.getElementsByName("ced_user")[0].value=="" || 
      document.getElementsByName("tele_user")[0].value=="" || document.getElementsByName("dire_user")[0].value=="" ||
      document.getElementsByName("ape_user")[0].value=="" || document.getElementsByName("fecha_user")[0].value=="" || 
      document.getElementsByName("marca")[0].value=="" || document.getElementsByName("nplaca")[0].value=="" || 
      document.getElementsByName("emai_user")[0].value==""){
        toastr.info('Los campos del cliente son obligatorios y la marca del transformador');
    }else{
        if(validate_fechaMayorQue(fentrega1,finicial) && validate_fechaMayorQue(fentrega1,ffinal)){
            if(document.getElementsByName("idoculto")[0].value == ""){
                jQuery.ajax({
                     type: "POST",
                     url: servidor+"cliente", 
                     dataType: "json",
                     data: jsonregistrarclientetrans(),
                     success: function (data, status, jqXHR) {
                         if(data.estados == 1){
                            maxIdclientetran();
                         }
                     },
                     error: function (jqXHR, status) {
                        toastr.error('Esta Cedula Ya Esta Registrada');
                        setInterval(function(){location.reload();},2000);
                     }
                });
            }else{
                id_clientetran = document.getElementsByName('idoculto')[0].value;
                agregartransformador();
            }
        }else{
            toastr.info('La fecha debe empezar dos dias despues de la fecha actual');
        }

    }
     
}
/*
 * json de registrar cliente
 * 
 */
function jsonregistrarcliente(){    
    return JSON.stringify({
        "Nom_cliente":      document.getElementsByName("nomb_user")[0].value,
        "Cedula":           document.getElementsByName("ced_user")[0].value,
        "Telefono":         document.getElementsByName("tele_user")[0].value,
        "Direccion":        document.getElementsByName("dire_user")[0].value,
        "Ciudad":           document.getElementsByName("ciu_user")[0].value,
        "Apellido":         document.getElementsByName("ape_user")[0].value,
        "Fecha_ingre":      document.getElementsByName("fecha_user")[0].value,
        "Email":            document.getElementsByName("correo_user")[0].value
    });
}

function validate_fechaMayorQue(fechaInicial,fechaFinal){
    valuesStart=fechaInicial.split("-");
    valuesEnd=fechaFinal.split("-");

    // Verificamos que la fecha no sea posterior a la actual
    var dateStart=new Date(valuesStart[2],(valuesStart[1]-1),valuesStart[0]);
    var dateEnd=new Date(valuesEnd[2],(valuesEnd[1]-1),valuesEnd[0]);
    if(dateStart>=dateEnd)
    {
        return 0;
    }
    return 1;
}

/**
 * registra cliente del motor
 * 
 */
var id_cliente;
function registrarcliente(){
    var f = new Date(); 
    var fentrega1 = f.getFullYear() + "-" +(f.getMonth() +1) + "-"  + (f.getDate()+1) ; 
    var finicial = document.getElementById('feentrega').value;
    var ffinal = document.getElementById('feterminacion').value;
    //alert(fentrega1+" "+finicial);
    if (document.getElementsByName('nomb_user')[0].value==""||document.getElementsByName('ape_user')[0].value=="" ||
        document.getElementsByName('dire_user')[0].value=="" || document.getElementsByName('tele_user')[0].value=="" || 
        document.getElementsByName('ced_user')[0].value=="" || document.getElementsByName('ciu_user')[0].value=="" ||
        document.getElementsByName('numserie')[0].value=="" || document.getElementsByName('marca')[0].value=="" || 
        document.getElementsByName("correo_user")[0].value=="") {
        toastr.info('Los campos del cliente son obligatorios y la serie del motor');
    }else{
        
        if(validate_fechaMayorQue(fentrega1,finicial) && validate_fechaMayorQue(fentrega1,ffinal)){
            if(document.getElementsByName("idoculto")[0].value == ""){
                //alert(jsonregistrarcliente());
                jQuery.ajax({
                     type: "POST",
                     url: servidor+"cliente", 
                     dataType: "json",
                     data: jsonregistrarcliente(),
                     success: function (data, status, jqXHR) {
                         if(data.estados == 1){
                            maxIdcliente();
                         }
                     },
                     error: function (jqXHR, status) {
                        toastr.error('Esta Cedula Ya Esta Registrada');
                        setInterval(function(){location.reload();},2000);
                     }
                }); 
            }else{
                id_cliente = document.getElementsByName('idoculto')[0].value;
                registrarMotor();
            }
        }else{
            toastr.info('La fecha debe empezar dos dias despues de la fecha actual');
        }
    }
}


/**
 * json de actualizar datos
 * enviamos por peticion de json
 */
function jsonmodificarcliente(){    
    return JSON.stringify({
        "Nom_cliente":      document.getElementsByName("ncliente")[0].value,
        "Id_cliente":       document.getElementsByName("ns")[0].value,
        "Telefono":         document.getElementsByName("tel")[0].value,
        "Direccion":        document.getElementsByName("dir")[0].value,
        "Ciudad":           document.getElementsByName("city")[0].value,
        "Apellido":         document.getElementsByName("napelli")[0].value,
        "Fecha_ingre":      document.getElementsByName("fecha_ing")[0].value
    });
}
/**
 * modificar datos del cliente en la ventana modal 
 * de menu_admin_motores_edit
 */
function modificarcliente(){
   
    jQuery.ajax({
         type: "PUT",
         url: servidor+"cliente", 
         dataType: "json",
         data: jsonmodificarcliente(),
         success: function (data, status, jqXHR) {
             //consultarcuenta();
             if(data.estados == 1){
                 Actualizadatosmotor();
                //alert("Se Ha Modificado Correctamente");
                 //location.reload();
             }
         },
         error: function (jqXHR, status) {
             alert("Error editar cliete");
         }
    });
}
/**
 * id del cliente motores
 */

function maxIdcliente(){
    jQuery.ajax({
         type: "GET",
         url: servidor+"cliente", 
         dataType: "json",
         success: function (data, status, jqXHR) {
             if(data!=null){
                 
                for(var i=0;i < data.length; i++){
                    id_cliente = data[i].Id;
                    registrarMotor();
                }
                 
             }

         },
         error: function (jqXHR, status) {
             alert("error buscar user");
         }
    });
    
}
/**
 * id del cliente tranformadores
 */

function maxIdclientetran(){
    jQuery.ajax({
         type: "GET",
         url: servidor+"cliente", 
         dataType: "json",
         success: function (data, status, jqXHR) {
             if(data!=null){
                for(var i=0;i < data.length; i++){
                    id_clientetran = data[i].Id;
                    agregartransformador();
                }
                 
             }

         },
         error: function (jqXHR, status) {
             alert("error buscar user");
         }
    });
    
}
/**
 * json de datos del cliente
 */
function VerDatosCliente(idcli,idtra){
    jQuery.ajax({
         type: "GET",
         url: servidor+"cliente/"+idcli+"/"+idtra, 
         dataType: "json",
         success: function (data, status, jqXHR) {
             if(data!=null){
                 
                for(var i=0;i < data.length; i++){
                    document.getElementsByName("nomcliente")[0].value = data[i].Nombre;
                    document.getElementsByName("fechaingreso")[0].value = data[i].Fecha;
                    document.getElementsByName("marcatrans")[0].value = data[i].Marca;
                }
                 
             }

         },
         error: function (jqXHR, status) {
             alert("error buscar datos cliente");
         }
    });
}

/**
 * json de consultar datos del cliente por medio del idtransformador
 */

function consultardatos(idtra){
    jQuery.ajax({
         type: "GET",
         url: servidor+"cliente/"+idtra, 
         dataType: "json",
         success: function (data, status, jqXHR) {
             if(data!=null){
                 
                for(var i=0;i < data.length; i++){
                    var idcliente = data[i].Id;
                    VerDatosCliente(idcliente,idtra);
                }
                 
             }

         },
         error: function (jqXHR, status) {
             alert("error buscar user");
         }
    });
}
/*
*   Busqueda Avanzada
*/
function busquedaAvanzada(peticion){
    jQuery.ajax({
         type: "GET",
         url: servidor+"clientes/avanzada/" + peticion, 
         dataType: "json",
         success: function (data, status, jqXHR) {
             if(data!=null){
                document.getElementById('clientereg').innerHTML = data.Nombre + " " + data.Apellidos;
                document.getElementById('textced').value = data.Cedula;
                document.getElementById('textid').value = data.Id
                document.getElementById('textnom').value = data.Nombre;
                document.getElementById('textape').value = data.Apellidos;
                document.getElementById('telereg').innerHTML = data.Telefono;
                document.getElementById('texttel').value = data.Telefono;
                document.getElementById('textdir').value = data.Direccion;
                document.getElementById('textciu').value = data.Ciudad;
                //$('#agrega_motor').modal(); 
             }

         },
         error: function (jqXHR, status) {
             alert("error buscar user");
         }
    });
}