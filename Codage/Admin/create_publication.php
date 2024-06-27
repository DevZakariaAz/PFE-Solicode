<?php
session_start();
include "../connection.php";

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

// Fetch cuisines from database
$query_cuisines = "SELECT * FROM cuisine";
$stmt_cuisines = $conn->prepare($query_cuisines);
$stmt_cuisines->execute();
$cuisines = $stmt_cuisines->fetchAll(PDO::FETCH_ASSOC);

// Fetch types (you need to define your own type table structure and query)
$query_types = "SELECT DISTINCT type FROM publication";
$stmt_types = $conn->prepare($query_types);
$stmt_types->execute();
$types = $stmt_types->fetchAll(PDO::FETCH_COLUMN);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Publication</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .container { margin-top: 20px; }
        .form-group { margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Create New Publication</h2>
        <form action="process_create_publication.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" class="form-control" rows="4"></textarea>
            </div>
            <div class="form-group">
                <label for="type">Type:</label>
                <select id="type" name="type" class="form-control" required>
                    <option value="">Select Type</option>
                    <?php foreach ($types as $type): ?>
                        <option value="<?php echo htmlspecialchars($type); ?>"><?php echo htmlspecialchars($type); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="location">Location:</label>
                <input type="text" id="location" name="location" class="form-control">
            </div>
            <div class="form-group">
                <label for="cuisine">Cuisine:</label>
                <select id="cuisine" name="cuisineid" class="form-control">
                    <option value="">Select Cuisine</option>
                    <?php foreach ($cuisines as $cuisine): ?>
                        <option value="<?php echo htmlspecialchars($cuisine['cuisineid']); ?>"><?php echo htmlspecialchars($cuisine['description']); ?> (<?php echo htmlspecialchars($cuisine['nationalite']); ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="cover_image">Cover Image:</label>
                <input type="file" id="cover_image" name="cover_image" class="form-control-file">
            </div>
            <button type="submit" class="btn btn-primary">Create Publication</button>
            <button type="reset" class="btn btn-primary">Reset</button><br>
            <a href="admin_dashboard.php">Back to dashboard ?</a>
        </form>
    </div>
</body>
</html>
