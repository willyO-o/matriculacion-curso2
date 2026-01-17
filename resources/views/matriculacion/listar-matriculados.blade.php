 <div class="modal-header">
     <h5 class="modal-title font-weight-normal" id="exampleModalLabel">
         Listado de Estudiantes Matriculados
     </h5>
     <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
         <span aria-hidden="true">&times;</span>
     </button>
 </div>
 <div class="modal-body">
     <div class="card">
         <div class="table-responsive">
             <table class="table align-items-center mb-0">
                 <thead>
                     <tr>
                         <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Author</th>
                         <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Function
                         </th>
                         <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                             Technology</th>
                         <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                             Employed
                         </th>
                         <th class="text-secondary opacity-7"></th>
                     </tr>
                 </thead>

                 <tbody>

                     @forelse ($estudiantes as $estudiante)
                         <tr>
                             <td>
                                 <div class="d-flex px-2 py-1">
                                     <div>
                                         <img src="{{ asset('storage/' . $estudiante->foto) }}"
                                             class="avatar avatar-sm me-3">
                                     </div>
                                     <div class="d-flex flex-column justify-content-center">
                                         <h6 class="mb-0 text-xs">{{ $estudiante->nombre }}</h6>
                                         <p class="text-xs text-secondary mb-0">{{ $estudiante->fecha_nacimiento->age }}
                                             años</p>
                                     </div>
                                 </div>
                             </td>
                             <td>
                                 <p class="text-xs font-weight-bold mb-0">{{ $estudiante->pivot->nro_matricula }}</p>
                             </td>
                             <td class="align-middle text-center text-sm">
                                 <span class="">{{ $estudiante->pivot->estado_matriculacion }}</span>
                             </td>
                             <td class="align-middle text-center">
                                 <span
                                     class="text-secondary text-xs font-weight-normal">{{ $estudiante->pivot->fecha_matriculacion }}</span>
                             </td>
                             <td class="align-middle">
                                 <button value="{{ route('matriculaciones.destroy', $estudiante->pivot->id) }}"
                                     class="btn btn-sm btn-danger  btn-desmatricular" data-toggle="tooltip"
                                     data-original-title="Edit user">
                                     Desmatricular
                                 </button>

                                 <button value="{{ route('matriculaciones.matricula-pdf', $estudiante->pivot->id) }}"
                                     class="btn btn-sm btn-primary  btn-imprimir-matricula" data-toggle="tooltip"
                                     data-original-title="Edit user">
                                     <i class="fa fa-print"></i> Imprimir Matricula
                                 </button>

                             </td>
                         </tr>

                     @empty

                         <tr>
                             <td colspan="100%">
                                 <h6 class="text-center p-5">No se encontraron estudiantes matriculados</h6>
                             </td>
                         </tr>
                     @endforelse

                 </tbody>
             </table>
         </div>
     </div>
 </div>

 <div class="modal-footer">
     <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Cerrar</button>
 </div>
