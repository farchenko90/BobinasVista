

/**
 * json de login
 * retorna 1 si es verdadero
 */
function jsonRegistroUser(){
    var user = document.getElementsByName("username")[0].value;
    var pass = document.getElementsByName("password")[0].value;

    return JSON.stringify({
                "Usuario": user,
                "Pass": pass
    });
}
/**
 * Jquery Servidor de login para iniciar sesion
 * si es 1 existe e inicia sesion
 */
function login(){
     jQuery.ajax({

        type: "POST",
        url: servidor+"usuario",
        dataType: "json",
        data: jsonRegistroUser(),

            success: function (data, status, jqXHR) {
                if(data == 1){
                     location.href = "menu_admin.php";
                }else{
                    alert("Error usuario o contraseña incorrecta");
                }
            },
            error: function (jqXHR, status) {
                alert("error ");
            }
      });
}
/**
 * JQuery Servidor consultar cuenta de perfil
 * trae un jsonObject de objetos
 */
function consultarcuenta(){
    
    var cedula = document.getElementsByName('ced')[0].value;
    jQuery.ajax({
         type: "GET",
         url: servidor+"usuario/"+cedula, 
         dataType: "json",
         success: function (data, status, jqXHR) {
             if(data!=null){
                 var img = document.getElementById("photo");
                for(var i=0;i < data.length; i++){
                    document.getElementsByName("nomb_admin")[0].value = data[i].Nom_usu;
                    document.getElementsByName("user_admin")[0].value = data[i].Usuario;
                    document.getElementsByName("mail_admin")[0].value = data[i].Email;
                    document.getElementsByName("pass_admin")[0].value = data[i].Pass;
                    document.getElementById("nomb_usua").innerHTML = data[i].Nom_usu;
                    document.getElementById("tipo").innerHTML = data[i].Nom_tp;
                    document.getElementsByName("foto_admin")[0].value = data[i].Foto;
                    if(data[i].Foto!=""){
                        img.innerHTML += "<img src='"+imgservidor+data[i].Foto+"' height='130px' width='120px' style='border-radius:90px; border: 4px solid #fff;'>"; 
                    }else{
                        var img1 = "img/fotos_perfil.jpg";
                        img.innerHTML += "<img src='"+imgservidor1+"' height='130px' style='border-radius:90px; border: 4px solid #fff;'>";
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
 * json de actualizar datos
 * enviamos por peticion de json
 */
function jsonUsuariomodificar(){
     return JSON.stringify({
        "Nom_usu": document.getElementsByName("nomb_admin")[0].value,
        "Usuario": document.getElementsByName("user_admin")[0].value,
        "Email":   document.getElementsByName("mail_admin")[0].value,
        "Pass":    document.getElementsByName("pass_admin")[0].value,
        "Foto":    document.getElementsByName("foto_admin")[0].value,
        "Id_usu":  document.getElementsByName("ced")[0].value
     });
}
/**
 * editar o actualizar cuenta 
 * obtiene true si lo guardo en la base de datos
 */
function editarcuenta(){
    toastr.options.positionClass = 'toast-top-center';
    jQuery.ajax({
         type: "PUT",
         url: servidor+"usuario", 
         dataType: "json",
         data: jsonUsuariomodificar(),
         success: function (data, status, jqXHR) {
             consultarcuenta();
             if(data.estado == 1){
                toastr.info('Se Ha Actualizado Este Usuario Correctamente');
                setInterval(function(){location.reload();},2000);
             }
         },
         error: function (jqXHR, status) {
             alert("Error editar cuenta");
         }
    });
}
/**
 * validacion de registro
 */
function explode(){
    location.reload();   
}

/**
 * Agregar usuario
 * obtiene true si lo guardo en la base de datos
 */
 
function agregarusuario(){
    toastr.options.positionClass = 'toast-top-center';
    if(document.getElementsByName("nomb_user")[0].value == "" || document.getElementsByName("apelli_user")[0].value == ""
        || document.getElementsByName("docu_user")[0].value == "" || document.getElementsByName("pass_user")[0].value == ""){
            toastr.warning('Los Campos Marcados Con * Son Obligatorios','Error');
    }else{
        if(document.getElementsByName("pass_user")[0].value == document.getElementsByName("pass_user1")[0].value){
            jQuery.ajax({
                 type: "POST",
                 url: servidor+"user", 
                 dataType: "json",
                 data: jsonUsuario(),
                 success: function (data, status, jqXHR) {
                     
                     if(data.estados == 1){ 
                        toastr.info('Se Ha Registrado Este Usuario Correctamente');
                        setInterval(function(){location.reload();},3000);
                     }
                 },
                 error: function (jqXHR, status) {
                    alert("Erro usuario");
                 }
            });    
        }else{
            toastr.warning('La Contraseñas no coinciden','Error');    
        }
    }
}
/**
 * Json de agregar usuario
 * returna 1 si es true
 */
var photo = "";
function jsonUsuario(){
    var nom_ape = document.getElementsByName("nomb_user")[0].value +" "+ document.getElementsByName("apelli_user")[0].value;
    var foto = document.getElementsByName("foto_admin1")[0].value;
        if(foto==""){
            photo = "fotos_perfil.jpg";
        }else{
            photo = foto;
        }
         return JSON.stringify({
            "Nom_usu":   nom_ape,
            "Usuario":   document.getElementsByName("docu_user")[0].value,
            "Cedula":    document.getElementsByName("docu_user")[0].value,
            "Telefono":  document.getElementsByName("tel_user")[0].value,
            "Email":     document.getElementsByName("email_user")[0].value,
            "Pass":      document.getElementsByName("pass_user")[0].value,
            "Foto":      photo, 
            "Id_tp_usu": document.getElementsByName("tipo_usuario")[0].value,
            
        });
    
}
/**
 * Servicio de consultar datos usario ventana modal ver usuario
 * obtiene un array de datos del json
 */
function verdatosusuario(ced){
    jQuery.ajax({
         type: "GET",
         url: servidor+"user/"+ced, 
         dataType: "json",
         success: function (data, status, jqXHR) {
             if(data!=null){
                 var img = document.getElementById("imgperfil");
                for(var i=0;i < data.length; i++){
                    document.getElementById("idnom").innerHTML = "<p style='font: oblique 115% sans-serif bold;'>"+data[i].Nom_usu+"</p>";
                    document.getElementById("idced").innerHTML = "<p style='font: oblique 115% sans-serif bold;'>"+data[i].Cedula+"</p>";
                    document.getElementById("idtel").innerHTML = "<p style='font: oblique 115% sans-serif bold;'>"+data[i].Telefono+"</p>";
                    document.getElementById("idema").innerHTML = "<p style='font: oblique 115% sans-serif bold; width:210px; margin-left:-30px;'>"+data[i].Email+"</p>";
                    document.getElementById("idtip").innerHTML = "<p style='font: oblique 115% sans-serif bold;'>"+data[i].Tipo+"</p>";
                    img.innerHTML = "<img src='"+imgservidor+data[i].Foto+"' height='140px' width='130px' style='border-radius:10px; border: 4px solid #fff;'>";
                }
                 
             }

         },
         error: function (jqXHR, status) {
             alert("error buscar user");
         }
    });
}
/**
 * Servicio de consultar datos usario ventana modal de eliminar ver usuario
 * obtiene un array de datos del json
 */
function verdatosusuarioeliminar(ced){
    jQuery.ajax({
         type: "GET",
         url: servidor+"user/"+ced, 
         dataType: "json",
         success: function (data, status, jqXHR) {
             if(data!=null){
                 var img = document.getElementById("imgperfil1");
                for(var i=0;i < data.length; i++){
                    document.getElementById("eliname").innerHTML = "<p style='font: oblique 115% sans-serif bold;'>"+data[i].Nom_usu+"</p>";
                    document.getElementById("oculta").value = data[i].Id_usu;
                    document.getElementById("eliced").innerHTML = "<p style='font: oblique 115% sans-serif bold;'>"+data[i].Cedula+"</p>";
                    document.getElementById("elitel").innerHTML = "<p style='font: oblique 115% sans-serif bold;'>"+data[i].Telefono+"</p>";
                    document.getElementById("eliemail").innerHTML = "<p style='font: oblique 115% sans-serif bold;'>"+data[i].Email+"</p>";
                    document.getElementById("elitipo").innerHTML = "<p style='font: oblique 115% sans-serif bold;'>"+data[i].Tipo+"</p>";
                    img.innerHTML = "<img src='"+imgservidor+data[i].Foto+"' height='140px' width='130px' style='border-radius:10px; border: 4px solid #fff;'>";
                }
                 
             }

         },
         error: function (jqXHR, status) {
             alert("error buscar user");
         }
    });
    
}
/**
 * Servicio de consultar datos usario ventana modal de motores
 * obtiene un array de datos del json
 */
function verResponsable(ced){
    jQuery.ajax({
         type: "GET",
         url: servidor+"user/"+ced, 
         dataType: "json",
         success: function (data, status, jqXHR) {
             if(data!=null){
                 
                for(var i=0;i < data.length; i++){
                    
                    document.getElementsByName("autorizado")[0].value = data[i].Nom_usu;
                    document.getElementsByName("autorizado1")[0].value = data[i].Nom_usu;
                }
                 
             }

         },
         error: function (jqXHR, status) {
             alert("error buscar user");
         }
    });
    
}
/**
 * modificar datos usuario del administrador
 * ventana modal de modificar
 */
function modiverdatosusuario(ced){
    cc = ced;
    jQuery.ajax({
         type: "GET",
         url: servidor+"user/"+ced, 
         dataType: "json",
         success: function (data, status, jqXHR) {
             if(data!=null){
                 var img = document.getElementById("editimg");
                for(var i=0;i < data.length; i++){
                    document.getElementById("editnom").value = data[i].Nom_usu;
                    document.getElementById("edittel").value = data[i].Telefono;
                    document.getElementById("editema").value = data[i].Email;
                    document.getElementById("editpas").value = data[i].Pass;
                    document.getElementById("editsel").value = data[i].Id_tipo;
                    //document.getElementById("idtip").innerHTML = data[i].Tipo;
                    //alert(data[i].Foto);
                    img.innerHTML = "<img style='margin-top:30px' src='"+imgservidor+data[i].Foto+"' height='140px' width='130px' style='border-radius:10px; border: 4px solid #fff;'>";
                }
                 
             }

         },
         error: function (jqXHR, status) {
             alert("error buscar user");
         }
    });
    
}
var cc;
/**
 * json de actualizar datos
 * enviamos por peticion de json
 */
function jsonUsuariomodificarperfil(){
    
     return JSON.stringify({
        "Nom_usu":   document.getElementById("editnom").value,
        "Email":     document.getElementById("editema").value,
        "Telefono":  document.getElementById("edittel").value,
        "Pass":      document.getElementById("editpas").value,
        "Id_tp_usu": document.getElementById("editsel").value,
        "Id_usu":    cc
     });
}
/**
 * editar o actualizar usuario de ventana modal de administrador 
 * obtiene true si lo guardo en la base de datos
 */
function editarperfil(){
    toastr.options.positionClass = 'toast-top-center';
    if(document.getElementById('editpas1').value == document.getElementById('editpas').value){
        jQuery.ajax({
             type: "PUT",
             url: servidor+"user", 
             dataType: "json",
             data: jsonUsuariomodificarperfil(),
             success: function (data, status, jqXHR) {
                 consultarcuenta();
                 //alert(data.estado);
                 var id = document.getElementById("alertamod");
                 if(data.estado == 1){
                    //alert("Se Ha Modificado Correctamente");
                    toastr.info('Se Ha Editado Este Usuario Correctamente');
                    setInterval(function(){location.reload();},3000);
                 }
             },
             error: function (jqXHR, status) {
                 //alert("Error editar cuenta");
             }
        });
    }else{
        toastr.warning('La Contraseñas no coinciden','Error');
    }
}
/**
 * cargamos los empleados motores o jefes de motores
 */
function cargarresponsableadministrador(){
    jQuery.ajax({
         type: "GET",
         url: servidor+"responsable", 
         dataType: "json",
         success: function (data, status, jqXHR) {
             //
             
             if(data!=null){
                 //var select1 = document.getElementsByName("respon1")[0];
                 var selec = document.getElementsByName("revicion2")[0]; 
                    for(var i=0;i < data.length; i++){

                        selec.innerHTML += "<option value='"+data[i].Id_usu+"'>"+data[i].Nom_usu+"</option>";
                        //select1.innerHTML += "<option value='"+data[i].Id_usu+"'>"+data[i].Nom_usu+"</option>";
                    }
                 
             }

         },
         error: function (jqXHR, status) {
             alert("error buscar user");
         }
    });
}
/**
 * cargamos los empleados motores o jefes de motores
 */
function cargarresponsabletrans(){
    jQuery.ajax({
         type: "GET",
         url: servidor+"encargadotra", 
         dataType: "json",
         success: function (data, status, jqXHR) {
             //
             
             if(data!=null){
                 //var responsable = document.getElementsByName("respo_trans");
                 var selec = document.getElementsByName("revicion2")[0]; 
                 var selec1 = document.getElementsByName("revicion3")[0]; 
                    for(var i=0;i < data.length; i++){
                        //responsable.value = data[i].Nom_usu;
                        selec.innerHTML += "<option value='"+data[i].Id_usu+"'>"+data[i].Nom_usu+"</option>";
                        selec1.innerHTML += "<option value='"+data[i].Id_usu+"'>"+data[i].Nom_usu+"</option>";
                    }
                 
             }

         },
         error: function (jqXHR, status) {
             alert("error buscar user");
         }
    });
}
/**
 * json de cambiar estado de inactivo
 * @returns {[[Type]]} [[Description]]
 */
function jsonUsuarioeditarinactivo(){
     return JSON.stringify({
        "Id_usu":  document.getElementById("oculta").value
     });
}
/**
 * Cambiamos el estado del usario a inactivo para sacarlo
 * de las tablas solo queda inactivo de ella
 */
function Editarestadoinactivo(){
    toastr.options.positionClass = 'toast-top-center';
    jQuery.ajax({
         type: "PUT",
         url: servidor+"cambiar", 
         dataType: "json",
         data: jsonUsuarioeditarinactivo(),
         success: function (data, status, jqXHR) {
             var id = document.getElementById("alertaeli");
             if(data == true){
                toastr.info('Se Ha Inactivado Este Usuario');
                setInterval(function(){location.reload();},3000);
             }
         },
         error: function (jqXHR, status) {
             //alert("Error editar cuenta");
         }
    });
}
/**
 * Servicio de consultar tipo de usuario en menu_admin_motores
 * obtiene un array de datos del json
 */
function verdatostipousuario(ced){
    jQuery.ajax({
         type: "GET",
         url: servidor+"user/"+ced, 
         dataType: "json",
         success: function (data, status, jqXHR) {
             if(data!=null){
                 var tipo = document.getElementById("tipouser");
                for(var i=0;i < data.length; i++){
                    tipo.innerHTML = data[i].Tipo+": " + data[i].Nom_usu;
                }
                 
             }

         },
         error: function (jqXHR, status) {
             alert("error buscar user");
         }
    });
}
/**
 * Servicio de consultar datos usario ventana modal de motores
 * obtiene un array de datos del json
 */
function CargarTrabajadorTrans(id){
    
    jQuery.ajax({
         type: "GET",
         url: servidor+"encargadotra/"+id, 
         dataType: "json",
         success: function (data, status, jqXHR) {
             if(data!=null){
                 
                for(var i=0;i < data.length; i++){
                    document.getElementsByName("resposable")[0].value = data[i].Nom_usu;
                    document.getElementsByName("resposable1")[0].value = data[i].Nom_usu;
                    
                }
                 
             }

         },
         error: function (jqXHR, status) {
             alert("error buscar user");
         }
    });
    
}