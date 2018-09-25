<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/{if isset($colectivos)}?colectivos=1{/if}"><i class="fas fa-home"></i></a></li>
                {foreach $padres as $categoria}
                    {if isset($categoria->nombre)}
                <li class="breadcrumb-item"><a href="/categoria/{$categoria->id}/{if isset($colectivos)}?colectivos=1{/if}>{if $categoria->icono}<i class="fas {$categoria->icono}"></i> {/if}{$categoria->nombre}</a></li>
                {/if}
            {/foreach}    
            {if !isset($propuesta)}
                {if isset($actual->nombre)}
                <li class="breadcrumb-item">{if $actual->icono}<i class="fas {$actual->icono}"></i> {/if}{$actual->nombre}</li>
                {/if}
            {else}
            <li class="breadcrumb-item">{if $actual->icono}<i class="fas {$actual->icono}"></i> {/if}<a href="/categoria/{$propuesta->cat->id}/{if isset($colectivos)}?colectivos=1{/if}">{$propuesta->cat->nombre}</a></li>
            {/if}
            {if isset($propuesta)}
            <li class="breadcrumb-item active" aria-current="page">{$elementotipo|ucfirst} {$propuesta->id}</li>
            {/if}
    </ol>
</nav>    