<?php
include "connection.php"; // Include your database connection file


    // Assuming $DB is your PDO connection object
    $destinations = fetchAllDestinationsV2($conn);

    if (count($destinations) > 0) {
        
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Explore Tangier Destinations</title>
            <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
            <style>
                /* CSS styles for the page */
                body {
                    font-family: 'Roboto', sans-serif;
                    background-color: #f8f9fa;
                    margin: 0;
                    padding: 0;
                }
                .destination-section {
                    display: flex;
                    justify-content: center;
                    flex-wrap: wrap;
                    padding: 20px;
                }
                .destination-card {
                    flex: 0 0 calc(33.33% - 20px);
                    margin: 10px;
                    border: 1px solid #ccc;
                    border-radius: 8px;
                    overflow: hidden;
                    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
                    background-color: #fff;
                    transition: transform 0.3s;
                }
                .destination-card:hover {
                    transform: translateY(-5px);
                }
                .destination-image img {
                    width: 100%;
                    height: 400px;
                }
                .destination-content {
                    padding: 15px;
                }
                .rating {
                    margin: 10px 0;
                }
                .rating .star {
                    color: #ffd700;
                }
                
                .rating {
                    color: #FFA500;
                    font-size: 1.2rem;
                }.hero-section {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            max-width: 600px;
            margin: 40px auto; /* Add some spacing around */
            text-align: center;
            color: #06414E; /* Dark teal color for text */
        }.hero-section {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            max-width: 600px;
            margin: 40px auto;
            text-align: center;
            color: #06414E;
        }
        .hero-title {
            font-size: 2.5rem;
            margin-bottom: 20px;
        }
        .search-form {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        .search-input {
            padding: 10px;
            border: 1px solid #06414E;
            border-radius: 5px;
            font-size: 1rem;
            width: 300px;
            margin-right: 10px;
            outline: none;
        }
        .search-button {
            background-color: #06414E;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .search-button:hover {
            background-color: #052F3C;
        }
        .explore-link {
            color: #06414E;
            text-decoration: none;
            font-size: 0.9rem;
            margin-top: 10px;
            display: inline-block;
        }
        .explore-link:hover {
            text-decoration: underline;
        }
        .search-results {
            margin-top: 20px;
            text-align: left;
            width: 100%;
        }
        .search-result {
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
        }
            </style>
        </head>
        <body>
        <?php include "./package/navbar.html"; ?>
<section class="hero-section">
    <h1 class="hero-title">Explore the beauty of Tangier</h1>
    <form class="search-form" action="index.php" method="get">
        <input type="text" class="search-input" name="q" id="search-query" placeholder="Search destinations" required>
        <button type="submit" class="search-button">Explore</button>
    </form>
    <a href="destinations.html" class="explore-link">Still deciding where to go? Explore destinations</a>
    <!-- Container to display search results -->
    <div class="search-results" id="search-results">
        <?php
        if (isset($_GET['q'])) {
            $searchQuery = $_GET['q'];
            // Perform search in PHP and display results
            $filtered_destinations = searchDestinations($conn, $searchQuery);

            if (count($filtered_destinations) > 0) {
                foreach ($filtered_destinations as $destination) {
        ?>
                    <div class="destination-card">
                        <div class="destination-image">
                            <img src="./img/<?php echo htmlspecialchars($destination['coverimage']); ?>" alt="<?php echo htmlspecialchars($destination['titre']); ?>">
                        </div>
                        <div class="destination-content">
                            <h2><?php echo htmlspecialchars($destination['titre']); ?></h2>
                            <p><?php echo htmlspecialchars($destination['description']); ?></p>
                            <p><strong>Location:</strong> <?php echo htmlspecialchars($destination['location']); ?></p>
                            <p><strong>Categories:</strong> <?php echo htmlspecialchars($destination['categories']); ?></p>
                           
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
                                echo " ({$average_rating} / 5) based on " . $destination['review_count'] . " reviews";
                                ?>
                            </div>
                        </div>
                    </div>
        <?php
                }
            } else {
                echo '<p>No results found.</p>';
            }
        }
        ?>
    </div>
</section>
        <section class="destination-section">
            <?php foreach ($destinations as $destination): ?>
                <div class="destination-card">
                    <div class="destination-image">
                        <img src="./img/<?php echo htmlspecialchars($destination['coverimage']); ?>" alt="<?php echo htmlspecialchars($destination['titre']); ?>">
                    </div>
                    <div class="destination-content">
                        <h2><?php echo htmlspecialchars($destination['titre']); ?></h2>
                        <p><?php// echo htmlspecialchars($destination['description']); ?></p>
                        <p><strong>Location:</strong> <?php echo htmlspecialchars($destination['location']); ?></p>
                        <p><strong>Categories:</strong> <?php echo htmlspecialchars($destination['categories']); ?></p>
                       
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
                            echo " ({$average_rating} / 5) based on " . $destination['review_count'] . " reviews";
                            ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </section>

        <?php include "./package/footer.html"; ?>
        </body>
      
        </html>
        <?php
    } else {
        echo "No destinations found.";
    }

?>
