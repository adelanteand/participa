{if isset($msg)}
    <div class="alert alert-success" role="alert">
        <p class="mb-0">
        <ul>
            {foreach from=$msg item=$m}
                <li>{$m}</li>
                {/foreach}
        </ul> 
    </p>
</div>
{/if}
<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">First</th>
        </tr>        
    </thead>
    <tr>
        <th scope="row">Nombre:</th>
        <td>{$usuario.nombre}</td>
    </tr>
    <tr>
        <th scope="row">Apellidos:</th>
        <td>{$usuario.apellidos}</td>
    </tr>
    <tr>
        <th scope="row">Email:</th>
        <td>{$usuario.email}</td>
    </tr>  
    <tr>
        <th scope="row">Imagen:</th>
        <td>
            {if isset($media)}
                <img class="img-fluid" src="/media/{$mod|lower}/{$usuario.id}/?w=500&{$random}">
            {else}
                <img src="/media/{$mod|lower}/{$usuario.id}/?w=500&{$random}">
            {/if}
        </td>
    </tr>      
</table>

