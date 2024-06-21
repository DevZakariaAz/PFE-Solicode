<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Page</title>
    <link rel="stylesheet" href="./Style/SignUp.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <section class="signup-section">
        <div class="container">
            <div class="left-side">
                <blockquote class="quote">
                    <h3>"The <span class="highlight">essence</span> of existence lies in <br> embracing <span class="highlight">the mysteries</span> of our journey."</h3>
                    <footer>- Steve Jobs</footer>
                </blockquote>
                <div class="logo">
                    <img src="./img/LogoTnagorroco.png" alt="Logo">
                </div>
            </div>
            <div class="right-side">
                <form class="signup-form" action="signup.php" method="post" enctype="multipart/form-data">
                    <h2>Sign Up</h2>
                    <div class="form-group">
                        <label for="email"><i class="fas fa-envelope"></i></label>
                        <input type="email" id="email" name="email" placeholder="Your email" required>
                    </div>
                    <div class="form-group">
                        <label for="username"><i class="fas fa-user"></i></label>
                        <input type="text" id="username" name="username" placeholder="User name" required>
                    </div>
                    <div class="form-group">
                        <label for="password"><i class="fas fa-key"></i></label>
                        <input type="password" id="password" name="password" placeholder="Password" required>
                    </div>
                    <div class="form-group">
                        <label for="repeat-password"><i class="fas fa-key"></i></label>
                        <input type="password" id="repeat-password" name="repeat-password" placeholder="Repeat Password" required>
                    </div>
                    <button type="submit" class="btn">Sign Up</button>
                </form>
                <p>Already have an account? <a href="Login.php">Log in</a></p>
            </div>
        </div>
    </section>
</body>
</html>
<?php
// Start the session
session_start();

// Include database connection
include 'connection.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $repeat_password = trim($_POST['repeat-password']);

    // Basic validation
    if (empty($email) || empty($username) || empty($password) || empty($repeat_password)) {
        echo "All fields are required.";
        exit;
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit;
    }

    // Check if passwords match
    if ($password !== $repeat_password) {
        echo "Passwords do not match.";
        exit;
    }

    // Check for password strength (example: minimum 6 characters)
    if (strlen($password) < 6) {
        echo "Password must be at least 6 characters long.";
        exit;
    }

    // Hash the password for security
    // $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if the email already exists
    $checkQuery = "SELECT COUNT(*) FROM user WHERE email = :email";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $emailExists = $stmt->fetchColumn();

    if ($emailExists > 0) {
        echo "Email is already registered.";
        exit;
    }

    // Prepare SQL query to insert the user into the database
    $query = "INSERT INTO user (email, username, password) VALUES (:email, :username, :password)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);

    // Execute the query and check for success
    if ($stmt->execute()) {
        // Registration success, redirect to login page
        header('Location: Login.php');
        exit();
    } else {
        // If the insertion fails, you can debug by checking the error information
        $errorInfo = $stmt->errorInfo();
        echo "Error: " . $errorInfo[2];
        exit;
    }
}
