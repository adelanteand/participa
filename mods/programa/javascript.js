$(document).ready(function () {

    $(".engloba.sub, .descripcion, .grupo-propuestas").each(function () {
        $(this).hide();
    });

    $(".nivel-1.titulo").each(function () {        
        $(this).next('.descripcion').append("<hr>");
        $(this).show();
    });
    

    $( "<hr class=\"separador\">" ).insertBefore( ".engloba.nivel-1" );


    $(".titulo").on("click", function () {
        $(this).siblings().slideToggle();
    });
    
        $('#sticky').addClass('stick');
        $('#sticky').css('top', $(".navbar").outerHeight());    

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
        
        if (typeof actual !== 'undefined'){
            $('#sticky').text(actual_texto);
        } else {
            $('#sticky').text("Programa electoral");
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
        if (((distanciaTop - scroll)+alto) > $(".navbar").outerHeight()+ $("#sticky").outerHeight() ) {
            elemento = $(this);            
            return false;
        }
        previo = this;
    });
    resultado = new Array(elemento,previo);
    return resultado;
}