
function explode(){
    location.reload();   
}
/* json de registrar cliente
 * 
 */
var photo = "";
function jsonregistrarmotor(){    
    
    if(NomImg1==""){
        photo = "motor.jpg";
    }else{
        photo = NomImg1;
    }
    return JSON.stringify({
        "Num_serie_motor":  document.getElementsByName("numserie")[0].value,
        "Marca":            document.getElementsByName("marca")[0].value,
        "Hp":               document.getElementsByName("hp")[0].value,
        "Kw":               document.getElementsByName("kw")[0].value,
        "Rpm":              document.getElementsByName("rpm")[0].value,
        "N_fases":          document.getElementsByName("fases")[0].value,
        "Accion":           document.getElementsByName("tpentrada")[0].value,
        "revicion":         document.getElementsByName("revicion")[0].value,
        "Cotizado":         document.getElementsByName("cotizado")[0].value,
        "Autorizado":       document.getElementsByName("autorizado")[0].value,
        "Fe_acord":         document.getElementById("feentrega").value,
        "Fe_term":          document.getElementById("feterminacion").value,
        "Id_usu":           document.getElementsByName("revicion2")[0].value,
        "Id_cliente":       id_cliente,
        "Foto":             photo
    });
}
/**
 * registra cliente del motor
 * 
 */

function registrarMotor(){
    //alert(fechaactual);
    toastr.options.positionClass = 'toast-top-center';
    //var id = document.getElementById("alerta");
    //alert(jsonregistrarmotor());
    jQuery.ajax({
         type: "POST",
         url: servidor+"motor", 
         dataType: "json",
         data: jsonregistrarmotor(),
         success: function (data, status, jqXHR) {
             if(data.estados == 1){
                 //registrarcliente();
                toastr.info('Se Ha Registrado Este Motor Correctamente');
                setInterval(function(){location.reload();},2000);
             }
         },
         error: function (jqXHR, status) {
             alert("Error registrar motor ");
         }
    });
    
        
    
}
/**
 * Ver tipo de accion si es rebobinado o mantenimiento
 * si esta terminado inhabilitamos los campos 
 */
function VerManteRebo(id){
    jQuery.ajax({
         type: "GET",
         url: servidor+"motor/"+id, 
         dataType: "json",
         success: function (data, status, jqXHR) {
             if(data!=null){
                 var img = document.getElementById("imgperfil");
                 var boton1 = document.getElementById('modificarboton');
                 var boton = document.getElementById('modificarboton1');
                for(var i=0;i < data.length; i++){
                    //document.getElementById("accion").innerHTML = data[i].Num_serie_motor;
                    
                    if(data[i].Accion=="Rebobinado"){
                        //boton1.style.display = 'none';
                        Responsable2(id);
                        var div = document.getElementById("mantenimineto");
                        div.innerHTML = "<div hidden='hidden' style='display:none;'></div>";
                        var est2 = document.getElementById("estado2");
                        est2.style.backgroundColor = "#A52626";
                        est2.innerHTML = ""+data[i].Estado+"";
                        if(data[i].Estado=="Terminado"){
                            verestadomotorrebobinado(id);
                            est2.style.backgroundColor = "#26A549";
                        }
                    }
                    if(data[i].Accion=="Mantenimiento"){
                        //verestadomotormantenimiento(id);
                        //boton.style.display = 'none';
                        Responsable1(id);
                        var est = document.getElementById("estado");
                        est.innerHTML = ""+data[i].Estado+"";
                        est.style.backgroundColor = "#A52626";
                        var div1 = document.getElementById("monofacico");
                        div1.innerHTML = "<div hidden='hidden' style='display:none;'></div>";
                        if(data[i].Estado=="Terminado"){
                            verestadomotormantenimiento(id);
                            est.style.backgroundColor = "#26A549";
                        }
                    }
                }
                 
             }

         },
         error: function (jqXHR, status) {
             alert("error buscar user");
         }
    });
    
}
/**
 * Ver datos del motor en modal
 */
