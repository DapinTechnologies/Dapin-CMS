<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class TrackVisits
{
    public function handle(Request $request, Closure $next)
    {
        // Exclude AJAX, JSON, and asset requests
        if (
            $request->ajax() ||
            $request->wantsJson() ||
            preg_match('#\.(js|css|png|jpg|jpeg|gif|svg|woff2?|ttf|eot|ico|map)$#i', $request->path())
        ) {
            return $next($request);
        }

        // Exclude API and storage routes (you can add more patterns if needed)
        if (
            $request->is('api/*') ||
            $request->is('storage/*')
        ) {
            return $next($request);
        }

        // Optionally skip robots/crawlers
        $agent = new Agent();
        if ($agent->isRobot()) {
            return $next($request);
        }

        // GeoIP lookup (use correct facade/class for your setup)
        $geo = geoip($request->ip());

        \App\Models\Visit::create([
            'device_type'   => $agent->device() ?: $request->userAgent(),
            'ip_address'    => $request->ip(),
            'latitude'      => $geo->latitude ?? null,
            'longitude'     => $geo->longitude ?? null,
            'country'       => $geo->country ?? null,
            'city'          => $geo->city ?? null,
            'page_visited'  => $request->path(),
        ]);

        return $next($request);
    }
}
