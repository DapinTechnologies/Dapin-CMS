<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use GeoIP;
use App\Models\Visit;

class VisitController extends Controller
{
    public function trackVisit(Request $request)
    {
        $agent = new Agent();
        $ipAddress = $request->ip();
        $location = GeoIP::getLocation($ipAddress);

        // Get device type (mobile, tablet, desktop)
        $deviceType = $agent->device();

        // Get the page visited
        $pageVisited = $request->path();

        // Store in the database
        Visit::create([
            'device_type' => $deviceType,
            'ip_address' => $ipAddress,
            'latitude' => $location ? $location->latitude : null,
            'longitude' => $location ? $location->longitude : null,
            'page_visited' => $pageVisited,
        ]);
    }
}
