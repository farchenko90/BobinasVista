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
    <link href="css/alertify.core.css" rel="stylesheet"/>
    <link href="css/alertify.default.css" rel="stylesheet"/>
    
    <script src="js/jquery-1.11.0.min.js" type="text/javascript"></script>
    <script src="Jsserver/Server.js" type="text/javascript"></script>
    <script src="Jsserver/ClienteServer.js" type="text/javascript"></script>
    <script src="Jsserver/MotorServer.js" type="text/javascript"></script>
    <script src="Jsserver/UsuarioServer.js" type="text/javascript"></script>
    <script src="js/alertify.js" type="text/javascript"></script>
    
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
    
    $(document).ready(function(){
        
        var cc = document.getElementsByName("ced")[0].value;
        
        
        verdatostipousuario(cc);
        
        cargarTabla();
    });
    
    function initTabla(){
            //CONVERTIMOS NUESTRO LISTADO DE LA FORMA DEL JQUERY.DATATABLES- PASAMOS EL ID DE LA TABLA
            $('#dataTables-example').dataTable({
                //"sPaginationType": "full_numbers" //DAMOS FORMATO A LA PAGINACION(NUMEROS)
            });
        }
    
    function cargarTabla(){
            var cc = document.getElementsByName("ced")[0].value;
        
            jQuery.ajax({
                     type: "GET",
                     url: servidor+"transformado/historial", 
                     dataType: "json",
                     success: function (data, status, jqXHR) {
                         vecCC = data;
                         var tabla = document.getElementById("tbodytabla");//dataTables-example
                         tabla.innerHTML = "";
                         if(data==null){
                            initTabla();
                         }
                         for(var i = 0; i < data.length ; i++){
                             var accion = "";
                             var color = "red";
                             
                             if (data[i].Estado == "Terminado"){
                                color = "green";
                             }
                             
                             //notificacion();
                             tabla.innerHTML += "<tr>"+
                             "<td>"+data[i].Placa+"</td>"+
                             "<td>"+data[i].Marca+"</td>"+
                             "<td>"+data[i].NomCliente+"</td>"+
                             "<td>"+data[i].Facor+"</td>"+
                             "<td>"+data[i].Fterm+"</td>"+
                             "<td><p style='color:"+color+"; font-size:17px'>"+data[i].Estado+"</p></td>"+    
                             "<td>"+data[i].Tipo+"</td>"+    
                             "<td>"+data[i].NomUsu+"</td>"
                            
                         }
                         initTabla();
                     },
                     error: function (jqXHR, status) {
                         initTabla();
                         //alert("error cargar tabla");
                     }
                });
            //initTabla();
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
                    <li class="" >
                        <a href="menu_admin_motores.php" style="background-color: rgb(125, 185, 185);">
                        <img src="img/engine22.png"  alt="Motores" title="Motores" >
                        </a>
                    </li>
                    <li class="" >
                        <a href="menu_admin_transformador.php" style="  background-color: rgb(146, 62, 63);"> 
                        <img src="img/transformadores.png"  title="Transformadores" alt="Transformadores" style>
                       </a>
                    </li>
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
                
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Historial Registrado
                        </div>

                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-condensed  table-hover table-bordered" id="dataTables-example">
                                    <thead>
                                        <tr class="fa-rosa danger" >
                                            <th>N° Placa</th>
                                            <th>Marca</th>
                                            <th>Cliente</th>
                                            <th title="fecha de ingreso">F. ingreso</th>
                                            <th title="fecha acordada de entrega">F. a. Entrega</th>
                                            <th>Estado</th>
                                            <th>T.Entrada</th>
                                            <th>Responsable</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody class="" id="tbodytabla">
                                        
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
                        <h3 class="modal-title" id="myModalLabel">Nuevo Motor</h3>
                      </div>                     
                      
                      <div class="modal-body">
                      <p class="help-block">Los campos marcados con * son obligatorios</p>
                      <form role="form" action="#">
                          <div class="row ">
                              <div class="col-xs-12 col-sm-3" >
                              
                                  <div class="form-group">
                                <label >Foto Motor</label>
                                  <a href="foto_motor/motor1.jpg" target="_blank" ><div style="margin:auto;">
                                  <img src="foto_motor/motor1.jpg" style="max-width:100%; " title="Ver imagen"></div>
                                  </a>
                                    <input type="file" class="form-control" id="" name="foto_user" placeholder="Foto del usuario" >
                                  </div>
                              </div>
                                <div class="col-xs-12 col-sm-9">
                                  <div class="">
                                        <div class="col-xs-6 col-sm-6"> 
                                          <div class="form-group">
                                            <label >Nombre del Cliente</label>
                                            <input type="text" class="form-control" id="" name="nomb_user" placeholder="Nombre de la persona" required>
                                          </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                           <div class="form-group">
                                            <label >Dirección</label>
                                            <input type="text" class="form-control" id="" name="apelli_user" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                          <div class="form-group">
                                            <label >Ciudad</label>
                                            <input type="number" class="form-control" id="" name="docu_user" placeholder="" required>
                                            
                                          </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                           <div class="form-group">
                                            <label >Telefono</label>
                                            <input type="tel" class="form-control" id="" name="tel_user" placeholder="numero de telefono">
                                          </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                          <div class="form-group">
                                            <label >Fecha de ingreso</label>
                                            <input type="date" class="form-control" id="" name="email_user" placeholder="" >
                                          </div>
                                        </div>
                                        
                                        <div class="col-xs-6 col-sm-6">
                                          <div class="form-group">
                                            <label >N.S</label>
                                            <input type="text" class="form-control" id="" name="pass_user" placeholder=""  required>
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
                                            <input type="text" class="form-control" id="" name="nomb_user" placeholder="" required>
                                          </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                           <div class="col-xs-6">
                                               <div class="form-group">
                                                  <label >HP</label>
                                                  <input type="text" class="form-control" id="" name="apelli_user" placeholder="" required>
                                               </div> 
                                           </div> 
                                           <div class="col-xs-6">
                                               <div class="form-group">
                                                  <label >KW</label>
                                                  <input type="text" class="form-control" id="" name="apelli_user" placeholder="" required>
                                               </div> 
                                           </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                          <div class="form-group">
                                            <label >R.P.M</label>
                                            <input type="number" class="form-control" id="" name="docu_user" placeholder="" required>
                                            
                                          </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                           <div class="form-group">
                                            <label >N° de fases</label>
                                            <input type="tel" class="form-control" id="" name="tel_user" placeholder="">
                                          </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                           <div class="col-xs-7">
                                               <div class="form-group">
                                                  <label >Tp. Entrada</label>
                                                  <select class="form-control" name="tipo_usuario" title="Seleccione un tipo de entrada" required>
                                                        <option value="motor" selected>Rebobinado</option>
                                                        <option value="Jefe_motor">Mantenimiento</option>
                                                  </select>
                                               </div> 
                                           </div> 
                                           <div class="col-xs-5">
                                               <div class="form-group">
                                                  <label >Revision</label>
                                                  <select class="form-control" name="tipo_usuario" title="Seleccione un tipo de entrada" required>
                                                        <option value="motor" selected>Si</option>
                                                        <option value="Jefe_motor">No</option>
                                                  </select
                                               </div> 
                                           </div>
                                        </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                          <div class="form-group">
                                            <label >Cotizado</label>
                                            <input type="text" class="form-control" id="" name="pass_user" placeholder=""  required>
                                          </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                          <div class="form-group">
                                            <label >Autirizado</label>
                                            <input type="text" class="form-control" id="" name="pass_user" placeholder=""  required>
                                          </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                          <div class="form-group">
                                            <label >F. acordada entrega</label>
                                            <input type="date" class="form-control" id="" name="email_user" placeholder="" >
                                          </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                          <div class="form-group">
                                            <label >F. terminacion servicio</label>
                                            <input type="date" class="form-control" id="" name="email_user" placeholder="" >
                                          </div>
                                        </div>
                                        
                                        <div class="col-xs-6 col-sm-6">
                                          <div class="form-group">
                                          <!--aca debe ir el q ingresa estos datos en este caso el que este logeado -->
                                            <label >Responsable</label>
                                            <input type="text" class="form-control" id="" name="pass_user" placeholder=""  readonly="true" value="Admin logeado">
                                          </div>
                                        </div>

                                </div>
                            </div>
                                                  
                          <div class="modal-footer">
                          	<button type="submit" class="btn btn-naranja" >Guardar</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                          </div>                          
                        </form> 
                        
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