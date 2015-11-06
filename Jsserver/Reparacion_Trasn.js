function explode(){
    location.reload();   
}

/**
 * ESTADO DE ACEITE TRANSFORMADOR
 */
function guardarEstadoAceite(){
    if(estadobobina == false){
        alert("No se puede registrar ya esta completado");
    }else{
        toastr.options.positionClass = 'toast-top-center';
        //alert(jsonEstadoAceiteTrans());
        jQuery.ajax({
            type: "POST",
            url: servidor+"estadoAceiteTransformador/"+id['id'], 
            dataType: "json",
            data: jsonEstadoAceiteTrans(),
            success: function (data, status, jqXHR) {
                if(data.estado == 1){
                    toastr.info('Se Ha Registrado Este Transformador Correctamente');
                    setInterval(function(){location.reload();},2000);
                    //$('#dataTables-example').dataTable().fnDestroy();
                    //tablareparacion(id['id']);
                    //location.href = ruta + "menu_datos_estado_aceite.php?id="+id['id'];
                }
            },
            error: function (jqXHR, status) {
                alert("Erro usuario");
            }
        });
    }
}

function jsonEstadoAceiteTrans(){
    return JSON.stringify({
        "fecha" : document.getElementById("fecha").value,
        "pasada_arena" : document.getElementById("pasada_arena").value,
        "tiempo_filtro" : document.getElementById("tiempo_filtro").value,
        "temperatura_max" : document.getElementById("temperatura_max").value,
        "color" : document.getElementById("color").value,
        "tiempo_reposo_ini" : document.getElementById("tiempo_reposo_ini").value,
        "kv1" : document.getElementById("kv1").value,
        "kv2" : document.getElementById("kv2").value,
        "kv3" : document.getElementById("kv3").value,
        "kv4" : document.getElementById("kv4").value,
        "kv5" : document.getElementById("kv5").value,
        "kv6" : document.getElementById("kv6").value,
        "kv_total" : document.getElementById("kv_total").value,
        "tiempo_reposo1" : document.getElementById("tiempo_reposo1").value,
        "tiempo_reposo2" : document.getElementById("tiempo_reposo2").value,
        "tiempo_reposo3" : document.getElementById("tiempo_reposo3").value,
        "tiempo_reposo4" : document.getElementById("tiempo_reposo4").value,
        "tiempo_reposo5" : document.getElementById("tiempo_reposo5").value,
        "tiempo_reposo6" : document.getElementById("tiempo_reposo6").value,
        "tiempo_reposo_total" : document.getElementById("tiempo_reposo_total").value,
        "escala_chispometro" : document.getElementById("escala_chispometro").value,
        "aceite_trans" : document.getElementById("aceite_trans").value,
        "observaciones" : document.getElementById("observaciones").value,
        "responsable" : document.getElementById("responsable1").value
    });
}

function updateEstadoAceite(idi){
    toastr.options.positionClass = 'toast-top-center';
    jQuery.ajax({
         type: "PUT",
         url: servidor+"estadoAceiteTransformador/"+idi, 
         dataType: "json",
         data: jsonEstadoAceiteTransupdate(),
         success: function (data, status, jqXHR) {
             if(data.estado == 1){
                toastr.info('Se Ha Actualizado Este Transformador Correctamente');
                setInterval(function(){location.reload();},2000);
                //$('#dataTables-example').dataTable().fnDestroy();
                //tablareparacion(id['id']);
                //location.href = ruta + "menu_datos_estado_aceite.php?id="+id['id'];
             }
         },
         error: function (jqXHR, status) {
             //alert("Erro usuario");
         }
    });
}

function deleteEstadoAceite(idi){
    jQuery.ajax({
         type: "DELETE",
         url: servidor+"estadoAceiteTransformador/"+idi, 
         dataType: "json",
         success: function (data, status, jqXHR) {
             if(data.estado == 1){
                toastr.info('Se Ha Eliminado Este Estado Aceite Transformador Correctamente');
                //$('#dataTables-example').dataTable().fnDestroy();
                //tablareparacion(id['id']);
                //location.href = ruta + "menu_datos_estado_aceite.php?id="+id['id'];
             }
         },
         error: function (jqXHR, status) {
             //alert("Erro usuario");
         }
    });
}



