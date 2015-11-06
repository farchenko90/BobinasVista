/*
*   Guardar chat del cliente al usuario
*/
function guardarchatcli(){
    //alert(jsonChat1());
    if(document.getElementById('message').value==""){

    }else{
        jQuery.ajax({
            type: "POST",
            url: servidor+"chat", 
            dataType: "json",
            data: jsonChat1(),
            success: function (data, status, jqXHR) {
                if(data.estado == 1){ 
                    toastr.info('Has Enviado Este Mensaje  ');
                    //setInterval(function(){location.reload();},1000);
                    verMensaje(geturl, idcli);
                    guardarimagenservidor();
                    document.getElementById('message').value = "";
                }
            },
            error: function (jqXHR, status) {
                alert("Erro chat1");
            }
        });
    }
}

function jsonChat1(){
    if(arch == 'Archivo'){
        return JSON.stringify({
            "mensaje":      document.getElementById('message').value,
            "idusu":        geturl,
            "idcli":        idcli,
            "nomusuario":   nom_usu,
            "archivo":      arch
        });
    }else{
        return JSON.stringify({
            "mensaje":      document.getElementById('message').value,
            "idusu":        geturl,
            "idcli":        idcli,
            "nomusuario":   nom_usu,
            "archivo":      "null"
        });
    }
    
}

/*
*   Guarda archivo al servidor
*/

function guardarimagenservidor(){
    //información del formulario
    //document.getElementById('message').value = "";
        var formData = new FormData($(".formulario")[0]);
        var message = ""; 
        //hacemos la petición ajax  
        $.ajax({
            url: servidor+'uploadArchivos.php',  
            type: 'POST',
            // Form data
            //datos del formulario
            data: formData,
            //necesario para subir archivos via ajax
            cache: false,
            contentType: false,
            processData: false,
            //mientras enviamos el archivo
            beforeSend: function(){
                //message = $("<span class='before'>Subiendo la imagen, por favor espere...</span>");
                showMessage(message) 
                //alert(message)       
            },
            //una vez finalizado correctamente
            success: function(data){
                //message = $("<span class='success'>La imagen ha subido correctamente.</span>");
                showMessage(message);
                if(isImage(fileExtension))
                {
                    //$(".showImage").html("<img src='files/"+data+"' />");
                }
            },
            //si ha ocurrido un error
            error: function(){
                message = $("<span class='error'>Ha ocurrido un error.</span>");
                showMessage(message);
            }
        });
        //location.reload();
}

/*
*   Guardar Chat del usuario al cliente
*/
function guardarchat(){
    //alert(jsonChat())
    if(document.getElementById('message').value==""){

    }else{
        jQuery.ajax({
            type: "POST",
            url: servidor+"chat", 
            dataType: "json",
            data: jsonChat(),
            success: function (data, status, jqXHR) {
                if(data.estado == 1){ 
                    toastr.info('Has Enviado Este Mensaje  ');
                    //setInterval(function(){location.reload();},1000);
                    verMensaje(ced, geturl);
                    guardarimagenservidor();
                    document.getElementById('message').value = "";
                    //setInterval(function(){location.reload()},2000);
                }
            },
            error: function (jqXHR, status) {
                alert("Erro chat");
            }
        });
    }
	
}

function jsonChat(){
    if(arch == 'Archivo'){
        return JSON.stringify({
            "mensaje":      document.getElementById('message').value,
            "idusu":        ced,
            "idcli":        geturl,
            "nomusuario":   nom_usu,
            "archivo":      arch
        });
    }else{
        return JSON.stringify({
            "mensaje":      document.getElementById('message').value,
            "idusu":        ced,
            "idcli":        geturl,
            "nomusuario":   nom_usu,
            "archivo":      "null"
        });
    }
	
}
var nom_usu;
var idcli;
function verdatostipousuario(ced){
    //alert(ced)
	jQuery.ajax({
         type: "GET",
         url: servidor+"user/"+ced, 
         dataType: "json",
         success: function (data, status, jqXHR) {
             if(data!=null){
                var user = document.getElementById('username');
                for(var i=0;i < data.length; i++){
                    //alert(data[i].Nom_usu);

                	user.innerHTML = "<label for='user'>Usuario: "+data[i].Nom_usu+"</label>"+
                                    "<img src='"+imgservidor+data[i].Foto+"' height='50px' width='60px' style='border-radius:90px; border: 4px solid #fff; margin-left: 60%'>"; 

                    nom_usu = data[i].Nom_usu;
                    idcli = data[i].Id_cli;
                }
                 
             }

         },
         error: function (jqXHR, status) {
             //alert("error buscar user");
         }
    });
}

