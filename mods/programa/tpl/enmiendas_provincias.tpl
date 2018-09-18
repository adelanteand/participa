<div class="container">
    
    <h3>Enmiendas recibidas por provincia</h3>

    <table class="table table-striped table-sm">

        {foreach $tabla as $provincia=>$contador}
            <tr class="row">
                <td class="col">{$provincia}</td>
                <td class="col">{$contador}</td>
            </tr>
        {/foreach}
    </table>

</div>