function Verdatosmotor(id){
    jQuery.ajax({
         type: "GET",
         url: servidor+"motores/"+id, 
         dataType: "json",
         success: function (data, status, jqXHR) {
             if(data!=null){
                 var img = document.getElementById("photo");
                 var cli = document.getElementsByName("cliente")[0];
                 var dir = document.getElementsByName("direccion")[0];
                 var ciu = document.getElementsByName("ciudad")[0];
                 var tel = document.getElementsByName("tele")[0];
                 var fe_ingr = document.getElementsByName("fingre")[0];
                 var nit = document.getElementsByName("nit")[0];
                 var marca = document.getElementsByName("marca")[0];
                 var hp = document.getElementsByName("hp")[0];
                 var kw = document.getElementsByName("kw")[0];
                 var rpm = document.getElementsByName("rpm")[0];
                 var fase = document.getElementsByName("fase")[0];
                 var tp = document.getElementsByName("tp")[0];
                 var rev = document.getElementsByName("revicion")[0];
                 var cot = document.getElementsByName("cotizado")[0];
                 var aut = document.getElementsByName("autorizado")[0];
                 var facor = document.getElementsByName("facor")[0];
                 var ftermi = document.getElementsByName("ftermi")[0];
                 var admin = document.getElementsByName("admin")[0];
                 
                for(var i=0;i < data.length; i++){
                    cli.innerHTML = "<p style='font: oblique 115% sans-serif bold;'>"+data[i].Cliente+"</p>";
                    dir.innerHTML = "<p style='font: oblique 115% sans-serif bold;'>"+data[i].Direccion+"</p>";
                    ciu.innerHTML = "<p style='font: oblique 115% sans-serif bold;'>"+data[i].Ciudad+"</p>";
                    tel.innerHTML = "<p style='font: oblique 115% sans-serif bold;'>"+data[i].Telefono+"</p>";
                    fe_ingr.innerHTML = "<p style='font: oblique 115% sans-serif bold;'>"+data[i].Fecha_ing+"</p>";
                    nit.innerHTML = "<p style='font: oblique 115% sans-serif bold;'>"+data[i].Id_cliente+"</p>";
                     marca.innerHTML = "<p style='font: oblique 115% sans-serif bold;'>"+data[i].Marca+"</p>";
                     hp.innerHTML = "<p style='font: oblique 115% sans-serif bold;'>"+data[i].Hp+"</p>";
                    kw.innerHTML = "<p style='font: oblique 115% sans-serif bold;'>"+data[i].Kw+"</p>";
                    rpm.innerHTML = "<p style='font: oblique 115% sans-serif bold;'>"+data[i].Rpm+"</p>";
                    fase.innerHTML = "<p style='font: oblique 115% sans-serif bold;'>"+data[i].Fases+"</p>";
                    tp.innerHTML = "<p style='font: oblique 115% sans-serif bold;'>"+data[i].Accion+"</p>";
                    rev.innerHTML = "<p style='font: oblique 115% sans-serif bold;'>"+data[i].Revicion+"</p>";
                    cot.innerHTML = "<p style='font: oblique 115% sans-serif bold;'>"+data[i].Cotizado+"</p>";
                    aut.innerHTML = "<p style='font: oblique 115% sans-serif bold;'>"+data[i].Autorizado+"</p>";
                    facor.innerHTML = "<p style='font: oblique 115% sans-serif bold;'>"+data[i].Fe_acord+"</p>";
                    ftermi.innerHTML = "<p style='font: oblique 115% sans-serif bold;'>"+data[i].Fe_acord+"</p>";
                    admin.innerHTML = "<p style='font: oblique 115% sans-serif bold;'>"+data[i].Nom_usu+"</p>";
                    if(data[i].Foto!=""){
                        img.innerHTML += "<img src='"+imgservidor2+data[i].Foto+"' height='130px' width='120px' style='border-radius:90px; border: 4px solid #fff;'/>";
                    }else{
                        img.innerHTML += "<img src='"+imgservidor3+"' height='130px' style='border-radius:90px; border: 4px solid #fff;'>";
                    }
                }
                 
             }

         },
         error: function (jqXHR, status) {
             alert("error buscar user");
         }
    });
}
/**
 * Ver dato del responsable2 
 */
function Responsable2(id){
    jQuery.ajax({
         type: "GET",
         url: servidor+"motores/"+id, 
         dataType: "json",
         success: function (data, status, jqXHR) {
             if(data!=null){
                 
                for(var i=0;i < data.length; i++){
                    document.getElementsByName("res")[0].value = data[i].Nom_usu; 
                    document.getElementsByName("ce1")[0].value = data[i].Id_usu;
                    
                }
                 
             }

         },
         error: function (jqXHR, status) {
             alert("error buscar user");
         }
    });
}
/**
 * Ver dato del responsable1 
 */
function Responsable1(id){
    jQuery.ajax({
         type: "GET",
         url: servidor+"motores/"+id, 
         dataType: "json",
         success: function (data, status, jqXHR) {
             if(data!=null){
                 
                for(var i=0;i < data.length; i++){
                    document.getElementsByName("c1")[0].value = data[i].Id_usu; 
                    document.getElementsByName("r1")[0].value = data[i].Nom_usu;
                    
                }
                 
             }

         },
         error: function (jqXHR, status) {
             alert("error buscar user");
         }
    });
}
/**
 * Ver datos del editar motor en modal
 */
 var idusuariomotor;