function verdatostipocliente(ced){
    //alert(ced)
    jQuery.ajax({
         type: "GET",
         url: servidor+"user/cliente/"+ced, 
         dataType: "json",
         success: function (data, status, jqXHR) {
             if(data!=null){
                var user = document.getElementById('username');
                for(var i=0;i < data.length; i++){
                    //alert(data[i].Nom_usu);
                    user.innerHTML = "<label for='user'>Usuario: "+data[i].Nom_usu+"</label>"; 

                }
                 
             }

         },
         error: function (jqXHR, status) {
             //alert("error buscar user");
         }
    });
}
/*
*   Ver mensaje del cliente al usuario
*/
var verMensaje = function(idusu,idcli){
    //alert(idusu+" "+idcli);
	jQuery.ajax({
         type: "GET",
         url: servidor+"chat/"+idusu+"/"+idcli, 
         dataType: "json",
         success: function (data, status, jqXHR) {
             if(data!=null){
                var mensaje = document.getElementById('conversation');
                mensaje.innerHTML = "";
                for(var i=0;i < data.length; i++){
                    if(data[i].archivo=='Archivo'){
                        if(i+1 >= data.length){
                        mensaje.innerHTML += "<p style='background-color:lightgreen;padding-botton:20px size=12px'>"+data[i].usuario+": <a href='"+servidor+"files/"+data[i].mensaje+"' target='_blank'>"+data[i].mensaje+"</a><p style='margin-top: -3%;margin-left: 75%'>"+data[i].fecha+" "+data[i].hora+" "+data[i].estado+"</p></p>"
                               "<p style='margin-left: 70%;margin-top: -3%'>"+data[i].fecha+" "+data[i].hora+"   "+data[i].estado+"</p>";
                        var alt = document.getElementById('conversation').scrollHeight;       
                        mensaje.scrollTop = alt;
                        
                        }else{
                            mensaje.innerHTML += "<p style='padding-botton:20px size=12px'>"+data[i].usuario+": <a href='"+servidor+"files/"+data[i].mensaje+"' target='_blank'>"+data[i].mensaje+"</a>"
                                   "</p>";
                        }
                    }else{
                        if(i+1 >= data.length){
                        mensaje.innerHTML += "<p style='background-color:lightgreen;padding-botton:20px size=12px'>"+data[i].usuario+": "+data[i].mensaje+"  <p style='margin-top: -3%;margin-left: 75%'>"+data[i].fecha+" "+data[i].hora+" "+data[i].estado+"</p></p>"
                               "<p style='margin-left: 70%;margin-top: -2%'>"+data[i].fecha+" "+data[i].hora+"   "+data[i].estado+"</p>";
                        var alt = document.getElementById('conversation').scrollHeight;       
                        mensaje.scrollTop = alt;
                        
                        }else{
                            mensaje.innerHTML += "<p style='padding-botton:20px size=12px'>"+data[i].usuario+": "+data[i].mensaje+""
                                   "</p><p>"+data[i].fecha+"</p>";
                        }
                    }
                    
                                    
                }
                 //setInterval(function(){location.reload();},1000);
             }

         },
         error: function (jqXHR, status) {
             //alert("error buscar user");
         }
    });
}

var verMensajecliente = function(idcli,idusu){
    //alert(idcli+" "+idusu);
    jQuery.ajax({
         type: "GET",
         url: servidor+"chatcliente/"+idcli+"/"+idusu, 
         dataType: "json",
         success: function (data, status, jqXHR) {
             if(data!=null){
                var mensaje = document.getElementById('conversation');
                mensaje.innerHTML = "";
                for(var i=0;i < data.length; i++){
                    
                    if(i+1 >= data.length){
                        mensaje.innerHTML += "<p style='background-color:lightgreen;padding-botton:20px size=12px'>"+data[i].mensaje+
                               "</p>";

                    }else{
                        mensaje.innerHTML += "<p style='padding-botton:20px size=12px'>"+data[i].mensaje+
                               "</p>";
                    }
                                    
                }
                 //setInterval(function(){location.reload();},1000);
             }

         },
         error: function (jqXHR, status) {
             alert("error buscar user");
         }
    });
}

