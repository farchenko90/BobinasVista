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
    <link href="css/alertify.core.css" rel="stylesheet"/>
    <link href="css/alertify.default.css" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="css/toastr.css">
    
    <script src="js/jquery-1.11.0.min.js" type="text/javascript"></script>
    <script src="js/alertify.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/toastr.min.js"></script>
    <script src="Jsserver/Server.js" type="text/javascript"></script>
    <script src="Jsserver/RebobinadosServer.js" type="text/javascript"></script>
    <script src="Jsserver/MotorServer.js"></script>
    <script src="Jsserver/ClienteServer.js"></script>
    <script src="Jsserver/MantenimientoServer.js"></script>
    <script src="Jsserver/UsuarioServer.js"></script>
    
<style>
#myModalLabel{text-shadow: 0px 1px 0px #080808;
opacity: .9;
color: #FEFEFE;
font-weight: 700;}
.letra_ancha{font-size: 1.4em;;}

.bton{background:#CA8355; color:#fff; border:1px solid #EEBFA1;}
#side-menu li a img{   
  max-height: 70px;
  max-width: 70px;
  }

  .collapsed:link {
    text-decoration: none;
}

.collapsed:visited {
    text-decoration: none;
}

.collapsed:hover {
    text-decoration: underline;
}

.collapsed:active {
    text-decoration: none;
}

</style>

