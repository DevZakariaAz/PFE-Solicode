<?php
session_start();
include "connection.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

$admin = null;
$update_success = false;

if (isset($_SESSION['admin_id'])) {
    $adminid = $_SESSION['admin_id'];
    $query = "SELECT * FROM admin WHERE adminid = :adminid";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':adminid', $adminid);
    $stmt->execute();
    
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'];
        $email = $_POST['email'];

        // Update admin details
        $query = "UPDATE admin SET username = :username, email = :email WHERE adminid = :adminid";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':adminid', $adminid);

        if ($stmt->execute()) {
            $update_success = true;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Admin Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php include "./package/NavBar.html"; ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h2>Edit Admin Profile</h2>
                    </div>
                    <div class="card-body">
                        <?php if ($update_success): ?>
                            <div class="alert alert-success">Profile updated successfully.</div>
                        <?php endif; ?>

                        <?php if ($admin): ?>
                            <form action="edit_admin_profile.php" method="post">
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($admin['username']); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($admin['email']); ?>" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                        <?php else: ?>
                            <p>No admin profile found.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
