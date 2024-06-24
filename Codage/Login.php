<?php
session_start();
include 'connection.php'; // Include the database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        // Check if the credentials match a user
        $query = "SELECT * FROM user WHERE email = :email";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($password == $user['password']) { // For simplicity, this example uses plain text passwords, but you should use password_hash() in production
                // Set session variables for user
                $_SESSION['user_id'] = $user['userid'];
                $_SESSION['user_name'] = $user['username']; // Store the user's name in the session
                $_SESSION['user_email'] = $user['email'];
                // Redirect to the main page
                header("Location: HomePage.php");
                exit;
            } else {
                $error_message = "Invalid password.";
            }
        } else {
            // Check if the credentials match an admin
            $query = "SELECT * FROM admin WHERE email = :email";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            if ($stmt->rowCount() == 1) {
                $admin = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($password == $admin['password']) { // For simplicity, this example uses plain text passwords, but you should use password_hash() in production
                    // Set session variables for admin
                    $_SESSION['admin_id'] = $admin['adminid'];
                    $_SESSION['admin_username'] = $admin['username']; // Store the admin's username in the session
                    $_SESSION['admin_email'] = $admin['email'];
                    // Redirect to the admin dashboard
                    header("Location: admin_dashboard.php");
                    exit;
                } else {
                    $error_message = "Invalid password.";
                }
            } else {
                $error_message = "No user or admin found with that email.";
            }
        }

    } catch (PDOException $e) {
        echo "Database query error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="./Style/SignUp.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <section class="login-section">
        <div class="container">
            <div class="left-side">
                <blockquote class="quote">
                    <h3>"The adventure awaits for those who <br><span class="highlight">believe</span> in the <span class="highlight">magic of their dreams</span>."</h3>
                    <footer>- Zakaria Azizi</footer>
                </blockquote>
                <div class="logo">
                    <img src="./img/LogoTnagorroco.png" alt="Logo">
                </div>
            </div>
            <div class="right-side">
                <form class="login-form" action="login.php" method="POST">
                    <h2>Login</h2>
                    <?php if (isset($error_message)): ?>
                        <div class="alert alert-danger"><?php echo $error_message; ?></div>
                    <?php endif; ?>
                    <div class="form-group">
                        <label for="email"><i class="fas fa-envelope"></i></label>
                        <input type="email" id="email" name="email" placeholder="Your email" required>
                    </div>
                    <div class="form-group">
                        <label for="password"><i class="fas fa-key"></i></label>
                        <input type="password" id="password" name="password" placeholder="Password" required>
                    </div>
                    <button type="submit" class="btn">Login</button>
                </form>
                <p>Don't have an account? <a href="signup.php">Sign up</a></p>
            </div>
        </div>
    </section>
</body>
</html>
