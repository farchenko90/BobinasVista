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
        
        
        var ced;
        $(document).ready(function(){
             
            toastr.options.timeOut = 1500; // 1.5s
            ced = document.getElementsByName('ced')[0].value;

            usuariochat(ced);
            setInterval("bandejaentrada(clienteid,nombre)",10000);
            setInterval("bandejaentradausuario(id, nombre)",10000);
        });     
        
        var clienteid;
        var nombre;
        function usuariochat(id){
            //alert(id)
          jQuery.ajax({
               type: "GET",
               url: servidor+"user/chatusuario/"+id, 
               dataType: "json",
               success: function (data, status, jqXHR) {

                   if(data!=null){
                      clienteid = data.Id_cli;
                      nombre = data.Nom_usu;
                      bandejaentrada(clienteid,nombre);
                      bandejaentradausuario(id, nombre);
                   }
                   
               },
               error: function (jqXHR, status) {
                   alert("error buscar user");
               }
          });
        }
        
        var bandejaentrada = function(idcli,nom){
            jQuery.ajax({
                 type: "GET",
                 url: servidor+"bandejacliente/"+idcli+"/"+nom, 
                 dataType: "json",
                 success: function (data, status, jqXHR) {
                    if(data!=null){
                        var lista = document.getElementById('lista');
                        lista.innerHTML = "";
                        for(var i=0;i < data.length; i++){
                            //alert(JSON.stringify(data[i].mensaje))
                            lista.innerHTML += "<a target='_blank' class='list-group-item' style='margin-botton: 5%' href='"+ruta+"chat.php?id="+data[i].Idusu+"'>"+ 
                                    "<span class='fa fa-star-o'>"+
                                    " Mensajes De </span> <span>"+data[i].usuario+": "+data[i].mensaje+"</span></a>"
                        }
                         
                    }

                 },
                 error: function (jqXHR, status) {
                     alert("error buscar user");
                 }
            });
        }
          
        var bandejaentradausuario = function(idusu,nom){
            jQuery.ajax({
                 type: "GET",
                 url: servidor+"bandeja/"+idusu+"/"+nom, 
                 dataType: "json",
                 success: function (data, status, jqXHR) {
                    if(data!=null){
                        var lista = document.getElementById('lista');
                        lista.innerHTML = "";
                        for(var i=0;i < data.length; i++){
                            //alert(JSON.stringify(data[i].mensaje));
                            //alert(data[i].Tipo);
                            if(data[i].Tipo!='Usuario'){
                                lista.innerHTML += "<a target='_blank' class='list-group-item' style='margin-botton: 5%' href='"+ruta+"chatcliente.php?id="+data[i].IdCli+"'>"+ 
                                    "<span class='fa fa-star-o'>"+
                                    " Mensajes De </span> <span>"+data[i].usuario+": "+data[i].mensaje+"</span></a>"
                            }else{
                                lista.innerHTML += "<a target='_blank' class='list-group-item' style='margin-botton: 5%' href='"+ruta+"chatusuarios.php?id="+data[i].IdCli+"'>"+ 
                                    "<span class='fa fa-star-o'>"+
                                    " Mensajes De </span> <span>"+data[i].usuario+": "+data[i].mensaje+"</span></a>"
                            }
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
                    <?php if($_SESSION['rol']=="Administrador" || $_SESSION['rol']=="Sub Admin" 
                         || $_SESSION['rol']=="Jefe Motores" || 
                          $_SESSION['rol'] == "Empleado Motores"){ ?>
                    <!--<li class="" >
                        <a href="menu_admin_motores.php" style="background-color: rgb(125, 185, 185);">
                            <img src="img/engine22.png"  alt="Motores" title="Motores" >
                        </a>
                    </li>-->
                    <?php } ?>
                    <?php if($_SESSION['rol']=="Jefe Transformadores" || $_SESSION['rol'] == "Empleado Transformador" ||
                            $_SESSION['rol']=="Administrador" || $_SESSION['rol']=="Sub Admin"){ ?>
                    <!--<li class="" >
                        <a href="menu_admin_transformador.php" style="  background-color: rgb(146, 62, 63);"> 
                            <img src="img/transformadores.png"  title="Transformadores" alt="Transformadores" style>
                       </a>
                    </li>-->
                    <?php } ?>
                    <li class="" >
                        <a href="" style="  background-color: #616161;"> 
                            <img src="img/logotype181.png"  title="Bandeja De Entrada" alt="" style>
                        </a>
                    </li>
                    <li class="" >
                        <a href="iniciochat.php" style="  background-color: #009688"> 
                            <img src="img/chat.png"  title="Bandeja De Entrada" alt="" style>
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
                
                    <h1 class="fa-rosa" style="border-bottom: 1px solid #eee;">Bandeja De Entrada</h1>
                    
                    <div class="list-group">
                        <a href="#" class="list-group-item active" style="background-color: #424242">
                            <span class="glyphicon glyphicon-picture"></span> Tu Bandeja De Entrada <span class="badge">15</span>
                        </a>
                        <div id="lista">
                            
                        </div>
                        <!--<a href="#" class="list-group-item">
                            <span class="fa fa-star-o"></span> Mensajes <span class="badge">23</span>
                        </a>-->
                    </div>

                   
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                
                    
                        <!-- /.panel-body -->
                        <?php 
                echo "<input type='hidden' name='ced' value='".$_SESSION['id']."'";
            ?>
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
