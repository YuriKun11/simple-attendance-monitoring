<?php
require '../db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$username = 'Guest';

// --- 1. Get User Details ---
$sql = "SELECT full_name FROM users WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
if ($row = mysqli_fetch_assoc($result)) {
    $username = $row['full_name'];
}

// --- 2. Calculate Total Trips (Finished) ---
// IMPORTANT: We should count finished trips for "Trips Completed"
$sql = "SELECT COUNT(*) AS total FROM ride_bookings WHERE user_id = ? AND status = 'finished'";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$totalTrips = ($row = mysqli_fetch_assoc($result)) ? $row['total'] : 0;

$totalSavings = $totalTrips * 30;

// --- 3. Get Preferred Mode (Based on Finished Trips) ---
$sql = "SELECT transport_mode, COUNT(*) AS cnt 
        FROM ride_bookings 
        WHERE user_id = ? AND status = 'finished' 
        GROUP BY transport_mode 
        ORDER BY cnt DESC 
        LIMIT 1";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$preferredMode = ($row = mysqli_fetch_assoc($result)) ? $row['transport_mode'] : 'N/A';

// --- 4. Get Upcoming Trip (status NOT finished/cancelled) ---
// CRITICAL CHANGE: Removed LIMIT 1 to fetch all upcoming rides
$sql = "SELECT booking_id, destination, pickup_date, pickup_time, transport_mode, pickup_location, fare_estimate
        FROM ride_bookings 
        WHERE user_id = ? AND status NOT IN ('finished', 'cancelled')
        ORDER BY booking_id DESC"; // Keep DESC to show newest first
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Store all upcoming trips in an array
$upcomingTrips = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Update Next Destination to be the first one in the list, or 'N/A'
$upcomingTrip = !empty($upcomingTrips) ? $upcomingTrips[0] : null;
$nextDestination = $upcomingTrip ? $upcomingTrip['destination'] : 'N/A';

// --- 5. Get Past Trips (status = 'finished') ---
// This is the CRITICAL change you requested:
$sql = "SELECT destination, transport_mode, pickup_date, pickup_time, fare_estimate 
        FROM ride_bookings 
        WHERE user_id = ? AND status = 'finished' 
        ORDER BY pickup_date DESC, pickup_time DESC"; // Added pickup_time for better sorting
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$pastTripsResult = mysqli_stmt_get_result($stmt);
?>

