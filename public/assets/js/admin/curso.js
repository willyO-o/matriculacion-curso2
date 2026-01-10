$(function () {

    'use strict';

    const modal = new bootstrap.Modal(document.querySelector('#modal-formulario'))

    $('#boton-agregar').on('click', function () {





        modal.show();

        const url = $(this).val();


        $.get(url)
            .done(function (respuesta) {

                $('#modal-content').html(respuesta)

            })


    })



})
