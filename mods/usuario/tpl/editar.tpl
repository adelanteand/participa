
{if isset($msg)}
    <div class="alert alert-danger" role="alert">
        <h4 class="alert-heading">Ops, algo salió mal</h4>
        <p>La operación no pudo ser finalizada. Solucione cada uno de los items detallados a continuación.</p>
        <hr>
        <p class="mb-0">
        <ul>
            {foreach from=$msg item=$m}
                <li>{$m}</li>
                {/foreach}
        </ul> 
    </p>
</div>
{/if}


<form id="usuario_editar" 
      class="needs-validation" 
      novalidate 
      action="/{$mod|lower}/guardar/" 
      method="POST" 
      enctype="multipart/form-data">

    {include file="$baseAPP/tpl/csrf.tpl"}

    <input type="hidden" name="idusuario" id="idusuario" value="{$val->id}" />

    <div class="row formulario">
        <div class="col-auto mb-3">
            <label for="nombre">Nombre</label>
            <input type="text" 
                   class="form-control" 
                   id="nombre" 
                   name="nombre" 
                   placeholder="Nombre de pila" 
                   value="{$val->nombre}" 
                   required
                   >
        </div>
        <div class="col-auto">
            <label for="apellidos">Apellidos</label>
            <input type="text" 
                   class="form-control" 
                   id="apellidos" 
                   name="apellidos" 
                   placeholder="Apellidos" 
                   value="{$val->apellidos}" 
                   required>
        </div>
    </div>

    <div class="row">
        <div class="col-auto">
            <label for="password">Contraseña actual</label>
            <div class="input-group mb-3 showpwd">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                </div>
                <input type="password" 
                       class="form-control" 
                       id="password" 
                       name="password" 
                       placeholder="Contraseña" 
                       value="" 
                       required>
                <div class="input-group-append">
                    <span class="input-group-text"><a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a></span>
                </div>
            </div> 
        </div>
    </div>

    <div class="row">
        <div class="col-auto">            
            <label for="newpassword">Contraseña actual</label>
            <div class="input-group mb-3 showpwd">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                </div>
                <input type="password" 
                       class="form-control" 
                       id="newpassword" 
                       name="newpassword" 
                       placeholder="Nueva contraseña" 
                       value="" 
                       required>
                <div class="input-group-append">
                    <span class="input-group-text"><a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a></span>
                </div>
            </div>   
        </div>

        <div class="col-auto">
            
            
            <label for="newpassword2">Repetir contraseña</label>
            <div class="input-group mb-3 showpwd">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                </div>
                <input type="password" 
                       class="form-control" 
                       id="newpassword2" 
                       name="newpassword2" 
                       placeholder="Repetir" 
                       value="" 
                       required>
                <div class="input-group-append">
                    <span class="input-group-text"><a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a></span>
                </div>
            </div>    

        </div>
    </div>   
    <div class="row">
        <div class="col-md-12">
            <label for="imagen">Imagen / Fotografía</label>            
            {if isset($media)}
                <div id="si-imagen">
                    <img 
                        class="img-thumbnail img-responsive" 
                        src="/media/{$media->modulo}/{$media->modid}/?w=200&{$random}">

                    <input 
                        type="hidden" 
                        name="eliminar_imagen_id" 
                        id="eliminar_imagen_id" 
                        value="{$media->id}"/>

                    <button type="button" 
                            class="btn btn-link" 
                            name="eliminar_imagen" 
                            id="eliminar_imagen">Eliminar imagen</button>
                </div>
            {/if}  
            <div id="no-imagen" style="{if isset($media)}display:none;{/if}" >
                <input type="file" name="fileToUpload" id="fileToUpload">
            </div>

        </div>
    </div>            

</form>