$(document).ready(function() {

    // Files deletion
    $('.deleteFile').on('click', function (e) {
        e.preventDefault();
        var url = $(this).attr('href');
        var elt = $(this);
        swal({
                title: "Warning",
                text: "Êtes vous sûr de vouloir supprimer ce fichier ?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Oui",
                cancelButtonText: "Annuler",
                closeOnConfirm: true
            },
            function(isConfirm){
                if (isConfirm) {
                    $.ajax({
                        type: 'post',
                        url : url,
                        datatype: 'json',
                        beforeSend: function () {
                            elt.prop('disabled',true);
                            $('#loadFiles').show();
                            $('#alertFile').get(0).innerHTML = "";
                        },
                        success: function (json) {
                            if (json.status === 0) {
                                $('#alertFile').append(
                                    "<span class='alert alert-success'>"+ json.mes +"</span>"
                                );
                                $('#'+elt.data('id')).remove();
                            } else {
                                $('#alertFile').append(
                                    "<span class='alert alert-danger'>"+ json.mes +"</span>"
                                );
                            }
                        },
                        complete: function () {
                            elt.prop('disabled',false);
                            $('#loadFiles').hide();
                        },
                        error: function(jqXHR, textStatus, errorThrown){}
                    });
                }
            });
    });


    // uploaded files

    $('#formFiles').on('submit', function (e) {
        e.preventDefault();
        var formdata = (window.FormData) ? new FormData($(this)[0]) : null;
        var data = (formdata !== null) ? formdata : $(this).serialize();
        $.ajax({
            type: 'post',
            url: $("#formFiles").attr('action'),
            data: data,
            datatype: 'json',
            processData: false,
            contentType: false,
            beforeSend: function () {
                $("#filesBtn").prop('disabled',true);
                $('#loadFiles').show();
                $('#alertFile').get(0).innerHTML = "";
            },
            success: function (json) {
                if (json.status === 0){
                    $('#alertFile').append(
                        "<span class='alert alert-success'>"+ json.mes +"</span>"
                    );
                    setTimeout(function () {
                        window.location.reload();
                    }, 2000);
                }else{
                    $('#alertFile').append(
                        "<span class='alert alert-danger'>"+ json.mes +"</span>"
                    );
                }
            },
            complete: function () {
                $('#filesBtn').prop('disabled',false);
                $('#loadFiles').hide();
            },
            error: function(jqXHR, textStatus, errorThrown){}
        });
    });

});