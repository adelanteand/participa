<div id="sticky-inicio"></div>
<div id="sticky" class='a1 stick'>Borrador - Programa electoral</div>
<div id="sticky-fin"></div>

<!--<span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; open</span>-->
<div id="container">
    {$programa}
</div>

<div id="barra_enmiendas" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <div class="contenido_barra">
        <form>
            <h4><strong>Propuesta <span id="codigo_propuesta">x.x.x</span></strong></h4>
            <div class="form-group">
                <label for="texto_original">Texto original</label>
                <div id="texto_original"></div>                
            </div>
            <div class="form-group">
                <label for="texto_nuevo">Redacción sugerida</label>
                <textarea id="texto_nuevo" rows="6"></textarea> 
            </div>            
            
            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
            </div>
            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Check me out</label>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
