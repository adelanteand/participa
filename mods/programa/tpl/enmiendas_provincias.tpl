<div class="container">
    
    <h3>Enmiendas recibidas por provincia</h3>

    <table class="table table-striped table-sm">
        {assign var="totales" value="0"} 
        {foreach $tabla as $provincia=>$contador}
            {$totales = $totales + $contador}
            <tr class="row">
                <td class="col">{$provincia}</td>
                <td class="col">{$contador}</td>
            </tr>
        {/foreach}
            <tr class="row">
                <td class="col"><strong>Totales</strong></td>
                <td class="col">{$totales}</td>
            </tr>        
    </table>

</div>