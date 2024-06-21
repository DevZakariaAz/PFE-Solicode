<?php
include "connection.php";
session_start(); // Start the session

// Check if the user session exists
if (empty($_SESSION['user_id'])) {
    // If no session exists, redirect to the login page
    header('Location: login.php');
    exit(); // Exit to prevent further script execution
}

// Get the destination ID from the URL
$destination_id = isset($_GET['id']) ? intval($_GET['id']) : 1;

// Query to fetch destination details
$query = "
SELECT 
    p.publicationid, 
    p.titre, 
    p.description, 
    p.coverimage, 
    AVG(r.rating) as average_rating
FROM 
    publication p
LEFT JOIN 
    review r ON p.publicationid = r.publicationid
WHERE 
    p.publicationid = :destination_id
GROUP BY 
    p.publicationid";

$stmt = $conn->prepare($query);
$stmt->bindParam(':destination_id', $destination_id, PDO::PARAM_INT);
$stmt->execute();

// Fetch the destination details
$destination = $stmt->fetch(PDO::FETCH_ASSOC);

function fetchReviews($conn, $publicationid) {
    $query = "SELECT r.comment, r.rating, u.username, u.coverimage 
              FROM review r
              JOIN user u ON r.userid = u.userid
              WHERE r.publicationid = :publicationid";
    
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':publicationid', $publicationid, PDO::PARAM_INT);
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fetch reviews
$reviews = fetchReviews($conn, $destination_id);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo htmlspecialchars($destination['titre']); ?> - Destination</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./Style/indexPage.css">
    <link rel="stylesheet" href="./Style/destination.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"
        integrity="sha384-Z65FFH9kCk3Upsh6zVeJT6zxy5bRB+8SM6RvDhhOdYJbCLs4qybrt1wrj5d9UJGh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@400;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
</head>

<body>
    <nav class="navbar navbar-expand-lg">
        <a class="navbar-brand" href="HomePage.php">
            <img src="./img/LogoTnagorroco.png" width="180" height="auto" class="d-inline-block align-top" alt="Logo">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="#">About</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Restaurants</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Destination</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Blog</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
            </ul>
        </div>
    </nav>

    <section class="destination-section py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="destination-card">
                        <h2><?php echo htmlspecialchars($destination['titre']); ?></h2>
                        <p><?php echo htmlspecialchars($destination['description']); ?></p>
                        <div class="rating">
                            <?php
                            $average_rating = round($destination['average_rating'], 1);
                            $filled_stars = round($average_rating);
                            $max_stars = 5;
                            for ($i = 0; $i < $filled_stars; $i++) {
                                echo "&#9733;"; // Filled star
                            }
                            for ($i = $filled_stars; $i < $max_stars; $i++) {
                                echo "&#9734;"; // Empty star
                            }
                            echo " ({$average_rating} / 5)";
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="destination-image">
                        <img src="./img/<?php echo htmlspecialchars($destination['coverimage']); ?>"
                            alt="<?php echo htmlspecialchars($destination['titre']); ?>">
                        <div class="image-caption">
                            <p><?php echo htmlspecialchars($destination['titre']); ?> - Average Rating:
                                <?php echo $average_rating; ?> stars</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="review-section">
        <h2>Reviews</h2>
        <div id="reviews-container">
            <?php foreach ($reviews as $review) : ?>
                <div class="review-item">
                    <img src="./img/<?php echo htmlspecialchars($review['coverimage']); ?>" alt="Avatar">
                    <div class="review-content">
                        <div class="review-header">
                            <h3><?php echo htmlspecialchars($review['username']); ?></h3>
                            <div class="rating">
                                <?php
                                $user_rating = intval($review['rating']);
                                for ($i = 0; $i < $user_rating; $i++) {
                                    echo "&#9733;"; // Filled star
                                }
                                for ($i = $user_rating; $i < 5; $i++) {
                                    echo "&#9734;"; // Empty star
                                }
                                ?>
                            </div>
                        </div>
                        <p><?php echo htmlspecialchars($review['comment']); ?></p>
                        <div class="review-actions">
                            <button class="like-btn"><i class="fas fa-thumbs-up"></i> Like</button>
                            <button class="reply-btn"><i class="fas fa-reply"></i> Reply</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
