<?php
require_once('../db_connect.php'); 

if (!isset($conn)) {
    echo '<div class="p-4 bg-red-100 text-red-700 rounded-lg">Error: Database connection not established. Check ../db_connect.php</div>';
    return;
}
if (!isset($_SESSION['driver_id'])) {
    echo '<div class="p-4 bg-red-100 text-red-700 rounded-lg">Error: Driver session not found.</div>';
    return;
}

$driverId = $_SESSION['driver_id'];

function fetchOverallSummary($conn, $driverId) {
    $sql = "
        SELECT 
            IFNULL(SUM(fare_estimate), 0) AS total_earnings,
            COUNT(booking_id) AS total_rides
        FROM ride_bookings
        WHERE driver_id = ? AND status = 'finished'
    ";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $driverId);
    $stmt->execute();
    $result = $stmt->get_result();
    $summary = $result->fetch_assoc();
    $stmt->close();
    return $summary;
}

function fetchMonthlyBreakdown($conn, $driverId) {
    $sql = "
        SELECT 
            DATE_FORMAT(pickup_date, '%Y-%m') AS month_year,
            SUM(fare_estimate) AS monthly_earnings,
            COUNT(booking_id) AS monthly_rides
        FROM ride_bookings
        WHERE driver_id = ? AND status = 'finished'
        GROUP BY month_year
        ORDER BY month_year DESC
        LIMIT 6
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $driverId);
    $stmt->execute();
    $result = $stmt->get_result();
    $breakdown = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $breakdown;
}

function fetchRecentTrips($conn, $driverId, $limit = 10) {
    $sql = "
        SELECT 
            rb.booking_id, 
            rb.pickup_date, 
            rb.pickup_time, 
            rb.fare_estimate, 
            rb.pickup_location,
            u.full_name AS user_name
        FROM ride_bookings rb
        JOIN users u ON rb.user_id = u.id
        WHERE rb.driver_id = ? AND rb.status = 'finished'
        ORDER BY rb.pickup_date DESC, rb.pickup_time DESC
        LIMIT ?
    ";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $driverId, $limit);
    $stmt->execute();
    $result = $stmt->get_result();
    $trips = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $trips;
}

$summary = fetchOverallSummary($conn, $driverId);
$monthlyBreakdown = fetchMonthlyBreakdown($conn, $driverId);
$recentTrips = fetchRecentTrips($conn, $driverId);

?>

