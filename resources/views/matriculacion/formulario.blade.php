<form id="formulario-curso" method="POST" action="{{ route('matriculaciones.store') }}">
    <div class="modal-header">
        <h5 class="modal-title font-weight-normal" id="exampleModalLabel">
            Agregar Estudiante al Curso
        </h5>
        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">

        @csrf

        <input type="hidden" name="id_curso" value="{{ $curso->id }}">

        <div class="row">
            <div class="col-md-12">
                <label class="form-label">Titulo</label>

                <div class="input-group input-group-outline mb-3">
                    <input type="text" class="form-control" disabled value="{{ $curso?->titulo }}">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <label class="form-label">Seleccionar Estudiantes</label>

                <div class="input-group input-group-outline mb-3">
                    <select name="estudiantes[]" id="select-estudiantes" class="form-control" multiple="multiple"></select>
                </div>
            </div>
        </div>


    </div>

    <div class="modal-footer">
        <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn bg-gradient-primary">Guardar cambios</button>
    </div>
</form>