function jsonEstadoAceiteTransupdate(){
    return JSON.stringify({
        "fecha" : document.getElementById("fecha1").value,
        "pasada_arena" : document.getElementById("pasada_arena1").value,
        "tiempo_filtro" : document.getElementById("tiempo_filtro1").value,
        "temperatura_max" : document.getElementById("temperatura_max1").value,
        "color" : document.getElementById("color1").value,
        "tiempo_reposo_ini" : document.getElementById("tiempo_reposo_ini1").value,
        "kv1" : document.getElementById("kv11").value,
        "kv2" : document.getElementById("kv21").value,
        "kv3" : document.getElementById("kv31").value,
        "kv4" : document.getElementById("kv41").value,
        "kv5" : document.getElementById("kv51").value,
        "kv6" : document.getElementById("kv61").value,
        "kv_total" : document.getElementById("kv_total1").value,
        "tiempo_reposo1" : document.getElementById("tiempo_reposo11").value,
        "tiempo_reposo2" : document.getElementById("tiempo_reposo21").value,
        "tiempo_reposo3" : document.getElementById("tiempo_reposo31").value,
        "tiempo_reposo4" : document.getElementById("tiempo_reposo41").value,
        "tiempo_reposo5" : document.getElementById("tiempo_reposo51").value,
        "tiempo_reposo6" : document.getElementById("tiempo_reposo61").value,
        "tiempo_reposo_total" : document.getElementById("tiempo_reposo_total1").value,
        "escala_chispometro" : document.getElementById("escala_chispometro1").value,
        "aceite_trans" : document.getElementById("aceite_trans1").value,
        "observaciones" : document.getElementById("observaciones1").value,
        "responsable" : document.getElementById("responsable1").value
    });
}

//#############################

/**
 * 
 * ESTADO DE TRANSFORMADOR
 */
function guardarEstadoTransformador(){
    if(estadobobina == false){
        alert("No se puede registrar ya esta completado");
    }else{
        //alert(id['id']);
        //alert(jsonEstadoTransformador());
        jQuery.ajax({
            type: "POST",
            url: servidor+"estadoTransformador/"+id['id'], 
            dataType: "json",
            data: jsonEstadoTransformador(),
            success: function (data, status, jqXHR) {
                if(data.estado == 1){
                    toastr.info('Estado Transformador Guardado Correctamente');
                    setInterval(function(){location.reload();},2000);
                    //$('#dataTables-example').dataTable().fnDestroy();
                    //tablareparacion(id['id']);
                    updatecambiarEstadoTransformador(id['id']);
                    //location.href = ruta + "menu_datos_estado_transformador.php?id="+id['id'];
                }
            },
            error: function (jqXHR, status) {
                alert("Error Estado Transformador");
            }
        });
    }
    
}

function updateEstadoTransformador(idi){
    jQuery.ajax({
         type: "PUT",
         url: servidor+"estadoTransformador/"+idi, 
         dataType: "json",
         data: jsonEstadoTransformadorupdate(),
         success: function (data, status, jqXHR) {
             if(data.estado == 1){
                toastr.info('Estado Transformador Guardado Correctamente');
                setInterval(function(){location.reload();},2000);
                 //$('#dataTables-example').dataTable().fnDestroy();
                 //tablareparacion(id['id']);
                 //location.href = ruta + "menu_datos_estado_transformador.php?id="+id['id'];
             }
         },
         error: function (jqXHR, status) {
             //alert("Erro usuario");
         }
    });
}

function updatecambiarEstadoTransformador(idi){
    jQuery.ajax({
         type: "PUT",
         url: servidor+"estadoAceiteTransformador/estado/"+idi, 
         dataType: "json",
         data: jsonEstadoTransformadorupdate(),
         success: function (data, status, jqXHR) {
             if(data.estado == 1){
                 alert("Actualizado correctamente");
                 $('#dataTables-example').dataTable().fnDestroy();
                 tablareparacion(id['id']);
                 location.href = ruta + "menu_datos_estado_transformador.php?id="+id['id'];
             }
         },
         error: function (jqXHR, status) {
             //alert("Erro usuario");
         }
    });
}

