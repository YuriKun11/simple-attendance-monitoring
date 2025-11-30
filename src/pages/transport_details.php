<?php
$transport_data = [
    'motorcycle' => [
        'name' => 'Motorcycle',
        'icon' => '🏍️',
        'details' => 'Motorcycles (Habal-Habal) are essential for reaching remote areas and are the fastest for short, solo trips, especially in mountainous terrain.',
        'fare_info' => 'Fares start at ₱30 for the first kilometer, plus ₱10 per succeeding kilometer. Always agree on the fare beforehand for long distances.',
        'routes' => 'Commonly found near terminals and markets. Best for trips up the mountain to Tangadan Falls or short town hops along the national highway.',
    ],
    'tricycle' => [
        'name' => 'Tricycle',
        'icon' => '🛵',
        'details' => 'Tricycles are perfect for short city travel and can accommodate 2-3 passengers comfortably, making them ideal for local errands.',
        'fare_info' => 'Standard city fare is ₱15 per person for the first 2 kilometers. Fares should be agreed upon for special routes or charter (pakyaw) trips.',
        'routes' => 'The main mode of transport within San Juan, San Fernando, and Bauang town centers. They follow set municipal routes.',
    ],
    'jeepney' => [
        'name' => 'Jeepney',
        'icon' => '🚎',
        'details' => 'The iconic Filipino public utility vehicle. Jeepneys cover fixed, long-distance routes along the national highway and within major towns.',
        'fare_info' => 'Minimum fare is ₱12.00. Fares are calculated based on distance. Make sure to tap your beep card or pass your payment down the line.',
        'routes' => 'Major routes include San Fernando to Bacnotan, San Fernando to Agoo, and various inner-city routes within San Fernando. Look for route signs on the windshield.',
    ],
    'van' => [
        'name' => 'Van',
        'icon' => '🚐',
        'details' => 'Vans (UV Express) are usually for shared, non-stop, long-distance travel, offering a more comfortable and faster alternative to the bus.',
        'fare_info' => 'Fares are typically fixed per destination (e.g., San Fernando to Vigan is a set price). Tickets must be purchased at the van terminal.',
        'routes' => 'Primary routes connect La Union to other provinces, such as Ilocos Sur (Vigan) and Pangasinan (Dagupan). Terminals are centrally located in San Fernando.',
    ],
    'taxi' => [
        'name' => 'Taxi',
        'icon' => '🚕',
        'details' => 'Comfortable and convenient city rides, usually meter-based. Taxis offer door-to-door service and are a reliable option for tourists.',
        'fare_info' => 'Flag-down rate is ₱40.00, with metered rates applying thereafter. Always ensure the driver resets the meter upon starting the trip.',
        'routes' => 'Generally operate within the San Fernando City and San Juan areas. Best used for late-night travel or when carrying heavy luggage.',
    ],
    'bus' => [
        'name' => 'Bus',
        'icon' => '🚌',
        'details' => 'Buses are the main mode for inter-provincial travel, connecting La Union to Metro Manila and other major cities in Northern Luzon.',
        'fare_info' => 'Fares are distance-based and vary by bus company (Partas, Farinas, Viron, etc.). Pre-booking seats, especially for trips to Manila, is highly recommended.',
        'routes' => 'Major terminals in San Fernando and Agoo handle routes to Manila, Baguio, Vigan, and Abra. Schedules are available on the TouRide terminal map.',
    ],
];

$requested_type = isset($_GET['type']) ? strtolower($_GET['type']) : '';

$type_details = $transport_data[$requested_type] ?? null;

if (!$type_details) {
    header('Location: ../'); 
    exit;
}

$all_types = array_keys($transport_data);

$title = $type_details['name'];
$icon = $type_details['icon'];
$details = $type_details['details'];
$fare_info = $type_details['fare_info'];
$routes = $type_details['routes'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?> Details | TouRide</title>
    <link href="../output.css" rel="stylesheet"> 
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/colors.css">
</head>
<body class="min-h-screen bg-gray-50">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    <?
    include '../component/destinationsNavbar.php';
   ?>

    <div class="bg-white p-8 md:p-12 rounded-2xl shadow-2xl border border-gray-100">
        <p class="mb-4 text-blue-600 font-semibold"><a href="../index.php" class="hover:underline">&larr; Back to Home</a></p>

        <h1 class="text-4xl font-extrabold text-slate-900 mb-2 flex items-center">
            <?php echo $icon; ?> <?php echo $title; ?> Transport Details
        </h1>
        <p class="text-xl text-gray-600 mb-6"><?php echo $details; ?></p>

        <div class="mb-10 p-3 bg-gray-100 rounded-xl overflow-x-auto whitespace-nowrap shadow-inner">
            <h3 class="text-sm font-semibold text-gray-600 mb-2 px-1">Switch Transport Type:</h3>
            <nav class="flex space-x-2">
                <?php foreach ($all_types as $type_slug): 
                    $nav_details = $transport_data[$type_slug];
                    $is_active = $type_slug === $requested_type;
                ?>
                    <a href="?type=<?php echo urlencode($type_slug); ?>"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium <?php echo $is_active ? 'active' : ''; ?>">
                        <?php echo $nav_details['icon']; ?> 
                        <span class="ml-2 capitalize"><?php echo $nav_details['name']; ?></span>
                    </a>
                <?php endforeach; ?>
            </nav>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
            <div>
                <h2 class="text-2xl font-bold text-blue-800 mb-4 flex items-center">
                    💰 Transparent Fare Information
                </h2>
                <div class="bg-blue-50 p-6 rounded-xl border border-blue-200 mr-3">
                    <p class="text-lg text-gray-700 font-medium"><?php echo $fare_info; ?></p>
                    <p class="mt-4 text-sm text-gray-500 italic">
                        All fares are standardized and enforced by the local transport management office.
                    </p>
                </div>
            </div>

            <div>
                <h2 class="text-2xl font-bold text-green-800 mb-4 flex items-center">
                    🗺️ Available Routes & Usage
                </h2>
                <div class="bg-green-50 p-6 rounded-xl border border-green-200 ml-3">
                    <p class="text-lg text-gray-700 font-medium"><?php echo $routes; ?></p>
                    <p class="mt-4 text-sm text-gray-500 italic">
                        Use the "Find a Ride" search bar on the home page to calculate exact fares to your destination.
                    </p>
                </div>
            </div>
        </div>
        
        <div class="mt-10 pt-8 border-t border-gray-100 text-center">
            <a href="./live-terminals.php" class="btn-color inline-block px-8 py-3 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 transition duration-300 shadow-lg">
                View All <?php echo $title; ?> Terminal Spots &rarr;
            </a>
        </div>
    </div>
</div>

   <?
    include '../component/pagefooter.php';
   ?>
</body>
</html>