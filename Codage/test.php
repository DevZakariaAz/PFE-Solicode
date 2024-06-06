
<?php
$dbn = 'mysql:host=localhost;dbname=tangorocco_v1';
$user = 'root';
$pass = '';

$destinations = []; // Initialize $destinations as an empty array

try {
    $conn = new PDO($dbn, $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $type = 'destination';
    $limit = 3;

    $stmt = $conn->prepare("SELECT p.titre, p.description, p.coverimage, 
                                   IFNULL(AVG(r.rating), 0) AS average_rating
                            FROM publication p
                            LEFT JOIN review r ON p.publicationid = r.publicationid
                            WHERE p.type = :type
                            GROUP BY p.publicationid
                            ORDER BY average_rating DESC
                            LIMIT :limit");

    $stmt->bindParam(':type', $type, PDO::PARAM_STR);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();

    $destinations = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Featured Destinations</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<section class="featured-destination py-5">
    <div class="container">
        <h2 class="text-center mb-4">Featured Destinations</h2>
        <div class="cardsDst">
            <div class="row">
                <?php if (!empty($destinations)): ?>
                    <?php foreach ($destinations as $destination): ?>
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <img src="./img/<?php echo htmlspecialchars($destination['coverimage']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($destination['titre']); ?>">
                            <div class="card-body">
                                <h5 class="card-title"><i class="fa fa-map-marker"></i> <?php echo htmlspecialchars($destination['titre']); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($destination['description']); ?></p>
                                <p class="card-text rating"><i class="fa fa-star"></i> <?php echo round($destination['average_rating'], 1); ?></p>
                                <a href="#" class="btn btn-link">View more <span class="arrow">→</span></a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12">
                        <p class="text-center">No featured destinations available.</p>
                    </div>
                <?php endif; ?>
            </div>
            <div class="text-center">
                <a href="#" class="btn btn-secondary">Discover more destinations</a>
            </div>
        </div>
    </div>
</section>

                <div class="col-md-4">
                    <div class="card mb-4">
                        <img src="./img/Old Madena.png"  class="card-img-top" alt="Old Medina">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fa fa-map-marker"></i> Cap Spartel</h5>
                            <p class="card-text">Tourist Place</p>
                            <p class="card-text rating"><i class="fa fa-star"></i> 4.1</p>
                            <a href="#" class="btn btn-link">View more <span class="arrow">→</span></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img src="./img/Cap Spartel.png" class="card-img-top" alt="Old Medina">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fa fa-map-marker"></i> Old Medina</h5>
                            <p class="card-text">Tourist Place</p>
                            <p class="card-text rating"><i class="fa fa-star"></i> 4.6</p>
                            <a href="#" class="btn btn-link">View more <span class="arrow">→</span></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img src="./img/RR Ice.webp" class="card-img-top" alt="Mosque Lalla Abla">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fa fa-map-marker"></i> Mosque Lalla Abla</h5>
                            <p class="card-text">Tourist Place</p>
                            <p class="card-text rating"><i class="fa fa-star"></i> 4.8</p>
                            <a href="#" class="btn btn-link">View more <span class="arrow">→</span></a>
                        </div>
                    </div>
                </div>
            </div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>