<main class="p-6 md:p-10 flex-1">

    <div class="bg-gradient-to-r from-blue-600 to-cyan-500 p-8 md:p-12 rounded-2xl shadow-xl text-white mb-10">
        <h2 class="text-3xl md:text-4xl font-extrabold mb-2">
            Plan Your Next La Union Adventure
        </h2>
        <p class="text-blue-100 mb-6 max-w-2xl">
            Find the quickest and most transparent route to Urbiztondo, Tangadan Falls, or anywhere in between.
        </p>
        <a href="?view=bookings" 
            class="inline-block bg-white text-blue-600 font-bold py-3 px-6 rounded-full hover:bg-gray-100 transition duration-300 shadow-lg">
            Start a New Trip
        </a>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 mb-10">
        <div class="bg-white p-6 rounded-xl shadow-md transition hover:shadow-lg">
            <span class="text-2xl mb-2 block">🛤️</span>
            <p class="text-sm font-medium text-gray-500">Trips Completed</p>
            <p class="text-2xl font-extrabold text-gray-900 mt-1 sm:text-3xl"><?php echo $totalTrips; ?></p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-md transition hover:shadow-lg">
            <span class="text-2xl mb-2 block">💰</span>
            <p class="text-sm font-medium text-gray-500">Savings (Est.)</p>
            <p class="text-2xl font-extrabold text-green-600 mt-1 sm:text-3xl">₱ <?php echo number_format($totalSavings, 0); ?></p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-md transition hover:shadow-lg">
            <span class="text-2xl mb-2 block">🛵</span>
            <p class="text-sm font-medium text-gray-500">Preferred Mode</p>
            <p class="text-xl font-extrabold text-gray-900 mt-1 sm:text-2xl"><?php echo htmlspecialchars($preferredMode); ?></p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-md transition hover:shadow-lg">
            <span class="text-2xl mb-2 block">⭐</span>
            <p class="text-sm font-medium text-gray-500">Next Destination</p>
            <p class="text-xl font-extrabold text-gray-900 mt-1 sm:text-2xl"><?php echo htmlspecialchars($nextDestination); ?></p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
    <section class="lg:col-span-3 bg-white p-6 rounded-2xl shadow-xl">
        <h3 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Upcoming Trips (<?php echo count($upcomingTrips); ?>)</h3>
        
        <?php if (!empty($upcomingTrips)): ?>
            <?php foreach ($upcomingTrips as $index => $trip): ?>
                <div class="mb-8">
                    <div class="flex items-center justify-between p-4 border rounded-xl bg-blue-50 mb-4">
                        <div>
                            <p class="text-lg font-semibold text-blue-700">
                                <?php echo htmlspecialchars($trip['transport_mode']); ?> to 
                                <?php echo htmlspecialchars($trip['destination']); ?>
                            </p>
                            <p class="text-sm text-gray-600">
                                Pickup: <strong><?php echo htmlspecialchars($trip['pickup_location']); ?></strong><br>
                                Departure: <strong><?php echo date('D, M j', strtotime($trip['pickup_date'])); ?></strong> 
                                at <strong><?php echo date('g:i A', strtotime($trip['pickup_time'])); ?></strong>
                            </p>
                        </div>
                        <button 
                            class="view-ticket-btn text-white bg-green-500 hover:bg-green-600 py-2 px-4 rounded-lg font-medium text-sm"
                            data-id="<?php echo $trip['booking_id']; ?>">
                            View Ticket
                        </button>
                    </div>
                    
                    <div id="mapContainer-<?php echo $trip['booking_id']; ?>" class="h-64 bg-gray-200 rounded-lg overflow-hidden">
                        <iframe 
                            id="destinationMap-<?php echo $trip['booking_id']; ?>"
                            class="trip-map-frame" 
                            data-destination="<?php echo htmlspecialchars($trip['destination']); ?>"
                            src=""
                            width="100%"
                            height="100%"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="text-gray-500 italic">No upcoming trips found. Book your first ride!</div>
        <?php endif; ?>
    </section>

        <section class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-xl">
            <h3 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Past Trips</h3>
            <?php if (mysqli_num_rows($pastTripsResult) > 0): ?>
                <ul class="divide-y divide-gray-200">
                    <?php while ($trip = mysqli_fetch_assoc($pastTripsResult)): ?>
                        <li class="py-3">
                            <p class="font-medium text-gray-800">
                                <?php echo htmlspecialchars($trip['transport_mode']); ?> to 
                                <?php echo htmlspecialchars($trip['destination']); ?>
                            </p>
                            <p class="text-sm text-gray-500">
                                Date: <?php echo date('M j, Y', strtotime($trip['pickup_date'])); ?> • 
                                Time: <?php echo date('g:i A', strtotime($trip['pickup_time'])); ?> • 
                                Fare: ₱<?php echo number_format($trip['fare_estimate'], 2); ?>
                            </p>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p class="text-gray-500 italic">No finished trips found in your history.</p>
            <?php endif; ?>
        </section>
    </div>
</main>

<div id="ticketModal" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">
    <div class="bg-white rounded-xl shadow-2xl p-6 w-96 relative">
        <button type="button" id="closeModalBtn" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-lg font-bold">×</button>
        <h3 class="text-xl font-bold mb-4 text-blue-700">🎫 Ticket Details</h3>
        <div id="ticketDetails" class="space-y-2 text-gray-700 text-sm"></div>
        <!-- <button type="button" id="completeBookingBtn" class="mt-4 w-full bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-lg font-medium text-sm">
            Mark as Completed
        </button> -->
        <button type="button" id="cancelBookingBtn" class="mt-4 w-full bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-lg font-medium text-sm">
            Cancel Trip
        </button>
    </div>
