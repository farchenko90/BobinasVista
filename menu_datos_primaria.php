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
    <link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" />
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
    <script src="Jsserver/BobinadoPrimario.js" type="text/javascript"></script>
    <script src="Jsserver/BobinadoSecundario.js" type="text/javascript"></script>
    
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

    
var estadoprimaria = true;    
    
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
        cc = document.getElementsByName("ced")[0].value;
        verdatostipousuario(cc);
        var id = getGET();
        if(id!=null){
            geturl = id['id'];
            tipodedato(id['id']);
            DatosTransformador(geturl);
        }else{
            //location.href = "menu_datos_bobina.php";
        }    
    });
    
    function initTabla(){
        //CONVERTIMOS NUESTRO LISTADO DE LA FORMA DEL JQUERY.DATATABLES- PASAMOS EL ID DE LA TABLA
        $('#dataTables-example').dataTable({
            //"sPaginationType": "full_numbers" //DAMOS FORMATO A LA PAGINACION(NUMEROS)
        });
    }
    
    function initTabla1(){
        //CONVERTIMOS NUESTRO LISTADO DE LA FORMA DEL JQUERY.DATATABLES- PASAMOS EL ID DE LA TABLA
        $('#dataTables-example1').dataTable({
            //"sPaginationType": "full_numbers" //DAMOS FORMATO A LA PAGINACION(NUMEROS)
        });
    }

    
    var tipo;
