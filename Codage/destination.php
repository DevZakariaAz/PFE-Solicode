<?php
include "connection.php";

// Get the destination ID from the URL
$destination_id = isset($_GET['id']) ? $_GET['id'] : 1;

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
$stmt->bindParam(':destination_id', $destination_id);
$stmt->execute();

// Fetch the destination details
$destination = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo htmlspecialchars($destination['titre']); ?> - Destination</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./Style/indexPage.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"
        integrity="sha384-Z65FFH9kCk3Upsh6zVeJT6zxy5bRB+8SM6RvDhhOdYJbCLs4qybrt1wrj5d9UJGh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@400;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .rating {
            color: gold;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg">
        <a class="navbar-brand" href="#">
            <img src="./img/LogoTnagorroco.png" width="180" height="auto" class="d-inline-block align-top" alt="Logo">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="#">about</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Restaurants</a></li>
                <li class="nav-item"><a class="nav-link" href="#">destination</a></li>
                <li class="nav-item"><a class="nav-link" href="#">blog</a></li>
                <li class="nav-item"><a class="nav-link" href="#">contact</a></li>
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
                        <img src="./img/<?php echo htmlspecialchars($destination['coverimage']); ?>" alt="<?php echo htmlspecialchars($destination['titre']); ?>">
                        <div class="image-caption">
                            <p><?php echo htmlspecialchars($destination['titre']); ?> - Average Rating: <?php echo $average_rating; ?> stars</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
