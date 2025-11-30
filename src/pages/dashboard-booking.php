<?php
$today_date = date('Y-m-d');
?>

    <link rel="stylesheet" href="../assets/css/map.css">

<main class="p-6 md:p-8 flex-1 bg-gray-50 min-h-screen">
    <div class="max-w-6xl mx-auto">
        <h1 class="text-3xl sm:text-4xl font-bold text-slate-800 mb-2">
            Book Your <span class="text-blue-600">La Union</span> Ride
        </h1>
        <p class="text-sm text-gray-500 mb-6">
            Enter your details to instantly compare rates and vehicle types for your adventure.
        </p>
        <div class="bg-white p-6 sm:p-8 rounded-xl shadow-lg border border-gray-100">
            <form action="../backend/booking_process.php" method="POST" id="bookingForm" class="space-y-8">

                <section>
                    <h2 class="text-xl font-semibold text-slate-700 mb-5 flex items-center gap-2 border-b pb-2">
                        <span class="bg-blue-600 text-white w-6 h-6 flex items-center justify-center rounded-full text-sm font-bold">1</span>
                        Trip Details
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="lg:col-span-2">
                            <label for="pickup" class="block text-xs font-medium text-gray-600 mb-1">📍 Pickup Location</label>
                            <input type="text" name="pickup" id="pickup" placeholder="Enter pickup address (e.g., Hotel, Airport)"
                                class="w-full p-2 border border-gray-300 rounded-lg text-sm shadow-sm focus:ring-1 ring-blue-500 focus:border-blue-500 transition duration-150">
                        </div>
                        <div class="lg:col-span-2">
                            <label for="destination" class="block text-xs font-medium text-gray-600 mb-1">🏁 Destination</label>
                            <select name="destination" id="destination"
                                class="w-full p-2 border border-gray-300 rounded-lg text-sm shadow-sm focus:ring-1 ring-blue-500 focus:border-blue-500 transition duration-150 text-gray-700 appearance-none">
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
                        <div>
                            <label for="date" class="block text-xs font-medium text-gray-600 mb-1">📅 Pickup Date</label>
                            <input type="date" name="date" id="date" value="<?php echo $today_date; ?>"
                                class="w-full p-2 border border-gray-300 rounded-lg text-sm shadow-sm focus:ring-1 ring-blue-500 focus:border-blue-500 transition duration-150 text-gray-700">
                        </div>
                        <div>
                            <label for="time" class="block text-xs font-medium text-gray-600 mb-1">⏰ Pickup Time</label>
                            <input type="time" name="time" id="time" value="08:00"
                                class="w-full p-2 border border-gray-300 rounded-lg text-sm shadow-sm focus:ring-1 ring-blue-500 focus:border-blue-500 transition duration-150 text-gray-700">
                        </div>
                        <div class="md:col-span-2">
                            <label for="passengers" class="block text-xs font-medium text-gray-600 mb-1">👥 Passengers</label>
                            <select name="passengers" id="passengers"
                                class="w-full p-2 border border-gray-300 rounded-lg text-sm shadow-sm focus:ring-1 ring-blue-500 focus:border-blue-500 transition duration-150 text-gray-700 appearance-none">
                                <option value="1">1 Passenger</option>
                                <option value="2">2 Passengers</option>
                                <option value="3">3 Passengers</option>
                                <option value="4+">4+ Passengers (Group)</option>
                            </select>
                        </div>
                    </div>
                </section>

                <section class="border-t pt-6">
                    <h2 class="text-xl font-semibold text-slate-700 mb-5 flex items-center gap-2 border-b pb-2">
                        <span class="bg-blue-600 text-white w-6 h-6 flex items-center justify-center rounded-full text-sm font-bold">2</span>
                        Select Mode of Transport
                    </h2>
                    
                    <style>
                        /* Custom styling for the radio buttons/labels - Updated to blue */
                        .transport-label {
                            display: block;
                            border: 1px solid theme('colors.gray.200');
                            border-radius: theme('borderRadius.lg');
                            cursor: pointer;
                            transition: all 0.2s;
                            user-select: none;
                            box-shadow: theme('boxShadow.sm');
                        }
                        input[type="radio"]:checked + .transport-label {
                            border-color: theme('colors.blue.500'); /* Changed from teal */
                            background-color: theme('colors.blue.50'); /* Changed from teal */
                            box-shadow: theme('boxShadow.md') theme('colors.blue.500' / 0.1);
                            transform: translateY(-1px);
                        }
                    </style>

                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
                        <input type="radio" id="transport-motor" name="transport_mode" value="motor" class="hidden">
                        <label for="transport-motor" class="transport-label p-3 text-center">
                            <div class="text-3xl mb-1">🏍️</div>
                            <div class="text-sm font-semibold text-slate-800">Motorcycle</div>
                            <p class="text-xs text-gray-500 mt-0.5 min-h-[25px]">Quick solo rides (1 pax)</p>
                        </label>
                        
                        <input type="radio" id="transport-tricycle" name="transport_mode" value="tricycle" class="hidden" checked>
                        <label for="transport-tricycle" class="transport-label p-3 text-center">
                            <div class="text-3xl mb-1">🛵</div>
                            <div class="text-sm font-semibold text-slate-800">Tricycle</div>
                            <p class="text-xs text-gray-500 mt-0.5 min-h-[25px]">Short city trips (1-3 pax)</p>
                        </label>

                        <input type="radio" id="transport-jeep" name="transport_mode" value="jeep" class="hidden">
                        <label for="transport-jeep" class="transport-label p-3 text-center">
                            <div class="text-3xl mb-1">🚌</div>
                            <div class="text-sm font-semibold text-slate-800">Jeepney</div>
                            <p class="text-xs text-gray-500 mt-0.5 min-h-[25px]">Public transport (Group)</p>
                        </label>

                        <input type="radio" id="transport-taxi" name="transport_mode" value="taxi" class="hidden">
                        <label for="transport-taxi" class="transport-label p-3 text-center">
                            <div class="text-3xl mb-1">🚕</div>
                            <div class="text-sm font-semibold text-slate-800">Taxi</div>
                            <p class="text-xs text-gray-500 mt-0.5 min-h-[25px]">Comfortable rides (1-4 pax)</p>
                        </label>
                        
                        <input type="radio" id="transport-van" name="transport_mode" value="van" class="hidden">
                        <label for="transport-van" class="transport-label p-3 text-center">
                            <div class="text-3xl mb-1">🚐</div>
                            <div class="text-sm font-semibold text-slate-800">Van (Shared/Private)</div>
                            <p class="text-xs text-gray-500 mt-0.5 min-h-[25px]">Group or long travel (Up to 12 pax)</p>
                        </label>

                        <input type="radio" id="transport-bus" name="transport_mode" value="bus" class="hidden">
                        <label for="transport-bus" class="transport-label p-3 text-center">
                            <div class="text-3xl mb-1">🚍</div>
                            <div class="text-sm font-semibold text-slate-800">Bus (Terminal)</div>
                            <p class="text-xs text-gray-500 mt-0.5 min-h-[25px]">Scheduled long-distance</p>
                        </label>
                    </div>
                </section>

                <section class="border-t pt-6">
                    <h2 class="text-xl font-semibold text-slate-700 mb-5 flex items-center gap-2 border-b pb-2">
                        <span class="bg-blue-600 text-white w-6 h-6 flex items-center justify-center rounded-full text-sm font-bold">3</span>
                        Estimate & Confirmation
                    </h2>
                    <div class="bg-blue-50 p-5 rounded-lg shadow-inner border border-blue-200">
                        
                        <div id="map-preview-container" class="map-container mb-5 flex items-center justify-center bg-gray-100 rounded-lg border border-dashed border-gray-300 h-52">
                             <p class="text-gray-500 text-sm p-4 text-center">
                                 Select a Destination above to load the interactive map for that tourist spot.
                             </p>
                        </div>
                        
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-center">
                            <div class="p-2 bg-white rounded-md shadow-sm border border-gray-100">
                                <span class="text-lg font-bold text-slate-800 block" id="travel-time">~30 min</span>
                                <span class="text-xs text-gray-500 uppercase tracking-wider">Est. Travel Time</span>
                            </div>
                            <div class="p-2 bg-white rounded-md shadow-sm border border-gray-100">
                                <span class="text-lg font-bold text-slate-800 block" id="distance">~15 km</span>
                                <span class="text-xs text-gray-500 uppercase tracking-wider">Distance</span>
                            </div>
                            <div id="transport-display" class="p-2 bg-white rounded-md shadow-sm border border-gray-100">
                                <span class="text-lg font-bold text-slate-800 block" id="vehicle-type">Tricycle</span>
                                <span class="text-xs text-gray-500 uppercase tracking-wider">Current Mode</span>
                            </div>
                            <div class="p-2 bg-blue-100 rounded-md shadow-lg border-2 border-blue-600">
                                <span class="text-xs text-blue-600 block uppercase tracking-wider font-semibold">Estimated Fare</span>
                                <span class="text-3xl font-extrabold text-blue-800" id="fare-estimate">₱ 250.00</span>
                            </div>
                        </div>
                        <p id="route-map-info" class="mt-4 text-center text-gray-600 text-xs italic">
                            * Fares are estimates for 3 passengers based on local guidelines and peak time.
                        </p>
                    </div>
                </section>

                <div class="pt-4">
                    <button type="submit" class="w-full bg-blue-600 text-white px-6 py-3 text-lg font-bold rounded-lg transition duration-300 shadow-xl shadow-blue-500/50 hover:bg-blue-700">
                        Proceed to Booking & Payment
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>