function deleteEstadoTransformador(idi){
    jQuery.ajax({
         type: "DELETE",
         url: servidor+"estadoTransformador/"+idi, 
         dataType: "json",
         success: function (data, status, jqXHR) {
             if(data.estado == 1){
                toastr.info('Estado Transformador Guardado Correctamente');
                setInterval(function(){location.reload();},2000);
                 //$('#dataTables-example').dataTable().fnDestroy();
                 //tablareparacion(id['id']);
                 //location.href = ruta + "menu_datos_estado_transformador.php?id="+id['id'];
             }
         },
         error: function (jqXHR, status) {
             //alert("Erro usuario");
         }
    });
}


function jsonEstadoTransformadorupdate(){
    
    return JSON.stringify({
            "tension_aplicada": document.getElementById("tension_aplicada1").value,
            "ff11": document.getElementById("ff111").value,
            "ff12": document.getElementById("ff121").value,
            "ff13": document.getElementById("ff131").value,
            "ff14": document.getElementById("ff141").value,
            "ff15": document.getElementById("ff151").value,
            "ff21": document.getElementById("ff211").value,
            "ff22": document.getElementById("ff221").value,
            "ff23": document.getElementById("ff231").value,
            "ff24": document.getElementById("ff241").value,
            "ff25": document.getElementById("ff251").value,
            "ff31": document.getElementById("ff311").value,
            "ff32": document.getElementById("ff321").value,
            "ff33": document.getElementById("ff331").value,
            "ff34": document.getElementById("ff341").value,
            "ff35": document.getElementById("ff351").value,
            "fn1":  document.getElementById("fn11").value,
            "fn2":  document.getElementById("fn21").value,
            "fn3":  document.getElementById("fn31").value,
            "fn4":  document.getElementById("fn41").value,
            "fn5":  document.getElementById("fn51").value,
            "corto_circuito_x": document.getElementById("corto_circuito_x1").value,
            "corto_circuito_y": document.getElementById("corto_circuito_y1").value,
            "corto_circuito_z": document.getElementById("corto_circuito_z1").value,
            "corto_circuito_n": document.getElementById("corto_circuito_n1").value,
            "seco_30_ab": document.getElementById("seco_30_ab1").value,
            "seco_30_at": document.getElementById("seco_30_at1").value,
            "seco_30_bt": document.getElementById("seco_30_bt1").value,
            "seco_60_ab": document.getElementById("seco_60_ab1").value,
            "seco_60_at": document.getElementById("seco_60_at1").value,
            "seco_60_bt": document.getElementById("seco_60_bt1").value,
            "aceite_30_ab": document.getElementById("aceite_30_ab1").value,
            "aceite_30_at": document.getElementById("aceite_30_at1").value,
            "aceite_30_bt": document.getElementById("aceite_30_bt1").value,
            "aceite_60_ab": document.getElementById("aceite_60_ab1").value,
            "aceite_60_at": document.getElementById("aceite_60_at1").value,
            "aceite_60_bt": document.getElementById("aceite_60_bt1").value,
            "encube": document.getElementById("encube1").value,
            "tension_aplicada2": document.getElementById("tension_aplicada21").value,
            "amperaje": document.getElementById("amperaje1").value,
            "voltaje_de_salida": document.getElementById("voltaje_de_salida1").value,
            "pintura": document.getElementById("pintura1").value,
            "observaciones": document.getElementById("observaciones1").value,
            "responsable": document.getElementById("resposable").value
    });
}


