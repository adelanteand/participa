
<h2>Add grupo de seguridad</h2>

<div class="row">        
    <form role="form" action="/seguridad/grupos/add/go/" method="post" enctype="multipart/form-data">

        <div class="form-group">
            <label for="nombre">Nombre del grupo:</label>
            <input type="text" class="form-control" id="nombre" name="nombre">
        </div>

        <div class="form-group">
            <label for="padre">Padre:</label>
            <input type="text" class="form-control" id="padre" name="padre">
        </div>        

        <button type="submit" class="btn btn-info boton_envio">
            Enviar
        </button>
    </form>
</div>