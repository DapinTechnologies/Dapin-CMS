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

        <?php $__currentLoopData = $visits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $visit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            L.marker([<?php echo e($visit->latitude); ?>, <?php echo e($visit->longitude); ?>])
                .addTo(map)
                .bindPopup(`<strong><?php echo e($visit->device_type); ?></strong><br><?php echo e($visit->city); ?>, <?php echo e($visit->country); ?><br><?php echo e($visit->page_visited); ?>`);
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </script>
</body>
</html>
<?php /**PATH C:\Users\User\Desktop\cms\Dapin-CMS\resources\views/visits/map.blade.php ENDPATH**/ ?>