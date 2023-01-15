let map = null;
let typingTimer; 
let doneTypingInterval = 1000;

(function ($) {
    function findAddress() {
        var address = document.getElementById("search_location").value;
        if (address.length == 0) {
            alert("An address is required.");
            return;
        }
      
        address = address.split(' ').join('+');
        var url = '/wp-content/mu-plugins/first-responder-plugin/ajax/geocode.php?address='+address;
        //console.log(url);
        $.getJSON(url, function(data) {
            //data is the JSON string
            //console.log(data);
            if (data.status == "OK") {
                let lat = parseFloat( data.results[0].geometry.location.lat );
                let lng = parseFloat( data.results[0].geometry.location.lng );

                $('#main_data_geolocation').attr('value', lat + ',' + lng);

                var latLng = {
                    lat: lat,
                    lng: lng
                };
        
                new google.maps.Marker({
                    position : latLng,
                    map: map
                });    
                map.setCenter(latLng);
                map.setZoom( 12 );
            } else {
                alert("We were unable to locate your address. Please try again. Be sure to include a city, state, and zip will help.");
                return;
            }
        });
    }

    function initMap( $el ) {
        var mapArgs = {
            zoom        : 8,
            mapTypeId   : google.maps.MapTypeId.ROADMAP
        };
        var map = new google.maps.Map( $el[0], mapArgs );

        var value;
        if ($('#map-location').length) {
            value = $('#map-location').attr('data-loc');
        } else {
            value = $('#search_location').attr('value');
        }
        if (value) {
            const loc = value.split(",");
            const lat = parseFloat( loc[0] );
            const lng = parseFloat( loc[1] );
    
            new google.maps.Marker({
                position : {
                    lat: lat,
                    lng: lng
                },
                map: map
            });    

            map.setCenter({ lat:lat, lng:lng });
        } else {
            map.setCenter({lat:37.0902, lng:-95.7129});
            map.setZoom(5);
        }
        
        return map;
    }

    $(document).ready(function() {
        if ($('#main_map').length) {
            map = initMap( $('#main_map') );

            $('#search_location').on('keyup', function () {
                clearTimeout(typingTimer);
                typingTimer = setTimeout(findAddress, doneTypingInterval);
            });
              
            //on keydown, clear the countdown 
            $('#search_location').on('keydown', function () {
                clearTimeout(typingTimer);
            });
        }
    });
})(jQuery);