<!DOCTYPE html>
<html>
<head>
    <title>Visitor Map</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <style>
        #map { height: 500px; }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Users Visitor Map</h2>
    <div id="map"></div>

    <script>
        var map = L.map('map').setView([0, 0], 2);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        @foreach($visits as $visit)
            L.marker([{{ $visit->latitude }}, {{ $visit->longitude }}])
                .addTo(map)
                .bindPopup(`<strong>{{ $visit->device_type }}</strong><br>{{ $visit->city }}, {{ $visit->country }}<br>{{ $visit->page_visited }}`);
        @endforeach
    </script>
</body>
</html>
