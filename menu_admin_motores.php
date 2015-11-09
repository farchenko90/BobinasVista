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
    <link rel="stylesheet" type="text/css" href="css/toastr.css">
    
    <script src="js/jquery-1.11.0.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/toastr.min.js"></script>
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
        
        function cargar(){
            location.href = "menu_admin_motores.php";
        }
        
        var d = new Date(); 
        var fentrega = d.getFullYear() + "-" + (d.getMonth() +1) + "-" + d.getDate();
        var NI = d.getDate() + "" + (d.getMonth() +1) + "" + d.getFullYear() + '' +d.getHours()+''+d.getMinutes()+''+d.getSeconds();
        var NomImg ="";
        var NomImg1 ="";
        var NomImgAnt = "";
        var fechaactual;

        $(document).ready(function(){
            fechaactual = d.getFullYear() + "-" + (d.getMonth() +1) + "-" + (d.getDate());
            document.getElementById('fechaact').value = fechaactual;
            //alert(document.getElementById('fechaact').value);
            //document.getElementsByName('fecha_user')[0].value = fentrega;
            mandarcorreo();
            ///Obtenemos la obtencion de una imagen para cargarla al servidor
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
                    //document.getElementsByName("foto_admin")[0].value = NomImg1;
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
            
            
            var cc = document.getElementsByName("ced")[0].value;
            
            verResponsable(cc);
            //verdatostipousuario(cc);
            cargarTabla();
            cargarresponsableadministrador();
            cargarTablaemplado(cc);
            obtenerfecha(cc);
        });
         
        function mandarcorreo(){
        }
            
        function validarnumeros(e){
            var key = window.Event ? e.which: e.keycode;
            return ((key>=48 && key<=57)||(key==8));
        }
        
        function initTabla(){
            //CONVERTIMOS NUESTRO LISTADO DE LA FORMA DEL JQUERY.DATATABLES- PASAMOS EL ID DE LA TABLA
            $('#dataTables-example').dataTable({
                //"sPaginationType": "full_numbers" //DAMOS FORMATO A LA PAGINACION(NUMEROS)
            });
        }
        var f3 = (d.getFullYear() + "-" + (d.getMonth() +1) + "-" +d.getDate());
        var f1 =  f3; //'6-7-2015';//fecha del sistema 
        //var f2='2015-07-09';//fecha de la base de datos
        
        
         restaFechas = function(f1,f2)
         {
             var aFecha1 = f1.split('-'); 
             var aFecha2 = f2.split('-'); 
             var fFecha1 = Date.UTC(aFecha1[0],aFecha1[1]-1,aFecha1[2]); 
             var fFecha2 = Date.UTC(aFecha2[0],aFecha2[1]-1,aFecha2[2]); 
             var dif = fFecha2 - fFecha1;
             var dias = Math.floor(dif / (1000 * 60 * 60 * 24)); 
             if(dias<=0){
                dias = "Listo";
             }
             return dias + " dias para terminar";
         }
        
        var fecha;
        function obtenerfecha(cc){
            jQuery.ajax({
                type: "GET",
                url: servidor+"fechamotor/"+cc,
                dataType: "json",
                success: function (data, status, jqXHR){
                    //alert(JSON.stringify(data));
                    for(var i=0 ; i < data.length; i++){
                        fecha = data[i].FeEntrega;
                        if(fentrega > fecha){
                                            
                        }else{
                            alertify.log("Esto es una notificación cualquiera."); 
                            return false;
                        }
                    }
                },
                error: function (jqXHR, status) {
                    alert("error cargar tabla");
                }
            });
        }
        
        //cargamos la tabla de el superadministrador 
        function cargarTabla(){
            var cc = document.getElementsByName("ced")[0].value;
            jQuery.ajax({
                     type: "GET",
                     url: servidor+"motor", 
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
                             //alert(JSON.stringify(data[i]));
                             //notificacion();
                             tabla.innerHTML += "<tr>"+
                             "<td>"+data[i].Num_serie+"</td>"+
                             "<td>"+data[i].Marca+"</td>"+
                             "<td>"+data[i].Cliente+"</td>"+
                             "<td>"+data[i].Fe_Ter+"</td>"+
                             "<td>"+data[i].Fe_Acor+"</td>"+
                             "<td><p style='color:"+color+"; font-size:17px'>"+data[i].Estado+"</p></td>"+    
                             "<td>"+data[i].Accion+"</td>"+    
                             "<td>"+data[i].Nom_Usu+"</td>"+     
                             "<td class='center'>"+"<a href='#' title='Eliminar' "+ 
                             "class='btn btn-danger btn-sm' id='' data-toggle='modal'"+ 
                             "data-target='#ver_motor_eli' onclick='verdatosmotor("+data[i].IdMotor+")'>"+
                             "<i class='fa fa-2x fa-eraser fa-fw'></i></a>"+
                             "<a href='menu_admin_motores_edit.php?id="+data[i].IdMotor+"' "+ 
                             "title='Editar' class='btn btn-success btn-sm' >"+
                             "<i class='fa fa-edit fa-2x fa-fw' id=''></i></a>"+
                             "<a onclick='enviar("+JSON.stringify(data[i])+");'"+
                             "title='Informe' class='btn btn-info btn-sm'>"+
                             "<i class='fa fa-file fa-2x fa-fw'></i></a>"+
                             "</td></tr>";
                            
                         }
                         initTabla();
                     },
                     error: function (jqXHR, status) {
                        initTabla();
                        alert("error cargar tabla motor");
                     }
                });
        }
        

        function enviar (id) {
            window.open(servidor+"reportemotor.php?uri='"+id.IdMotor+"'","_blank");
        }
        
        var idmotor
        ////ver datos del motor a eliminar
        function verdatosmotor(id){
            idmotor = id;
            verdatosmotorjson(id);
        }
        
        
        ////cargamos la tabla para un empleado motores
        function cargarTablaemplado(cc){
            //var cc = document.getElementsByName("ced")[0].value;
            jQuery.ajax({
                     type: "GET",
                     url: servidor+"tablamotor/"+cc, 
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
                             
                             if (data[i].Estado == "Terminado"){
                                color = "green";
                                f1 = data[i].Fe_Acor; 
                             }else{
                                f1 = (d.getFullYear() + "-" + (d.getMonth() +1) + "-" +d.getDate());
                             }
                             //notificacion();
                             tabla.innerHTML += "<tr>"+
                             "<td>"+data[i].Num_serie+"</td>"+
                             "<td>"+data[i].Marca+"</td>"+
                             "<td>"+data[i].Cliente+"</td>"+
                             "<td>"+data[i].Fe_Ter+"</td>"+
                             "<td>"+data[i].Fe_Acor+"</td>"+
                             "<td >"+restaFechas(f1,data[i].Fe_Acor)+"</td>"+
                             "<td><p style='color:"+color+"; font-size:17px'>"+data[i].Estado+"</p></td>"+    
                             "<td>"+data[i].Accion+"</td>"+    
                             "<td>"+data[i].Nom_Usu+"</td>"+     
                             "<td>"+"<a href='#' title='Eliminar' class='btn btn-danger btn-sm' id='' "+
                             "data-toggle='modal' data-target='#ver_motor_eli' "+
                             "onclick='verdatosmotor("+data[i].IdMotor+")'>"+
                             "<i class='fa fa-2x fa-eraser fa-fw'></i></a>"+
                             "<a href='menu_admin_motores_edit.php?id="+data[i].IdMotor+"' "+
                             "title='Editar' class='btn btn-success  btn-sm' >"+
                             "<i class='fa fa-edit fa-2x fa-fw' id=''></i></a>"+
                             "<a onclick='enviar("+JSON.stringify(data[i])+");'"+
                             "title='Informe' class='btn btn-info btn-sm'>"+
                             "<i class='fa fa-file fa-2x fa-fw'></i></a>"+
                             "</td></tr>";
                            
                         }
                         initTabla();
                     },
                     error: function (jqXHR, status) {
                         initTabla();
                         //alert("error cargar tabla");
                         
                     }
                });
        }

        function soloNumeros(e){
            var key = window.Event ? e.which : e.keyCode
            return (key >= 48 && key <= 57)
        }
        
        function sololetras(e){
            var key = window.Event ? e.which : e.keyCode
            return (key >= 97 && key <= 122 || key >=65 && key <= 90 || key == 32)
        }

        function historial(){
            location.href = ruta+"menu_admin_historial.php";
        }

        function buscarcliente(){
            var buscar = document.getElementsByName('buscar')[0].value;
            busquedaAvanzada(buscar);
        }

        function emailCheck(inputvalue){    
            var pattern=/^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/;
            var span=document.getElementById("emailError");
            if(pattern.test(inputvalue))
            {         
                span.innerHTML="correo valido";    
                var myRequest = new XMLHttpRequest();
                var response = myRequest.reponseText;
                myRequest.onreadystatechange = function()
                {
                    if(myRequest.readyState == 4 && myRequest.status == 200)
                    {
                        if(response.test(inputvalue))
                        {
                            span.innerHTML="already in use";
                        }
                        else
                        {
                            span.innerHTML="valid";
                        }
                    }

                    myRequest.open("POST", "email.php", true);
                    myRequest.send();
                }
            }
            else
            {   
                span.innerHTML="correo invalido"; 
            }
          }
        
        function llevar(){
            $('#agrega_motor').modal(); 
            $('#modalclientes').modal('hide');
            document.getElementsByName('nomb_user')[0].value = document.getElementById('textnom').value;
            document.getElementsByName('ape_user')[0].value = document.getElementById('textape').value;
            document.getElementsByName('dire_user')[0].value = document.getElementById('textdir').value;
            document.getElementsByName('tele_user')[0].value = document.getElementById('texttel').value;
            document.getElementsByName('ced_user')[0].value = document.getElementById('textced').value;
            document.getElementsByName('ciu_user')[0].value = document.getElementById('textciu').value;
            document.getElementsByName('idoculto')[0].value = document.getElementById('textid').value;
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
                
                    <h1 class="fa-rosa" style="border-bottom: 1px solid #eee;" id="tipouser">Lista De Motores</h1>
                    
                   
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                        <div class="well">
                        <?php if($_SESSION['rol']=="Administrador" || $_SESSION['rol']=="Sub Admin"){ ?>
                            <button type="button" class="btn btn-naranja" data-toggle="modal" data-target="#agrega_motor"><i class="fa fa-plus fa-fw "></i> Agregar Nuevo Motor</button>
                            <button type="button" class="btn btn-naranja" data-toggle="modal" data-target="#modalclientes"><i class="fa fa-male fa-fw "></i> Cliente Registrados</button>
                            
                            <button type="button" class="btn btn-naranja" onclick="javascript:historial();"><i class="fa fa-h-square "></i> Ver Historial</button>
                            <?php } ?>
                        </div>
                        
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Motores Registrados
                        </div>

                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <?php if($_SESSION['rol']=="Administrador" || $_SESSION['rol']=="Sub Admin"){ ?>
                            <div class="table-responsive">
                                <table class="table table-condensed  table-hover table-bordered" id="dataTables-example">
                                    <thead>
                                        <tr class="fa-rosa danger" >
                                            <!--<th>#</th>-->
                                            <th># Serie</th>
                                            <th>Marca</th>
                                            <th>Cliente</th>
                                            <th title="fecha de ingreso">F. ingreso</th>
                                            <th title="fecha acordada de entrega">F. a. Entrega</th>
                                            <th>Estado</th>
                                            <th>Entrada</th>
                                            <th>Responsable</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="" id="tbodytabla">

                                        
                                    </tbody>
                                </table>
                            </div>
                            
                            <?php }else{ ?>
                            
                            <div class="table-responsive">
                                <table class="table table-condensed  table-hover table-bordered" id="dataTables-example">
                                    <thead>
                                        <tr class="fa-rosa danger">
                                            <!--<th>#</th>-->
                                            <th># Serie</th>
                                            <th>Marca</th>
                                            <th>Cliente</th>
                                            <th title="fecha de ingreso">F. ingreso</th>
                                            <th title="fecha acordada de entrega">F. a. Entrega</th>
                                            <th title="Dias faltantes">Faltantes</th>
                                            <th>Estado</th>
                                            <th>Entrada</th>
                                            <th>Responsable</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="" id="tbodytabla1">

                                        
                                    </tbody>
                                </table>
                            </div>
                            
                            <?php } ?>
                            
                            <?php 
                echo "<input type='hidden' name='ced' value='".$_SESSION['id']."'";
            ?>
                            <!-- /.table-responsive -->
                            
                                
                                <!-- Modal -->
                <div class="modal fade" id="agrega_motor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header" style="background:#d66e2b;">
                        <h3 class="modal-title" id="myModalLabel">Nuevo Motor</h3>
                      </div>                     
                      
                      <div class="modal-body">
                      <p class="help-block">Los campos marcados con * son obligatorios</p>
                      <!--<form role="form" action="#">--->
                          <div class="row ">
                              <div class="col-xs-12 col-sm-3" >
                              
                                  <!--<div class="form-group">
                                <label >Foto Motor</label>
                                  <a href="foto_motor/motor1.jpg" target="_blank" ><div style="margin:auto;">
                                  <img src="foto_motor/motor1.jpg" style="max-width:100%; " title="Ver imagen"></div>
                                  </a>
                                    <input type="file" class="form-control" id="" name="foto_user" placeholder="Foto del usuario" >
                                  </div>-->
                                  
                                  <form class="frmInv1" name="frm_inv">
                                     <label>Foto</label>
                                     <img id="imgInv1" class="imbInv" src="foto_motor/motor1.jpg" width="100px" height="100px" style="margin-left: 5px;" /> 
                                     <input id="txtImagen" name="txtImagen" type="file" style="margin-top: 10px; border: none; box-shadow:none; width:145px"/>
                                     <br />
                                     <progress id="barInv1" style="position: relative; left: 15px;" value="0" max="100"></progress>
           
                                 </form>
                              </div>
                               
                                <div class="col-xs-12 col-sm-9">
                                  <div class="">
                                        <div class="col-xs-6 col-sm-6"> 
                                          <div class="form-group">
                                            <label >Nombre del Cliente<labe style="color: red"> *</labe></label>
                                            <input type="text" class="form-control nombre" id="" name="nomb_user" placeholder="Nombre de la persona" onKeyPress="return sololetras(event)">
                                          </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                           <div class="form-group">
                                            <label >Apellidos Del Cliente <labe style="color: red"> *</labe></label>
                                            <input type="text" class="form-control dire" id="" name="ape_user" placeholder="" required onKeyPress="return sololetras(event)">
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                          <div class="form-group">
                                            <label >Direccion <labe style="color: red"> *</labe></label>
                                            <input type="text" class="form-control ciudad" id="" name="dire_user" placeholder="" required>
                                            
                                          </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                           <div class="form-group">
                                            <label >Telefono <labe style="color: red"> *</labe></label>
                                            <input type="text" maxlength="10" size="10" class="form-control tele" id="" name="tele_user" placeholder="numero de telefono" onKeyPress="return soloNumeros(event)">
                                          </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                          <div class="form-group">
                                            <label >Fecha de ingreso</label>
                                            <input type="text" class="form-control" id="fechaact" name="fecha_user" placeholder="" readonly="true">
                                          </div>
                                        </div>
                                        
                                        <div class="col-xs-6 col-sm-6">
                                          <div class="form-group">
                                            <label >N.I <labe style="color: red"> *</labe></label>
                                            <input type="text" maxlength="10" size="10" class="form-control ns" id="" name="ced_user" placeholder="cedula"  required onKeyPress="return soloNumeros(event)">
                                          </div>
                                        </div>

                                        <div class="col-xs-6 col-sm-6">
                                          <div class="form-group">
                                            <label >Ciudad <labe style="color: red"> *</labe></label>
                                            <input type="text"  class="form-control ns" id="" name="ciu_user" placeholder="ciudad"  required >
                                          </div>
                                        </div>

                                        <div class="col-xs-6 col-sm-6">
                                          <div class="form-group">
                                            <label >correo <labe style="color: red"> *</labe></label>
                                            <span id="emailError"></span>
                                            <input type="email"  class="form-control ns" id="" name="correo_user" placeholder="email"  required onkeyup="emailCheck(this.value)">
                                          </div>
                                        </div>

                                        <div class="col-xs-6 col-sm-6">
                                          <div class="form-group">
                                            <input type="hidden"  class="form-control ns" id="" name="idoculto" placeholder=""  required >
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
                                            <label ># Serie Motor <labe style="color: red"> *</labe></label>
                                            <input type="text" class="form-control" id="" name="numserie" placeholder="" required>
                                          </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6"> 
                                          <div class="form-group">
                                            <label >Marca <labe style="color: red"> *</labe></label>
                                            <input type="text" class="form-control" id="" name="marca" placeholder="" required>
                                          </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                           <div class="col-xs-6">
                                               <div class="form-group">
                                                  <label >HP</label>
                                                  <input type="number" class="form-control" id="" name="hp" placeholder="" required>
                                               </div> 
                                           </div> 
                                           <div class="col-xs-6">
                                               <div class="form-group">
                                                  <label >KW</label>
                                                  <input type="number" class="form-control" id="" name="kw" placeholder="" required>
                                               </div> 
                                           </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                          <div class="form-group">
                                            <label >R.P.M</label>
                                            <input type="number" class="form-control" id="" name="rpm" placeholder="" required>
                                            
                                          </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                           <div class="form-group">
                                            <label >N° de fases</label>
                                            <input type="number" class="form-control" id="" name="fases" placeholder="">
                                          </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                           <div class="col-xs-7">
                                               <div class="form-group">
                                                  <label >Tp. Entrada</label>
                                                  <select class="form-control" name="tpentrada" title="Seleccione un tipo de entrada" required>
                                                        <option value="Rebobinado" selected>Rebobinado</option>
                                                        <option value="Mantenimiento">Mantenimiento</option>
                                                  </select>
                                               </div> 
                                           </div> 
                                           <div class="col-xs-5">
                                               <div class="form-group">
                                                  <label >Revision</label>
                                                  <select class="form-control" name="revicion" title="Seleccione un tipo de entrada" required>
                                                        <option value="si" selected>Si</option>
                                                        <option value="no">No</option>
                                                   </select>
                                               </div> 
                                           </div>
                                        </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                          <div class="form-group">
                                            <label >Cotizado</label>
                                            <input type="number" class="form-control" id="" name="cotizado" placeholder=""  required>
                                          </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                          <div class="form-group">
                                            <label >Autorizado</label>
                                            <input type="text" class="form-control" id="" name="autorizado" placeholder=""  required readonly="true">
                                          </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                          <div class="form-group">
                                            <label >F. acordada entrega</label>
                                            <input type="date" class="form-control"  id="feentrega" name=""  >
                                          </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                          <div class="form-group">
                                            <label >F. terminacion servicio</label>
                                            <input type="date" class="form-control" id="feterminacion" name="" >
                                          </div>
                                        </div>
                                        <?php if($_SESSION['rol']=="Jefe Motores" || $_SESSION['rol']=="Administrador" || $_SESSION['rol']=="Sub Admin"){ ?>
                                        <div class="col-xs-6 col-sm-6">
                                          <div class="form-group">
                                          <!--aca debe ir el q ingresa estos datos en este caso el que este logeado -->
                                            <label >Responsable</label>
                                            <!--<input type="text" class="form-control" id="resp" name="responsable" placeholder="" value="Admin logeado">-->
                                            <select class="form-control" name="revicion2" title="" required > 
                                                
                                            </select>
                                          </div>
                                        </div>
                                <?php }else {?>
                                       <div class="col-xs-6 col-sm-6">
                                          <div class="form-group">
                                          <!--aca debe ir el q ingresa estos datos en este caso el que este logeado -->
                                            <label >Responsable</label>
                    <input type="text" class="form-control" id="resp" name="revici" placeholder="" value="<?php echo $_SESSION['user'] ?>" >
                                            <input type="hidden" class="form-control" id="resp" name="revicion2" placeholder=""  value="<?php echo $_SESSION['id'] ?>" readonly="true">
                                          </div>
                                        </div>
                                <?php } ?>
                                        
                                        <div class="col-xs-6 col-sm-6">
                                          <div class="form-group" id="alerta">
                                                          
                                          </div>
                                       </div>
                                       
                                       
                                    
                               
                                </div>
                            
                                                  
                          <div class="modal-footer">
                          	<input class="btn btn-naranja boton" onclick="javascript:registrarcliente();" value="guardar"/>
                            <button type="button" class="btn btn-default" data-dismiss="modal" onclick="javascript:cargar()">Cancelar</button>
                          </div>                          
                        <!--</form>--> 
                        
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
            <!--</div>-->
            
            
            
            <!-- Modal Eliminar-->
                <div class="modal fade" id="ver_motor_eli" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog ">
                    <div class="modal-content">
                      <div class="modal-header"  style="background:#d66e2b;">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Eliminar Motor</h4>
                      </div>                     
                      
                      <div class="modal-body">
                        <div class="row ">
                              <div class="col-xs-12 col-sm-3" id="imgperfil1">
                              <a href="foto_persona/cabe2.jpg" target="_blank" >
                              <!--<div style="margin:auto;" id="imgperfil">-->
                              <!--<img  style="max-width:200px;" title="Ver imagen">-->
                              <!--<img id="imgperfil" src="foto_persona/cabe2.jpg" style="max-width:200px; " title="Ver imagen">-->
                              <!--</div>-->
                              </a>
                              </div>
                                <div class="col-xs-12 col-sm-9">
                                	<div class="">
                                        
                                    </div>
                                    <input type="hidden" id="oculta">
                                </div>
                                
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group" id="">
                                         <div class="col-xs-6 col-sm-6"><h4>Cliente:</h4><p id="vercliente" style="margin-left:80px; margin-top:-30px;width:220px;font: oblique 120% sans-serif bold;" ></p></div>
                                        <!--<div class="col-xs-6 col-sm-6"><h4 id="id">Apellido:</h4>Ruiz Dias</div>-->
                                        <div class="col-xs-6 col-sm-6"><h4 style="margin-left:180px">Marca:</h4><p id="vermarca" style="margin-left:250px; margin-top:-30px;width:170px;font: oblique 120% sans-serif bold;"></p></div>
                                        <div class="col-xs-6 col-sm-6"><h4># Serie:</h4><p id="verserie" style="margin-left:80px; margin-top:-30px;width:220px;font: oblique 120% sans-serif bold;"></p></div>
                                        <div class="col-xs-6 col-sm-6"><h4 style="margin-left:180px">Estado:</h4><p id="verestado" style="margin-left:250px; margin-top:-30px;width:170px;font: oblique 120% sans-serif bold;" ></p></div>
                                        <div class="col-xs-6 col-sm-6"><h4>Entrada:</h4><p id="verentrada"style="margin-left:80px; margin-top:-30px;width:220px;font: oblique 120% sans-serif bold;"></p></div>                     
                                        <div class="col-xs-6 col-sm-6" id="mostrar"></div>
                                        
                                        
                                    </div>
                                    <div class="form-group" id="alerta1">
                                                              
                                        </div>
                                </div>       
                            </div>
                         </div>
                         
                        <div class="modal-footer">
                            <button class="btn btn-naranja" onclick="javascript:eliminarmotor();" data-toggle="<modaleli></modaleli>">Eliminar</button>
                            
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                      </div>
                      </div>
                      
                      
                    </div>
                  </div>
                
                <!-- modal-->

    
            
            <div class="modal fade" id="modalclientes" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                      <div class="modal-header"  style="background:#d66e2b;">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Clientes Registrados</h4>
                      </div>  
                  <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-6 col-sm-6"> 
                          <div class="form-group">
                            <label>Buscar Cliente</label>
                            <input type="text" class="form-control nombre" id="" name="buscar" placeholder="Buscar X Cedula" >
                          </div>
                        </div>
                        <div class="col-xs-6 col-sm-6" style="margin-top: 4%"> 
                          <div class="form-group">
                            <button type="button" class="btn btn-primary" onclick="javascript:buscarcliente();">Buscar</button>
                          </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6 col-sm-6">
                            <div class="form-group">
                                <label>Nombre Del Cliente: </label>
                                <input type="hidden" class="form-control nombre" id="textid" name="buscar" >
                                <input type="hidden" class="form-control nombre" id="textdir" name="buscar" >
                                <input type="hidden" class="form-control nombre" id="textced" name="buscar" >
                                <input type="hidden" class="form-control nombre" id="textnom" name="buscar" >
                                <input type="hidden" class="form-control nombre" id="textape" name="buscar" >
                                <input type="hidden" class="form-control nombre" id="textciu" name="buscar" >
                                <h4 id="clientereg"></h4>
                            </div>
                        </div> 
                        <div class="col-xs-6 col-sm-6">
                            <div class="form-group">
                                <label>Telefono: </label>
                                <input type="hidden" class="form-control nombre" id="texttel" name="buscar" >
                                <h4 id="telereg"></h4>
                            </div>
                        </div> 
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="javascript:llevar()">Registrar Motor</button>
                  </div>
                </div>
              </div>
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