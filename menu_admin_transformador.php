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
    <script src="Jsserver/TransformadorServer.js" type="text/javascript"></script>
    <script src="Jsserver/Prueba_trans.js" type="text/javascript"></script>
    
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
        
        var cc;
        var d = new Date(); 
        var fentrega = d.getFullYear() + "-" + (d.getMonth() +1) + "-" + d.getDate();
        var NI = d.getDate() + "" + (d.getMonth() +1) + "" + d.getFullYear() + '' +d.getHours()+''+d.getMinutes()+''+d.getSeconds();
        var NomImg ="";
        var NomImg1 ="";
        var NomImgAnt = "";
        var idtrans;
        var fechaactual;
        
        $(document).ready(function(){
            
            document.getElementById('fechaact').value = d.getFullYear() + "-" + (d.getMonth() +1) + "-" + d.getDate();
            fechaactual = d.getFullYear() + "-" + (d.getMonth() +1) + "-" + (d.getDate()+1);
            
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
                            url: servidor+'upload2.php?n='+NI+"&e="+fileExtension,  
                            type: 'POST',
                            data: formData,
                            cache: false,
                            contentType: false,
                            processData: false,
                            //una vez finalizado correctamente
                            success: function(data){
                                //alert(servidor+"imagenesmotor/"+data);
                                document.getElementById("barInv1").value = 100;
                                document.getElementById("imgInv1").setAttribute("src",servidor+"imagenestransformador/"+data);
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
            
            /////////imagen 2
            
            ///Obtenemos la obtencion de una imagen para cargarla al servidor
            $('#txtImagen1').change(function()
                   {
                    var fileExtension = "";
                    document.getElementById("barInv2").value = 0;
                    var file = $("#txtImagen1")[0].files[0];
                    var fileName = file.name;
                    document.getElementById("barInv2").value = 30;
                    fileExtension = fileName.substring(fileName.lastIndexOf('.') + 1);
                    document.getElementById("barInv2").value = 70;
                    
                    NomImg1 = NI+"."+fileExtension;
                    //document.getElementsByName("foto_admin")[0].value = NomImg1;
                    if(isImage(fileExtension)){
                        var formData = new FormData($(".frmInv2")[0]);
                        //alert(JSON.stringify($(".frmInv1")[0]));
                        
                        $.ajax({
                            url: servidor+'upload3.php?n='+NI+"&e="+fileExtension,  
                            type: 'POST',
                            data: formData,
                            cache: false,
                            contentType: false,
                            processData: false,
                            //una vez finalizado correctamente
                            success: function(data){
                                document.getElementById("barInv2").value = 100;
                                document.getElementById("imgInv2").setAttribute("src",servidor+"imagenestransformador/"+data);
                            },
                            //si ha ocurrido un error
                            error: function(){
                                alert("error imagen2");
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
            
            
            cargarTabla();
            cc = document.getElementsByName("ced")[0].value;
            cargarTablaempleados(cc)
            //verdatostipousuario(cc);
            cargarresponsabletrans();
            mostrarcual();
            verResponsable(cc);
            
        });
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
                dias = "Listo! los";
             }
             return dias + " dias";
         }
        
        function cargar(){
            location.href = "menu_admin_transformador.php";
        }
            
        function initTabla(){
            //CONVERTIMOS NUESTRO LISTADO DE LA FORMA DEL JQUERY.DATATABLES- PASAMOS EL ID DE LA TABLA
            $('#dataTables-example').dataTable({
                //"sPaginationType": "full_numbers" //DAMOS FORMATO A LA PAGINACION(NUMEROS)
            });
        }
        
        function cargarTabla(){
            //var cc = document.getElementsByName("ced")[0].value;
            jQuery.ajax({
                     type: "GET",
                     url: servidor+"tablatrans", 
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
                             //href='menu_datos_bobina.php?id="+data[i].Id+"'
                             
                             
                             //notificacion();
                             tabla.innerHTML += "<tr>"+
                             "<td><a target='_blank' href='"+servidor+"imagenestransformador/"+data[i].Foto+"'><img src='"+servidor+"imagenestransformador/"+data[i].Foto+"' align='center' border='0' height='50px'; width='50px' style='border-radius:90px'></a></td>"+    
                             "<td>"+data[i].Marca+"</td>"+
                             "<td>"+data[i].Placa+"</td>"+
                             "<td>"+data[i].NomCliente+"</td>"+
                             "<td>"+data[i].Facor+"</td>"+
                             "<td>"+data[i].Fterm+"</td>"+
                             "<td><p style='color:"+color+"; font-size:17px'>"+data[i].Estado+"</p></td>"+    
                             "<td>"+data[i].Tipo+"</td>"+    
                             "<td>"+data[i].NomUsu+"</td>"+     
                             "<td class='center'>"+"<a href='#' title='Eliminar' class='btn btn-danger btn-sm' \n\
                             id='' data-toggle='modal' data-target='#ver_tran_eli' \n\
                             onclick='javascript:verdatostrans("+data[i].Id+")'>\n\
                             <i class='fa fa-2x fa-eraser fa-fw'></i></a><a  \n\
                              \n\
                             title='Siguiente' onclick='javascript:tipo("+data[i].Id+")' class='btn btn-primary  btn-sm' >\n\
                             <i class='fa fa-eye fa-2x fa-fw' id=''></i></a><a href='' \n\
                             title='Actualizar' onclick='javascript:vertrasnformador("+data[i].Id+")' \n\
                             class='btn btn-success btn-sm' data-toggle='modal' data-target='#editar_trans' >\n\
                             <i class='fa fa-edit fa-2x fa-fw' ></i></a>"+
                             "<a onclick='enviar("+JSON.stringify(data[i])+");'"+
                             "title='Editar' class='btn btn-info btn-sm'>"+
                             "<i class='fa fa-file fa-2x fa-fw'></i></a>"+
                             "</td></tr>";
                            
                         }
                         initTabla();
                     },
                     error: function (jqXHR, status) {
                         initTabla();
                         alert("error cargar tabla");
                     }
                });
        }

        function enviar (id) {
            window.open(servidor+"reportetransformador.php?uri='"+id.Id+"'","_blank");
        }

        
        function tipo(id){
            jQuery.ajax({
                type: "GET",
                url: servidor+"transformador/all/"+id, 
                dataType: "json",
                success: function (data, status, jqXHR) {
                    if(data!=null){
                        for(var i=0;i < data.length; i++){
                            if(data[i].Tipo=="Reparacion"){
                                location.href = "menu_datos_bobina.php?id="+id;
                            }else{
                                location.href = "menu_datos_estado_aceite.php?id="+id;
                            }
                        }
                    }

                },
                error: function (jqXHR, status) {
                    alert("error buscar user");
                }
           });
        }
        
        function verdatostrans(id){
            idtrans = id;
            verdatoseliminartransformador(id);
        }
        
        function cargarTablaempleados(cc){
            //var cc = document.getElementsByName("ced")[0].value;
            jQuery.ajax({
                     type: "GET",
                     url: servidor+"transformador/tablatrab/"+cc, 
                     dataType: "json",
                     success: function (data, status, jqXHR) {
                         vecCC = data;
                         var tabla = document.getElementById("tbodytabla1");//dataTables-example
                         tabla.innerHTML = "";
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
                                 "<td><a target='_blank' href='"+servidor+"imagenestransformador/"+data[i].Foto+"'><img src='"+servidor+"imagenestransformador/"+data[i].Foto+"' align='center' border='0' height='50px'; width='50px' style='border-radius:90px'></a></td>"+ 
                             "<td>"+data[i].Marca+"</td>"+
                             "<td>"+data[i].Placa+"</td>"+
                             "<td>"+data[i].Nombre+"</td>"+
                             "<td>"+data[i].Fe_Acor+"</td>"+
                             "<td>"+data[i].Fe_ter+"</td>"+
                             "<td><p>"+restaFechas(f1,data[i].Fe_Acor)+"</p></td>"+    
                             "<td style='color:"+color+"; font-size:17px'>"+data[i].Estado+"</td>"+    
                             "<td>"+data[i].Tipo+"</td>"+     
                             "<td class='center'>"+"<a href='#' title='Eliminar' class='btn btn-danger btn-sm' id='' \n\
                 data-toggle='modal' data-target='#ver_tran_eli' onclick='javascript:verdatostrans("+data[i].Id+")'>\n\
                <i class='fa fa-2x fa-eraser fa-fw'></i> </a><a  \n\
                              \n\
                             title='Siguiente' onclick='javascript:tipo("+data[i].Id+")' class='btn btn-primary  btn-sm' >\n\
                             <i class='fa fa-eye fa-2x fa-fw' id=''></i></a>\n\
                            <a href='' title='Actualizar' onclick='javascript:vertrasnformador("+data[i].Id+")' \n\
                            class='btn btn-success btn-sm' data-toggle='modal' data-target='#editar_trans'>\n\
                            <i class='fa fa-edit fa-2x fa-fw' ></i></a>"+
                            "<a onclick='enviar("+JSON.stringify(data[i])+");'"+
                            "title='Editar' class='btn btn-info btn-sm'>"+
                            "<i class='fa fa-file fa-2x fa-fw'></i></a>"+
                            "</td></tr>";
                            
                         }
                         initTabla();
                     },
                     error: function (jqXHR, status) {
                         initTabla();
                         alert("error cargar tabla");
                     }
                });
        }
        
        function vertrasnformador(id){
            getalltransformador(id);
        }
        
        function verdatosmotor(id){
            alert(id);
        }
        function historial(){
            location.href = ruta+"menu_admin_historial_transformador.php";
        }

        function soloNumeros(e){
            var key = window.Event ? e.which : e.keyCode
            return (key >= 48 && key <= 57)
        }

        function buscarcliente(){
            var buscar = document.getElementsByName('buscar')[0].value;
            busquedaAvanzada(buscar);
        }    

        function sololetras(e){
            var key = window.Event ? e.which : e.keyCode
            return (key >= 97 && key <= 122 || key >=65 && key <= 90 || key == 32)
        }


        function llevar(){
            $('#agrega_trasn').modal(); 
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
                
                    <h1 class="fa-rosa" style="border-bottom: 1px solid #eee;" id="tipouser">Lista De Transformadores</h1>
                    
                   
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                <div class="well">
                 <?php if($_SESSION['rol']=="Administrador" || $_SESSION['rol']=="Sub Admin"){ ?>
                        <button type="button" class="btn btn-naranja" data-toggle="modal" data-target="#agrega_trasn"><i class="fa fa-plus fa-fw "></i> Agregar Nuevo Transformador</button>
                        <button type="button" class="btn btn-naranja" data-toggle="modal" data-target="#modalclientes"><i class="fa fa-male fa-fw "></i> Cliente Registrados</button>
                   
                            <button type="button" class="btn btn-naranja" onclick="javascript:historial();"><i class="fa fa-h-square "></i> Ver Historial</button>
                            <?php } ?>
                </div>
                        
                    
                    
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Transformadores Registrados
                        </div>

                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <?php if($_SESSION['rol']=="Administrador" || $_SESSION['rol']=="Sub Admin"){ ?>
                            <div class="table-responsive">
                                <table class="table table-condensed  table-hover table-bordered" id="dataTables-example">
                                    <thead>
                                        <tr class="fa-rosa danger" >
                                            <th>Foto</th>
                                            <th>Marca</th>
                                            <th>N° Placa</th>
                                            <th>Cliente</th>
                                            <th title="fecha de ingreso">F. ingreso</th>
                                            <th title="fecha acordada de entrega">F. a. Entrega</th>
                                            <th>Estado</th>
                                            <th>T.Entrada</th>
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
                                        <tr class="fa-rosa danger" >
                                            <th>Foto</th>
                                            <th>Marca</th>
                                            <th>N° Placa</th>
                                            <th>Cliente</th>
                                            <th title="fecha de ingreso">F. ingreso</th>
                                            <th title="fecha acordada de entrega">F. a. Entrega</th>
                                            <th title="Dias faltantes">Faltantes</th>
                                            <th>Estado</th>
                                            <th>T.Entrada</th>
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
                <div class="modal fade" id="agrega_trasn" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header" style="background:#d66e2b;">
                        <h3 class="modal-title" id="myModalLabel">Nuevo Transformador</h3>
                      </div>                     
                      
                      <div class="modal-body">
                      <p class="help-block">Los campos marcados con * son obligatorios</p>
                      
                          <div class="row ">
                              <div class="col-xs-12 col-sm-3" >
                                <form class="frmInv1" name="frm_inv" >
                                     <label>Foto Transformador</label>
                                     <img id="imgInv1" class="imbInv" src="foto_motor/motor1.jpg" width="100px" height="100px" style="margin-left: 5%;" /> 
                                     <input  style="margin-top: 10px; border: none; box-shadow:none; width:145px" id="txtImagen" name="txtImagen" type="file" />
                                     <br />
                                     <progress id="barInv1" style="position: relative; left: 15px;" value="0" max="100"></progress>
           
                                 </form>
                              </div>
                                <div class="col-xs-12 col-sm-9">
                                  <div class="">
                                        <div class="col-xs-6 col-sm-6"> 
                                          <div class="form-group">
                                            <label >Nombre del Cliente <labe style="color: red"> *</labe></label>
                                            <input type="text" class="form-control" id="" onkeypress="return sololetras(event)" name="nomb_user" placeholder="Nombre de la persona" required>
                                          </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6"> 
                                          <div class="form-group">
                                            <label >Apellido del Cliente <labe style="color: red"> *</labe></label>
                                            <input type="text" class="form-control" id="" onkeypress="return sololetras(event)" name="ape_user" placeholder="Nombre de la persona" required>
                                          </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                           <div class="form-group">
                                            <label >Dirección <labe style="color: red"> *</labe></label>
                                            <input type="text" class="form-control" id="" name="dire_user" placeholder="" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                           <div class="form-group">
                                            <label >Telefono <labe style="color: red"> *</labe></label>
                                            <input type="text" maxlength="10" size="10" class="form-control" id="" name="tele_user" placeholder="numero de telefono" onKeyPress="return soloNumeros(event)">
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
                                            <input type="text" maxlength="10" size="10" class="form-control" id="" name="ced_user" placeholder=""  required onKeyPress="return soloNumeros(event)">
                                          </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                            <div class="form-group">
                                                <label >Ciudad <labe style="color: red"> *</labe></label>
                                                <input type="text" class="form-control" id="" name="ciu_user" placeholder="" required>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                          <div class="form-group">
                                            <label >correo <labe style="color: red"> *</labe></label>
                                            <span id="emailError"></span>
                                            <input type="email"  class="form-control ns" id="" name="emai_user" placeholder="email"  required onkeyup="emailCheck(this.value)">
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
                                    <h3 class="modal-title" style="color:#fff;">Datos del transformador</h3>
                                </div>
                                    
                                <div class="col-sm-12">
                                        <div class="col-xs-6 col-sm-6"> 
                                          <div class="form-group">
                                            <label >Marca <labe style="color: red"> *</labe></label>
                                            <input type="text" class="form-control" id="" name="marca" placeholder="" required>
                                          </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                           <div class="col-xs-6">
                                               <div class="form-group">
                                                  <label >N° Placa <labe style="color: red"> *</labe></label>
                                                  <input type="text" class="form-control" id="" name="nplaca" placeholder="" required>
                                               </div> 
                                           </div> 
                                           <div class="col-xs-6">
                                               <div class="form-group">
                                                  <label >KVA</label>
                                                  <input type="number" class="form-control" id="" name="kva" placeholder="" required>
                                               </div> 
                                           </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                          <div class="form-group">
                                            <label >T.P</label>
                                            <input type="number" class="form-control" id="" name="tp" placeholder="" required>
                                            
                                          </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                           <div class="form-group">
                                            <label >T.S</label>
                                            <input type="number" class="form-control" id="" name="ts" placeholder="">
                                          </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                           <div class="col-xs-7">
                                               <div class="form-group">
                                                  <label >Tp. Entrada</label>
                                                  <select class="form-control" name="tipo_usuario" title="Seleccione un tipo de entrada" required>
                                                        <option value="Reparacion" selected>Reparacion</option>
                                                        <option value="Mantenimiento">Mantenimiento</option>
                                                  </select>
                                               </div> 
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
                                            <input type="date" class="form-control" id="" name="fentrega" placeholder="" >
                                          </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                          <div class="form-group">
                                            <label >F. terminacion servicio</label>
                                            <input type="date" class="form-control" id="" name="fterminacion" placeholder="" >
                                          </div>
                                        </div>
                                       <?php if($_SESSION['rol']=="Jefe Transformadores" || $_SESSION['rol']=="Administrador" 
                                               || $_SESSION['rol']=="Sub Admin"){ ?> 
                                        <div class="col-xs-6 col-sm-6">
                                          <div class="form-group">
                                          <!--aca debe ir el q ingresa estos datos en este caso el que este logeado -->
                                            <label >Responsable</label>
                                            <!--<input type="text" class="form-control" id="resp" name="responsable" placeholder="" value="Admin logeado">-->
                                            <select class="form-control" name="revicion2" title="" required>
                                                
                                            </select>
                                          </div>
                                        </div>
                                        <?php }else{ ?>
                                            <div class="col-xs-6 col-sm-6">
                                              <div class="form-group">
                                                <label >Responsable</label>
                                                <input type="text" class="form-control" id="" name="revi" placeholder=""  value="<?php echo $_SESSION['user']; ?>" required readonly="true">
                                                <input type="hidden" class="form-control" id="resp" name="revicion2" placeholder="" value="<?php echo $_SESSION['id'] ?>">
                                              </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                          </div>
                          
                          <div class="row">
                                <div class="col-sm-12" style="background:#d66e2b;">
                                    <h3 class="modal-title" style="color:#fff;">Lista De Verificacion</h3>
                                </div>
                              <div class="col-sm-12">
                                    <!-----------------Formulario de lista-------------------------------------->
                          
                                        <form role="form" action="#" id="form1">
                                        <div class="col-xs-6 col-sm-6">
                                          <div class="form-group">
                                              <div class="checkbox">
                                                <label>
                                                  <input type="checkbox" id="desele" value="Descarga Electrica" name="checkbox">
                                                  Descarga Electrica
                                                </label>
                                              </div>
                                          </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                          <div class="form-group">
                                              <div class="checkbox">
                                                <label>
                                                  <input type="checkbox" id="desafm" value="Descarga Afmoferica" name="checkbox">
                                                  Descarga Afmosferica
                                                </label>
                                              </div>
                                          </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                          <div class="form-group">
                                              <div class="checkbox">
                                                <label>
                                                  <input type="checkbox" id="sobretension" value="Sobretension" name="checkbox">
                                                  Sobretension
                                                </label>
                                              </div>
                                          </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                          <div class="form-group">
                                              <div class="checkbox">
                                                <label>
                                                  <input type="checkbox" id="sobrecarga" value="Sobrecarga" name="checkbox">
                                                  Sobrecarga
                                                </label>
                                              </div>
                                          </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                          <div class="form-group">
                                              <div class="checkbox">
                                                <label>
                                                  <input type="checkbox" id="fal_man" value="Falta De Mantenimiento" name="checkbox">
                                                  Falta De Mantenimiento
                                                </label>
                                              </div>
                                          </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                          <div class="form-group">
                                              <div class="checkbox">
                                                <label>
                                                  <input type="checkbox" id="ef_inst" value="Efectos De Instalacion" name="checkbox">
                                                  Efectos De Instalacion
                                                </label>
                                              </div>
                                          </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-7">
                                          <div class="form-group">
                                              <div class="checkbox">
                                                <label>
                                                  <input type="checkbox" id="otros" value="Otros" name="checkbox" onclick="javascript:mostrarcual();">
                                                  Otros
                                                </label>
                                              </div>
                                          </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                          <div class="form-group" id="opcion">
                                            <label>Cual</label>
                                            <input type="text" class="form-control" name="txtcual" placeholder="" >
                                          </div>
                                        </div>
                                        
                                        <div class="col-xs-6 col-sm-6">
                                          <div class="form-group" id="opcion">
                                            <label >Observaciones</label>
                                             <textarea rows="4" style="min-width: 100%;" name="Observaciones" id="obser">
                                             </textarea>
                                          </div>
                                        </div>
                                        
                                        </form> 
                              </div>
                          </div>
                                        
                                    <!--  pruebas iniciales  --->
                          <div class="row">
                            <div class="col-sm-12" style="background:#d66e2b;">
                                <h3 class="modal-title" style="color:#fff;">Pruebas iniciales</h3>
                            </div>
                              <div class="col-sm-12">
                                  
                                  <form role="form" action="#" id="formulario">
                                        <div class="col-xs-6 col-sm-4" >
                                          <div class="form-group">
                                            <label style="padding-top: 10px;">F-F</label>
                                            <input type="text" class="form-control" id="" name="ff" placeholder="" required style="margin-left: 30px; margin-top: -30px; width:50%">
                                          </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-4" >
                                          <div class="form-group">
                                            <input type="text" class="form-control" id="" name="ff1" placeholder="" required style="margin-top:5px; margin-left: -70px; width: 70%">
                                          </div>
                                        </div><br><br><br>
                                      
                                      <!--   Aqui va las segunda -->
                                      <div class="col-xs-6 col-sm-4" >
                                          <div class="form-group">
                                            <label style="padding-top: 10px;">F-F</label>
                                            <input type="text" class="form-control" id="" name="ff2" placeholder="" required style="margin-left: 30px; margin-top: -30px; width:50%">
                                          </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-4" >
                                          <div class="form-group">
                                            <input type="text" class="form-control" id="" name="ff3" placeholder="" required style="margin-top:5px; margin-left: -70px; width: 70%">
                                          </div>
                                        </div><br><br><br>
                                      
                                      
                                      <div class="col-xs-6 col-sm-4" >
                                          <div class="form-group">
                                            <label style="padding-top: 10px;">F-F</label>
                                            <input type="text" class="form-control" id="" name="ff4" placeholder="" required style="margin-left: 30px; margin-top: -30px; width:50%">
                                          </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-4" >
                                          <div class="form-group">
                                            <input type="text" class="form-control" id="" name="ff5" placeholder="" required style="margin-top:5px; margin-left: -70px; width: 70%">
                                          </div>
                                        </div><br><br><br>
                                        
                                      <div class="col-xs-6 col-sm-4" >
                                          <div class="form-group">
                                            <label style="padding-top: 10px;">F-N</label>
                                            <input type="text" class="form-control" id="" name="fn" placeholder="" required style="margin-left: 30px; margin-top: -30px; width:50%">
                                          </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-4" >
                                          <div class="form-group">
                                            <input type="text" class="form-control" id="" name="fn1" placeholder="" required style="margin-top:5px; margin-left: -70px; width: 70%">
                                          </div>
                                        </div><br><br><br>
                                      
                                      <div class="col-xs-6 col-sm-4" >
                                          <div class="form-group">
                                            <label style="padding-top: 10px;">X</label>
                                            <input type="text" class="form-control" id="" name="x" placeholder="" required style="margin-left: 30px; margin-top: -30px; width:50%">
                                          </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-4" >
                                          <div class="form-group">
                                            <input type="text" class="form-control" id="" name="x1" placeholder="" required style="margin-top:5px; margin-left: -70px; width: 70%">
                                          </div>
                                        </div><br><br><br>
                                      
                                      <div class="col-xs-6 col-sm-4" >
                                          <div class="form-group">
                                            <label style="padding-top: 10px;">Y</label>
                                            <input type="text" class="form-control" id="" name="y" placeholder="" required style="margin-left: 30px; margin-top: -30px; width:50%">
                                          </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-4" >
                                          <div class="form-group">
                                            <input type="text" class="form-control" id="" name="y1" placeholder="" required style="margin-top:5px; margin-left: -70px; width: 70%">
                                          </div>
                                        </div><br><br><br>
                                      
                                      <div class="col-xs-6 col-sm-4" >
                                          <div class="form-group">
                                            <label style="padding-top: 10px;">Z</label>
                                            <input type="text" class="form-control" id="" name="z" placeholder="" required style="margin-left: 30px; margin-top: -30px; width:50%">
                                          </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-4" >
                                          <div class="form-group">
                                            <input type="text" class="form-control" id="" name="z1" placeholder="" required style="margin-top:5px; margin-left: -70px; width: 70%">
                                          </div>
                                        </div><br><br><br>
                                      <div class="col-xs-6 col-sm-4">
                                          <div class="form-group">
                                            <label >Megueo</label><br>
                                            <select class="form-control" name="megueo">
                                                <option value="Bueno" selected>Bueno</option>
                                                <option value="Malo">Malo</option>
                                            </select>
                                          </div>
                                      </div>
                                      
                                        <div class="col-xs-6 col-sm-6">
                                          <div class="form-group" id="alerta">
                                                          
                                          </div>
                                        </div>
                                      
                                    </form>
                                  
                              </div>
                          </div>
                                    
                                    
                                </div>
                            
                                                  
                          <div class="modal-footer">
                          	<input class="btn btn-naranja boton" onclick="javascript:registrarvector();" value="guardar"/>
                            <button type="button" class="btn btn-default" data-dismiss="modal" onclick="javascript:cargar()">Cancelar</button>
                          </div>                          
                        
                          
                        
                      </div>
                      
                        
                        
                        
                    </div>
                  </div>
                </div> <!-- modal-->
                
                <!-- Modal modificar trans -->
                <div class="modal fade" id="editar_trans" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog ">
                    <div class="modal-content">
                      <div class="modal-header"  style="background:#d66e2b;">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Modificar Transformador</h4>
                      </div>                     
                      
                      <div class="modal-body">
                        <div class="row ">
                              <div class="col-xs-12 col-sm-3" id="imgperfil" >
                                    
                                <form class="frmInv2" name="frmInv2" style="margin-left:40%">
                                     <label>Foto Transformador</label>
                                     <img id="imgInv2" class="imbInv" src="foto_motor/motor1.jpg" width="100px" height="100px" style="margin-left: 5px;" /> 
                                     <input  style="margin-top: 10px; border: none; box-shadow:none; width:143px" id="txtImagen1" name="txtImagen1" type="file" />
                                     <br />
                                     <progress id="barInv2" style="position: relative; left: 15px;" value="0" max="100"></progress>
           
                                 </form>
                                    
                              </div>
                                <div class="col-xs-12 col-sm-19">
                                	<div class="">
                                        
                                        <div class="col-xs-6 col-sm-6"> 
                                          <div class="form-group">
                                            <label >Marca</label>
                                            <input type="text" class="form-control" id="" name="marcamod" placeholder="" required>
                                          </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                           <div class="col-xs-6">
                                               <div class="form-group">
                                                  <label >N° Placa</label>
                                                  <input type="text" class="form-control" id="" name="nplacamod" placeholder="" required>
                                               </div> 
                                           </div> 
                                           <div class="col-xs-6">
                                               <div class="form-group">
                                                  <label >KVA</label>
                                                  <input type="text" class="form-control" id="" name="kvamod" placeholder="" required>
                                               </div> 
                                           </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                          <div class="form-group">
                                            <label >T.P</label>
                                            <input type="number" class="form-control" id="" name="tpmod" placeholder="" required>
                                            
                                          </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                           <div class="form-group">
                                            <label >T.S</label>
                                            <input type="tel" class="form-control" id="" name="tsmod" placeholder="">
                                          </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                           
                                               <div class="form-group">
                                                  <label >Tp. Entrada</label>
                                                  <select class="form-control" name="tipo_usuariomod" title="Seleccione un tipo de entrada" required>
                                                        <option value="Reparacion" selected>Reparacion</option>
                                                        <option value="Mantenimiento">Mantenimiento</option>
                                                  </select>
                                               </div> 
                                           
                                        </div>
                                        
                                        <div class="col-xs-6 col-sm-6">
                                          <div class="form-group">
                                            <label >F. acordada entrega</label>
                                            <input type="date" class="form-control" id="finicial" name="fentregamod" placeholder="" >
                                          </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                          <div class="form-group">
                                            <label >F. terminacion servicio</label>
                                            <input type="date" class="form-control" id="ffinal" name="fterminacionmod" placeholder="" >
                                          </div>
                                        </div>
                                        <?php if($_SESSION['rol']=="Jefe Transformadores" || $_SESSION['rol']=="Administrador" 
                                               || $_SESSION['rol']=="Sub Admin"){ ?> 
                                        <div class="col-xs-6 col-sm-6">
                                          <div class="form-group">
                                          <!--aca debe ir el q ingresa estos datos en este caso el que este logeado -->
                                            <label >Responsable</label>
                                            <!--<input type="text" class="form-control" id="resp" name="responsable" placeholder="" value="Admin logeado">-->
                                            <select class="form-control" name="revicion3" title="" required>
                                                
                                            </select>
                                          </div>
                                        </div>
                                        <?php }else{ ?>
                                            <div class="col-xs-6 col-sm-6">
                                              <div class="form-group">
                                                <label >Responsable</label>
                                                <input type="text" class="form-control" id="" name="revi" placeholder=""  value="<?php echo $_SESSION['user']; ?>" required readonly="true">
                                                <input type="hidden" class="form-control" id="resp" name="revicion3" placeholder="" value="<?php echo $_SESSION['id'] ?>">
                                              </div>
                                            </div>
                                        <?php } ?>
                                        
                                    </div>
                                
                                </div>
                                
                                <div class="col-xs-6 col-sm-6">
                                  <div class="form-group" id="alertamod">
                                        
                                  </div>
                                </div>
                            
                            </div>
                         </div>
                        
                        <div class="modal-footer">
                            <input class="btn btn-naranja" onclick="javascript:modificartransformador();" value="Actualizar">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                      </div>
                      </div>
                      
                      
                    </div>
                  </div>
                   
                     <!-- Modal Eliminar-->
                <div class="modal fade" id="ver_tran_eli" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog ">
                    <div class="modal-content">
                      <div class="modal-header"  style="background:#d66e2b;">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Eliminar Transformador</h4>
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
                                         <div class="col-xs-6 col-sm-6"><h4>Cliente:</h4><p id="vercliente1" style="margin-left:80px; margin-top:-30px;width:220px;font: oblique 120% sans-serif bold;" ></p></div>
                                        <!--<div class="col-xs-6 col-sm-6"><h4 id="id">Apellido:</h4>Ruiz Dias</div>-->
                                        <div class="col-xs-6 col-sm-6"><h4 style="margin-left:180px">Marca:</h4><p id="vermarca1" style="margin-left:250px; margin-top:-30px;width:170px;font: oblique 120% sans-serif bold;"></p></div>
                                        <div class="col-xs-6 col-sm-6"><h4># Placa:</h4><p id="verserie1" style="margin-left:80px; margin-top:-30px;width:220px;font: oblique 120% sans-serif bold;"></p></div>
                                        <div class="col-xs-6 col-sm-6"><h4 style="margin-left:180px">Estado:</h4><p id="verestado1" style="margin-left:250px; margin-top:-30px;width:170px;font: oblique 120% sans-serif bold;" ></p></div>
                                        <div class="col-xs-6 col-sm-6"><h4>Entrada:</h4><p id="verentrada1"style="margin-left:80px; margin-top:-30px;width:220px;font: oblique 120% sans-serif bold;"></p></div>                     
                                        <div class="col-xs-6 col-sm-6" id="mostrar"></div>
                                        
                                        
                                    </div>
                                    <div class="form-group" id="alerta1">
                                                              
                                        </div>
                                </div>       
                            </div>
                         </div>
                         
                        <div class="modal-footer">
                            <button class="btn btn-naranja" onclick="javascript:eliminartransformador();" data-toggle="<modaleli></modaleli>">Eliminar</button>
                            
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                      </div>
                      </div>
                      
                      
                    </div>
                  </div>



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
                            <input type="text" class="form-control nombre" id="" name="buscar" placeholder="Buscar X Cliente" >
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
                    <button type="button" class="btn btn-primary" onclick="javascript:llevar()">Registrar Transformador</button>
                  </div>
                </div>
              </div>
            </div>   
    



                
                
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
    <!--<script src="js/sb-admin.js"></script>--->

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