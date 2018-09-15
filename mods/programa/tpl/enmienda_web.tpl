<div class="enmienda">

    <div class="row">

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Columna</th>
                        <th scope="col">Valor</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">ID</th>
                        <td>{$e->id}</td>
                    </tr>  
                    {if (isset($e->idPropuesta))}
                    <tr>
                        <th scope="row">Propuesta</th>
                        <td><a href="{$url}propuesta/{$e->idPropuesta->id}/" target="_blank">Ver</a> - {$e->idPropuesta->texto}</td>
                    </tr>
                    {/if}
                    {if (isset($e->idCategoria))}
                    <tr>
                        <th scope="row">Categoría</th>
                        <td><a href="{$url}categoria/{$e->idCategoria->id}/" target="_blank">Ver</a> - {$e->idCategoria->nombre}</td>
                    </tr>                    
                    {/if}
                </tbody>
            </table>

            <hr>
            <h3>Motivación</h3>
            {$e->motivacion}

            <hr>
            <h3>Texto</h3>
            {$e->redaccion}            

        </div>        




    </div>


</div>
<hr>