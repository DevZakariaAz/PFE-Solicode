<?php
session_start();
include 'connection.php'; // Include the database connection file

// Redirect to login if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch user data based on session user ID
$user = null;
if (isset($_SESSION['user_id'])) {
    $userid = $_SESSION['user_id'];
    $query = "SELECT * FROM user WHERE userid = :userid";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':userid', $userid);
    $stmt->execute();
    
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userid = $_SESSION['user_id']; // Get user ID from session
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate inputs (basic validation for demonstration)
    if (empty($username)) {
        die("Username is required.");
    }
    if (empty($password)) {
        die("Password is required.");
    }
    if ($password !== $confirm_password) {
        die("Passwords do not match.");
    }

    try {
        // Hash the password for security (use password_hash() in production)
        // $hashed_password = md5($password); // For demonstration, use more secure methods in production

        // Prepare and execute query to update user information
        $query = "UPDATE user SET username = :username, password = :password WHERE userid = :userid";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':userid', $userid);
        $stmt->execute();

        // Redirect back to profile page or any other confirmation page
        header("Location: profile.php");
        exit;
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
    <title>Change Information</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h1 class="card-title">Change Information</h1>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="oldpassword">Old Password</label>
                                <input type="text" class="form-control" value="<?php echo htmlspecialchars($user['password']); ?>" disabled id="oldpassword" name="oldpassword" required>
                            </div>
                            <div class="form-group">
                                <label for="password">New Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="form-group">
                                <label for="confirm_password">Confirm New Password</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                            <a href="profile.php" class="btn btn-secondary">Cancel</a>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
