<?php
session_start();
include '../student_session.php';
include '../db/db.php';
$student_id = $_SESSION['student_id']; 
$sql_student = "SELECT * FROM students WHERE id = '$student_id'";
$result_student = $conn->query($sql_student);

if ($result_student->num_rows > 0) {
    $row_student = $result_student->fetch_assoc();
    $student_name = $row_student['first_name'] . ' ' . $row_student['last_name'];
} else {
    header("Location: ../student_login.php");
    exit;
}

$sql_count_present = "SELECT COUNT(*) AS present_count FROM attendance WHERE student_id = '$student_id' AND status = 'Present'";
$sql_count_absent = "SELECT COUNT(*) AS absent_count FROM attendance WHERE student_id = '$student_id' AND status = 'Absent'";

$result_present = $conn->query($sql_count_present);
$result_absent = $conn->query($sql_count_absent);

$present_count = 0;
$absent_count = 0;

if ($result_present->num_rows > 0) {
    $row_present = $result_present->fetch_assoc();
    $present_count = $row_present['present_count'];
}

if ($result_absent->num_rows > 0) {
    $row_absent = $result_absent->fetch_assoc();
    $absent_count = $row_absent['absent_count'];
}
$sql_attendance = "SELECT attendance.*, class.class_name 
                   FROM attendance 
                   INNER JOIN students ON attendance.student_id = students.id 
                   INNER JOIN class ON students.class_id = class.id 
                   WHERE attendance.student_id = '$student_id' 
                   ORDER BY attendance.date DESC";

$result_attendance = $conn->query($sql_attendance);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/searchbar.css">
    <title>Attendance Monitoring</title>
</head>
<body>

    <?php include './sidebar/sidebar.php'; ?>

<!-- CONTENT -->
<section id="content">
    <!-- NAVBAR -->
     <nav>
        <i class='bx bx-menu' ></i>
        <a href="#" class="nav-link">Student Panel</a>
        
        <form action="#">
            <div class="form-input">
                <input type="search" placeholder="Search..." hidden>
                <button type="submit" class="search-btn" style="display:none"><i class='bx bx-search' style="display:none"></i></button>
            </div>
        </form>
        <input type="checkbox" id="switch-mode" hidden>
        <label for="switch-mode" class="switch-mode"></label>
    </nav>
    <!-- NAVBAR -->

    <!-- MAIN -->
    <main>
        <div class="head-title">
            <div class="left">
                <h1>Dashboard</h1>
                <ul class="breadcrumb">
                    <li><a href="#">Dashboard</a></li>
                    <li><i class='bx bx-chevron-right'></i></li>
                    <li><a class="active" href="#"><?php echo $student_name; ?></a></li>
                </ul>
            </div>
            <a href="javascript:void(0);" id="exportBtn" class="btn-download">
                <i class="bx bxs-cloud-download"></i>
                <span class="text">Export Excel</span>
            </a>
        </div>

        <ul class="box-info">
            <li>
                <i class='bx bxs-group'></i>
                <span class="text">
                    <h3><?php echo $present_count; ?></h3>
                    <p>Days Present</p>
                </span>
            </li>
            <li>
                <i class='bx bxs-check-circle'></i>
                <span class="text">
                    <h3><?php echo $absent_count; ?></h3> 
                    <p>Days Absent</p>
                </span>
            </li>
        </ul>

        <div class="table-data">
            <div class="order">
                <div class="head">
                    <div class="today">
                        <h3>Your Attendance Record</h3>
                    </div>
                </div>
                <table id="attendanceTable">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Class</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result_attendance->num_rows > 0) {
                            while ($row_attendance = $result_attendance->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row_attendance['date'] . "</td>";
                                echo "<td>" . $row_attendance['class_name'] . "</td>";
                                echo "<td>" . $row_attendance['status'] . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='3'>No attendance records found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    <!-- MAIN -->
</section>
<!-- CONTENT -->

<script src="../assets/js/script.js"></script>
<script src="../assets/js/search.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>


</body>
</html>
<script>
//FUNCTION TO EXPORT FEATURE
document.getElementById("exportBtn").addEventListener("click", function() {
    var wb = XLSX.utils.book_new();

    var headerRow1 = ['Attendance Record'];
    var ws = XLSX.utils.aoa_to_sheet([headerRow1]);
    var emptyRow = [''];
    XLSX.utils.sheet_add_aoa(ws, [emptyRow], {origin: 'A2'});
    var headerRow2 = ['Date', 'Class', 'Status'];
    XLSX.utils.sheet_add_aoa(ws, [headerRow2], {origin: 'A3'});
    var records = [];
    var rows = document.querySelectorAll("#attendanceTable tbody tr");
    rows.forEach(row => {
        var date = row.cells[0].innerText;
        var className = row.cells[1].innerText;
        var status = row.cells[2].innerText;
        records.push([date, className, status]);
    });
    XLSX.utils.sheet_add_aoa(ws, records, {origin: 'A4'});
    const range = XLSX.utils.decode_range(ws['!ref']);
    for (let col = range.s.c; col <= range.e.c; col++) {
        let maxWidth = 0;
        for (let row = range.s.r; row <= range.e.r; row++) {
            const cellAddress = {r: row, c: col};
            const cell = ws[XLSX.utils.encode_cell(cellAddress)];
            if (cell && cell.v) {
                maxWidth = Math.max(maxWidth, String(cell.v).length);
            }
        }
        const column = XLSX.utils.encode_col(col);
        ws['!cols'] = ws['!cols'] || [];
        ws['!cols'][col] = {wch: maxWidth + 5};
    }
    XLSX.utils.book_append_sheet(wb, ws, 'Attendance Records');
    var wbout = XLSX.write(wb, {bookType: 'xlsx', bookSST: true, type: 'array'});
    var blob = new Blob([wbout], {bookType: 'xlsx', type: 'application/octet-stream'});
    var link = document.createElement("a");
    link.href = URL.createObjectURL(blob);
    link.download = "attendance_records.xlsx";
    link.click();
});

</script>
