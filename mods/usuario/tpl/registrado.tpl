<div class="container">
    <div class="row">

        <h1>{$u->fullName}</h1>

        {if $msg}
            <div class="alert alert-success">
                {$msg}
            </div>
        {/if}

        ID Sistema: <strong>{$u->id}</strong> | <span class="glyphicon glyphicon-user"></span> Usuario: <strong>{$u->nick}</strong>

        <br>

        <span class="glyphicon glyphicon-envelope"></span> {$u->email}

        <br>

        <span class="glyphicon glyphicon-certificate"></span> {$u->karma}




        <form action="/usuarios/modificar/" method="post" role="form">

            <h2>Datos opcionales</h2>
            <input type="hidden" name="refURL" value="{$refURL}" id="refURL">

            {if $msg2}
                <div class="alert alert-success">
                    {$msg2}
                </div>
            {/if}

            <div class="form-group">
                <div class="row">
                    <div class="col-md-4">
                        <label for="tlf1">Teléfono</label>                            
                        <input type="text" class="form-control" id="tlf1" name="tlf1"
                               value="{$u->tlf1}" placeholder="Teléfono 1">
                    </div>
                    <div class="col-md-4">
                        <label for="tlf2">Teléfono 2</label>
                        <input type="text" class="form-control" id="tlf2" name="tlf2"
                               value="{$u->tlf2}" placeholder="Teléfono 2">
                    </div>       
                    <div class="col-md-4">
                        <label for="cp">Código postal</label>
                        <input type="text" class="form-control" id="cp" name="cp"
                               value="{$u->cp}" placeholder="Código postal">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-md-3">
                        <label for="localidad">Localidad</label>
                        <input type="text" class="form-control" id="localidad" name="localidad"
                               value="{$u->localidad}" placeholder="Localidad">
                    </div>
                    <div class="col-md-9">
                        <label for="circulo">Si pertenece a algún Círculo de Podemos indíquelo aquí</label>
                        <input type="text" class="form-control" id="circulo" name="circulo"
                               value="{$u->circulo}" placeholder="Circulo">
                    </div>
                </div>
            </div>            


            <input type="submit" class="btn btn-primary btn-lg btn-block" value="{if $msgboton}{$msgboton}{else}Guardar datos{/if}">


        </form>








        {*
        <br>
        {if $verificado}
        <span class="glyphicon glyphicon-ok"> Identidad Verficada </span>
        {else}
        <span class="glyphicon glyphicon-exclamation-sign"></span> Identidad Sin Verficar:
        <br>
        En breve se habilitará el mecanismo para la verificación.
        {/if}
        *}

        {*

        <hr>

        {if $colaborador}
        <form action="/usuarios/?go=colaborador" method=post>
        <h2>Ficha de colaborador</h2>

        Nombre: {$colaborador.nombre}
        <br>
        Apellidos: {$colaborador.apellidos}
        <br>
        Ocupación: {$colaborador.ocupacion}
        <br>
        Móvil: {$colaborador.movil}
        {if $colaborador.ciudad}
        <br>
        Ciudad: Jerez{/if}
        <br>
        {$colaborador.territoriotxt}
        <br>
        Envío de correos:
        <input value=1 type=checkbox name=mailing {if $colaborador.mailing}checked{/if}>

        <br>
        Envío de mensajes sms:
        <input value=1 type=checkbox name=moviling {if $colaborador.moviling}checked{/if}>

        <hr>

        <h3>Colaboraciones</h3>

        <div class=row>
        {foreach from=$intereses key=k item=i name=n}
        <div class="col-md-4" >
        <h4>{$k}</h4>
        {foreach from=$i key=kk item=ii}
        <input {if in_array($kk, $interesesusuario)}checked{/if} type=checkbox name="{$kk}">
        {$ii}
        <br>
        {/foreach}
        </div>
        {/foreach}
        </div>
        <input type=submit class="btn btn-primary btn-lg btn-block" value="Modificar">

        </form>
        {else}
        <form action="/usuarios/?go=colaborador" method=post role=form>

        <h2>Date de alta como Colaborador/a</h2>
        <div class="form-group">
        <label >Nombre</label>
        <input type="text" class="form-control" name=nombre
        placeholder="Introduce tu nombre">
        </div>
        <div class="form-group">
        <label >Apellidos</label>
        <input type="text" class="form-control" name=apellidos
        placeholder="Introduce tus apellidos">
        </div>
        <div class="form-group">
        <label >Ocupación</label>
        <input type="text" class="form-control" name=ocupacion
        placeholder="Introduce tu ocupación">
        </div>
        <div class="form-group">
        <label >Nº Móvil</label>
        <input type="text" class="form-control" name=movil
        placeholder="solo para envíos de mensajes (sms, whatapp, telegram...)">
        </div>
        <div class="form-group">
        <label >Lugar de Residencia</label>
        <br>
        <input checked type=radio name=lugarresidencia id=lugarresidenciaa value=1 onclick="$('#distritodiv').show();$('#residenciadiv').hide();">
        {$ciudad}
        <br>
        <input type=radio name=lugarresidencia id=lugarresidenciab value=2 onclick="$('#distritodiv').hide();$('#residenciadiv').show();">
        Fuera de {$ciudad}
        </div>

        {literal}
        <script>
        function cambiodistrito() {

        $("#distritotxt").hide();
        $("#distritotxt").html(""); {/literal
        } { foreach
        from = $txtdistritos
        item = i
        key = k
        }
        if ($("#distrito").val() == "{$k}")
        $("#distritotxt ").html("{$i}");
        {/foreach
        } { literal
        }

        if ($("#distritotxt ").html() != "")
        $("#distritotxt").show();

        }
        </script>
        {/literal}

        <div class="form-group">
        <label >Territorio</label>
        <div id=distritodiv>

        <select name=distrito id=distrito onchange="cambiodistrito();" class="form-control">
        <option value="0">Seleccione distrito</option>
        {foreach from=$distritos key=k item=i}
        <option value="{$k}">{$i}</option>
        {/foreach}
        </select>
        <div id=distritotxt style="border: 1px solid #888; display: none; padding 5px;">
        sdkljfsd
        </div>

        </div>
        <div id=residenciadiv  style="display:none;">

        <select name=residencia id=residencia class="form-control">
        <option value="0">Seleccione lugar de residencia</option>
        {foreach from=$externos key=k item=i}
        <option value="{$k}">{$i}</option>
        {/foreach}
        </select>

        </div>
        </div>

        <div class="form-group">
        <label > Acepto recibir mensajes de correo electrónico
        <input type=checkbox class="form-control" name=okmail checked value=1>
        </label>
        </div>
        <div class="form-group">
        <label > Acepto recibir mensajes a mi número de móvil
        <input type=checkbox class="form-control" name=okmovil checked value=1>
        </label>
        </div>

        <div class=row>
        {foreach from=$intereses key=k item=i name=n}
        <div class="col-md-4" >
        <h4>{$k}</h4>
        {foreach from=$i key=kk item=ii}
        <input {if in_array($kk, $interesesusuario)}checked{/if} type=checkbox name="{$kk}">
        {$ii}
        <br>
        {/foreach}
        </div>
        {/foreach}

        <input type=submit class="btn btn-primary btn-lg btn-block" value="Date de Alta como Colaborador/a">

        </div>

        </form>
        {/if}

        *}

    </div>
</div>

