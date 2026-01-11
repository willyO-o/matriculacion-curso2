<div class="modal-header">
        <h5 class="modal-title font-weight-normal" id="exampleModalLabel">
            Detalle del Curso
        </h5>
        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<div class="card">
    <div class="card-header mx-4 p-3 text-center">
        <h6 class="text-center mb-0">{{ $curso->estado_curso}} </h6>
        <div class="icon icon-shape icon-lg bg-gradient-dark shadow text-center border-radius-lg">
            <i class="material-symbols-rounded opacity-10">account_balance</i>
        </div>
        <h5 class="text-center mt-3">{{ $curso->codigo }}</h5>
    </div>
    <div class="card-body pt-0 p-3 text-center">
        <h6 class="text-center mb-0">{{ $curso->titulo}} </h6>
        <span class="text-xs">{{ $curso->descripcion }}</span>
        <hr class="horizontal dark my-3">
        <span class="text-xs"> Fecha inicio: {{ $curso->fecha_inicio->format('d/m/Y') }}</span>
        <span class="text-xs"> Fecha fin:  {{ $curso->fecha_fin->format('d/m/Y') }}</span>

        <hr class="horizontal dark my-3">
        <h5 class="mb-0">{{ $curso->costo }} Bs.</h5>
    </div>
</div>
