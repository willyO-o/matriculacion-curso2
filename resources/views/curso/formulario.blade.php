
@php
    if ($curso->id) {
        $action = route('cursos.update', $curso->id);
    } else {
        $action = route('cursos.store');
    }

@endphp


<form id="formulario-estudiante" method="POST" action="{{ $action }}" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title font-weight-normal" id="exampleModalLabel">
            @if ($curso->id)
                Editar
            @else
                Registrar
            @endif
            Curso
        </h5>
        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">

        @csrf
        @if ($curso->id)
            @method('PUT')
        @endif
        <div class="row">
            <div class="col-md-12">
                <label class="form-label">Titulo</label>

                <div class="input-group input-group-outline mb-3">
                    <input type="text" class="form-control" name="titulo" value="{{ $curso?->titulo }}">
                </div>
            </div>
            <div class="col-md-12">
                <label class="form-label">Descripcion</label>

                <div class="input-group input-group-outline mb-3">
                    <textarea name="descripcion" id="descripcion"  rows="8" class="form-control">{{ $curso?->descripcion }}</textarea>
                </div>
            </div>
            <div class="col-md-6">
                <label class="form-label">Costo</label>

                <div class="input-group input-group-outline mb-3">
                    <input type="number" class="form-control" name="costo" value="{{ $curso?->costo }}">
                </div>
            </div>
             <div class="col-md-6">
                <label class="form-label">Estado</label>

                <div class="input-groupis-invalid ">
                    <select name="estado_curso" id="estado_curso" class="form-select">
                        <option value="PENDIENTE" {{ $curso?->estado_curso == 'PENDIENTE' ? 'selected' : '' }}>PENDIENTE</option>
                        <option value="EN CURSO" {{ $curso?->estado_curso == 'EN CURSO' ? 'selected' : '' }}>EN CURSO </option>
                        <option value="FINALIZADO" {{ $curso?->estado_curso == 'FINALIZADO' ? 'selected' : '' }}>FINALIZADO </option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <label class="form-label">Fecha de Inicio</label>

                <div class="input-group  is-valid ">
                    <input type="date" class="form-control" name="fecha_inicio"
                        value="{{ $curso->fecha_inicio?->format('Y-m-d') }}">
                </div>
            </div>
            <div class="col-md-6">
                <label class="form-label">Fecha de Finalización</label>

                <div class="input-group  is-valid ">
                    <input type="date" class="form-control" name="fecha_fin"
                        value="{{ $curso->fecha_fin?->format('Y-m-d') }}">
                </div>
            </div>

        </div>


    </div>

    <div class="modal-footer">
        <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn bg-gradient-primary">Guardar cambios</button>
    </div>
</form>
