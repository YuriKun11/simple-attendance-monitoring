<?php
require_once('../db_connect.php'); 

if (!isset($conn)) {
    echo '<div class="p-4 bg-red-100 text-red-700 rounded-lg">Error: Database connection not established. Check ../config/db.php</div>';
    return;
}

$driverId = $_SESSION['driver_id'];

if (isset($_GET['action'], $_GET['booking_id'])) {
    $action = $_GET['action'];
    $bookingId = (int)$_GET['booking_id'];
    $newStatus = null;
    $message = '';

    switch ($action) {
        case 'start':
            $newStatus = 'ongoing';
            $message = 'Ride started successfully!';
            break;
        case 'complete':
            $newStatus = 'finished';
            $message = 'Ride marked as finished! Great job!';
            break;
        case 'cancel':
            $newStatus = 'cancelled';
            $message = 'Ride cancelled.';
            break;
        case 'accept':
            $newStatus = 'pending';
            $message = 'Ride accepted! It is now in your Active Bookings.';
            break;
        default:
            $message = 'Invalid action.';
            break;
    }

    if ($newStatus) {
        try {
            if ($action === 'accept') {
                $stmt = $conn->prepare("UPDATE `ride_bookings` SET status = ?, driver_id = ? WHERE booking_id = ? AND driver_id IS NULL");
                $stmt->bind_param("sii", $newStatus, $driverId, $bookingId);
            } else {
                $stmt = $conn->prepare("UPDATE `ride_bookings` SET status = ? WHERE booking_id = ? AND driver_id = ?");
                $stmt->bind_param("sii", $newStatus, $bookingId, $driverId);
            }
            
            if ($stmt->execute() && $stmt->affected_rows > 0) {
                $_SESSION['action_message'] = ['type' => 'success', 'text' => $message];
            } else {
                $_SESSION['action_message'] = ['type' => 'error', 'text' => 'Action failed. Booking not found or you are not authorized.'];
            }
            $stmt->close();

        } catch (Exception $e) {
            error_log("Booking action error: " . $e->getMessage());
            $_SESSION['action_message'] = ['type' => 'error', 'text' => 'An unexpected error occurred.'];
        }
        header("Location: ?view=booking");
        exit();
    }
}

if (isset($_SESSION['action_message'])) {
    $msg = $_SESSION['action_message'];
    $color = $msg['type'] === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700';
    echo '<div class="' . $color . ' p-4 mb-6 rounded-lg font-medium">' . htmlspecialchars($msg['text']) . '</div>';
    unset($_SESSION['action_message']); 
}

function fetchAssignedBookings($conn, $driverId, $statuses) {
    $inClause = str_repeat('?,', count($statuses) - 1) . '?';
    $sql = "
        SELECT 
            rb.*, 
            u.full_name AS user_name 
        FROM 
            ride_bookings rb
        JOIN 
            users u ON rb.user_id = u.id
        WHERE 
            rb.driver_id = ? AND rb.status IN ($inClause)
        ORDER BY 
            rb.pickup_date ASC, rb.pickup_time ASC
    ";

    $stmt = $conn->prepare($sql);

    $types = 'i' . str_repeat('s', count($statuses));
    $params = array_merge([$driverId], $statuses);
    $stmt->bind_param($types, ...$params);

    $stmt->execute();
    $result = $stmt->get_result();
    $bookings = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $bookings;
}

function fetchNewRequests($conn) {
    $sql = "
        SELECT 
            rb.*, 
            u.full_name AS user_name 
        FROM 
            ride_bookings rb
        JOIN 
            users u ON rb.user_id = u.id
        WHERE 
            rb.driver_id IS NULL AND rb.status = 'pending'
        ORDER BY 
            rb.created_at ASC
    ";

    $result = $conn->query($sql);
    $bookings = $result->fetch_all(MYSQLI_ASSOC);
    return $bookings;
}

$activeBookings = fetchAssignedBookings($conn, $driverId, ['pending', 'ongoing']);
$historyBookings = fetchAssignedBookings($conn, $driverId, ['finished', 'cancelled']);
$newRequests = fetchNewRequests($conn);

