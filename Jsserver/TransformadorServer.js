function explode(){
    location.reload();   
}
/**
 * registramos el vector
 */
var vec = new Array();
function registrarvector(){
    var checkboxes = document.getElementById("form1").checkbox;
    //alert(checkboxes.length);
    if(document.getElementById('desele').checked=="" && document.getElementById('desafm').checked=="" &&
       document.getElementById('sobretension').checked=="" && document.getElementById('sobrecarga').checked=="" && 
       document.getElementById('fal_man').checked=="" && document.getElementById('ef_inst').checked=="" &&
       document.getElementById('otros').checked==""){
        toastr.error('Al menos un campo es obligatorio en la lista de verificacion');
    }else{
        for (var x=0; x < checkboxes.length; x++) {
            if (checkboxes[x].checked) {
                vec.push(checkboxes[x].value);
            }
        }
        registrarclientetrans();    
    }
    
}
/**
 * agregamos a la base de datos los campos del transformador
 */
function agregartransformador(){
    //var id = document.getElementById("alerta");
    
        jQuery.ajax({
             type: "POST",
             url: servidor+"transformador", 
             dataType: "json",
             data: jsonRegistraTransformador(),
             success: function (data, status, jqXHR) {
                 if(data.estado == 1){ 
                     maxId();
                 }
             },
             error: function (jqXHR, status) {
                 //alert("Erro usuario");
             }
         });
        
    
    
}
/**
 * json de registrar transformador
 */
var photo="";
function jsonRegistraTransformador(){
    if(NomImg1==""){
        photo = "transformador.jpg";
    }else{
        photo = NomImg1;
    }
    return JSON.stringify({
        "Marca_tran":       document.getElementsByName("marca")[0].value,
        "Nplaca_tran":      document.getElementsByName("nplaca")[0].value,
        "Kva_tran":         document.getElementsByName("kva")[0].value,
        "Tp_tran":          document.getElementsByName("tp")[0].value,
        "Ts_tran":          document.getElementsByName("ts")[0].value,
        "Tipo_acc_tran":    document.getElementsByName("tipo_usuario")[0].value,
        "Fe_acor_tran":     document.getElementsByName("fentrega")[0].value, 
        "Fe_ter_tran":      document.getElementsByName("fterminacion")[0].value,
        "Foto":             photo,
        "IdClie_tran":      id_clientetran,
        "Idusu_tran":       document.getElementsByName("revicion2")[0].value
    });
}
/**
 * Servicio de consultar datos usario ventana modal de motores
 * obtiene un array de datos del json
 */
var idmax;
function maxId(){
    jQuery.ajax({
         type: "GET",
         url: servidor+"transformador", 
         dataType: "json",
         success: function (data, status, jqXHR) {
             if(data!=null){
                 
                for(var i=0;i < data.length; i++){
                    idmax = data[i].Id;
                    guardarprueba();
                    agregarlista();
                }
                 
             }

         },
         error: function (jqXHR, status) {
             alert("error buscar user");
         }
    });
    
}
/*
*Datos del modal menu del dato de primaria
*/
function DatosTransformador(id){
    jQuery.ajax({
         type: "GET",
         url: servidor+"transformador/"+id, 
         dataType: "json",
         success: function (data, status, jqXHR) {
             if(data!=null){
                 
                for(var i=0;i < data.length; i++){
                    document.getElementsByName("nomcliente")[0].value = data[i].NomCliente;
                    document.getElementsByName("fechaingreso")[0].value = data[i].Fecha;
                    document.getElementsByName("nsecuncia")[0].value = data[i].NSecuencia;
                    document.getElementsByName("kva")[0].value = data[i].KVA;
                    document.getElementsByName("marcatra")[0].value = data[i].Marca;
                    document.getElementsByName("vprimario")[0].value = data[i].Primario;
                    document.getElementsByName("vegundario")[0].value = data[i].Segundario;
                    
                    document.getElementsByName("nomcliente1")[0].value = data[i].NomCliente;
                    document.getElementsByName("fechaingreso1")[0].value = data[i].Fecha;
                    document.getElementsByName("nsecuncia1")[0].value = data[i].NSecuencia;
                    document.getElementsByName("kva1")[0].value = data[i].KVA;
                    document.getElementsByName("marcatra1")[0].value = data[i].Marca;
                    document.getElementsByName("vprimario1")[0].value = data[i].Primario;
                    document.getElementsByName("vegundario1")[0].value = data[i].Segundario;
                    
                }
                 
             }
         },
         error: function (jqXHR, status) {
             alert("error buscar user");
         }
    });
    
}

function cambiarestadotransf(id){
    jQuery.ajax({
         type: "PUT",
         url: servidor+"transformador/estado", 
         dataType: "json",
         data: jsonmodificarestado(id),
         success: function (data, status, jqXHR) {
             //consultarcuenta();
             if(data.estados == 1){
                 //modificarcliente();
                //alert("cambio");
             }
         },
         error: function (jqXHR, status) {
             alert("Error actualizar estado transformador");
         }
    });
}

function jsonmodificarestado(id){    
    return JSON.stringify({
        "Id_tran":  id              
    });
}

