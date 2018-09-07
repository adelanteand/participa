

<h2>Listado de usuarios</h2>


<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Usuario</th>
            <th scope="col">Email</th>
            <th scope="col">Nombre</th>
            <th scope="col">Apellidos</th>
            <th scope="col">Editar</th>
            <th scope="col">Eliminar</th>            
        </tr>
    </thead>
    <tbody>
        {foreach from=$ListadoUsuarios item=$i}
            <tr>

                <th scope="row">{$i->id}</th>
                <td>{$i->user}</td>
                <td>{$i->email}</td>  
                <td>{$i->nombre}</td>
                <td>{$i->apellidos}</td>                      
                <td><a href="/seguridad/usuarios/editar/{$i->id}/">Editar</a></td>
                <td><a href="/seguridad/usuarios/eliminar/{$i->id}/">Eliminar</a></td>

            </tr>
        {/foreach}                
    </tbody>
</table>
