
<div class=container>
<div class=row>


<h1>{$titulopagina}</h1>

{if $msg}
<div class="alert alert-success">{$msg}</div>
{/if}


<div class="col-md-6" >
<h3>Tus Datos</h3>
<div class="well well-sm">
<span class="glyphicon glyphicon-user"></span> <strong>{$usuario.nick}</strong>

<br>
<span class="glyphicon glyphicon-envelope"></span> {$usuario.email}


</div>

<h3>Iniciativas</h3><a class="btn btn-default btn-lg" href="/iniciativas/"><i class="fa fa-list"></i> Ver iniciativas</a>
<a href="/iniciativas/add/" class="btn btn-primary btn-lg"><i class="fa fa-file-text-o"></i> Presentar una iniciativa</a></label>

{if $comisiones|@count >0}
<h3>Tus comisiones</h3>

  <div class="well well-sm">
  {foreach from=$comisiones item=c}

    <strong>{$c->nombre|escape:"htmlall"}</strong> 
    {*
    {if $c.nivel==100}
       <a href="/adminusuarios/comision/{$c.id}/">Administrador</a>
    {else}  
       <a href="/comisiones/ver/{$c.id}/">ver Miembros</a>
    {/if}
    *}

    <br>

{/foreach}
  </div>



{/if}



</div>




<div class="col-md-6" >    
{if $iniciativas|@count >0}
    <h3>Tus iniciativas</h3>    
      <div class="well well-sm">
      {foreach from=$iniciativas item=i}    
        {$i->tipo}: <a href="/iniciativas/p/{$i->id}/">{$i->autor->nombre} {$i->autor->apellidos}</a> 
        <br>    
      {/foreach}
      </div>    
{/if}    
</div>




</div></div>



