<div id="sticky-inicio"></div>
<div id="sticky" class='a1 stick'>Borrador - Programa electoral</div>
<div id="sticky-fin"></div>


<div id="container">
    {$programa}
</div>

<div id="barra_enmiendas" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <div class="contenido_barra">
        <form action="/enviar/" method="POST">
            
            {include file="$baseAPP/tpl/csrf.tpl"}
            <input type="hidden" value="" id="tipo" name="tipo"/>
            <input type="hidden" value="" id="idPropuesta" name="idPropuesta"/>
            <input type="hidden" value="" id="idCategoria" name="idCategoria"/>
            <input type="hidden" value="{$ip}" id="ip" name="ip"/>
            
            <h4><strong>Propuesta <span id="codigo_propuesta">x.x.x</span></strong></h4>
            
            <div class="form-group">
                <label for="texto_original">Texto original</label>
                <div id="texto_original"></div>                
            </div>
            
            <div class="form-group">
                <label for="texto_nuevo">Redacción sugerida</label>
                <textarea id="texto_nuevo" rows="4"></textarea> 
            </div>            
            
            <div class="form-group">
                <label for="adjunto" class="btn btn-info">Pulse para adjuntar fichero</label>
                <input type="file" id="adjunto" name="adjunto" class="hide">
            </div>             
            
            <div class="form-group">
                <label for="texto_nuevo">Datos personales:</label>
                <div class="row">              
                  <div class="col">
                    <input type="text" class="form-control" placeholder="Nombre" id="nombre" name="nombre">
                  </div>
                  <div class="col">
                    <input type="text" class="form-control" placeholder="Apellidos" id="apellidos" name="apellidos">
                  </div>
                </div>  
                <div class="row">                    
                  <div class="col">
                      <label for="texto_nuevo">Email:</label>
                    <input type="email" class="form-control" placeholder="Email" id="email" name="email">
                  </div>
                  <div class="col">
                      <label for="texto_nuevo">Teléfono:</label>
                    <input type="text" class="form-control" placeholder="Telefono" id="telefono" name="telefono">
                  </div>
                </div>
                <div class="row">              
                  <div class="col">
                      <label for="texto_nuevo">Código postal:</label>
                    <input type="text" class="form-control" placeholder="CP">
                  </div>
                </div>                                
            </div>   
            
            <div class="form-group">
                <label for="texto_nuevo">Motivación de la enmienda</label>
                <textarea id="motivacion" rows="4"></textarea> 
            </div>              
            
            
            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Entiendo y acepto los términos</label>
            </div>
            
            <button type="submit" class="btn btn-primary">Enviar</button>
            
        </form>
    </div>
</div>
