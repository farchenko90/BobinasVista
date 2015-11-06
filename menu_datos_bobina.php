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

    <script src="js/jquery-1.10.2.js"></script>
    <script type="text/javascript" src="js/toastr.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>

    

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
            consultardatos(id['id']);
            CargarTrabajadorTrans(id['id']);

        }else{
            location.href = "menu_datos_bobina.php";
        }    
    });
    
    function initTabla(){
        //CONVERTIMOS NUESTRO LISTADO DE LA FORMA DEL JQUERY.DATATABLES- PASAMOS EL ID DE LA TABLA
        $('#dataTables-example').dataTable({
            //"sPaginationType": "full_numbers" //DAMOS FORMATO A LA PAGINACION(NUMEROS)
        });
    }
    
    function cerrar(){
        
        estadobobina = false;
        
        document.getElementsByName("largo1")[0].disabled = true;          
        document.getElementsByName("ancho1")[0].disabled = true;
        document.getElementsByName("refri1")[0].disabled = true;
        document.getElementsByName("bisel1")[0].disabled = true;
        document.getElementsByName("fibra1")[0].disabled = true;
        document.getElementsByName("n2")[0].disabled = true;
        document.getElementsByName("bobinas")[0].disabled = true;
        document.getElementsByName("otros1")[0].disabled = true;
        document.getElementsByName("nsecuncia")[0].disabled = true;
        document.getElementsByName("poteciapri")[0].disabled = true;
        document.getElementsByName("vprimario")[0].disabled = true;
        document.getElementsByName("vsegundario")[0].disabled = true;
        document.getElementsByName("tipoconductorrepa")[0].disabled = true;
        
        document.getElementsByName("largorepa")[0].disabled = true;           
        document.getElementsByName("anchorepa")[0].disabled = true;
        document.getElementsByName("alturepa")[0].disabled = true;
        document.getElementsByName("refrirepa")[0].disabled = true;
        document.getElementsByName("biselrepa")[0].disabled = true;
        document.getElementsByName("fibrarepa")[0].disabled = true;
        document.getElementsByName("calirepa")[0].disabled = true;
        document.getElementsByName("otrorepa")[0].disabled = true;
        document.getElementsByName("nsecuncia")[0].disabled = true;
        document.getElementsByName("poteciapri")[0].disabled = true;
        document.getElementsByName("vprimario")[0].disabled = true;
        document.getElementsByName("vsegundario")[0].disabled = true;
        
    }
    
    function tablareparacion(idtra){
        jQuery.ajax({
             type: "GET",
             url: servidor+"reparacion/"+idtra, 
             dataType: "json",
             success: function (data, status, jqXHR) {
                 //vecCC = data;
                 var tabla = document.getElementById("tbodytabla1");//dataTables-example
                 tabla.innerHTML = "";
                 //alert(JSON.stringify(data));
                 if(data==null){
                    initTabla();
                 }else{
                    cerrar();
                 
                 //cambiarestadotransf(geturl);
                 for(var i = 0; i < data.length ; i++){
                     var accion = "";
                     var color = "red";
                     
                     if (data[0].Estado == "Terminado"){
                        color = "red"; 
                     }if(data[1].Estado == "Terminado"){
                        color = "red";
                     }if (data[0].Estado == "Terminado" && data[1].Estado == "Terminado"){
                        color = "green";
                        cambiarestadotransf(geturl);
                     }
                     tabla.innerHTML += "<tr>"+
                     "<td>"+data[i].Nom_cliente+"</td>"+
                     "<td>"+data[i].Fecha+"</td>"+
                     "<td>"+data[i].Nplaca+"</td>"+
                     "<td>"+data[i].TipoPS+"</td>"+
                     "<td>"+data[i].primario+"</td>"+
                     "<td>"+data[i].segundario+"</td>"+
                     "<td><p style='color:"+color+"; font-size:17px'>"+data[i].Estado+"</p></td>"+    
                     "<td>"+data[i].Tipo+"</td>"+    
                     "<td>"+data[i].Nom_usu+"</td>"+     
                     "<td class='center'>"+"<a href='menu_datos_primaria.php?id="+data[i].Id+"' \n\
                     title='Siguiente' class='btn btn-primary  btn-sm' ><i class='fa fa-eye fa-2x fa-fw' id=''></i></a>"+
                     "<a title='modificar' onClick='javascript:primariasegundaria("+JSON.stringify(data)+", "+i+")' class='btn btn-success btn-sm' data-toggle='modal' data-target='#primaria'>\n\
                     <i class='fa fa-edit fa-2x fa-fw' id=''></i></a></td></tr>";
                            
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
    ///data-toggle='modal' data-target='#primaria'
    function primariasegundaria(data,i){
            DatosReparacion(data[i].Id);    
            DatosTransformador(data[i].Id);   
            orden(data[i].TipoPS);
    }



    function volver(){
        location.href = ruta + "menu_admin_transformador.php";
    }
    
    /*
*Datos del modal menu del dato de primaria
*/
function DatosTransformador(id){
    jQuery.ajax({
         type: "GET",
         url: servidor+"transformador/"+id, 
         dataType: "json",
         success: function (data, status, jqXHR) {
             if(data!=null){
                 
                for(var i=0;i < data.length; i++){

                    document.getElementsByName("nomcliente1")[0].value = data[i].NomCliente;
                    document.getElementsByName("fechaingreso1")[0].value = data[i].Fecha;
                    document.getElementsByName("nsecuncia1")[0].value = data[i].NSecuencia;
                    document.getElementsByName("poteciapri1")[0].value = data[i].Potencia;
                    document.getElementsByName("vprimario1")[0].value = data[i].Primario;
                    document.getElementsByName("vsegundario1")[0].value = data[i].Segundario;
                    document.getElementsByName("marcatrans1")[0].value = data[i].Marca;
                    
                    
                    
                }
                 
             }
         },
         error: function (jqXHR, status) {
             alert("error buscar user");
         }
    });
    
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
                        <button type="button" class="btn btn-naranja" data-toggle="modal" data-target="#agrega_motor"><i class="fa fa-plus fa-fw "></i> Agregar Datos De Bobina</button>
                        <button type="button" class="btn btn-naranja" onclick="javascript:volver();">
                                <i class="fa fa-reply"></i> Volver</button>
                        </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Bobinas Registradas
                        </div>

                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-condensed  table-hover table-bordered" id="dataTables-example">
                                    <thead>
                                        <tr class="fa-rosa danger" >
                                            <th>Nombre Cliente</th>
                                            <th>Fecha Ingreso</th>
                                            <th>N# placa</th>
                                            <th>Tipo</th>
                                            <th>V. Primario</th>
                                            <th>V. Segundario</th>
                                            <th>Estado</th>
                                            <th>T.Entrada</th>
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
                        <h3 class="modal-title" id="myModalLabel">Datos de bobina primaria y segundaria</h3>
                      </div>                     
                      
                      <div class="modal-body">
                      <p class="help-block"></p>
                      <!--<form role="form" action="#">-->
                          <div class="row ">
                                <div class="col-xs-12 col-sm-9" style="margin-left:30px;">
                                  <div class="">
                                        <div class="col-xs-12 col-sm-6 col-md-8"> 
                                          <div class="form-group">
                                            <label >Nombre del Cliente</label>
                                            <input type="text" class="form-control" id="" name="nomcliente" placeholder="Nombre de la persona" required readonly="true">
                                          </div>
                                        </div>
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >Fecha</label>
                                            <input type="text" class="form-control" id="" name="fechaingreso" placeholder="" required readonly="true">
                                          </div>  
                                        </div>
                                        
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >N° Secuencia</label>
                                            <input type="text" class="form-control" id="" name="nsecuncia" placeholder="" required>
                                          </div>  
                                        </div>
                                        
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >Potencia</label>
                                            <input type="text" class="form-control" name="poteciapri" placeholder="" required>
                                          </div>  
                                        </div>
                                        
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >V Primario</label>
                                            <input type="text" class="form-control" id="" name="vprimario" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >V Segundario</label>
                                            <input type="text" class="form-control" id="" name="vsegundario" placeholder="" required>
                                          </div>  
                                        </div>
                                        
                                        
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >Marca</label>
                                            <input type="text" class="form-control" id="" name="marcatrans" placeholder="" required readonly="true">
                                          </div>  
                                        </div>
                                       
                                    </div>
                                
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-sm-12" style="background:#d66e2b;">
                                    <h3 class="modal-title" style="color:#fff;">Bobina Primaria</h3>
                                </div>
                                <div class="col-sm-12">
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >Largo</label>
                                            <input type="text" class="form-control" id="" name="largorepa" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >Ancho</label>
                                            <input type="text" class="form-control" id="" name="anchorepa" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >Altura</label>
                                            <input type="text" class="form-control" id="" name="alturepa" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >Refrigeracion</label>
                                            <input type="text" class="form-control" id="" name="refrirepa" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >Bisel</label>
                                            <input type="text" class="form-control" id="" name="biselrepa" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >Fibra</label>
                                            <input type="text" class="form-control" id="" name="fibrarepa" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >Calibre</label>
                                            <input type="text" class="form-control" id="" name="calirepa" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >Otro</label>
                                            <input type="text" class="form-control" id="" name="otrorepa" placeholder="" required>
                                          </div>  
                                        </div>

                                </div>
                            </div>
                            <!--  Bobina Segundaria---->
                            
                            <div class="row">
                                <div class="col-sm-12" style="background:#d66e2b;">
                                    <h3 class="modal-title" style="color:#fff;">Bobina Segundaria</h3>
                                </div>
                                <div class="col-sm-12">
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >Largo</label>
                                            <input type="text" class="form-control" id="" name="largo1" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >Ancho</label>
                                            <input type="text" class="form-control" id="" name="ancho1" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >Tipo Conductor</label>
                                            <input type="text" class="form-control" id="" name="tipoconductorrepa" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >Refrigeracion</label>
                                            <input type="text" class="form-control" id="" name="refri1" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >Fibra</label>
                                            <input type="text" class="form-control" id="" name="fibra1" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >Bisel</label>
                                            <input type="text" class="form-control" id="" name="bisel1" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >N2</label>
                                            <input type="text" class="form-control" id="" name="n2" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >Bobina</label>
                                            <input type="text" class="form-control" id="" name="bobinas" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >Otro</label>
                                            <input type="text" class="form-control" id="" name="otros1" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-8"> 
                                          <div class="form-group">
                                            <label >Responsable</label>
                                            <input type="text" class="form-control" id="" name="resposable" placeholder="Nombre de la persona" required readonly="true">
                                            <!--<select class="form-control" name="revicion2" title="" required>
                                                
                                            </select>-->
                                          </div>
                                        </div>
                                </div>
                            </div>                      
                                                                                              
                          <div class="modal-footer"><!----  registrarReparacionTransformador(); -->
                          	<button  class="btn btn-naranja" onclick="javascript:registrarReparacionTransformador();">Guardar</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                          </div>                          
                        <!--</form> -->
                        
                      </div>
                      
                    </div>
                  </div>
                </div> <!-- modal-->
                
                

                <!-- Modal modificar primaria-->
                <div class="modal fade" id="primaria" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header" style="background:#d66e2b;">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title" id="myModalLabel">Datos de bobina primaria y segundaria</h3>
                      </div>                     
                      
                      <div class="modal-body">
                      <p class="help-block"></p>
                      <!--<form role="form" action="#">-->
                          <div class="row ">
                                <div class="col-xs-12 col-sm-9" style="margin-left:30px;">
                                  <div class="">
                                        <input type="hidden" name="idrepa" value="" placeholder="">
                                        <div class="col-xs-12 col-sm-6 col-md-8"> 
                                          <div class="form-group">
                                            <label >Nombre del Cliente</label>
                                            <input type="text" class="form-control" id="" name="nomcliente1" placeholder="Nombre de la persona" required readonly="true">
                                          </div>
                                        </div>
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >Fecha</label>
                                            <input type="text" class="form-control" id="" name="fechaingreso1" placeholder="" required readonly="true">
                                          </div>  
                                        </div>
                                        
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >N° Secuencia</label>
                                            <input type="text" class="form-control" id="" name="nsecuncia1" placeholder="" required>
                                          </div>  
                                        </div>
                                        
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >Potencia</label>
                                            <input type="text" class="form-control" name="poteciapri1" placeholder="" required>
                                          </div>  
                                        </div>
                                        
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >V Primario</label>
                                            <input type="text" class="form-control" id="" name="vprimario1" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >V Segundario</label>
                                            <input type="text" class="form-control" id="" name="vsegundario1" placeholder="" required>
                                          </div>  
                                        </div>
                                        
                                        
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >Marca</label>
                                            <input type="text" class="form-control" id="" name="marcatrans1" placeholder="" required readonly="true">
                                          </div>  
                                        </div>
                                       
                                    </div>
                                
                                </div>
                                
                            </div>

                            <div id="ocultar1">
                                  <div class="row">
                                <div class="col-sm-12" style="background:#d66e2b;">
                                    <h3 class="modal-title" style="color:#fff;">Bobina Primaria</h3>
                                </div>
                                <div class="col-sm-12">
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >Largo</label>
                                            <input type="text" class="form-control" id="" name="largorepa1" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >Ancho</label>
                                            <input type="text" class="form-control" id="" name="anchorepa1" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >Altura</label>
                                            <input type="text" class="form-control" id="" name="alturepa1" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >Refrigeracion</label>
                                            <input type="text" class="form-control" id="" name="refrirepa1" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >Bisel</label>
                                            <input type="text" class="form-control" id="" name="biselrepa1" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >Fibra</label>
                                            <input type="text" class="form-control" id="" name="fibrarepa1" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >Calibre</label>
                                            <input type="text" class="form-control" id="" name="calirepa1" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >Otro</label>
                                            <input type="text" class="form-control" id="" name="otrorepa1" placeholder="" required>
                                          </div>  
                                        </div>

                                </div>
                            </div>
                            </div>
                            
                            
                            <div id="ocultar">
                              <div class="row">
                                <div class="col-sm-12" style="background:#d66e2b;">
                                    <h3 class="modal-title" style="color:#fff;">Bobina Segundaria</h3>
                                </div>
                                <div class="col-sm-12">
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >Largo</label>
                                            <input type="text" class="form-control" id="" name="largo11" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >Ancho</label>
                                            <input type="text" class="form-control" id="" name="ancho11" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >Tipo Conductor</label>
                                            <input type="text" class="form-control" id="" name="tipoconductorrepa1" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >Refrigeracion</label>
                                            <input type="text" class="form-control" id="" name="refri11" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >Fibra</label>
                                            <input type="text" class="form-control" id="" name="fibra11" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >Bisel</label>
                                            <input type="text" class="form-control" id="" name="bisel11" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >N2</label>
                                            <input type="text" class="form-control" id="" name="n21" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >Bobina</label>
                                            <input type="text" class="form-control" id="" name="bobinas1" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >Otro</label>
                                            <input type="text" class="form-control" id="" name="otros11" placeholder="" required>
                                          </div>  
                                        </div>
                                        
                                </div>
                            </div>    

                            </div>      

                             

                          <div id="botonprimaria" class="modal-footer"><!----  registrarReparacionTransformador(); -->
                            <button  class="btn btn-naranja" onclick="javascript:ActualizarReparacionTransformador();">Actualizar</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                          </div>       

                          <div id="botonsecundario" class="modal-footer"><!----  registrarReparacionTransformador(); -->
                            <button  class="btn btn-naranja" onclick="javascript:ActualizarReparacionSecundariaTransformador();">Actualizar</button>
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