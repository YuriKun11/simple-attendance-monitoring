
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
// Driver-specific data arrays
$driver_benefits = [
    [
        'title' => 'Boost Your Income',
        'description' => 'Access a steady stream of tourists and local commuters. Fill your seats more often with digital bookings and real-time requests.',
        'icon_svg' => '<svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2M21 12a9 9 0 11-18 0 9 9 0 0118 0zM12 7v1m0 8v1m-6.211-1.211l.707-.707M17.504 6.496l-.707.707M17.504 17.504l-.707-.707M6.496 6.496l.707.707"></path></svg>' // Dollar/Earning
    ],
    [
        'title' => 'Transparent Operations',
        'description' => 'Standardized digital fare calculation ensures you are paid fairly and consistently for every trip. No more haggling or confusion.',
        'icon_svg' => '<svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.504A9.951 9.951 0 0112 3c-5.523 0-10 4.477-10 10 0 2.21 1.05 4.22 2.7 5.58M21.5 13H19.5a.5.5 0 00-.5.5v1a.5.5 0 00.5.5h2a.5.5 0 00.5-.5v-1a.5.5 0 00-.5-.5zM12 18h.01"></path></svg>' // Checkmark/Accuracy
    ],
    [
        'title' => 'Efficient Route Management',
        'description' => 'Access real-time schedules and route demand data to optimize your shifts. Reduce idle time and unnecessary fuel consumption.',
        'icon_svg' => '<svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>' // Bolt/Efficiency
    ],
    [
        'title' => 'Community Support',
        'description' => 'Join a network of professional operators. Get access to training, local government compliance updates, and driver-focused assistance.',
        'icon_svg' => '<svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5m-5 0a2 2 0 100-4m0 4a2 2 0 110-4m-9-6a4 4 0 100 8m-2-8h4l-2-2-2 2zM9 16l-2 2-4-4"></path></svg>' // Users/Community
    ],
];

$transport_types = [
    [ 'name' => 'Motorcycle', 'description' => 'Quick solo rides for short distances.', 'icon' => '🏍️' ],
    [ 'name' => 'Tricycle', 'description' => 'Ideal for short city or provincial trips.', 'icon' => '🛵'],
    [ 'name' => 'Jeepney', 'description' => 'The classic Filipino public transport.', 'icon' => '🚎'],
    [ 'name' => 'Van', 'description' => 'Shared or long-distance group travel.', 'icon' => '🚐'],
    [ 'name' => 'Taxi', 'description' => 'Comfortable and convenient city rides.', 'icon' => '🚕'],
    [ 'name' => 'Bus', 'description' => 'Pre-book seats with digital payments.', 'icon' => '🚌'],
];

$registration_steps = [
    [ 'icon' => '📝', 'title' => 'Sign Up', 'description' => 'Create your account and complete your driver profile. We verify your operator details.' ],
    [ 'icon' => '📄', 'title' => 'Submit Documents', 'description' => 'Upload necessary documents: driver\'s license, vehicle registration, and operator permits.' ],
    [ 'icon' => '📱', 'title' => 'App Training', 'description' => 'Complete a quick training session on using the TouRide Driver app and digital fare system.' ],
    [ 'icon' => '🚀', 'title' => 'Start Driving!', 'description' => 'Go online, accept ride requests, and start earning better with TouRide.' ]
];
?>


