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

    <script src="Jsserver/Server.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/toastr.min.js"></script>
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
        document.getElementById("tension_aplicada").value = "";
        document.getElementById("ff11").value = "";
        document.getElementById("ff12").value = "";
        document.getElementById("ff13").value = "";
        document.getElementById("ff14").value = "";
        document.getElementById("ff15").value = "";
        document.getElementById("ff21").value = "";
        document.getElementById("ff22").value = "";
        document.getElementById("ff23").value = "";
        document.getElementById("ff24").value = "";
        document.getElementById("ff25").value = "";
        document.getElementById("ff31").value = "";
        document.getElementById("ff32").value = "";
        document.getElementById("ff33").value = "";
        document.getElementById("ff34").value = "";
        document.getElementById("ff35").value = "";
        document.getElementById("fn1").value = "";
        document.getElementById("fn2").value = "";
        document.getElementById("fn3").value = "";
        document.getElementById("fn4").value = "";
        document.getElementById("fn5").value = "";
        document.getElementById("corto_circuito_x").value = "";
        document.getElementById("corto_circuito_y").value = "";
        document.getElementById("corto_circuito_z").value = "";
        document.getElementById("corto_circuito_n").value = "";
        document.getElementById("seco_30_ab").value = "";
        document.getElementById("seco_30_at").value = "";
        document.getElementById("seco_30_bt").value = "";
        document.getElementById("seco_60_ab").value = "";
        document.getElementById("seco_60_at").value = "";
        document.getElementById("seco_60_bt").value = "";
        document.getElementById("aceite_30_ab").value = "";
        document.getElementById("aceite_30_at").value = "";
        document.getElementById("aceite_30_bt").value = "";
        document.getElementById("aceite_60_ab").value = "";
        document.getElementById("aceite_60_at").value = "";
        document.getElementById("aceite_60_bt").value = "";
        document.getElementById("encube").value = "";
        document.getElementById("tension_aplicada2").value = "";
        document.getElementById("amperaje").value = "";
        document.getElementById("voltaje_de_salida").value = "";
        document.getElementById("pintura").value = "";
        document.getElementById("observaciones").value = "";
        //document.getElementById("responsable1").value = "";
            
    }
    
    function guardar_o_update(){
        if (banInsert){
            guardarEstadoTransformador();
        }else{
            updateEstadoTransformador(idEstadoAceite);
        }
    }
    
    
    
    
    function cerrar(){
            estadobobina = false;
            document.getElementById("tension_aplicada").disabled = true;
            document.getElementById("ff11").disabled = true;
            document.getElementById("ff12").disabled = true;
            document.getElementById("ff13").disabled = true;
            document.getElementById("ff14").disabled = true;
            document.getElementById("ff15").disabled = true;
            document.getElementById("ff21").disabled = true;
            document.getElementById("ff22").disabled = true;
            document.getElementById("ff23").disabled = true;
            document.getElementById("ff24").disabled = true;
            document.getElementById("ff25").disabled = true;
            document.getElementById("ff31").disabled = true;
            document.getElementById("ff32").disabled = true;
            document.getElementById("ff33").disabled = true;
            document.getElementById("ff34").disabled = true;
            document.getElementById("ff35").disabled = true;
            document.getElementById("fn1").disabled = true;
            document.getElementById("fn2").disabled = true;
            document.getElementById("fn3").disabled = true;
            document.getElementById("fn4").disabled = true;
            document.getElementById("fn5").disabled = true;
            document.getElementById("corto_circuito_x").disabled = true;
            document.getElementById("corto_circuito_y").disabled = true;
            document.getElementById("corto_circuito_z").disabled = true;
            document.getElementById("corto_circuito_n").disabled = true;
            document.getElementById("seco_30_ab").disabled = true;
            document.getElementById("seco_30_at").disabled = true;
            document.getElementById("seco_30_bt").disabled = true;
            document.getElementById("seco_60_ab").disabled = true;
            document.getElementById("seco_60_at").disabled = true;
            document.getElementById("seco_60_bt").disabled = true;
            document.getElementById("aceite_30_ab").disabled = true;
            document.getElementById("aceite_30_at").disabled = true;
            document.getElementById("aceite_30_bt").disabled = true;
            document.getElementById("aceite_60_ab").disabled = true;
            document.getElementById("aceite_60_at").disabled = true;
            document.getElementById("aceite_60_bt").disabled = true;
            document.getElementById("encube").disabled = true;
            document.getElementById("tension_aplicada2").disabled = true;
            document.getElementById("amperaje").disabled = true;
            document.getElementById("voltaje_de_salida").disabled = true;
            document.getElementById("pintura").disabled = true;
            document.getElementById("observaciones").disabled = true;
        
    }
    
    function cargarDatosUpdate(data,i){
        banInsert = false;
        idEstadoAceite = data[i].id;
        document.getElementById("tension_aplicada1").value = data[i].tension_aplicada;
            document.getElementById("ff111").value = data[i].ff11;
            document.getElementById("ff121").value = data[i].ff12;
            document.getElementById("ff131").value = data[i].ff13;
            document.getElementById("ff141").value = data[i].ff14;
            document.getElementById("ff151").value = data[i].ff15;
            document.getElementById("ff211").value = data[i].ff21;
            document.getElementById("ff221").value = data[i].ff22;
            document.getElementById("ff231").value = data[i].ff23;
            document.getElementById("ff241").value = data[i].ff24;
            document.getElementById("ff251").value = data[i].ff25;
            document.getElementById("ff311").value = data[i].ff31;
            document.getElementById("ff321").value = data[i].ff32;
            document.getElementById("ff331").value = data[i].ff33;
            document.getElementById("ff341").value = data[i].ff34;
            document.getElementById("ff351").value = data[i].ff35;
            document.getElementById("fn11").value = data[i].fn1;
            document.getElementById("fn21").value = data[i].fn2;
            document.getElementById("fn31").value = data[i].fn3;
            document.getElementById("fn41").value = data[i].fn4;
            document.getElementById("fn51").value = data[i].fn5;
            document.getElementById("corto_circuito_x1").value = data[i].corto_circuito_x;
            document.getElementById("corto_circuito_y1").value = data[i].corto_circuito_y;
            document.getElementById("corto_circuito_z1").value = data[i].corto_circuito_z;
            document.getElementById("corto_circuito_n1").value = data[i].corto_circuito_n;
            document.getElementById("seco_30_ab1").value = data[i].seco_30_ab;
            document.getElementById("seco_30_at1").value = data[i].seco_30_at;
            document.getElementById("seco_30_bt1").value = data[i].seco_30_bt;
            document.getElementById("seco_60_ab1").value = data[i].seco_60_ab;
            document.getElementById("seco_60_at1").value = data[i].seco_60_at;
            document.getElementById("seco_60_bt1").value = data[i].seco_60_bt;
            document.getElementById("aceite_30_ab1").value = data[i].aceite_30_ab;
            document.getElementById("aceite_30_at1").value = data[i].aceite_30_at;
            document.getElementById("aceite_30_bt1").value = data[i].aceite_30_bt;
            document.getElementById("aceite_60_ab1").value = data[i].aceite_60_ab;
            document.getElementById("aceite_60_at1").value = data[i].aceite_60_at;
            document.getElementById("aceite_60_bt1").value = data[i].aceite_60_bt;
            document.getElementById("encube1").value = data[i].encube;
            document.getElementById("tension_aplicada21").value = data[i].tension_aplicada2;
            document.getElementById("amperaje1").value = data[i].amperaje;
            document.getElementById("voltaje_de_salida1").value = data[i].voltaje_de_salida;
            document.getElementById("pintura1").value = data[i].pintura;
            document.getElementById("observaciones1").value = data[i].observaciones;
            document.getElementById("responsable").value = data[i].responsable;
    }
    
    function eliminarEstadoAceit(id){
        var r = confirm("Desea eliminar el registro con id # "+ id);
        if (r == true) {
            deleteEstadoTransformador(id);
        }
    }
    
    function tablareparacion(idtra){
        jQuery.ajax({
             type: "GET",
             url: servidor+"estadoTransformador/"+idtra, 
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
                    }
                     
                     cerrar();   
                     tabla.innerHTML += "<tr>"+
                     "<td>"+data[i].id+"</td>"+
                     "<td>"+data[i].tension_aplicada2+"</td>"+
                     "<td>"+data[i].amperaje+"</td>"+
                     "<td>"+data[i].voltaje_de_salida+"</td>"+
                     "<td><p style='color:"+color+"; font-size:17px'>"+data[i].estado+"</p></td>"+
                     "<td>"+data[i].responsable+"</td>"+
                     "<td class='center'>"+"<a href='#' title='Eliminar' class='btn btn-danger btn-sm' id='' \n\
            onclick='javascript:eliminarEstadoAceit("+ data[i].id + ")'><i class='fa fa-2x fa-eraser fa-fw'></i> \n\
            </a><a onclick='cargarDatosUpdate(" + JSON.stringify(data) + ", " + i + ")' title='Editar' \n\
            class='btn btn-success  btn-sm' data-toggle='modal' data-target='#update_motor' >\n\
            <i class='fa fa-edit fa-2x fa-fw' ></i></a>"+"</td></tr>";
                            
                 }
                         initTabla();
                    }
             },
             error: function (jqXHR, status) {
                 initTabla();
                 
             }
        });
    }
    
    function volver(){
        location.href = ruta + "menu_datos_estado_aceite.php?id="+id['id'];;
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
                        <button onclick="initBanInsert()" type="button" class="btn btn-naranja" data-toggle="modal" data-target="#agrega_motor"><i class="fa fa-plus fa-fw "></i> Agregar Datos De Estado</button>
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
                                            <th>Tensión aplicada (CASCADA)</th>
                                            <th>Amperaje</th>
                                            <th>Voltaje de salida</th>
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
                        <h3 class="modal-title" id="myModalLabel">Estado de transformadores</h3>
                      </div>                     
                      
                      <div class="modal-body">
                      <p class="help-block"></p>
                      <!--<form role="form" action="#">-->
                            <div class="row">
                                <div class="col-sm-12" style="background:#d66e2b; margin-bottom: 10px;">
                                    <h3 class="modal-title" style="color:#fff;">Resultados de ensayos</h3>
                                </div>
                                <div class="col-sm-12">
                                    
                                        <div class="col-xs-6 col-md-12" >
                                           <div class="form-group">
                                            <label >Tensión aplicada</label>
                                            <input type="text" class="form-control" id="tension_aplicada" name="largorepa" placeholder="" required>
                                          </div>  
                                        </div>

                                </div>
                                
                                 <div class="col-sm-12">
                                    
                                        <div class="col-xs-6 col-md-1" >
                                           <div class="form-group">
                                            <label >Relación de transformación</label>
                                            </div>  
                                        </div>
                                     <div class="col-sm-12">
                                     <div class="row">
                                         <div class="col-xs-6 col-md-2" >
                                           <div class="form-group">
                                            <label >F-F</label>
                                            </div>  
                                        </div>
                                         
                                         <div class="col-xs-6 col-md-2" >
                                            <input type="text" class="form-control" id="ff11" name="largorepa" placeholder="" required>
                                        </div>
                                         
                                         <div class="col-xs-6 col-md-2" >
                                            <input type="text" class="form-control" id="ff12" name="largorepa" placeholder="" required>
                                        </div>
                                         <div class="col-xs-6 col-md-2" >
                                            <input type="text" class="form-control" id="ff13" name="largorepa" placeholder="" required>
                                        </div>
                                         
                                         <div class="col-xs-6 col-md-2" >
                                            <input type="text" class="form-control" id="ff14" name="largorepa" placeholder="" required>
                                        </div>
                                         
                                         <div class="col-xs-6 col-md-2" >
                                            <input type="text" class="form-control" id="ff15" name="largorepa" placeholder="" required>
                                        </div>
                                         
                                     </div>
                                     
                                     <div class="row">
                                         <div class="col-xs-6 col-md-2" >
                                           <div class="form-group">
                                            <label >F-F</label>
                                            </div>  
                                        </div>
                                         
                                         <div class="col-xs-6 col-md-2" >
                                            <input type="text" class="form-control" id="ff21" name="largorepa" placeholder="" required>
                                        </div>
                                         
                                         <div class="col-xs-6 col-md-2" >
                                            <input type="text" class="form-control" id="ff22" name="largorepa" placeholder="" required>
                                        </div>
                                         <div class="col-xs-6 col-md-2" >
                                            <input type="text" class="form-control" id="ff23" name="largorepa" placeholder="" required>
                                        </div>
                                         
                                         <div class="col-xs-6 col-md-2" >
                                            <input type="text" class="form-control" id="ff24" name="largorepa" placeholder="" required>
                                        </div>
                                         
                                         <div class="col-xs-6 col-md-2" >
                                            <input type="text" class="form-control" id="ff25" name="largorepa" placeholder="" required>
                                        </div>
                                         
                                     </div>
                                     
                                     <div class="row">
                                         <div class="col-xs-6 col-md-2" >
                                           <div class="form-group">
                                            <label >F-F</label>
                                            </div>  
                                        </div>
                                         
                                         <div class="col-xs-6 col-md-2" >
                                            <input type="text" class="form-control" id="ff31" name="largorepa" placeholder="" required>
                                        </div>
                                         
                                         <div class="col-xs-6 col-md-2" >
                                            <input type="text" class="form-control" id="ff32" name="largorepa" placeholder="" required>
                                        </div>
                                         <div class="col-xs-6 col-md-2" >
                                            <input type="text" class="form-control" id="ff33" name="largorepa" placeholder="" required>
                                        </div>
                                         
                                         <div class="col-xs-6 col-md-2" >
                                            <input type="text" class="form-control" id="ff34" name="largorepa" placeholder="" required>
                                        </div>
                                         
                                         <div class="col-xs-6 col-md-2" >
                                            <input type="text" class="form-control" id="ff35" name="largorepa" placeholder="" required>
                                        </div>
                                         
                                     </div>
                                     
                                     <div class="row">
                                         <div class="col-xs-6 col-md-2" >
                                           <div class="form-group">
                                            <label >F-N</label>
                                            </div>  
                                        </div>
                                         
                                         <div class="col-xs-6 col-md-2" >
                                            <input type="text" class="form-control" id="fn1" name="largorepa" placeholder="" required>
                                        </div>
                                         
                                         <div class="col-xs-6 col-md-2" >
                                            <input type="text" class="form-control" id="fn2" name="largorepa" placeholder="" required>
                                        </div>
                                         <div class="col-xs-6 col-md-2" >
                                            <input type="text" class="form-control" id="fn3" name="largorepa" placeholder="" required>
                                        </div>
                                         
                                         <div class="col-xs-6 col-md-2" >
                                            <input type="text" class="form-control" id="fn4" name="largorepa" placeholder="" required>
                                        </div>
                                         
                                         <div class="col-xs-6 col-md-2" >
                                            <input type="text" class="form-control" id="fn5" name="largorepa" placeholder="" required>
                                        </div>
                                         
                                     </div>
                                         
                                         <div class="row">
                                         <div class="col-xs-6 col-md-2" >
                                           <div class="form-group">
                                            <label >Corto circuito</label>
                                            </div>  
                                        </div>
                                         
                                         <div class="col-xs-6 col-md-2" >
                                             <label >X</label>
                                            <input type="text" class="form-control" id="corto_circuito_x" name="largorepa" placeholder="" required>
                                        </div>
                                         
                                         <div class="col-xs-6 col-md-2" >
                                             <label >Y</label>
                                            <input type="text" class="form-control" id="corto_circuito_y" name="largorepa" placeholder="" required>
                                        </div>
                                         <div class="col-xs-6 col-md-2" >
                                             <label >Z</label>
                                            <input type="text" class="form-control" id="corto_circuito_z" name="largorepa" placeholder="" required>
                                        </div>
                                         
                                         <div class="col-xs-6 col-md-2" >
                                             <label >N</label>
                                            <input type="text" class="form-control" id="corto_circuito_n" name="largorepa" placeholder="" required>
                                        </div>

                                         
                                     </div>
                                         
                                         
                                     </div>
                                     
                                </div>
                                
                            </div>
                            <!--  Bobina Segundaria---->
                            
                            <div class="row">
                                <div class="col-sm-12" style="background:#d66e2b; margin-top: 20px; margin-bottom: 10px;">
                                    <h3 class="modal-title" style="color:#fff;">En seco</h3>
                                </div>
                                <div class="col-sm-12">
                                    
                                        <div class="col-xs-6 col-md-1" >
                                           <div class="form-group">
                                            <label >Aislamiento (MEGUEO)</label>
                                            </div>  
                                        </div>
                                    
                                    <div class="row">
                                        
                                        <div class="col-sm-12">
                                            
                                            <div class="col-xs-6 col-md-2" >
                                                <div class="form-group">
                                                 <label ></label>
                                                 </div>  
                                             </div>
                                            
                                            <div class="col-xs-6 col-md-5" >
                                                <div class="form-group">
                                                 <label >30 segundos</label>
                                                 </div>  
                                             </div>
                                            
                                            <div class="col-xs-6 col-md-5" >
                                                <div class="form-group">
                                                 <label >60 segundos</label>
                                                 </div>  
                                             </div>
                                            
                                        </div>
                                        
                                    </div>
                                    
                                    <div class="row">
                                        
                                        <div class="col-sm-12">
                                            
                                            <div class="col-xs-6 col-md-2" >
                                                <div class="form-group">
                                                 <label >A-B</label>
                                                 </div>  
                                             </div>
                                            
                                            <div class="col-xs-6 col-md-5" >
                                                <div class="form-group">
                                                 <input type="text" class="form-control" id="seco_30_ab" name="largorepa" placeholder="" required>
                                                 </div>  
                                             </div>
                                            
                                            <div class="col-xs-6 col-md-5" >
                                                <div class="form-group">
                                                 <input type="text" class="form-control" id="seco_60_ab" name="largorepa" placeholder="" required>
                                                 </div>  
                                             </div>
                                            
                                        </div>
                                        
                                    </div>
                                    
                                    
                                    <div class="row">
                                        
                                        <div class="col-sm-12">
                                            
                                            <div class="col-xs-6 col-md-2" >
                                                <div class="form-group">
                                                 <label >A-T</label>
                                                 </div>  
                                             </div>
                                            
                                            <div class="col-xs-6 col-md-5" >
                                                <div class="form-group">
                                                 <input type="text" class="form-control" id="seco_30_at" name="largorepa" placeholder="" required>
                                                 </div>  
                                             </div>
                                            
                                            <div class="col-xs-6 col-md-5" >
                                                <div class="form-group">
                                                 <input type="text" class="form-control" id="seco_60_at" name="largorepa" placeholder="" required>
                                                 </div>  
                                             </div>
                                            
                                        </div>
                                        
                                    </div>
                                    
                                    
                                    <div class="row">
                                        
                                        <div class="col-sm-12">
                                            
                                            <div class="col-xs-6 col-md-2" >
                                                <div class="form-group">
                                                 <label >B-T</label>
                                                 </div>  
                                             </div>
                                            
                                            <div class="col-xs-6 col-md-5" >
                                                <div class="form-group">
                                                 <input type="text" class="form-control" id="seco_30_bt" name="largorepa" placeholder="" required>
                                                 </div>  
                                             </div>
                                            
                                            <div class="col-xs-6 col-md-5" >
                                                <div class="form-group">
                                                 <input type="text" class="form-control" id="seco_60_bt" name="largorepa" placeholder="" required>
                                                 </div>  
                                             </div>
                                            
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                            </div>    
                            
                            <div class="row">
                                <div class="col-sm-12" style="background:#d66e2b; margin-top: 20px; margin-bottom: 10px;">
                                    <h3 class="modal-title" style="color:#fff;">En aceite</h3>
                                </div>
                                <div class="col-sm-12">
                                    
                                        <div class="col-xs-6 col-md-1" >
                                           <div class="form-group">
                                            <label >Aislamiento (MEGUEO)</label>
                                            </div>  
                                        </div>
                                    
                                    <div class="row">
                                        
                                        <div class="col-sm-12">
                                            
                                            <div class="col-xs-6 col-md-2" >
                                                <div class="form-group">
                                                 <label ></label>
                                                 </div>  
                                             </div>
                                            
                                            <div class="col-xs-6 col-md-5" >
                                                <div class="form-group">
                                                 <label >30 segundos</label>
                                                 </div>  
                                             </div>
                                            
                                            <div class="col-xs-6 col-md-5" >
                                                <div class="form-group">
                                                 <label >60 segundos</label>
                                                 </div>  
                                             </div>
                                            
                                        </div>
                                        
                                    </div>
                                    
                                    <div class="row">
                                        
                                        <div class="col-sm-12">
                                            
                                            <div class="col-xs-6 col-md-2" >
                                                <div class="form-group">
                                                 <label >A-B</label>
                                                 </div>  
                                             </div>
                                            
                                            <div class="col-xs-6 col-md-5" >
                                                <div class="form-group">
                                                 <input type="text" class="form-control" id="aceite_30_ab" name="largorepa" placeholder="" required>
                                                 </div>  
                                             </div>
                                            
                                            <div class="col-xs-6 col-md-5" >
                                                <div class="form-group">
                                                 <input type="text" class="form-control" id="aceite_60_ab" name="largorepa" placeholder="" required>
                                                 </div>  
                                             </div>
                                            
                                        </div>
                                        
                                    </div>
                                    
                                    
                                    <div class="row">
                                        
                                        <div class="col-sm-12">
                                            
                                            <div class="col-xs-6 col-md-2" >
                                                <div class="form-group">
                                                 <label >A-T</label>
                                                 </div>  
                                             </div>
                                            
                                            <div class="col-xs-6 col-md-5" >
                                                <div class="form-group">
                                                 <input type="text" class="form-control" id="aceite_30_at" name="largorepa" placeholder="" required>
                                                 </div>  
                                             </div>
                                            
                                            <div class="col-xs-6 col-md-5" >
                                                <div class="form-group">
                                                 <input type="text" class="form-control" id="aceite_60_at" name="largorepa" placeholder="" required>
                                                 </div>  
                                             </div>
                                            
                                        </div>
                                        
                                    </div>
                                    
                                    
                                    <div class="row">
                                        
                                        <div class="col-sm-12">
                                            
                                            <div class="col-xs-6 col-md-2" >
                                                <div class="form-group">
                                                 <label >B-T</label>
                                                 </div>  
                                             </div>
                                            
                                            <div class="col-xs-6 col-md-5" >
                                                <div class="form-group">
                                                 <input type="text" class="form-control" id="aceite_30_bt" name="largorepa" placeholder="" required>
                                                 </div>  
                                             </div>
                                            
                                            <div class="col-xs-6 col-md-5" >
                                                <div class="form-group">
                                                 <input type="text" class="form-control" id="aceite_60_bt" name="largorepa" placeholder="" required>
                                                 </div>  
                                             </div>
                                            
                                        </div>
                                        
                                    </div>
                                    <hr/>
                                    <div class="row">
                                        
                                        <div class="col-sm-12">

                                            <div class="col-xs-6 col-md-12" >
                                                <div class="form-group">
                                                    <label>Encube</label>
                                                 <input type="text" class="form-control" id="encube" name="largorepa" placeholder="" required>
                                                 </div>  
                                             </div>
                                            
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                            </div>     
                            
                            <div class="row">
                                <div class="col-sm-12" style="background:#d66e2b; margin-top: 20px; margin-bottom: 10px;">
                                    <h3 class="modal-title" style="color:#fff;">Cascada</h3>
                                </div>
                                <div class="col-sm-12">
                                    <div class="row">
                                        
                                        <div class="col-sm-12">

                                            <div class="col-xs-6 col-md-12" >
                                                <div class="form-group">
                                                    <label>Tensión aplicada</label>
                                                 <input type="text" class="form-control" id="tension_aplicada2" name="largorepa" placeholder="" required>
                                                 </div>  
                                             </div>
                                            
                                        </div>
                                        
                                    </div>
                                    
                                    <div class="row">
                                        
                                        <div class="col-sm-12">

                                            <div class="col-xs-6 col-md-12" >
                                                <div class="form-group">
                                                    <label>Amperaje</label>
                                                 <input type="text" class="form-control" id="amperaje" name="largorepa" placeholder="" required>
                                                 </div>  
                                             </div>
                                            
                                        </div>
                                        
                                    </div>
                                    
                                    
                                    <div class="row">
                                        
                                        <div class="col-sm-12">

                                            <div class="col-xs-6 col-md-12" >
                                                <div class="form-group">
                                                    <label>Voltaje de salida</label>
                                                 <input type="text" class="form-control" id="voltaje_de_salida" name="largorepa" placeholder="" required>
                                                 </div>  
                                             </div>
                                            
                                        </div>
                                        
                                    </div>
                                    
                                    <div class="row">
                                        
                                        <div class="col-sm-12">

                                            <div class="col-xs-6 col-md-12" >
                                                <div class="form-group">
                                                    <label>Pintura</label>
                                                 <input type="text" class="form-control" id="pintura" name="largorepa" placeholder="" required>
                                                 </div>  
                                             </div>
                                            
                                        </div>
                                        
                                    </div>
                                    
                                    <div class="row">
                                        
                                        <div class="col-sm-12">

                                            <div class="col-xs-6 col-md-12" >
                                                <div class="form-group">
                                                    <label>Observaciones</label>
                                                 <input type="text" class="form-control" id="observaciones" name="largorepa" placeholder="" required>
                                                 </div>  
                                             </div>
                                            
                                        </div>
                                        
                                        <div class="col-xs-12 col-sm-6 col-md-8"> 
                                          <div class="form-group">
                                            <label >Responsable</label>
                                            <input type="text" class="form-control" id="resposable1" name="resposable" placeholder="Nombre de la persona" required readonly="true">
                                            <!--<select class="form-control" name="revicion2" title="" required>
                                                
                                            </select>-->
                                          </div>
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
                
                
                   
                     
                <!-- Modal update -->
                <div class="modal fade" id="update_motor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header" style="background:#d66e2b;">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title" id="myModalLabel">Estado de transformadores</h3>
                      </div>                     
                      
                      <div class="modal-body">
                      <p class="help-block"></p>
                      <!--<form role="form" action="#">-->
                            <div class="row">
                                <div class="col-sm-12" style="background:#d66e2b; margin-bottom: 10px;">
                                    <h3 class="modal-title" style="color:#fff;">Resultados de ensayos</h3>
                                </div>
                                <div class="col-sm-12">
                                    
                                        <div class="col-xs-6 col-md-12" >
                                           <div class="form-group">
                                            <label >Tensión aplicada</label>
                                            <input type="text" class="form-control" id="tension_aplicada1" name="largorepa" placeholder="" required>
                                          </div>  
                                        </div>

                                </div>
                                
                                 <div class="col-sm-12">
                                    
                                        <div class="col-xs-6 col-md-1" >
                                           <div class="form-group">
                                            <label >Relación de transformación</label>
                                            </div>  
                                        </div>
                                     <div class="col-sm-12">
                                     <div class="row">
                                         <div class="col-xs-6 col-md-2" >
                                           <div class="form-group">
                                            <label >F-F</label>
                                            </div>  
                                        </div>
                                         
                                         <div class="col-xs-6 col-md-2" >
                                            <input type="text" class="form-control" id="ff111" name="largorepa" placeholder="" required>
                                        </div>
                                         
                                         <div class="col-xs-6 col-md-2" >
                                            <input type="text" class="form-control" id="ff121" name="largorepa" placeholder="" required>
                                        </div>
                                         <div class="col-xs-6 col-md-2" >
                                            <input type="text" class="form-control" id="ff131" name="largorepa" placeholder="" required>
                                        </div>
                                         
                                         <div class="col-xs-6 col-md-2" >
                                            <input type="text" class="form-control" id="ff141" name="largorepa" placeholder="" required>
                                        </div>
                                         
                                         <div class="col-xs-6 col-md-2" >
                                            <input type="text" class="form-control" id="ff151" name="largorepa" placeholder="" required>
                                        </div>
                                         
                                     </div>
                                     
                                     <div class="row">
                                         <div class="col-xs-6 col-md-2" >
                                           <div class="form-group">
                                            <label >F-F</label>
                                            </div>  
                                        </div>
                                         
                                         <div class="col-xs-6 col-md-2" >
                                            <input type="text" class="form-control" id="ff211" name="largorepa" placeholder="" required>
                                        </div>
                                         
                                         <div class="col-xs-6 col-md-2" >
                                            <input type="text" class="form-control" id="ff221" name="largorepa" placeholder="" required>
                                        </div>
                                         <div class="col-xs-6 col-md-2" >
                                            <input type="text" class="form-control" id="ff231" name="largorepa" placeholder="" required>
                                        </div>
                                         
                                         <div class="col-xs-6 col-md-2" >
                                            <input type="text" class="form-control" id="ff241" name="largorepa" placeholder="" required>
                                        </div>
                                         
                                         <div class="col-xs-6 col-md-2" >
                                            <input type="text" class="form-control" id="ff251" name="largorepa" placeholder="" required>
                                        </div>
                                         
                                     </div>
                                     
                                     <div class="row">
                                         <div class="col-xs-6 col-md-2" >
                                           <div class="form-group">
                                            <label >F-F</label>
                                            </div>  
                                        </div>
                                         
                                         <div class="col-xs-6 col-md-2" >
                                            <input type="text" class="form-control" id="ff311" name="largorepa" placeholder="" required>
                                        </div>
                                         
                                         <div class="col-xs-6 col-md-2" >
                                            <input type="text" class="form-control" id="ff321" name="largorepa" placeholder="" required>
                                        </div>
                                         <div class="col-xs-6 col-md-2" >
                                            <input type="text" class="form-control" id="ff331" name="largorepa" placeholder="" required>
                                        </div>
                                         
                                         <div class="col-xs-6 col-md-2" >
                                            <input type="text" class="form-control" id="ff341" name="largorepa" placeholder="" required>
                                        </div>
                                         
                                         <div class="col-xs-6 col-md-2" >
                                            <input type="text" class="form-control" id="ff351" name="largorepa" placeholder="" required>
                                        </div>
                                         
                                     </div>
                                     
                                     <div class="row">
                                         <div class="col-xs-6 col-md-2" >
                                           <div class="form-group">
                                            <label >F-N</label>
                                            </div>  
                                        </div>
                                         
                                         <div class="col-xs-6 col-md-2" >
                                            <input type="text" class="form-control" id="fn11" name="largorepa" placeholder="" required>
                                        </div>
                                         
                                         <div class="col-xs-6 col-md-2" >
                                            <input type="text" class="form-control" id="fn21" name="largorepa" placeholder="" required>
                                        </div>
                                         <div class="col-xs-6 col-md-2" >
                                            <input type="text" class="form-control" id="fn31" name="largorepa" placeholder="" required>
                                        </div>
                                         
                                         <div class="col-xs-6 col-md-2" >
                                            <input type="text" class="form-control" id="fn41" name="largorepa" placeholder="" required>
                                        </div>
                                         
                                         <div class="col-xs-6 col-md-2" >
                                            <input type="text" class="form-control" id="fn51" name="largorepa" placeholder="" required>
                                        </div>
                                         
                                     </div>
                                         
                                         <div class="row">
                                         <div class="col-xs-6 col-md-2" >
                                           <div class="form-group">
                                            <label >Corto circuito</label>
                                            </div>  
                                        </div>
                                         
                                         <div class="col-xs-6 col-md-2" >
                                             <label >X</label>
                                            <input type="text" class="form-control" id="corto_circuito_x1" name="largorepa" placeholder="" required>
                                        </div>
                                         
                                         <div class="col-xs-6 col-md-2" >
                                             <label >Y</label>
                                            <input type="text" class="form-control" id="corto_circuito_y1" name="largorepa" placeholder="" required>
                                        </div>
                                         <div class="col-xs-6 col-md-2" >
                                             <label >Z</label>
                                            <input type="text" class="form-control" id="corto_circuito_z1" name="largorepa" placeholder="" required>
                                        </div>
                                         
                                         <div class="col-xs-6 col-md-2" >
                                             <label >N</label>
                                            <input type="text" class="form-control" id="corto_circuito_n1" name="largorepa" placeholder="" required>
                                        </div>

                                         
                                     </div>
                                         
                                         
                                     </div>
                                     
                                </div>
                                
                            </div>
                            <!--  Bobina Segundaria---->
                            
                            <div class="row">
                                <div class="col-sm-12" style="background:#d66e2b; margin-top: 20px; margin-bottom: 10px;">
                                    <h3 class="modal-title" style="color:#fff;">En seco</h3>
                                </div>
                                <div class="col-sm-12">
                                    
                                        <div class="col-xs-6 col-md-1" >
                                           <div class="form-group">
                                            <label >Aislamiento (MEGUEO)</label>
                                            </div>  
                                        </div>
                                    
                                    <div class="row">
                                        
                                        <div class="col-sm-12">
                                            
                                            <div class="col-xs-6 col-md-2" >
                                                <div class="form-group">
                                                 <label ></label>
                                                 </div>  
                                             </div>
                                            
                                            <div class="col-xs-6 col-md-5" >
                                                <div class="form-group">
                                                 <label >30 segundos</label>
                                                 </div>  
                                             </div>
                                            
                                            <div class="col-xs-6 col-md-5" >
                                                <div class="form-group">
                                                 <label >60 segundos</label>
                                                 </div>  
                                             </div>
                                            
                                        </div>
                                        
                                    </div>
                                    
                                    <div class="row">
                                        
                                        <div class="col-sm-12">
                                            
                                            <div class="col-xs-6 col-md-2" >
                                                <div class="form-group">
                                                 <label >A-B</label>
                                                 </div>  
                                             </div>
                                            
                                            <div class="col-xs-6 col-md-5" >
                                                <div class="form-group">
                                                 <input type="text" class="form-control" id="seco_30_ab1" name="largorepa" placeholder="" required>
                                                 </div>  
                                             </div>
                                            
                                            <div class="col-xs-6 col-md-5" >
                                                <div class="form-group">
                                                 <input type="text" class="form-control" id="seco_60_ab1" name="largorepa" placeholder="" required>
                                                 </div>  
                                             </div>
                                            
                                        </div>
                                        
                                    </div>
                                    
                                    
                                    <div class="row">
                                        
                                        <div class="col-sm-12">
                                            
                                            <div class="col-xs-6 col-md-2" >
                                                <div class="form-group">
                                                 <label >A-T</label>
                                                 </div>  
                                             </div>
                                            
                                            <div class="col-xs-6 col-md-5" >
                                                <div class="form-group">
                                                 <input type="text" class="form-control" id="seco_30_at1" name="largorepa" placeholder="" required>
                                                 </div>  
                                             </div>
                                            
                                            <div class="col-xs-6 col-md-5" >
                                                <div class="form-group">
                                                 <input type="text" class="form-control" id="seco_60_at1" name="largorepa" placeholder="" required>
                                                 </div>  
                                             </div>
                                            
                                        </div>
                                        
                                    </div>
                                    
                                    
                                    <div class="row">
                                        
                                        <div class="col-sm-12">
                                            
                                            <div class="col-xs-6 col-md-2" >
                                                <div class="form-group">
                                                 <label >B-T</label>
                                                 </div>  
                                             </div>
                                            
                                            <div class="col-xs-6 col-md-5" >
                                                <div class="form-group">
                                                 <input type="text" class="form-control" id="seco_30_bt1" name="largorepa" placeholder="" required>
                                                 </div>  
                                             </div>
                                            
                                            <div class="col-xs-6 col-md-5" >
                                                <div class="form-group">
                                                 <input type="text" class="form-control" id="seco_60_bt1" name="largorepa" placeholder="" required>
                                                 </div>  
                                             </div>
                                            
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                            </div>    
                            
                            <div class="row">
                                <div class="col-sm-12" style="background:#d66e2b; margin-top: 20px; margin-bottom: 10px;">
                                    <h3 class="modal-title" style="color:#fff;">En aceite</h3>
                                </div>
                                <div class="col-sm-12">
                                    
                                        <div class="col-xs-6 col-md-1" >
                                           <div class="form-group">
                                            <label >Aislamiento (MEGUEO)</label>
                                            </div>  
                                        </div>
                                    
                                    <div class="row">
                                        
                                        <div class="col-sm-12">
                                            
                                            <div class="col-xs-6 col-md-2" >
                                                <div class="form-group">
                                                 <label ></label>
                                                 </div>  
                                             </div>
                                            
                                            <div class="col-xs-6 col-md-5" >
                                                <div class="form-group">
                                                 <label >30 segundos</label>
                                                 </div>  
                                             </div>
                                            
                                            <div class="col-xs-6 col-md-5" >
                                                <div class="form-group">
                                                 <label >60 segundos</label>
                                                 </div>  
                                             </div>
                                            
                                        </div>
                                        
                                    </div>
                                    
                                    <div class="row">
                                        
                                        <div class="col-sm-12">
                                            
                                            <div class="col-xs-6 col-md-2" >
                                                <div class="form-group">
                                                 <label >A-B</label>
                                                 </div>  
                                             </div>
                                            
                                            <div class="col-xs-6 col-md-5" >
                                                <div class="form-group">
                                                 <input type="text" class="form-control" id="aceite_30_ab1" name="largorepa" placeholder="" required>
                                                 </div>  
                                             </div>
                                            
                                            <div class="col-xs-6 col-md-5" >
                                                <div class="form-group">
                                                 <input type="text" class="form-control" id="aceite_60_ab1" name="largorepa" placeholder="" required>
                                                 </div>  
                                             </div>
                                            
                                        </div>
                                        
                                    </div>
                                    
                                    
                                    <div class="row">
                                        
                                        <div class="col-sm-12">
                                            
                                            <div class="col-xs-6 col-md-2" >
                                                <div class="form-group">
                                                 <label >A-T</label>
                                                 </div>  
                                             </div>
                                            
                                            <div class="col-xs-6 col-md-5" >
                                                <div class="form-group">
                                                 <input type="text" class="form-control" id="aceite_30_at1" name="largorepa" placeholder="" required>
                                                 </div>  
                                             </div>
                                            
                                            <div class="col-xs-6 col-md-5" >
                                                <div class="form-group">
                                                 <input type="text" class="form-control" id="aceite_60_at1" name="largorepa" placeholder="" required>
                                                 </div>  
                                             </div>
                                            
                                        </div>
                                        
                                    </div>
                                    
                                    
                                    <div class="row">
                                        
                                        <div class="col-sm-12">
                                            
                                            <div class="col-xs-6 col-md-2" >
                                                <div class="form-group">
                                                 <label >B-T</label>
                                                 </div>  
                                             </div>
                                            
                                            <div class="col-xs-6 col-md-5" >
                                                <div class="form-group">
                                                 <input type="text" class="form-control" id="aceite_30_bt1" name="largorepa" placeholder="" required>
                                                 </div>  
                                             </div>
                                            
                                            <div class="col-xs-6 col-md-5" >
                                                <div class="form-group">
                                                 <input type="text" class="form-control" id="aceite_60_bt1" name="largorepa" placeholder="" required>
                                                 </div>  
                                             </div>
                                            
                                        </div>
                                        
                                    </div>
                                    <hr/>
                                    <div class="row">
                                        
                                        <div class="col-sm-12">

                                            <div class="col-xs-6 col-md-12" >
                                                <div class="form-group">
                                                    <label>Encube</label>
                                                 <input type="text" class="form-control" id="encube1" name="largorepa" placeholder="" required>
                                                 </div>  
                                             </div>
                                            
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                            </div>     
                            
                            <div class="row">
                                <div class="col-sm-12" style="background:#d66e2b; margin-top: 20px; margin-bottom: 10px;">
                                    <h3 class="modal-title" style="color:#fff;">Cascada</h3>
                                </div>
                                <div class="col-sm-12">
                                    <div class="row">
                                        
                                        <div class="col-sm-12">

                                            <div class="col-xs-6 col-md-12" >
                                                <div class="form-group">
                                                    <label>Tensión aplicada</label>
                                                 <input type="text" class="form-control" id="tension_aplicada21" name="largorepa" placeholder="" required>
                                                 </div>  
                                             </div>
                                            
                                        </div>
                                        
                                    </div>
                                    
                                    <div class="row">
                                        
                                        <div class="col-sm-12">

                                            <div class="col-xs-6 col-md-12" >
                                                <div class="form-group">
                                                    <label>Amperaje</label>
                                                 <input type="text" class="form-control" id="amperaje1" name="largorepa" placeholder="" required>
                                                 </div>  
                                             </div>
                                            
                                        </div>
                                        
                                    </div>
                                    
                                    
                                    <div class="row">
                                        
                                        <div class="col-sm-12">

                                            <div class="col-xs-6 col-md-12" >
                                                <div class="form-group">
                                                    <label>Voltaje de salida</label>
                                                 <input type="text" class="form-control" id="voltaje_de_salida1" name="largorepa" placeholder="" required>
                                                 </div>  
                                             </div>
                                            
                                        </div>
                                        
                                    </div>
                                    
                                    <div class="row">
                                        
                                        <div class="col-sm-12">

                                            <div class="col-xs-6 col-md-12" >
                                                <div class="form-group">
                                                    <label>Pintura</label>
                                                 <input type="text" class="form-control" id="pintura1" name="largorepa" placeholder="" required>
                                                 </div>  
                                             </div>
                                            
                                        </div>
                                        
                                    </div>
                                    
                                    <div class="row">
                                        
                                        <div class="col-sm-12">

                                            <div class="col-xs-6 col-md-12" >
                                                <div class="form-group">
                                                    <label>Observaciones</label>
                                                 <input type="text" class="form-control" id="observaciones1" name="largorepa" placeholder="" required>
                                                 </div>  
                                             </div>
                                            
                                        </div>
                                        
                                        <div class="col-xs-12 col-sm-6 col-md-8"> 
                                          <div class="form-group">
                                            <label >Responsable</label>
                                            <input type="text" class="form-control" id="resposable" name="resposable1" placeholder="Nombre de la persona" required readonly="true">
                                            <!--<select class="form-control" name="revicion2" title="" required>
                                                
                                            </select>-->
                                          </div>
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