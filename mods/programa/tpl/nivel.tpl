<h2>Nivel</h2>
{if ($anterior)}
    {if ($anterior=='ROOT')}
        <a href="/patio/">Volver</a>
    {else}
        <a href="/patio/{$anterior}/">Volver</a>
    {/if}
{/if}
<hr>

{if ($cats)}
    <ul>
        {foreach from=$cats item=e}
            <li><a href="/patio/{$e->id}/">{$e->nombre}</a></li>
            {/foreach}
    </ul>
{else}
    {if ($propuestas)}
        <ul>
            {foreach from=$propuestas item=p}
                <li>{$p->texto}</li>    
                {/foreach}
        </ul>
    {else}
        Aquí no hay nada
    {/if}
{/if}

