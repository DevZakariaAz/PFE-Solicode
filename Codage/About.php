<?php
include "./package/navbar.html";
include "connection.php";

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
$reviews = fetchReviews($conn, $publicationid);
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
        <h2>Designing Your Dream in Three Simple Steps</h2>
        <div class="steps-container">
            <div class="step">
                <div class="step-icon">&#x2714;</div>
                <div class="step-details">
                    <h3>Start Project</h3>
                    <p>Embark on your design adventure by initiating your project. Share your vision and set the stage for a bespoke design experience.</p>
                </div>
            </div>
            <div class="step">
                <div class="step-icon">&#x2699;</div>
                <div class="step-details">
                    <h3>Craft</h3>
                    <p>Collaborate closely to achieve design excellence, refining your vision and crafting brilliance into every aspect of your space.</p>
                </div>
            </div>
            <div class="step">
                <div class="step-icon">&#x1F3A8;</div>
                <div class="step-details">
                    <h3>Choose the Best</h3>
                    <p>Finalize your design choices and select the best elements to bring your dream space to life.</p>
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
                             <h3><?php echo htmlspecialchars($review['username']); ?>    .</h3>
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
</body>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const likeButtons = document.querySelectorAll('.like-btn');
    const replyButtons = document.querySelectorAll('.reply-btn');

    likeButtons.forEach(button => {
        button.addEventListener('click', function() {
             alert('You want to like it this review!');
            // button.classList.toggle('active');
        });
    });

    replyButtons.forEach(button => {
        button.addEventListener('click', function() {
            alert('You want to reply to this review!');
        });
    });
});
</script>
</html>
