$(document).ready(function () {

    $(".propuesta").hover(
            function () {
                $(this).find('.opciones').css('visibility', 'visible');
            }, function () {
        $(this).find('.opciones').css('visibility', 'hidden');
    }
    );

    $("<hr class=\"separador\">").insertBefore(".engloba.nivel-1");


    $(".titulo").on("click", function () {
        $(this).siblings().slideToggle();
    });

    $(".titulo").click(function () {
        elemento = $(this).find('.despliegue');
        if (elemento.hasClass('fa-angle-right')) {
            elemento.addClass('fa-angle-down');
            elemento.removeClass('fa-angle-right');
        } else {
            elemento.addClass('fa-angle-right');
            elemento.removeClass('fa-angle-down');
        }
    });

    $('#sticky').addClass('stick');
    $('#sticky').css('top', $(".navbar").outerHeight());

    $('.opciones > .btn').on('click', function () {
        ref = $(this).closest('.propuesta').data('referencia');
        idPropuesta = $(this).closest('.propuesta').data('idpropuesta');
        idCategoria = $(this).closest('.propuesta').data('idcategoria');
        act = $(this).data('accion');
        tex = $(this).closest('.propuesta').find('.textprop').text();
        
        //console.log(tex);
        $("#codigo_propuesta").text(ref);
        $("#texto_original").text(tex);
        $("#tipo").val(act);
        $("#idPropuesta").val(idPropuesta);
        $("#idCategoria").val(idCategoria);
        openNav();
    });


    tinymce.init({
        selector: '#texto_nuevo,#motivacion',
        language: 'es',
        statusbar: false,
        plugins: "lists",
        menubar: false,
        size: 'small',
        toolbar: 'bold italic | bullist',
        setup : function(ed) {
          ed.on('init', function() {              
              this.execCommand("fontSize", false, "10px");
          });
        }          
    });


});



$(function () {
    $(window).scroll(function () {
        //sticky_relocate();
        resultados = getClosestFromTop('.categoria.titulo:visible');

        cerca = resultados[0];
        actual = resultados[1];

        texto = $(cerca).children('span').text();
        nivel = $(cerca).data('nivel');
        actual_texto = $(actual).children('span').text();

        if (actual) {
            $('#sticky').text(actual_texto);
        } else {
            $('#sticky').text("Borrador - Programa electoral");
        }

    });
});

function getClosestFromTop(elementos) {

    var resultado;

    var previo = null;
    $(elementos).each(function () {

        distanciaTop = $(this).offset().top;
        scroll = $(window).scrollTop();
        alto = $(this).outerHeight();
        if (((distanciaTop - scroll) + alto) > $(".navbar").outerHeight() + $("#sticky").outerHeight()) {
            elemento = $(this);
            return false;
        }
        previo = this;
    });
    resultado = new Array(elemento, previo);
    return resultado;
}


function openNav() {
    $("#barra_enmiendas").width("320px");
}

function closeNav() {
    $("#barra_enmiendas").width("0px");
}
