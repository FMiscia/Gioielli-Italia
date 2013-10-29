/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function() {

    $("#go").click(function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: index.php/backend/login,
            data: ({
                user: $('#user').text(),
                pass: $('#pass').text()
            }),
            success: success,
            dataType: dataType,
            async: false
        });
    });

});