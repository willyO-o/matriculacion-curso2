$(function () {
    'use strict';


    const modal = new bootstrap.Modal(document.querySelector('#modal-formulario'))


    let table = new DataTable('#tabla-estudiante',{
        serverSide: true,
        ajax: '/estudiantes',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'foto', name: 'foto' },
            { data: 'nombre', name: 'nombre' },
            { data: 'ci', name: 'ci' },
            { data: 'fecha_nacimiento', name: 'fecha_nacimiento' },
        ]

    });



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

            Swal.fire({
                title: respuesta.mensaje,
                icon: "success",
                draggable: true
            });

            modal.hide();
        })







    })





})
