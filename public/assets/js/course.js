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

    function previewVideoIframe(video, videoPreview){
        if(video.val().toLowerCase().split('iframe').length > 1)
            videoPreview.html(video.val());
        else
            videoPreview.html('');
    }

    function formatUrl(url){
        return url.replaceAll(/[|&_ ]+/g, "-").replaceAll("é", "e").replaceAll("à", "a").toLowerCase();
    }
    editCkeditor();

    $('#form').on('submit', function (e) {
        e.preventDefault();
        $('#metaUrl').val(formatUrl($("#title").val()));
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
        editor.setData($(this).data('overview'));
        $('#overview').val($(this).data('overview'));
        $('#price').val($(this).data('price'));
        $('#oldPrice').val($(this).data('oldprice'));
        $('#duration').val($(this).data('duration'));
        $('#metaUrl').val($(this).data('metaurl'));
        $('#video').val($(this).data('video'));
        $('#metaDescription').val($(this).data('metadescription'));
        previewVideoIframe($('#video'), $('#videoPreview'));
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

    $("#video").on('keyup', function (e) {
        previewVideoIframe($(this), $('#videoPreview'));
    });

    $('.videoLink').on('click', function (e) {
        e.preventDefault();
        $("#videoContainer").html($(this).attr('videoframe'));
    });

    var MAX_CHARACTER = 200;
    $(".rx-training-item .rx-overview").each(function (i, elt) {
        $(elt).html($($(elt).data('overview')).text().slice(0, MAX_CHARACTER) + "...");
    });

    $('.publishCourse input').on('change', function (e) {
        var publishCheckBox = $(this);
        $.ajax({
            type: 'post',
            url: publishCheckBox.closest(".publishCourse").attr('action'),
            data: "publish=" + (publishCheckBox.is(":checked")? 1 : 0),
            datatype: 'json',
            beforeSend: function () {
            },
            success: function (json) {
                if (json.status == 0){
                    alert(json.mes);
                }else{
                    alert(json.mes);
                    publishCheckBox.prop("checked", !publishCheckBox.prop("checked"));
                }
            },
            complete: function () {
            },
            error: function(jqXHR, textStatus, errorThrown){}
        });
    });
});