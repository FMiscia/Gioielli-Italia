$(document).ready(function() {

    type = null;
    todelete = null;

    $('#upcontainer').hide();

    var uploader = new plupload.Uploader({
        runtimes: 'gears,html5,flash,silverlight,browserplus',
        browse_button: 'pickfiles',
        container: 'upcontainer',
        max_file_size: '10mb',
        url: '/index.php/pages/upload',
        multipart: true,
        //flash_swf_url: '/plupload/js/plupload.flash.swf',
        //silverlight_xap_url: '/plupload/js/plupload.silverlight.xap',
        filters: [
            {title: "Image files", extensions: "jpg,jpeg,gif,png"}
        ],
        resize: {width: 800, height: 600, quality: 90}
    });

    $('#uploadfiles').click(function(e) {
        uploader.start();
        e.preventDefault();
    });

    uploader.init();


    uploader.bind('Init', function(up, params) {

    });

    uploader.bind('BeforeUpload', function(up, file) {
        uploader.settings.multipart_params = {tipo: type}
    });

    uploader.bind('FilesAdded', function(up, files) {
        $.each(files, function(i, file) {
            $('#filelist').append(
                    '<div id="' + file.id + '">' +
                    file.name + ' (' + plupload.formatSize(file.size) + ') <b></b>' +
                    '</div>');
        });

        up.refresh(); // Reposition Flash/Silverlight
    });

    uploader.bind('UploadProgress', function(up, file) {
        $('#' + file.id + " b").html(file.percent + "%");
    });

    uploader.bind('Error', function(up, err) {
        $('#filelist').append("<div>Error: " + err.code +
                ", Message: " + err.message +
                (err.file ? ", File: " + err.file.name : "") +
                "</div>"
                );

        up.refresh(); // Reposition Flash/Silverlight
    });

    uploader.bind('FileUploaded', function(up, file, response) {
        $('#' + file.id + " b").html("100%");
        res = jQuery.parseJSON(response.response);
        if (res.result) {
            $("#block").html('Immagine inserita con successo nella sezione "' + type + '"');
            $('.filter-adm').show();
            $('#upcontainer').hide('slow');
        }
        else {
            $("#block").html('');
            $("#block").html('Errore... ');
            $('.filter-adm').show();
            $('#upcontainer').hide('slow');
        }

    });

    $('.filter-adm').click(function(e) {

        $('.filter-adm').not($(this)).hide('slow');
        $('#upcontainer').show();
        type = $(this).attr("name")
        $("#block").html('');
    });

    $('.imgtodelete').click(function() {
        todelete = $(this).attr("src");
        $(this).attr('height', '128');
        $(this).attr('width', '128');
        $(this).next().show();
        $('.result').html("");
    });

    $('.conf').click(function() {
        var me = this;
        $.post("./deletePhoto",
                {
                    img: todelete
                }).success(function(data) {
            var response = jQuery.parseJSON(data);
            if (response.result) {
                $(me).parent().prev().hide("slow");
                $(me).parent().hide();
            }
            else {
                $(me).parent().prev().hide("slow");
                $(me).parent().append('<div class="result">Errore: aggiorna e riprova</div>');
            }
        });
    });

    $('.disc').click(function() {
        $(this).parent().hide();
        $(this).parent().prev().attr('height', '150');
        $(this).parent().prev().attr('width', '150');
        $(this).parent().prev().show();
    });


    $('#aggiorna').click(function() {
        window.location = './login';
        return false;
    });

    $('#logout').click(function() {
        window.location = './logout';
        return false;
    });

    $('#bhome').click(function() {
        window.location = './home';
        return false;
    });


});