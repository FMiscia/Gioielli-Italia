/**
 * Maps
 * 
 */
$(document).ready(function() {

    var map = initializeMap();
    var markerPos = new google.maps.LatLng(
            parseFloat(48.90799),
            parseFloat(9.16188)
            );
    var marker = new google.maps.Marker({
        'position': markerPos,
        'map': map,
        'title': "Gioielli Italia",
        'address': "Hirschbergstra&szlig;e 53, 71634 Ludwigsburg",
        'tel': "Tel  07141/378985",
        'mobile': "Mobile 01796833989",
        'email': 'gioielli-italia@web.de',
        'apertura1': 'mo-fr 10-13 Uhr und 15:30-20 Uhr',
        'apertura2': 'Sa. 10-19 Uhr',
        'infoHTML': infoHTML
    });

    var infowindow = new google.maps.InfoWindow({
        maxWidth: 600,
        maxHeight: 700
                //pixelOffset: new google.maps.Size(-150, 50)
    });

    google.maps.event.addListener(marker, 'click', function() {
        infowindow.setContent(infoHTML());
        infowindow.open(map, marker);
    });

    google.maps.event.addListener(map, 'tilesloaded', function() {
        infowindow.setContent(infoHTML());
        infowindow.open(map, marker);
    });

    function infoHTML() {
        var output;
        output = '<div><h4>' + marker.title + '</h4></div>'
                + '<div style="float:left"><img src=/assets/img/map.jpg /><div>'
                + '<div style="display:inline;float:right"><ul class="clearfix">'
                + '<li>' + marker.address + '</li>'
                + '<li>' + marker.tel + '</li>'
                + '<li>' + marker.mobile + '</li>'
                + '<li>' + marker.email + '</li>'
                + '<li>' + marker.apertura1 + '</li>'
                + '<li>' + marker.apertura2 + '</li>'
                + '</ul><div>';
        return output;
    }



    function initializeMap() {
        var myOptions = {
            zoom: 16,
            center: new google.maps.LatLng(48.90799, 9.16188),
            mapTypeId: google.maps.MapTypeId.ROADMAP,
        };
        return new google.maps.Map($('#map_canvas')[0], myOptions);
    }

    function checkfield() {
        var reg = /^[\w\.\-]+@([\w\-]+\.)+[a-zA-Z]/;
        return ($('#name').val() == "" || $('#email').val() == "" || reg.test($('#email').val()) || $('#message').val() == "")

    }









});
