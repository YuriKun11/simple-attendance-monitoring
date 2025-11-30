<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TouRide - Booking</title>
     <link href="../output.css" rel="stylesheet"> 
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="min-h-screen bg-gray-50">

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
   <?
    include '../component/destinationsNavbar.php';
   ?>
    
    <main class="py-12 md:py-20">
        <h1 class="text-4xl sm:text-5xl font-extrabold text-center text-slate-900 mb-4">
            Book Your <span class="text-teal-600">La Union</span> Ride
        </h1>
        <p class="text-center text-lg text-gray-500 mb-12">
            Enter your details to instantly compare rates and vehicle types.
        </p>

        <div class="max-w-5xl mx-auto bg-white p-6 sm:p-10 rounded-3xl shadow-2xl border border-gray-100">
            <form action="#" method="POST" id="bookingForm" class="space-y-12">

                <!-- Where & When Section -->
                <section>
                    <h2 class="text-2xl font-bold text-slate-800 mb-6 flex items-center gap-3">
                        <span class="bg-teal-500 text-white w-8 h-8 flex items-center justify-center rounded-full text-lg">1</span>
                        Where & When?
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="pickup" class="block text-sm font-semibold text-gray-700 mb-2">📍 Pickup Location</label>
                            <input type="text" name="pickup" id="pickup" placeholder="Enter pickup address (e.g., Hotel, Airport)"
                                class="w-full p-3 border border-gray-300 rounded-xl shadow-inner focus:ring-2 ring-teal-500 focus:border-transparent transition duration-150">
                        </div>
                         <div>
                            <label for="destination" class="block text-sm font-semibold text-gray-700 mb-2">🏁 Destination</label>
                            <select name="destination" id="destination"
                                class="w-full p-3 border border-gray-300 rounded-xl shadow-inner focus:ring-2 ring-teal-500 transition duration-150 text-gray-700 appearance-none">
                                <option value="" disabled selected>Select a Tourist Spot</option>
                                <option value="Ma-Cho Temple">Ma-Cho Temple</option>
                                <option value="Saint William the Hermit Cathedral">Saint William the Hermit Cathedral</option>
                                <option value="Pindangan Ruins">Pindangan Ruins</option>
                                <option value="Pagoda Hill">Pagoda Hill</option>
                                <option value="Poro Point Lighthouse">Poro Point Lighthouse</option>
                                <option value="SM City La Union">SM City La Union</option>
                                <option value="Urbiztondo Beach">Urbiztondo Beach</option>
                                <option value="Tangadan Falls">Tangadan Falls</option>
                            </select>
                        </div>

                        <div class="md:col-span-2 grid grid-cols-1 sm:grid-cols-3 gap-4 mt-2">
                            <div>
                                <label for="date" class="block text-sm font-semibold text-gray-700 mb-2">📅 Pickup Date</label>
                                <input type="date" name="date" id="date" value="<?php echo date('Y-m-d'); ?>"
                                    class="w-full p-3 border border-gray-300 rounded-xl shadow-inner focus:ring-2 ring-teal-500 transition duration-150 text-gray-700">
                            </div>
                            <div>
                                <label for="time" class="block text-sm font-semibold text-gray-700 mb-2">⏰ Pickup Time</label>
                                <input type="time" name="time" id="time" value="08:00"
                                    class="w-full p-3 border border-gray-300 rounded-xl shadow-inner focus:ring-2 ring-teal-500 transition duration-150 text-gray-700">
                            </div>
                            <div>
                                <label for="passengers" class="block text-sm font-semibold text-gray-700 mb-2">👥 Passengers</label>
                                <select name="passengers" id="passengers"
                                    class="w-full p-3 border border-gray-300 rounded-xl shadow-inner focus:ring-2 ring-teal-500 transition duration-150 text-gray-700 appearance-none">
                                    <option value="1">1 Passenger</option>
                                    <option value="2">2 Passengers</option>
                                    <option value="3">3 Passengers</option>
                                    <option value="4+">4+ Passengers (Group)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Ride Selection Section (Kept structure for consistency, functionality is in JS) -->
                <section class="border-t pt-8">
                    <h2 class="text-2xl font-bold text-slate-800 mb-6 flex items-center gap-3">
                        <span class="bg-teal-500 text-white w-8 h-8 flex items-center justify-center rounded-full text-lg">2</span>
                        Choose Your Ride
                    </h2>
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
                        <input type="radio" id="transport-motor" name="transport_mode" value="motor" class="hidden">
                        <label for="transport-motor" class="transport-label p-4 text-center peer">
                            <div class="text-4xl mb-2">🏍️</div>
                            <div class="text-sm font-bold text-slate-900">Motorcycle</div>
                            <p class="text-xs text-gray-500 mt-0.5 min-h-[30px]">Quick solo rides (1 pax)</p>
                        </label>
                        
                        <input type="radio" id="transport-tricycle" name="transport_mode" value="tricycle" class="hidden">
                        <label for="transport-tricycle" class="transport-label p-4 text-center peer">
                            <div class="text-4xl mb-2">🛵</div>
                            <div class="text-sm font-bold text-slate-900">Tricycle</div>
                            <p class="text-xs text-gray-500 mt-0.5 min-h-[30px]">Short city trips (1-3 pax)</p>
                        </label>

                        <input type="radio" id="transport-jeep" name="transport_mode" value="jeep" class="hidden">
                        <label for="transport-jeep" class="transport-label p-4 text-center peer">
                            <div class="text-4xl mb-2">🚌</div>
                            <div class="text-sm font-bold text-slate-900">Jeepney</div>
                            <p class="text-xs text-gray-500 mt-0.5 min-h-[30px]">Classic public transport (Group)</p>
                        </label>

                        <input type="radio" id="transport-taxi" name="transport_mode" value="taxi" class="hidden">
                        <label for="transport-taxi" class="transport-label p-4 text-center peer">
                            <div class="text-4xl mb-2">🚕</div>
                            <div class="text-sm font-bold text-slate-900">Taxi</div>
                            <p class="text-xs text-gray-500 mt-0.5 min-h-[30px]">Comfortable city rides (1-4 pax)</p>
                        </label>
                        
                        <input type="radio" id="transport-van" name="transport_mode" value="van" class="hidden">
                        <label for="transport-van" class="transport-label p-4 text-center peer">
                            <div class="text-4xl mb-2">🚐</div>
                            <div class="text-sm font-bold text-slate-900">Van (Shared/Private)</div>
                            <p class="text-xs text-gray-500 mt-0.5 min-h-[30px]">Group or long travel (Up to 12 pax)</p>
                        </label>

                        <input type="radio" id="transport-bus" name="transport_mode" value="bus" class="hidden">
                        <label for="transport-bus" class="transport-label p-4 text-center peer">
                            <div class="text-4xl mb-2">🚍</div>
                            <div class="text-sm font-bold text-slate-900">Bus (Terminal)</div>
                            <p class="text-xs text-gray-500 mt-0.5 min-h-[30px]">Scheduled long-distance (Ticket)</p>
                        </label>
                    </div>
                </section>

                <!-- Fare Estimate & Vehicle Display -->
                <section class="border-t pt-8">
                    <h2 class="text-2xl font-bold text-slate-800 mb-6 flex items-center gap-3">
                        <span class="bg-teal-500 text-white w-8 h-8 flex items-center justify-center rounded-full text-lg">3</span>
                        Fare Estimate & Route
                    </h2>
                    <div class="bg-blue-50 p-6 rounded-xl shadow-inner border border-blue-200">
                        
                        <!-- Dynamic Map Container -->
                        <div id="map-preview-container" class="map-container mb-6 flex items-center justify-center bg-gray-200 border-2 border-dashed border-gray-400">
                             <p class="text-gray-500 font-medium p-4 text-center">
                                Select a Destination above to load the interactive map for that tourist spot.
                            </p>
                        </div>
                        
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                            <div class="p-3 bg-white rounded-lg shadow-md">
                                <span class="text-xl font-bold text-slate-900 block" id="travel-time">-- min</span>
                                <span class="text-xs text-gray-500 uppercase tracking-wider">Travel Time</span>
                            </div>
                            <div class="p-3 bg-white rounded-lg shadow-md">
                                <span class="text-xl font-bold text-slate-900 block" id="distance">-- km</span>
                                <span class="text-xs text-gray-500 uppercase tracking-wider">Distance</span>
                            </div>
                            <div id="transport-display" class="p-3 bg-white rounded-lg shadow-md">
                                <span class="text-xl font-bold text-slate-900 block" id="vehicle-type">Select Mode</span>
                                <span class="text-xs text-gray-500 uppercase tracking-wider">Vehicle Type</span>
                            </div>
                            <div class="p-3 bg-white rounded-lg shadow-xl border-2 border-teal-600">
                                <span class="text-sm text-gray-500 block uppercase tracking-wider font-semibold">Estimated Fare</span>
                                <span class="text-4xl font-extrabold text-teal-600" id="fare-estimate">₱ 0.00</span>
                            </div>
                        </div>
                        <p id="route-map-info" class="mt-6 text-center text-gray-600 text-sm italic">
                            Map is showing the location of the selected destination. Enter a **Pickup Location** to calculate route and fare.
                        </p>
                    </div>
                </section>

                <!-- Submit -->
                <div class="pt-6">
                    <button type="submit" class="w-full btn-color px-6 py-4 text-xl font-bold rounded-xl transition duration-300 shadow-2xl shadow-teal-500/50 hover:bg-teal-700">
                        ✅ Proceed to Booking & Payment
                    </button>
                    <p class="text-center text-xs text-gray-500 mt-3">
                        By clicking 'Proceed', you agree to our <a href="#" class="underline hover:text-teal-600">Terms of Service</a>.
                    </p>
                </div>
            </form>
        </div>
    </main>
</div>

<script src="../assets/js/app.js"></script>
<script src="../assets/js/booking.js"></script>
<script src="../assets/js/map.js"></script>
</body>
</html>
