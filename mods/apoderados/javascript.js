var mymap;
var L;
var marker;
var grupoColegios;


$(document).ready(function () {

    cargarMapa();
    condicional_opciones();

    $('#fecha_nacimiento').datepicker();
    $("#error").hide();
    $("#enviarFormulario").on("click", function () {
        enviarFormulario();
    });

    $('.select2').select2({
        dropdownAutoWidth: true,
        width: '100%',
        placeholder: 'Elija una opción'
    });

    $(".select2.colegio").select2({
        containerCssClass: "listadoColegios",
        dropdownCssClass: "listadoColegios",
        templateResult: desplegable,
        templateSelection: seleccionado,
        disabled: true
    });

    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
        $('.select2').select2({
            minimumResultsForSearch: -1
        });
    }

    $('.select2.provincia').on('change', function (e, elegirMunicipio, elegirColegio) {
        $.ajax({
            url: '/ajax/apoderados/selectProvincia/',
            type: 'POST',
            dataType: 'JSON',
            data: {
                token: $('#token').val(),
                provincia: $(this).val()
            },
            beforeSend: function () {
                $('.select2.municipio, .select2.colegio').prop("disabled", true);
            },
            success: function (data) {
                $('.select2.municipio,  .select2.colegio').empty();
                $('.select2.municipio').prop("disabled", false);
                $.each(data, function (i, item) {
                    var newOption = new Option(data[i].municipio, data[i].municipio, true, true);
                    $(".select2.municipio").append(newOption);
                });
                $(".select2.municipio").val('').trigger('change');
                $('.select2.colegio').empty();


                if (typeof elegirMunicipio != 'undefined') {
                    $(".select2.municipio").val(elegirMunicipio).trigger('change', [elegirColegio]);
                }

            },
            error: function (e) {
                console.log(e);
            }
        });
    });

    $('.select2.municipio').on('change', function (e, elegirColegio) {
        $.ajax({
            url: '/ajax/apoderados/selectMunicipio/',
            type: 'POST',
            dataType: 'JSON',
            data: {
                token: $('#token').val(),
                municipio: $(this).val()
            },
            beforeSend: function () {
                $('.select2.colegio').empty();
                var newOption = new Option('Cargando...', '', true, true);
                $(".select2.colegio").append(newOption);
                $('.select2.colegio').prop("disabled", true);

            },
            success: function (data) {
                $('.select2.colegio').empty();
                $('.select2.colegio').prop("disabled", false);
                $.each(data, function (i, item) {
                    var newOption = new Option(data[i].nombre + "###" + data[i].direccion, data[i].id, true, true);
                    newOption.setAttribute("longitud", data[i].longitud);
                    newOption.setAttribute("latitud", data[i].latitud);
                    var nuevo = $(".select2.colegio").append(newOption);
                    //var punto = {lon: parseFloat(data[i].longitud), lat: parseFloat(data[i].latitud)};
                    //marker = L.marker(punto).addTo(grupoColegios).bindPopup(data[i].nombre);
                    //mymap.setView(punto, 15);
                    //marker.identificador = data[i].id;
                });
                $(".select2.colegio").val('').trigger('change');


                if (typeof elegirColegio != 'undefined') {
                    $(".select2.colegio").val(elegirColegio).trigger('change');
                }

            },
            error: function (e) {
                if (e.statusText != "OK") {
                    console.log(e);
                }
            }
        });
    });


    $("#voluntario, #apoderado").on("change", function () {
        condicional_opciones();
    });

    $('.select2.colegio').on('change', function () {
        if (!$('.select2.municipio').prop("disabled")) {
            var elemento = $('.select2.colegio').select2("data");
            if (elemento.length > 0 && typeof elemento[0].element.attributes.longitud != 'undefined') {
                longitud = elemento[0].element.attributes.longitud.value;
                latitud = elemento[0].element.attributes.latitud.value;
                nombre = elemento[0].element.label;
                identificador = elemento[0].element.value;
                mymap.setView({lon: parseFloat(longitud), lat: parseFloat(latitud)}, 18);
            }
        }
    });

    $(document).on('change', '#terminos', function () {
        if ($(this).is(':checked')) {
            $("#enviarFormulario").prop('disabled', false);
        } else {
            $("#enviarFormulario").prop('disabled', true);
        }
    });

    //$(".select2-search, .select2-focusser").remove(); 

});


