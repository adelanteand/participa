

<div class="container">
    <div class="row">
        <div class="col-md-10">
            <h2><strong>Inscripción en patio</strong></h2>
            <h4>{$patio->ciudad}</h4>
        </div>

        <div class="col-md-2 text-right">
            <a class="btn btn-light" href="{$url_anterior}">Volver</a>
        </div>    

    </div>


    <form action="" name="formInscripcion" id="formInscripcion" enctype="multipart/form-data" method="POST">

        <div class="alert alert-danger hide" id="error" name="error" role="alert">
            <h4 class="alert-heading">Errores</h4>
            <p>Se han detectado los siguientes errores en el formulario. </p>
            <hr>
            <span id="lista_errores" name="lista_errores"></span>
        </div>      

        {include file="$baseAPP/tpl/csrf.tpl"}

        <input type="hidden" value="{$patio->id}" id="patio" name="patio"/>        
        <input type="hidden" value="{$ip}" id="ip" name="ip"/>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="nombre">Nombre:</label>   
                <input type="text" class="form-control" maxlength="150" placeholder="Nombre" id="nombre" name="nombre">
            </div>
            <div class="form-group col-md-6">
                <label for="apellidos">Apellidos:</label>   
                <input type="text" class="form-control" maxlength="150" placeholder="Apellidos" id="apellidos" name="apellidos">
            </div>              
        </div>       

        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="email">Email:</label>
                <input type="email" class="form-control" maxlength="100" placeholder="Email" id="email" name="email">
            </div>
            <div class="form-group col-md-4">
                <label for="telefono">Teléfono:</label>
                <input type="text" class="form-control" maxlength="50" placeholder="Telefono" id="telefono" name="telefono">
            </div>     
            <div class="form-group col-md-4">
                <label for="cp">Código postal:</label>
                <input type="text" name="cp" id="cp" maxlength="5" class="form-control" placeholder="CP">
            </div>
        </div>   


        <div class="form-row">
            <div class="form-group col-md-6">
                Marque los ejes de su interés
                {$cuentaejes = 0}
                {foreach $ejes as $eje}
                    <div class="form-check">
                        <input class="form-check-input" type="radio" id="eje{$eje->id}" name="ejes" value="{$eje->id}">
                        <label class="form-check-label" for="eje{$eje->id}">
                            {if $eje->icono}
                                <i class="fas {$eje->icono}"></i>
                            {/if}                                                        
                            {$eje->nombre}
                            <strong>EJE {$cuentaejes}</strong>
                        </label>
                    </div>  
                    {$cuentaejes=$cuentaejes+1}                        
                {/foreach}
            </div>
            <div class="form-group col-md-3">
                Ludoteca
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="ludoteca" id="ludoteca_SI" value="1">
                    <label class="form-check-label" for="ludoteca_SI">
                        <strong>Necesita</strong> servicio de ludoteca
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="ludoteca" id="ludoteca_NO" value="0">
                    <label class="form-check-label" for="ludoteca_NO">
                        <strong>No</strong> necesita servicio de ludoteca
                    </label>
                </div>
                
                <hr>
                {if $patio->id != 9}
                Patio Andaluz
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="andaluz" id="andaluzSI" value="1">
                    <label class="form-check-label" for="andaluzSI">
                        <strong>Sí</strong>, tengo interés en participar en el Patio Andaluz del día 6 de Octubre
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="andaluz" id="andaluzNO" value="0">
                    <label class="form-check-label" for="andaluzNO">
                        <strong>No</strong>, no participaré en el Patio Andaluz
                    </label>
                </div>    
                {/if}

            </div>     
            <div class="form-group col-md-3">
                <label for="observaciones">Observaciones:</label>
                <input type="text" name="observaciones" id="observaciones" maxlength="250" class="form-control">
            </div>
        </div>          

        <div class="form-row">
            <div class="form-group col-md-12">
                <div class="alert alert-info" id="error" name="error" role="alert">
                    <div class="row">
                        <div class="col-md-1 text-right"><input type="checkbox" name="terminos" id="terminos"></div>
                        <div class="col-md-11"><label for="terminos">He leído y acepto la <a href="https://adelanteandalucia.org/legal" target="_blank">Política de Privacidad</a> y las condiciones y tratamientos de los datos personales que en ella se indican. Mediante la marcación de esta casilla doy mi consentimiento expreso al tratamiento de los datos personales que estoy facilitando en este formulario.</label></div>
                    </div>
                </div>
            </div>
        </div>     


        <div class="form-row">
            <div class="form-group col-md-2">
                <button type="button" id="enviarFormularioInscripcion"  name="enviarFormularioInscripcion" class="btn btn-primary">Enviar</button>
            </div>
            <div class="form-group col-md-10">
                <div class="alert alert-success" id="enviarFormularioInscripcion_OK" name="enviarFormularioInscripcion_OK" role="alert">
                    <h4 class="alert-heading">Tu inscripción ha sido correctamente. </h4>
                    <p><strong>¡Por favor, sea puntual</strong>! Tenemos mucho trabajo por delante :)</p>
                </div>                
            </div>
        </div>

    </form>
</div>