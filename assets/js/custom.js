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
        'address': "Hirschbergstraße 53, 71634 Ludwigsburg",
        'tel': "Tel  07141378985",
        'mobile': "Mobile 01796833989",
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
                +'<div style="float:left"><img src=assets/img/map.jpg /><div>'
                + '<div style="display:inline;float:right"><ul class="clearfix">'
                + '<li>' + marker.address + '</li>'
                + '<li>' + marker.tel + '</li>'
                + '<li>' + marker.mobile + '</li>'
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




});