<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

   <?
    include './component/express-navbar.php';
   ?>
    
   <main class="mt-8 mb-16">
        <div id="hero-driver" class="w-full h-72 md:h-96 rounded-xl overflow-hidden shadow-xl relative transition-all duration-1000 ease-in-out">
            <img src="./assets/img/slider1.png"
                alt="Local transport operator looking confident while holding a smartphone"
                class="w-full h-full object-cover opacity-80 transition-opacity duration-1000 ease-in-out">
            <div class="absolute inset-0 flex items-center justify-center p-4 backdrop-brightness-50 rounded-xl">
                <h1 class="text-4xl sm:text-5xl lg:text-7xl font-extrabold text-white text-center tracking-tight leading-tight">
                    Join as TOURIDE</span> <span>DRIVER </span> 
                    <span>now!</span>
                </h1>
            </div>
        </div>

        <div class="relative -mt-8 md:-mt-10 mx-4">
            <div class="bg-white p-4 md:p-6 rounded-xl shadow-2xl shadow-green-300/50 flex flex-col md:flex-row space-y-3 md:space-y-0 md:space-x-4 relative justify-center">
                <a href="./driver_register.php" class="btn-color px-8 py-4 font-bold rounded-lg transition duration-300 shadow-xl text-center bg-green-600 text-white hover:bg-green-700">
                    Join TouRide Today & Start Earning!
                </a>
            </div>
        </div>


        <section id="benefits" class="mt-16 p-4 md:p-0">
            <h2 class="text-3xl font-bold text-center text-slate-900 mb-4">Why Drive with TouRide?</h2>
            <p class="text-lg text-center text-gray-600 mb-12 max-w-3xl mx-auto">We provide the tools and passengers you need to maximize your daily trips and profit.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <?php foreach ($driver_benefits as $benefit): ?>
                    <div class="flex space-x-4 p-6 bg-white rounded-xl shadow-lg border border-gray-100">
                        <div class="flex-shrink-0">
                            <?php echo $benefit['icon_svg']; ?>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-slate-900 mb-2"><?php echo $benefit['title']; ?></h3>
                            <p class="text-gray-600"><?php echo $benefit['description']; ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
        
        <hr class="my-16 border-gray-200">

        <section id="vehicles" class="p-4 md:p-0 mt-10">
            <h2 class="text-3xl font-bold text-center text-slate-900 mb-8">All Types of Operators Welcome</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 sm:gap-6">
                <?php foreach ($transport_types as $type): ?>
                    <div class="bg-white p-4 sm:p-6 rounded-2xl shadow-xl transition duration-300 border border-gray-100 text-center">
                        <div class="text-4xl mb-3"><?php echo $type['icon']; ?></div>
                        <h3 class="text-lg font-semibold text-slate-900 mb-1"><?php echo $type['name']; ?></h3>
                        <p class="text-sm text-gray-500 min-h-[40px]"><?php echo $type['description']; ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <hr class="my-16 border-gray-200">

        <section id="registration" class="py-10">
            <h2 class="text-3xl font-bold text-center text-slate-900 mb-4">Simple Steps to Become a TouRide Partner</h2>
            <p class="text-lg text-center text-gray-600 mb-12 max-w-3xl mx-auto">Get verified and start benefiting from the digital platform in just a few steps.</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <?php foreach ($registration_steps as $step): ?>
                    <div class="text-center p-6 bg-white rounded-xl shadow-lg border-t-4 border-green-600 hover:shadow-2xl transition duration-300">
                        <div class="text-4xl mb-4"><?php echo $step['icon']; ?></div>
                        <h3 class="text-xl font-bold text-slate-900 mb-2"><?php echo $step['title']; ?></h3>
                        <p class="text-gray-600 text-sm"><?php echo $step['description']; ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="text-center mt-10">
                <a href="./driver_register.php" class="btn-color inline-block px-8 py-3 bg-green-600 text-white font-bold rounded-lg hover:bg-green-700 transition duration-300 shadow-xl text-lg">
                    Register Now
                </a>
            </div>
        </section>

        <section class="mt-20 py-10 bg-gray-50 rounded-xl shadow-inner p-8 lg:p-16">
            <blockquote class="text-center max-w-4xl mx-auto">
                <p class="text-3xl font-serif italic text-gray-800 mb-6">
                    "Since joining TouRide, my daily income has increased by 30%. The fixed fares and easy access to tourist passengers have changed how I work. No more guesswork, just smooth trips."
                </p>
                <footer class="text-lg font-semibold text-green-600">
                    — Manong Ben, Jeepney Operator, San Juan, La Union
                </footer>
            </blockquote>
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