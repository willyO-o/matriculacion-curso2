@php
    if ($estudiante->id) {
        $action = route('estudiantes.update', $estudiante->id);
    } else {
        $action = route('estudiantes.store');
    }

@endphp


<form id="formulario-estudiante" method="POST" action="{{ $action }}" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title font-weight-normal" id="exampleModalLabel">
            @if ($estudiante->id)
                Editar
            @else
                Registrar
            @endif
            Estudiante
        </h5>
        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">

        @csrf
        @if ($estudiante->id)
            @method('PUT')
        @endif
        <div class="row">
            <div class="col-md-6">
                <label class="form-label">Nro de C.I.</label>

                <div class="input-group input-group-outline mb-3">
                    <input type="text" class="form-control" name="ci" value="{{ $estudiante?->ci }}">
                </div>
            </div>
            <div class="col-md-6">
                <label class="form-label">Nombre</label>

                <div class="input-group input-group-outline mb-3">
                    <input type="text" class="form-control" name="nombre" value="{{ $estudiante?->nombre }}">
                </div>
            </div>
            <div class="col-md-6">
                <label class="form-label">Paterno</label>

                <div class="input-group input-group-outline mb-3">
                    <input type="text" class="form-control" name="paterno" value="{{ $estudiante?->paterno }}">
                </div>
            </div>
            <div class="col-md-6">
                <label class="form-label">Materno</label>

                <div class="input-group input-group-outline mb-3">
                    <input type="text" class="form-control" name="materno" value="{{ $estudiante?->materno }}">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <label class="form-label">Fecha de Nacimiento</label>

                <div class="input-group  is-valid ">
                    <input type="date" class="form-control" name="fecha_nacimiento"
                        value="{{ $estudiante->fecha_nacimiento?->format('Y-m-d') }}">
                </div>
            </div>
            <div class="col-md-6">
                <label class="form-label">Estado</label>

                <div class="input-groupis-invalid ">
                    <select name="estado" id="estado" class="form-select">
                        <option value="ACTIVO" {{ $estudiante?->estado == 'ACTIVO' ? 'selected' : '' }}>ACTIVO</option>
                        <option value="INACTIVO" {{ $estudiante?->estado == 'INACTIVO' ? 'selected' : '' }}>INACTIVO
                        </option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            @if ($estudiante->foto)
                <div class="col-md-4">
                    <p>Fotografia Actual:</p>
                    <div>
                        <img src="{{ asset('storage/' . $estudiante->foto) }}" alt="Foto perfil" class="img-fluid">
                    </div>
                </div>
            @endif
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
