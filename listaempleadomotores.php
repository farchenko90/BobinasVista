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
             var cc = document.getElementsByName("ced")[0].value;
              cargartabla(cc)
            
        });     
        

        function cargartabla(id){
            jQuery.ajax({
                     type: "GET",
                     url: servidor+"empleadosasignado/"+id, 
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
                             
                             
                          tabla.innerHTML += "<tr>"+
                         "<td margin-left:'5px';><a target='_blank' href='"+imgservidor+data[i].Foto+"'><img align='center'; src='"+imgservidor+data[i].Foto+"'; border='0' height='55px'; width='55px' style='border-radius:90px';></a></td>"+
                         "<td>"+data[i].Nomusu+"</td>"+
                         "<td>"+data[i].usuarios+"</td>"+
                         "<td>"+data[i].Cedula+"</td>"+
                         "<td>"+data[i].Telefono+"</td>"+
                         "<td>"+data[i].Email+"</td>"
                         "</tr>";
                                   
                             

                             
                            
                             
                         }
                         initTabla();
                         //initTabla();btn btn-danger btn-sm
                     },
                     error: function (jqXHR, status) {
                         //initTabla();
                         alert("error cargar tabla");
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
                    <?php if($_SESSION['rol']=="Jefe Motores"  ){ ?>
                    <li class="" >
                        <a href="menu_admin_motores.php" style="background-color: rgb(125, 185, 185);">
                        <img src="img/engine22.png"  alt="Motores" title="Motores" >
                        </a>
                    </li>
                    <?php ?>
                    <?php }if($_SESSION['rol']=="Jefe Transformadores"){ ?>
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
                
                    <h1 class="fa-rosa" style="border-bottom: 1px solid #eee;">Lista De Empleados Asignados</h1>
                    
                   
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Usuarios Asignados
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
                                            <th>Telefono</th>
                                            <th>Correo</th>
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