<div class="container mx-auto">
    <h2 class="text-3xl font-extrabold text-gray-900 mb-8">Driver Earnings Summary</h2>

    <!-- Earnings Overview Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
        
        <!-- Card 1: Total Earnings -->
        <div class="bg-white p-6 rounded-2xl shadow-xl border-l-4 border-green-500">
            <div class="flex items-center">
                <span class="material-symbols-outlined text-4xl text-green-500 mr-4">payments</span>
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase">Total Lifetime Earnings</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">
                        ₱<?= number_format($summary['total_earnings'], 2) ?>
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Card 2: Total Rides Completed -->
        <div class="bg-white p-6 rounded-2xl shadow-xl border-l-4 border-blue-500">
            <div class="flex items-center">
                <span class="material-symbols-outlined text-4xl text-blue-500 mr-4">local_taxi</span>
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase">Rides Completed</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">
                        <?= number_format($summary['total_rides']) ?>
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Card 3: Average Fare (Simple Calculation) -->
        <div class="bg-white p-6 rounded-2xl shadow-xl border-l-4 border-indigo-500">
            <div class="flex items-center">
                <span class="material-symbols-outlined text-4xl text-indigo-500 mr-4">trending_up</span>
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase">Average Fare</p>
                    <?php 
                        $avgFare = $summary['total_rides'] > 0 
                            ? $summary['total_earnings'] / $summary['total_rides'] 
                            : 0;
                    ?>
                    <p class="text-3xl font-bold text-gray-900 mt-1">
                        ₱<?= number_format($avgFare, 2) ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Monthly Breakdown & Chart Area -->
    <div class="bg-white p-6 md:p-8 rounded-2xl shadow-lg mb-12">
        <h3 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center">
            <span class="material-symbols-outlined text-3xl mr-3 text-red-500">calendar_month</span>
            Last 6 Months Earnings Trend
        </h3>
        
        <?php if (!empty($monthlyBreakdown)): ?>
          
            <div class="flex items-end h-64 border-b border-l border-gray-200 mb-4">
                <?php
                $maxEarnings = 0;
                foreach ($monthlyBreakdown as $month) {
                    $maxEarnings = max($maxEarnings, $month['monthly_earnings']);
                }
            
                $monthlyBreakdown = array_reverse($monthlyBreakdown);
                
                foreach ($monthlyBreakdown as $month):
                    $height = ($maxEarnings > 0) 
                        ? round(($month['monthly_earnings'] / $maxEarnings) * 90) + 10 
                        : 0;
                    $monthLabel = date('M', strtotime($month['month_year'] . '-01'));
                ?>
                    <div class="flex-1 flex flex-col items-center justify-end h-full px-2 group">
                        <div 
                            class="bg-blue-500 w-8 rounded-t-lg transition-all duration-300 ease-in-out hover:bg-blue-600 relative" 
                            style="height: <?= $height ?>%;"
                            data-earnings="₱<?= number_format($month['monthly_earnings'], 0) ?>">
                             <!-- Tooltip/Label on hover -->
                             <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 p-1 text-xs font-bold text-white bg-gray-800 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                                ₱<?= number_format($month['monthly_earnings'], 0) ?>
                             </span>
                        </div>
                        <span class="text-sm text-gray-600 mt-2"><?= $monthLabel ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        
            <ul class="divide-y divide-gray-100 mt-8">
                <?php 
                $monthlyBreakdown = array_reverse($monthlyBreakdown);
                foreach ($monthlyBreakdown as $month): 
                ?>
                    <li class="flex justify-between items-center py-3">
                        <span class="text-lg font-medium text-gray-700">
                            <?= date('F Y', strtotime($month['month_year'] . '-01')) ?>
                        </span>
                        <div class="text-right">
                            <span class="text-xl font-bold text-green-600">
                                ₱<?= number_format($month['monthly_earnings'], 2) ?>
                            </span>
                            <span class="text-sm text-gray-500 block">
                                (<?= $month['monthly_rides'] ?> rides)
                            </span>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <div class="text-center py-8 text-gray-500">
                <span class="material-symbols-outlined text-6xl mb-3 text-red-300">work_history</span>
                <p class="font-semibold text-xl">No Ride History Yet</p>
                <p>Complete your first ride to see your earning trends here!</p>
            </div>
        <?php endif; ?>
    </div>


    <!-- Recent Completed Trips Table -->
    <div class="bg-white p-6 md:p-8 rounded-2xl shadow-lg">
        <h3 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center">
            <span class="material-symbols-outlined text-3xl mr-3 text-yellow-600">receipt_long</span>
            Recent Completed Trips (Last <?= count($recentTrips) ?>)
        </h3>
        
        <?php if (!empty($recentTrips)): ?>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Booking ID
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Date & Time
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Customer
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Pickup Location
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Fare
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        <?php foreach ($recentTrips as $trip): ?>
                        <tr class="hover:bg-gray-50 transition duration-100">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-blue-600">
                                #<?= htmlspecialchars($trip['booking_id']) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900"><?= date('M d, Y', strtotime($trip['pickup_date'])) ?></div>
                                <div class="text-xs text-gray-500"><?= date('h:i A', strtotime($trip['pickup_time'])) ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                <?= htmlspecialchars($trip['user_name']) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                <?= htmlspecialchars($trip['pickup_location']) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-extrabold text-right text-green-700">
                                ₱<?= number_format($trip['fare_estimate'], 2) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center py-8 text-gray-500">
                <p>No completed trips to display in the history.</p>
            </div>
        <?php endif; ?>
    </div>

</div>