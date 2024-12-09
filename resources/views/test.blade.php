<!DOCTYPE html>
<html>

<head>
    <title>Leaflet Polygon Clustering Example</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.Default.css" />
    <style>
        #map {
            height: 600px;
        }
    </style>
</head>

<body>
    <div id="map"></div>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet.markercluster/dist/leaflet.markercluster.js"></script>
    <script>
        // Khởi tạo bản đồ
        var map = L.map('map').setView([37.77, -122.43], 5);

        // Thêm lớp bản đồ
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Tạo nhóm cluster
        var markers = L.markerClusterGroup();

        // Tạo các polygon
        var polygon1 = L.polygon([
            [35.51, -122.68],
            [37.77, -122.43],
            [34.04, -118.2]
        ]).addTo(map);
        var polygon2 = L.polygon([
            [40.78, -113.91],
            [41.83, -117.62],
            [37.07, -122.03],
            [34.54, -118.52]
        ]).addTo(map);

        // Tính toán centroid của các polygon
        function getCentroid(latlngs) {
            var latSum = 0,
                lngSum = 0,
                len = latlngs.length;
            for (var i = 0; i < len; i++) {
                latSum += latlngs[i][0];
                lngSum += latlngs[i][1];
            }
            return [latSum / len, lngSum / len];
        }

        var centroid1 = getCentroid(polygon1.getLatLngs()[0]);
        var centroid2 = getCentroid(polygon2.getLatLngs()[0]);

        // Tạo các marker tại vị trí centroid
        var marker1 = L.marker(centroid1).bindPopup('Polygon 1');
        var marker2 = L.marker(centroid2).bindPopup('Polygon 2');

        // Thêm các marker vào nhóm cluster
        markers.addLayer(marker1);
        markers.addLayer(marker2);

        // Thêm nhóm vào bản đồ
        map.addLayer(markers);
    </script>
</body>

</html>