function jsonEstadoTransformador(){
    return JSON.stringify({
            "tension_aplicada": document.getElementById("tension_aplicada").value,
            "ff11": document.getElementById("ff11").value,
            "ff12": document.getElementById("ff12").value,
            "ff13": document.getElementById("ff13").value,
            "ff14": document.getElementById("ff14").value,
            "ff15": document.getElementById("ff15").value,
            "ff21": document.getElementById("ff21").value,
            "ff22": document.getElementById("ff22").value,
            "ff23": document.getElementById("ff23").value,
            "ff24": document.getElementById("ff24").value,
            "ff25": document.getElementById("ff25").value,
            "ff31": document.getElementById("ff31").value,
            "ff32": document.getElementById("ff32").value,
            "ff33": document.getElementById("ff33").value,
            "ff34": document.getElementById("ff34").value,
            "ff35": document.getElementById("ff35").value,
            "fn1":  document.getElementById("fn1").value,
            "fn2":  document.getElementById("fn2").value,
            "fn3":  document.getElementById("fn3").value,
            "fn4":  document.getElementById("fn4").value,
            "fn5":  document.getElementById("fn5").value,
            "corto_circuito_x": document.getElementById("corto_circuito_x").value,
            "corto_circuito_y": document.getElementById("corto_circuito_y").value,
            "corto_circuito_z": document.getElementById("corto_circuito_z").value,
            "corto_circuito_n": document.getElementById("corto_circuito_n").value,
            "seco_30_ab": document.getElementById("seco_30_ab").value,
            "seco_30_at": document.getElementById("seco_30_at").value,
            "seco_30_bt": document.getElementById("seco_30_bt").value,
            "seco_60_ab": document.getElementById("seco_60_ab").value,
            "seco_60_at": document.getElementById("seco_60_at").value,
            "seco_60_bt": document.getElementById("seco_60_bt").value,
            "aceite_30_ab": document.getElementById("aceite_30_ab").value,
            "aceite_30_at": document.getElementById("aceite_30_at").value,
            "aceite_30_bt": document.getElementById("aceite_30_bt").value,
            "aceite_60_ab": document.getElementById("aceite_60_ab").value,
            "aceite_60_at": document.getElementById("aceite_60_at").value,
            "aceite_60_bt": document.getElementById("aceite_60_bt").value,
            "encube": document.getElementById("encube").value,
            "tension_aplicada2": document.getElementById("tension_aplicada2").value,
            "amperaje": document.getElementById("amperaje").value,
            "voltaje_de_salida": document.getElementById("voltaje_de_salida").value,
            "pintura": document.getElementById("pintura").value,
            "observaciones": document.getElementById("observaciones").value,
            "responsable": document.getElementById("resposable1").value
    });
}

// ##################################



/**
 *guardar reparacion transformador
 */
function registrarReparacionTransformador(){
    if(estadobobina == false){
        alert("No se puede registrar ya esta completo");
    }else{
        jQuery.ajax({
            type: "POST",
            url: servidor+"reparacion", 
            dataType: "json",
            data: jsonguardarreparacion(),
            success: function (data, status, jqXHR) {
                if(data.estado == 1){
                    registrarReparacionTransformador2();
                }
            },
            error: function (jqXHR, status) {
                //alert("Erro usuario");
            }
        });
    }
}

function jsonguardarreparacion(){
    return JSON.stringify({
        "Largo_repa":       document.getElementsByName("largorepa")[0].value,           
        "Ancho_repa":       document.getElementsByName("anchorepa")[0].value,
        "Altu_repa":        document.getElementsByName("alturepa")[0].value,
        "Refri_repa":       document.getElementsByName("refrirepa")[0].value,
        "Bisel_repa":       document.getElementsByName("biselrepa")[0].value,
        "Fibra_repa":       document.getElementsByName("fibrarepa")[0].value,
        "Cali_repa":        document.getElementsByName("calirepa")[0].value,
        "Otros_repa":       document.getElementsByName("otrorepa")[0].value,
        "Nsecuencia":       document.getElementsByName("nsecuncia")[0].value,
        "Potencia":         document.getElementsByName("poteciapri")[0].value,
        "Vprimario":        document.getElementsByName("vprimario")[0].value,
        "Vsegundario":      document.getElementsByName("vsegundario")[0].value,
        "Idtran_repa":      geturl
    });
}

/**
 *Actualizar reparacion transformador
 */
function ActualizarReparacionTransformador(){
    toastr.options.positionClass = 'toast-top-center';
    jQuery.ajax({
        type: "PUT",
        url: servidor+"reparacion/primaria", 
        dataType: "json",
        data: jsonactualizarreparacion(),
        success: function (data, status, jqXHR) {
            if(data.estado == 1){
                toastr.info('Se Ha Actualizado Esta Bobina Correctamente');
                setInterval(function(){location.reload();},2000);
            }
        },
        error: function (jqXHR, status) {
            alert("Erro actualizar reparacion primaria");
        }
    });
    
}

