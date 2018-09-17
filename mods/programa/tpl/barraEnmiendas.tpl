

<div id="barra_enmiendas" class="sidenav">

    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>

    <div class="contenido_barra">

        <form action="/enviar/" name="formEnmienda" id="formEnmienda" enctype="multipart/form-data" method="POST">

            <h4><strong><span id="codigo_propuesta"></span></strong></h4>

            <div id="fase1" class="fase fase-1" data-fase="1">

                {include file="$baseAPP/tpl/csrf.tpl"}
                <input type="hidden" value="" id="tipo" name="tipo"/>
                <input type="hidden" value="" id="idPropuesta" name="idPropuesta"/>
                <input type="hidden" value="" id="idCategoria" name="idCategoria"/>
                <input type="hidden" value="{$ip}" id="ip" name="ip"/>

                <div class="mod sup form-group">
                    <label for="texto_original">Texto original</label>
                    <div id="texto_original"></div>                
                </div>

                <div class="add mod form-group">
                    <label for="redaccion" class="mod">Redacción sugerida</label>
                    <label for="redaccion" class="add">Texto a incorporar</label>
                    <textarea id="redaccion" name="redaccion" rows="4"></textarea> 
                </div>

                <div class="sup form-group">
                    <div class="alert alert-danger" role="alert">
                        Va a sugerir eliminar la propuesta o párrafo
                    </div>
                </div>                

            </div>

            <div id="fase2" class="fase fase-2" fase="2">

                <div class="form-group add mod">
                    <label>Si lo desea, puede adjuntar un fichero</label>
                    <label for="adjunto" class="btn btn-info">Pulse para adjuntar fichero</label>
                    <input type="file" id="adjunto" name="adjunto" class="hide">
                </div>         

                <div class="form-group">
                    <label for="motivacion" class="add mod">Motivación de la enmienda</label>
                    <label for="motivacion" class="sup">¿Por qué sugiere eliminarla?</label>
                    <textarea id="motivacion" name="motivacion" rows="4"></textarea> 
                </div>  

            </div>                

            <div id="fase3" class="fase fase-3" fase="3">

                <div class="row">
                    <div class="col">
                        <label for="nombre">Nombre/Entidad/Colectivo/Formación:</label>   
                        <input type="text" class="form-control" maxlength="150" placeholder="Nombre" id="nombre" name="nombre">
                    </div>
                </div>

                <div class="row">                       
                    <div class="col">
                        <label for="apellidos">Apellidos:</label>   
                        <input type="text" class="form-control" maxlength="150" placeholder="Apellidos" id="apellidos" name="apellidos">
                    </div>                    
                </div>                      
                <div class="row">                    
                    <div class="col">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" maxlength="100" placeholder="Email" id="email" name="email">
                    </div>
                </div>
                <div class="row">                     
                    <div class="col">
                        <label for="telefono">Teléfono:</label>
                        <input type="text" class="form-control" maxlength="50" placeholder="Telefono" id="telefono" name="telefono">
                    </div>                
                </div>                
                <div class="row">              
                    <div class="col">
                        <label for="cp">Código postal:</label>
                        <input type="text" name="cp" id="cp" maxlength="50" class="form-control" placeholder="CP">
                    </div>
                </div>                                
                <!--
                <div class="row">              
                    <div class="col">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">Entiendo y acepto los términos</label>
                    </div>
                </div>   
                -->
            </div> 

            <!--<button type="submit" class="btn btn-primary">Enviar</button>-->

    </div>


    <div id="fase4" class="fase fase-4" fase="4">

        <div class="alert alert-danger hide" id="error" name="error" role="alert">
            <h4 class="alert-heading">Errores</h4>
            <p>Se  han detectado los siguientes errores en el formulario. </p>
            <hr>
            <span id="lista_errores" name="lista_errores"></span>
        </div>               

        <div class="container">
            <div class="alert alert-info" id="error" name="error" role="alert">
                <input type="checkbox" name="terminos" id="terminos"><label for="terminos">He leído y acepto la <a href="https://adelanteandalucia.org/legal" class="btn btn-link" target="_blank">Política de Privacidad</a> y las condiciones y tratamientos de los datos personales que en ella se indican. Mediante la marcación de esta casilla doy mi consentimiento expreso al tratamiento de los datos personales que estoy facilitando en este formulario.</label>
            </div>
             
        </div>
    </div> 



    <div id="fase5" class="fase fase-5" fase="5">
        <div class="container">
            <div class="alert alert-success" id="error" name="error" role="alert">
                <h4 class="alert-heading">¡Gracias!</h4>
                <p>Tu enmienda al texto ha sido recibida correctamente que será revisada por el equipo de redacción. </p>
                <hr>
                <p class="mb-0">¡Acude al próximo <strong>patio provincial</strong>!</p>
            </div>
        </div>
    </div>        


    <div id="botones" >
        <div class="form-group">                            
            <div class="col">
                <div class="btn-group" role="group">
                    <button type="button" data-destino="0" id="botonPrev" class="botonEnmienda btn btn-light">Volver</button>
                    <button type="button" data-destino="2" id="botonNext" class="botonEnmienda btn btn-light">Siguiente</button>                    
                </div> 
            </div>
        </div>                
    </div>  





</form>
</div>