$(document).ready(function() {

    type = null;
    todelete = null;

    $('.filter-adm').click(function(e) {

        $('.filter-adm').not($(this)).hide('slow');
        $('#newHotnessForm').show();
        type = $(this).attr("name")
        $('#lfile').html('Scegli un\'immagine per la sezione ' + type + ':');
        $("#block").html('');
    });

    $(document).on('click', '#addProduct', function(e) {
        e.preventDefault();
        $("#block").html('<img src="/assets/img/loader.gif" alt="Uploading...."/>');
        $('#type').attr("value", type);
        $("#newHotnessForm").ajaxForm(
                {
                    success: function(data) {
                        var response = jQuery.parseJSON(data);
                        if (response.result) {
                            $("#block").html('');
                            $("#block").html('Immagine inserita con successo nella sezione "' + type + '"');
                            $('.filter-adm').show();
                            $('#newHotnessForm').hide('slow');
                            /*setTimeout(function() {
                             location.reload();
                             }, 1200);*/
                        }
                        else {
                            $("#block").html('');
                            $("#block").html('Errore. Forse la dimensione dell\'immagine &eacute troppo grande o di\n\
                                        un tipo diverso da png,jpg o JPG');

                        }
                    }
                }).submit();

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
        window.location = './home/logout/true';
        return false;
    });

    $('#bhome').click(function() {
        window.location = './home';
        return false;
    });


});