<?php
// Start session to access session variables
session_start();
include "connection.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userid = $_SESSION['user_id'];

    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
        $file_tmp = $_FILES['profile_image']['tmp_name'];
        $file_name = $_FILES['profile_image']['name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($file_ext, $allowed_ext)) {
            // Generate a unique file name
            $new_file_name = uniqid() . '.' . $file_ext;
            $destination = './img/' . $new_file_name;

            if (move_uploaded_file($file_tmp, $destination)) {
                // Update user's coverimage in the database
                $query = "UPDATE user SET coverimage = :coverimage WHERE userid = :userid";
                $stmt = $conn->prepare($query);
                $stmt->bindParam(':coverimage', $new_file_name);
                $stmt->bindParam(':userid', $userid);
                
                if ($stmt->execute()) {
                    header("Location: profile.php");
                    exit;
                } else {
                    echo "Failed to update profile image in database.";
                }
            } else {
                echo "Failed to move uploaded file.";
            }
        } else {
            echo "Invalid file type. Allowed types: " . implode(', ', $allowed_ext);
        }
    } else {
        echo "No file uploaded or upload error.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Profile Image</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php include "./package/NavBar.html"; ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h1 class="card-title">Upload Profile Image</h1>
                    </div>
                    <div class="card-body">
                        <form action="upload_image.php" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="profile_image">Choose Image</label>
                                <input type="file" class="form-control-file" id="profile_image" name="profile_image" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
