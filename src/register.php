<?php
session_start();
include('./db/db.php');

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    if ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("sss", $username, $email, $hashed_password);
            if ($stmt->execute()) {
                header("Location: login.php");
                exit;
            } else {
                $error = "Error: " . $stmt->error;
            }

            $stmt->close();
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        :root {
            --poppins: 'Poppins', sans-serif;
            --lato: 'Lato', sans-serif;

            --light: #F9F9F9;
            --blue: #3C91E6;
            --light-blue: #CFE8FF;
            --grey: #EEEEEE;
            --dark-grey: #AAAAAA;
            --dark: #342E37;
            --red: #DB504A;
        }

        body {
            font-family: var(--lato);
            background-color: var(--grey);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .register-container {
            background: var(--light);
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 350px;
        }

        .register-container h1 {
            font-size: 1.8rem;
            margin-bottom: 1rem;
            color: var(--dark);
        }

        .register-container input[type="email"], 
        .register-container input[type="password"],
        .register-container input[type="text"] {
            width: 100%;
            padding: 10px;
            margin: 0.5rem 0;
            border: 1px solid var(--grey);
            border-radius: 5px;
            font-size: 1rem;
            background: var(--light);
            color: var(--dark);
        }

        .register-container button {
            background: var(--blue);
            color: var(--light);
            border: none;
            padding: 10px 20px;
            font-size: 1rem;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            transition: background 0.3s ease;
        }

        .register-container button:hover {
            background: var(--light-blue);
            color: var(--blue);
        }

        .register-container .error {
            color: var(--red);
            font-size: 0.9rem;
            margin-top: 1rem;
        }

        .register-container p {
            margin-top: 1rem;
            font-size: 0.9rem;
            color: var(--dark-grey);
        }

        .register-container p a {
            color: var(--blue);
            text-decoration: none;
            font-weight: 500;
        }

        .register-container p a:hover {
            text-decoration: underline;
            color: var(--dark);
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h1>Register as Admin</h1>
        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="post" autocomplete="off">
            <input type="text" name="username" placeholder="Username" required autocomplete="new-username" />
            <input type="email" name="email" placeholder="Email" required autocomplete="new-email" />
            <input type="password" name="password" placeholder="Password" required autocomplete="new-password" />
            <input type="password" name="confirm_password" placeholder="Confirm Password" required autocomplete="new-password" />
            <button type="submit" name="register">Register</button>
        </form>

        <p>Already have an account? <a href="login.php">Login</a></p>
    </div>
</body>
</html>
