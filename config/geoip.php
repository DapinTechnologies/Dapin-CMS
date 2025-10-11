<?php
return [

    /*
    |----------------------------------------------------------------------
    | Logging Configuration
    |----------------------------------------------------------------------
    */
    'log_failures' => true,

    /*
    |----------------------------------------------------------------------
    | Include Currency in Results
    |----------------------------------------------------------------------
    */
    'include_currency' => true,

    /*
    |----------------------------------------------------------------------
    | Default Service
    |----------------------------------------------------------------------
    */
    'service' => 'ipgeolocation',

    /*
    |----------------------------------------------------------------------
    | Storage Specific Configuration
    |----------------------------------------------------------------------
    */
    'services' => [
        'ipgeolocation' => [
            'class' => \Torann\GeoIP\Services\IPGeoLocation::class,
            'secure' => true, // Use HTTPS for secure connections
            'key' => env('IPGEOLOCATION_KEY'), // Fetch the API key from the .env file
            'continent_path' => storage_path('app/continents.json'), // Path for the continents data file
            'lang' => 'en', // Set language for results
        ],
    ],

    /*
    |----------------------------------------------------------------------
    | Default Cache Driver
    |----------------------------------------------------------------------
    */
    'cache' => 'file',
  // This will cache all locations(channged from all to file)

    /*
    |----------------------------------------------------------------------
    | Cache Tags
    |----------------------------------------------------------------------
    */
    'cache_tags' => ['torann-geoip-location'],

    /*
    |----------------------------------------------------------------------
    | Cache Expiration
    |----------------------------------------------------------------------
    */
    'cache_expires' => 30,  // Cache expiration time in minutes

    /*
    |----------------------------------------------------------------------
    | Default Location
    |----------------------------------------------------------------------
    */
   'default_location' => [
    'ip' => '127.0.0.0',
    'iso_code' => 'KE',            // Kenya's ISO country code
    'country' => 'Kenya',          // Country name
    'city' => 'Nairobi',           // Default city, you can change this if needed
    'state' => '',                 // Kenya does not have states, so leave this empty
    'state_name' => '',            // Same as above, no states in Kenya
    'postal_code' => '',           // Optional, not needed for Kenya
    'lat' => -1.2921,              // Latitude for Nairobi, Kenya
    'lon' => 36.8219,              // Longitude for Nairobi, Kenya
    'timezone' => 'Africa/Nairobi', // Timezone for Kenya
    'continent' => 'AF',           // Africa continent code
    'default' => true,
    'currency' => 'KES',           // Kenyan Shilling (KES) currency
],


];
