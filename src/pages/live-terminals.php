<?php
// Terminal definitions
$terminals = [
    'partas' => [
        'name' => 'Partas Bus Terminal',
        'location' => 'San Fernando City, La Union',
        'map_query' => 'Partas Bus Terminal, San Fernando, La Union',
    ],
    'viron' => [
        'name' => 'Viron Transit Terminal',
        'location' => 'San Fernando City, La Union',
        'map_query' => 'Viron Transit Terminal, San Fernando, La Union',
    ],
    'dominion' => [
        'name' => 'Dominion Bus Terminal',
        'location' => 'San Fernando City, La Union',
        'map_query' => 'Dominion Bus Terminal, San Fernando, La Union',
    ],
    'san_juan_hub' => [
        'name' => 'San Juan Transport Hub (Jeepney/Tricycle)',
        'location' => 'San Juan, La Union (near surfing area)',
        'map_query' => 'San Juan, La Union Surf Town',
    ],
    'agoo_terminal' => [
        'name' => 'Agoo Bus Terminal (South Hub)',
        'location' => 'Agoo, La Union',
        'map_query' => 'Agoo, La Union Bus Terminal',
    ],
];

$selected_key = $_GET['terminal'] ?? 'partas';

if ($selected_key === 'all') {
    // All terminals
    $all_locations = array_map(fn($t) => $t['map_query'], $terminals);
    $map_embed_url = "https://maps.google.com/maps?q=" . urlencode(implode('|', $all_locations)) . "&t=&z=10&ie=UTF8&iwloc=&output=embed";
    $current_name = 'All Terminals';
    $current_location = 'La Union';
} else {
    $current_terminal = $terminals[$selected_key] ?? reset($terminals);
    $map_embed_url = "https://maps.google.com/maps?q=" . urlencode($current_terminal['map_query']) . "&t=&z=14&ie=UTF8&iwloc=&output=embed";
    $current_name = $current_terminal['name'];
    $current_location = $current_terminal['location'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TouRide - Live Terminals Map</title>
    <link href="../output.css" rel="stylesheet"> 
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="min-h-screen bg-gray-50">

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    <?php include '../component/destinationsNavbar.php'; ?>

    <main class="mt-12 mb-16">

        <section id="live-terminals-map" class="py-10">
            <h1 class="text-4xl font-extrabold text-center text-slate-900 mb-4">Live Terminals Map</h1>
            <p class="text-xl text-center text-gray-600 mb-12 max-w-4xl mx-auto">
                <span class="font-bold text-blue-600">Currently Viewing:</span> 
                <?php echo $current_name; ?> in <?php echo $current_location; ?>
            </p>

            <div>
      
            <!-- Terminal selection form -->
            <div class="mb-10 p-5 bg-white rounded-lg shadow-md custom-mx">
                <form method="GET" action="live-terminals.php" class="flex flex-col sm:flex-row gap-4 items-center justify-center">
                    <label for="terminal_select" class="text-lg font-semibold text-slate-900">Select a Terminal:</label>
                    <select name="terminal" id="terminal_select" class="p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 w-full sm:w-auto">
                        <option value="all" <?php echo ($selected_key === 'all') ? 'selected' : ''; ?>>All Terminals</option>
                        <?php foreach ($terminals as $key => $terminal): ?>
                            <option value="<?php echo $key; ?>" <?php echo ($selected_key === $key) ? 'selected' : ''; ?>>
                                <?php echo $terminal['name']; ?> (<?php echo $terminal['location']; ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" class="btn-color px-6 py-3 font-bold rounded-lg transition duration-300 shadow hover:bg-blue-700 w-full sm:w-auto">
                        View Map
                    </button>
                </form>
            </div>

            <!-- Google Map iframe -->
            <div class="w-full h-[600px] rounded-xl shadow-2xl border-4 border-blue-600 overflow-hidden mt-4">
                <iframe
                    src="<?php echo $map_embed_url; ?>"
                    width="100%"
                    height="500"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
            
        </section>

        <!-- Back button -->
        <div class="text-center mt-12">
            <a href="../index.php" class="px-8 py-3 border border-blue-600 text-blue-600 font-semibold rounded-lg hover:bg-blue-600 hover:text-white transition duration-300">
                ← Back to Homepage
            </a>
        </div>

    </main>
</div>

<?php include '../component/pagefooter.php'; ?>
<script src="../assets/js/app.js"></script>
</body>
</html>
