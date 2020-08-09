<div class="m-2 p-2">
  <form class="validacion_campos card" id="form-registro" action="#" novalidate>

    <div class="card-header">
      <div class="float-left">
        <a href="#" onclick="history.go(-1)">
          <div class="pr-2">
            <i class="fas fa-sm fa-arrow-left"></i>
          </div>
        </a>
      </div>

      <h5 class="mb-0">
        A continuación debe registrar los Datos Solicitados del Restaurant y del Gerente
      </h5>
    </div>

    <div class="card-body">
      <div class="container">        
        <div class="form-row">
          <div class="form-group col-md-3">
            <label for="DocumentoRest">N° Documento</label>
            <input type="text" name="documento-restaurant" class="form-control" id="DocumentoRest" placeholder="N° de Documento" required>
            <div class="valid-feedback">Campo LLeno</div>
            <div class="invalid-feedback">Ingrese N° de Documento Válido.</div>
          </div>
          <div class="form-group col-md-9">
            <label for="NombreRest">Nombre o Razón Social</label>
            <input type="text" name="nombre-restaurant" class="form-control" id="NombreRest" placeholder="Nombre o Razón Social" required>
            <div class="valid-feedback">Campo LLeno</div>
            <div class="invalid-feedback">Ingrese Nombre Razón Social Válida.</div>
          </div>
          <div class="form-group col-md-12">
            <label for="DireccionRest">Dirección Fiscal</label>
            <textarea class="form-control" name="direccion-restaurant" id="DireccionRest" placeholder="Dirección Fiscal" required cols="30" rows="3"></textarea>
            <div class="valid-feedback">Campo LLeno</div>
            <div class="invalid-feedback">Ingrese Dirección Fiscal Válida.</div>
          </div>
          <div class="form-group col-md-3">
            <label for="TlfRest">N° de Teléfono</label>
            <input type="text" name="telefono-restaurant" class="form-control" id="TlfRest" placeholder="N° de Teléfonos">
            <div class="valid-feedback">Campo LLeno</div>
            <div class="invalid-feedback">Ingrese N° de Teléfono Válido.</div>
          </div>
          <div class="form-group col-md-9">
            <label for="EmaiRest">Correo Electrónico</label>
            <input type="email" name="correo-restaurant" class="form-control" id="EmaiRest" required placeholder="Ejemplo@dominio.com">
            <div class="valid-feedback">Campo LLeno</div>
            <div class="invalid-feedback">Ingrese Correo Electrónico Válido.</div>
          </div>
        </div>
      </div>
    </div>

    <!-- DATOS DEL GERENTE -->
    <div class="card-header border-top">
      <h5 class="mb-0">
        Registro del Gerente
      </h5>
    </div>

    <div class="card-body">
      <div class="container">
        <div class="form-row">
          <div class="form-group col-md-3">
              <label for="DocumentoGerente">N° de Identificación</label>
              <input type="text" name="documento-gerente" class="form-control" id="DocumentoGerente" placeholder="N° de Identificación" required>
              <div class="valid-feedback">Campo LLeno</div>
            <div class="invalid-feedback">Ingrese N° de Ientificación Válido.</div>
            </div>
            <div class="form-group col-md-9">
              <label for="NombreGerente">Nombre Completo</label>
              <input type="text" name="nombre-gerente" class="form-control" id="NombreGerente" placeholder="Nombre Completo" required>
              <div class="valid-feedback">Campo LLeno</div>
            <div class="invalid-feedback">Ingrese Nombre Completo Válido.</div>
            </div>
            <div class="form-group col-md-12">
              <label for="DireccionGerente">Dirección de Domicilio</label>
              <textarea name="direccion-gerente" class="form-control" id="DireccionGerente" placeholder="Dirección de Domicilio" required cols="30" rows="3"></textarea>
              <div class="valid-feedback">Campo LLeno</div>
              <div class="invalid-feedback">Ingrese Dirección de Domicilio Válida.</div>
          </div>
            <div class="form-group col-md-3">
              <label for="TlfGerente">N° de Teléfono</label>
              <input type="text" name="telefono-gerente" class="form-control" id="TlfGerente" placeholder="N° de Teléfonos">
              <div class="valid-feedback">Campo LLeno</div>
              <div class="invalid-feedback">Ingrese N° de Teléfono Válido.</div>
            </div>
            <div class="form-group col-md-9">
              <label for="EmaiGerente">Correo Electrónico</label>
              <input type="email" name="correo-gerente" class="form-control" id="EmaiGerente" placeholder="Ejemplo@dominio.com" required>
              <div class="valid-feedback">Campo LLeno</div>
              <div class="invalid-feedback">Ingrese Correo Electrónico Válido.</div>
            </div>
          <div class="form-group col-md-3">
              <label for="UsuarioGerente">Usuario del Sistema</label>
              <input type="text" name="usuario-gerente" class="form-control" id="UsuarioGerente" placeholder="Nombre de Usuario" required>
              <div class="valid-feedback">Campo LLeno</div>
              <div class="invalid-feedback">Ingrese Usaurio del Sistema Válido.</div>
          </div>
          <div class="form-group col-md-5">
              <label for="ClaveGerente">Clave</label>
              <input type="password" name="clave-gerente" class="form-control" id="ClaveGerente" placeholder="Clave o Password" required>
              <div class="valid-feedback">Campo LLeno</div>
              <div class="invalid-feedback">Ingrese Clave Válida.</div>

          </div>
          <div class="form-group col-md-4">
              <label for="Clave2Gerente">Verifique la Clave</label>
              <input type="password" name="clave2-gerente" class="form-control" id="Clave2Gerente" placeholder="Verificación del Clave o Password" required>
              <div class="valid-feedback">Campo LLeno</div>
              <div class="invalid-feedback">Verifique la Clave.</div>

          </div>
        </div>        
      </div>
    </div>

    <div class="card-footer bg-white">
      <button type="submit" class="btn btn-outline-primary col-sm-6 offset-sm-3" id="boton-registro">Registrar Restaurant</button>
    </div>

  </form>
</div>