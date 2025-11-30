
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TouRide</title>
    <link href="./output.css" rel="stylesheet"> 
    <link rel="stylesheet" href="./assets/css/style.css">
    </head>
<body class="min-h-screen">

<?php
$transport_types = [
    [ 'name' => 'Motorcycle', 'description' => 'Quick solo rides for short distances.', 'icon' => '🏍️' ],
    [ 'name' => 'Tricycle', 'description' => 'Ideal for short city or provincial trips.', 'icon' => '🛵'],
    [ 'name' => 'Jeepney', 'description' => 'The classic Filipino public transport.', 'icon' => '🚎'],
    [ 'name' => 'Van', 'description' => 'Shared or long-distance group travel.', 'icon' => '🚐'],
    [ 'name' => 'Taxi', 'description' => 'Comfortable and convenient city rides.', 'icon' => '🚕'],
    [ 'name' => 'Bus', 'description' => 'Pre-book seats with digital payments.', 'icon' => '🚌'],
];

$features = [
    [
        'title' => 'Transparent Fares',
        'description' => 'See the exact fare before you ride. No surprises, guaranteed.',
        'icon_svg' => '<svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m4 0h6m-6 0v2m0-2h6m-6 0H9m-6 0h2m-4 0v-4m0-4v-4m0 4h2m-2 0H5"></path></svg>'
    ],
    [
       'title' => 'Travel Prep',
        'description' => 'Plan your journey ahead with preloaded route and terminal info.',
        'icon_svg' => '<svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>'
    ],
    [
        'title' => 'Real-Time Schedules',
        'description' => 'Know exactly when your next jeepney or bus is leaving the terminal.',
        'icon_svg' => '<svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'
    ],
    [
        'title' => 'Local Tourism Hub',
        'description' => 'Discover the best of La Union, from hidden gems to popular spots.',
        'icon_svg' => '<svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>'
    ],
];

$attractions = [
    [ 'name' => 'Urbiztondo Beach', 'tag' => 'Surfing & Sunsets', 'image' => './assets/img/attractions/urbiztondo.jpg', ],
    [ 'name' => 'Tangadan Falls', 'tag' => 'Adventure Trekking', 'image' => './assets/img/attractions/falls.jpg', ],
    [ 'name' => 'Ma-Cho Temple', 'tag' => 'Cultural Landmark', 'image' => './assets/img/attractions/temple.jpg', ],
];

$terminal_steps = [
    [ 'icon' => '📍', 'title' => 'Locate Terminals', 'description' => 'Use our GPS mapping to find the nearest bus, van, or jeepney terminal in La Union.' ],
    [ 'icon' => '⏰', 'title' => 'View Schedules', 'description' => 'Check departure times and route information to minimize your wait time.' ],
    [ 'icon' => '💡', 'title' => 'Transparent Info', 'description' => 'See standardized fares and operator details instantly, eliminating confusion.' ],
    [ 'icon' => '📶', 'title' => 'Travel Prep', 'description' => 'Plan your journey ahead with preloaded route and terminal info for smooth travel.' ]
];
?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

   <?
    include './component/navbar.php';
   ?>
    
  <main class="mt-8 mb-16">
      <div id="hero-slider" class="w-full h-72 md:h-96 rounded-xl overflow-hidden shadow-xl relative transition-all duration-1000 ease-in-out">
          <img id="slider-img"
              src="./assets/img/slider1.png"
              alt="Scenic view of a landmark, representing travel"
              class="w-full h-full object-cover opacity-80 transition-opacity duration-1000 ease-in-out">
          <div class="absolute inset-0 flex items-center justify-center p-4 backdrop-brightness-50 rounded-xl">
              <h1 class="text-4xl sm:text-5xl lg:text-7xl font-extrabold text-white text-center tracking-tight leading-tight">
                  Seamless <span style="color: #2563EB;">Travel</span>. Transparent <span style="color: #2563EB;">Fares.</span> 
                <span>Explore  <span style="color:#2563EB;">La Union </span> your way</span>.
              </h1>

          </div>
      </div>

       <div class="relative -mt-8 md:-mt-10 mx-4">
    <div class="bg-white p-4 md:p-6 rounded-xl shadow-2xl shadow-blue-300/50 flex flex-col md:flex-row space-y-3 md:space-y-0 md:space-x-4 relative">
        <div class="flex-grow relative">
            <input id="destination-search" type="text" placeholder="Where are you going? (e.g., Urbiztondo Beach)"
                   class="flex-grow p-3 border border-gray-200 rounded-lg focus:ring-blue-600 focus:border-blue-600 transition duration-150 text-gray-700 placeholder-gray-400 w-full">
            <div id="destination-options"
                 class="absolute bg-white border border-gray-200 rounded-lg mt-1 max-h-60 overflow-y-auto w-full hidden z-50 shadow-lg"></div>
        </div>

        <a href="./pages/dashboard.php?view=bookings" class="btn-color px-6 py-3 font-bold rounded-lg transition duration-300 shadow-lg">
            Book a Ride
        </a>
    </div>
