<div class="container">
    <div class="row">
        <h2>Enviar valoraciones</h2>
        <div class="alert alert-success">
            <ul>
                <li>Se listan en primer lugar las admitidas por la ponencia (en el PDF) y al final las no admitidas por si hubiera que incluir algún comentario</li>
                <li>Aparecen listadas en el mismo orden que el PDF, y entedemos que en el acta de la mesa. Se puede cambiar el orden al que tenían los EXCEL provinciales</li>
                <li>Puedes enviar este formulario todas las veces que necesites</li>
                <li>Solo se guardarán aquellas que en el campo "PATIO - Sentido" <strong>hay alguna opción marcada</strong></li>
                <li>Las observaciones NO son obligatorias. Rellenar solo si aportan contenido relevante</li>
                <li>Si una enmienda es enviada varias veces su sentido, solo contará el último enviado</li>
                <li>Dudas técnicas por Telegram a <a href="https://t.me/acardiel">@acardiel</a></li>
            </ul>
        </div>
    </div>
    
    <div class="row">
        <div class="col col-md-2"><a href="?orden=PDF" class="btn btn-light {if ($orden eq 'PDF')}disabled{/if}">Orden del PDF</a></div>
        <div class="col col-md-2"><a href="?orden=EXCEL" class="btn btn-light {if ($orden neq 'PDF')}disabled{/if}">Orden por EXCEL</a></div>
    </div>
            
    <hr>
    <form action="/valoracion/patio/guardar/" method="POST">

        {include file="$baseAPP/tpl/csrf.tpl"}
        <input type="hidden" value="{$provincia}" name="provincia"/>
        <h4>Previamente aceptadas por la ponencia</h4>
        {foreach $enmiendas as $e}
            {include file="valoraciones_elemento.tpl"}
        {/foreach}
        
        <h4>Denegadas por la ponencia</h4>
        {foreach $enmiendas_denegadas as $e}
            {include file="valoraciones_elemento.tpl"}
        {/foreach}

        <input type="submit" value="Guardar sentido y observaciones de las enmiendas RELLENADAS" class="btn btn-primary" />
    </form>


</div>
