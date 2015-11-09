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
    

    <script type="text/javascript">

    function recordar(){
      location.href = ruta+"recordarcontrasena.php";
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
      
      
          <form role="form" action="javascript:login();" method="POST" >
            <!--<div class="form-group">
              <label for="exampleInputEmail1">Usuario:</label>
              <input type="text" class="form-control" id="" placeholder="Ingrese su nombre de usuario o cedula" required name="username">
            </div>-->
            <div class="input-group margin-bottom-sm">
              <span class="input-group-addon"><i class="fa fa-envelope-o fa-fw"></i></span>
              <input class="form-control" type="text" name="username" placeholder="Ingrese su nombre de usuario o cedula">
            </div><br>
            <!--<div class="form-group">
              <label for="exampleInputPassword1">Contraseña:</label>
              <input type="password" class="form-control" id="" placeholder="Contraseña" name="password" required>
            </div>-->
            <div class="input-group">
              <span class="input-group-addon"><i class="fa fa-key fa-fw"></i></span>
              <input class="form-control" name="password" type="password" placeholder="Contraseña">
            </div> <br>     

            <button type="submit" class="btn btn-primary btn-lg" name="sesion" onclick="javascript:function(){document.formulario.submit();}">Entrar</button>
            <a href="javascript:recordar()"><h5 style="margin-left: 30%;margin-top: -5%;color: blue;">¿Olvidaste tu contraseña?</h5></a>
          </form>
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