</div>

<div id="confirmModal" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">
    <div class="bg-white rounded-xl shadow-2xl p-6 w-96 relative">
        <h3 id="confirmModalTitle" class="text-xl font-bold mb-4 text-gray-800">Confirm Action</h3>
        <p id="confirmModalMessage" class="text-gray-700 mb-6"></p>
        <div class="flex justify-end gap-4">
            <button id="confirmCancelBtn" class="bg-gray-300 hover:bg-gray-400 text-gray-800 py-2 px-4 rounded-lg font-medium">Cancel</button>
            <button id="confirmOkBtn" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg font-medium">Confirm</button>
        </div>
    </div>
</div>

<div id="successModal" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">
    <div class="bg-white rounded-xl shadow-2xl p-6 w-96 relative text-center">
        <h3 class="text-xl font-bold mb-2 text-green-600">✅ Success!</h3>
        <p id="successModalMessage" class="text-gray-700 mb-4"></p>
        <button id="successModalOkBtn" class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-lg font-medium">
            OK
        </button>
    </div>
</div>


<script>
const successModal = document.getElementById('successModal');
const successModalMessage = document.getElementById('successModalMessage');
const successModalOkBtn = document.getElementById('successModalOkBtn');

function showSuccessModal(message, callback) {
    successModalMessage.textContent = message;
    successModal.classList.remove('hidden');
    successModal.classList.add('flex');

    successModalOkBtn.onclick = () => {
        successModal.classList.add('hidden');
        successModal.classList.remove('flex');
        if (callback) callback();
        window.location.reload();
        
    };
}
</script>

<script>
const confirmModal = document.getElementById('confirmModal');
const confirmModalTitle = document.getElementById('confirmModalTitle');
const confirmModalMessage = document.getElementById('confirmModalMessage');
const confirmOkBtn = document.getElementById('confirmOkBtn');
const confirmCancelBtn = document.getElementById('confirmCancelBtn');

function showConfirmModal(title, message, onConfirm) {
    confirmModalTitle.textContent = title;
    confirmModalMessage.textContent = message;
    confirmModal.classList.remove('hidden');
    confirmModal.classList.add('flex');

    const cleanup = () => {
        confirmModal.classList.add('hidden');
        confirmModal.classList.remove('flex');
        confirmOkBtn.onclick = null;
        confirmCancelBtn.onclick = null;
    };

    confirmOkBtn.onclick = () => {
        cleanup();
        onConfirm();
    };

    confirmCancelBtn.onclick = cleanup;
}
</script>

<script>

let currentBookingId = null;

// Open ticket modal
document.querySelectorAll('.view-ticket-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const bookingId = this.dataset.id;
        currentBookingId = bookingId;

        fetch('../backend/view_ticket.php?id=' + bookingId)
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const t = data.ticket;
                    document.getElementById('ticketDetails').innerHTML = `
                        <p><strong>Destination:</strong> ${t.destination}</p>
                        <p><strong>Pickup Location:</strong> ${t.pickup_location}</p>
                        <p><strong>Transport Mode:</strong> ${t.transport_mode}</p>
                        <p><strong>Date:</strong> ${t.pickup_date}</p>
                        <p><strong>Time:</strong> ${t.pickup_time}</p>
                        <p><strong>Fare Estimate:</strong> ₱${t.fare_estimate}</p>
                      
                    `;
                    document.getElementById('ticketModal').classList.remove('hidden');
                    document.getElementById('ticketModal').classList.add('flex');
                } else {
                    alert('Ticket not found!');
                    currentBookingId = null;
                }
            });
    });
});

// Close modal
document.getElementById('closeModalBtn').addEventListener('click', () => {
    document.getElementById('ticketModal').classList.add('hidden');
    document.getElementById('ticketModal').classList.remove('flex');
    currentBookingId = null; // Reset so no accidental update
});