function validate_fechaMayorQue(fechaInicial,fechaFinal){
    //alert(fechaInicial+" "+fechaFinal)
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

/*
*modificar transformador
*/
function modificartransformador(){
    var f = new Date(); 
    var fentrega2 = f.getFullYear() + "-" +(f.getMonth() +1) + "-"  + (f.getDate()+1) ; 
    var finicial1 = document.getElementById('finicial').value;
    var ffinal1 = document.getElementById('ffinal').value;
    //alert(fentrega1+" "+finicial+" "+ffinal);
    if(validate_fechaMayorQue(fentrega2,finicial1) && validate_fechaMayorQue(fentrega2,ffinal1)){
        jQuery.ajax({
             type: "PUT",
             url: servidor+"transformador", 
             dataType: "json",
             data: jsonModificarTransformador(),
             success: function (data, status, jqXHR) {
                 if(data.estado == 1){ 
                    toastr.info('Se Ha Actualizado Este Transformador Correctamente');
                    setInterval(function(){location.reload();},2000);
                 }
             },
             error: function (jqXHR, status) {
                 alert("Error modificar transformador");
             }
         });
    }else{
        toastr.error('La fecha debe empezar dos dias despues de la fecha actual');
    }
        
}
/**
 * json de modificar transformador
 */
var photo1="";
function jsonModificarTransformador(){
    if(NomImg1==""){
        photo1 = "transformador.jpg";
    }else{
        photo1 = NomImg1;
    }
    return JSON.stringify({
        "Marca_tran":       document.getElementsByName("marcamod")[0].value,
        "Nplaca_tran":      document.getElementsByName("nplacamod")[0].value,
        "Kva_tran":         document.getElementsByName("kvamod")[0].value,
        "Tp_tran":          document.getElementsByName("tpmod")[0].value,
        "Ts_tran":          document.getElementsByName("tsmod")[0].value,
        "Tipo_acc_tran":    document.getElementsByName("tipo_usuariomod")[0].value,
        "Fe_acor_tran":     document.getElementsByName("fentregamod")[0].value, 
        "Fe_ter_tran":      document.getElementsByName("fterminacionmod")[0].value,
        "Foto":             photo1,
        "Id_tran":          idtrasnformador,
        "Idusu_tran":       document.getElementsByName('revicion3')[0].value 
    });
}
var idtrasnformador;
function getalltransformador(id){
    jQuery.ajax({
         type: "GET",
         url: servidor+"transformador/all/"+id, 
         dataType: "json",
         success: function (data, status, jqXHR) {
             if(data!=null){
                for(var i=0;i < data.length; i++){
                    idtrasnformador = data[i].Id;
                    //document.getElementById("imgInv2").src = servidor + "imagenestransformador/" + data[i].Foto;
                    document.getElementsByName("marcamod")[0].value = data[i].Marca;
                    document.getElementsByName("nplacamod")[0].value = data[i].Placa;
                    document.getElementsByName("kvamod")[0].value = data[i].KVA;
                    document.getElementsByName("tpmod")[0].value = data[i].TP;
                    document.getElementsByName("tsmod")[0].value = data[i].TS;
                    document.getElementsByName("tipo_usuariomod")[0].value= data[i].Tipo;
                    document.getElementsByName("fentregamod")[0].value= data[i].Facor;
                    document.getElementsByName("fterminacionmod")[0].value=data[i].Fter;
                    document.getElementsByName("revicion3")[0].value=data[i].Id_usu;
                    NomImg1 = data[i].Foto;
                    
                }
                 
             }

         },
         error: function (jqXHR, status) {
             alert("error buscar transformador");
         }
    });
    
}


function verdatoseliminartransformador(id){
    jQuery.ajax({
         type: "GET",
         url: servidor+"transformadorverdatos/"+id, 
         dataType: "json",
         success: function (data, status, jqXHR) {
             if(data!=null){
                 var ver = document.getElementById("mostrar");
                 //alert(data.Cliente);
                document.getElementById("vercliente1").innerHTML = data.Cliente;
                document.getElementById("vermarca1").innerHTML = data.Marca;
                document.getElementById("verserie1").innerHTML = data.Placa;
                document.getElementById("verestado1").innerHTML = data.Estado;
                document.getElementById("verentrada1").innerHTML = data.Accion;
                 if(data.Estado=="Terminado"){
                        ver.innerHTML = "<p style='margin-top:50px; width:350px;font: oblique 120% sans-serif bold;'>¿Esta Seguro que desea eliminar este transformador</p>"; 
                    }else{
                        ver.innerHTML = "<p style='margin-top:50px; width:390px;width:220px;font: oblique 120% sans-serif bold;'>¿Esta Seguro que desea eliminar este motor sin haberlo terminado?</p>";
                    }
             }

         },
         error: function (jqXHR, status) {
             alert("error buscar transformador");
         }
    });
    
}

function eliminartransformador(){
    jQuery.ajax({
         type: "PUT",
         url: servidor+"transformador/estado2", 
         dataType: "json",
         data: jsoneliminarestadotran(),
         success: function (data, status, jqXHR) {
             if(data.estado == 1){ 
                toastr.info('Se Ha Eliminado Este Transformador Correctamente');
                        setInterval(function(){location.reload();},2000);
             }
         },
         error: function (jqXHR, status) {
             alert("Error cambiar estado transformador");
         }
    });
}

function jsoneliminarestadotran(){    
    return JSON.stringify({
        "Id_tran":  idtrans              
    });
}