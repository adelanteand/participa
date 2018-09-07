
<h2>Modulos</h2>

<table class="table">
    <thead><tr>
    <th>Módulo</th>
    <th>Aplicación</th>
    </tr>
    </thead>
    <tbody>
        {foreach from=$modulos item= $modulo}
        <tr>
            <td>{$modulo.mod}</td>
            <td>
                {$modulo.app}
            </td>
        </tr>
        {/foreach}
    </tbody>
</table>