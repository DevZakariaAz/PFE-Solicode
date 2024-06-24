<?php
include "./package/navbar.html";
include "connection.php";
session_start(); // Start the session

// Check if the user session exists and get user ID
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

// Redirect to login if user is not logged in
if (empty($user_id)) {
    header('Location: login.php');
    exit(); // Exit to prevent further script execution
}

// Check if a publication ID is provided in the URL
if (isset($_GET['publicationid'])) {
    $publicationid = intval($_GET['publicationid']);

    $query = "
    SELECT 
        p.titre, 
        p.description, 
        p.coverimage, 
        AVG(r.rating) as average_rating
    FROM 
        publication p
    LEFT JOIN 
        review r ON p.publicationid = r.publicationid
    WHERE 
        p.publicationid = :publicationid
    GROUP BY 
        p.publicationid";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':publicationid', $publicationid, PDO::PARAM_INT);
    $stmt->execute();

    $restaurant = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    // Handle the case where publicationid is not provided
    die("Publication ID is missing.");
}

function fetchReviews($conn, $publicationid) {
    $query = "SELECT r.comment, r.rating, u.username, u.coverimage, r.userid 
              FROM review r
              JOIN user u ON r.userid = u.userid
              WHERE r.publicationid = :publicationid";
    
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':publicationid', $publicationid, PDO::PARAM_INT);
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fetch reviews
$reviews = fetchReviews($conn, $publicationid);

// Handle review form submission
$alertMessage = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_review'])) {
    $rating = intval($_POST['rating']);
    $comment = $_POST['comment'];

    if ($rating >= 1 && $rating <= 5 && !empty($comment)) {
        $insertQuery = "INSERT INTO review (rating, comment, userid, publicationid) VALUES (:rating, :comment, :userid, :publicationid)";
        
        $insertStmt = $conn->prepare($insertQuery);
        $insertStmt->bindParam(':rating', $rating, PDO::PARAM_INT);
        $insertStmt->bindParam(':comment', $comment, PDO::PARAM_STR);
        $insertStmt->bindParam(':userid', $user_id, PDO::PARAM_INT);
        $insertStmt->bindParam(':publicationid', $publicationid, PDO::PARAM_INT);
        
        if ($insertStmt->execute()) {
            $alertMessage = '<div class="alert alert-success" role="alert">Review submitted successfully!</div>';
            // Refresh reviews
            $reviews = fetchReviews($conn, $publicationid);
        } else {
            $alertMessage = '<div class="alert alert-danger" role="alert">Failed to submit review. Please try again.</div>';
        }
    } else {
        $alertMessage = '<div class="alert alert-warning" role="alert">Please provide a valid rating and comment.</div>';
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Design Your Dream</title>
    <link rel="stylesheet" href="./Style/about.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@400;700&display=swap">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" crossorigin="anonymous">
    <style>
        .delete-btn {
            background: none;
            border: none;
            color: red;
            cursor: pointer;
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <section class="about-section">
        <div class="about-card">
            <h2>About</h2>
            <h3><?php echo htmlspecialchars($restaurant['titre']); ?></h3>
            <p><?php echo htmlspecialchars($restaurant['description']); ?></p>
            <div class="rating">
                <?php
                $average_rating = round($restaurant['average_rating'], 1);
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
        <div class="about-image">
            <img src="./img/<?php echo htmlspecialchars($restaurant['coverimage']); ?>" alt="<?php echo htmlspecialchars($restaurant['titre']); ?>">
            <div class="image-caption">
                <p><?php echo htmlspecialchars($restaurant['titre']); ?> - Average Rating: <?php echo $average_rating; ?> stars</p>
            </div>
        </div>
    </section>

 <section class="steps-section">
    <h2>Exploring International Cuisine</h2>
    <div class="steps-container">
        <div class="step">
            <div class="step-icon"><i class="fas fa-globe"></i></div>
            <div class="step-details">
                <p>Embark on a culinary adventure across the globe by exploring international cuisine. Immerse yourself in the rich flavors and diverse dishes that span continents, from savory street food to exquisite fine dining experiences.</p>
            </div>
        </div>
        <div class="step">
            <div class="step-icon"><i class="fas fa-utensils"></i></div>
            <div class="step-details">
                <p>Celebrate the art of cooking as you learn about different culinary techniques and traditions. Collaborate with chefs and fellow food enthusiasts to expand your palate and refine your culinary skills.</p>
            </div>
        </div>
        <div class="step">
            <div class="step-icon"><i class="fas fa-heart"></i></div>
            <div class="step-details">
                <p>Indulge in the joy of selecting and savoring the best dishes from around the world. Whether it's mastering the perfect pasta dish from Italy or sampling spicy street food from Thailand, let international cuisine inspire your culinary journey.</p>
            </div>
        </div>
    </div>
</section>


    <!-- Display Alert Messages -->
    <?php echo $alertMessage; ?>

    <!-- Review Submission Form -->
    <section class="review-section">
        <h2>Submit Your Review</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="rating">Rating:</label>
                <select name="rating" id="rating" class="form-control" required>
                    <option value="1">&#9733;</option>
                    <option value="2">&#9733;&#9733;</option>
                    <option value="3">&#9733;&#9733;&#9733;</option>
                    <option value="4">&#9733;&#9733;&#9733;&#9733;</option>
                    <option value="5">&#9733;&#9733;&#9733;&#9733;&#9733;</option>
                </select>
            </div>
            <div class="form-group">
                <label for="comment">Comment:</label>
                <textarea name="comment" id="comment" class="form-control" rows="2" required></textarea>
            </div>
            <button type="submit" name="submit_review" class="btn btn-light">Submit Review</button>
        </form>
    </section>

    <!-- Reviews Section -->
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
                            <?php if ($review['userid'] === $user_id) : ?>
                                <form method="POST" action="">
                                    <!-- <input type="hidden" name="review_id" value="<?php echo $review['reviewid']; ?>"> -->
                                    <!-- <button type="submit" name="delete_review" class="delete-btn"><i class="fas fa-trash-alt"></i> Delete</button> -->
                                </form>
                            <?php endif; ?>
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
    
</body>
            <?php include "./package/footer.html"; ?>

<script>
   document.addEventListener('DOMContentLoaded', function() {
    const likeButtons = document.querySelectorAll('.like-btn');
    const replyButtons = document.querySelectorAll('.reply-btn');

    likeButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Change the color of the button to red
            button.style.color = 'red';
            alert('You want to like this review!');
        });
    });

    replyButtons.forEach(button => {
    button.addEventListener('click', function() {
        alert('You want to reply to this review! This action is intended for admin review.');
    });
});

});

    </script>
</html>
