$(document).ready(function() {
    // init ckeditor
    var editor;
    function editCkeditor() {
        return  DecoupledEditor
            .create( document.querySelector( '#editor' ), {
                placeholder: 'Description de la formation'
            })
            .then( function (value) {
                editor = value;
                const toolbarContainer = document.querySelector( '#toolbar-container' );
                toolbarContainer.prepend( value.ui.view.toolbar.element );
                value.model.document.on( 'change:data', function(){
                    $("#overview").val(editor.getData());
                });
            })
            .catch(function (reason) { console.error(reason); });
    }
    editCkeditor();

    $('#form').on('submit', function (e) {
        e.preventDefault();
        var formdata = (window.FormData) ? new FormData($(this)[0]) : null;
        var data = (formdata !== null) ? formdata : $(this).serialize();
        $.ajax({
            type: 'post',
            url: $("#form").attr('action'),
            data: data,
            datatype: 'json',
            processData: false,
            contentType: false,
            beforeSend: function () {
                $('#sendBtn').prop('disabled',true);
                $('#textSendBtn').text('Patientez...');
                $('#loadSendBtn').show();
                $('#alert').get(0).innerHTML = "";
            },
            success: function (json) {
                if (json.status === 0){
                    $('#alert').append(
                        "<span class='alert alert-success'>"+ json.mes +"</span>"
                    );
                    setTimeout(function () {
                        window.location.reload();
                    }, 1500);
                }else{
                    $('#alert').append(
                        "<span class='alert alert-danger'>"+ json.mes +"</span>"
                    );
                }
            },
            complete: function () {
                $('#sendBtn').prop('disabled',false);
                $('#loadSendBtn').hide();
                $('#textSendBtn').text('Enregistrer');
            },
            error: function(jqXHR, textStatus, errorThrown){}
        });
    });

    $('#newModal').on('click', function () {
        $('#form').get(0).reset();
        editor.setData("");
        $('#alert').get(0).innerHTML = "";
        $("#videoPreview").html("");
        $('#form').attr('action', $(this).data('url'));
    });

    $('.editModal').on('click', function () {
        $('#title').val($(this).data('title'));
        editor.setData($(this).data('video'));
        $('#overview').val($(this).data('overview'));
        $('#price').val($(this).data('price'));
        $('#oldPrice').val($(this).data('oldprice'));
        $('#duration').val($(this).data('duration'));
        $('#video').val($(this).data('video'));
        $('#metaDescription').val($(this).data('metadescription'));
        console.log($(this).data('ispublished'));
        if($(this).data('ispublished'))
            $("#isPublished").attr("checked", "checked");
        else
            $("#isPublished").removeAttr("checked", "checked");
        $('#form').attr('action', $(this).data('url'));
    });

    $('.deleteElt').on('click', function (e) {
        e.preventDefault();
        var url = $(this).data('url');
        swal({
                title: "Warning",
                text: "Êtes vous sûr de vouloir supprimer cette formation?",
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
                        success: function (json) {
                            if (json.status === 0) {
                                window.location.reload();
                            } else {
                                // toastr.error(json.mes,'Oups!');
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown){}
                    });
                }
            });
    });

    $("#video").on('change', function (e) {
        if($(this).val().toLowerCase().split('iframe').length > 1)
            $('#videoPreview').html($(this).val());
    });

    $('.videoLink').on('click', function (e) {
        e.preventDefault();
        $("#videoPreview").html($(this).attr('videoframe'));
    });
});