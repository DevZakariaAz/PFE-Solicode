<?php
session_start();
include 'connection.php'; // Include the database connection file

if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $searchTerm = '%' . $search . '%'; // Prepare for a LIKE query

    try {
        // Prepare the SQL query to search for destinations
        $query = "SELECT p.*, IFNULL(AVG(r.rating), 0) as average_rating
                  FROM publication p
                  LEFT JOIN ratings r ON p.publicationid = r.publicationid
                  WHERE p.type = 'destination' AND p.titre LIKE :searchTerm
                  GROUP BY p.publicationid";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':searchTerm', $searchTerm);
        $stmt->execute();

        // Fetch all matching destinations
        $destinations = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Database query error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Results</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .favorite-icon {
            padding: 10px;
            color: #f44336;
            cursor: pointer;
        }
        .rating {
            color: #FFD700;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Search Results for "<?php echo htmlspecialchars($search); ?>"</h2>
        <div class="row">
            <?php if (!empty($destinations)): ?>
                <?php foreach ($destinations as $destination): ?>
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <span class="favorite-icon position-absolute top-0 end-0">
                                <i class="far fa-heart" data-id="<?php echo htmlspecialchars($destination['publicationid']); ?>"></i>
                            </span>
                            <img src="./img/<?php echo htmlspecialchars($destination['coverimage']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($destination['titre']); ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($destination['titre']); ?></h5>
                                <div class="rating">
                                    <?php
                                    $max_stars = 5;
                                    $average_rating = round($destination['average_rating'], 1);
                                    $filled_stars = round($average_rating);
                                    for ($i = 0; $i < $filled_stars; $i++) {
                                        echo "&#9733;";
                                    }
                                    for ($i = $filled_stars; $i < $max_stars; $i++) {
                                        echo "&#9734;";
                                    }
                                    echo " ({$average_rating} / 5)";
                                    ?>
                                </div>
                                <a href="destination.php?id=<?php echo htmlspecialchars($destination['publicationid']); ?>" class="btn btn-link">View details <span class="arrow">→</span></a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No destinations found matching your search.</p>
            <?php endif; ?>
        </div>
        <a href="HomePage.php" class="btn btn-secondary mt-3">Back to Search</a>
    </div>
</body>
</html>
