<?php
include '../db_connect.php';

$current_user_id = $_SESSION['user_id'] ?? null; 
if (!$current_user_id) {
    header('Location: ../login.php');
    exit();
}

$allSpots = [
    [
        'name' => 'Urbiztondo Beach',
        'location' => 'San Juan, La Union',
        'activity' => 'Surfing, Beach relaxation, Food trip',
        'entrance' => 'Free (Beach Access)',
        'budget' => '₱500 - ₱1500+',
        'details' => 'The surfing capital of the North. Perfect for beginners. Budget mainly covers surfboard rentals (₱400-₱500/hr) and food/drinks.',
        'icon' => '🏄',
        'image_url' => '../assets/img/attractions/urbiztondo.jpg' ,
        'spot_id' => 1
    ],
    [
        'name' => 'Tangadan Falls',
        'location' => 'San Gabriel, La Union',
        'activity' => 'Trekking, Swimming, Cliff Jumping',
        'entrance' => '₱30 (Environmental Fee)',
        'budget' => '₱600 - ₱1200',
        'details' => 'A mandatory guide (approx. ₱500-₱700 per group) is required. Budget includes the guide fee and transportation to the jump-off point.',
        'icon' => '🏞️',
        'image_url' => '../assets/img/attractions/falls.jpg' ,
        'spot_id' => 2
    ],
    [
        'name' => 'Ma-Cho Temple',
        'location' => 'San Fernando, La Union',
        'activity' => 'Sightseeing, Architecture, Reflection',
        'entrance' => 'Free',
        'budget' => '₱50 - ₱200',
        'details' => 'A beautiful, large Taoist temple. Offers panoramic views of the city and sea. Budget is generally for transportation only.',
        'icon' => '🏯',
        'image_url' => '../assets/img/attractions/temple.jpg' ,
        'spot_id' => 3
    ],
    [
        'name' => 'Saint William the Hermit Cathedral',
        'location' => 'San Fernando, La Union',
        'activity' => 'Historical Visit, Worship',
        'entrance' => 'Free',
        'budget' => '₱50 - ₱100',
        'details' => 'The historical seat of the Roman Catholic Diocese of San Fernando. Visit to appreciate the religious architecture and history.',
        'icon' => '⛪',
        'image_url' => '../assets/img/attractions/church.jpg',
        'spot_id' => 4
    ],
    [
        'name' => 'Pindangan Ruins',
        'location' => 'San Fernando, La Union',
        'activity' => 'Historical Sightseeing, Photography',
        'entrance' => 'Donation (Approx. ₱20 - ₱50)',
        'budget' => '₱100 - ₱300',
        'details' => 'Remnants of the first Catholic church (1764) in San Fernando. Maintained by the Carmelite Sisters. Serene and great for historical photos.',
        'icon' => '🧱',
        'image_url' => '../assets/img/attractions/ruins.jpg' ,
        'spot_id' => 5
    ],
    [
        'name' => 'Pagoda Hill',
        'location' => 'San Fernando, La Union',
        'activity' => 'Scenic Viewpoint, Sunset/Sunrise Viewing',
        'entrance' => 'Free',
        'budget' => '₱50 - ₱150',
        'details' => 'Also known as the Filipino-Chinese Friendship Park Pagoda. Offers a high, panoramic view of the city and harbor, popular for sunsets.',
        'icon' => '🌄',
        'image_url' => '../assets/img/attractions/pagoda.jpg',
        'spot_id' => 6
    ],
    [
        'name' => 'Poro Point Lighthouse',
        'location' => 'Poro Point, San Fernando, La Union',
        'activity' => 'Sightseeing, Sunset Viewing',
        'entrance' => 'Free',
        'budget' => '₱50 - ₱200',
        'details' => 'A historic 27-ft high lighthouse built in 1905. Offers a beautiful sea view, but access may sometimes be restricted as it is inside a freeport zone.',
        'icon' => '燈',
        'image_url' => '../assets/img/attractions/lighthouse.jpg' ,
        'spot_id' => 7
    ],
    [
        'name' => 'Grape Farms',
        'location' => 'Bauang, La Union',
        'activity' => 'Grape Picking, Wine Tasting, Farm Tour',
        'entrance' => '₱25 (Registration Fee)',
        'budget' => '₱400 - ₱800',
        'details' => 'Popular farms include Gapuz and Lomboy. The grape picking activity itself is typically ₱350/kilo. Peak season is generally March to May (dry season).',
        'icon' => '🍇',
        'image_url' => '../assets/img/attractions/grape.jpg' ,
        'spot_id' => 8
    ],
    [
        'name' => 'Baluarte Watch Tower',
        'location' => 'Luna, La Union',
        'activity' => 'Historical Sightseeing, Photography, Pebble Beach',
        'entrance' => 'Free (Donation suggested)',
        'budget' => '₱100 - ₱300',
        'details' => 'A Spanish-era watchtower that has survived numerous disasters. Located near the famous Pebble Beach of Luna.',
        'icon' => '🗿',
        'image_url' => '../assets/img/attractions/tower.jpg' ,
        'spot_id' => 9
    ],
    [
        'name' => 'Immuki Island',
        'location' => 'Paraoir, Balaoan, La Union',
        'activity' => 'Swimming, Snorkeling, Exploring Lagoons',
        'entrance' => '₱20 (Environmental Fee)',
        'budget' => '₱300 - ₱600',
        'details' => 'A set of three crystal-clear saltwater lagoons near the shore. Best for a refreshing swim and a unique natural experience.',
        'icon' => '🏝️',
        'image_url' => '../assets/img/attractions/immuki.jpg' ,
        'spot_id' => 10
    ]
];