</div>


        <section class="mt-16 p-4 md:p-0">
            <h2 class="text-3xl font-bold text-center text-slate-900 mb-8">Choose Your Way to Travel</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 sm:gap-6">
                
              <?php foreach ($transport_types as $type): ?>
                    <div class="bg-white p-4 sm:p-6 rounded-2xl shadow-xl hover:shadow-2xl hover:scale-[1.02] transition duration-300 cursor-pointer border border-gray-100 text-center group">
                        <div class="text-4xl mb-3 transition duration-300 group-hover:scale-110"><?php echo $type['icon']; ?></div>
                        <h3 class="text-lg font-semibold text-slate-900 mb-1"><?php echo $type['name']; ?></h3>
                        <p class="text-sm text-gray-500 min-h-[40px]"><?php echo $type['description']; ?></p>
                        
                        <a href="./pages/transport_details.php?type=<?php echo urlencode(strtolower($type['name'])); ?>" 
                        class="mt-3 inline-block text-blue-600 text-sm font-medium hover:text-blue-700 opacity-0 group-hover:opacity-100 transition duration-300">
                        View Details &rarr;
                        </a>
                    </div>
                <?php endforeach; ?>
                </div>
        </section>

        <section id="features" class="mt-20 py-10">
            <h2 class="text-3xl font-bold text-center text-slate-900 mb-4">Key Features</h2>
            <p class="text-lg text-center text-gray-600 mb-12 max-w-3xl mx-auto">Connecting every commuter and traveler to a unified digital platform.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <?php foreach ($features as $feature): ?>
                    <div class="flex space-x-4 p-6 bg-white rounded-xl shadow-lg border border-gray-100">
                        <div class="flex-shrink-0">
                            <?php echo $feature['icon_svg']; ?>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-slate-900 mb-2"><?php echo $feature['title']; ?></h3>
                            <p class="text-gray-600"><?php echo $feature['description']; ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
                </div>
        </section>
      
        <section id="attractions" class="mt-20 py-10">
            <h2 class="text-3xl font-bold text-center text-slate-900 mb-4">Explore La Union's Best</h2>
            <p class="text-lg text-center text-gray-600 mb-12 max-w-3xl mx-auto">Find the top landmarks and plan your seamless journey with us.</p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <?php foreach ($attractions as $attraction): ?>
                    <div class="bg-white rounded-xl shadow-xl overflow-hidden group hover:shadow-2xl transition duration-300">
                        <div class="h-48 overflow-hidden">
                            <img src="<?php echo $attraction['image']; ?>" alt="<?php echo $attraction['name']; ?>" 
                                    class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                        </div>
                        <div class="p-5">
                            <h3 class="text-xl font-bold text-slate-900 mb-1"><?php echo $attraction['name']; ?></h3>
                            <p class="text-blue-600 font-semibold mb-3 text-sm"><?php echo $attraction['tag']; ?></p>
                            <a href="#" class="text-gray-600 text-sm font-medium hover:text-blue-600 transition duration-150 flex items-center">
                                Plan Trip Now &rarr;
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
                </div>
            <div class="text-center mt-10">
               <a href="./pages/destinations.php" class="btn-destination inline-block px-8 py-3 font-semibold rounded-lg transition duration-300">
                View All Destinations
              </a>
            </div>
        </section>


        <section id="terminals" class="mt-20 py-10">
            <h2 class="text-3xl font-bold text-center text-slate-900 mb-4">Navigate Terminals Effortlessly</h2>
            <p class="text-lg text-center text-gray-600 mb-12 max-w-3xl mx-auto">We bring scattered terminal information onto a single, intuitive digital map.</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <?php foreach ($terminal_steps as $step): ?>
                    <div class="text-center p-6 bg-white rounded-xl shadow-lg border-t-4 border-blue-600 hover:shadow-2xl transition duration-300">
                        <div class="text-4xl mb-4"><?php echo $step['icon']; ?></div>
                        <h3 class="text-xl font-bold text-slate-900 mb-2"><?php echo $step['title']; ?></h3>
                        <p class="text-gray-600 text-sm"><?php echo $step['description']; ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="text-center mt-10">
                <a href="./pages/live-terminals.php" class="btn-color inline-block px-8 py-3 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 transition duration-300 shadow-lg">
                    View Terminals Map
                </a>
            </div>
        </section>
 
       <section id="about" class="mt-20 py-10 bg-white rounded-xl shadow-2xl p-8 lg:p-16 border border-gray-100">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
        <div class="order-2 lg:order-1">
            <h4 class="text-blue-600 text-lg font-semibold mb-3">Our Mission</h4>
            <h2 class="text-4xl font-extrabold text-slate-900 mb-6">Building Smarter Travel and Stronger Communities.</h2>
            
            <p class="text-gray-700 mb-4">
                We are TouRide. Our mission is to solve the current problem of inconsistent fares, scattered terminal data, and uncoordinated public transport schedules in La Union.
            </p>
            
            <p class="text-gray-700 mb-6">
                We transform local travel by uniting every transport type - motorcycles, tricycles, jeepneys, buses, and vans into a single, unified digital platform. This boosts the local economy, supports operators, and gives both commuters and tourists a seamless, transparent experience.
            </p>

        </div>

        <div class="order-1 lg:order-2">
            <img src="./assets/img/mission.jpg" 
                alt="Image representing community and technology" 
                class="rounded-xl shadow-xl w-full">
        </div>
    </div>
    
    <div class="mt-16 pt-10 border-t border-gray-100">
        <h4 class="text-purple-600 text-lg font-semibold mb-3">Our Vision</h4>
        <h2 class="text-3xl font-extrabold text-slate-900 mb-6">A Seamless, Integrated Future for Regional Mobility.</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <p class="text-gray-700">
                To be the leading smart mobility platform across the entire Ilocos Region, setting the standard for transparent and efficient public transport. We envision a future where all journeys are predictable, fares are fair, and transport operators thrive in a digitized ecosystem.
            </p>
            <p class="text-gray-700">
                Ultimately, TouRide will become synonymous with hassle-free regional travel, eliminating transport uncertainty and serving as the foundational layer for future smart city initiatives in Northern Luzon.
            </p>
        </div>
    </div>