//Tipo de dato o primario o segundario
function tipodedato(id2){
    jQuery.ajax({
         type: "GET",
         url: servidor+"reparacion2/"+id2, 
         dataType: "json",
         success: function (data, status, jqXHR) {
             if(data!=null){
                 var boton = document.getElementById("boton");
                 var boton1 = document.getElementById("boton1");
                 var tab1 = document.getElementById("tablaprim"); 
                 var tab2 = document.getElementById("tablasecu");
                for(var i=0;i < data.length; i++){
                    tipo = data[i].Tipo;
                    if(tipo=="Primaria"){
                        boton1.style.display = 'none';
                        tab2.style.display = 'none';
                        tablabobinaprimaria();
                    }else{
                        boton.style.display = 'none';
                        tab1.style.display = 'none';
                        tablabobinasecundaria();
                    }
                }
                 
             }

         },
         error: function (jqXHR, status) {
             alert("error buscar user");
         }
    });
    
}
    
    function cerrarcampos(){
        estadoprimaria = false;
        document.getElementsByName("calibre")[0].disabled = true;          
        document.getElementsByName("espiracapa")[0].disabled = true;
        document.getElementsByName("opciones")[0].disabled = true;
        document.getElementsByName("aislamiento")[0].disabled = true;
        document.getElementsByName("refrigreacion")[0].disabled = true;
        document.getElementsByName("calibrefibra")[0].disabled = true;
        document.getElementsByName("bisel")[0].disabled = true;
        document.getElementsByName("largo")[0].disabled = true;
        document.getElementsByName("ancho")[0].disabled = true;
        document.getElementsByName("altura")[0].disabled = true;
        document.getElementsByName("n2")[0].disabled = true;
        document.getElementsByName("espiratotal")[0].disabled = true;
        document.getElementsByName("tap")[0].disabled = true;
        
    }
    
    function cerrarcampossecundario(){
        
        document.getElementsByName("tipoconductor")[0].disabled = true;          
        document.getElementsByName("medidaconductor")[0].disabled = true;
        document.getElementsByName("capassecu")[0].disabled = true;
        document.getElementsByName("espitacapas")[0].disabled = true;
        document.getElementsByName("bobinasec")[0].disabled = true;
        document.getElementsByName("n2secu")[0].disabled = true;
        document.getElementsByName("aislamientosec")[0].disabled = true;
        document.getElementsByName("refrigesec")[0].disabled = true;
        document.getElementsByName("calibresecu")[0].disabled = true;
        document.getElementsByName("biselsecundario")[0].disabled = true;
        document.getElementsByName("observacionsec")[0].disabled = true;
        
    }
    
    function tablabobinaprimaria(){
        jQuery.ajax({
             type: "GET",
             url: servidor+"bobinapri/"+id['id'], 
             dataType: "json",
             success: function (data, status, jqXHR) {
                 //vecCC = data;
                 var tabla = document.getElementById("tbodytabla1");//dataTables-example
                 tabla.innerHTML = "";
                 //alert(JSON.stringify(data));
                 if(data==null){
                    initTabla();
                 }
                 
                 for(var i = 0; i < data.length ; i++){
                     var accion = "";
                     var color = "red";
                     if (data[0].Estado == "Terminado"){
                        color = "green";
                        cerrarcampos();
                        modificarReparacionTransformador(geturl);
                     }
                     
                     tabla.innerHTML += "<tr>"+
                     "<td>"+data[i].NomCliente+"</td>"+
                     "<td>"+data[i].Fecha+"</td>"+
                     "<td>"+data[i].Placa+"</td>"+
                     "<td>"+data[i].CAlambre+"</td>"+
                     "<td>"+data[i].EspiraCapa+"</td>"+
                     "<td>"+data[i].Tipo+"</td>"+
                     "<td><p style='color:"+color+"; font-size:17px'>"+data[i].Estado+"</p></td>"+    
                     "<td>"+data[i].TAccion+"</td>"+    
                     "<td>"+data[i].Nom_Usu+"</td>"+     
                     "<td class='center'>"+"<a href='"+ruta+"/menu_admin_transformador.php' title='Volver al inicio' \n\
                     class='btn btn-primary  btn-sm' ><i class='fa fa-reply fa-2x fa-fw' id=''></i></a>"+
                     "<a title='modificar' class='btn btn-success btn-sm' data-toggle='modal' onClick='javascript:primario("+data[i].Idprimario+")' \n\
                     data-target='#actualizar-primaria'><i class='fa fa-edit fa-2x fa-fw'></i></a>"
                     +"</td></tr>";
                            
                 }
                         initTabla();
             },
             error: function (jqXHR, status) {
                 initTabla();
                 //alert("error cargar tabla");

             }
        });
    }
    
    function primario(id){
        document.getElementsByName("idprimario")[0].value = id;
        datosprimario(id);
    }

    function tablabobinasecundaria(){
        jQuery.ajax({
             type: "GET",
             url: servidor+"secundario/"+id['id'], 
             dataType: "json",
             success: function (data, status, jqXHR) {
                 //vecCC = data;
                 var tabla = document.getElementById("tbodytabla2");//dataTables-example
                 tabla.innerHTML = "";
                 //alert(JSON.stringify(data));
                 if(data==null){
                    initTabla1();
                 }
                 
                 for(var i = 0; i < data.length ; i++){
                     var accion = "";
                     var color = "red";
                     if (data[i].Estado == "Terminado"){
                        color = "green";
                        cerrarcampossecundario();
                        modificarReparacionTransformador(geturl);
                     }
                     
                     tabla.innerHTML += "<tr>"+
                     "<td>"+data[i].NomCliente+"</td>"+
                     "<td>"+data[i].Fecha+"</td>"+
                     "<td>"+data[i].Placa+"</td>"+
                     "<td>"+data[i].MConductor+"</td>"+
                     "<td>"+data[i].TConductor+"</td>"+
                     "<td>"+data[i].Capas+"</td>"+
                     "<td><p style='color:"+color+"; font-size:17px'>"+data[i].Estado+"</p></td>"+    
                     "<td>"+data[i].TAccion+"</td>"+    
                     "<td>"+data[i].Nom_Usu+"</td>"+     
                     "<td class='center'>"+"<a href='"+ruta+"/menu_admin_transformador.php' title='Editar' \n\
                     class='btn btn-primary  btn-sm' ><i class='fa fa-reply fa-2x fa-fw' id=''></i></a>"+
                     "<a title='modificar' class='btn btn-success btn-sm' data-toggle='modal' onClick='javascript:segundario("+data[i].Idsegundario+")' \n\
                     data-target='#modalsegundario'><i class='fa fa-edit fa-2x fa-fw'></i></a>"
                     +"</td></tr>";
                            
                 }
                         initTabla1();
             },
             error: function (jqXHR, status) {
                 initTabla1();
                 //alert("error cargar tabla");

             }
        });
    }

    function segundario(id){
        datossegundario(id);
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
                
                        <div class="well" id="boton">
                            <button type="button" class="btn btn-naranja" data-toggle="modal" data-target="#agrega_motor"><i class="fa fa-plus fa-fw "></i> Datos De Bobina Primaria</button>
                            <button type="button" class="btn btn-naranja" onclick="javascript:volver();">
                                <i class="fa fa-reply"></i> Volver</button>
                        </div>
                    
                        <div class="well" id="boton1">
                            <button type="button" class="btn btn-naranja" data-toggle="modal" data-target="#agrega_motor1"><i class="fa fa-plus fa-fw "></i> Datos De Bobina Secundaria</button>
                            <button type="button" class="btn btn-naranja" onclick="javascript:volver();">
                                <i class="fa fa-reply"></i> Volver</button>
                        </div>
                    
                    
                       
                    <div class="panel panel-default">
                        <div class="panel-heading">
    
                        </div>

                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive" id="tablaprim">
                                <table class="table table-condensed  table-hover table-bordered" id="dataTables-example">
                                    <thead>
                                        <tr class="fa-rosa danger" >
                                            <th>Nombre Cliente</th>
                                            <th>Fecha Ingreso</th>
                                            <th>N# placa</th>
                                            <th>Calibre Alambre</th>
                                            <th>Espira X Capas</th>
                                            <th>Opciones</th>
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
                            
                            
                            <div class="table-responsive" id="tablasecu">
                                
                                <table class="table table-condensed  table-hover table-bordered" id="dataTables-example1">
                                    <thead>
                                        <tr class="fa-rosa danger" >
                                            <th>Nombre Cliente</th>
                                            <th>Fecha Ingreso</th>
                                            <th>N# placa</th>
                                            <th>Tipo Conductor</th>
                                            <th>Medidas Conductor</th>
                                            <th>Capas</th>
                                            <th>Estado</th>
                                            <th>T.Entrada</th>
                                            <th>Responsable</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="" id="tbodytabla2">
                                        
                                    </tbody>
                                </table>
                                
                            </div>
                    <?php 
                        echo "<input type='hidden' name='ced' value='".$_SESSION['id']."'";
                    ?>
                            
            
                            
                                <!-- Modal primario -->
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
                                            <input type="text" class="form-control" id="" name="nsecuncia" placeholder="" required readonly="true">
                                          </div>  
                                        </div>
                                        
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >KVA</label>
                                            <input type="text" class="form-control" name="kva" placeholder="" required readonly="true">
                                          </div>  
                                        </div>
                                        
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >Marca</label>
                                            <input type="text" class="form-control" id="" name="marcatra" placeholder="" required readonly="true">
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >V.P</label>
                                            <input type="text" class="form-control" id="" name="vprimario" placeholder="" required readonly="true">
                                          </div>  
                                        </div>
                                        
                                        
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >V.S</label>
                                            <input type="text" class="form-control" id="" name="vegundario" placeholder="" required readonly="true">
                                          </div>  
                                        </div>
                                      
                                      <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >N° Fases</label>
                                            <input type="text" class="form-control" id="" name="nfases" placeholder="" required readonly="true">
                                          </div>  
                                        </div>
                                       
                                    </div>
                                
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-sm-12" style="background:#d66e2b;">
                                    <h3 class="modal-title" style="color:#fff;">Datos Bobinado Primario</h3>
                                </div>
                                <div class="col-sm-12">
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >Calibre Alambre</label>
                                            <input type="text" class="form-control" id="" name="calibre" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >Espira X Capa</label>
                                            <input type="text" class="form-control" id="" name="espiracapa" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >Opciones</label>
                                            <select class="form-control" name="opciones" title="Seleccione un tipo de entrada" required>
                                                        <option value="Exterior" selected>Exterior</option>
                                                        <option value="Interior">Interior</option>
                                            </select>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label>Aislamiento Capa</label>
                                            <input type="text" class="form-control" id="" name="aislamiento" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >Refrigeracion</label>
                                            <input type="text" class="form-control" id="" name="refrigreacion" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >Calibre Fibra</label>
                                            <input type="text" class="form-control" id="" name="calibrefibra" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >Bisel</label>
                                            <input type="text" class="form-control" id="" name="bisel" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >Largo</label>
                                            <input type="text" class="form-control" id="" name="largo" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >Ancho</label>
                                            <input type="text" class="form-control" id="" name="ancho" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >Altura</label>
                                            <input type="text" class="form-control" id="" name="altura" placeholder="" required>
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
                                            <label>Espira Total</label>
                                            <input type="text" class="form-control" id="" name="espiratotal" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label>TAP</label>
                                            <input type="text" class="form-control" id="" name="tap" placeholder="" required>
                                          </div>  
                                        </div>
                                    
                                        <div class="col-xs-6 col-sm-6">
                                          <div class="form-group" id="alerta">
                                                          
                                          </div>
                                       </div>
                                </div>
                                
                                
                                
                            </div>                      
                                                                                              
                          <div class="modal-footer"><!----  registrarReparacionTransformador(); -->
                          	<button  class="btn btn-naranja" onclick="javascript:agregarbobinaprimaria();">Guardar</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                          </div>                          
                        <!--</form> -->
                        
                      </div>
                      
                    </div>
                  </div>
                </div> <!-- modal-->
                
                            
                <!-- Modal primario actualizar -->
                <div class="modal fade" id="actualizar-primaria" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header" style="background:#d66e2b;">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title" id="myModalLabel">Actualizar datos de bobina primaria</h3>
                      </div>                     
                      
                      <div class="modal-body">
                      <p class="help-block"></p>
                      <!--<form role="form" action="#">-->
                            <div class="row">
                                <!--div class="col-sm-12" style="background:#d66e2b;">
                                    <h3 class="modal-title" style="color:#fff;">Datos Bobinado Primario</h3>
                                </div>-->
                                <input type="hidden" name="idprimario" value="" placeholder="">
                                <div class="col-sm-12">
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >Calibre Alambre</label>
                                            <input type="text" class="form-control" id="" name="calibre1" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >Espira X Capa</label>
                                            <input type="text" class="form-control" id="" name="espiracapa1" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >Opciones</label>
                                            <select class="form-control" name="opciones1" title="Seleccione un tipo de entrada" required>
                                                        <option value="Exterior" selected>Exterior</option>
                                                        <option value="Interior">Interior</option>
                                            </select>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label>Aislamiento Capa</label>
                                            <input type="text" class="form-control" id="" name="aislamiento1" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >Refrigeracion</label>
                                            <input type="text" class="form-control" id="" name="refrigreacion1" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >Calibre Fibra</label>
                                            <input type="text" class="form-control" id="" name="calibrefibra1" placeholder="" required>
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
                                            <label >Altura</label>
                                            <input type="text" class="form-control" id="" name="altura1" placeholder="" required>
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
                                            <label>Espira Total</label>
                                            <input type="text" class="form-control" id="" name="espiratotal1" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label>TAP</label>
                                            <input type="text" class="form-control" id="" name="tap1" placeholder="" required>
                                          </div>  
                                        </div>
                                    
                                        <div class="col-xs-6 col-sm-6">
                                          <div class="form-group" id="alerta">
                                                          
                                          </div>
                                       </div>
                                </div>
                                
                                
                                
                            </div>                      
                                                                                              
                          <div class="modal-footer"><!----  registrarReparacionTransformador(); -->
                            <button  class="btn btn-naranja" onclick="javascript:actualizarbobinaprimaria();">Actualizar</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                          </div>                          
                        <!--</form> -->
                        
                      </div>
                      
                    </div>
                  </div>
                </div> <!-- modal-->            



                <!---  Modal segundario -->            
                <div class="modal fade" id="agrega_motor1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-     hidden="true">
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
                                            <input type="text" class="form-control" id="" name="nsecuncia1" placeholder="" required readonly="true">
                                          </div>  
                                        </div>
                                        
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >KVA</label>
                                            <input type="text" class="form-control" name="kva1" placeholder="" required readonly="true">
                                          </div>  
                                        </div>
                                        
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >Marca</label>
                                            <input type="text" class="form-control" id="" name="marcatra1" placeholder="" required readonly="true">
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >V.P</label>
                                            <input type="text" class="form-control" id="" name="vprimario1" placeholder="" required readonly="true">
                                          </div>  
                                        </div>
                                        
                                        
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >V.S</label>
                                            <input type="text" class="form-control" id="" name="vegundario1" placeholder="" required readonly="true">
                                          </div>  
                                        </div>
                                      
                                      <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >N° Fases</label>
                                            <input type="text" class="form-control" id="" name="nfases1" placeholder="" required readonly="true">
                                          </div>  
                                        </div>
                                       
                                    </div>
                                
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-sm-12" style="background:#d66e2b;">
                                    <h3 class="modal-title" style="color:#fff;">Datos Bobinado Secundario</h3>
                                </div>
                                <div class="col-sm-12">
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >Tipo Conductor</label>
                                            <input type="text" class="form-control" id="" name="tipoconductor" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >Medidas Conductor</label>
                                            <input type="text" class="form-control" id="" name="medidaconductor" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >Capas</label>
                                            <input type="text" class="form-control" id="" name="capassecu" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label>Espiras X Capas</label>
                                            <input type="text" class="form-control" id="" name="espitacapas" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >Bobina</label>
                                            <input type="text" class="form-control" id="" name="bobinasec" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >N2</label>
                                            <input type="text" class="form-control" id="" name="n2secu" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >Aislamiento CapasS</label>
                                            <input type="text" class="form-control" id="" name="aislamientosec" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >Refrigeracion</label>
                                            <input type="text" class="form-control" id="" name="refrigesec" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >Calibre Fibra</label>
                                            <input type="text" class="form-control" id="" name="calibresecu" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >Bisel</label>
                                            <input type="text" class="form-control" id="" name="biselsecundario" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group" id="opcion">
                                            <label >Observaciones</label>
                                             <textarea rows="4" style="min-width: 100%;" name="observacionsec" id="obser">
                                             </textarea>
                                          </div> 
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                          <div class="form-group" id="alerta1">
                                                          
                                          </div>
                                       </div>
                                </div>
                            </div>                      
                                                                                              
                          <div class="modal-footer"><!----  registrarReparacionTransformador(); -->
                          	<button  class="btn btn-naranja" onclick="javascript:agregarbobinasecundario();">Guardar</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                          </div>                          
                        <!--</form> -->
                        
                      </div>
                      
                    </div>
                  </div>
                </div> <!-- modal-->
                            
                            
                        <!---  Modal segundario actualizar -->            
                <div class="modal fade" id="modalsegundario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-     hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header" style="background:#d66e2b;">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title" id="myModalLabel">Actualizar Datos de bobina segundaria</h3>
                      </div>                     
                      
                      <div class="modal-body">
                      <p class="help-block"></p>
                      <!--<form role="form" action="#">-->
                            <div class="row">
                                <input type="hidden" name="idsegundario" value="" placeholder="">
                                <div class="col-sm-12">
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >Tipo Conductor</label>
                                            <input type="text" class="form-control" id="" name="tipoconductor1" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >Medidas Conductor</label>
                                            <input type="text" class="form-control" id="" name="medidaconductor1" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >Capas</label>
                                            <input type="text" class="form-control" id="" name="capassecu1" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label>Espiras X Capas</label>
                                            <input type="text" class="form-control" id="" name="espitacapas1" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >Bobina</label>
                                            <input type="text" class="form-control" id="" name="bobinasec1" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >N2</label>
                                            <input type="text" class="form-control" id="" name="n2secu1" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >Aislamiento CapasS</label>
                                            <input type="text" class="form-control" id="" name="aislamientosec1" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >Refrigeracion</label>
                                            <input type="text" class="form-control" id="" name="refrigesec1" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >Calibre Fibra</label>
                                            <input type="text" class="form-control" id="" name="calibresecu1" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group">
                                            <label >Bisel</label>
                                            <input type="text" class="form-control" id="" name="biselsecundario1" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-md-4" >
                                           <div class="form-group" id="opcion">
                                            <label >Observaciones</label>
                                             <textarea rows="4" style="min-width: 100%;" name="observacionsec1" id="obser">
                                             </textarea>
                                          </div> 
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                          <div class="form-group" id="alerta1">
                                                          
                                          </div>
                                       </div>
                                </div>
                            </div>                      
                                                                                              
                          <div class="modal-footer"><!----  registrarReparacionTransformador(); -->
                            <button  class="btn btn-naranja" onclick="javascript:actualizarbobinasecundario();">Guardar</button>
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
<script>location.href = "inicio_sesion.php";


</script>
<?php } ?>