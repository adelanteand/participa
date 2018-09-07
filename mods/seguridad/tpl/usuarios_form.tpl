
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

<form id="seguridad_usuarios_add" 
      class="needs-validation" 
      novalidate 
      action="/{$mod|lower}/usuarios/{$accion}/" 
      method="POST" 
      enctype="multipart/form-data">

    {include file="$baseAPP/tpl/csrf.tpl"}

    <input type="hidden" name="idusuario" id="idusuario" value="{if isset($val)}{$val->id}{/if}" />
    <input type="hidden" name="tipo" id="tipo" value="{if isset($val)}{$val->tipo}{else}Normal{/if}" />

    
    <div class="row">
        <div class="col-auto mb-3 col-3">
            <label for="user">Usuario</label>
            <input type="text" 
                   class="form-control" 
                   id="user" 
                   name="user" 
                   placeholder="Nombre de usuario" 
                   value="{if isset($val)}{$val->user}{/if}" 
                   required
                   >
        </div>        
    </div>
    
    
    <div class="row formulario">
        <div class="col-auto mb-3 col-3">
            <label for="nombre">Nombre</label>
            <input type="text" 
                   class="form-control" 
                   id="nombre" 
                   name="nombre" 
                   placeholder="Nombre de pila" 
                   value="{if isset($val)}{$val->nombre}{/if}" 
                   required
                   >
        </div>
        <div class="col-auto mb-3 col-3">
            <label for="apellidos">Apellidos</label>
            <input type="text" 
                   class="form-control" 
                   id="apellidos" 
                   name="apellidos" 
                   placeholder="Apellidos" 
                   value="{if isset($val)}{$val->apellidos}{/if}" 
                   required>
        </div>
    </div>
               

    <div class="row">
        <div class="col-auto mb-3 col-6">
            <label for="email">Correo electrónico</label>
            <input type="email" 
                   class="form-control" 
                   id="email" 
                   name="email" 
                   placeholder="Correo electrónico" 
                   value="{if isset($val)}{$val->email}{/if}" 
                   required>

        </div>
    </div>

    <div class="row">
        <div class="col-auto">            
            <label for="newpassword">Contraseña</label>
                <input type="text" 
                       class="form-control" 
                       id="pwd" 
                       name="pwd" 
                       placeholder="Nueva contraseña" 
                       value="{if isset($val)}{$val->pwd}{else}{if ($randomPass)}{$randomPass}{/if}{/if}" 
                       required>
        </div>

    </div>   

</form>