</section>
        
    </main>
</div>
<footer class="mt-16 py-12">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-2 md:grid-cols-5 gap-8 border-b pb-8 mb-8 border-gray-700">
      <div class="col-span-2 md:col-span-2">
        <h4 class="text-xl font-bold mb-3">TouRide</h4>
        <p class="max-w-xs">
          Seamless travel. Transparent fares. The unified digital platform for local transportation and tourism in La Union.
        </p>
        <div class="flex space-x-4 mt-4 footer-socials">
          <a href="#">FB</a>
          <a href="#">TW</a>
          <a href="#">IG</a>
        </div>
      </div>

      <div>
        <h5 class="text-lg font-semibold mb-4">Company</h5>
        <ul class="space-y-2 text-sm">
          <li><a href="#about" class="nav-link">About Us</a></li>
          <li><a href="#">Our Vision</a></li>
          <li><a href="#">Careers</a></li>
          <li><a href="#">Partnerships</a></li>
        </ul>
      </div>

      <div>
        <h5 class="text-lg font-semibold mb-4">Resources</h5>
        <ul class="space-y-2 text-sm">
          <li><a href="#">Help Center</a></li>
          <li><a href="#terminals" class="nav-link">Terminals Map</a></li>
          <li><a href="#">FAQ</a></li>
          <li><a href="#">Offline Routes</a></li>
        </ul>
      </div>

      <div>
        <h5 class="text-lg font-semibold mb-4">Legal</h5>
        <ul class="space-y-2 text-sm">
          <li><a href="#">Privacy Policy</a></li>
          <li><a href="#">Terms of Service</a></li>
        </ul>
      </div>
    </div>

    <div class="text-center text-sm">
      &copy; <?php echo date("Y"); ?> TouRide. All rights reserved.
    </div>
  </div>
</footer>


<script src="./assets/js/app.js"></script>
<script src="./assets/js/slider.js"></script>
<script src="./assets/js/find.js"></script>

</body>
</html>