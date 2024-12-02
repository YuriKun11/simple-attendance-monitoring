<?php
session_start();
include('./db/db.php');

if (isset($_POST['login'])) {
    $email = $_POST['email']; 
    $password = $_POST['password'];
    $sql_user = "SELECT * FROM users WHERE email = '$email'";
    $result_user = $conn->query($sql_user);

    if ($result_user->num_rows > 0) {
        $row_user = $result_user->fetch_assoc();
        if (password_verify($password, $row_user['password'])) {
            $_SESSION['user_id'] = $row_user['id'];
            header('Location: admin/dashboard.php');
        } else {
            $error = "Invalid email or password!";
        }
    } else {
        $sql_student = "SELECT * FROM students WHERE student_id = '$email'";
        $result_student = $conn->query($sql_student);

        if ($result_student->num_rows > 0) {
          
            $row_student = $result_student->fetch_assoc();
           
            $default_password = $row_student['last_name'] . substr($row_student['phone_number'], -4);

            if ($password == $default_password) {
                $_SESSION['student_id'] = $row_student['id'];
                header('Location: student/dashboard.php');
            } else {
                $error = "Invalid student ID or password!";
            }
        } else {
            $error = "Invalid student ID or password!";
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
.login-container input[type="text"] {
    width: 100%;
    padding: 10px;
    margin: 0.5rem 0;
    border: 1px solid var(--grey);
    border-radius: 5px;
    font-size: 1rem;
    background: var(--light);
    color: var(--dark);
    box-sizing: border-box; /* Ensures padding and border are included in the width */
}

.login-container input[type="text"]:focus,
.login-container input[type="password"]:focus,
.login-container input[type="email"]:focus {
    border-color: var(--blue); 
    background: var(--light-blue); 
    outline: none; 
}

.login-container button {
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
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Student Portal</h1>
        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="post">
            <input type="text" name="email" placeholder="Student ID" aria-label="Email" required>
            <input type="password" name="password" placeholder="Password" aria-label="Password" required>
            <button type="submit" name="login">Login</button>
        </form>
        <p>Your password is your Student ID and the last 4 digits of your phone number</p>
        <p>Example: Gallardo6366</p>
    </div>
</body>
</html>
