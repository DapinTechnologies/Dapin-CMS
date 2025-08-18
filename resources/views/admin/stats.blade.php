@extends('admin.layouts.master')

<style>
    #pieChart{
        max-width: 100% !important;
        max-height: 500px !important;
    }
</style>


@section('content')

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">

 <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" />
    <style>
        .traffic-light {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin-right: 6px;
        }
        .traffic-light.high { background-color: #ef4444; }
        .traffic-light.medium { background-color: #f59e0b; }
        .traffic-light.low { background-color: #10b981; }
        
        .device-icon {
            width: 44px;
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            margin-right: 12px;
            transition: all 0.2s ease;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        
        [data-tooltip] {
            position: relative;
            cursor: help;
        }
        
        [data-tooltip]:hover::after {
            content: attr(data-tooltip);
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            padding: 4px 8px;
            background: rgba(0,0,0,0.8);
            color: white;
            border-radius: 4px;
            font-size: 12px;
            white-space: nowrap;
            pointer-events: none;
            z-index: 10;
        }
        
        .page-url {
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            display: inline-block;
        }
        
        .progress-bar {
            transition: width 0.5s ease-in-out;
        }
    </style>
</head>
<body class="bg-gray-50 font-sans">
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="bg-white shadow p-4 text-center">
            <h1 class="text-2xl font-bold text-indigo-600">Visitor Statistics Dashboard</h1>
            <p class="text-gray-500 mt-1">Comprehensive analytics of your website traffic</p>
        </header>

        <main class="flex-grow container mx-auto px-4 py-8">
            <!-- Quick Stats Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-8">
                @php
                    $totalVisits = $deviceStats->sum('total');
                    $mobileVisits = $deviceStats->where('device_type', 'mobile')->first()->total ?? 0;
                    $desktopVisits = $deviceStats->where('device_type', 'desktop')->first()->total ?? 0;
                    $topCountry = $countryStats->first();
                    $topPage = $pageStats->first() ?? null;
                @endphp
                
                <!-- Total Visits Card -->
                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500 hover:shadow-md transition-shadow">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-gray-500 text-sm font-medium">Total Visits</h3>
                            <p class="text-2xl font-bold mt-1 text-gray-800">{{ number_format($totalVisits) }}</p>
                        </div>
                        <div class="bg-blue-100 p-3 rounded-full text-blue-500">
                            <i class="fas fa-users text-xl"></i>
                        </div>
                    </div>
                </div>
                
                <!-- Mobile Visits Card -->
                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500 hover:shadow-md transition-shadow">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-gray-500 text-sm font-medium">Mobile Visits</h3>
                            <p class="text-2xl font-bold mt-1 text-gray-800">{{ number_format($mobileVisits) }}</p>
                            <div class="flex items-center mt-2">
                                <span class="text-sm text-gray-500">
                                    {{ $totalVisits > 0 ? round(($mobileVisits/$totalVisits)*100) : 0 }}% of total
                                </span>
                            </div>
                        </div>
                        <div class="bg-green-100 p-3 rounded-full text-green-500">
                            <i class="fas fa-mobile-alt text-xl"></i>
                        </div>
                    </div>
                </div>
                
                <!-- Top Page Card -->
                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-purple-500 hover:shadow-md transition-shadow">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-gray-500 text-sm font-medium">Top Page</h3>
                            <p class="text-lg font-bold mt-1 text-gray-800 truncate" title="{{ $topPage->page_visited ?? 'N/A' }}">
                                {{ $topPage->page_visited ?? 'N/A' }}
                            </p>
                            <div class="flex items-center mt-2">
                                <span class="text-sm text-gray-500">
                                    {{ $topPage->total ?? 0 }} views
                                </span>
                            </div>
                        </div>
                        <div class="bg-purple-100 p-3 rounded-full text-purple-500">
                            <i class="fas fa-file-alt text-xl"></i>
                        </div>
                    </div>
                </div>
                
                <!-- Top Country Card -->
                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-red-500 hover:shadow-md transition-shadow">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-gray-500 text-sm font-medium">Top Country</h3>
                            <p class="text-2xl font-bold mt-1 text-gray-800">{{ $topCountry->country ?? 'N/A' }}</p>
                            <div class="flex items-center mt-2">
                                <span class="text-sm text-gray-500">
                                    {{ $topCountry->total ?? 0 }} visits
                                </span>
                            </div>
                        </div>
                        <div class="bg-red-100 p-3 rounded-full text-red-500">
                            <i class="fas fa-globe text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Visited Pages Section -->
            @if($pageStats->count() > 0)
            <div class="bg-white rounded-lg shadow p-6 mb-8 hover:shadow-md transition-shadow">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-semibold text-indigo-700">Most Visited Pages</h2>
                    <span class="text-sm text-gray-500">{{ $pageStats->count() }} pages tracked</span>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-indigo-600 text-white">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Page URL</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Visits</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Traffic Level</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Share</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($pageStats as $item)
                            @php
                                $trafficLevel = $item->total > ($totalVisits * 0.2) ? 'high' : 
                                              ($item->total > ($totalVisits * 0.1) ? 'medium' : 'low');
                                $path = parse_url($item->page_visited, PHP_URL_PATH);
                                $path = $path ?: $item->page_visited;
                                $percentage = $totalVisits > 0 ? round(($item->total/$totalVisits)*100, 1) : 0;
                            @endphp
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-indigo-100 rounded-full flex items-center justify-center">
                                            <i class="fas fa-file-alt text-indigo-500"></i>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                <span class="page-url" title="{{ $item->page_visited }}">{{ $path }}</span>
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ Str::limit($item->page_visited, 50) }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                        {{ number_format($item->total) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="traffic-light {{ $trafficLevel }}"></span>
                                    <span class="text-sm text-gray-500 capitalize">{{ $trafficLevel }} traffic</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                                            <div class="bg-indigo-600 h-2.5 rounded-full progress-bar" 
                                                 style="width: {{ $percentage }}%"></div>
                                        </div>
                                        <span class="ml-2 text-sm text-gray-500">{{ $percentage }}%</span>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            <!-- Devices Section -->
            <div class="bg-white rounded-lg shadow p-6 mb-8 hover:shadow-md transition-shadow">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-semibold text-indigo-700">Device Analytics</h2>
                    <span class="text-sm text-gray-500">{{ $deviceStats->count() }} device types</span>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Device Types Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-indigo-600 text-white">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Device Type</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Visits</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Share</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($deviceStats as $item)
                                @php
                                    $percentage = $totalVisits > 0 ? round(($item->total/$totalVisits)*100) : 0;
                                @endphp
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center group relative">
                                            @php
                                                $deviceInfo = [
                                                    'mobile' => ['icon' => 'mobile-alt', 'color' => 'blue', 'label' => 'Smartphone'],
                                                    'desktop' => ['icon' => 'desktop', 'color' => 'purple', 'label' => 'Computer'],
                                                    'tablet' => ['icon' => 'tablet-alt', 'color' => 'green', 'label' => 'Tablet'],
                                                    'default' => ['icon' => 'question', 'color' => 'gray', 'label' => 'Other Device']
                                                ];
                                                
                                                $device = $deviceInfo[$item->device_type] ?? $deviceInfo['default'];
                                                $bgColor = "bg-{$device['color']}-100";
                                                $textColor = "text-{$device['color']}-500";
                                            @endphp
                                            <div class="device-icon {{ $bgColor }} {{ $textColor }} group-hover:scale-110 transition-transform duration-200" 
                                                 data-tooltip="{{ $device['label'] }}">
                                                <i class="fas fa-{{ $device['icon'] }}"></i>
                                            </div>
                                            <div class="ml-2">
                                                <div class="font-medium text-gray-800">{{ $device['label'] }}</div>
                                                <div class="text-xs text-gray-500">{{ number_format($item->total) }} visits</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                            {{ number_format($item->total) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                                <div class="h-2.5 rounded-full progress-bar
                                                    @if($item->device_type == 'mobile') bg-blue-500
                                                    @elseif($item->device_type == 'desktop') bg-purple-500
                                                    @elseif($item->device_type == 'tablet') bg-green-500
                                                    @else bg-gray-500 @endif" 
                                                    style="width: {{ $percentage }}%"></div>
                                            </div>
                                            <span class="ml-2 text-sm text-gray-500">{{ $percentage }}%</span>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Enhanced Device Breakdown Chart -->
                    <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-semibold text-gray-800">Device Distribution</h3>
                            <span class="text-sm text-gray-500">{{ $totalVisits }} total visits</span>
                        </div>
                        
                        <!-- Pie Chart Container -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="flex items-center justify-center">
                                <div class="relative w-48 h-48">
                                    @php
                                        $colors = [
                                            'mobile' => ['from' => 'from-blue-400', 'to' => 'to-blue-600', 'bg' => 'bg-blue-500'],
                                            'desktop' => ['from' => 'from-purple-400', 'to' => 'to-purple-600', 'bg' => 'bg-purple-500'],
                                            'tablet' => ['from' => 'from-green-400', 'to' => 'to-green-600', 'bg' => 'bg-green-500'],
                                            'default' => ['from' => 'from-gray-400', 'to' => 'to-gray-600', 'bg' => 'bg-gray-500']
                                        ];
                                        $totalDeg = 0;
                                    @endphp
                                    
                                    @foreach($deviceStats as $item)
                                        @php
                                            $device = $deviceInfo[$item->device_type] ?? $deviceInfo['default'];
                                            $color = $colors[$item->device_type] ?? $colors['default'];
                                            $percentage = $totalVisits > 0 ? ($item->total/$totalVisits) * 100 : 0;
                                            $deg = ($percentage/100) * 360;
                                            $rotation = $totalDeg;
                                            $totalDeg += $deg;
                                        @endphp
                                        <div class="absolute inset-0 rounded-full overflow-hidden" 
                                             style="background: conic-gradient(
                                                 {{ $color['bg'] }} {{$rotation}}deg, 
                                                 {{ $color['bg'] }} {{$rotation + $deg}}deg, 
                                                 transparent {{$rotation + $deg}}deg, 
                                                 transparent 360deg
                                             );">
                                        </div>
                                    @endforeach
                                    
                                    <div class="absolute inset-4 bg-white rounded-full flex items-center justify-center shadow-inner">
                                        <span class="text-2xl font-bold text-gray-700">{{ $deviceStats->count() }}</span>
                                        <span class="text-xs text-gray-500 block mt-1">Device Types</span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Device Details -->
                            <div class="space-y-4">
                                @foreach($deviceStats as $item)
                                @php
                                    $device = $deviceInfo[$item->device_type] ?? $deviceInfo['default'];
                                    $color = $colors[$item->device_type] ?? $colors['default'];
                                    $percentage = $totalVisits > 0 ? round(($item->total/$totalVisits)*100, 1) : 0;
                                    $bgGradient = "bg-gradient-to-r {$color['from']} {$color['to']}";
                                @endphp
                                <div class="group">
                                    <div class="flex justify-between items-center mb-1">
                                        <div class="flex items-center">
                                            <span class="w-3 h-3 rounded-full {{ $bgGradient }} mr-2"></span>
                                            <span class="text-sm font-medium text-gray-800">{{ $device['label'] }}</span>
                                        </div>
                                        <div class="text-right">
                                            <span class="text-sm font-semibold text-gray-900">{{ number_format($item->total) }}</span>
                                            <span class="text-xs text-gray-500 ml-1">({{ $percentage }}%)</span>
                                        </div>
                                    </div>
                                    <div class="w-full bg-gray-100 rounded-full h-2 overflow-hidden">
                                        <div class="h-full rounded-full transition-all duration-700 ease-out {{ $bgGradient }}" 
                                             style="width: {{ $percentage }}%"
                                             data-tooltip="{{ $percentage }}% of visits from {{ strtolower($device['label']) }} devices">
                                        </div>
                                    </div>
                                    <div class="mt-1 text-xs text-gray-500 flex justify-between">
                                        <span>0%</span>
                                        <span>100%</span>
                                    </div>
                                </div>
                                @endforeach
                                
                                <!-- Additional Metrics -->
                                <div class="mt-6 pt-4 border-t border-gray-100">
                                    <h4 class="text-sm font-medium text-gray-700 mb-3">Device Insights</h4>
                                    <div class="grid grid-cols-2 gap-4">
                                        @php
                                            $mostPopular = $deviceStats->sortByDesc('total')->first();
                                            $mostPopularDevice = $deviceInfo[$mostPopular->device_type] ?? $deviceInfo['default'];
                                            $mobileVsDesktop = $deviceStats->firstWhere('device_type', 'mobile')?->total ?? 0;
                                            $desktopVsMobile = $deviceStats->firstWhere('device_type', 'desktop')?->total ?? 0;
                                            $totalMobileDesktop = $mobileVsDesktop + $desktopVsMobile;
                                            $mobileVsDesktopPct = $totalMobileDesktop > 0 ? round(($mobileVsDesktop / $totalMobileDesktop) * 100) : 0;
                                        @endphp
                                        <div class="bg-gray-50 p-3 rounded-lg">
                                            <div class="text-xs text-gray-500">Most Popular</div>
                                            <div class="font-medium text-gray-900">{{ $mostPopularDevice['label'] }}</div>
                                            <div class="text-xs text-gray-500">{{ $mostPopular->total }} visits</div>
                                        </div>
                                        <div class="bg-gray-50 p-3 rounded-lg">
                                            <div class="text-xs text-gray-500">Mobile vs Desktop</div>
                                            <div class="font-medium text-gray-900">{{ $mobileVsDesktopPct }}% Mobile</div>
                                            <div class="text-xs text-gray-500">{{ 100 - $mobileVsDesktopPct }}% Desktop</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Countries and Cities Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Countries Table -->
                <div class="bg-white rounded-lg shadow p-6 hover:shadow-md transition-shadow">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-semibold text-indigo-700">Top Countries</h2>
                        <span class="text-sm text-gray-500">{{ $countryStats->count() }} countries</span>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-indigo-600 text-white">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Country</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Visits</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Share</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($countryStats->take(10) as $item)
                                @php
                                    $percentage = $totalVisits > 0 ? round(($item->total/$totalVisits)*100, 1) : 0;
                                @endphp
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <i class="fas fa-globe-americas text-indigo-500 mr-3"></i>
                                            <span class="text-gray-800">{{ $item->country }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                            {{ number_format($item->total) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                                <div class="bg-indigo-600 h-2.5 rounded-full progress-bar" 
                                                     style="width: {{ $percentage }}%"></div>
                                            </div>
                                            <span class="ml-2 text-sm text-gray-500">{{ $percentage }}%</span>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Cities Table -->
                <div class="bg-white rounded-lg shadow p-6 hover:shadow-md transition-shadow">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-semibold text-indigo-700">Top Cities</h2>
                        <span class="text-sm text-gray-500">{{ $cityStats->count() }} cities</span>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-indigo-600 text-white">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">City</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Visits</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Share</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($cityStats->take(10) as $item)
                                @php
                                    $percentage = $totalVisits > 0 ? round(($item->total/$totalVisits)*100, 1) : 0;
                                @endphp
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <i class="fas fa-city text-indigo-500 mr-3"></i>
                                            <span class="text-gray-800">{{ $item->city }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                            {{ number_format($item->total) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                                <div class="bg-indigo-600 h-2.5 rounded-full progress-bar" 
                                                     style="width: {{ $percentage }}%"></div>
                                            </div>
                                            <span class="ml-2 text-sm text-gray-500">{{ $percentage }}%</span>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>








    </div>
</div>

        @endsection