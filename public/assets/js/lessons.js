$(document).ready(function() {

    var editor;
    var editor2;
    function editCkeditor() {
        return  DecoupledEditor
            .create( document.querySelector( '#editor' ), {
                placeholder: "Description de l'aperçu de la formation"
            })
            .then( function (value) {
                editor = value;
                var toolbarContainer = document.querySelector( '#toolbar-container' );
                toolbarContainer.prepend( value.ui.view.toolbar.element );
                value.model.document.on( 'change:data', function(){
                    $("#smallDescription").val(editor.getData());
                });
            })
            .catch(function (reason) { console.error(reason); });
    }
    function editCkeditor2() {
        return  DecoupledEditor
            .create( document.querySelector( '#editor2' ), {
                placeholder: "Description de la formation"
            })
            .then( function (value) {
                editor2 = value;
                var toolbarContainer = document.querySelector( '#toolbar-container2' );
                toolbarContainer.prepend( value.ui.view.toolbar.element );
                value.model.document.on( 'change:data', function(){
                    $("#description").val(editor2.getData());
                    console.log("Hey"+editor2.getData());
                });
            })
            .catch(function (reason) { console.error(reason); });
    }

    var colors = ["#fff", "#000", "#f2a900"];
    var toolbarOptions = [
        [{ 'font': [] }, {size: [ 'small', false, 'large', 'huge' ]}],
        ['bold', 'italic', 'underline', 'strike'],
        [{ 'color': colors }, {'background': colors}],
        [ { 'header': 1 }, { 'header': 2 }, {'header': 3}, 'blockquote'],
        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
        [{ 'direction': 'rtl' }, 'align', { 'indent': '-1'}, { 'indent': '+1'}],
        ["link", 'image', 'video']
    ];

    function createEditor(editorId, placeholder) {
        return new Quill(editorId, {
            placeholder: placeholder,
            theme: 'snow',
            modules: {
                toolbar: toolbarOptions
            }
        });
    }

    var editor1 = createEditor("#editor1"),
        editor2 = createEditor("#editor2");

    editor1.on('editor-change', function(delta, oldDelta, source) {
        $('#smallDescription').val(editor1.root.innerHTML);
    });

    editor2.on('editor-change', function(delta, oldDelta, source) {
        $('#description').val(editor2.root.innerHTML);
    });
    function previewVideoIframe(video, videoPreview){
        if(video.val().toLowerCase().split('iframe').length > 1)
            videoPreview.html(video.val());
        else
            videoPreview.html('');
    }

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
                    }, 2000);
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
        editor1.root.innerHTML = "";
        editor2.root.innerHTML = "";
        $('#alert').get(0).innerHTML = "";
        $("#form").attr('action', $(this).data('url'));
        $('#filesContainer').show();
    });

    $('.editModal').on('click', function () {
        editor1.root.innerHTML = $(this).data("smalldescription");
        editor2.root.innerHTML = $(this).data("description");
        $('#title').val($(this).data('title'));
        $('#video').val($(this).data('video'));
        $('#duration').val($(this).data('duration'));
        $("#form").attr('action', $(this).data('url'));
        $('#filesContainer').hide();
        previewVideoIframe($('#video'), $('#videoPreview'));
    });

    $('.deleteElt').on('click', function (e) {
        e.preventDefault();
        var url = $(this).data('url');
        swal({
                title: "Warning",
                text: "Êtes vous sûr de vouloir supprimer cette leçon?",
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
});