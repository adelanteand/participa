<div class="enmienda">
    <span class="tipo">        

        {if $e->tipo eq 'mod'}
            <span class="badge badge-secondary">
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

    </span>
    <span class="redaccion">{$e->redaccion}
    </span>

</div>
<hr>