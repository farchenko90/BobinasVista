<?php 
     session_start();
if(isset($_SESSION['id'])){
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bobinados del Valle</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/sb-admin.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/toastr.css">
    
    <script src="js/jquery-1.11.0.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/toastr.min.js"></script>
    <script src="Jsserver/Server.js" type="text/javascript"></script>
    <script src="Jsserver/UsuarioServer.js" type="text/javascript"></script>
    
    <style>.titu_menu{float: right; margin-top:0px; border-bottom: 1px dashed #fff;}
    #myModalLabel{text-shadow: 0px 1px 0px #080808;
			opacity: .9;
			color: #FEFEFE;
			font-weight: 700;}
    </style>
    
    <script>
    
        var d = new Date(); 
        var NI = d.getDate() + "" + (d.getMonth() +1) + "" + d.getFullYear() + '' +d.getHours()+''+d.getMinutes()+''+d.getSeconds();
        var NomImg ="";
        var NomImg1 ="";
        var NomImgAnt = "";
        
        function cargar(){
            location.href = "menu_admin.php";
        }
        
        $(document).ready(function(){
            toastr.options.timeOut = 1500; // 1.5s
            consultarcuenta();
            
            $('#txtImagen').change(function()
                   {
                    var fileExtension = "";
                    document.getElementById("barInv1").value = 0;
                    var file = $("#txtImagen")[0].files[0];
                    var fileName = file.name;
                    document.getElementById("barInv1").value = 30;
                    fileExtension = fileName.substring(fileName.lastIndexOf('.') + 1);
                    document.getElementById("barInv1").value = 70;
                    
                    NomImg1 = NI+"."+fileExtension;
                    document.getElementsByName("foto_admin")[0].value = NomImg1;
                    if(isImage(fileExtension)){
                        var formData = new FormData($(".frmInv1")[0]);
                        //alert(JSON.stringify($(".frmInv1")[0]));
                        
                        $.ajax({
                            url: servidor+'upload.php?n='+NI+"&e="+fileExtension,  
                            type: 'POST',
                            data: formData,
                            cache: false,
                            contentType: false,
                            processData: false,
                            //una vez finalizado correctamente
                            success: function(data){
                                //alert(servidor+"imagenes/"+data);
                                document.getElementById("barInv1").value = 100;
                                document.getElementById("imgInv1").setAttribute("src",servidor+"imagenes/"+data);
                            },
                            //si ha ocurrido un error
                            error: function(){
                                alert("error imagen");
                            }
                        });
                    }
                    else{
                        alert("solo se permiten imagenes");
                    }
                });
                
                

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
            
        });
        
        function sololetras(e){
            var key = window.Event ? e.which : e.keyCode
            return (key >= 97 && key <= 122 || key >=65 && key <= 90)
        }
       
    </script>
    
</head>

<body>

    <div id="wrapper">
<div style="background-color: #d66e2b;height: 10px;border-bottom: solid 1px #B35D25;"></div>
            <br>
        
        <div id="page-wrapper" style="padding:0px;">
        
            <div class="container-fluid" style="max-width:800px;">
                
                <div class="row" style="color:#FFF;">
                  <div class="col-xs-12 col-sm-8 bloquesw" style="background-color: #49678D; ">
                      <h2 style="margin-top:5px; border-bottom: 1px dashed #fff;" >Datos de Perfil</h2>
                      <div class="col-xs-4" id="photo">
                     	<!--<img src="img/fotos_perfil.jpg" height="130px" style="border-radius:90px; border: 4px solid #fff;">-->
                      </div>  
                      <div class="col-xs-8" style="min-height:130px; ">
                      	<h3 id="nomb_usua" style="margin-left: -7%; font-size: 20px"></h3>
                        <h3 id="tipo" style="margin-top: -4%; margin-left: -5%;font-size: 20px"></h3>
                        <div style="float:right; margin-top:10%;">                        
                        <a class="btn btn-success btn-outline btn-xs" href="#" role="button" data-toggle="modal" data-target="#confi_admin"><i class="fa fa-gear fa-fw fa-2x " ></i> Configurar</a>
                        <a class="btn btn-warning btn-outline btn-xs" href="http://localhost/BobinasVista/iniciochat.php" role="button"><i class="fa fa-home fa-fw fa-2x" ></i> Chat</a> 
                     	</div>
                      </div>    

                  </div>
                  <?php if($_SESSION['rol']=="Administrador"){ ?> 
                  <a href="menu_admin_usuarios.php" title="Agregar o Modificar Usuarios">
                  <div class="col-xs-6 col-sm-4 bloquesw" style="background-color:#8673A1;">
                   	  
                      <img src="img/usuariouno.png" style="margin: 10px auto 0px;display: block;max-height: 150px;width:auto;">
                      <h4  class="titu_menu">Usuarios</h4>
                  
                      </div></a><?php  } ?>
                    <?php  if($_SESSION['rol']=="Jefe Motores" || $_SESSION['rol']=="Empleado Motores" || $_SESSION['rol']=="Administrador" || $_SESSION['rol']=="Sub Admin"){ ?> 
                  <a href="menu_admin_motores.php" title="Motores" ><div class=" col-xs-6 col-sm-4 bloquesw" style="background-color:#7FB5B5">
                    
                      <img src="img/engine22.png" style="margin: 10px auto 0px;display: block;max-height: 150px;width:auto;">
                      <h4  class="titu_menu"> Motores</h4>
                  </div></a>
                <?php } ?> 
                <?php if($_SESSION['rol']=="Jefe Motores" || $_SESSION['rol']=="Empleado Motores"){ ?>
                      <a href="" title="Diccionario" data-toggle="modal" data-target="#diccionary"><div class=" col-xs-6 col-sm-4 bloquesw" style="background-color:#009688">
                    
                        <img src="img/book.png" style="margin: 10px auto 0px;display: block;max-height: 150px;width:auto;">
                        <h4  class="titu_menu"> Manual</h4>
                      </div></a>
                      
                <?php  } ?>
                <?php if($_SESSION['rol']=="Cliente"){ ?>
                      <a href="" title="Diccionario" data-toggle="modal" data-target="#glosario"><div class=" col-xs-6 col-sm-4 bloquesw" style="background-color:#009688">
                    
                        <img src="img/book.png" style="margin: 10px auto 0px;display: block;max-height: 150px;width:auto;">
                        <h4  class="titu_menu"> Glosario</h4>
                      </div></a>
                      
                <?php  } ?>
                    <?php if($_SESSION['rol']=="Jefe Transformadores" || $_SESSION['rol']=="Empleado Transformador" || $_SESSION['rol']=="Administrador" || $_SESSION['rol']=="Sub Admin"){ ?>
                  <a href="menu_admin_transformador.php" title="Transformadores"><div class="col-xs-6 col-sm-4 bloquesw" style="background-color:#434750;">
                   
                      
                      <img src="img/transformadores.png" style="margin: 10px auto 0px;display: block;max-height: 150px;width:auto;">
                      <h4  class="titu_menu">Transformadores</h4>
                  </div></a>
                    <?php } ?>
                    <?php if($_SESSION['rol']=="Jefe Transformadores" || $_SESSION['rol']=="Empleado Transformador"){ ?>
                      <a href="" title="Diccionario" data-toggle="modal" data-target="#diccionarytrans"><div class=" col-xs-6 col-sm-4 bloquesw" style="background-color:#009688">
                    
                        <img src="img/book.png" style="margin: 10px auto 0px;display: block;max-height: 150px;width:auto;">
                        <h4  class="titu_menu"> Manual</h4>
                      </div></a>
                      
                <?php  } ?>
                <?php if($_SESSION['rol']=="Jefe Motores" || $_SESSION['rol']=="Jefe Transformadores" ){ ?>
                        <a href="listaempleadomotores.php" title="Lista De Trabajadores">
                  <div class="col-xs-6 col-sm-4 bloquesw" style="background-color:#8673A1;">
                      
                      <img src="img/usuariouno.png" style="margin: 10px auto 0px;display: block;max-height: 150px;width:auto;">
                      <h4  class="titu_menu">Lista De Trabajadpres</h4>
                  
                      </div></a>
                <?php } ?> 
                 <a onClick="alert('Salio de la Cuenta.')" href="salir.php"> <div class="col-xs-6 col-sm-4 bloquesw" style="background-color:#BA4648;">
                  <img src="img/salir.png" style="margin: 10px auto 0px;display: block;max-height: 150px;width:auto;"> 
                  <h4  class="titu_menu">Salir</h4>
                 </div></a>
                  
                </div>        
                        
            </div>
            
            <?php 
                echo "<input type='hidden' name='ced' value='".$_SESSION['id']."'";
            ?>
            
        </div>
        <!-- /#page-wrapper -->
        
        <!--modal ventana  -->
         <div class="modal fade" id="confi_admin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header" style="background:#d66e2b;">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"  id="myModalLabel">Editar cuenta</h4>
                  </div>                     

                  <div class="modal-body">
                    <!--<form role="form"  action="" method="post">-->
                      
                        <!--<label >Foto</label>
                        <input type="file" class="form-control" id="txtImagen" name="txtImagen" >
                        <p class="help-block">Seleccione un archivo .jpg ó .png</p>-->
                    <form class="frmInv1" name="frm_inv">
                             <label>Foto</label><br /> <br /> 
                             <img id="imgInv1" class="imbInv" src="./img/producto_sin_foto.jpg" width="100px" height="100px" style="margin-left: 40px;" /> <br />
                             <input  style="margin-top: 10px; border: none; box-shadow:none;" id="txtImagen" name="txtImagen" type="file" />
                             <br />
                             <progress id="barInv1" style="position: relative; left: 15px;" value="0" max="100"></progress>

                       </form>
                      <div class="form-group">
                        <input type="hidden" class="form-control" name="foto_admin"  required>
                      </div>
                      <div class="form-group">
                        <label >Nombre y Apellido</label>
                        <input type="text" class="form-control" id="nombres" name="nomb_admin"  required>
                      </div>
                      <div class="form-group">
                        <label >Usuario</label>
                        <input type="text" class="form-control" id="usuario" name="user_admin"  required onkeypress="return sololetras(event)">
                      </div>

                      <div class="form-group">
                        <label >Email</label>
                        <input type="email" class="form-control" id="correo" name="mail_admin"  required>
                      </div>
                       <div class="form-group">
                        <label >Contraseña</label>
                        <input type="password" class="form-control" id="contraseña" name="pass_admin" required>
                      </div>                       
                      <div class="modal-footer">
                        <input type="submit" class="btn btn-success" onclick="javascript:editarcuenta();" value="Guardar">
                        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="javascript:cargar();">Cancelar</button>
                      </div>                          
                    <!--</form> -->

                  </div>

                </div>
            </div>
        </div>
        
        <!-- Modal de diccionario-->
          
        <div class="modal fade" id="diccionary" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header" style="background:#d66e2b;">
                    <h4 class="modal-title"  id="myModalLabel">Manual de instructivo de mantenimiento</h4>
                  </div>                     

                  <div class="modal-body">
                    
                    <div class="row">
                      <div class="col-xs-12 col-md-8">
                        <h5 style="color: red;font-size: 19px;margin-left: 50%">Desarme del motor </h5>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-6">
                          <h5 style="color: red; font-size: 16px">* Quitar tapas:
                          </h5>
                          <p style="line-height: 100%;color: blue;text-align: justify">Soltar tornillos y accesorio como poleas, ventilador, cuña, bujes separadores para proceder a destaparlo. Si es un motor monofásico, hay que tener cuidado por que en la tapa viene instalado un interruptor centrífugo.</p>  
                      </div>
                      <div class="col-xs-6">
                          <h5 style="color: red; font-size: 16px">* Sacar rotor:
                          </h5>
                          <p style="line-height: 100%;color: blue;text-align: justify">Se saca el rotor con mucho cuidado para no dañar el bobinado o los bujes del estator.</p>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-6">
                        <h5 style="color: red; font-size: 16px">* Quitar Base:
                          </h5>
                          <p style="line-height: 100%;color: blue;text-align: justify">la mayoría de los motores traen una base o patas, las que hay que quitar para poder girarlo a la hora de meter bobinas.</p>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-12 col-md-8">
                        <h5 style="color: red;font-size: 17px;margin-left: 10%;text-align: justify">Toma de datos de la placa :</h5>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-6 col-md-4">
                        <h5 style="color: red; font-size: 16px">* Amp:
                          </h5>
                          <p style="line-height: 100%;color: blue;margin-top: -15%;margin-left: 35%">Amperaje</p>
                      </div>
                      <div class="col-xs-6 col-md-4">
                        <h5 style="color: red; font-size: 16px">* HP:
                          </h5>
                          <p style="line-height: 100%;color: blue;margin-top: -15%;margin-left: 35%">Caballos de fuerza</p>
                      </div>
                      <div class="col-xs-6 col-md-4">
                        <h5 style="color: red; font-size: 16px">* V:
                          </h5>
                          <p style="line-height: 100%;color: blue;margin-top: -15%;margin-left: 35%">Voltaje</p>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-6 col-md-4">
                        <h5 style="color: red; font-size: 16px">* KW:
                          </h5>
                          <p style="line-height: 100%;color: blue;margin-top: -15%;margin-left: 35%">Kilovatios. </p>
                      </div>
                      <div class="col-xs-6 col-md-4">
                        <h5 style="color: red; font-size: 16px">* RPM:
                          </h5>
                          <p style="line-height: 100%;color: blue;margin-top: -15%;margin-left: 35%">Revolución Por minuto </p>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-6">
                        <h5 style="color: red; font-size: 16px">* Limpieza y secado del bobinado</h5>
                        <p style="text-align: justify;line-height: 100%;color: blue">la mayoría de los motores traen una base o patas, las que hay que quitar para poder girarlo a la hora de meter bobinas.</p>
                      </div>
                      <div class="col-xs-6">
                        <h5 style="color: red; font-size: 16px">* Barnizada</h5>
                        <p style="text-align: justify;line-height: 100%;color: blue">Si se requiere, procedemos  a preparar el barniz dieléctrico disolviéndolo con un poco de thiner , luego comenzamos a barnizar el bobinado por ambos lados, aplicándole en intervalos  de tiempo  de 10-15 o 20 minutos.</p>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-xs-6">
                        <h5 style="color: red; font-size: 16px">* Horneado</h5>
                        <p style="text-align: justify;line-height: 100%;color: blue">Después de escurrido el bobinado, lo colocamos en el horno a una temperatura entre 80° - 100°C  por un tiempo de  1 a 2 horas dependiendo del tamaño del motor, para un total secado y cristalización del barniz.</p>
                      </div>
                      <div class="col-xs-6">
                        <h5 style="color: red; font-size: 16px">* Preparación del rotor</h5>
                        <p style="text-align: justify;line-height: 100%;color: blue">Mientras se hornea el bobinado, podemos mirar en que condiciones se encuentra el rotor, cambiar balineras y observar, cunas de balineras en las tapas.</p>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-xs-6">
                        <h5 style="color: red; font-size: 16px">* Raspado de estator</h5>
                        <p style="text-align: justify;line-height: 100%;color: blue">Sacamos el estator del horno, y raspamos con cuchillo  la superficie, teniendo cuidado para no rayar los aislamientos y alambres.</p>
                      </div>
                      <div class="col-xs-6">
                        <h5 style="color: red; font-size: 16px">* Armada final </h5>
                        <p style="text-align: justify;line-height: 100%;color: blue">Cumplidas todas las etapas, procedemos a acomodar las tapas en el rotor y el rotor en el estator, teniendo cuidado al introducir este, para no maltratar ninguna parte del bobinado.</p>
                      </div>

                      <div class="row">
                        <div class="col-xs-12 col-md-8">
                          <h5 style="color: red;font-size: 17px;margin-left: 10%">Verificaciones finales </h5>
                        </div>
                      </div>
                      
                      <div class="row">
                        <div class="col-xs-6">
                          <h5 style="color: red; font-size: 16px;margin-left: 15px">* Prueba a tierra:</h5>
                          <p style="text-align: justify;line-height: 100%;color: blue;margin-left: 15px">Colocar un terminal del Tester y se ubica en la carcasa del motor, luego se coloca el otro terminal del Tester en el cable de conexiones del motor, se coloca el equipo en escala de 200 ohmios (), las medida debe ser cero (0), si no indica que un cable está rozando el bobinado. </p>
                        </div>
                        <div class="col-xs-6">
                          <h5 style="color: red; font-size: 16px">* prueba ohmiaje: </h5>
                          <p style="text-align: justify;line-height: 100%;color: blue">Se toman los cables terminales de las bobinas entre sí conectadas al tester en escala de 200 ohmios (), el cual nos va a dar resultados en ohmios; dichos resultados deben dar iguales entre bobinas.</p>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-xs-12 col-md-8">
                          <h5 style="color: red;font-size: 17px;margin-left: 10%">Aplicacion de voltaje o tension</h5>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-xs-6">
                          <p style="text-align: justify;line-height: 100%;color: blue;margin-left: 15px">a). Encender el motor y con la pinza voltiamperimétrica realizamos mediciones, estas medidas son anotadas en el registro R7/7.5./13 Control de datos de Motores Trifásico o en el  registro R7/7.1/03 Control de datos de Motores Monofásico.  </p>
                        </div>
                        <div class="col-xs-6">
                          <p style="text-align: justify;line-height: 100%;color: blue">b). Anotar el amperaje en vacío que no debe exceder del (30 – 40) % del amperaje nominal de carga.</p>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-xs-12 col-md-8">
                          <h5 style="text-align: justify;color: blue;margin-left: 15px">c).  Medir el voltaje aplicado dependiendo del motor (220V/440V) (110V/220V).</h5>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-xs-6">
                          <h5 style="color: red; font-size: 16px;margin-left: 15px">*  Instalación de accesorios </h5>
                          <p style="text-align: justify;line-height: 100%;color: blue;margin-left: 15px">Se coloca el ventilador, tapas de ventilador, capacitores y  poleas.</p>
                        </div>
                        <div class="col-xs-6">
                          <h5 style="color: red; font-size: 16px">* Limpieza, lijada y pintura </h5>
                          <p style="text-align: justify;line-height: 100%;color: blue">Limpiamos, lijamos y pintamos el motor, para una mejor presentación</p>
                        </div>
                      </div>
                      
                      <div class="row">
                        <div class="col-xs-6">
                          <h5 style="color: red; font-size: 16px;margin-left: 15px">* Revicion y verificacion </h5>
                          <p style="text-align: justify;line-height: 100%;color: blue;margin-left: 15px">El Jefe del área de motores, los auxiliares tienen la responsabilidad de verificar  que el proceso se encuentre terminado a satisfacción, para poder entregar un servicio con calidad. </p>
                        </div>
                      </div>

                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="javascript:cargar();">Cerrar</button>
                      </div>  

                  </div>

                </div>
            </div>
        </div>  
    </div>


    <div class="modal fade" id="diccionarytrans" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header" style="background:#d66e2b;">
                    <h4 class="modal-title"  id="myModalLabel">Manual de instructivo de Transformadores</h4>
                  </div>                     

                  <div class="modal-body">
                    
                    <div class="row">
                      <div class="col-xs-12 col-md-8">
                        <h5 style="text-align: justify;color: red;font-size: 19px;margin-left: 30%">Verificación del estado del transformador</h5>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-6">
                          <h5 style="color: red; font-size: 16px">* Megueo:
                          </h5>
                          <p style="line-height: 100%;color: blue">Esta consiste en mirar en qué estado de humedad se encuentra el transformador. (Ver prueba de megueo en seco y/o en aceite item  6.8 y 6.10 del presente instructivo) </p>  
                      </div>
                      <div class="col-xs-6">
                          <h5 style="color: red; font-size: 16px">* Condiciones del aceite:
                          </h5>
                          <p style="line-height: 100%;color: blue">consiste en verificar en qué condiciones está el aceite.</p>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-6">
                        <h5 style="color: red; font-size: 16px">* Relación de transformación:
                          </h5>
                          <p style="text-align: justify;line-height: 100%;color: blue">se le aplica al transformador por los bornes de alta tensión un bajo voltaje y se lee por los bornes de baja tensión un voltaje inferior según conversión de formula eléctrica.</p>
                      </div>
                      <div class="col-xs-6">
                        <h5 style="color: red; font-size: 16px">* Corto circuito:
                          </h5>
                          <p style="text-align: justify;line-height: 100%;color: blue">cuando se le aplica un bajo voltaje al transformador por los bornes de alta tensión y leemos en los bornes de baja tensión un respectivo amperaje en cada borne, para saber si el transformador está en capacidad de resistir la carga para el cual fue elaborado.</p>
                      </div>
                    </div>
                    
                    <div class="row">
                      <div class="col-xs-6">
                        <h5 style="color: red; font-size: 16px">* Desencube del transformador</h5>
                        <p style="text-align: justify;line-height: 100%;color: blue">la mayoría de los motores traen una base o patas, las que hay que quitar para poder girarlo a la hora de meter bobinas.</p>
                      </div>
                      <div class="col-xs-6">
                        <h5 style="color: red; font-size: 16px">* Barnizada</h5>
                        <p style="text-align: justify;line-height: 100%;color: blue">Levantar la tapa con cuidado, procediendo a sacar la mayor parte del aceite.Envasar en un recipiente y observar si está o no quemado.</p>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-xs-6">
                        <h5 style="color: red; font-size: 16px">* Horneado de la parte activa</h5>
                        <p style="text-align: justify;line-height: 100%;color: blue">Dejar en el horno hasta que el Meguer  indique que no hay humedad en la bobina.  La temperatura del horno se determina con el termómetro y un suiche térmico dispuesto a dispararse en el momento que llega a la temperatura máxima.</p>
                      </div>
                      <div class="col-xs-6">
                        <h5 style="color: red; font-size: 16px">* Preparar la parte inactiva</h5>
                        <p style="text-align: justify;line-height: 100%;color: blue">Despojo de aceite en cuba,Lavado y lijado de cubas. </p>
                      </div>
                    </div>
                      
                      <div class="row">
                        <div class="col-xs-6">
                          <h5 style="color: red; font-size: 16px;margin-left: 15px">* Preparacion del aceite:</h5>
                          <p style="text-align: justify;line-height: 100%;color: blue;">Seleccionar el aceite que se va a usar en el transformador.
