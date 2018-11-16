

<div class="container">

    <h1><strong>Apúntate</strong></h1>
    
    <div>
        Tenemos por delante el reto histórico de dar la vuelta a Andalucía. Rellena el siguiente formulario y nos pondremos en contacto contigo lo antes posible. ¡Gracias!
        <hr>
    </div>

    <form action="/apoderados/enviar/" name="formApoderado" id="formApoderado" enctype="multipart/form-data" method="POST">

        {include file="$baseAPP/tpl/csrf.tpl"}

        <div class="alert alert-danger invisible d-print-none" id="error" name="error" role="alert">
            <h4 class="alert-heading">Errores</h4>
            <p>Se  han detectado los siguientes errores en el formulario. </p>
            <hr>
            <span id="lista_errores" name="lista_errores"></span>
        </div>            


        <div class="form-row">
            <div class="form-group col-md-12">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <input id="apoderado" name="apoderado" type="checkbox" aria-label="Apoderado/a 2D">
                        </div>
                    </div>
                    <label class="form-control" for="apoderado"><i class="fas fa-vote-yea"></i> Quiero participar como apoderado/a en la jornada electoral</label>
                    
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <input id="voluntario" name="voluntario" type="checkbox" aria-label="Voluntario/a campaña">
                        </div>
                    </div>
                    <label class="form-control" for="voluntario"><i class="fas fa-users"></i> Quiero participar como voluntario/a en la campaña electoral</label>
                </div>                
            </div>                   
        </div>


        <div class="bloque_elemental">



            <div class="form-row">
                <div class="form-group col-md-6">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="casilla-nombre">Nombre</span>
                        </div>
                        <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Nombre" aria-label="Nombre" aria-describedby="casilla-nombre">
                    </div>

                </div>
                <div class="form-group col-md-6">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="casilla-apellidos">Apellidos</span>
                        </div>
                        <input type="text" id="apellidos" name="apellidos" class="form-control" placeholder="Apellidos" aria-label="Apellidos" aria-describedby="casilla-apellidos">
                    </div>
                </div>            

            </div>          



            <div class="form-row">
                <div class="form-group col-md-3">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="casilla-genero">Género</span>
                        </div>
                        <select class="form-control" id="genero" name="genero" placeholder="Género" aria-label="Género" aria-describedby="casilla-genero">
                            <option value="">--</option>
                            <option value="masculino">Masculino</option>
                            <option value="femenino">Femenino</option>
                            <option value="otros">Otro/s</option>
                            <option value="nc">Prefiero no responder</option>
                        </select>     
                    </div>

                </div>
                <div class="form-group col-md-5">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="casilla-email">Email</span>
                        </div>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Correo electrónico" aria-label="Correo electrónico" aria-describedby="casilla-email">
                    </div>
                </div>   
                <div class="form-group col-md-4">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="casilla-telefono">Teléfono contacto</span>
                        </div>
                        <input type="text" id="telefono" name="telefono" class="form-control" placeholder="Teléfono" aria-label="Teléfono" aria-describedby="casilla-telefono">
                    </div>
                </div>   
            </div>         


            <div class="form-row">
                <div class="form-group col-md-3">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="casilla-dni">DNI</span>
                        </div>
                        <input type="text" id="DNI" name="DNI" class="form-control" maxlength="9" placeholder="DNI" aria-label="DNI" aria-describedby="casilla-dni">
                    </div>

                </div>
                <div class="form-group col-md-5">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="casilla-fechanacimiento">Fecha de nacimiento</span>
                        </div>
                        <input type="text" id="fecha_nacimiento" name="fecha_nacimiento" 
                               data-date-start-view="decade" data-date-start-date="01/11/1868" data-date-end-date="01/11/2000" data-provide="datepicker" data-zIndexOffset="2000" data-date-language="es" data-date-format="dd/mm/yyyy"
                               class="form-control" placeholder="dd/mm/aaaa" aria-label="Fecha de nacimiento" aria-describedby="casilla-fechanacimiento">
                    </div>
                </div>   
                <div class="form-group col-md-4">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="casilla-movilidad">Movilidad reducida</span>
                        </div>
                        <select class="form-control" id="movilidad" name="movilidad" placeholder="Movilidad Reducida" aria-label="Movilidad Reducida" aria-describedby="casilla-movilidad">
                            <option value="">--</option>
                            <option value="no">No</option>
                            <option value="si">Sí</option>
                        </select>                    

                    </div>
                </div>   
            </div> 

            <div class="form-row">

                <div class="form-group col-md-4">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="casilla-provincia">Profesión</span>
                        </div>
                        <input type="text" id="profesion" name="profesion"  class="form-control" placeholder="Profesión" aria-label="Profesión" aria-describedby="casilla-profesion">
                    </div>

                </div>            

                <div class="form-group col-md-4">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="casilla-provincia">Provincia</span>
                        </div>
                        <select class="form-control" id="dirprovincia" name="dirprovincia" placeholder="Provincia" aria-label="Provincia" aria-describedby="casilla-provincia">
                            <option value="">--</option>
                            <option value="AL">Almería</option>
                            <option value="CA">Cádiz</option>
                            <option value="CO">Córdoba</option>
                            <option value="GR">Granada</option>
                            <option value="HU">Huelva</option>
                            <option value="JA">Jaén</option>
                            <option value="MA">Málaga</option>
                            <option value="SE">Sevilla</option>
                            <option value="NO">No andaluza</option>
                        </select>                          

                    </div>

                </div>
                <div class="form-group col-md-4">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="casilla-municipio">Municipio</span>
                        </div>
                        <input type="text" id="dirmunicipio" name="dirmunicipio" class="form-control" placeholder="Municipio" aria-label="Municipio" aria-describedby="casilla-municipio">
                    </div>
                </div>    
            </div>        

            <div class="form-row">
                <div class="form-group col-md-6">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="casilla-direccion">Direccion</span>
                        </div>
                        <input type="text" id="direccion" name="direccion" class="form-control" placeholder="Direccion completa" aria-label="Dirección" aria-describedby="casilla-direccion">
                    </div>

                </div>
                <div class="form-group col-md-2">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="casilla-num">Nº</span>
                        </div>
                        <input type="text" id="num" name="num"  class="form-control" placeholder="Número" aria-label="Número" aria-describedby="casilla-num">
                    </div>
                </div>  
                <div class="form-group col-md-2">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="casilla-piso">Piso</span>
                        </div>
                        <input type="text" id="piso" name="piso" class="form-control" placeholder="Piso" aria-label="Piso" aria-describedby="casilla-piso">
                    </div>
                </div>  
                <div class="form-group col-md-2">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="casilla-cp">CP</span>
                        </div>
                        <input type="text" id="cp" name="cp" class="form-control" placeholder="CP" aria-label="CP" aria-describedby="casilla-cp">
                    </div>
                </div>    
            </div>        



            <div class="form-row">
                <div class="form-group col-md-12">
                    <div class="alert alert-info" id="error" name="error" role="alert">
                        <div class="row">
                            <div class="col-md-1 text-right"><input type="checkbox" name="terminos" id="terminos"></div>
                            <div class="col-md-11"><label for="terminos">He leído y acepto la <a href="https://adelanteandalucia.org/legal" target="_blank">Política de Privacidad</a> y las condiciones y tratamientos de los datos personales que en ella se indican. Mediante la marcación de esta casilla doy mi consentimiento expreso al tratamiento de los datos personales que estoy facilitando en este formulario.</label></div>
                        </div>
                    </div>
                </div>
            </div>      

        </div>

        <div class="bloque_apoderados">



            <h2>Elección de colegio electoral</h2>

            <div class="form-row">
                <div class="form-group col-md-6">
                    Provincia
                    <select class="select2 provincia js-states form-control" name="provincia" id="provincia">
                        <option value=""></option>
                        <option value="04">Almería</option>
                        <option value="11">Cádiz</option>
                        <option value="14">Córdoba</option>
                        <option value="18">Granada</option>
                        <option value="21">Huelva</option>
                        <option value="23">Jaén</option>
                        <option value="29">Málaga</option>
                        <option value="41">Sevilla</option>                  
                    </select>                  
                </div>
                <div class="form-group col-md-6">
                    Municipio
                    <select class="select2 municipio js-states form-control" name="municipio" id="municipio">
                    </select>                  
                </div>          
            </div>  

            <div class="form-row">
                <div class="form-group col-md-12">
                    Colegio Electoral
                    <select class="select2 colegio js-states form-control" name="colegio" id="colegio">
                        <option value=""></option>               
                    </select>
                </div>    
            </div>          

            <div id="mapid" style="height: 350px;"></div>
            <div class="alert alert-warning" role="alert">
                <strong><span class="fas fa-map-marker-alt"></span> Atención: </strong> La ubicación en el mapa
                del marcador puede no coincidir con la localización real de la mesa. Use siempre la dirección
                como referencia real de su localización
            </div>    

            <h2>Otros datos</h2>        

            <div class="form-row">
                <div class="form-group col-md-12">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <input id="disponibilidad" name="disponibilidad" type="checkbox" aria-label="Disponibilidad">
                            </div>
                        </div>
                        <label class="form-control" for="disponibilidad">Tengo disponibilidad para cambiar de colegio en caso de necesidad</label>
                    </div>                

                </div>
            </div> 

        </div>


        <div class="bloque_elemental">
            <div class="form-row">
                <div class="form-group col-md-12">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="casilla-observaciones">Observaciones</span>
                        </div>
                        <input type="text" id="observaciones" name="observaciones" class="form-control" placeholder="Observaciones" maxlength="250" aria-label="Observaciones" aria-describedby="casilla-observaciones">
                    </div>
                </div>            
            </div>         


            <div class="form-row">
                <div class="form-group offset-md-11 col-md-1">
                    <button type="button" id="enviarFormulario"  name="enviarFormulario" class="btn btn-primary" disabled="disabled">Enviar</button>
                </div>
            </div>     

        </div>

    </form>    

</div>


<script>
    $(document).ready(function () {

        var markers = L.markerClusterGroup({
            showCoverageOnHover: false
        });

    {foreach $marcadores as $el}

        /////
        var marker = L.marker(new L.LatLng({$el->latitud}, {$el->longitud}));
        marker.bindPopup("{$el->nombre|escape:'htmlall'}");
        marker.identificador = "{$el->id}";
        marker.provincia = "{$el->id|substr:0:2}";
        marker.municipio = "{$el->municipio}";
        marker.longitud = {$el->longitud};
        marker.latitud = {$el->latitud};
        markers.addLayer(marker);
    {/foreach}

        mymap.addLayer(markers);
        markers.on('click', grupoColegiosClick);
    });
</script>
