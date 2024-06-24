<?php
session_start();
include "connection.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

$admin = null;
if (isset($_SESSION['admin_id'])) {
    $adminid = $_SESSION['admin_id'];
    $query = "SELECT * FROM admin WHERE adminid = :adminid";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':adminid', $adminid);
    $stmt->execute();
    
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .profile-card {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <?php include "./package/NavBar.html"; ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card profile-card">
                    <h2>Admin Profile</h2>
                    <?php if ($admin): ?>
                        <p><strong>Username:</strong> <?php echo htmlspecialchars($admin['username']); ?></p>
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($admin['email']); ?></p>
                        <a href="edit_admin_profile.php" class="btn btn-primary">Edit Profile</a>
                    <?php else: ?>
                        <p>No admin profile found.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
