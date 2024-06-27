<?php
session_start();
include "../connection.php";

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

// Get the publication ID from the URL
$publicationid = isset($_GET['publicationid']) ? intval($_GET['publicationid']) : 0;

// Fetch the publication details
$query = "SELECT * FROM publication WHERE publicationid = :publicationid";
$stmt = $conn->prepare($query);
$stmt->bindParam(':publicationid', $publicationid, PDO::PARAM_INT);
$stmt->execute();
$publication = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$publication) {
    echo "Publication not found!";
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
    <title>Modify Publication</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .container { margin-top: 20px; }
        .form-group { margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Modify Publication</h2>
        <form action="process_modify_publication.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="publicationid" value="<?php echo htmlspecialchars($publication['publicationid']); ?>">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" class="form-control" value="<?php echo htmlspecialchars($publication['titre']); ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" class="form-control" rows="4"><?php echo htmlspecialchars($publication['description']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="type">Type:</label>
                <select id="type" name="type" class="form-control" required>
                    <option value="">Select Type</option>
                    <?php foreach ($types as $type): ?>
                        <option value="<?php echo htmlspecialchars($type); ?>" <?php if ($type == $publication['type']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($type); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="location">Location:</label>
                <input type="text" id="location" name="location" class="form-control" value="<?php echo htmlspecialchars($publication['location']); ?>">
            </div>
            <div class="form-group">
                <label for="cuisine">Cuisine:</label>
                <select id="cuisine" name="cuisineid" class="form-control">
                    <option value="">Select Cuisine</option>
                    <?php foreach ($cuisines as $cuisine): ?>
                        <option value="<?php echo htmlspecialchars($cuisine['cuisineid']); ?>" <?php if ($cuisine['cuisineid'] == $publication['cuisineid']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($cuisine['description']); ?> (<?php echo htmlspecialchars($cuisine['nationalite']); ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="cover_image">Cover Image:</label>
                <input type="file" id="cover_image" name="cover_image" class="form-control-file">
                <?php if ($publication['coverimage']): ?>
                    <img src="./img/<?php echo htmlspecialchars($publication['coverimage']); ?>" alt="Current Cover Image" width="150" height="150">
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
            <a href="admin_publications.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>
