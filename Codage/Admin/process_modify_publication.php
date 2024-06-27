<?php
session_start();
include "../connection.php";

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $publicationid = intval($_POST['publicationid']);
    $title = $_POST['title'];
    $description = $_POST['description'];
    $type = $_POST['type'];
    $location = $_POST['location'];
    $cuisineid = intval($_POST['cuisineid']);
    $cover_image = $_FILES['cover_image'];

    // Handle cover image upload if a new file is provided
    if ($cover_image['size'] > 0) {
        $target_dir = "img/";
        $target_file = $target_dir . basename($cover_image['name']);
        move_uploaded_file($cover_image['tmp_name'], $target_file);
        $cover_image_name = basename($cover_image['name']);
    } else {
        // If no new cover image is provided, keep the old one
        $cover_image_name = null;
    }

    // Update publication in the database
    $query = "UPDATE publication SET titre = :title, description = :description, type = :type, location = :location, cuisineid = :cuisineid";
    if ($cover_image_name) {
        $query .= ", coverimage = :cover_image";
    }
    $query .= " WHERE publicationid = :publicationid";
    
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':type', $type);
    $stmt->bindParam(':location', $location);
    $stmt->bindParam(':cuisineid', $cuisineid);
    if ($cover_image_name) {
        $stmt->bindParam(':cover_image', $cover_image_name);
    }
    $stmt->bindParam(':publicationid', $publicationid, PDO::PARAM_INT);
    
    if ($stmt->execute()) {
        header("Location: admin_publications.php");
    } else {
        echo "Error updating publication!";
    }
}
?>
