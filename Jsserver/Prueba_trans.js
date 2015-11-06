function guardarprueba(){
    jQuery.ajax({
        type: "POST",
        url: servidor+"prueba",
        dataType: "json",
        data: jsonRegistropruebastrans(),
        success: function (data, status, jqXHR) {
            if(data.estado == 1){
                //alert("Registrado");
            }
        },
        error: function (jqXHR, status) {
            alert("error ");
        }
    });
}

function jsonRegistropruebastrans(){
    return JSON.stringify({
        "Ff":       document.getElementsByName("ff")[0].value,
        "Ff1":      document.getElementsByName("ff1")[0].value,
        "Ff2":      document.getElementsByName("ff2")[0].value,
        "Ff3":      document.getElementsByName("ff3")[0].value,
        "Ff4":      document.getElementsByName("ff4")[0].value,
        "Ff5":      document.getElementsByName("ff5")[0].value,
        "Fn":       document.getElementsByName("fn")[0].value,
        "Fn1":      document.getElementsByName("fn1")[0].value,
        "X":        document.getElementsByName("x")[0].value,
        "X1":       document.getElementsByName("x1")[0].value,
        "Y":        document.getElementsByName("y")[0].value,
        "Y1":       document.getElementsByName("y1")[0].value,
        "Z":        document.getElementsByName("z")[0].value,
        "Z1":       document.getElementsByName("z1")[0].value,
        "Megueo":   document.getElementsByName("megueo")[0].value,
        "Id_trans": idmax
    });
}