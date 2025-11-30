<?php
require '../db_connect.php';

if (!isset($_SESSION['driver_id'])) {
    header("Location: ../driver_login.php");
    exit();
}

$driver_id = $_SESSION['driver_id'];
$driverName = $_SESSION['driver_name'];

// Total bookings
$stmt = $conn->prepare("SELECT COUNT(*) FROM ride_bookings WHERE driver_id = ?");
$stmt->bind_param("i", $driver_id);
$stmt->execute();
$stmt->bind_result($totalBookings);
$stmt->fetch();
$stmt->close();

// Completed bookings
$stmt = $conn->prepare("SELECT COUNT(*) FROM ride_bookings WHERE driver_id = ? AND status='finished'");
$stmt->bind_param("i", $driver_id);
$stmt->execute();
$stmt->bind_result($completed);
$stmt->fetch();
$stmt->close();

// Cancelled bookings
$stmt = $conn->prepare("SELECT COUNT(*) FROM ride_bookings WHERE driver_id = ? AND status='cancelled'");
$stmt->bind_param("i", $driver_id);
$stmt->execute();
$stmt->bind_result($cancelled);
$stmt->fetch();
$stmt->close();

// Earnings
$stmt = $conn->prepare("SELECT IFNULL(SUM(fare_estimate),0) FROM ride_bookings WHERE driver_id = ? AND status='finished'");
$stmt->bind_param("i", $driver_id);
$stmt->execute();
$stmt->bind_result($earnings);
$stmt->fetch();
$stmt->close();

// Calculate Pending bookings
$pending = $totalBookings - ($completed + $cancelled);
?>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">

    <div class="bg-white rounded-xl shadow p-4 flex flex-col justify-between">
        <div>
            <p class="text-gray-500 font-medium">Total Bookings</p>
            <h2 class="text-2xl font-bold text-gray-800"><?= $totalBookings ?></h2>
        </div>
        <span class="text-blue-500 font-semibold mt-2">🚗</span>
    </div>

    <div class="bg-white rounded-xl shadow p-4 flex flex-col justify-between">
        <div>
            <p class="text-gray-500 font-medium">Completed</p>
            <h2 class="text-2xl font-bold text-gray-800"><?= $completed ?></h2>
        </div>
        <span class="text-blue-600 font-semibold mt-2">✅</span>
    </div>

    <div class="bg-white rounded-xl shadow p-4 flex flex-col justify-between">
        <div>
            <p class="text-gray-500 font-medium">Cancelled</p>
            <h2 class="text-2xl font-bold text-gray-800"><?= $cancelled ?></h2>
        </div>
        <span class="text-red-500 font-semibold mt-2">❌</span>
    </div>

    <div class="bg-white rounded-xl shadow p-4 flex flex-col justify-between">
        <div>
            <p class="text-gray-500 font-medium">Earnings</p>
            <h2 class="text-2xl font-bold text-gray-800">₱<?= number_format($earnings, 2) ?></h2>
        </div>
        <span class="text-indigo-500 font-semibold mt-2">💰</span>
    </div>

</div>

<div class="bg-white rounded-xl shadow p-6">
    <h3 class="text-gray-700 font-semibold mb-4">Booking Status Breakdown</h3>
    
    <div class="flex justify-center">
        <div class="max-w-sm w-full"> 
            <canvas id="driverStatsChart"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('driverStatsChart');

new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ['Completed', 'Cancelled', 'Pending'],
        datasets: [{
            label: 'Bookings',
            data: [
                <?= $completed ?>,
                <?= $cancelled ?>,
                <?= $pending ?> 
            ],
            backgroundColor: [
                '#3b82f6', 
                '#ef4444', 
                '#9ca3af'  
            ],
            borderColor: '#ffffff',
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        aspectRatio: 1,
        plugins: {
            legend: { 
                position: 'bottom' 
            },
            tooltip: { enabled: true }
        },
        cutout: '70%' 
    }
});
</script>