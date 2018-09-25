<div class="container">
    <div class="row">
        <h2>Enviar valoraciones</h2>
    </div>
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

        <input type="submit" value="Guardar" class="btn btn-primary" />
    </form>


</div>