<script>
    
    var id;
    
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
    
    var d = new Date(); 
        var NI = d.getDate() + "" + (d.getMonth() +1) + "" + d.getFullYear() + '' +d.getHours()+''+d.getMinutes()+''+d.getSeconds();
        var NomImg ="";
        var NomImg1 ="";
        var NomImgAnt = "";
    
    $(document).ready(function(){
        
        //boton1.style.display = 'none';
        
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
                            url: servidor+'upload1.php?n='+NI+"&e="+fileExtension,  
                            type: 'POST',
                            data: formData,
                            cache: false,
                            contentType: false,
                            processData: false,
                            //una vez finalizado correctamente
                            success: function(data){
                                //alert(servidor+"imagenesmotor/"+data);
                                document.getElementById("barInv1").value = 100;
                                document.getElementById("imgInv1").setAttribute("src",servidor+"imagenesmotor/"+data);
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
        
            cargarresponsableadministrador();
        //var cc = document.getElementsByName("ced")[0].value;
        
        var id = getGET();
        //alert(id)
        if(id!=null){
            tipodeaccion(id['id']);
            geturl = id['id'];
            Verdatosmotor(id['id']);//ver datos del motor modal
            Verdatoseditamotor(id['id']);//ver datos del motor modificar modal
            //Actualizadatosmotor(id['id']);///Actualizamos los datos del cliente y motor
            Verdatosclientemotor(id['id']);
        }else{
            location.href = "menu_admin_motores.php";
        }
    });


    function cargarresponsableadministrador(){
        jQuery.ajax({
             type: "GET",
             url: servidor+"responsable", 
             dataType: "json",
             success: function (data, status, jqXHR) {
                 //
                 
                 if(data!=null){
                     //var select1 = document.getElementsByName("respon1")[0];
                     var selec = document.getElementsByName("revicion4")[0]; 
                        for(var i=0;i < data.length; i++){
                            //alert(data[i].Id_usu)
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


    function Verdatosclientemotor(id){
    jQuery.ajax({
         type: "GET",
         url: servidor+"motores/"+id, 
         dataType: "json",
         success: function (data, status, jqXHR) {
             if(data!=null){
                 
                for(var i=0;i < data.length; i++){
                    document.getElementsByName("revicion4")[0].value = data[i].Id_usu;
                }
                 
             }

         },
         error: function (jqXHR, status) {
             alert("error buscar user");
         }
    });
}

    
    function tipodeaccion(id){
        VerManteRebo(id);
    }
    
</script>

</head>

<body>

 <nav class="navbar-default " style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                
            </div>
            <!-- /.navbar-header -->
  </nav>
              


<div style="background-color: #d66e2b;min-height: 10px;border-bottom: solid 1px #B35D25;"></div>    

        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav " id="side-menu">
                    <li class="brand">
                        <img src="logo.png"  alt="Bobinados del Valle" style="margin:auto; max-width: 100%;">
                    </li>
                    <li class="">
                        <a href="menu_admin.php"><i class="fa fa-home fa-5x fa-rosa" alt="Inicio"></i></a>
                    </li>
                    <?php if($_SESSION['rol']=="Jefe Motores" || $_SESSION['rol']=="Empleado Motores" || $_SESSION['rol']=="Administrador" || $_SESSION['rol']=="Sub Admin"){ ?>
                    <li class="" >
                        <a href="menu_admin_motores.php" style="background-color: rgb(125, 185, 185);">
                        <img src="img/engine22.png"  alt="Motores" title="Motores" >
                        </a>
                    </li>
                    <?php }if($_SESSION['rol']=="Jefe Transformadores" || $_SESSION['rol']=="Empleado Transformador" || $_SESSION['rol']=="Administrador" || $_SESSION['rol']=="Sub Admin"){ ?>
                    <li class="" >
                        <a href="menu_admin_transformador.php" style="  background-color: rgb(146, 62, 63);"> 
                        <img src="img/transformadores.png"  title="Transformadores" alt="Transformadores" style>
                       </a>
                    </li>
                    <?php } ?>
                </ul>
                <!-- /#side-menu -->
            </div>
            <!-- /.sidebar-collapse -->
        </nav>
        <!-- /.navbar-static-side -->


        
        <div id="page-wrapper">
       
        
            <div  id="" class="row">
                <div class="col-lg-12">
                
                    <h1 class="fa-rosa" style="border-bottom: 1px solid #eee;">Editar Motores</h1>
                    
                   
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        <div class="row">
        <!-- datos entrda -->

                                                                   
    <?php 
                echo "<input type='hidden' name='ced' value='".$_SESSION['id']."'";
            ?>

                <div class="col-lg-12">

<div class="well">
        <a href="#" title="Ver Datos del motor" class="btn btn-naranja " data-toggle="modal" data-target="#ver_datos" ><i class="fa fa-eye  fa-fw" ></i> Ver datos del Motor</a>
        <a href="#" title="Editar Datos de entrada del motor" class="btn btn-naranja " data-toggle="modal" data-target="#edit_datos" ><i class="fa fa-edit  fa-fw" ></i> Editar datos del Motor</a>
    </div> 

                <!-- Contenido -->
                     <div class="well">


      <!-- Mantenimiento --->
 <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
     <div id="mantenimineto">
  <div class="panel panel-danger"  >
    <div class="panel-heading" role="tab" id="headingOne">
      <h2 class="panel-title" style="font-size: 20px; display: inline-block;">
        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"><i class="fa fa-wrench  fa-rosa" ></i>
          Control Mantenimiento de Motores
        </a>
      </h2>
        <span class="badge "  style="float:right;" id="estado"></span>
        <span class="badge "  style="float:right; background-color: #1A4D79;">Mantenimiento</span>
      
    </div>
    <div id="collapseOne" class="panel-collapse collapse " role="tabpanel" aria-labelledby="headingOne">
      <div class="panel-body" >
        
        <form role="form" action="#">
                          <div class="row ">
                              
                                <div class="col-xs-12 ">
                                  
                                        <div class="col-xs-6 col-sm-3"> 
                                          <div class="form-group">
                                            <label >AMP</label>
                                            <input type="text" class="form-control" id="amp1" name="amp" required>
                                          </div>
                                        </div>

                                        <div class="col-xs-6 col-sm-3"> 
                                          <div class="form-group">
                                            <label >Voltios</label>
                                            <input type="text" class="form-control" id="vol1" name="voltios"  required>
                                          </div>
                                        </div>

                                        <div class="col-xs-6 col-sm-3"> 
                                          <div class="form-group">
                                            <label >Balineras</label>
                                            <input type="text" class="form-control" id="balineras1" name="balineras"  required>
                                          </div>
                                        </div>

                                        <div class="col-xs-6 col-sm-3"> 
                                          <div class="form-group">
                                            <label >Sello Mecanico</label>
                                            <input type="text" class="form-control" id="sello1" name="sello"  required>
                                          </div>
                                        </div>

                                </div><!-- col 12 -->

                                <div class="col-xs-12 ">
                                  
                                        <div class="col-xs-6 col-sm-4"> 
                                          <div class="form-group">
                                            <label >Capacitor de arranque</label>
                                            <input type="text" class="form-control" id="capa1" name="capacitor"  required>
                                          </div>
                                        </div>

                                        <div class="col-xs-6 col-sm-4"> 
                                          <div class="form-group">
                                            <label >Capacitor de marcha</label>
                                            <input type="text" class="form-control" id="marcha1" name="marcha"  required>
                                          </div>
                                        </div>

                                        <div class="col-xs-6 col-sm-4"> 
                                            <div class="form-group">
                                             <label >Respondable</label> <!--aca colocarmos al usuario q llena los datos del motor -->
                                                  <!--<select class="form-control" name="respon1" title="" required >
                                                        
                                                  </select>-->
                                                  <input type="text" class="form-control" id="" name="r1"  required readonly="true">
                                                  <input type="hidden" class="form-control" id="" name="c1"  required>
                                            </div>
                                        </div>

                                </div><!-- col 12 -->

                                <div class="col-xs-12 ">
                                  
                                        <div class="col-xs-6 col-sm-4"> 
                                          <div class="form-group">
                                            <label >Otros</label>
                                            <textarea rows="4" style="min-width: 100%;" name="otros" id="otros1">
                                             </textarea>
                                          </div>
                                        </div>

                                        <div class="col-xs-6 col-sm-4"> 
                                          <div class="form-group">
                                            <label >Pruebas Finales</label>
                                            <textarea rows="4" style="min-width: 100%;" name="pruebas" id="pruebas1">
                                             </textarea>
                                          </div>
                                        </div>

                                        <div class="col-xs-6 col-sm-4"> 
                                            <div class="form-group">
                                             <label >Observaciones</label> <!--aca colocarmos al usuario q llena los datos del motor -->
                                             <textarea rows="4" style="min-width: 100%;" name="observaciones" id="obs1">
                                             </textarea>
                                            </div>
                                        </div>

                                </div><!-- col 12 -->
                                
                            </div><!-- row -->
                                                  
                         <div id="ocultarboton">
                            <input class="btn btn-primary" value="Guardar" id="mante" onclick="javascript:registrarmantenimiento();">
                             
                         </div>
                        <div id="modificarboton1" style="padding-left: 210px; margin-top: -33px">
                          <input type="button" class="btn btn-primary" id="" onclick="javascript:modificarmantenimiento();" value="Actualizar">
                        </div>
                            
                                                   
                        
      </div>
    </div>
  </div>
                         </div>
<!-- panel 2-->  
 <div id="monofacico">
  <div class="panel panel-danger" >
    <div class="panel-heading" role="tab" id="heading2">
      <h2 class="panel-title" style="font-size: 20px; display: inline-block;">
        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse2" aria-expanded="false" aria-controls="collapse2"><i class="fa fa-wrench  fa-rosa" ></i>
          Control de Motores Monofacicos
        </a>
      </h2>
        <span class="badge "  style="float:right;" id="estado2"></span>
        <span class="badge "  style="float:right; background-color: #1A4D79;">Rebobinado</span>
      <!--background-color: #A52626;-->
    </div>
    <div id="collapse2" class="panel-collapse collapse " role="tabpanel" aria-labelledby="heading2">
      <div class="panel-body">
        <p id="accion"></p>
        <form role="form" action="#">
                         
                          <div class="row ">
                             
                                <div class="col-xs-12">
                                  
                                        <div class="col-xs-6 col-sm-3"> 
                                          <div class="form-group">
                                            <label >V</label>
                                            <input type="text" class="form-control" id="v1" name="v"  required>
                                          </div>
                                        </div>  

                                        <div class="col-xs-6 col-sm-3"> 
                                          <div class="form-group">
                                            <label >Capacitor Marcha</label>
                                            <input type="text" class="form-control" id="capmarcha1" name="capmarcha"  required>
                                          </div>
                                        </div> 

                                        <div class="col-xs-6 col-sm-3"> 
                                          <div class="form-group">
                                            <label >Conexiones</label>
                                                 <select class="form-control" name="cone" title="" id="cone1">
                                                        <option value="220" selected>220</option>
                                                        <option value="110">110</option>
                                                  </select>
                                          </div>
                                        </div> 

                                        <div class="col-xs-6 col-sm-3"> 
                                          <div class="form-group">
                                            <label >Capacitor Arranque</label>
                                            <input type="text" class="form-control" id="caparran1" name="caparran"  required>
                                          </div>
                                        </div> 

                                        <div class="col-xs-6 col-sm-3"> 
                                          <div class="form-group">
                                            <label >AM</label>
                                            <input type="text" class="form-control" id="am1" name="am"  required>
                                          </div>
                                        </div>

                                        <div class="col-xs-6 col-sm-3"> 
                                          <div class="form-group">
                                            <label >Balineras ref</label>
                                            <input type="text" class="form-control" id="balinerasref1" name="balinerasref"  required>
                                          </div>
                                        </div>

                                        <div class="col-xs-6 col-sm-3"> 
                                          <div class="form-group">
                                            <label >Largo</label>
                                            <input type="text" class="form-control" id="largo1" name="largo"  required>
                                          </div>
                                        </div>

                                        <div class="col-xs-6 col-sm-3"> 
                                          <div class="form-group">
                                            <label >Sello Mecanico</label>
                                            <input type="text" class="form-control" id="sellomec1" name="sellomec"  required>
                                          </div>
                                        </div>
                                </div> <!--col 12-->

                                 <div class="col-xs-12" style="background:#d66e2b;">
                                    <h4 class="modal-title" style="color:#fff;">ARRANQUE</h4>
                                 </div>

                                 <div class="col-xs-12">

                                    <div class="col-xs-6 col-sm-3"> 
                                        <div class="form-group">
                                         <label >Paso</label>
                                         <input type="text" class="form-control" id="paso1" name="paso"  required>
                                        </div>
                                    </div>

                                    <div class="col-xs-6 col-sm-3"> 
                                        <div class="form-group">
                                         <label >Espiras</label>
                                         <input type="text" class="form-control" id="espiras1" name="espiras"  required>
                                        </div>
                                    </div>

                                    <div class="col-xs-6 col-sm-3"> 
                                        <div class="form-group">
                                         <label >Calibre</label>
                                         <input type="text" class="form-control" id="calibre1" name="calibre"  required>
                                        </div>
                                    </div>

                                    <div class="col-xs-6 col-sm-3"> 
                                        <div class="form-group">
                                         <label >Peso por Bobina</label>
                                         <input type="text" class="form-control" id="pesobobina1" name="pesobobina"  required>
                                        </div>
                                    </div>

                                 </div> <!--col 12-->

                                  <div class="col-xs-12" style="background:#d66e2b;">
                                    <h4 class="modal-title" style="color:#fff;">MARCHA</h4>
                                 </div>

                                     <div class="col-xs-12">

                                        <div class="col-xs-6 col-sm-3"> 
                                            <div class="form-group">
                                             <label >Paso</label>
                                             <input type="text" class="form-control" id="paso11" name="paso1"  required>
                                            </div>
                                        </div>

                                        <div class="col-xs-6 col-sm-3"> 
                                            <div class="form-group">
                                             <label >Espiras</label>
                                             <input type="text" class="form-control" id="espiras11" name="espiras1"  required>
                                            </div>
                                        </div>

                                        <div class="col-xs-6 col-sm-3"> 
                                            <div class="form-group">
                                             <label >Calibre</label>
                                             <input type="text" class="form-control" id="calibre11" name="calibre1"  required>
                                            </div>
                                        </div>

                                        <div class="col-xs-6 col-sm-3"> 
                                            <div class="form-group">
                                             <label >Peso por Bobina</label>
                                             <input type="text" class="form-control" id="pesobobi11" name="pesobobi1"  required>
                                            </div>
                                        </div>

                                        <div class="col-xs-6 col-sm-3"> 
                                            <div class="form-group">
                                             <label >Numero de ranuras</label>
                                             <input type="text" class="form-control" id="ranura1" name="ranura"  required>
                                            </div>
                                        </div>

                                        <div class="col-xs-6 col-sm-3"> 
                                            <div class="form-group">
                                             <label >Respondable</label> <!--aca colocarmos al usuario q llena los datos del motor -->
                                                  <!--<select class="form-control" name="respon" title="" required>
                                                        <option value="motor" selected>Juan</option>
                                                        <option value="Jefe_motor">Pedro</option>
                                                        <option value="Jefe_motor">mario</option>
                                                        <option value="Jefe_motor">resto de usuarios...</option>
                                                  </select>-->
                                                  <input type="text" class="form-control" id="" name="res" readonly="true" >
                                                  <input type="hidden" class="form-control" id="" name="ce1" readonly="true" >
                                            </div>
                                        </div>

                                        <div class="col-xs-6 col-sm-3"> 
                                            <div class="form-group">
                                             <label >Observaciones</label>
                                             <textarea rows="4"  style="min-width: 100%;" name="observaciones" id="observaciones1">
                                             </textarea>
                                            </div>
                                        </div>

                                        <div class="col-xs-6 col-sm-3"> 
                                            <div class="form-group">
                                             <label >Sugerencias</label>
                                             <textarea rows="4" style="min-width: 100%;" name="sugerencias" id="sugerencias1">
                                             </textarea>
                                            </div>
                                        </div>

                                        

                                     </div> <!--col 12-->

                            </div> <!--row-->
                      <div id="ocultarboton">
                            <input type="button" class="btn btn-primary" id="" onclick="javascript:guardarrebobinado();" value="Guardar">      
                      </div>                            
                      <div id="modificarboton" style="padding-left: 90px; margin-top: -33px">
                          <input type="button" class="btn btn-primary" id="" onclick="javascript:modificarrebobinado();" value="Actualizar">
                      </div>   
                    
                           
                                                   
                        </form> 
      </div>
    </div>
  </div>
                         </div>
</div>
    

                     </div>   <!--wel-->                 
                
                 </div>
            
            
            
            
            
            <!-- Modal -->
                <div class="modal fade" id="ver_datos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog ">
                    <div class="modal-content">
                      <div class="modal-header"  style="background:#d66e2b;">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Datos del Cliente</h4>
                      </div>                     
                      
                      <div class="modal-body">
                        <div class="row ">
                              <div class="col-xs-12 col-sm-3" >
                              
                                  <div class="form-group" id="photo">
                                    <label >Foto Motor</label>
                                  <!--<a href="foto_motor/motor1.jpg" target="_blank" ><div style="margin:auto;">
                                  <img src="foto_motor/motor1.jpg" style="max-width:100%; " title="Ver imagen"></div>
                                  </a>-->
                                  </div>
                              </div>
                                <div class="col-xs-12 col-sm-9">
                                  <div class="">
                                        <div class="col-xs-6 col-sm-6"> 
                                          <div class="form-group">
                                            <label >Nombre del Cliente</label>
                                            <p name="cliente"></p>
                                          </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                           <div class="form-group">
                                            <label >Dirección</label>
                                            <p name="direccion"></p>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                          <div class="form-group">
                                            <label >Ciudad:</label>
                                           <p name="ciudad"></p>                                            
                                          </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                           <div class="form-group">
                                            <label >Telefono:</label>
                                            <p name="tele"></p>
                                          </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                          <div class="form-group">
                                            <label >Fecha de ingreso</label>
                                            <p name="fingre"></p>
                                          </div>
                                        </div>
                                        
                                        <div class="col-xs-6 col-sm-6">
                                          <div class="form-group">
                                            <label >N.I</label>
                                            <p name="nit"></p>
                                          </div>
                                        </div>
                                       
                                    </div>
                                
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-sm-12" style="background:#d66e2b;">
                                    <h3 class="modal-title" style="color:#fff;">Datos del motor</h3>
                                </div>
                                <div class="col-sm-12">
                                        <div class="col-xs-6 col-sm-6" style=""> 
                                          <div class="form-group">
                                            <label >Marca:</label>
                                            <p name="marca"></p>
                                          </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                           <div class="col-xs-6" style="">
                                               <div class="form-group">
                                                  <label >Hp:</label>
                                                  <p name="hp"></p>
                                               </div> 
                                           </div> 
                                           <div class="col-xs-6" style="">
                                               <div class="form-group">
                                                  <label >KW:</label>
                                                  <p name="kw"></p>
                                               </div> 
                                           </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6" style="">
                                          <div class="form-group">
                                            <label >R.P.M:</label>
                                            <p name="rpm"> </p>                                           
                                          </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6" style="">
                                           <div class="form-group">
                                            <label >N° de fases:</label>
                                            <p name="fase"></p>
                                          </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                           <div class="col-xs-8" style="">
                                               <div class="form-group">
                                                  <label >Tp. Entrada:</label>
                                                  <p name="tp"></p>
                                               </div> 
                                           </div> 
                                           <div class="col-xs-4" style="">
                                               <div class="form-group">
                                                  <label >Revision:</label>
                                                  <p name="revicion"></p>
                                               </div> 
                                           </div>
                                        </div>
                                        
                                        <div class="col-xs-6 col-sm-6" style="">
                                          <div class="form-group">
                                            <label >Cotizado:</label>
                                            <p name="cotizado"></p>
                                          </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6" style="">
                                          <div class="form-group">
                                            <label >Autorizado:</label>
                                            <p name="autorizado"></p>
                                          </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6" style="">
                                          <div class="form-group">
                                            <label >F. acordada entrega:</label>
                                            <p name="facor"></p>
                                          </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6" style="">
                                          <div class="form-group">
                                            <label >F. terminacion servicio:</label>
                                            <p name="ftermi"></p>
                                          </div>
                                        </div>
                                        
                                        <div class="col-xs-6 col-sm-6" style="">
                                          <div class="form-group">
                                          <!--aca debe ir el q ingresa estos datos de entrada en este caso el que este logeado -->
                                            <label >Responsable:</label>
                                            <p name="admin"></p>
                                          </div>
                                        </div>


                                </div>
                            </div>
                       </div> 
                        <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                      </div>
                      </div>
                      
                      
                    </div>
                  </div>
                
                <!-- modal-->    




 <!-- edit Modal -->
                <div class="modal fade" id="edit_datos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header" style="background:#d66e2b;">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title" id="myModalLabel">Editar Cliente</h3>
                      </div>                     
                      
                      <div class="modal-body">
                      
                      <!--<form role="form" action="#">-->
                          <div class="row ">
                              <div class="col-xs-12 col-sm-3" >
                              
                                  <div class="form-group">
                                <form class="frmInv1" name="frm_inv">
                                     <label>Foto</label>
                                     <img id="imgInv1" class="imbInv" src="foto_motor/motor1.jpg" width="100px" height="100px" style="margin-left: 5px;" /> 
                                     <input  style="margin-top: 10px; border: none; box-shadow:none;" id="txtImagen" name="txtImagen" type="file" />
                                     <br />
                                     <progress id="barInv1" style="position: relative; left: 15px;" value="0" max="100"></progress>
           
                                 </form>
                                  </div>
                              </div>
                                <div class="col-xs-12 col-sm-9">
                                  <div class="">
                                        <div class="col-xs-6 col-sm-6"> 
                                          <div class="form-group">
                                            <label >Nombre del Cliente</label>
                                            <input type="text" class="form-control" id="" name="ncliente" placeholder="Nombre de la persona" required>
                                          </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6"> 
                                          <div class="form-group">
                                            <label>Apellidos del Cliente</label>
                                            <input type="text" class="form-control" id="" name="napelli" placeholder="Apellidos" required>
                                          </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                           <div class="form-group">
                                            <label >Dirección</label>
                                            <input type="text" class="form-control" id="" name="dir" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                          <div class="form-group">
                                            <label >Ciudad</label>
                                            <input type="text" class="form-control" id="" name="city" placeholder="" required>
                                            
                                          </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                           <div class="form-group">
                                            <label >Telefono</label>
                                            <input type="tel" class="form-control" id="" name="tel" placeholder="numero de telefono">
                                          </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                          <div class="form-group">
                                            <label >Fecha de ingreso</label>
                                            <input type="date" class="form-control" id="" name="fecha_ing" placeholder="" >
                                          </div>
                                        </div>
                                        
                                        <div class="col-xs-6 col-sm-6">
                                          <div class="form-group">
                                            <!--<label >N.S</label>-->
                                            <input type="hidden" class="form-control" id="" name="ns" placeholder=""  required>
                                          </div>
                                        </div>
                                       
                                    </div>
                                
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-sm-12" style="background:#d66e2b;">
                                    <h3 class="modal-title" style="color:#fff;">Datos del motor</h3>
                                </div>
                                <div class="col-sm-12">
                                        <div class="col-xs-6 col-sm-6"> 
                                          <div class="form-group">
                                            <label >Marca</label>
                                            <input type="text" class="form-control" id="" name="marc" placeholder="" required>
                                          </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                           <div class="col-xs-6">
                                               <div class="form-group">
                                                  <label >HP</label>
                                                  <input type="text" class="form-control" id="" name="hp1" placeholder="" required>
                                               </div> 
                                           </div> 
                                           <div class="col-xs-6">
                                               <div class="form-group">
                                                  <label >KW</label>
                                                  <input type="text" class="form-control" id="" name="kw1" placeholder="" required>
                                               </div> 
                                           </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                          <div class="form-group">
                                            <label >R.P.M</label>
                                            <input type="number" class="form-control" id="" name="rpm1" placeholder="" required>
                                            
                                          </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                           <div class="form-group">
                                            <label >N° de fases</label>
                                            <input type="tel" class="form-control" id="" name="fase1" placeholder="">
                                          </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                           <div class="col-xs-7">
                                               <div class="form-group">
                                                  <label >Tp. Entrada</label>
                                                  <select class="form-control" name="entrada" title="Seleccione un tipo de entrada" required>
                                                        <option value="Rebobinado" selected>Rebobinado</option>
                                                        <option value="Mantenimiento">Mantenimiento</option>
                                                  </select>
                                               </div> 
                                           </div> 
                                           <div class="col-xs-5">
                                               <div class="form-group">
                                                  <label >Revision</label>
                                                  <select class="form-control" name="tprev" title="Seleccione un tipo de entrada" required>
                                                        <option value="Si" selected>Si</option>
                                                        <option value="No">No</option>
                                                   </select>
                                               </div> 
                                           </div>
                                        </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                          <div class="form-group">
                                            <label >Cotizado</label>
                                            <input type="text" class="form-control" id="" name="coti" placeholder=""  required>
                                          </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                          <div class="form-group">
                                            <label >Autorizado</label>
                                            <input type="text" class="form-control" id="" name="autor" placeholder=""  required readonly="true">
                                          </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                          <div class="form-group">
                                            <label >F. acordada entrega</label>
                                            <input type="date" class="form-control" id="" name="fentrega" placeholder="" >
                                          </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                          <div class="form-group">
                                            <label >F. terminacion servicio</label>
                                            <input type="date" class="form-control" id="" name="fterminacion" placeholder="" >
                                          </div>
                                        </div>
                                        
                                         <?php if($_SESSION['rol']=="Jefe Motores" || $_SESSION['rol']=="Administrador" || $_SESSION['rol']=="Sub Admin"){ ?>
                                        <div class="col-xs-6 col-sm-6">
                                          <div class="form-group">
                                          <!--aca debe ir el q ingresa estos datos en este caso el que este logeado -->
                                            <label >Responsable</label>
                                            <!--<input type="text" class="form-control" id="resp" name="responsable" placeholder="" value="Admin logeado">-->
                                            <select class="form-control" name="revicion4" title="" required > 
                                                
                                            </select>
                                          </div>
                                        </div>
                                <?php }else {?>
                                       <div class="col-xs-6 col-sm-6">
                                          <div class="form-group">
                                          <!--aca debe ir el q ingresa estos datos en este caso el que este logeado -->
                                            <label >Responsable</label>
                    <input type="text" class="form-control" id="resp" name="revici" placeholder="" value="<?php echo $_SESSION['user'] ?>" readonly="true">
                                            <input type="hidden" class="form-control" id="resp" name="revicion4" placeholder=""  value="<?php echo $_SESSION['id'] ?>" readonly="true">
                                          </div>
                                        </div>
                                <?php } ?>
                                        <div class="form-group">
                                                <input type="hidden" class="form-control" name="foto_admin"  required>
                                        </div>
                                        
                                        
                                            <div class="form-group" id="alerta">

                                            </div>
                                        
                                        
                                </div>
                            </div>
                                                  
                          <div class="modal-footer">
                            <input  class="btn btn-naranja" value="Actualizar" onclick="javascript:modificarcliente();"/>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                          </div>                          
                        <!--</form> -->
                        
                      </div>
                      
                    </div>
                  </div>
                </div> <!-- edit modal-->


            
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Core Scripts - Include with every page -->
    
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>

   
    
   

    <!-- SB Admin Scripts - Include with every page -->
    <script src="js/sb-admin.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    $(document).ready(function() {

        
       	  
    });
	
	
    </script>

</body>

</html>
<?php }else{ ?>
<script>location.href = "inicio_sesion.php";</script>
<?php } ?>
