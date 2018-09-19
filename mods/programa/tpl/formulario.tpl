

<div class="container">
    <div class="row">
        <div class="col-md-10">
            {if $accion=='add'}
                <h2>Añadir texto</h2>
                <h5>{$categoria->nombre}</h5>
            {/if}

            {if $accion=='mod'}    
                <h2>Modificar {$elementotipo} {$elemento->id}</h2>
                <h5>{$elemento->cat->nombre}</h5>
            {/if}

            {if $accion=='sup'}    
                <h2>Eliminar {$elementotipo} {$elemento->id}</h2>
                <h5>{$elemento->cat->nombre}</h5>
            {/if}    


        </div>

        <div class="col-md-2">
            <a class="btn btn-light" href="{$url_anterior}">Volver</a>
        </div>    

    </div>


    <form action="" name="formEnmienda" id="formEnmienda" class="{$version}" enctype="multipart/form-data" method="POST">

        <h4><strong><span id="codigo_propuesta"></span></strong></h4>


        <div class="alert alert-danger hide" id="error" name="error" role="alert">
            <h4 class="alert-heading">Errores</h4>
            <p>Se  han detectado los siguientes errores en el formulario. </p>
            <hr>
            <span id="lista_errores" name="lista_errores"></span>
        </div>      

        {include file="$baseAPP/tpl/csrf.tpl"}
        <input type="hidden" value="{$op}" id="tipo" name="tipo"/>
        <input type="hidden" value="{if (isset($elemento->id))}{$elemento->id}{else}0{/if}" id="idPropuesta" name="idPropuesta"/>
        <input type="hidden" value="{if (isset($categoria->id))}{$categoria->id}{else}{$elemento->cat->id}{/if}" id="idCategoria" name="idCategoria"/>
        <input type="hidden" value="{$ip}" id="ip" name="ip"/>

        {if $accion!='add'}
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="texto_original" class="add">Texto original</label>
                    <div id="texto_original">{$elemento->texto}</div>      
                </div>        
            </div>        
        {/if}

        {if $accion eq 'mod' or $accion eq 'add'}
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="redaccion" class="add">Texto propuesto</label>
                    <textarea id="redaccion" name="redaccion" rows="4"></textarea> 
                    <label>Si lo desea, puede adjuntar un fichero</label>
                    <label for="adjunto" class="btn btn-info">Pulse para adjuntar fichero</label>
                    <input type="file" id="adjunto" name="adjunto" class="hide">            
                </div>
                <div class="form-group col-md-6">
                    <label for="motivacion" class="add mod">Motivación de la enmienda</label>
                    <textarea id="motivacion" name="motivacion" rows="4"></textarea> 
                </div>          
            </div>
        {else}
            <div class="form-row">
                <div class="form-group col-md-12">
                    <div class="alert alert-danger" role="alert">
                        Va a sugerir eliminar la propuesta o párrafo
                    </div>
                </div>
            </div>
        {/if}




        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="nombre">Nombre/Entidad/Colectivo/Formación:</label>   
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
                <input type="text" name="cp" id="cp" maxlength="50" class="form-control" placeholder="CP">
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
                <button type="button" id="enviarFormulario"  name="enviarFormulario" class="btn btn-primary">Enviar</button>
            </div>
            <div class="form-group col-md-10">
                <div class="alert alert-success" id="enviarFormulario_OK" name="enviarFormulario_OK" role="alert">
                    <h4 class="alert-heading">¡Gracias!</h4>
                    <p>Tu enmienda al texto ha sido recibida correctamente que será revisada por el equipo de redacción. </p>
                    <hr>
                    <p class="mb-0">¡Acude al próximo <strong>patio provincial</strong>!</p>
                </div>                
            </div>
        </div>




    </form>
</div>