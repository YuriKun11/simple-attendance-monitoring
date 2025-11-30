<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

$username = $_SESSION['user_name']; 

$view = $_GET['view'] ?? 'dashboard'; 

$content_file = '';
$active_link = $view;

switch ($view) {
    case 'bookings':
        $content_file = './dashboard-booking.php';
        break;
    case 'planner':
        $content_file = './dashboard-tourist-spots.php';
        break;
    case 'settings':
        $content_file = './dashboard-settings.php';
        break;
    case 'dashboard':
    default:
        $content_file = './dashboard-content.php';
        $active_link = 'dashboard';
        break;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TouRide Dashboard - Explore La Union</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <!-- Material Icons Link -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <style>
        /* Custom styles to ensure Material Icons look great */
        .material-symbols-outlined {
          font-variation-settings:
          'FILL' 0,
          'wght' 400,
          'GRAD' 0,
          'opsz' 24
        }
    </style>
</head>

<body class="bg-gray-50 flex min-h-screen">
    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden"></div>

    <aside
        id="sidebar"
        class="fixed inset-y-0 left-0 w-64 bg-white shadow-xl z-40 sidebar-transition sidebar-hidden md:translate-x-0 md:relative flex flex-col py-6 px-4"
    >
        <a href="#" class="text-3xl font-extrabold text-blue-600 flex items-center mb-8">
            <img src="../assets/img/touride.png" alt="TouRide Logo" class="w-auto h-8 md:h-10">
        </a>

        <nav class="space-y-2 flex-1 overflow-y-auto">
            <?php
            // Helper function for nav classes
            function getNavClasses($linkName, $active_link) {
                $baseClasses = 'flex items-center py-3 px-4 rounded-xl transition duration-200';
                if ($linkName === $active_link) {
                    return $baseClasses . ' font-semibold text-white bg-blue-600 shadow-lg shadow-blue-200';
                }
                return $baseClasses . ' text-gray-700 hover:bg-blue-50 hover:text-blue-600';
            }
            ?>
            <a href="?view=dashboard" class="<?php echo getNavClasses('dashboard', $active_link); ?>">
                <!-- Icon Replacement: 🏠 -> home -->
                <span class="material-symbols-outlined mr-4 text-xl">home</span> Dashboard
            </a>
            <a href="?view=planner" class="<?php echo getNavClasses('planner', $active_link); ?>">
                <!-- Icon Replacement: 🗺️ -> explore -->
                <span class="material-symbols-outlined mr-4 text-xl">explore</span> Tourist Spots
            </a>
            <a href="?view=bookings" class="<?php echo getNavClasses('bookings', $active_link); ?>">
                <!-- Icon Replacement: 💳 -> book_online -->
                <span class="material-symbols-outlined mr-4 text-xl">book_online</span> My Bookings
            </a>
            <a href="?view=settings" class="<?php echo getNavClasses('settings', $active_link); ?>">
                <!-- Icon Replacement: ⚙️ -> settings -->
                <span class="material-symbols-outlined mr-4 text-xl">settings</span> Settings
            </a>
        </nav>

        <div class="pt-4 border-t">
            <a href="../logout.php" class="flex items-center py-3 px-4 rounded-xl transition duration-200 text-red-600 hover:bg-red-50 font-medium">
                <!-- Icon Replacement: 🚪 -> logout -->
                <span class="material-symbols-outlined mr-4 text-xl">logout</span> Sign Out
            </a>
        </div>
    </aside>

    <div class="flex-1 flex flex-col main-content">
        <header
            class="w-full bg-white sticky top-0 shadow-sm p-4 md:p-6 flex justify-between items-center z-20"
        >
            <button
                id="sidebarToggle"
                class="text-gray-600 focus:outline-none md:hidden p-2 rounded-lg hover:bg-gray-100"
            >
                <svg
                    class="h-6 w-6"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M4 6h16M4 12h16m-7 6h7"
                    />
                </svg>
            </button>

  
            <h1 class="text-xl font-bold text-gray-800 md:text-2xl">
                    Hello, <span class="text-blue-600"><?php echo htmlspecialchars($username); ?></span>!
                <span class="text-gray-500 font-normal hidden sm:inline">Ready to explore?</span>
            </h1>

            
        </header>

        <main class="p-4 md:p-6">
            <?php 
                if (file_exists($content_file)) {
                    include $content_file;
                } else {
                    echo '<p class="text-red-500 font-semibold">Error: Content file not found.</p>';
                }
            ?>
        </main>
        </div>

    <script src="../assets/js/dashboard.js"></script>
</body>
</html>