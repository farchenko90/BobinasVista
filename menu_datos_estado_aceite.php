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
    <link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
    <link href="css/sb-admin.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/toastr.css">
    
    <script src="js/jquery-1.11.0.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/toastr.min.js"></script>
    <script src="Jsserver/Server.js" type="text/javascript"></script>
    <script src="Jsserver/ListaServer.js" type="text/javascript"></script>
    <script src="Jsserver/ClienteServer.js" type="text/javascript"></script>
    <script src="Jsserver/MotorServer.js" type="text/javascript"></script>
    <script src="Jsserver/UsuarioServer.js" type="text/javascript"></script>
    <script src="Jsserver/Reparacion_Trasn.js" type="text/javascript"></script>
    <script src="Jsserver/TransformadorServer.js" type="text/javascript"></script>
    
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

</style>

<script>
    
    var banInsert = true;
    var idEstadoAceite = 0;
    
    var estadobobina = true;
    
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
    var id = getGET();
    $(document).ready(function(){
        //tablareparacion(geturl);
        cc = document.getElementsByName("ced")[0].value;
        verdatostipousuario(cc);
        
        if(id!=null){
            geturl = id['id'];
            tablareparacion(id['id']);
            //cambiarestadotransf(geturl);
            //consultardatos(id['id']);
            CargarTrabajadorTrans(id['id']);
        }else{
            location.href = "menu_admin_transformador.php";
        }    
    });
    
    function initTabla(){
        //CONVERTIMOS NUESTRO LISTADO DE LA FORMA DEL JQUERY.DATATABLES- PASAMOS EL ID DE LA TABLA
        $('#dataTables-example').dataTable({
            //"sPaginationType": "full_numbers" //DAMOS FORMATO A LA PAGINACION(NUMEROS)
        });
    }
    
    function initBanInsert(){
        banInsert = true;
        document.getElementById("fecha").value = "";
        document.getElementById("pasada_arena").value = "";
        document.getElementById("tiempo_filtro").value = "";
        document.getElementById("temperatura_max").value = "";
        document.getElementById("color").value = "";
        document.getElementById("tiempo_reposo_ini").value = "";
        document.getElementById("kv1").value = "";
        document.getElementById("kv2").value = "";
        document.getElementById("kv3").value = "";
        document.getElementById("kv4").value = "";
        document.getElementById("kv5").value = "";
        document.getElementById("kv6").value = "";
        document.getElementById("kv_total").value = "";
        document.getElementById("tiempo_reposo1").value = "";
        document.getElementById("tiempo_reposo2").value = "";
        document.getElementById("tiempo_reposo3").value = "";
        document.getElementById("tiempo_reposo4").value = "";
        document.getElementById("tiempo_reposo5").value = "";
        document.getElementById("tiempo_reposo6").value = "";
        document.getElementById("tiempo_reposo_total").value = "";
        document.getElementById("escala_chispometro").value = "";
        document.getElementById("aceite_trans").value = "";
        document.getElementById("observaciones").value = "";
    }
    
    function guardar_o_update(){
        if (banInsert){
            guardarEstadoAceite();
        }else{
            updateEstadoAceite(idEstadoAceite);
        }
    }
    
    function cerrar(){
        
        estadobobina = false;
        document.getElementById("fecha").disabled = true;
        document.getElementById("pasada_arena").disabled = true;
        document.getElementById("tiempo_filtro").disabled = true;
        document.getElementById("temperatura_max").disabled = true;
        document.getElementById("color").disabled = true;
        document.getElementById("tiempo_reposo_ini").disabled = true;
        document.getElementById("kv1").disabled = true;
        document.getElementById("kv2").disabled = true;
        document.getElementById("kv3").disabled = true;
        document.getElementById("kv4").disabled = true;
        document.getElementById("kv5").disabled = true;
        document.getElementById("kv6").disabled = true;
        document.getElementById("kv_total").disabled = true;
        document.getElementById("tiempo_reposo1").disabled = true;
        document.getElementById("tiempo_reposo2").disabled = true;
        document.getElementById("tiempo_reposo3").disabled = true;
        document.getElementById("tiempo_reposo4").disabled = true;
        document.getElementById("tiempo_reposo5").disabled = true;
        document.getElementById("tiempo_reposo6").disabled = true;
        document.getElementById("tiempo_reposo_total").disabled = true;
        document.getElementById("escala_chispometro").disabled = true;
        document.getElementById("aceite_trans").disabled = true;
        document.getElementById("observaciones").disabled = true;
        
    }
    
    function cargarDatosUpdate(data,i){
        banInsert = false;
        idEstadoAceite = data[i].id;
        document.getElementById("fecha1").value = data[i].fecha;
        document.getElementById("pasada_arena1").value = data[i].pasada_arena;
        document.getElementById("tiempo_filtro1").value = data[i].tiempo_filtro;
        document.getElementById("temperatura_max1").value = data[i].temperatura_max;
        document.getElementById("color1").value = data[i].color;
        document.getElementById("tiempo_reposo_ini1").value = data[i].tiempo_reposo_ini;
        document.getElementById("kv11").value = data[i].kv1;
        document.getElementById("kv21").value = data[i].kv2;
        document.getElementById("kv31").value = data[i].kv3;
        document.getElementById("kv41").value = data[i].kv4;
        document.getElementById("kv51").value = data[i].kv5;
        document.getElementById("kv61").value = data[i].kv6;
        document.getElementById("kv_total1").value = data[i].kv_total;
        document.getElementById("tiempo_reposo11").value = data[i].tiempo_reposo1;
        document.getElementById("tiempo_reposo21").value = data[i].tiempo_reposo2;
        document.getElementById("tiempo_reposo31").value = data[i].tiempo_reposo3;
        document.getElementById("tiempo_reposo41").value = data[i].tiempo_reposo4;
        document.getElementById("tiempo_reposo51").value = data[i].tiempo_reposo5;
        document.getElementById("tiempo_reposo61").value = data[i].tiempo_reposo6;
        document.getElementById("tiempo_reposo_total1").value = data[i].tiempo_reposo_total;
        document.getElementById("escala_chispometro1").value = data[i].escala_chispometro;
        document.getElementById("aceite_trans1").value = data[i].aceite_trans;
        document.getElementById("observaciones1").value = data[i].observaciones;
    }
    
    function eliminarEstadoAceit(id){
        var r = confirm("Desea eliminar el registro con id # "+ id);
        if (r == true) {
            deleteEstadoAceite(id);
        }
    }
    
    function tablareparacion(idtra){
        jQuery.ajax({
             type: "GET",
             url: servidor+"estadoAceiteTransformador/"+idtra, 
             dataType: "json",
             success: function (data, status, jqXHR) {
                 //vecCC = data;
                 var tabla = document.getElementById("tbodytabla1");//dataTables-example
                 tabla.innerHTML = "";
                 //alert(JSON.stringify(data));
                 if(data==null){
                    initTabla();
                 }else{
                    
                 
                 
                 for(var i = 0; i < data.length ; i++){
                     var color = "red";
                    if (data[i].estado == "Terminado"){
                        color = "green";
                        cambiarestadotransf(geturl);
                    }
                     
                     cerrar();
                     tabla.innerHTML += "<tr>"+
                     "<td>"+data[i].id+"</td>"+
                     "<td>"+data[i].fecha+"</td>"+
                     "<td>"+data[i].tiempo_reposo_ini+"</td>"+
                     "<td>"+data[i].tiempo_reposo_total+"</td>"+
                     "<td>"+data[i].escala_chispometro+"</td>"+
                     "<td>"+data[i].kv_total+"</td>"+
                     "<td><p style='color:"+color+"; font-size:17px'>"+data[i].estado+"</p></td>"+
                     "<td>"+data[i].responsable+"</td>"+   
                     "<td class='center'>"+"\<a title='Siguiente' href='menu_datos_estado_transformador.php?id=" + id['id'] + "' class='btn btn-primary  btn-sm' >\n\
                             <i class='fa fa-eye fa-2x fa-fw' id=''></i></a>\n\
         <a href='#' title='Eliminar' class='btn btn-danger btn-sm' id='' \n\
onclick='javascript:eliminarEstadoAceit("+ data[i].id + ")'>\n\
<i class='fa fa-2x fa-eraser fa-fw'></i> </a>\n\
<a onclick='cargarDatosUpdate(" + JSON.stringify(data) + ", " + i + ")' title='Editar' class='btn btn-success  btn-sm' data-toggle='modal' data-target='#modificar_motor' ><i class='fa fa-edit fa-2x fa-fw' ></i></a>"+"</td></tr>";
                            
                 }
                         initTabla();
                     }
             },
             error: function (jqXHR, status) {
                 initTabla();
                 //alert("error cargar tabla");

             }
        });
    }
    
    
    function volver(){
        location.href = ruta + "menu_admin_transformador.php";
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
                
                    <h1 class="fa-rosa" style="border-bottom: 1px solid #eee;" id="tipouser"></h1>
                    
                   
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                <div class="well">
                        <button onclick="initBanInsert()" type="button" class="btn btn-naranja" data-toggle="modal" data-target="#agrega_motor"><i class="fa fa-plus fa-fw "></i> Agregar Datos De Estado de Aceite</button>
                        <button type="button" class="btn btn-naranja" onclick="javascript:volver();">
                                <i class="fa fa-reply"></i> Volver</button>
                </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Estados registrados
                        </div>

                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-condensed  table-hover table-bordered" id="dataTables-example">
                                    <thead>
                                        <tr class="fa-rosa danger" >
                                            <th>Id</th>
                                            <th>Fecha</th>
                                            <th>Tiempo reposo inicial</th>
                                            <th>Tiempo reposo total</th>
                                            <th>Escala chispometro</th>
                                            <th>KV total</th>
                                            <th>Estado</th>
                                            <th>Responsable</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="" id="tbodytabla1">
                                        
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                            <?php 
                    echo "<input type='hidden' name='ced' value='".$_SESSION['id']."'";
                ?>
                                
                                <!-- Modal -->
                <div class="modal fade" id="agrega_motor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header" style="background:#d66e2b;">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title" id="myModalLabel">Estado de aceite de transformadores</h3>
                      </div>                     
                      
                      <div class="modal-body">
                      <p class="help-block"></p>
                      <!--<form role="form" action="#">-->
                          <div class="row ">
                                <div class="col-xs-12 col-sm-9" style="margin-left:0px;">
                                  <div class="">
                                        <div class="col-xs-12 col-md-8" >
                                           <div class="form-group">
                                            <label >Fecha</label>
                                            <input type="date" class="form-control" id="fecha" name="fechaingreso" placeholder="" required>
                                          </div>  
                                        </div>
                                       
                                    </div>
                                
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-sm-12" style="background:#d66e2b;">
                                    <h3 class="modal-title" style="color:#fff;">Inspección visual</h3>
                                </div>
                                <div class="col-sm-12">
                                    
                                        <div class="col-xs-6 col-md-6" >
                                           <div class="form-group">
                                            <label >Pasada por arena</label>
                                            <input type="text" class="form-control" id="pasada_arena" name="largorepa" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-6" >
                                           <div class="form-group">
                                            <label >Tiempo de filtro prensado</label>
                                            <input type="text" class="form-control" id="tiempo_filtro" name="anchorepa" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-6" >
                                           <div class="form-group">
                                            <label >Temperatura máxima</label>
                                            <input type="text" class="form-control" id="temperatura_max" name="largorepa" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-6" >
                                           <div class="form-group">
                                            <label >Color</label>
                                            <input type="text" class="form-control" id="color" name="anchorepa" placeholder="" required>
                                          </div>  
                                        </div>

                                </div>
                            </div>
                            <!--  Bobina Segundaria---->
                            
                            <div class="row">
                                <div class="col-sm-12" style="background:#d66e2b;">
                                    <h3 class="modal-title" style="color:#fff;">Resultados de pruebas (chispometro)</h3>
                                </div>
                                <div class="col-sm-12">
                                        <div class="col-xs-6 col-md-12" >
                                           <div class="form-group">
                                            <label >Tiempo de reposo inicial</label>
                                            <input type="text" class="form-control" id="tiempo_reposo_ini" name="largo1" placeholder="" required>
                                          </div>  
                                        </div>
                                    
                                       
                                    
                                        <div class="col-xs-6 col-md-3" >
                                           <div class="form-group">
                                            <label >No.</label>
                                           </div>  
                                        </div>
                                    
                                        <div class="col-xs-6 col-md-3" >
                                           <div class="form-group">
                                            <label >KV</label>
                                           </div>  
                                        </div>
                                    
                                        <div class="col-xs-6 col-md-6" >
                                           <div class="form-group">
                                            <label >Tiempo reposo entre pruebas</label>
                                           </div>  
                                        </div>
                                    
                                        <div class="col-xs-6 col-md-3" >
                                           <div class="form-group">
                                               <label >1</label>
                                           </div>  
                                        </div>
                                    
                                        <div class="col-xs-6 col-md-3" >
                                           <div class="form-group">
                                            <input type="number" class="form-control" id="kv1" name="largo1" placeholder="" required>
                                           </div>  
                                        </div>
                                    
                                        <div class="col-xs-6 col-md-6" >
                                           <div class="form-group">
                                            <input type="text" class="form-control" id="tiempo_reposo1" name="largo1" placeholder="" required>
                                           </div>  
                                        </div>
                                    
                                        <div class="col-xs-6 col-md-3" >
                                           <div class="form-group">
                                               <label >2</label>
                                           </div>  
                                        </div>
                                    
                                        <div class="col-xs-6 col-md-3" >
                                           <div class="form-group">
                                            <input type="number" class="form-control" id="kv2" name="largo1" placeholder="" required>
                                           </div>  
                                        </div>
                                    
                                        <div class="col-xs-6 col-md-6" >
                                           <div class="form-group">
                                            <input type="text" class="form-control" id="tiempo_reposo2" name="largo1" placeholder="" required>
                                           </div>  
                                        </div>
                                    
                                        <div class="col-xs-6 col-md-3" >
                                           <div class="form-group">
                                               <label >3</label>
                                           </div>  
                                        </div>
                                    
                                        <div class="col-xs-6 col-md-3" >
                                           <div class="form-group">
                                            <input type="number" class="form-control" id="kv3" name="largo1" placeholder="" required>
                                           </div>  
                                        </div>
                                    
                                        <div class="col-xs-6 col-md-6" >
                                           <div class="form-group">
                                            <input type="text" class="form-control" id="tiempo_reposo3" name="largo1" placeholder="" required>
                                           </div>  
                                        </div>
                                    
                                        <div class="col-xs-6 col-md-3" >
                                           <div class="form-group">
                                               <label >4</label>
                                           </div>  
                                        </div>
                                    
                                        <div class="col-xs-6 col-md-3" >
                                           <div class="form-group">
                                            <input type="number" class="form-control" id="kv4" name="largo1" placeholder="" required>
                                           </div>  
                                        </div>
                                    
                                        <div class="col-xs-6 col-md-6" >
                                           <div class="form-group">
                                            <input type="text" class="form-control" id="tiempo_reposo4" name="largo1" placeholder="" required>
                                           </div>  
                                        </div>
                                    
                                        <div class="col-xs-6 col-md-3" >
                                           <div class="form-group">
                                               <label >5</label>
                                           </div>  
                                        </div>
                                    
                                        <div class="col-xs-6 col-md-3" >
                                           <div class="form-group">
                                            <input type="number" class="form-control" id="kv5" name="largo1" placeholder="" required>
                                           </div>  
                                        </div>
                                    
                                        <div class="col-xs-6 col-md-6" >
                                           <div class="form-group">
                                            <input type="text" class="form-control" id="tiempo_reposo5" name="largo1" placeholder="" required>
                                           </div>  
                                        </div>
                                    
                                        <div class="col-xs-6 col-md-3" >
                                           <div class="form-group">
                                               <label >6</label>
                                           </div>  
                                        </div>
                                    
                                        <div class="col-xs-6 col-md-3" >
                                           <div class="form-group">
                                            <input type="number" class="form-control" id="kv6" name="largo1" placeholder="" required>
                                           </div>  
                                        </div>
                                    
                                        <div class="col-xs-6 col-md-6" >
                                           <div class="form-group">
                                            <input type="text" class="form-control" id="tiempo_reposo6" name="largo1" placeholder="" required>
                                           </div>  
                                        </div>
                                    
                                        <div class="col-xs-6 col-md-3" >
                                           <div class="form-group">
                                               <label >Total</label>
                                           </div>  
                                        </div>
                                    
                                        <div class="col-xs-6 col-md-3" >
                                           <div class="form-group">
                                            <input type="number" class="form-control" id="kv_total" name="largo1" placeholder="" required>
                                           </div>  
                                        </div>
                                    
                                        <div class="col-xs-6 col-md-6" >
                                           <div class="form-group">
                                            <input type="text" class="form-control" id="tiempo_reposo_total" name="largo1" placeholder="" required>
                                           </div>  
                                        </div>
                                    
                                        <div class="col-xs-6 col-md-6" >
                                           <div class="form-group">
                                            <label >Escala de chispometro</label>
                                            <input type="text" class="form-control" id="escala_chispometro" name="largo1" placeholder="" required>
                                          </div>  
                                        </div>
                                    
                                        <div class="col-xs-6 col-md-6" >
                                           <div class="form-group">
                                            <label >Aceite transformadores</label>
                                            <input type="text" class="form-control" id="aceite_trans" name="largo1" placeholder="" required>
                                          </div>  
                                        </div>
                                    
                                        <div class="col-xs-6 col-md-12" >
                                           <div class="form-group">
                                            <label >Observaciones</label>
                                            <input type="text" class="form-control" id="observaciones" name="largo1" placeholder="" required>
                                          </div>  
                                        </div>
                                    
                                    
                                        <div class="col-xs-12 col-sm-6 col-md-8"> 
                                          <div class="form-group">
                                            <label >Responsable</label>
                                            <input type="text" class="form-control" id="responsable" name="resposable" placeholder="Nombre de la persona" required readonly="true">
                                            <!--<select class="form-control" name="revicion2" title="" required>
                                                
                                            </select>-->
                                          </div>
                                        </div>

                                        <div class="col-xs-6 col-sm-6">
                                          <div class="form-group" id="alerta">
                                                          
                                          </div>
                                        </div>
                                        
                                </div>
                            </div>                      
                                                                                              
                          <div class="modal-footer"><!----  registrarReparacionTransformador(); -->
                          	<button  class="btn btn-naranja" onclick="javascript:guardar_o_update();">Guardar</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                          </div>                          
                        <!--</form> -->
                        
                      </div>
                      
                    </div>
                  </div>
                </div> <!-- modal-->
                
                        <!-- modificar estado transformador -->
                   
                     <div class="modal fade" id="modificar_motor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header" style="background:#d66e2b;">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title" id="myModalLabel">Estado de aceite de transformadores</h3>
                      </div>                     
                      
                      <div class="modal-body">
                      <p class="help-block"></p>
                      <!--<form role="form" action="#">-->
                          <div class="row ">
                                <div class="col-xs-12 col-sm-9" style="margin-left:0px;">
                                  <div class="">
                                        <div class="col-xs-12 col-md-8" >
                                           <div class="form-group">
                                            <label >Fecha</label>
                                            <input type="date" class="form-control" id="fecha1" name="fechaingreso" placeholder="" required>
                                          </div>  
                                        </div>
                                       
                                    </div>
                                
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-sm-12" style="background:#d66e2b;">
                                    <h3 class="modal-title" style="color:#fff;">Inspección visual</h3>
                                </div>
                                <div class="col-sm-12">
                                    
                                        <div class="col-xs-6 col-md-6" >
                                           <div class="form-group">
                                            <label >Pasada por arena</label>
                                            <input type="text" class="form-control" id="pasada_arena1" name="largorepa" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-6" >
                                           <div class="form-group">
                                            <label >Tiempo de filtro prensado</label>
                                            <input type="text" class="form-control" id="tiempo_filtro1" name="anchorepa" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-6" >
                                           <div class="form-group">
                                            <label >Temperatura máxima</label>
                                            <input type="text" class="form-control" id="temperatura_max1" name="largorepa" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-6" >
                                           <div class="form-group">
                                            <label >Color</label>
                                            <input type="text" class="form-control" id="color1" name="anchorepa" placeholder="" required>
                                          </div>  
                                        </div>

                                </div>
                            </div>
                            <!--  Bobina Segundaria---->
                            
                            <div class="row">
                                <div class="col-sm-12" style="background:#d66e2b;">
                                    <h3 class="modal-title" style="color:#fff;">Resultados de pruebas (chispometro)</h3>
                                </div>
                                <div class="col-sm-12">
                                        <div class="col-xs-6 col-md-12" >
                                           <div class="form-group">
                                            <label >Tiempo de reposo inicial</label>
                                            <input type="text" class="form-control" id="tiempo_reposo_ini1" name="largo1" placeholder="" required>
                                          </div>  
                                        </div>
                                    
                                       
                                    
                                        <div class="col-xs-6 col-md-3" >
                                           <div class="form-group">
                                            <label >No.</label>
                                           </div>  
                                        </div>
                                    
                                        <div class="col-xs-6 col-md-3" >
                                           <div class="form-group">
                                            <label >KV</label>
                                           </div>  
                                        </div>
                                    
                                        <div class="col-xs-6 col-md-6" >
                                           <div class="form-group">
                                            <label >Tiempo reposo entre pruebas</label>
                                           </div>  
                                        </div>
                                    
                                        <div class="col-xs-6 col-md-3" >
                                           <div class="form-group">
                                               <label >1</label>
                                           </div>  
                                        </div>
                                    
                                        <div class="col-xs-6 col-md-3" >
                                           <div class="form-group">
                                            <input type="text" class="form-control" id="kv11" name="largo1" placeholder="" required>
                                           </div>  
                                        </div>
                                    
                                        <div class="col-xs-6 col-md-6" >
                                           <div class="form-group">
                                            <input type="text" class="form-control" id="tiempo_reposo11" name="largo1" placeholder="" required>
                                           </div>  
                                        </div>
                                    
                                        <div class="col-xs-6 col-md-3" >
                                           <div class="form-group">
                                               <label >2</label>
                                           </div>  
                                        </div>
                                    
                                        <div class="col-xs-6 col-md-3" >
                                           <div class="form-group">
                                            <input type="text" class="form-control" id="kv21" name="largo1" placeholder="" required>
                                           </div>  
                                        </div>
                                    
                                        <div class="col-xs-6 col-md-6" >
                                           <div class="form-group">
                                            <input type="text" class="form-control" id="tiempo_reposo21" name="largo1" placeholder="" required>
                                           </div>  
                                        </div>
                                    
                                        <div class="col-xs-6 col-md-3" >
                                           <div class="form-group">
                                               <label >3</label>
                                           </div>  
                                        </div>
                                    
                                        <div class="col-xs-6 col-md-3" >
                                           <div class="form-group">
                                            <input type="text" class="form-control" id="kv31" name="largo1" placeholder="" required>
                                           </div>  
                                        </div>
                                    
                                        <div class="col-xs-6 col-md-6" >
                                           <div class="form-group">
                                            <input type="text" class="form-control" id="tiempo_reposo31" name="largo1" placeholder="" required>
                                           </div>  
                                        </div>
                                    
                                        <div class="col-xs-6 col-md-3" >
                                           <div class="form-group">
                                               <label >4</label>
                                           </div>  
                                        </div>
                                    
                                        <div class="col-xs-6 col-md-3" >
                                           <div class="form-group">
                                            <input type="text" class="form-control" id="kv41" name="largo1" placeholder="" required>
                                           </div>  
                                        </div>
                                    
                                        <div class="col-xs-6 col-md-6" >
                                           <div class="form-group">
                                            <input type="text" class="form-control" id="tiempo_reposo41" name="largo1" placeholder="" required>
                                           </div>  
                                        </div>
                                    
                                        <div class="col-xs-6 col-md-3" >
                                           <div class="form-group">
                                               <label >5</label>
                                           </div>  
                                        </div>
                                    
                                        <div class="col-xs-6 col-md-3" >
                                           <div class="form-group">
                                            <input type="text" class="form-control" id="kv51" name="largo1" placeholder="" required>
                                           </div>  
                                        </div>
                                    
                                        <div class="col-xs-6 col-md-6" >
                                           <div class="form-group">
                                            <input type="text" class="form-control" id="tiempo_reposo51" name="largo1" placeholder="" required>
                                           </div>  
                                        </div>
                                    
                                        <div class="col-xs-6 col-md-3" >
                                           <div class="form-group">
                                               <label >6</label>
                                           </div>  
                                        </div>
                                    
                                        <div class="col-xs-6 col-md-3" >
                                           <div class="form-group">
                                            <input type="text" class="form-control" id="kv61" name="largo1" placeholder="" required>
                                           </div>  
                                        </div>
                                    
                                        <div class="col-xs-6 col-md-6" >
                                           <div class="form-group">
                                            <input type="text" class="form-control" id="tiempo_reposo61" name="largo1" placeholder="" required>
                                           </div>  
                                        </div>
                                    
                                        <div class="col-xs-6 col-md-3" >
                                           <div class="form-group">
                                               <label >Total</label>
                                           </div>  
                                        </div>
                                    
                                        <div class="col-xs-6 col-md-3" >
                                           <div class="form-group">
                                            <input type="text" class="form-control" id="kv_total1" name="largo1" placeholder="" required>
                                           </div>  
                                        </div>
                                    
                                        <div class="col-xs-6 col-md-6" >
                                           <div class="form-group">
                                            <input type="text" class="form-control" id="tiempo_reposo_total1" name="largo1" placeholder="" required>
                                           </div>  
                                        </div>
                                    
                                        <div class="col-xs-6 col-md-6" >
                                           <div class="form-group">
                                            <label >Escala de chispometro</label>
                                            <input type="text" class="form-control" id="escala_chispometro1" name="largo1" placeholder="" required>
                                          </div>  
                                        </div>
                                    
                                        <div class="col-xs-6 col-md-6" >
                                           <div class="form-group">
                                            <label >Aceite transformadores</label>
                                            <input type="text" class="form-control" id="aceite_trans1" name="largo1" placeholder="" required>
                                          </div>  
                                        </div>
                                    
                                        <div class="col-xs-6 col-md-12" >
                                           <div class="form-group">
                                            <label >Observaciones</label>
                                            <input type="text" class="form-control" id="observaciones1" name="largo1" placeholder="" required>
                                          </div>  
                                        </div>
                                    
                                    
                                        <div class="col-xs-12 col-sm-6 col-md-8"> 
                                          <div class="form-group">
                                            <label >Responsable</label>
                                            <input type="text" class="form-control" id="responsable1" name="resposable1" placeholder="Nombre de la persona" required readonly="true">
                                            <!--<select class="form-control" name="revicion2" title="" required>
                                                
                                            </select>-->
                                          </div>
                                        </div>
                                </div>
                            </div>                      
                                                                                              
                          <div class="modal-footer"><!----  registrarReparacionTransformador(); -->
                          	<button  class="btn btn-naranja" onclick="javascript:guardar_o_update();">Guardar</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                          </div>                          
                        <!--</form> -->
                        
                      </div>
                      
                    </div>
                  </div>
                </div> <!-- modal-->
                
                
                            </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            
            
            
            
            
            
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Core Scripts - Include with every page -->
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>

    <!-- Page-Level Plugin Scripts - Tables -->
    <script src="js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>

    <!-- SB Admin Scripts - Include with every page -->
    <script src="js/sb-admin.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    /*$(document).ready(function() {
        $('#dataTables-example').dataTable();
		//selecciona el color dependiendo el tipo de usuario
					  
			  $('.tpu p').addClass("label label-info");			  
    });*/
	
	
    </script>

</body>

</html>
<?php }else{ ?>
<script>location.href = "inicio_sesion.php";</script>
<?php } ?>