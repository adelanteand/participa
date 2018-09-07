{if isset($msg)}
    <div class="alert alert-success">{$msg}</div>
{/if}

{if isset($msg_err)}
    <div class="alert alert-danger">{$msg_err}</div>
{/if}	

<form class="form-signin" action="/usuario/entrar/" method="post" >
    {include file="$baseAPP/tpl/csrf.tpl"}
    <label for="inputEmail" class="sr-only">Correo electrónico</label>
    <input type="text" id="introEmail" name="introEmail" class="form-control" placeholder="Correo electrónico" required autofocus>
    <label for="inputPassword" class="sr-only">Contraseña</label>
    <input type="password" id="introPwd" name="introPwd" class="form-control" placeholder="Contraseña" required>
    <div class="checkbox mb-3">
        <label>
            <input type="checkbox" value="remember-me"> Recordarme en este equipo
        </label>
    </div>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Acceder</button>
    <input type="hidden" name="redirect" id="redirect" class="form-control" value="{$refURL}">
</form>      
