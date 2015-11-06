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
    <script src="Jsserver/Trabajadoresasignados.js" type="text/javascript"></script>
    <script src="Jsserver/Server.js" type="text/javascript"></script>
    <script src="Jsserver/UsuarioServer.js" type="text/javascript"></script>
    
    
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

        var d = new Date(); 
        var NI = d.getDate() + "" + (d.getMonth() +1) + "" + d.getFullYear() + '' +d.getHours()+''+d.getMinutes()+''+d.getSeconds();
        var NomImg ="";
        var NomImg1 ="";
        var NomImgAnt = "";
        
        function initTabla(){
                //CONVERTIMOS NUESTRO LISTADO DE LA FORMA DEL JQUERY.DATATABLES- PASAMOS EL ID DE LA TABLA
                $('#dataTables-example').dataTable({
                    //"sPaginationType": "full_numbers" //DAMOS FORMATO A LA PAGINACION(NUMEROS)
                });
        }
        
        function cargar(){
            location.href = "menu_admin_usuarios.php";
        }

        $(document).ready(function(){
             
            toastr.options.timeOut = 1500; // 1.5s
            
            cargarTabla();
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
                    
                    document.getElementsByName("foto_admin1")[0].value = NomImg1;
                    if(isImage(fileExtension)){
                        var formData = new FormData($(".frmInv1")[0]);
                        //alert(JSON.stringify($(".frmInv1")));
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
        
        function ver(cedula){
            verdatosusuario(cedula);
            
        }
        
        function verdatosmod(ced){
            modiverdatosusuario(ced);
        }
        
        function vereli(cedula){
          verdatosusuarioeliminar(cedula);
        }
        
        function validarnumeros(e){
            var key = window.Event ? e.which: e.keycode;
            return ((key>=48 && key<=57)||(key==8));
        }
        
        function cargarTabla(){
            var cc = document.getElementsByName("ced")[0].value;
            jQuery.ajax({
                     type: "GET",
                     url: servidor+"user", 
                     dataType: "json",
                     success: function (data, status, jqXHR) {
                         vecCC = data;
                         var tabla = document.getElementById("tbodytabla");//dataTables-example
                         tabla.innerHTML = "";
                         //alert(JSON.stringify(data));
                         if(data==null){
                            initTabla();
                         }
                         for(var i = 0; i < data.length ; i++){
                             
                             if(data[i].Tipo=="Jefe Motores" || data[i].Tipo=="Jefe Transformadores"){

                                tabla.innerHTML += "<tr>"+
                               "<td margin-left:'5px';><a target='_blank' href='"+imgservidor+data[i].Foto+"'><img align='center'; src='"+imgservidor+data[i].Foto+"'; border='0' height='55px'; width='55px' style='border-radius:90px';></a></td>"+
                               "<td>"+data[i].Nom_usu+"</td>"+
                               "<td>"+data[i].Telefono+"</td>"+
                               "<td>"+data[i].Tipo+"</td>"+
                               "<td>"+data[i].Email+"</td>"+
                               "<td class='center'>"+"<a href='#' title='eliminar' class='btn btn-danger btn-sm' data-toggle='modal' data-target='#ver_usuario_eli' onclick='javascript:vereli("+data[i].Cedula+")'><i class='fa fa-eye fa-2x fa-fw' ></i></a><a href='#' title='Editar' class='btn btn-success  btn-sm' data-toggle='modal' data-target='#editar_usuario' onclick='javascript:verdatosmod("+data[i].Cedula+")'><i class='fa fa-edit fa-2x fa-fw' id=''></i></a>"+
                               "<a href='#' title='Ver' class='btn btn-primary  btn-sm' data-toggle='modal' data-target='#ver_usuario' onclick='javascript:ver("+data[i].Cedula+")'><i class='fa fa-eye fa-2x fa-fw' ></i></a>"+
                               "<a href='#' title='Asignar empleados' class='btn btn-warning  btn-sm'  onclick='javascript:verjefe("+JSON.stringify(data[i])+")'><i class='fa fa-plus fa-2x fa-fw'></i></a>"+
                               "</td></tr>";
                                   
                             }else{

                                  tabla.innerHTML += "<tr>"+
                                 "<td margin-left:'5px';><a target='_blank' href='"+imgservidor+data[i].Foto+"'><img align='center'; src='"+imgservidor+data[i].Foto+"'; border='0' height='55px'; width='55px' style='border-radius:90px';></a></td>"+
                                 "<td>"+data[i].Nom_usu+"</td>"+
                                 "<td>"+data[i].Telefono+"</td>"+
                                 "<td>"+data[i].Tipo+"</td>"+
                                 "<td>"+data[i].Email+"</td>"+
                                 "<td class='center'>"+"<a href='#' title='eliminar' class='btn btn-danger btn-sm' data-toggle='modal' data-target='#ver_usuario_eli' onclick='javascript:vereli("+data[i].Cedula+")'><i class='fa fa-eye fa-2x fa-fw' ></i></a><a href='#' title='Editar' class='btn btn-success  btn-sm' data-toggle='modal' data-target='#editar_usuario' onclick='javascript:verdatosmod("+data[i].Cedula+")'><i class='fa fa-edit fa-2x fa-fw' id=''></i></a>"+
                                 "<a href='' title='Ver' class='btn btn-primary  btn-sm' data-toggle='modal' data-target='#ver_usuario' onclick='javascript:ver("+data[i].Cedula+")'><i class='fa fa-eye fa-2x fa-fw' ></i></a>"+
                                 "<a href='' title='Asignar empleados' class='btn btn-warning  btn-sm' ><i class='fa fa-plus fa-2x fa-fw'></i></a>"+
                                 "</td></tr>";

                             }

                             
                            
                             
                         }
                         initTabla();
                         //initTabla();btn btn-danger btn-sm
                     },
                     error: function (jqXHR, status) {
                         //initTabla();
                         alert("error cargar tabla");
                     }
                });
        };

          var idjefe;
          function verjefe(pl){
              var jefe = document.getElementById('jefe');
              jefe.innerHTML = "";
              if(pl.Tipo == 'Jefe Motores'){
                jefe.innerHTML = "<h5>"+pl.Nom_usu+" "+pl.Tipo+"</h5>";
                idjefe = pl.Idusu;
                verempleadomotores();
                $('#verempleados').modal('show')  
              }else if(pl.Tipo == 'Jefe Transformadores'){
                jefe.innerHTML = "<h5>"+pl.Nom_usu+" "+pl.Tipo+"</h5>";
                idjefe = pl.Idusu;
                verempleadotransformador();
                $('#verempleadostrans').modal('show')
              }
              
          }

          function verempleadomotores(){
              jQuery.ajax({
                   type: "GET",
                   url: servidor+"empleadosmotor", 
                   dataType: "json",
                   success: function (data, status, jqXHR) {
                       if(data!=null){
                           
                          var mot = document.getElementById('empleadomotores');
                          mot.innerHTML = "";
                          for(var i=0;i < data.length; i++){
                            
                              mot.innerHTML +=  

                                "<option value='"+data[i].Id+"' >"+data[i].Nombre+"</option>"

                                      
                            
                          }
                           
                      }

                   },
                   error: function (jqXHR, status) {
                       alert("error buscar user");
                   }
              });
              
          }

          function verempleadotransformador(){
              jQuery.ajax({
                   type: "GET",
                   url: servidor+"empleadostrans", 
                   dataType: "json",
                   success: function (data, status, jqXHR) {
                       if(data!=null){
                           
                          var mot = document.getElementById('empleadotrans');
                          mot.innerHTML = "";
                          for(var i=0;i < data.length; i++){
                            
                              mot.innerHTML +=  

                                "<option value='"+data[i].Id+"' >"+data[i].Nombre+"</option>"

                                      
                            
                          }
                           
                      }

                   },
                   error: function (jqXHR, status) {
                       alert("error buscar user");
                   }
              });
              
          }

          function verempleado(id){
              jQuery.ajax({
                   type: "GET",
                   url: servidor+"usuario/"+id, 
                   dataType: "json",
                   success: function (data, status, jqXHR) {
                       if(data!=null){
                           
                          var mostrar = document.getElementById('mostrar')
                          mostrar.innerHTML = "";
                          for(var i=0;i < data.length; i++){
                            
                              mostrar.innerHTML =  "<p style='color: red; fontsize='12px'>Desea asignar a: "+data[i].Nom_usu+" como trabajador de este usuario </p>"

                          }
                           
                      }

                   },
                   error: function (jqXHR, status) {
                       alert("error buscar user");
                   }
              });
              
          }


          function verempleadotran(id){
              jQuery.ajax({
                   type: "GET",
                   url: servidor+"usuario/"+id, 
                   dataType: "json",
                   success: function (data, status, jqXHR) {
                       if(data!=null){
                           
                          var mostrar = document.getElementById('mostrartran')
                          mostrar.innerHTML = "";
                          for(var i=0;i < data.length; i++){
                            
                              mostrar.innerHTML =  "<p style='color: red; fontsize='12px'>Desea asignar a: "+data[i].Nom_usu+" como trabajador de este usuario </p>"

                          }
                           
                      }

                   },
                   error: function (jqXHR, status) {
                       alert("error buscar user");
                   }
              });
              
          }

            var vect;
            function listamotores(){
                //alert(document.getElementById('empleadomotores').value);
                verempleado(document.getElementById('empleadomotores').value);

                vect = document.getElementById('empleadomotores').value;

            } 

            function listatrans(){
              verempleadotran(document.getElementById('empleadotrans').value);
              vect = document.getElementById('empleadotrans').value;

            }

            function guardarempleadotran(){
              if (document.getElementById('empleadotrans').value=="") {
                  toastr.info('No hay ningun trabajador asignado');
              }else{
                  asignarempleado();
                  cambiarestadotipo();  
              }
              
            }

            function guardarempleado(){
              if (document.getElementById('empleadomotores').value=="") {
                  toastr.info('No hay ningun trabajador asignado');
              }else{
                  asignarempleado();
                  cambiarestadotipo();  
              }
              
            }
          
          
          function soloNumeros(e){
            var key = window.Event ? e.which : e.keyCode
            return (key >= 48 && key <= 57)
          }

          function sololetras(e){
              var key = window.Event ? e.which : e.keyCode
              return (key >= 97 && key <= 122 || key >=65 && key <= 90 || key == 32)
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
                
                    <h1 class="fa-rosa" style="border-bottom: 1px solid #eee;">Lista De Empleados</h1>
                    
                   
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                <div class="well">
                    <button type="button" class="btn btn-naranja" data-toggle="modal" data-target="#agrega_usuario"><i class="fa fa-plus fa-fw "></i> Agregar Nuevo Usuario</button>
                        </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Usuarios Registrados
                        </div>

                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-condensed  table-hover table-bordered" id="dataTables-example">
                                    <thead>
                                        <tr class="fa-rosa danger" >
                                            <th>Foto</th>
                                            <th>Nombres Apellidos</th>
                                            <th>Telefono</th>
                                            <th>Tipo Usuario</th>
                                            <th>Correo</th>
                                            <th>Opciones</th>
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
                <div class="modal fade" id="agrega_usuario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header" style="background:#d66e2b;">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title" id="myModalLabel">Nuevo Usuario</h3>
                      </div>                     
                      
                      <div class="modal-body">
                      <p class="help-block">Los campos marcados con * son obligatorios</p>
                      <!--form role="form" action="#"-->
                          <div class="row ">
                              <div class="col-xs-12 col-sm-3" >
                            <!-- Imagen -->  
                            
                          <div class="form-group">
                            <!--<label >Foto</label>
                              <a href="foto_persona/cabe2.jpg" target="_blank" ><div style="margin:auto;">
                              <img src="foto_persona/cabe2.jpg" style="max-width:200px; " title="Ver imagen"></div>
                              </a>
                            <input type="file" class="form-control" id="" name="foto_user" placeholder="Foto del usuario" >-->
                            
                            <form class="frmInv1" name="frm_inv">
                                 <label>Foto</label><br /> <br /> 
                                 <img id="imgInv1" class="imbInv" src="foto_persona/cabe2.jpg" width="100px" height="100px" style="margin-left: 40px;" /> <br />
                                 <input style="margin-top: 10px; border: none; box-shadow:none; width:145px" id="txtImagen" name="txtImagen" type="file" />
                                 <br />
                                 <progress id="barInv1" style="position: relative; left: 15px;" value="0" max="100"></progress>
           
                            </form>
                            
                          </div>
                             
                              </div>
                                <div class="col-xs-12 col-sm-9">
                                  <div class="">
                                       <div class="form-group">
                                            <input type="hidden" class="form-control" name="foto_admin1"  required>
                                      </div>
                                        <div class="col-xs-6 col-sm-6"> 
                                          <div class="form-group">
                                            <label >Nombre<labe style="color: red"> *</labe></label>
                                            <input type="text" class="form-control" id="" name="nomb_user" onkeypress="return sololetras(event)" placeholder="Nombre de la persona" required>
                                          </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                           <div class="form-group">
                                            <label >Apellido<labe style="color: red"> *</labe></label>
                                            <input type="text" class="form-control" id="" name="apelli_user" onkeypress="return sololetras(event)" placeholder="Apellido de la persona" required>
                                          </div>  
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                          <div class="form-group">
                                            <label >N.I<labe style="color: red"> *</labe></label>
                                            <input type="text" maxlength="10" size="10" class="form-control" id="" name="docu_user" placeholder="Numero de documento de indentidad" required onKeyPress="return soloNumeros(event)">
                                            <p class="help-block">Nombre De Usuario.</p>
                                          </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                           <div class="form-group">
                                            <label >Telefono<labe style="color: red"> *</labe></label>
                                            <input type="text" maxlength="10" size="10" class="form-control" id="" name="tel_user" placeholder="numero de telefono" onKeyPress="return soloNumeros(event)">
                                          </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                          <div class="form-group">
                                            <label >Email<labe style="color: red"> *</labe></label>
                                            <span id="emailError"></span>
                                            <input type="email" class="form-control" id="" name="email_user" placeholder="Email" onkeyup="emailCheck(this.value)">
                                          </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                          <div class="form-group">
                                            <label >Tipo de Usuario<labe style="color: red"> *</labe></label>
                                            <select class="form-control" name="tipo_usuario" title="Seleccione un tipo de usuario" required>
                                                <option value="5" selected>Empleado Motores</option>
                                                <option value="3">Jefe motores</option>
                                                <option value="4">Empleado Transformadores</option>
                                                <option value="2">Jefe Transformadores</option>
                                                <option value="6">Sub Admin</option>
                                            </select>
                                          </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                          <div class="form-group">
                                            <label >Contraseña<labe style="color: red"> *</labe></label>
                                            <input type="password" class="form-control" id="" name="pass_user" placeholder="Ingresar contraseña"  required>
                                          </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                          <div class="form-group">
                                            <label >Validar Contraseña<labe style="color: red"> *</labe></label>
                                            <input type="password" class="form-control" id="" name="pass_user1" placeholder="Ingresar contraseña"  required>
                                          </div>
                                        </div>
                                        
                                       <div class="col-xs-6 col-sm-6">
                                          <div class="form-group" id="alerta">
                                                          
                                          </div>
                                       </div>
                                       
                                    </div>
                                
                                </div>
                                    
                            </div>
                                                  
                          <div class="modal-footer" id="alerta">
                          	<input id="linkButton" class="btn btn-naranja" onclick="javascript:agregarusuario();" value="Guardar">
                            <button type="button" class="btn btn-default" data-dismiss="modal" onclick="javascript:cargar()">Cancelar</button>
                          </div>                          
                        <!--/form--> 
                        
                      </div>
                      
                    </div>
                  </div>
                </div>
                
                
                   <!-- Modal -->
                <div class="modal fade" id="editar_usuario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header"  style="background:#d66e2b;">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Editar Usuario</h4>
                      </div>                     
                      
                      <div class="modal-body">
                        <p class="help-block">Los campos marcados con * son obligatorios</p>
                        <form role="form" action="#">
                          <div class="row ">
                              <div class="col-xs-12 col-sm-3" >
                              
                          <div class="form-group" id="editimg">
                            <label >Foto</label>
                              <a href="foto_persona/cabe2.jpg" target="_blank" ><div style="margin:auto;">
                              <!--<img src="foto_persona/cabe2.jpg" style="max-width:200px; " title="Ver imagen">--></div>
                              </a>
                            <input type="file" class="form-control" id="" name="foto_user" placeholder="Foto del usuario" >
                          </div>
                              </div>
                                <div class="col-xs-12 col-sm-9">
                                  <div class="">
                                        <div class="col-xs-6 col-sm-6"> 
                                          <div class="form-group">
                                            <label >Nombre Apellidos*</label>
                                            <input type="text" class="form-control" id="editnom" name="nomb_user" placeholder="Nombre de la persona" required>
                                          </div>
                                        </div>
                                        <!--<div class="col-xs-6 col-sm-6">
                                           <div class="form-group">
                                            <label >Apellido*</label>
                                            <input type="text" class="form-control" id="editape" name="apelli_user" placeholder="Apellido de la persona" required>
                                          </div>  
                                        </div>-->
                                        
                                        <div class="col-xs-6 col-sm-6">
                                           <div class="form-group">
                                            <label >Telefono</label>
                                            <input type="text" maxlength="10" size="10" class="form-control" id="edittel" name="tel_user" placeholder="numero de telefono" onKeyPress="return soloNumeros(event)">
                                          </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                          <div class="form-group">
                                            <label >Email</label>
                                            <input type="email" class="form-control" id="editema" name="email_user" placeholder="Email" >
                                          </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                          <div class="form-group">
                                            <label >Tipo de Usuario*</label>
                                            <select class="form-control" id="editsel" name="tipo_usuario" title="Seleccione un tipo de usuario" required>
                                                <option value="5" selected>Empleado Motores</option>
                                                <option value="3">Jefe motores</option>
                                                <option value="4">Empleado Transformadores</option>
                                                <option value="2">Jefe Transformadores</option>
                                                <option value="6">Sub Admin</option>
                                                <option value="1">Administrador</option>
                                            </select>
                                          </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                          <div class="form-group">
                                            <label >Contraseña*</label>
                                            <input type="password" class="form-control" id="editpas" name="pass_user" placeholder="Ingresar contraseña"  required>
                                          </div>
                                      </div>
                                        
                                      <div class="col-xs-6 col-sm-6">
                                          <div class="form-group">
                                            <label>Confirmar Contraseña*</label>
                                            <input type="password" class="form-control" id="editpas1" name="pass_user" placeholder="Ingresar contraseña"  required>
                                          </div>
                                      </div>

                                        <div class="col-xs-6 col-sm-6">
                                          <div class="form-group" id="alertamod">
                                                          
                                          </div>
                                       </div>
                                       
                                    </div>
                                
                                </div>
                                
                            </div>
                        
                                                  
                          <div class="modal-footer">
                            <input class="btn btn-naranja" onclick="javascript:editarperfil();" value="Guardar">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                          </div>                          
                        </form> 
                        
                      </div>
                      
                    </div>
                  </div>
                </div>
                
                
                   <!-- Modal -->
                <div class="modal fade" id="ver_usuario" tabindex="-1" role="dialog" 
                  aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog ">
                    <div class="modal-content">
                      <div class="modal-header"  style="background:#d66e2b;">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Datos del Usuario</h4>
                      </div>                     
                      
                      <div class="modal-body">
                        <div class="row ">
                              <div class="col-xs-12 col-sm-3" id="imgperfil">
                              <a href="foto_persona/cabe2.jpg" target="_blank" >
                              <!--<div style="margin:auto;" id="imgperfil">-->
                              <!--<img  style="max-width:200px;" title="Ver imagen">-->
                              <!--<img id="imgperfil" src="foto_persona/cabe2.jpg" style="max-width:200px; " title="Ver imagen">-->
                              <!--</div>-->
                              </a>
                              </div>
                                <div class="col-xs-12 col-sm-9">
                                	<div class="">
                                        <div class="col-xs-6 col-sm-6"><h4>Nombre Apellidos:</h4><p id="idnom"></p></div>
                                        <!--<div class="col-xs-6 col-sm-6"><h4 id="id">Apellido:</h4>Ruiz Dias</div>-->
                                        <div class="col-xs-6 col-sm-6" ><h4>N.I:</h4><p id="idced"></p></div>
                                        <div class="col-xs-6 col-sm-6"><h4>Telefono:</h4><p id="idtel"></p></div>
                                        <div class="col-xs-6 col-sm-6"><h4>Email:</h4><p id="idema"></p></div>
                                        <div class="col-xs-6 col-sm-6"><h4>Tipo de Usuario:</h4><p id="idtip"></p></div>
                                        
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
                
                
                <!-- Modal Eliminar-->
                <div class="modal fade" id="ver_usuario_eli" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog ">
                    <div class="modal-content">
                      <div class="modal-header"  style="background:#d66e2b;">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Eliminar Usuario</h4>
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
                                        <div class="col-xs-6 col-sm-6"><h4>Nombre Apellidos:</h4><p id="eliname"></p></div>
                                        <!--<div class="col-xs-6 col-sm-6"><h4 id="id">Apellido:</h4>Ruiz Dias</div>-->
                                        <div class="col-xs-6 col-sm-6"><h4>N.I:</h4><p id="eliced"></p></div>
                                        <div class="col-xs-6 col-sm-6"><h4>Telefono:</h4><p id="elitel"></p></div>
                                        <div class="col-xs-6 col-sm-6"><h4>Email:</h4><p id="eliemail"></p></div>
                                        <div class="col-xs-6 col-sm-6"><h4>Tipo de Usuario:</h4><p id="elitipo"></p></div>
                                        
                                    </div>
                                    <input type="hidden" id="oculta">
                                </div>
                                
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group" id="alertaeli">
                                                          
                                    </div>
                                </div>       
                            </div>
                         </div>
                         
                        <div class="modal-footer">
                            <button class="btn btn-naranja" onclick="javascript:Editarestadoinactivo();" data-toggle="<modaleli></modaleli>">Eliminar</button>
                            
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                      </div>
                      </div>
                      
                      
                    </div>
                  </div>



                  <div class="modal fade" id="verempleados" tabindex="-1" role="dialog" 
                  aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog ">
                    <div class="modal-content">
                      <div class="modal-header"  style="background:#d66e2b;">
                        <h4 class="modal-title" id="myModalLabel">Asignar Empleados</h4>
                      </div>                     
                      
                      <div class="modal-body">
                        <div class="row ">
                              <div class="col-xs-12 col-sm-3" id="imgperfil">
                              
                              </div>
                                <div class="col-xs-12 col-sm-9">
                                  <div id="jefe" style="margin-left: -35%">
                                    
                                  </div>
                                    <div class='col-xs-6' style="margin-left: -35%">
                                        <select id="empleadomotores" class="form-control" onclick='listamotores()'>
                                          
                                        </select>
                                    </div>
                                    <div class="col-xs-6" id="mostrar">
                                        
                                    </div>
                                </div>
                                
                            </div>
                         </div>
                        
                        <div class="modal-footer">
                        <button class="btn btn-naranja" onclick="javascript:guardarempleado();" data-toggle="<modaleli></modaleli>">Guardar</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                      </div>
                      </div>
                      
                      
                    </div>
                  </div>


                  <div class="modal fade" id="verempleadostrans" tabindex="-1" role="dialog" 
                  aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog ">
                    <div class="modal-content">
                      <div class="modal-header"  style="background:#d66e2b;">
                        <h4 class="modal-title" id="myModalLabel">Asignar Empleados</h4>
                      </div>                     
                      
                      <div class="modal-body">
                        <div class="row ">
                              <div class="col-xs-12 col-sm-3" id="imgperfil">
                              
                              </div>
                                <div class="col-xs-12 col-sm-9">
                                  <div id="jefe" style="margin-left: -35%">
                                    
                                  </div>
                                    <div class='col-xs-6' style="margin-left: -35%">
                                        <select id="empleadotrans" class="form-control" onclick='listatrans()'>
                                          
                                        </select>
                                    </div>
                                    <div class="col-xs-6" id="mostrartran">
                                        
                                    </div>
                                </div>
                                
                            </div>
                         </div>
                        
                        <div class="modal-footer">
                        <button class="btn btn-naranja" onclick="javascript:guardarempleadotran();" data-toggle="<modaleli></modaleli>">Guardar</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                      </div>
                      </div>
                      
                      
                    </div>
                  </div>
                
                <!-- modal-->                
                
                
                            </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            

            
            
            
            
        <!--</div>-->
        <!-- /#page-wrapper -->

    <!--</div>-->
    <!-- /#wrapper -->

    <!-- Core Scripts - Include with every page -->
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>

    <!-- Page-Level Plugin Scripts - Tables -->
    <script src="js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>

    <!-- SB Admin Scripts - Include with every page -->
    <!--<script src="js/sb-admin.js"></script>-->

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    /*$(document).ready(function() {
        $('#dataTables-example').dataTable();
		//selecciona el color dependiendo el tipo de usuario
				//cargartabla();	  
			  $('.tpu p').addClass("label label-info");			  
    });*/
	
	
    </script>

</body>

</html>
<?php }else{ ?>
<script>location.href = "inicio_sesion.php";</script>
<?php } ?>
