<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Monitoring System</title>
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
            flex-direction: column;
        }

        .landing-container {
            background: var(--light);
            padding: 3rem;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 350px;
        }

        .landing-container h1 {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: var(--dark);
        }

        .button-container {
            margin-top: 2rem;
        }

        .landing-container button {
            width: 100%;
            padding: 10px;
            margin: 0.5rem 0;
            border: 1px solid var(--grey);
            border-radius: 5px;
            font-size: 1rem;
            background: var(--blue);
            color: var(--light);
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .landing-container button:hover {
            background: var(--light-blue);
            color: var(--blue);
        }

        .landing-container .error {
            color: var(--red);
            font-size: 0.9rem;
            margin-top: 1rem;
        }

        .landing-container p {
            margin-top: 1rem;
            font-size: 0.9rem;
            color: var(--dark-grey);
        }

        .landing-container p a {
            color: var(--blue);
            text-decoration: none;
            font-weight: 500;
        }

        .landing-container p a:hover {
            text-decoration: underline;
            color: var(--dark);
        }

        .login-links {
            display: flex;
            justify-content: center;
            gap: 20px;
        }
    </style>
</head>
<body>
    <div class="landing-container">
        <h1>Welcome to the Attendance Monitoring System</h1>
        <p>Choose your login type:</p>
        <div class="login-links">
            <a href="login.php">
                <button>Admin Login</button>
            </a>
            <a href="student_login.php">
                <button>Student Login</button>
            </a>
        </div>

    </div>
</body>
</html>
