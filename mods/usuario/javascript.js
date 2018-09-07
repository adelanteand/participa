$(document).ready(function () {

    $("#btn-registro").on("click", function () {
        $(".registro").toggle("slow");
    });

    $("#eliminar_imagen").click(function () {        
        $.ajax({
            url: "/ajax/usuario/eliminar_imagen/",
            data: {
                "token" : $("#token").val(),
                "id": $("#eliminar_imagen_id").val()
            },
            type: 'post',
            success: function (json) {
                $("#no-imagen").show();
                $("#si-imagen").hide();
            }
        });
    });

    $(".showpwd a").on('click', function(event) {        
        event.preventDefault();
        elemento = $(this).closest('.showpwd');
        icono = $(this).find('svg');
        
        if(elemento.find('input').attr("type") == "text"){
            elemento.find('input').attr('type', 'password');
            icono.addClass( "fa-eye-slash" );
            icono.removeClass( "fa-eye" );
        }else if(elemento.find('input').attr("type") == "password"){
            elemento.find('input').attr('type', 'text');
            icono.removeClass( "fa-eye-slash" );
            icono.addClass( "fa-eye" );
        }
    });



});
