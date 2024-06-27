<?php
session_start();
include "../connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture form data
    $title = $_POST['title'];
    $description = $_POST['description'];

    // Handle file upload for cover image
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["cover_image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["cover_image"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["cover_image"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["cover_image"]["tmp_name"], $target_file)) {
            echo "The file ". htmlspecialchars( basename( $_FILES["cover_image"]["name"])). " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    // Insert publication into database
    $query = "INSERT INTO publication (titre, description, coverimage) VALUES (:title, :description, :coverimage)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':coverimage', $_FILES["cover_image"]["name"]); // Save the file name in the database

    if ($stmt->execute()) {
        // Redirect to a success page or back to dashboard
        header("Location: admin_dashboard.php");
        exit;
    } else {
        echo "Error inserting publication into database.";
    }
}
?>