// Complete booking (only fires on explicit click)
document.getElementById('completeBookingBtn').addEventListener('click', () => {
    if (!currentBookingId) return;

    showConfirmModal(
        'Mark as Completed',
        'Are you sure you want to mark this booking as completed?',
        () => {
            fetch('../backend/update_booking_status.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ booking_id: currentBookingId })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                   showSuccessModal('Booking marked as completed!', () => {
                        document.getElementById('ticketModal').classList.add('hidden');
                        document.getElementById('ticketModal').classList.remove('flex');
                        // window.location.reload();
                    });
                    document.getElementById('ticketModal').classList.add('hidden');
                    document.getElementById('ticketModal').classList.remove('flex');
                    // window.location.reload();
                } else {
                    alert('Failed to update booking. ' + (data.message || ''));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred.');
            });
        }
    );
});

</script>


<script>
// Map Locations
const LA_UNION_MAP_LOCATIONS = {
    "Ma-Cho Temple": "https://maps.google.com/maps?q=Ma-Cho%20Temple,%20San%20Fernando,%20La%20Union&t=&z=16&ie=UTF8&iwloc=&output=embed",
    "Saint William the Hermit Cathedral": "https://maps.google.com/maps?q=Saint%20William%20the%20Hermit%20Cathedral,%20San%20Fernando,%20La%20Union&t=&z=16&ie=UTF8&iwloc=&output=embed",
    "Pindangan Ruins": "https://maps.google.com/maps?q=Pindangan%20Ruins,%20San%20Fernando,%20La%20Union&t=&z=16&ie=UTF8&iwloc=&output=embed",
    "Pagoda Hill": "https://maps.google.com/maps?q=Pagoda%20Hill,%20San%20Fernando,%20La%20Union&t=&z=16&ie=UTF8&iwloc=&output=embed",
    "Poro Point Lighthouse": "https://maps.google.com/maps?q=Poro%20Point%20Lighthouse,%20San%20Fernando,%20La%20Union&t=&z=16&ie=UTF8&iwloc=&output=embed",
    "SM City La Union": "https://maps.google.com/maps?q=SM%20City%20La%20Union,%20San%20Fernando,%20La%20Union&t=&z=16&ie=UTF8&iwloc=&output=embed",
    "Urbiztondo Beach": "https://maps.google.com/maps?q=Urbiztondo%20Beach,%20San%20Juan,%20La%20Union&t=&z=16&ie=UTF8&iwloc=&output=embed",
    "Tangadan Falls": "https://maps.google.com/maps?q=Tangadan%20Falls,%20San%20Gabriel,%20La%20Union&t=&z=16&ie=UTF8&iwloc=&output=embed"
};

document.querySelectorAll('.trip-map-frame').forEach(mapFrame => {
    const destination = mapFrame.dataset.destination;
    
    if (LA_UNION_MAP_LOCATIONS[destination]) {
        mapFrame.src = LA_UNION_MAP_LOCATIONS[destination];
    } else {
     
        mapFrame.parentElement.innerHTML = `
            <div class="h-full flex items-center justify-center text-gray-500 italic">
                Map not yet available for "${destination}"
            </div>`;
    }
});
</script>

<script>
//CANCEL BOOKING
document.getElementById('cancelBookingBtn').addEventListener('click', () => {
    if (!currentBookingId) return;

    showConfirmModal(
        'Cancel Trip',
        'Are you sure you want to cancel this booking?',
        () => {
            fetch('../backend/cancel_booking.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ booking_id: currentBookingId })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    showSuccessModal('Booking successfully cancelled!', () => {
                        document.getElementById('ticketModal').classList.add('hidden');
                        document.getElementById('ticketModal').classList.remove('flex');
                        // window.location.reload();
                    });
                    document.getElementById('ticketModal').classList.add('hidden');
                    document.getElementById('ticketModal').classList.remove('flex');
                    // window.location.reload();
                } else {
                    alert('Failed to cancel booking. ' + (data.message || ''));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred during cancellation.');
            });
        }
    );
});
</script>