function displayBookingCard($booking, $isNewRequest = false) {
    $statusColor = [
        'pending' => 'bg-yellow-100 text-yellow-800',
        'ongoing' => 'bg-blue-100 text-blue-800',
        'finished' => 'bg-green-100 text-green-800',
        'cancelled' => 'bg-red-100 text-red-800',
    ][$booking['status']] ?? 'bg-gray-100 text-gray-800';

    $isPending = $booking['status'] === 'pending';
    $isOngoing = $booking['status'] === 'ongoing';
    $isFinal = in_array($booking['status'], ['finished', 'cancelled']);
    
    ?>
    <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100 flex flex-col justify-between h-full">
        <div>
            <div class="flex justify-between items-start mb-4">
                <h3 class="text-xl font-bold text-gray-800">Booking #<?= htmlspecialchars($booking['booking_id']) ?></h3>
                <span class="py-1 px-3 text-xs font-semibold rounded-full <?= $statusColor ?>">
                    <?= ucfirst(htmlspecialchars($booking['status'])) ?>
                </span>
            </div>

            <div class="space-y-3 mb-6">
                <p class="flex items-center text-sm text-gray-600">
                    <span class="material-symbols-outlined text-blue-500 mr-3 text-lg">person</span>
                    <span class="font-medium text-gray-800"><?= htmlspecialchars($booking['user_name']) ?></span> (<?= htmlspecialchars($booking['passengers']) ?> pax)
                </p>
                <p class="flex items-start text-sm text-gray-600">
                    <span class="material-symbols-outlined text-green-500 mr-3 text-lg">location_on</span>
                    <strong class="text-gray-700">From:</strong> <?= htmlspecialchars($booking['pickup_location']) ?>
                </p>
                <p class="flex items-start text-sm text-gray-600">
                    <span class="material-symbols-outlined text-red-500 mr-3 text-lg">flag</span>
                    <strong class="text-gray-700">To:</strong> <?= htmlspecialchars($booking['destination']) ?>
                </p>
                <p class="flex items-center text-sm text-gray-600">
                    <span class="material-symbols-outlined text-indigo-500 mr-3 text-lg">schedule</span>
                    <strong class="text-gray-700">Time:</strong> <?= date('M d, Y', strtotime($booking['pickup_date'])) ?> @ <?= date('h:i A', strtotime($booking['pickup_time'])) ?>
                </p>
            </div>
            
            <div class="text-lg font-extrabold text-right border-t border-gray-100 pt-3">
                <span class="text-gray-500 font-medium text-base">Fare Est.:</span> ₱<?= number_format($booking['fare_estimate'], 2) ?>
            </div>
        </div>

        <?php if (!$isFinal): ?>
            <div class="mt-4 flex flex-col space-y-2">
                <?php if ($isNewRequest): ?>
                    <a href="?view=booking&action=accept&booking_id=<?= $booking['booking_id'] ?>" 
                       class="w-full text-center py-3 px-4 rounded-xl text-white bg-green-600 hover:bg-green-700 font-bold transition duration-150 shadow-md">
                        Accept Ride
                    </a>
                <?php elseif ($isPending): ?>
                    <a href="?view=booking&action=start&booking_id=<?= $booking['booking_id'] ?>" 
                       class="w-full text-center py-3 px-4 rounded-xl text-white bg-blue-600 hover:bg-blue-700 font-bold transition duration-150 shadow-md">
                        Start Trip
                    </a>
                <?php elseif ($isOngoing): ?>
                    <a href="?view=booking&action=complete&booking_id=<?= $booking['booking_id'] ?>" 
                       class="w-full text-center py-3 px-4 rounded-xl text-white bg-green-600 hover:bg-green-700 font-bold transition duration-150 shadow-md">
                        Mark as Complete
                    </a>
                <?php endif; ?>
                
                <?php if (!$isNewRequest): ?>
                    <a href="?view=booking&action=cancel&booking_id=<?= $booking['booking_id'] ?>" 
                       class="w-full text-center py-2 text-sm rounded-xl text-red-600 bg-red-50 hover:bg-red-100 transition duration-150">
                        Cancel Ride
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
    <?php
}
?>