Observar la coloración Realizar pruebas de Rigidez dieléctrica, la cual consiste en tomar una muestra de aceite de la filtroprensa y se coloca en el Chispometro dejándolo en reposo mínimo 15 minutos. </p>
                        </div>
                        <div class="col-xs-6">
                          <h5 style="color: red; font-size: 16px">* prueba de megueo: </h5>
                          <p style="text-align: justify;line-height: 100%;color: blue">Consiste en medir con el Meguer la parte activa del transformador, que permanece en horneado.  Para iniciar esta prueba es necesario esperar aproximadamente entre 1  y 3 horas, en caso de que el megueo no alcance los rangos mínimos se volverá a meter al horno Se realizan tres pruebas que son las siguientes:</p>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-xs-6">
                          <h5 style="color: red; font-size: 16px">* A-B: Alta-Baja</h5>
                          <p style="text-align: justify;line-height: 100%;color: blue">se mide la humedad entre el bobinado primario con el secundario.</p>
                        </div>
                        <div class="col-xs-6">
                          <h5 style="color: red; font-size: 16px">* A-T: Alta-Tierra:</h5>
                          <p style="text-align: justify;line-height: 100%;color: blue">se mide la humedad entre el bobinado primario con la tierra.</p>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-xs-6">
                          <h5 style="color: red; font-size: 16px">* B-T: Baja-Tierra:</h5>
                          <p style="text-align: justify;line-height: 100%;color: blue">se mide la humedad entre el bobinado secundario con la tierra.</p>
                        </div>
                      </div>

                      <div class="row">
                      <div class="col-xs-6">
                        <h5 style="color: red; font-size: 16px">* Pruebas finales de aplicación de corriente</h5>
                        <p style="text-align: justify;line-height: 100%;color: blue">Consiste en aplicarle al transformador un voltaje de alta tensión por los bornes de alta tensión y tomar una lectura de voltaje en los bornes de baja tensión con el tester, el voltaje de salida,  observando que el voltaje resultante en dichos bornes corresponda a las características propias del transformador.</p>
                      </div>
                      <div class="col-xs-6">
                        <h5 style="color: red; font-size: 16px">* Pintura, marcacion y placa</h5>
                        <p style="text-align: justify;line-height: 100%;color: blue">Teniendo la precaución de marcar el transformador con cinta de papel el secuencial del servicio en un lugar visible del transformador, procurando que no interfiera con la pintura, esto para garantizar que no se confunda el transformador</p>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-xs-6">
                        <h5 style="color: red; font-size: 16px">* Supervicion final</h5>
                        <p style="text-align: justify;line-height: 100%;color: blue">Se verifica que el servicio este completo en condiciones para ser entregado al cliente.</p>
                      </div>
                      <div class="col-xs-6">
                        <h5 style="color: red; font-size: 16px">* Entrega</h5>
                        <p style="text-align: justify;line-height: 100%;color: blue">Al finalizar todo el proceso, se le hace entrega del transformador al cliente con sus documentos, entre estos remisión, facturas y la garantía. </p>
                      </div>
                    </div>
  

                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="javascript:cargar();">Cerrar</button>
                      </div>  

                  

                </div>
            </div>
        </div>  
    </div>

      <div class="modal fade" id="glosario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header" style="background:#d66e2b;">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"  id="myModalLabel">Glosario de término</h4>
                  </div>                     

                  <div class="modal-body">
                      
                      <div class="row">
                      <div class="col-xs-6 col-md-4">
                        <h5 style="color: red; font-size: 16px">* Amp:
                          </h5>
                          <p style="line-height: 100%;color: blue;margin-top: -15%;margin-left: 35%">Amperaje</p>
                      </div>
                      <div class="col-xs-6 col-md-4">
                        <h5 style="color: red; font-size: 16px">* HP:
                          </h5>
                          <p style="line-height: 100%;color: blue;margin-top: -15%;margin-left: 35%">Caballos de fuerza</p>
                      </div>
                      <div class="col-xs-6 col-md-4">
                        <h5 style="color: red; font-size: 16px">* V:
                          </h5>
                          <p style="line-height: 100%;color: blue;margin-top: -15%;margin-left: 35%">Voltaje</p>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-6 col-md-4">
                        <h5 style="color: red; font-size: 16px">* KW:
                          </h5>
                          <p style="line-height: 100%;color: blue;margin-top: -15%;margin-left: 35%">Kilovatios. </p>
                      </div>
                      <div class="col-xs-6 col-md-4">
                        <h5 style="color: red; font-size: 16px">* RPM:
                          </h5>
                          <p style="line-height: 100%;color: blue;margin-top: -15%;margin-left: 35%">Revolución Por minuto </p>
                      </div>
                    </div>
                    
                    <div class="row">
                      <div class="col-xs-6">
                          <h5 style="color: red; font-size: 16px">* Megueo:
                          </h5>
                          <p style="line-height: 100%;color: blue">Esta consiste en mirar en qué estado de humedad se encuentra el transformador. (Ver prueba de megueo en seco y/o en aceite item  6.8 y 6.10 del presente instructivo) </p>  
                      </div>
                      <div class="col-xs-6">
                          <h5 style="color: red; font-size: 16px">* Condiciones del aceite:
                          </h5>
                          <p style="line-height: 100%;color: blue">consiste en verificar en qué condiciones está el aceite.</p>
                      </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-6">
                          <h5 style="color: red; font-size: 16px">* A-B: Alta-Baja</h5>
                          <p style="text-align: justify;line-height: 100%;color: blue">se mide la humedad entre el bobinado primario con el secundario.</p>
                        </div>
                        <div class="col-xs-6">
                          <h5 style="color: red; font-size: 16px">* A-T: Alta-Tierra:</h5>
                          <p style="text-align: justify;line-height: 100%;color: blue">se mide la humedad entre el bobinado primario con la tierra.</p>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-xs-6">
                          <h5 style="color: red; font-size: 16px">* B-T: Baja-Tierra:</h5>
                          <p style="text-align: justify;line-height: 100%;color: blue">se mide la humedad entre el bobinado secundario con la tierra.</p>
                        </div>
                      </div>

                      
                                           
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal" onclick="javascript:cargar();">Cancelar</button>
                    </div>                          
                    <!--</form> -->

                  </div>

                </div>
            </div>
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
    $(document).ready(function() {
        $('#dataTables-example').dataTable();
    });
	
    </script>
    <script>
	$(document).ready(function()
	  {
		  $(".row a div").hover(function() 
		   {
				$(this).animate({opacity:'0.6'});
			  }, function() {
				$(this).animate({opacity:'1'});
			  }
			);
	  
     });
	 
	</script>

</body>

</html>
<?php }else{ ?>
<script>location.href = "inicio_sesion.php";</script>
<?php } ?>