function jsonactualizarreparacion(){
    return JSON.stringify({
        "Largo_repa":       document.getElementsByName("largorepa1")[0].value,           
        "Ancho_repa":       document.getElementsByName("anchorepa1")[0].value,
        "Altu_repa":        document.getElementsByName("alturepa1")[0].value,
        "Refri_repa":       document.getElementsByName("refrirepa1")[0].value,
        "Bisel_repa":       document.getElementsByName("biselrepa1")[0].value,
        "Fibra_repa":       document.getElementsByName("fibrarepa1")[0].value,
        "Cali_repa":        document.getElementsByName("calirepa1")[0].value,
        "Otros_repa":       document.getElementsByName("otrorepa1")[0].value,
        "Nsecuencia":       document.getElementsByName("nsecuncia1")[0].value,
        "Potencia":         document.getElementsByName("poteciapri1")[0].value,
        "Vprimario":        document.getElementsByName("vprimario1")[0].value,
        "Vsegundario":      document.getElementsByName("vsegundario1")[0].value,
        "Id_repa":          document.getElementsByName("idrepa")[0].value
    }); 
}

function modificarReparacionTransformador(id){
    jQuery.ajax({
         type: "PUT",
         url: servidor+"reparacion", 
         dataType: "json",
         data: jsonmodificareparacion(id),
         success: function (data, status, jqXHR) {
             if(data.estado == 1){
                 //alert("Se Modifico"); 
             }
         },
         error: function (jqXHR, status) {
             //alert("Erro usuario");
         }
    });
}

function jsonmodificareparacion(id){
    return JSON.stringify({
        "Id_repa": id
    });
}

function registrarReparacionTransformador2(){
    toastr.options.positionClass = 'toast-top-center';
    jQuery.ajax({
         type: "POST",
         url: servidor+"reparacion2", 
         dataType: "json",
         data: jsonguardarreparacion2(),
         success: function (data, status, jqXHR) {
             if(data.estado == 1){
                toastr.info('Se Ha Registrado Esta Bobbina');
                setInterval(function(){location.reload();},2000);
             }
         },
         error: function (jqXHR, status) {
             //alert("Erro usuario");
         }
    });
}
function jsonguardarreparacion2(){
    return JSON.stringify({
        "Largo_repa":       document.getElementsByName("largo1")[0].value,           
        "Ancho_repa":       document.getElementsByName("ancho1")[0].value,
        "Refri_repa":       document.getElementsByName("refri1")[0].value,
        "Bisel_repa":       document.getElementsByName("bisel1")[0].value,
        "Fibra_repa":       document.getElementsByName("fibra1")[0].value,
        "N2":               document.getElementsByName("n2")[0].value,
        "Bobinas":          document.getElementsByName("bobinas")[0].value,
        "Otros_repa":       document.getElementsByName("otros1")[0].value,
        "Nsecuencia":       document.getElementsByName("nsecuncia")[0].value,
        "Potencia":         document.getElementsByName("poteciapri")[0].value,
        "Vprimario":        document.getElementsByName("vprimario")[0].value,
        "Vsegundario":      document.getElementsByName("vsegundario")[0].value,
        "Tipo_conductor":   document.getElementsByName("tipoconductorrepa")[0].value,
        "Idtran_repa":      geturl
    });
}

/**
 *Actualizar reparacion secundaria transformador
 */
function ActualizarReparacionSecundariaTransformador(){
    //alert(jsonactualizarsecundariareparacion());
    jQuery.ajax({
        type: "PUT",
        url: servidor+"reparacion/secundaria", 
        dataType: "json",
        data: jsonactualizarsecundariareparacion(),
        success: function (data, status, jqXHR) {
            if(data.estado == 1){
                toastr.info('Se Ha Actualizado Esta Bobina Correctamente');
                setInterval(function(){location.reload();},2000);
            }
        },
        error: function (jqXHR, status) {
            alert("Erro actualizar reparacion segundaria");
        }
    });
    
}

