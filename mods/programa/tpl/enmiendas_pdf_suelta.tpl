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
            {if $e->tipo eq 'trans'}
                <span class="badge badge-primary">
                    Transacción (ID: {$e->id})
                </span>
            {/if}            
        </a>
    </span>

    <span class="nombre badge badge-light">A propuesta de: {$e->nombre} {$e->apellidos}</span><br>

    <span class="redaccion">{$e->redaccion}</span>


    {if (isset($e->originales))}
        <span>

            <div class="subenmienda ml-10" style="font-size: 0.7em;margin-left:3em">
                <div>Procede de:</div>
                {foreach $e->originales as $enmiendaoriginal}
                    <a href="/enmienda/{$enmiendaoriginal->id}/"><span class="badge badge-info">Enmienda {$enmiendaoriginal->id}</span></a>
                    <span class="nombre badge badge-light">A propuesta de: {$enmiendaoriginal->nombre} {$enmiendaoriginal->apellidos}</span>
                    <span class="redaccion">{$enmiendaoriginal->redaccion}</span>
                {/foreach}            
            </div>
        </span>
    {/if}


    {if $e->fichero > 0 }
        <a href="/fichero/{$e->fichero}/descargar/"><i class="fas fa-paperclip" style="color:red"></i> TIENE DOCUMENTO ANEXO <strong>{$e->fichero}</strong></a>
    {/if}    

</div>