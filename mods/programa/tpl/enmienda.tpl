<div class="enmienda">
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
    <span class="redaccion">{$e->redaccion}
    </span>

</div>
<hr>