<div class="container mx-auto">
    <h2 class="text-3xl font-extrabold text-gray-900 mb-8">Ride Bookings</h2>

    <!-- Tabs Navigation -->
    <div class="border-b border-gray-200">
        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
            <button onclick="showTab('active')" id="tab-active"
                class="tab-btn py-3 px-1 inline-flex items-center text-sm font-medium border-b-2 border-blue-600 text-blue-600 transition duration-150 ease-in-out"
                aria-current="page">
                <span class="material-symbols-outlined text-xl mr-2">local_taxi</span>
                Active Rides (<?= count($activeBookings) ?>)
            </button>
            <button onclick="showTab('new')" id="tab-new"
                class="tab-btn py-3 px-1 inline-flex items-center text-sm font-medium border-b-2 border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 transition duration-150 ease-in-out">
                <span class="material-symbols-outlined text-xl mr-2">add_task</span>
                New Requests (<?= count($newRequests) ?>)
            </button>
            <button onclick="showTab('history')" id="tab-history"
                class="tab-btn py-3 px-1 inline-flex items-center text-sm font-medium border-b-2 border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 transition duration-150 ease-in-out">
                <span class="material-symbols-outlined text-xl mr-2">history</span>
                History (<?= count($historyBookings) ?>)
            </button>
        </nav>
    </div>

    <!-- Tab Content -->

    <!-- Active Bookings Tab -->
    <div id="content-active" class="tab-content pt-8">
        <h3 class="text-2xl font-semibold text-gray-800 mb-4">Your Active Trips (Pending & Ongoing)</h3>
        <?php if (!empty($activeBookings)): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($activeBookings as $booking): ?>
                    <?php displayBookingCard($booking); ?>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-12 bg-white rounded-xl shadow-inner text-gray-500">
                <span class="material-symbols-outlined text-6xl mb-3 text-blue-300">verified</span>
                <p class="font-semibold text-xl">No Active Bookings</p>
                <p>You have no trips currently assigned or pending. Check 'New Requests'!</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- New Requests Tab -->
    <div id="content-new" class="tab-content pt-8 hidden">
        <h3 class="text-2xl font-semibold text-gray-800 mb-4">New Available Ride Requests</h3>
        <?php if (!empty($newRequests)): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($newRequests as $booking): ?>
                    <?php displayBookingCard($booking, true); ?>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-12 bg-white rounded-xl shadow-inner text-gray-500">
                <span class="material-symbols-outlined text-6xl mb-3 text-green-300">waving_hand</span>
                <p class="font-semibold text-xl">No New Requests Available</p>
                <p>All current requests have been accepted or are temporarily unavailable.</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- History Tab -->
    <div id="content-history" class="tab-content pt-8 hidden">
        <h3 class="text-2xl font-semibold text-gray-800 mb-4">Ride History (Finished & Cancelled)</h3>
        <?php if (!empty($historyBookings)): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($historyBookings as $booking): ?>
                    <?php displayBookingCard($booking); ?>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-12 bg-white rounded-xl shadow-inner text-gray-500">
                <span class="material-symbols-outlined text-6xl mb-3 text-indigo-300">history_edu</span>
                <p class="font-semibold text-xl">No History Yet</p>
                <p>Complete a few rides to see your history here!</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    function showTab(tabId) {
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('border-blue-600', 'text-blue-600');
            btn.classList.add('border-transparent', 'text-gray-500', 'hover:border-gray-300', 'hover:text-gray-700');
        });
        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.add('hidden');
        });
        const selectedBtn = document.getElementById('tab-' + tabId);
        const selectedContent = document.getElementById('content-' + tabId);
        
        if (selectedBtn && selectedContent) {
            selectedBtn.classList.add('border-blue-600', 'text-blue-600');
            selectedBtn.classList.remove('border-transparent', 'text-gray-500', 'hover:border-gray-300', 'hover:text-gray-700');
            selectedContent.classList.remove('hidden');
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        const hash = window.location.hash.substring(1); 
        if (hash === 'new' || hash === 'history') {
             showTab(hash);
        } else {
             showTab('active');
        }
    });
</script>