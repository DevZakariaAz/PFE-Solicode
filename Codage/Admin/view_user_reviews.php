<?php
include "../connection.php";

// Get the user ID from the URL
$userid = isset($_GET['userid']) ? intval($_GET['userid']) : 0;

// Fetch user details
$query_user = "SELECT * FROM user WHERE userid = :userid";
$stmt_user = $conn->prepare($query_user);
$stmt_user->bindParam(':userid', $userid, PDO::PARAM_INT);
$stmt_user->execute();
$user = $stmt_user->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "User not found!";
    exit;
}

// Fetch reviews written by the user
$query_reviews = "SELECT r.*, p.titre AS publication_title FROM review r JOIN publication p ON r.publicationid = p.publicationid WHERE r.userid = :userid";
$stmt_reviews = $conn->prepare($query_reviews);
$stmt_reviews->bindParam(':userid', $userid, PDO::PARAM_INT);
$stmt_reviews->execute();
$reviews = $stmt_reviews->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Reviews</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
    <!-- Custom CSS -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .content {
            margin-left: 270px; /* Width of the sidebar + margin */
            padding: 20px;
        }
        .reviews-header {
            margin-bottom: 30px;
            color: #333;
        }
        .reviews-header h2 {
            font-size: 32px;
            font-weight: bold;
        }
        .table {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .table thead th {
            background-color: #007bff;
            color: #fff;
        }
        .table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <?php include '../package/sidebar.html'; ?>

    <div class="content">
        <div class="reviews-header">
            <h2>Reviews by <?php echo htmlspecialchars($user['username']); ?></h2>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Review ID</th>
                        <th>Publication Title</th>
                        <th>Review Content</th>
                        <th>Rating</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reviews as $review): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($review['reviewid']); ?></td>
                            <td><?php echo htmlspecialchars($review['publication_title']); ?></td>
                            <td><?php echo htmlspecialchars($review['comment']); ?></td>
                            <td><?php echo htmlspecialchars($review['rating']); ?></td>
                            <td>
                                <a href="delete_review.php?id=<?php echo htmlspecialchars($review['reviewid']); ?>&userid=<?php echo htmlspecialchars($userid); ?>" class="btn btn-danger"><i class="fas fa-trash-alt"></i> Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