$default_limit = 4;
$total_spots = count($allSpots);

$favorite_spots = [];
if ($current_user_id && isset($conn)) {
    $sql = "SELECT spot_id FROM user_favorites WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $current_user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($result)) {
        $favorite_spots[] = $row['spot_id'];
    }
    mysqli_stmt_close($stmt);
}

if (isset($conn)) {
    mysqli_close($conn);
}
?>
    <style>
        
        #tooltip {
            position: absolute;
            background: rgba(0,0,0,0.8);
            color: #fff;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            pointer-events: none;
            display: none;
            white-space: nowrap;
            z-index: 100;
        }

        svg {
            height: auto;
            display: block;
            margin: 0 auto;
            background-color: #e0f2f1;
        }

        .hover-group path {
            fill: #f4c0c7; 
            stroke: #000;
            stroke-width: 0.4;
            cursor: pointer;
            transition: fill 0.2s;
        }

        .hover-group path:hover,
        .hover-group text:hover {
            fill: #ff6b81; 
        }

        .hover-group text {
            font-family: 'Tahoma';
            font-size: 12px;
            pointer-events: all;
            cursor: pointer;
            fill: #000;
        }
        
        .hidden-spot {
            display: none;
        }

        .favorite-btn {
            cursor: pointer;
            transition: color 0.2s;
        }

        .is-favorite {
            color: #ef4444; 
        }

        .not-favorite {
            color: #9ca3af; 
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }
        svg{
            background-color: transparent !important;
        }

    </style>

