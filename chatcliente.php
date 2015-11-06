<?php 
     session_start();
if(isset($_SESSION['id'])){
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat del Valle</title>
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/sb-admin.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/toastr.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    
    <script src="js/jquery-1.11.0.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/toastr.min.js"></script>
    <script src="Jsserver/ChatServer.js" type="text/javascript"></script>
    <script src="Jsserver/Server.js" type="text/javascript"></script>
    
    <style>.titu_menu{float: right; margin-top:0px; border-bottom: 1px dashed #fff;}
    #myModalLabel{text-shadow: 0px 1px 0px #080808;
      opacity: .9;
      color: #FEFEFE;
      font-weight: 700;}

    .btn-file {
      position: relative;
      overflow: hidden;
    }
    .btn-file input[type=file] {
      position: absolute;
      top: 0;
      right: 0;
      min-width: 100%;
      min-height: 100%;
      font-size: 100px;
      text-align: right;
      filter: alpha(opacity=0);
      opacity: 0;
      background: red;
      cursor: inherit;
      display: block;
    }
    input[readonly] {
      background-color: white !important;
      cursor: text !important;
    }


    </style>
    

    <script type="text/javascript">


    function getGET()
    {
        // capturamos la url
        var loc = document.location.href;
        var get = null;

        // si existe el interrogante
        if(loc.indexOf('?')>0)
        {
            // cogemos la parte de la url que hay despues del interrogante
            var getString = loc.split('?')[1];
            
            // obtenemos un array con cada clave=valor
            var GET = getString.split('&');
            
            get = {};

            // recorremos todo el array de valores
            for(var i = 0, l = GET.length; i < l; i++){
                var tmp = GET[i].split('=');
                get[tmp[0]] = unescape(decodeURI(tmp[1]));
            }
        }
        return get;
    }

    var geturl;
    var ced;
    var clienteid;
    var nomusu;
    var men;
    var arch;
    $(document).ready(function(){

      $(':file').change(function()
      {
          men = document.getElementById('message');
          //obtenemos un array con los datos del archivo
          var file = $("#imagen")[0].files[0];
          //obtenemos el nombre del archivo
          var fileName = file.name;
          //obtenemos la extensión del archivo
          fileExtension = fileName.substring(fileName.lastIndexOf('.') + 1);
          //obtenemos el tamaño del archivo
          var fileSize = file.size;
          //obtenemos el tipo de archivo image/png ejemplo
          var fileType = file.type;
          //mensaje con la información del archivo
          //showMessage("<span class='info'>Archivo para subir: "+fileName+", peso total: "+fileSize+" bytes.</span>");
          men.innerHTML = fileName;
          arch = "Archivo";
      });


      var id = getGET();
      geturl = id['id'];
      ced = document.getElementsByName('ced')[0].value;
        
      //verdatostipocliente(geturl);
      cliente(geturl);
      verdatostipousuario(ced);
      //usuariochat(geturl);
      verMensaje(ced,geturl);

      
      //$.ajaxSetup({ cache: false });
      setInterval("verMensaje(ced,geturl)",3000);//este es de cliente a usuario
      //setInterval("verMensajecliente(ced,geturl)",1000);//este es de usuario a cliente
      //verMensaje(ced, geturl);
      setInterval("cambiarEstadoVisto(ced,geturl)",10000);

    });

    function showMessage(message){
        $(".messages").html("").show();
        $(".messages").html(message);
    }
 
//comprobamos si el archivo a subir es una imagen
//para visualizarla una vez haya subido
    function isImage(extension)
    {
        switch(extension.toLowerCase()) 
        {
            case 'jpg': case 'gif': case 'png': case 'jpeg':
                return true;
            break;
            default:
                return false;
            break;
        }
    }

    function jsonestadovisto(){    
      return JSON.stringify({
          "nomusuario":     nomusu
      });
    }

    function cambiarEstadoVisto(idusu,idcli){
      //alert(jsonestadovisto()+" "+idusu+" "+idcli);
      jQuery.ajax({
         type: "PUT",
         url: servidor+"estado/"+idusu+"/"+idcli, 
         dataType: "json",
         data: jsonestadovisto(),
         success: function (data, status, jqXHR) {
             if(data.estado == 1){
                //alert("Se Ha Modificado Correctamente");
             }
         },
         error: function (jqXHR, status) {
             alert("Error cambiar estado visto");
         }
      });
    }

    
    
    function cliente(id){
      jQuery.ajax({
           type: "GET",
           url: servidor+"user/chatcli/"+id, 
           dataType: "json",
           success: function (data, status, jqXHR) {

               if(data!=null){
                  //alert(data.Nom_usu);
                  document.getElementById('userid').value = "Destinatario: "+data.Nom_usu;
                  //nom_usu = data.Nom_usu;
                  nomusu = data.Nom_usu;
                  cambiarEstadoVisto(ced,geturl);
               }
               //setInterval("verMensaje(ced,geturl)",1000);
           },
           error: function (jqXHR, status) {
               alert("error buscar user sd");
           }
      });
    }


    function vaciarchat(){
      //alert(ced+" "+nom_usu);
      jQuery.ajax({
         type: "DELETE",
         url: servidor+"chat/eliminar/"+ced+"/"+nom_usu,
         dataType: "json",
         success: function (data, status, jqXHR) {
             if(data.estado == 1){
                 //alert("exito")
                 //verMensaje(ced,geturl);
             }
         },
         error: function (jqXHR, status) {
            //alert("Error al vaciar chat")
         }
    });
  }
    


    </script>
    
</head>

<body>

    <div id="wrapper">
<div style="background-color: #d66e2b;height: 10px;border-bottom: solid 1px #B35D25;"></div>
<br>
  <?php 
    if($_SESSION['rol']=="Cliente"){
      echo "<input type='hidden' name='ced' value='".$_SESSION['id']."'";
    
    
  ?>
  <div  class="container-fluid">
      <section  style="padding: 15%;margin-top: -12%">      
        <div class="row">       
          <h1 class="text-center"><img src="logo.png" alt="">Chat: <small>Bobinados Del Valle</small></h1> 
          <hr>
        </div>  
        <div class="row">
          <!--<form id="formChat" role="form" method="post">-->
            <div class="form-group" id="username">
              <!--<label for="user">User</label>-->
            </div>
            <input type="text" class="form-control" id="userid" name="user" placeholder="Enter User" disabled>
            </br>
            <div class="form-group">              
              <div class="row">
                <div class="col-md-12" >
                  <div id="conversation" style="height:200px; border: 1px solid #CCCCCC; padding: 12px;  border-radius: 5px; overflow-x: hidden;">
                    
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">        
              <label for="message">Mensaje</label>
              <textarea id="message" name="message" placeholder="Enter Message"  class="form-control" rows="3"></textarea>
            </div>
            <button id="send" class="btn btn-primary" onclick="javascript:guardarchatcli()">Enviar</button>            
          <!--</form>-->
        </div>
      </section>  
    </div>
    <?php 

      }else{
        echo "<input type='hidden' name='ced' value='".$_SESSION['id']."'";
      
    ?>

      <div  class="container-fluid">
      <section  style="padding: 15%;margin-top: -12%">      
        <div class="row">       
          <div class="col-xs-12 col-md-8">
            <h1 class="text-center" style="margin-left: 20%"><img src="logo.png" height='70px' style="margin:auto; max-width: 100%;">Chat: <small>Bobinados Del Valle</small></h1> 
            <hr>
            <div class="btn-group open" style="margin-top: -28%; margin-left: 0%">
              <a class="btn btn-primary" href="#"><i class="fa fa-user fa-fw"></i> Opciones</a>
              <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
                <span class="fa fa-caret-down"></span></a>
              <ul class="dropdown-menu">
                <li><a href="" onclick="javascript:vaciarchat()"><i class="fa fa-trash-o fa-fw"></i> Vaciar Chat</a></li>
                <li><a href="" onclick="javascript:window.close();"><i class="fa fa-ban fa-fw"></i> Salir</a></li>
                <li class="divider"></li>
                <li><a href="#"><i class="i"></i> Opciones Del chat</a></li>
              </ul>
            </div>
          </div>
        </div>  
        <div class="row">
            <div class="form-group" id="username">
              <!--<label for="user">User</label>-->
            </div>
            <input type="text" class="form-control" id="userid" name="user" placeholder="Enter User" disabled>
            </br>
            <div class="form-group">              
              <div class="row">
                <div class="col-md-12" >
                  <div id="conversation" style="height:200px; border: 1px solid #CCCCCC; padding: 12px;  border-radius: 5px; overflow-x: hidden;">
                    
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">        
              <label for="message">Mensaje</label>
              <textarea id="message" name="message" placeholder="Enter Message"  class="form-control" rows="3"></textarea>
            </div>
              <div class="row">
                <form enctype="multipart/form-data" class="formulario">
                  <div class="col-xs-6 col-md-4">
                    <input class="btn btn-primary" type="button" value="Enviar" onclick="javascript:guardarchat()">
                    <span class="file-input btn btn-primary btn-file">
                      Browse.. <input name="archivo" type="file" id="imagen">
                    </span>
                  </div>
                </form>
              </div>
            <!--<button id="send" class="btn btn-primary" onclick="javascript:guardarchat()">Enviar</button>-->
            
        </div>
      </section>  
    </div>

    <?php } ?>

</div>
    <!-- /#wrapper -->

    <!-- Core Scripts - Include with every page -->
    
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>

    <!-- Page-Level Plugin Scripts - Tables -->
    <script src="js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>

    <!-- SB Admin Scripts - Include with every page -->
    <!--<script src="js/sb-admin.js"></script>-->

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    
    <script>
    
      /*$(document).on("ready", function(){       
        registrarmensaje();  
      });
      
      var registrarmensaje = function(){
        $("send").on("click",function(e){
          e.preventDefault();
          var frm = $("#formChat").serialize();
            
        });
      }*/

    </script>

</body>

</html>
<?php }else{ ?>
<script>location.href = "inicio_sesion.php";</script>
<?php } ?>
