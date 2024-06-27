<?php
// Start session to access session variables
    session_start();
    include "../connection.php";

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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .profile-card {
            position: relative;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .profile-image {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border-radius: 50%;
            backgroundImage: norepet;
            border: 3px solid #fff; /* White border around the image */
            box-shadow: 0 0 10px rgba(0,0,0,0.1); /* Drop shadow */
        }
        .default-image-icon {
            font-size: 5rem;
            color: #888;
        }
        .upload-btn {
            display: block;
            margin-top: 10px;
        }
        .profile-content {
            padding: 20px;
        }
        .profile-content h1 {
            margin-bottom: 20px;
        }
        .profile-content p {
            font-size: 18px;
            line-height: 1.6;
            margin-bottom: 10px;
        }
        .change-info-btn {
            position: absolute;
            bottom: 10px;
            right: 10px;
        }
    </style>
</head>
<body>
    <?php include "navbar copy.html"; ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card profile-card">
                    <div class="card-header">
                        <h1 class="card-title">User Profile</h1>
                    </div>
                    <div class="card-body d-flex align-items-center">
                        <!-- Left side with user image or default icon -->
                        <div class="mr-4">
                            <?php if ($user && $user['coverimage']): ?>
                                <img src="../img/<?php echo htmlspecialchars($user['coverimage']); ?>" class="profile-image" alt="User Image">
                            <?php else: ?>
                                <i class="fas fa-user-circle default-image-icon"></i>
                            <?php endif; ?>
                        </div>
                        <!-- Right side with user information -->
                        <div>
                            <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
                            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                        </div>
                    </div>
                    <!-- Upload button if no image -->
                    <div class="card-footer d-flex justify-content-between align-items-center">
                        <a href="changeinformation.php?username=<?php echo urlencode($user['username']); ?>" class="btn btn-light">Change Information</a>
                        <a href="upload_image.php" class="btn btn-light upload-btn" style="display: <?php echo $user['coverimage'] ? '' : 'block'; ?>;">Upload Image</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</body>
</html>
