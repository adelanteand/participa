{if $msg}

<div style="
border: 1px solid #000;
border-radius: 20px;
padding: 30px;
margin: 30px;
font-size: 12pt;
">
<!--strong style="color: #f00;font-size: 20pt;">Error:</strong-->
{$msg}</div>

{/if}

<div class="container">
    <div class="row">

        <div class="container container-table">
            <div class="row vertical-center-row">

                <div class="text-center col-md-12 " id="loginbox" >
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3>TERMINE DE COMPLETAR EL REGISTRO</h3>
                        </div>
                        <div class="panel-body">
                            <form action="/usuarios/alta3/" class="form-horizontal" method="post">
                                <input type="hidden" name="pwd" value='{$pwd}'>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="email">Email:</label>
                                    <div class="col-sm-4 text-left">
                                        {$email}
                                    </div>
                                </div>
                        
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="pwd">Nombre:</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" value="{$nombre}" name="nombre" placeholder="Inserte su nombre de pila">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="pwd">Apellidos:</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" value="{$apellidos}" name="apellidos" placeholder="Inserte sus apellidos">
                                    </div>
                                </div>        
                        
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="pwd">Contraseña:</label>
                                    <div class="col-sm-4">
                                        <input type="password" name="pa" value="{$pab}" placeholder="Inserte la contraseña" class="form-control" >
                                    </div>
                                </div>
                            
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="pwd">Contraseña: (repetir):</label>
                                    <div class="col-sm-4">
                                        <input type="password" name="pb" value="{$pab}" placeholder="Repita la contraseña" class="form-control" >
                                    </div>
                                </div>    
                                
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-2">
                                        <button type="submit" class="btn btn-default">Enviar</button>
                                    </div>
                                </div>
                            
                            </form>


                        </div>
                    </div>
                </div>
            </div>
        </div>