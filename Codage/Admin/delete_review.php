<?php
include "../connection.php";

// Check if review ID is provided
if (!isset($_GET['id'])) {
    echo "No review ID provided!";
    exit;
}

// Get the review ID from the URL
$reviewid = intval($_GET['id']);

// Prepare the SQL query to delete the review
$query = "DELETE FROM review WHERE reviewid = :reviewid";
$stmt = $conn->prepare($query);
$stmt->bindParam(':reviewid', $reviewid, PDO::PARAM_INT);

// Execute the query
if ($stmt->execute()) {
    echo "Review deleted successfully!";
} else {
    echo "Failed to delete the review!";
}

// Redirect back to the previous page or a specific page
header("Location: view_user_reviews.php?userid=" . $_GET['userid']);
exit;
?>
    