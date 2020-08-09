<div class="p-2">
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text">
                <i class="fas fa-store" style="width: 20px;"></i>
            </span>
        </div>
        <input type="text" class="form-control" placeholder="Código de restaurant..." name="code" id="input-code">
    </div>

    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text">
                <i class="fas fa-user" style="width: 20px;"></i>
            </span>
        </div>
        <input type="text" class="form-control" placeholder="Usuario..." name="usuario" id="input-usuario">
    </div>

    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text">
                <i class="fas fa-key" style="width: 20px;"></i>
            </span>
        </div>
        <input type="password" class="form-control" placeholder="Contraseña..." name="clave" id="input-clave">
    </div>

    <button class="btn btn-primary w-100" id="BotonAcceso">
        Acceder
    </button>

    <br>
    <br>

    <!-- Button trigger modal  Nuevo Plato-->
    <div center>
        <a href="#modal-recuperar-clave" id="recupera" data-toggle="modal">
            Recuperar Datos.
        </a>
    </div>
    <!-- <div class="text-center" id="boton-nuevopla" data-toggle="modal" data-target="#staticBackdropnuevaCat">
        <a> Recuperar los Datos.</a>    
    </div> -->
</div>

<!-- Modal Recuperar los Datos con solo el correo -->
<div class="modal fade" id="modal-recuperar-clave" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">   
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header text-white bg-primary">
                <h5 class="modal-title" id="staticBackdropLabel">Recuperar Datos.</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="container">
                    <form id="form-recupera" onsubmit="event.preventDefault()">
                        <div class="form-row">
                            <label for="Correorecupera">Ingrese su Correo Electrónico</label>
                            <br>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">@</div>
                                </div>
                                <input type="text" class="form-control" required id="Correorecupera" name="correo" placeholder="usuario@servidor.com">
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="EnviarCorreo()">Enviar</button>
            </div>
            
        </div>
    </div>
</div>