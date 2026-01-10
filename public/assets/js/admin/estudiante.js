$(function () {
    'use strict';


    const modal = new bootstrap.Modal(document.querySelector('#modal-formulario'))


    let table = $('#tabla-estudiante').DataTable({
        serverSide: true,
        ajax: '/estudiantes',
        language:{
            url: '//cdn.datatables.net/plug-ins/2.3.6/i18n/es-ES.json'
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'nombre_completo', name: 'nombre_completo' },
            { data: 'ci', name: 'ci' },
            { data: 'estado', name: 'estado' },
            { data: 'id', name: 'id' ,searchable: false, orderable: false},
            { data: 'nombre', name: 'nombre', visible: false },
            { data: 'paterno', name: 'paterno', visible: false },
            { data: 'materno', name: 'materno', visible: false },
        ]

    }).on('draw.dt', function () {
        $('.btn-editar').off('click').on('click', function () {

            const url = $(this).val();

            $.get(url)
                .done(function (respuesta) {

                    $('#modal-content').html(respuesta)
                    modal.show();

                })

            // modal.show();
        })

        $('.btn-eliminar').off('click').on('click', function () {

            const url = $(this).val();

            //obtener el csrf token de la cabecera meta

            const token = $('meta[name="csrf-token"]').attr('content');



            Swal.fire({
                title: "Esta usted seguro?",
                text: "Desea eliminar el registro?, Esta accion no se puede revertir!",
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
                            text: "El registro ha sido eliminado correctamente.",
                            icon: "success"
                        });


                    })



                }
            });

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




    $(document).on('submit', '#formulario-estudiante', function (evento) {

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

                mensajeError += `<p class="text-danger"> ${errors[clave] } </p>`;

            });



            Swal.fire({
                title: "Error",
                icon: "error",
                html: mensajeError,
            });
        })







    })





})