<!-- Confirmation Modal -->
<div id="confirmationModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 hidden">
  <div class="bg-white rounded-xl shadow-2xl w-11/12 max-w-md p-6">
    <h2 class="text-2xl font-bold text-slate-800 mb-2 text-center">Confirm Booking</h2>
    <p class="text-gray-600 text-center mb-6">
      Are you sure you want to proceed with this booking?
    </p>
    <div class="flex justify-center gap-4">
      <button id="cancelBtn"
        class="px-5 py-2 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300 transition">
        Cancel
      </button>
      <button id="confirmBtn"
        class="px-5 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
        Confirm
      </button>
    </div>
  </div>
</div>

<!-- Success Modal -->
<div id="successModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 hidden">
  <div class="bg-white rounded-xl shadow-2xl w-11/12 max-w-md p-6 text-center">
    <h2 class="text-2xl font-bold text-green-600 mb-3">✅ Booking Successful!</h2>
    <p class="text-gray-600 mb-6">Your ride has been successfully booked. Redirecting to your dashboard...</p>
    <div class="flex justify-center">
      <button id="okBtn"
        class="px-6 py-2 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition">
        OK
      </button>
    </div>
  </div>
</div>


<script>
const form = document.getElementById('bookingForm');
const modal = document.getElementById('confirmationModal');
const successModal = document.getElementById('successModal');
const confirmBtn = document.getElementById('confirmBtn');
const cancelBtn = document.getElementById('cancelBtn');
const okBtn = document.getElementById('okBtn');

let isConfirmed = false;

form.addEventListener('submit', function(e) {
  if (!isConfirmed) {
    e.preventDefault();
    modal.classList.remove('hidden');
  }
});

confirmBtn.addEventListener('click', () => {
  isConfirmed = true;
  modal.classList.add('hidden');

  const formData = new FormData(form);
  fetch(form.action, {
    method: 'POST',
    body: formData
  })
  .then(response => response.text())
  .then(data => {
    successModal.classList.remove('hidden'); 
    setTimeout(() => {
      window.location.href = '?view=dashboard-content';
    }, 2500);
  })
  .catch(error => {
    alert('An error occurred while booking. Please try again.');
    console.error(error);
  });
});

cancelBtn.addEventListener('click', () => {
  modal.classList.add('hidden');
});

okBtn.addEventListener('click', () => {
  window.location.href = '?view=dashboard-content';
});
</script>

<script src="../assets/js/app.js"></script>
<script src="../assets/js/booking.js"></script>
<script src="../assets/js/map.js"></script>