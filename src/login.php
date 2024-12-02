<?php
session_start();
include('./db/db.php');

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $access_code = $_POST['access_code'];
    if ($access_code != 'DMMMSU') {
        $error = "Invalid access code!";
    } else {
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                $_SESSION['user_id'] = $row['id'];
                header('Location: admin/dashboard.php');
                exit();
            } else {
                $error = "Invalid email or password!";
            }
        } else {
            $error = "Invalid email or password!";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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

.login-container {
    background: var(--light);
    padding: 2rem;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    text-align: center;
    width: 350px;
}

.login-container h1 {
    font-size: 1.8rem;
    margin-bottom: 1rem;
    color: var(--dark);
}

.login-container input[type="email"],
.login-container input[type="password"],
.login-container input[type="text"],
.login-container button {
    width: 100%;
    padding: 10px;
    margin: 0.5rem 0;
    border: 1px solid var(--grey);
    border-radius: 5px;
    font-size: 1rem;
    background: var(--light);
    color: var(--dark);
}

.login-container button {
    background: var(--blue);
    color: var(--light);
    border: none;
    cursor: pointer;
    transition: background 0.3s ease;
}

.login-container button:hover {
    background: var(--light-blue);
    color: var(--blue);
}

.login-container .error {
    color: var(--red);
    font-size: 0.9rem;
    margin-top: 1rem;
}

.login-container p {
    margin-top: 1rem;
    font-size: 0.9rem;
    color: var(--dark-grey);
}

.login-container p a {
    color: var(--blue);
    text-decoration: none;
    font-weight: 500;
}

.login-container p a:hover {
    text-decoration: underline;
    color: var(--dark);
}

.login-container input[type="text"]:focus,
.login-container input[type="email"]:focus,
.login-container input[type="password"]:focus {
    border-color: var(--blue);
    outline: none;
}

    </style>
</head>
<body>
    <div class="login-container">
        <h1>Login</h1>
        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="post" autocomplete="off">
            <input type="text" name="access_code" placeholder="Access Code" aria-label="Access Code" required autocomplete="off">
            <input type="email" name="email" placeholder="Email" aria-label="Email" required autocomplete="off">
            <input type="password" name="password" placeholder="Password" aria-label="Password" required autocomplete="new-password">
            
            <button type="submit" name="login">Login</button>
        </form>


        <p>Don't have an account? <a href="register.php">Register</a></p>
    </div>
</body>
</html>
