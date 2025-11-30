<?php
session_start();

$message = $_SESSION['message'] ?? '';

unset($_SESSION['message']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TouRide Register</title>
    <link rel="stylesheet" href="./assets/css/register.css">
</head>
<body>

    <div class="auth-container">
        
        <div class="header-section">
            <img src="./assets/img/touride.png" alt="TouRide Logo" class="logo">
        </div>
        <h2 class="text-2xl font-bold text-gray-800 text-center header-title">
            Create Account
        </h2>

        <?php echo $message; ?>

        <form id="register-form" method="POST" action="auth_process.php">
            <h2 class="sr-only">Account Registration</h2>

            <div class="input-group">
                <label for="reg-name" class="text-sm font-medium text-gray-700 input-label">Full Name</label>
                <div class="input-wrapper">
                    <input type="text" id="reg-name" name="name" placeholder="John Doe"
                            class="input-field"
                            required>
                    <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
            </div>

            <div class="input-group">
                <label for="reg-email" class="text-sm font-medium text-gray-700 input-label">Email</label>
                <div class="input-wrapper">
                    <input type="email" id="reg-email" name="email" placeholder="john.doe@example.com"
                            class="input-field"
                            required>
                    <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
            </div>

       <div class="input-group" style="margin-bottom: 2rem;"> 
    <label for="reg-password" class="text-sm font-medium text-gray-700 input-label">Password</label>
    <div class="input-wrapper">
        <input type="password" id="reg-password" name="password" placeholder="••••••••"
                class="input-field password-input"
                required>
        <svg class="input-icon" fill="currentColor" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
            <path d="M 20 3 C 15.054688 3 11 7.054688 11 12 C 11 12.519531 11.085938 12.976563 11.15625 13.4375 L 3.28125 21.28125 L 3 21.59375 L 3 29 L 10 29 L 10 26 L 13 26 L 13 23 L 16 23 L 16 20.03125 C 17.179688 20.609375 18.554688 21 20 21 C 24.945313 21 29 16.945313 29 12 C 29 7.054688 24.945313 3 20 3 Z M 20 5 C 23.855469 5 27 8.144531 27 12 C 27 15.855469 23.855469 19 20 19 C 18.789063 19 17.542969 18.644531 16.59375 18.125 L 16.34375 18 L 14 18 L 14 21 L 11 21 L 11 24 L 8 24 L 8 27 L 5 27 L 5 22.4375 L 12.90625 14.5 L 13.28125 14.15625 L 13.1875 13.625 C 13.085938 13.023438 13 12.488281 13 12 C 13 8.144531 16.144531 5 20 5 Z M 22 8 C 20.894531 8 20 8.894531 20 10 C 20 11.105469 20.894531 12 22 12 C 23.105469 12 24 11.105469 24 10 C 24 8.894531 23.105469 8 22 8 Z"/>
        </svg>
        <button type="button" class="password-toggle-btn" onclick="togglePasswordVisibility('reg-password')">
            <svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
            </svg>
        </button>
    </div>
</div>

            <button type="submit" name="register_submit" class="btn-primary">
                Register Account
            </button>
        </form>

        <div class="toggle-section">
            <span class="text-gray-600">Already have an account?</span>
            <a href="login.php" class="touride-blue font-medium toggle-link">
                Login
            </a>
        </div>
    </div>

    <script>
        function togglePasswordVisibility(id) {
            const input = document.getElementById(id);
            if (input.type === 'password') {
                input.type = 'text';
            } else {
                input.type = 'password';
            }
        }
    </script>
</body>
</html>