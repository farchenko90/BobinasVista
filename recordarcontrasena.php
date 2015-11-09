<?php 
    session_start();
if(!isset($_SESSION['id'])){
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bobinados del Valle</title>
    <link href="dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/toastr.css">

    <script src="js/jquery-1.11.0.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/toastr.min.js"></script>
    <script src="Jsserver/Server.js" type="text/javascript"></script>
    <script src="Jsserver/UsuarioServer.js" type="text/javascript"></script>
    

    <script>

    var cc;
    var nom;
      var validarcorreoeditar = function(){
        var correo = document.getElementsByName('usernamereco')[0].value;
        jQuery.ajax({
         type: "GET",
         url: servidor+"usuario/correo/"+correo, 
         dataType: "json",
         success: function (data, status, jqXHR) {
             if(data!=null){
                //toastr.error(data.Nombre);
                cc = data.Id;
                nom = data.Nombre;
                updatecontraseña();
             }else{
                toastr.error("Este correo no se encuentra registrado");
             }

         },
         error: function (jqXHR, status) {
             //alert("error buscar user");
         }
        });
      }

      function jsonupdatepass(){    
        return JSON.stringify({
            "Pass":    document.getElementsByName('passwordreco')[0].value,
            "Id_usu":  cc,
            "Email":   document.getElementsByName('usernamereco')[0].value,
            "Nom_usu": nom
        });
      }

      var updatecontraseña = function (){
        if(document.getElementsByName('passwordreco')[0].value == document.getElementsByName('passwordreco1')[0].value){
            jQuery.ajax({
               type: "PUT",
               url: servidor+"usuario/cambiarpass", 
               dataType: "json",
               data: jsonupdatepass(),
               success: function (data, status, jqXHR) {
                   //consultarcuenta();
                   if(data.estado == 1){
                       toastr.info("Has modificado tu contraseña");
                       setInterval(function(){location.reload();},2000);
                   }
               },
               error: function (jqXHR, status) {
                   alert("Error editar cliete");
               }
            });
        }else{
          toastr.error("Error las contraseñas no coinciden");
        }
      }

    </script>
	
</head>
<body style="background-image:url(fondo.jpg)">
  <div class="contenido"  >
      <div style="background-color: #d66e2b;height: 10px;border-bottom: solid 1px #B35D25;"></div>
            
      <div style="margin: auto; max-width: 150px; margin-bottom: 13px;">
       <img src="logo.png" style="max-width:150px;">
      </div>	

      
    <div class="box">
      <div style="margin: auto; max-width: 420px; padding: 0px 15px 15px; box-shadow: 0px 0px 17px #666;
          border-radius: 10px; background-color:#FFF;"  >
      
          <div class="modal-header" style="margin-bottom: 25px;">
              <h2 class="modal-title" style="text-align:center; color:#E38144;">Bobinados del Valle</h2>     
          </div>
      
            
            <div class="input-group margin-bottom-sm">
              <span class="input-group-addon"><i class="fa fa-envelope-o fa-fw"></i></span>
              <input class="form-control" type="text" name="usernamereco" placeholder="Correo de confirmación">
            </div><br>
            
            <div class="input-group">
              <span class="input-group-addon"><i class="fa fa-key fa-fw"></i></span>
              <input class="form-control" name="passwordreco" type="password" placeholder="Contraseña" >
            </div> <br>  

            <div class="input-group">
              <span class="input-group-addon"><i class="fa fa-key fa-fw"></i></span>
              <input class="form-control" name="passwordreco1" type="password" placeholder="repita Contraseña">
            </div> <br>     
            
          

          <button type="button" class="btn btn-primary btn-lg" name="sesion" onclick="javascript:validarcorreoeditar()">Actualizar</button>
            
      </div>
    </div>
  </div>
  
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="dist/js/bootstrap.min.js"></script>

</body>
</html>
<?php }else{ ?>
<script>location.href = "menu_admin.php";</script>
<?php } ?>

