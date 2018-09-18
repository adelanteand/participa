<div class="container patio">

    {if isset($categoria->nombre)}
        <h2>{$categoria->nombre}</h2>
        {include file="breadcrumbs.tpl"}
        {if ($anterior)}
            {if ($anterior=='ROOT')}
                <a href="/categoria/" class="btn btn-light">Subir <i class="fas fa-level-up-alt"></i></a>
                {else}
                <a href="/categoria/{$anterior}/" class="btn btn-light">Subir <i class="fas fa-level-up-alt"></i></a>
                {/if}
            {/if}
        <hr>
    {else}
        <h2><strong>¡Cómo está el patio!</strong></h2>
        <p>Os  presentamos  las  principales  líneas  del  
            programa  a  través  de  10  patios  que  simbolizan  los  principales  
            ejes  políticos.  En  Andalucía  han  sido  los  patios  una  de  
            las expresiones de la vida de la gente en los pueblos y ciudades, entendidos 
            como núcleos fundamentales para la socialización, el apoyo mutuo y el bien común.
            Por esta razón, la participación ciudadana es indispensable para marcar la hoja 
            de ruta de este proyecto político. Abrimos un proceso participativo en el que 
            cualquier persona podrá presentar enmiendas en estos patios para convertir el
            programa de Adelante Andalucía en su programa, el que responde a sus necesidades</p>
        <div class="alert alert-info">
            <strong>¡Patios provinciales!</strong> <a href="/patios/listado/" class="alert-link">Acude a tu patio más cercano</a>.
        </div>        
    {/if}


    {if (isset($categoria->intro))}
        {foreach from=$categoria->intro item=e}
            <p class="parrafo" data-idPropuesta="{$e->id}" data-idCategoria="{$categoria->id}">
                <a href="/parrafo/{$e->id}/" data-propuesta="{$e->id}" class="badge badge-secondary codigo_parrafo">{$e->id}</a>
                {if isset($e->enmiendas) AND $e->enmiendas|@count > 0}
                    <span class="badge badge-warning">{$e->enmiendas|@count} enmienda/s</span> 
                {/if}                
                <span class='textprop'>{$e->texto}</span><a href="/parrafo/{$e->id}/" class="btn btn-default btn-sm"><i class='fas fa-plus'></i> Opciones</a>               
            </p>
        {/foreach}
    {/if}

    {if ($hijos)}
        <h3>Categorías</h3>
        <ul>
            {foreach from=$hijos item=e}
                <li class="patios nivel">
                    <a href="/categoria/{$e->id}/">
                        {if isset($e->enmiendas) AND $e->enmiendas|@count > 0}
                            <span class="badge badge-warning">{$e->enmiendas|@count} propuesta/s</span> 
                        {/if}                        

                        {if $e->icono}
                            <i class="fas {$e->icono}"></i>
                        {/if}
                        {$e->nombre}
                    </a>
                </li>
            {/foreach}
        </ul>
    {/if}

    {if ($propuestas)}
        <hr>
        <h3>Propuestas</h3>
        <p><i>Pulsa en el número de propuesta para ver más detalles</i></p>

        <div><a href="/formulario/add/{$categoria->id}/" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i> Enviar propuesta</a></div>
        <hr>
        {foreach from=$propuestas item=p}           
            <span data-propuesta="{$p->id}" class='badge badge-secondary codigo_propuesta' ><a href="/propuesta/{$p->id}/">Propuesta {$p->id}</a></span> 
            {if isset($p->enmiendas) AND $p->enmiendas|@count > 0}
                <span class="badge badge-warning">{$p->enmiendas|@count} enmienda/s</span> 
            {/if}             
            <p>{$p->texto}</p>    
        {/foreach}
        <hr>
        <div><a href="/formulario/add/{$categoria->id}/" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i> Enviar propuesta</a></div>
    {/if}


    {if $categoria->enmiendas}
        <h4><strong>Enmiendas al texto</strong></h4>
        {foreach from=$categoria->enmiendas item=e}
            {include file="enmienda.tpl"}
        {/foreach}
    {/if}    

</div>