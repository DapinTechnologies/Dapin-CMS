<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

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

        // // Store in the database
        // Visit::create([
        //     'device_type' => $deviceType,
        //     'ip_address' => $ipAddress,
        //     'latitude' => $location ? $location->latitude : null,
        //     'longitude' => $location ? $location->longitude : null,
        //     'page_visited' => $pageVisited,
        // ]);
    }



public function showStats()
{
    // Group by device type
    $deviceStats = Visit::selectRaw('device_type, COUNT(*) as total')
                        ->groupBy('device_type')
                        ->orderByDesc('total')
                        ->get();

    // Group by country
    $countryStats = Visit::selectRaw('country, COUNT(*) as total')
                         ->whereNotNull('country')
                         ->groupBy('country')
                         ->orderByDesc('total')
                         ->get();

    // Group by city
    $cityStats = Visit::selectRaw('city, COUNT(*) as total')
                      ->whereNotNull('city')
                      ->groupBy('city')
                      ->orderByDesc('total')
                      ->get();

    // Group by visited page (add this new query)
    $pageStats = Visit::selectRaw('page_visited, COUNT(*) as total')
                      ->whereNotNull('page_visited')
                      ->groupBy('page_visited')
                      ->orderByDesc('total')
                      ->get();

    return view('admin.stats', compact('deviceStats', 'countryStats', 'cityStats', 'pageStats'));
}




public function showMap()
    {
        $visits = Visit::whereNotNull('latitude')->whereNotNull('longitude')->get();

        $deviceStats = Visit::select('country', 'city', 'device_type')
            ->groupBy('country', 'city', 'device_type')
            ->selectRaw('count(*) as total, country, city, device_type')
            ->orderByDesc('total')
            ->get();

        return view('visits.map', compact('visits', 'deviceStats'));
    }
}
