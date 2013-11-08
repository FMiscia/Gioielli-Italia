$(document).ready(function() {

    type = null;
    todelete = null;

    $('#upcontainer').hide();
    /*if (!f) {
     var f = {};
     }
     
     f.image = new image();
     
     var file = document.getElementById("ifile");
     file.addEventListener("change", function() {
     f.image.handle_images(file);
     }, false);
     */

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

    uploader.bind('Init', function(up, params) {

    });

    uploader.bind('BeforeUpload', function(up, file) {
        uploader.settings.multipart_params = {tipo: type}
    });

    $('#uploadfiles').click(function(e) {
        uploader.start();
        e.preventDefault();
    });

    uploader.init();

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

    /*$(document).on('click', '#addProduct', function(e) {
     e.preventDefault();
     $("#block").html('<img src="/assets/img/loader.gif" alt="Uploading...."/>');
     $('#type').attr("value", type);
     $.ajax({
     type: "POST",
     url: "./upload",
     data: {
     ifile: file,
     tipo: type
     }
     }).done(
     function(data) {
     var response = jQuery.parseJSON(data);
     if (response.result) {
     //$("#block").html('');
     if (response.result) {
     $.post("./thumb", function(data2) {
     var response2 = jQuery.parseJSON(data2);
     if (response2 == null) {
     $("#block").html('');
     $("#block").html('Errore: Il server non riesce a da solo a comprimere l\'immagine\n\
     Prova con un\'immagine di dimensione inferiore a 1.0M e risoluzione non superiore a 2048x1024');
     $('.filter-adm').show();
     $('#newHotnessForm').hide('slow');
     }
     if (response2.result) {
     $("#block").html('Immagine inserita con successo nella sezione "' + type + '"');
     $('.filter-adm').show();
     $('#newHotnessForm').hide('slow');
     } else {
     $("#block").html('');
     $("#block").html('Errore. Forse la dimensione o la risoluzione dell\'immagine &eacute troppo grande ');
     $('.filter-adm').show();
     $('#newHotnessForm').hide('slow');
     }
     })
     }
     }
     });
     });*/
    /*setTimeout(function() {
     location.reload();
     }, 1200);
     else {
     $("#block").html('');
     $("#block").html('Errore. Tipo di immagine non riconosciuto');
     $('.filter-adm').show();
     $('#newHotnessForm').hide('slow');
     
     }
     }
     });
     /*$("#newHotnessForm").ajaxForm(
     {
     success: function(data) {
     var response = jQuery.parseJSON(data);
     if (response.result) {
     //$("#block").html('');
     if (response.result) {
     $.post("./thumb", function(data2) {
     var response2 = jQuery.parseJSON(data2);
     if (response2 == null) {
     $("#block").html('');
     $("#block").html('Errore: Il server non riesce a da solo a comprimere l\'immagine\n\
     Prova con un\'immagine di dimensione inferiore a 1.0M e risoluzione non superiore a 2048x1024');
     $('.filter-adm').show();
     $('#newHotnessForm').hide('slow');
     }
     if (response2.result) {
     $("#block").html('Immagine inserita con successo nella sezione "' + type + '"');
     $('.filter-adm').show();
     $('#newHotnessForm').hide('slow');
     } else {
     $("#block").html('');
     $("#block").html('Errore. Forse la dimensione o la risoluzione dell\'immagine &eacute troppo grande ');
     $('.filter-adm').show();
     $('#newHotnessForm').hide('slow');
     }
     })
     }
     /*setTimeout(function() {
     location.reload();
     }, 1200);
     else {
     $("#block").html('');
     $("#block").html('Errore. Tipo di immagine non riconosciuto');
     $('.filter-adm').show();
     $('#newHotnessForm').hide('slow');
     
     }
     }
     }
     }).submit();
     
     });*/


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


    /*var image = function() {
     //this.file_name = 'somepic.jpg';
     this.handle_images = function(element) {
     var list = element.files[0];
     var self = this;
     
     var img = new Image;
     var reader = new FileReader();
     var canvas = document.getElementById("manipulate");
     var context = canvas.getContext("2d");
     
     context.clearRect(0, 0, canvas.width, canvas.height);
     var w = canvas.width;
     canvas.width = 1;
     canvas.width = w;
     reader.onload = function(e) {
     img.src = e.target.result;
     img.onload = function() {
     self.original_width = img.width;
     self.original_height = img.height;
     
     self.max_width = 800;
     self.max_height = 600;
     
     var new_width = img.width /
     (self.original_height / self.max_height);
     self.dx = (self.max_width - new_width) / 2;
     self.dy = 0;
     img.height = self.max_height;
     img.width = new_width;
     
     self.width = img.width;
     self.height = img.height;
     
     context.drawImage(img, self.dx, self.dy,
     img.width, img.height);
     };
     }
     reader.readAsDataURL(list);
     
     }
     }*/




});