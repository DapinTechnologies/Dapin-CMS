<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visitor Statistics Dashboard</title>
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
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin-right: 12px;
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
                <?php
                    $totalVisits = $deviceStats->sum('total');
                    $mobileVisits = $deviceStats->where('device_type', 'mobile')->first()->total ?? 0;
                    $desktopVisits = $deviceStats->where('device_type', 'desktop')->first()->total ?? 0;
                    $topCountry = $countryStats->first();
                    $topPage = $pageStats->first() ?? null;
                ?>
                
                <!-- Total Visits Card -->
                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500 hover:shadow-md transition-shadow">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-gray-500 text-sm font-medium">Total Visits</h3>
                            <p class="text-2xl font-bold mt-1 text-gray-800"><?php echo e(number_format($totalVisits)); ?></p>
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
                            <p class="text-2xl font-bold mt-1 text-gray-800"><?php echo e(number_format($mobileVisits)); ?></p>
                            <div class="flex items-center mt-2">
                                <span class="text-sm text-gray-500">
                                    <?php echo e($totalVisits > 0 ? round(($mobileVisits/$totalVisits)*100) : 0); ?>% of total
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
                            <p class="text-lg font-bold mt-1 text-gray-800 truncate" title="<?php echo e($topPage->page_visited ?? 'N/A'); ?>">
                                <?php echo e($topPage->page_visited ?? 'N/A'); ?>

                            </p>
                            <div class="flex items-center mt-2">
                                <span class="text-sm text-gray-500">
                                    <?php echo e($topPage->total ?? 0); ?> views
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
                            <p class="text-2xl font-bold mt-1 text-gray-800"><?php echo e($topCountry->country ?? 'N/A'); ?></p>
                            <div class="flex items-center mt-2">
                                <span class="text-sm text-gray-500">
                                    <?php echo e($topCountry->total ?? 0); ?> visits
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
            <?php if($pageStats->count() > 0): ?>
            <div class="bg-white rounded-lg shadow p-6 mb-8 hover:shadow-md transition-shadow">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-semibold text-indigo-700">Most Visited Pages</h2>
                    <span class="text-sm text-gray-500"><?php echo e($pageStats->count()); ?> pages tracked</span>
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
                            <?php $__currentLoopData = $pageStats->take(10); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $trafficLevel = $item->total > ($totalVisits * 0.2) ? 'high' : 
                                              ($item->total > ($totalVisits * 0.1) ? 'medium' : 'low');
                                $path = parse_url($item->page_visited, PHP_URL_PATH);
                                $path = $path ?: $item->page_visited;
                                $percentage = $totalVisits > 0 ? round(($item->total/$totalVisits)*100, 1) : 0;
                            ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-indigo-100 rounded-full flex items-center justify-center">
                                            <i class="fas fa-file-alt text-indigo-500"></i>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                <span class="page-url" title="<?php echo e($item->page_visited); ?>"><?php echo e($path); ?></span>
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                <?php echo e(Str::limit($item->page_visited, 50)); ?>

                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                        <?php echo e(number_format($item->total)); ?>

                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="traffic-light <?php echo e($trafficLevel); ?>"></span>
                                    <span class="text-sm text-gray-500 capitalize"><?php echo e($trafficLevel); ?> traffic</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                                            <div class="bg-indigo-600 h-2.5 rounded-full progress-bar" 
                                                 style="width: <?php echo e($percentage); ?>%"></div>
                                        </div>
                                        <span class="ml-2 text-sm text-gray-500"><?php echo e($percentage); ?>%</span>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endif; ?>

            <!-- Devices Section -->
            <div class="bg-white rounded-lg shadow p-6 mb-8 hover:shadow-md transition-shadow">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-semibold text-indigo-700">Device Analytics</h2>
                    <span class="text-sm text-gray-500"><?php echo e($deviceStats->count()); ?> device types</span>
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
                                <?php $__currentLoopData = $deviceStats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $percentage = $totalVisits > 0 ? round(($item->total/$totalVisits)*100) : 0;
                                ?>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <?php if($item->device_type == 'mobile'): ?>
                                                <div class="device-icon bg-blue-100 text-blue-500">
                                                    <i class="fas fa-mobile-alt"></i>
                                                </div>
                                            <?php elseif($item->device_type == 'desktop'): ?>
                                                <div class="device-icon bg-purple-100 text-purple-500">
                                                    <i class="fas fa-desktop"></i>
                                                </div>
                                            <?php elseif($item->device_type == 'tablet'): ?>
                                                <div class="device-icon bg-green-100 text-green-500">
                                                    <i class="fas fa-tablet-alt"></i>
                                                </div>
                                            <?php else: ?>
                                                <div class="device-icon bg-gray-100 text-gray-500">
                                                    <i class="fas fa-question"></i>
                                                </div>
                                            <?php endif; ?>
                                            <span class="capitalize text-gray-800"><?php echo e($item->device_type); ?></span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                            <?php echo e(number_format($item->total)); ?>

                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                                <div class="h-2.5 rounded-full progress-bar
                                                    <?php if($item->device_type == 'mobile'): ?> bg-blue-500
                                                    <?php elseif($item->device_type == 'desktop'): ?> bg-purple-500
                                                    <?php elseif($item->device_type == 'tablet'): ?> bg-green-500
                                                    <?php else: ?> bg-gray-500 <?php endif; ?>" 
                                                    style="width: <?php echo e($percentage); ?>%"></div>
                                            </div>
                                            <span class="ml-2 text-sm text-gray-500"><?php echo e($percentage); ?>%</span>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Device Breakdown Chart -->
                    <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                        <h3 class="text-lg font-medium text-gray-800 mb-4">Device Distribution</h3>
                        <div class="flex flex-col space-y-4">
                            <?php $__currentLoopData = $deviceStats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $percentage = $totalVisits > 0 ? round(($item->total/$totalVisits)*100) : 0;
                            ?>
                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-700 capitalize">
                                        <i class="fas 
                                            <?php if($item->device_type == 'mobile'): ?> fa-mobile-alt text-blue-500
                                            <?php elseif($item->device_type == 'desktop'): ?> fa-desktop text-purple-500
                                            <?php elseif($item->device_type == 'tablet'): ?> fa-tablet-alt text-green-500
                                            <?php else: ?> fa-question text-gray-500 <?php endif; ?>
                                            mr-2"></i>
                                        <?php echo e($item->device_type); ?>

                                    </span>
                                    <span class="text-sm font-medium text-gray-700"><?php echo e($percentage); ?>%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="h-2.5 rounded-full progress-bar
                                        <?php if($item->device_type == 'mobile'): ?> bg-blue-500
                                        <?php elseif($item->device_type == 'desktop'): ?> bg-purple-500
                                        <?php elseif($item->device_type == 'tablet'): ?> bg-green-500
                                        <?php else: ?> bg-gray-500 <?php endif; ?>" 
                                        style="width: <?php echo e($percentage); ?>%"></div>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                        <span class="text-sm text-gray-500"><?php echo e($countryStats->count()); ?> countries</span>
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
                                <?php $__currentLoopData = $countryStats->take(10); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $percentage = $totalVisits > 0 ? round(($item->total/$totalVisits)*100, 1) : 0;
                                ?>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <i class="fas fa-globe-americas text-indigo-500 mr-3"></i>
                                            <span class="text-gray-800"><?php echo e($item->country); ?></span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                            <?php echo e(number_format($item->total)); ?>

                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                                <div class="bg-indigo-600 h-2.5 rounded-full progress-bar" 
                                                     style="width: <?php echo e($percentage); ?>%"></div>
                                            </div>
                                            <span class="ml-2 text-sm text-gray-500"><?php echo e($percentage); ?>%</span>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Cities Table -->
                <div class="bg-white rounded-lg shadow p-6 hover:shadow-md transition-shadow">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-semibold text-indigo-700">Top Cities</h2>
                        <span class="text-sm text-gray-500"><?php echo e($cityStats->count()); ?> cities</span>
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
                                <?php $__currentLoopData = $cityStats->take(10); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $percentage = $totalVisits > 0 ? round(($item->total/$totalVisits)*100, 1) : 0;
                                ?>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <i class="fas fa-city text-indigo-500 mr-3"></i>
                                            <span class="text-gray-800"><?php echo e($item->city); ?></span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                            <?php echo e(number_format($item->total)); ?>

                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                                <div class="bg-indigo-600 h-2.5 rounded-full progress-bar" 
                                                     style="width: <?php echo e($percentage); ?>%"></div>
                                            </div>
                                            <span class="ml-2 text-sm text-gray-500"><?php echo e($percentage); ?>%</span>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white shadow text-center p-4 text-gray-600 text-sm">
            &copy; <?php echo e(date('Y')); ?> Visitor Analytics Dashboard. All rights reserved.
        </footer>
    </div>
</body>
</html><?php /**PATH C:\Users\User\Desktop\cms\Dapin-CMS\resources\views/visits/stats.blade.php ENDPATH**/ ?>