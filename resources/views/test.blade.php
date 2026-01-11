<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
    #map {
        width: 100%;
        height: 400px;
    }
</style>
</head>
<body>
    <h3>test google map</h3>
    <div id="map" class=""></div>

    <script>
        function initMap(){
             let recto = {lat: 14.60491736184604, lng: 120.9783378601992}

             let map = new google.maps.Map(    //create new googleap object
                document.getElementById('map'), {zoom: 4, center: recto}  //where to center the map
             );

             let marker = new google.maps.Marker({position: recto, map: map})
        }
    </script>

    <script async defer src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps.key') }}&callback=initMap"></script>
</body>
</html>