function jsonactualizarsecundariareparacion(){
    return JSON.stringify({
        "Largo_repa":       document.getElementsByName("largorepa1")[0].value,           
        "Ancho_repa":       document.getElementsByName("anchorepa1")[0].value,
        "Tipo_conductor":   document.getElementsByName("alturepa1")[0].value,
        "Refri_repa":       document.getElementsByName("refrirepa1")[0].value,
        "Bisel_repa":       document.getElementsByName("biselrepa1")[0].value,
        "Fibra_repa":       document.getElementsByName("fibrarepa1")[0].value,
        "N2":               document.getElementsByName("calirepa1")[0].value,
        "Bobinas":          document.getElementsByName("calirepa1")[0].value,
        "Otros_repa":       document.getElementsByName("otrorepa1")[0].value,
        "Nsecuencia":       document.getElementsByName("nsecuncia1")[0].value,
        "Potencia":         document.getElementsByName("poteciapri1")[0].value,
        "Vprimario":        document.getElementsByName("vprimario1")[0].value,
        "Vsegundario":      document.getElementsByName("vsegundario1")[0].value,
        "Id_repa":          document.getElementsByName("idrepa")[0].value
    }); 
}


var estado;
//Tipo de dato o primario o segundario
function reparacionterminado(id1,id2,id3){
    jQuery.ajax({
         type: "GET",
         url: servidor+"reparacion/estado/"+id1+"/"+id2, 
         dataType: "json",
         success: function (data, status, jqXHR) {
             if(data!=null){
                for(var i=0;i < data.length; i++){
                    estado = data[i].Estado;
                    if(estado=="Terminado"){
                        cambiarestadotransf(id3);
                    }
                }
             }
         },
         error: function (jqXHR, status) {
             alert("error buscar reparacion terminado");
         }
    });
    
}

function DatosReparacion(id){
    var ocultar = document.getElementById('ocultar');
    var ocultar1 = document.getElementById('ocultar1');
    var boton = document.getElementById('botonprimaria');
    var boton1 = document.getElementById('botonsecundario');
    jQuery.ajax({
         type: "GET",
         url: servidor+"reparacion/datos/"+id, 
         dataType: "json",
         success: function (data, status, jqXHR) {
            for(var i=0; i<data.length;i++){
                if(data[i].tipo === 'Primaria'){
                    ocultar.style.display = 'none';
                    ocultar1.style.display = 'inline';
                    boton.style.display = 'inline';
                    boton1.style.display = 'none';
                    document.getElementsByName("largorepa1")[0].value = data[i].largo_repa;   
                    document.getElementsByName("anchorepa1")[0].value = data[i].ancho_repa;
                    document.getElementsByName("alturepa1")[0].value = data[i].altu_repa;
                    document.getElementsByName("refrirepa1")[0].value = data[i].refri_repa;
                    document.getElementsByName("biselrepa1")[0].value = data[i].bisel_repa;
                    document.getElementsByName("fibrarepa1")[0].value = data[i].fibra_repa;
                    document.getElementsByName("calirepa1")[0].value = data[i].cali_repa;
                    document.getElementsByName("otrorepa1")[0].value = data[i].otros_repa; 
                    document.getElementsByName("idrepa")[0].value = id;   
                }else{
                    boton.style.display = 'none';
                    ocultar1.style.display = 'none';
                    ocultar.style.display = 'inline';    
                    boton1.style.display = 'inline';
                    document.getElementsByName("largo11")[0].value = data[i].largo_repa;   
                    document.getElementsByName("ancho11")[0].value = data[i].ancho_repa;
                    document.getElementsByName("tipoconductorrepa1")[0].value = data[i].tipo_conductor;
                    document.getElementsByName("refri11")[0].value = data[i].refri_repa;
                    document.getElementsByName("fibra11")[0].value = data[i].fibra_repa;
                    document.getElementsByName("bisel11")[0].value = data[i].bisel_repa;
                    document.getElementsByName("n21")[0].value = data[i].n2;
                    document.getElementsByName("bobinas1")[0].value = data[i].bobinas;  
                    document.getElementsByName("otros11")[0].value = data[i].otros_repa;
                    document.getElementsByName("idrepa")[0].value = id;
                }

            }
                
         },
         error: function (jqXHR, status) {
             alert("error buscar reparacion terminado");
         }
    });
}


