$(function () {

    'use strict';

    const modal = new bootstrap.Modal(document.querySelector('#modal-formulario'))




    let table = $('#tabla-curso').DataTable({
        serverSide: true,
        ajax: '/cursos',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'codigo', name: 'codigo' },
            { data: 'titulo', name: 'titulo' },
            { data: 'costo', name: 'costo' },
            { data: 'fecha_inicio', name: 'fecha_inicio' },
            { data: 'fecha_fin', name: 'fecha_fin' },
            { data: 'estado_curso', name: 'estado_curso' },
            { data: 'id', name: 'id' },
        ]

    })
        .on('draw.dt', function () {

            $('.btn-accion').off('click').on('click', function () {

                const url = $(this).val();


                $.get(url)
                    .done(function (respuesta) {

                        $('#modal-content').html(respuesta)
                        modal.show();
                    })


            })

            $('.btn-eliminar').off('click').on('click', function () {
                const url = $(this).val();

                const token = $('meta[name="csrf-token"]').attr('content');


                Swal.fire({
                    title: "Esta usted seguro?",
                    text: "Desea eliminar el curso?, Esta accion no se puede revertir!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Si, eliminar!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        //se ejecuta cuano se confirmo el mensaje

                        $.ajax({
                            url: url,
                            type: 'DELETE',
                            data: {
                                _token: token
                            }

                        }).done(function (respuesta) {

                            table.ajax.reload(null, false);
                            Swal.fire({
                                title: respuesta.mensaje,
                                text: "El curso ha sido eliminado correctamente.",
                                icon: "success"
                            });


                        })



                    }
                });


            })


            $('.btn-matricular').off('click').on('click', function () {


                const url = $(this).val();

                modal.show();

                $.get(url)
                    .done(function (respuesta) {

                        $('#modal-content').html(respuesta)




                            $('#select-estudiantes').select2({
                                dropdownParent: $('#modal-content'),
                                minimumInputLength: 3,
                                ajax: {
                                    url: '/buscar-estudiantes',
                                    dataType: 'json'
                                    // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                                }
                            })
                    })
            })

        })



    $('#boton-agregar').on('click', function () {





        modal.show();

        const url = $(this).val();


        $.get(url)
            .done(function (respuesta) {

                $('#modal-content').html(respuesta)

            })


    })



    $(document).on('submit', '#formulario-curso', function (evento) {

        evento.preventDefault();


        const datos = new FormData(this);

        const formulario = $(this);


        $.ajax({
            type: formulario.attr('method'),
            url: formulario.attr('action'),
            data: datos,
            processData: false,
            contentType: false,
        }).done(function (respuesta) {

            // console.log(respuesta);
            Swal.fire({
                title: respuesta.mensaje,
                icon: "success",
                draggable: true
            });

            table.ajax.reload(null, false);


            modal.hide();
        }).fail(function (repuesta) {

            const errors = repuesta.responseJSON.errors
            console.warn(errors);

            let mensajeError = "";

            Object.keys(errors).forEach(clave => {

                mensajeError += `<p class="text-danger"> ${errors[clave]} </p>`;

            });



            Swal.fire({
                title: "Error",
                icon: "error",
                html: mensajeError,
            });
        })







    })



})
