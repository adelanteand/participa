<div class="enmienda ml-{$nivel}" >
    <span class="tipo">        
        <a href="/enmienda/{$e->id}/">
            {if $e->tipo eq 'mod'}
                <span class="badge badge-warning">
                    Modificación (ID: {$e->id})
                </span>
            {/if} 
            {if $e->tipo eq 'add'}
                <span class="badge badge-success">
                    Agregar (ID: {$e->id})
                </span>
            {/if}         
            {if $e->tipo eq 'sup'}
                <span class="badge badge-danger">
                    Suprimir (ID: {$e->id})
                </span>
            {/if}  
        </a>
    </span>
    <span class="nombre"><i>{$e->nombre} {$e->apellidos}</i></span>

    <span class="redaccion">{$e->redaccion}</span>
    {if $e->fichero > 0 }
        TIENE DOCUMENTO ANEXO <strong>{$e->fichero}</strong>
    {/if}    

</div>