function Verdatoseditamotor(id){
    jQuery.ajax({
         type: "GET",
         url: servidor+"motores/"+id, 
         dataType: "json",
         success: function (data, status, jqXHR) {
             if(data!=null){
                 
                for(var i=0;i < data.length; i++){
                    //alert(data[i].Id_usu)
                    idusuariomotor = data[i].Id_usu;
                    document.getElementsByName("ncliente")[0].value = data[i].Cliente;
                    document.getElementsByName("napelli")[0].value = data[i].Apellido;
                    document.getElementsByName("dir")[0].value = data[i].Direccion;
                    document.getElementsByName("city")[0].value = data[i].Ciudad;
                    document.getElementsByName("tel")[0].value = data[i].Telefono;
                    document.getElementsByName("fecha_ing")[0].value = data[i].Fecha_ing;
                    document.getElementsByName("ns")[0].value = data[i].Id_cliente;
                    document.getElementsByName("marc")[0].value = data[i].Marca;
                    document.getElementsByName("hp1")[0].value = data[i].Hp;
                    document.getElementsByName("kw1")[0].value = data[i].Kw;
                    document.getElementsByName("rpm1")[0].value = data[i].Rpm;
                    document.getElementsByName("fase1")[0].value = data[i].Fases;
                    document.getElementsByName("coti")[0].value = data[i].Cotizado;
                    document.getElementsByName("autor")[0].value = data[i].Autorizado;
                    document.getElementsByName("fentrega")[0].value = data[i].Fe_acord;
                    document.getElementsByName("fterminacion")[0].value = data[i].Fe_acord;
                    document.getElementsByName("respons")[0].value = data[i].Nom_usu;
                    document.getElementsByName("entrada")[0].value = data[i].Accion; 
                    //document.getElementsByName("revicion4")[0].value = data[i].Id_usu;
                    document.getElementsByName("foto_admin")[0].value = data[i].Foto; 
                }
                 
             }

         },
         error: function (jqXHR, status) {
             alert("error buscar user");
         }
    });
}
/**
 * json de actualizar datos
 * enviamos por peticion de json
 */
function jsonmodificarmotores(){    
    return JSON.stringify({
        "Marca":            document.getElementsByName("marc")[0].value,
        "Hp":               document.getElementsByName("hp1")[0].value,
        "Kw":               document.getElementsByName("kw1")[0].value,
        "Rpm":              document.getElementsByName("rpm1")[0].value,
        "N_fases":          document.getElementsByName("fase1")[0].value,
        "Accion":           document.getElementsByName("entrada")[0].value,
        "revicion":         document.getElementsByName("tprev")[0].value,
        "Cotizado":         document.getElementsByName("coti")[0].value,
        "Autorizado":       document.getElementsByName("autor")[0].value,
        "Fe_acord":         document.getElementsByName("fentrega")[0].value,
        "Fe_term":          document.getElementsByName("fterminacion")[0].value,
        "Foto":             document.getElementsByName("foto_admin")[0].value,
        "Id_motores":       geturl,
        "Id_usu":           document.getElementsByName("revicion4")[0].value            
    });
}
/**
 * modificamos los datos del motor
 * 
 */
function Actualizadatosmotor(id){
    //alert(jsonmodificarmotores());
    jQuery.ajax({
         type: "PUT",
         url: servidor+"motor", 
         dataType: "json",
         data: jsonmodificarmotores(),
         success: function (data, status, jqXHR) {
             //consultarcuenta();
             if(data.estados == 1){
                 //modificarcliente();
                toastr.info('Se Ha Modificado Correctamente');
                setInterval(function(){location.reload();},2000);
             }
         },
         error: function (jqXHR, status) {
             alert("Error editar motor");
         }
    });
}
/**
 * vemos los datos del motor en un modal
 * @param {[[Type]]} id [[Description]]
 */
function verdatosmotorjson(id){
    jQuery.ajax({
         type: "GET",
         url: servidor+"vermotor/"+id, 
         dataType: "json",
         success: function (data, status, jqXHR) {
             if(data!=null){
                 var ver = document.getElementById("mostrar");
                 for(var i=0;i < data.length; i++){
                    if(data[i].Estado=="Sin Terminar"){
                        ver.innerHTML = "<p style='margin-top:50px; width:350px;font: oblique 120% sans-serif bold;'>¿Esta Seguro que desea eliminar este motor sin haberlo terminado?</p>";    
                    } else{
                        ver.innerHTML = "<p style='margin-top:50px; width:390px;width:220px;font: oblique 120% sans-serif bold;'>¿Esta Seguro que desea eliminar este motor?</p>";
                    }
                    document.getElementById("vercliente").innerHTML = data[i].Cliente;
                    document.getElementById("vermarca").innerHTML = data[i].Marca;
                    document.getElementById("verserie").innerHTML = data[i].Num_serie;
                    document.getElementById("verestado").innerHTML = data[i].Estado;
                    document.getElementById("verentrada").innerHTML = data[i].Accion;
                }
                 
             }

         },
         error: function (jqXHR, status) {
             alert("error buscar user");
         }
    });
}
/**
 * json de eliminarmotor
 */
function jsoneliminarmotor(){
    return JSON.stringify({
        "Id_motores":      idmotor 
    });
}
/**
 * cambiar estado del motor y mandarlo al historial
 */
function eliminarmotor(){
    toastr.options.positionClass = 'toast-top-center';
    jQuery.ajax({
         type: "PUT",
         url: servidor+"elimotor", 
         dataType: "json",
         data: jsoneliminarmotor(),
         success: function (data, status, jqXHR) {
             //consultarcuenta();
             if(data.estado == 1){
                toastr.info('Se Ha Eliminado Este Motor Correctamente');
                        setInterval(function(){location.reload();},2000);
                 
             }
         },
         error: function (jqXHR, status) {
             alert("Error eliminar motor");
         }
    });
}