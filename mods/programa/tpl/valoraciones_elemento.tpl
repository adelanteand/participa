<div class="form-row">

    <div class="form-group col-md-1">
        <label for="enmienda{$e->id}">Enmienda</label>
        <a href="/enmienda/{$e->id}/" target="enmienda" ><span class="btn btn-link" >{$e->id}</span></a>
        <input type="hidden" class="form-control" name="enmienda[]" id="enmienda{$e->id}" value="{$e->id}" disabled="disabled">
    </div>
    <div class="form-group col-md-1">
        <label for="publica{$e->id}">Publicada</label>
        <div class="form-control" name="publica{$e->id}">{if ($e->publica eq 1)}Sí{else}No{/if}</div>
    </div>    
    <div class="form-group col-md-2">
        <label for="vponencia{$e->id}">Sentido Ponencia</label>       
        {if ($e->valoraciones|@count > 0)}
            <div name="vponencia{$e->id}">{$e->valoraciones[0]->valoracion}</div>
        {else}
            <div name="vponencia{$e->id}">Sin valoración</div>
        {/if}
    </div>      
    <div class="form-group col-md-3">
        <label for="oponencia{$e->id}">Observaciones Ponencia </label>       
        {if ($e->valoraciones|@count > 0)}
            <textarea name="oponencia[]" id="oponencia{$e->id}" class="form-control" disabled="disabled" >{$e->valoraciones[0]->observaciones}</textarea>
        {else}
            <div name="oponencia{$e->id}">Sin valoración</div>
        {/if}
    </div>
    <div class="form-group col-md-2">
        <label for="sentido{$e->id}">PATIO - Sentido de voto</label>
        <select class="custom-select form-control" name="sentido[]" id="sentido{$e->id}">
            <option selected value="0"></option>
            <option value="Si">Sí</option>
            <option value="No">No</option>
            <option value="Transaccion">Transacción</option>
        </select>        


    </div>    
    <div class="form-group col-md-3">
        <label for="observaciones{$e->id}">PATIO - Observaciones/Transacción</label>
        <textarea name="observaciones[]" id="observaciones{$e->id}" class="form-control" ></textarea>
    </div>        

</div>