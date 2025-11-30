<?php
session_start();
require 'db_connect.php'; 

if (isset($_POST['register_submit'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($name) || empty($email) || empty($password)) {
        $_SESSION['message'] = "<p class='error-message'>All fields are required.</p>";
        header('Location: register.php');
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $check_sql = "SELECT id FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $check_sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        $_SESSION['message'] = "<p class='error-message'>This email is already registered.</p>";
        header('Location: register.php');
        exit();
    }
    mysqli_stmt_close($stmt);

    $insert_sql = "INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $insert_sql);
    mysqli_stmt_bind_param($stmt, "sss", $name, $email, $hashed_password);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['message'] = "<p class='success-message'>Registration successful! Please log in.</p>";
        header('Location: login.php');
        exit();
    } else {
        error_log("Registration Error: " . mysqli_error($conn));
        $_SESSION['message'] = "<p class='error-message'>An error occurred during registration. Please try again.</p>";
        header('Location: register.php');
        exit();
    }
    mysqli_stmt_close($stmt);
}

// --- LOGIN LOGIC ---
if (isset($_POST['login_submit'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT id, full_name, password FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($user = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $user['password'])) {
        
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['full_name'];

            $update_sql = "UPDATE users SET last_login = NOW() WHERE id = ?";
            $update_stmt = mysqli_prepare($conn, $update_sql);
            mysqli_stmt_bind_param($update_stmt, "i", $user['id']);
            mysqli_stmt_execute($update_stmt);
            mysqli_stmt_close($update_stmt);

            header('Location: ./pages/dashboard.php');
            exit();
        } else {
            $_SESSION['message'] = "<p class='error-message'>Invalid email or password.</p>";
            header('Location: login.php');
            exit();
        }
    } else {
        $_SESSION['message'] = "<p class='error-message'>Invalid email or password.</p>";
        header('Location: login.php');
        exit();
    }
    mysqli_stmt_close($stmt);
}


// DRIVER's AUTH REGISTRATION

if (isset($_POST['driver_register_submit'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($name) || empty($email) || empty($password)) {
        $_SESSION['message'] = "<p class='error-message'>All fields are required.</p>";
        header('Location: driver_register.php');
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $check_sql = "SELECT driver_id FROM drivers WHERE email = ?";
    $stmt = mysqli_prepare($conn, $check_sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        $_SESSION['message'] = "<p class='error-message'>This email is already registered.</p>";
        header('Location: driver_register.php');
        exit();
    }
    mysqli_stmt_close($stmt);

    $insert_sql = "INSERT INTO drivers (full_name, email, password) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $insert_sql);
    mysqli_stmt_bind_param($stmt, "sss", $name, $email, $hashed_password);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['message'] = "<p class='success-message'>Driver registration successful! Please log in.</p>";
        header('Location: driver_login.php');
        exit();
    } else {
        $_SESSION['message'] = "<p class='error-message'>Error during registration.</p>";
        header('Location: driver_register.php');
        exit();
    }
}

// DRIVER's AUTH LOGIN

if (isset($_POST['driver_login_submit'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT driver_id, full_name, password FROM drivers WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($driver = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $driver['password'])) {

            $_SESSION['driver_id'] = $driver['driver_id'];
            $_SESSION['driver_name'] = $driver['full_name'];

            // Update login time
            $update_sql = "UPDATE drivers SET last_login = NOW() WHERE driver_id = ?";
            $up_stmt = mysqli_prepare($conn, $update_sql);
            mysqli_stmt_bind_param($up_stmt, "i", $driver['driver_id']);
            mysqli_stmt_execute($up_stmt);

            header('Location: ./driver/dashboard.php');
            exit();
        }
    }

    $_SESSION['message'] = "<p class='error-message'>Invalid email or password.</p>";
    header('Location: driver_login.php');
    exit();
}



mysqli_close($conn);
header('Location: login.php');
exit();
?>