<main class="p-6 md:p-10 flex-1">

    <div class="bg-gradient-to-r from-blue-600 to-cyan-500 p-8 md:p-12 rounded-2xl shadow-xl text-white mb-10">
        <h2 class="text-3xl md:text-4xl font-extrabold mb-2">
            🧭 Essential La Union Tourist Spots
        </h2>
        <p class="text-blue-100 max-w-2xl">
            Explore the best of San Juan, San Fernando, and the wider province, covering famous beaches, waterfalls, and historical sites.
        </p>
    </div>

    <section class="bg-white p-6 rounded-2xl shadow-xl">
        
        <div class="flex border-b border-gray-200 mb-6">
            <button 
                id="tab-all-btn"
                onclick="switchTab('all')" 
                class="tab-btn px-4 py-2 text-lg font-semibold text-blue-600 border-b-2 border-blue-600 transition duration-150 focus:outline-none"
            >
                📍 All Attractions
            </button>
            <button 
                id="tab-favorites-btn"
                onclick="switchTab('favorites')" 
                class="tab-btn px-4 py-2 text-lg font-medium text-gray-500 hover:text-blue-600 transition duration-150 focus:outline-none"
            >
                ❤️ My Favorites 
                <span id="fav-count-display" class="ml-1 text-sm bg-red-100 text-red-600 px-2 py-0.5 rounded-full font-bold">
                    <?php echo count($favorite_spots); ?>
                </span>
            </button>
            <button 
                id="tab-map-btn"
                onclick="switchTab('map')" 
                class="tab-btn px-4 py-2 text-lg font-medium text-gray-500 hover:text-blue-600 transition duration-150 focus:outline-none"
            >
                🗺️ View Map
            </button>
        </div>

        <div id="tab-all" class="tab-content active">
            <h3 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-3">Featured Attractions & Estimated Costs</h3>
            
            <div id="spots-container-all" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                
                <?php $i = 0; foreach ($allSpots as $index => $spot): 
                    $hidden_class = ($i >= $default_limit) ? 'hidden-spot' : ''; 
                    $map_query = urlencode($spot['name'] . ', ' . $spot['location']);
                    $map_link = 'https://www.google.com/maps/search/?api=1&query=' . $map_query;
                    $spot_id = $spot['spot_id'];
                    $is_fav = in_array($spot_id, $favorite_spots);
                    $fav_class = $is_fav ? 'is-favorite' : 'not-favorite';
                ?>
                    <div class="spot-card border border-gray-100 rounded-xl overflow-hidden shadow-md hover:shadow-lg transition duration-300 flex flex-col <?php echo $hidden_class; ?>" data-spot-id="<?php echo $spot_id; ?>">
                        
                        <div class="h-40 overflow-hidden bg-gray-200 relative">
                            <img 
                                src="<?php echo htmlspecialchars($spot['image_url']); ?>" 
                                alt="Image of <?php echo htmlspecialchars($spot['name']); ?>" 
                                class="h-full w-full object-cover" 
                                loading="lazy"
                            />
                            <button 
                                class="favorite-btn absolute top-3 right-3 text-2xl p-2 rounded-full bg-white/70 hover:bg-white transition"
                                data-spot-id="<?php echo $spot_id; ?>"
                                data-is-fav="<?php echo $is_fav ? 'true' : 'false'; ?>"
                            >
                                <span class="<?php echo $fav_class; ?>" id="fav-icon-<?php echo $spot_id; ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                    </svg>
                                </span>
                            </button>
                        </div>

                        <div class="p-5 flex flex-col justify-between flex-grow">
                            <div>
                                <span class="text-3xl mb-1 block"><?php echo htmlspecialchars($spot['icon']); ?></span> 
                                <h4 class="text-xl font-bold text-gray-900 mb-1"><?php echo htmlspecialchars($spot['name']); ?></h4>
                                <p class="text-sm text-blue-600 font-medium mb-3"><?php echo htmlspecialchars($spot['location']); ?></p>

                                <ul class="space-y-2 text-sm mb-4">
                                    <li class="flex items-start">
                                        <span class="text-gray-500 w-5 mr-2">🎯</span>
                                        <p class="flex-1"><strong>Activity:</strong> <span class="text-gray-700"><?php echo htmlspecialchars($spot['activity']); ?></span></p>
                                    </li>
                                    <li class="flex items-start">
                                        <span class="text-gray-500 w-5 mr-2">💸</span>
                                        <p class="flex-1"><strong>Entrance Fee:</strong> <span class="font-semibold text-green-700"><?php echo htmlspecialchars($spot['entrance']); ?></span></p>
                                    </li>
                                    <li class="flex items-start">
                                        <span class="text-gray-500 w-5 mr-2">💰</span>
                                        <p class="flex-1"><strong>Est. Day Budget:</strong> <span class="font-semibold text-blue-700"><?php echo htmlspecialchars($spot['budget']); ?></span></p>
                                    </li>
                                </ul>
                            </div>
                            
                            <blockquote class="mt-auto pt-4 text-xs italic text-gray-500 border-l-4 border-blue-300 pl-3 mb-4">
                                <p><?php echo htmlspecialchars($spot['details']); ?></p>
                            </blockquote>

                            <a 
                                href="<?php echo $map_link; ?>" 
                                target="_blank" 
                                class="mt-4 inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-500 hover:bg-green-600 transition duration-150"
                            >
                                View Map
                            </a>
                        </div>
                    </div>
                <?php $i++; endforeach; ?>

            </div>
            
            <?php if ($total_spots > $default_limit): ?>
                <div id="see-more-container" class="mt-8 text-center">
                    <button 
                        id="see-more-btn"
                        onclick="toggleSpots()" 
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-8 rounded-full shadow-lg transition duration-300 transform hover:scale-105"
                    >
                        Show <?php echo $total_spots - $default_limit; ?> More Attractions
                    </button>
                </div>
            <?php endif; ?>

        </div>
        
        <div id="tab-favorites" class="tab-content">
            <h3 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-3">My Saved Attractions</h3>
            
            <div id="spots-container-favorites" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                
                <?php 
                $favorite_count = 0;
                foreach ($allSpots as $spot): 
                    if (in_array($spot['spot_id'], $favorite_spots)):
                        $favorite_count++;
                        $map_query = urlencode($spot['name'] . ', ' . $spot['location']);
                        $map_link = 'https://www.google.com/maps/search/?api=1&query=' . $map_query;
                        $spot_id = $spot['spot_id'];
                ?>
                        <div class="spot-card border border-gray-100 rounded-xl overflow-hidden shadow-md hover:shadow-lg transition duration-300 flex flex-col is-favorite-spot" data-spot-id="<?php echo $spot_id; ?>">
                            
                            <div class="h-40 overflow-hidden bg-gray-200 relative">
                                <img 
                                    src="<?php echo htmlspecialchars($spot['image_url']); ?>" 
                                    alt="Image of <?php htmlspecialchars($spot['name']); ?>" 
                                    class="h-full w-full object-cover" 
                                    loading="lazy"
                                />
                                <button 
                                    class="favorite-btn absolute top-3 right-3 text-2xl p-2 rounded-full bg-white/70 hover:bg-white transition"
                                    data-spot-id="<?php echo $spot_id; ?>"
                                    data-is-fav="true"
                                >
                                    <span class="is-favorite" id="fav-icon-<?php echo $spot_id; ?>-fav-tab">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                        </svg>
                                    </span>
                                </button>
                            </div>

                            <div class="p-5 flex flex-col justify-between flex-grow">
                                <div>
                                    <span class="text-3xl mb-1 block"><?php echo htmlspecialchars($spot['icon']); ?></span> 
                                    <h4 class="text-xl font-bold text-gray-900 mb-1"><?php echo htmlspecialchars($spot['name']); ?></h4>
                                    <p class="text-sm text-blue-600 font-medium mb-3"><?php echo htmlspecialchars($spot['location']); ?></p>

                                    <ul class="space-y-2 text-sm mb-4">
                                        <li class="flex items-start">
                                            <span class="text-gray-500 w-5 mr-2">🎯</span>
                                            <p class="flex-1"><strong>Activity:</strong> <span class="text-gray-700"><?php echo htmlspecialchars($spot['activity']); ?></span></p>
                                        </li>
                                        <li class="flex items-start">
                                            <span class="text-gray-500 w-5 mr-2">💸</span>
                                            <p class="flex-1"><strong>Entrance Fee:</strong> <span class="font-semibold text-green-700"><?php echo htmlspecialchars($spot['entrance']); ?></span></p>
                                        </li>
                                        <li class="flex items-start">
                                            <span class="text-gray-500 w-5 mr-2">💰</span>
                                            <p class="flex-1"><strong>Est. Day Budget:</strong> <span class="font-semibold text-blue-700"><?php echo htmlspecialchars($spot['budget']); ?></span></p>
                                        </li>
                                    </ul>
                                </div>
                                
                                <blockquote class="mt-auto pt-4 text-xs italic text-gray-500 border-l-4 border-blue-300 pl-3 mb-4">
                                    <p><?php echo htmlspecialchars($spot['details']); ?></p>
                                </blockquote>

                                <a 
                                    href="<?php echo $map_link; ?>" 
                                    target="_blank" 
                                    class="mt-4 inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-500 hover:bg-green-600 transition duration-150"
                                >
                                    View Map
                                </a>
                            </div>
                        </div>
                <?php 
                    endif; 
                endforeach; 
                if ($favorite_count === 0):
                ?>
                    <div class="md:col-span-4 text-center py-10 text-gray-500">
                        <p class="text-3xl mb-3">💔</p>
                        <p class="text-lg font-semibold">You haven't added any favorite spots yet.</p>
                        <p>Go back to All Attractions and click the heart icon to save places!</p>
                    </div>
                <?php endif; ?>
            </div>

        </div>

        <div id="tab-map" class="tab-content">
            <h3 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-3">La Union Interactive Map</h3>
            <div class="p-4 border border-gray-100 rounded-lg">
                <?php
                    include 'dashboard-map.php';
                ?>
            </div>
        </div>

    </section>

    <script>
        function toggleSpots() {
            const hiddenSpots = document.querySelectorAll('#tab-all .hidden-spot');
            const buttonContainer = document.getElementById('see-more-container');
            
            hiddenSpots.forEach(spot => {
                spot.classList.remove('hidden-spot');
            });
            
            if (buttonContainer) {
                buttonContainer.style.display = 'none'; 
            }
        }
        
        function switchTab(tabId) {
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });

            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('text-blue-600', 'border-blue-600');
                btn.classList.add('text-gray-500', 'hover:text-blue-600');
                btn.classList.remove('font-semibold', 'border-b-2');
                btn.classList.add('font-medium');
            });

            document.getElementById(`tab-${tabId}`).classList.add('active');

            const selectedBtn = document.getElementById(`tab-${tabId}-btn`);
            selectedBtn.classList.add('text-blue-600', 'border-blue-600', 'border-b-2', 'font-semibold');
            selectedBtn.classList.remove('text-gray-500', 'hover:text-blue-600', 'font-medium');

             if (tabId === 'favorites') {
                updateFavoriteTabDisplay();
            }
            
            if (tabId === 'map') {
                console.log('Map tab opened. If using an interactive map, ensure it is initialized/resized here.');
            }
        }
        
        function handleFavoriteClick(button) {
            const spotId = button.dataset.spotId;
            let isFav = button.dataset.isFav === 'true';
            const action = isFav ? 'remove' : 'add';

            fetch('process_favorite.php', { 
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `spot_id=${spotId}&action=${action}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    isFav = !isFav;
                    
                    document.querySelectorAll(`.favorite-btn[data-spot-id="${spotId}"]`).forEach(btn => {
                        btn.dataset.isFav = isFav ? 'true' : 'false';
                        const iconSpan = btn.querySelector('span');
                        
                        if (isFav) {
                            iconSpan.classList.remove('not-favorite');
                            iconSpan.classList.add('is-favorite');
                        } else {
                            iconSpan.classList.remove('is-favorite');
                            iconSpan.classList.add('not-favorite');
                        }
                    });

                    updateFavoriteTabDisplay();

                } else {
                    alert(data.message || 'An error occurred.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to communicate with the server.');
            });
        }

        function updateFavoriteTabDisplay() {
            const allSpotCards = document.querySelectorAll('#spots-container-all .spot-card');
            const favContainer = document.getElementById('spots-container-favorites');
            const favCountDisplay = document.getElementById('fav-count-display');
            let favoriteCount = 0;

            favContainer.innerHTML = '';
            
            allSpotCards.forEach(card => {
                const button = card.querySelector('.favorite-btn');
                const isFavorite = button.dataset.isFav === 'true';

                if (isFavorite) {
                    const clonedCard = card.cloneNode(true);
                    clonedCard.classList.remove('hidden-spot');
                    
                    const clonedButton = clonedCard.querySelector('.favorite-btn');
                    clonedButton.removeEventListener('click', handleFavoriteClick);
                    clonedButton.addEventListener('click', function() { handleFavoriteClick(this); });
                    
                    favContainer.appendChild(clonedCard);
                    favoriteCount++;
                }
            });

            if (favoriteCount === 0) {
                favContainer.innerHTML = `
                    <div class="md:col-span-4 text-center py-10 text-gray-500 w-full">
                        <p class="text-3xl mb-3">💔</p>
                        <p class="text-lg font-semibold">You haven't added any favorite spots yet.</p>
                        <p>Go back to All Attractions and click the heart icon to save places!</p>
                    </div>
                `;
            }

            favCountDisplay.textContent = favoriteCount;
        }


        document.querySelectorAll('.favorite-btn').forEach(button => {
            button.addEventListener('click', function() { handleFavoriteClick(this); });
        });
        
        document.addEventListener('DOMContentLoaded', () => {
             updateFavoriteTabDisplay(); 
             switchTab('all');
        });


        
    </script>


</main>