function condicional_opciones() {
    
    var voluntario = false;
    var apoderado = false;
    
    voluntario = $('#voluntario').is(':checked');
    apoderado = $('#apoderado').is(':checked');
    
    if (apoderado){
        $(".bloque_apoderados").show();
    } else {
        $(".bloque_apoderados").hide();
    }
    
    if (voluntario || apoderado) {
        $(".bloque_elemental").show();
    } else {
        $(".bloque_elemental").hide();
    }
}


function desplegable(item) {
    lineas = item.text.split("###");
    if (lineas.length > 1) {
        var $returnString = $("<strong>" + lineas[0] + "</strong><br><span style='font-size:10px'>Direccion: " + lineas[1] + '<span>');
    } else {
        var $returnString = lineas[0];
    }

    return $returnString;
}


function seleccionado(item) {
    lineas = item.text.split("###");
    if (lineas.length > 1) {
        var $returnString = $("<strong>" + lineas[0] + "</strong> - <span style='font-size:10px'>Direccion: " + lineas[1] + '<span>');
    } else {
        var $returnString = lineas[0];
    }
    return $returnString;
}


function cargarMapa() {

    mymap = L.map('mapid').setView([37.272792, -4.120605], 7);
    L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoiYW5jYWZlIiwiYSI6ImNqbnhibDRjajBraXczdm5xcTVmMHlkNWkifQ.zXNQVzehzY7sA8lgduUTQw', {
        maxZoom: 18,
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
                '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        id: 'mapbox.streets'
    }).addTo(mymap);


}

function grupoColegiosClick(event) {
    //$('.select2.colegio').val(event.layer.identificador).trigger('change');

    if (typeof event.layer != 'undefined') {
        //console.log('provincia: '+event.layer.provincia);
        //console.log('municipio: '+event.layer.municipio);
        //console.log('colegio: '+event.layer.identificador);
        $(".select2.provincia").val(event.layer.provincia).trigger('change', [event.layer.municipio, event.layer.identificador]);
        $(".select2.municipio").val(event.layer.municipio).trigger('change', [event.layer.identificador]);
        $(".select2.colegio").val(event.layer.identificador).trigger('change');
    }

}




function enviarFormulario() {

    var validado = true;
    var voluntario = false;
    var apoderado = false;
    var msg = [];

    $("#error").hide();
    $("#lista_errores").empty();



    if ($('#voluntario').is(':checked')) {
        voluntario = true;
    } else {
        voluntario = false;
    }

    if ($('#apoderado').is(':checked')) {
        apoderado = true;
    } else {
        apoderado = false;
    }


    if (!$("#nombre").val()) {
        validado = false;
        msg.push("Revise su nombre");
    }

    if (!$("#apellido_1").val()) {
        validado = false;
        msg.push("Revise sus apellidos");
    }


    if (!$("#genero").val()) {
        validado = false;
        msg.push("Revise su género");
    }

    if (!validarEmail($("#email").val()) || !$("#email").val()) {
        validado = false;
        msg.push("Revise el correo electrónico");
    }

    if (!$("#telefono").val()) {
        validado = false;
        msg.push("Revise el teléfono de contacto");
    }

    if (!$("#DNI").val()) {
        validado = false;
        msg.push("Revise su DNI");
    }

    if (!$("#fecha_nacimiento").val()) {
        validado = false;
        msg.push("Revise su fecha de nacimiento");
    }

    if (!$("#movilidad").val()) {
        validado = false;
        msg.push("Seleccione una opción sobre movilidad reducida");
    }

    if (!$("#profesion").val()) {
        validado = false;
        msg.push("Indique una profesión");
    }

    if (!$("#dirprovincia").val()) {
        validado = false;
        msg.push("Seleccione una provincia");
    }

    if (!$("#dirmunicipio").val()) {
        validado = false;
        msg.push("Indique un municipio");
    }

    if (!$("#direccion").val()) {
        validado = false;
        msg.push("Indique su dirección");
    }

    if (!$("#cp").val()) {
        validado = false;
        msg.push("Revise el código postal");
    }

    if (apoderado && !$("#colegio").val()) {
        validado = false;
        msg.push("Elija un colegio electoral del desplegable o mapa");
    }

    if (validado) {
        //console.log('todo bien');
        $("#enviarFormulario").attr("disabled", true);
        $("#formApoderado").submit();
    } else {
        msg.forEach(function (el) {
            $("#lista_errores").append(el + "<br>");
        });
        $("#error").show();
        $("#error").removeClass("invisible d-print-none");
        $(window).scrollTop(0);
    }

}



function validarEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}
