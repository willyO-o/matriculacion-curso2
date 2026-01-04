<form id="formulario-estudiante" method="POST" action="{{ route('estudiantes.store') }}" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title font-weight-normal" id="exampleModalLabel">Registrar Estudiante</h5>
        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">

        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="input-group input-group-outline my-3">
                    <label class="form-label">Nro de C.I.</label>
                    <input type="text" class="form-control" name="ci">
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group input-group-outline my-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" class="form-control" name="nombre">
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group input-group-outline my-3">
                    <label class="form-label">Paterno</label>
                    <input type="text" class="form-control" name="paterno">
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group input-group-outline my-3">
                    <label class="form-label">Materno</label>
                    <input type="text" class="form-control" name="materno">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <label class="form-label">Fecha de Nacimiento</label>

                <div class="input-group  is-valid ">
                    <input type="date" class="form-control" name="fecha_nacimiento">
                </div>
            </div>
            <div class="col-md-6">
                <label class="form-label">Estado</label>

                <div class="input-groupis-invalid ">
                    <select name="estado" id="estado" class="form-select">
                        <option value="ACTIVO" selected>ACTIVO</option>
                        <option value="INACTIVO">INACTIVO</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <label for="foto"> Fotografia</label>
                <input type="file" class="form-control" name="foto" id="foto"
                    accept=".jpg, .png, .webp, .jpeg">

            </div>
        </div>

    </div>

    <div class="modal-footer">
        <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn bg-gradient-primary">Guardar cambios</button>
    </div>
</form>
