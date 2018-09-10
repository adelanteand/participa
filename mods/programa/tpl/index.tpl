<div id="sticky-inicio"></div>
<div id="sticky" class='a1 stick'>Borrador - Programa electoral</div>
<div id="sticky-fin"></div>


<a id="volverArriba"><i class="fas fa-chevron-up fa-2x"></i></a>

<div id="container">
    <strong>¡CÓMO ESTÁ EL PATIO!</strong> Os  presentamos  las  principales  líneas  del  
        programa  a  través  de  10  patios  que  simbolizan  los  principales  
        ejes  políticos.  En  Andalucía  han  sido  los  patios  una  de  
las expresiones de la vida de la gente en los pueblos y ciudades, entendidos 
como núcleos fundamentales para la socialización, el apoyo mutuo y el bien común.
Por esta razón, la participación ciudadana es indispensable para marcar la hoja 
de ruta de este proyecto político. Abrimos un proceso participativo en el que 
cualquier persona podrá presentar enmiendas en estos patios para convertir el
programa de Adelante Andalucía en su programa, el que responde a sus necesidades
    {$programa}
</div>

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
                    <label for="redaccion" class="add">Texto de la nueva propuesta</label>
                    <textarea id="redaccion" name="redaccion" rows="4"></textarea> 
                </div>

                <div class="sup form-group">
                    <div class="alert alert-danger" role="alert">
                        Va a sugerir eliminar la propuesta
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
                
                <div class="alert alert-danger hide" id="error" name="error" role="alert">
                    <h4 class="alert-heading">Errores</h4>
                    <p>Se  han detectado los siguientes errores en el formulario. </p>
                    <hr>
                    <span id="lista_errores" name="lista_errores"></span>
                    
                </div>               

                <div class="row">
                    <div class="col">
                        <label for="nombre">Nombre:</label>   
                        <input type="text" class="form-control" placeholder="Nombre" id="nombre" name="nombre">
                    </div>
                </div>
                
                <div class="row">                       
                    <div class="col">
                        <label for="apellidos">Apellidos:</label>   
                        <input type="text" class="form-control" placeholder="Apellidos" id="apellidos" name="apellidos">
                    </div>                    
                </div>                      
                <div class="row">                    
                    <div class="col">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" placeholder="Email" id="email" name="email">
                    </div>
                </div>
                <div class="row">                     
                    <div class="col">
                        <label for="telefono">Teléfono:</label>
                        <input type="text" class="form-control" placeholder="Telefono" id="telefono" name="telefono">
                    </div>                
                </div>                
                <div class="row">              
                    <div class="col">
                        <label for="cp">Código postal:</label>
                        <input type="text" name="cp" id="cp" class="form-control" placeholder="CP">
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
</div>
