<?php
include "connection.php"; // Include your database connection file

// Function to fetch all restaurants
function fetchAllRestaurantsV2($DB) {
    $query = "
        SELECT 
            p.publicationid, 
            p.titre, 
            p.description, 
            p.location, 
            p.coverimage, 
            GROUP_CONCAT(DISTINCT c.category) AS categories, 
            cu.nationalite AS cuisine, 
            COUNT(r.reviewid) AS review_count, 
            AVG(r.rating) AS average_rating 
        FROM 
            publication p
        LEFT JOIN 
            category_publication cp ON p.publicationid = cp.publicationid 
        LEFT JOIN 
            category c ON cp.categoryid = c.categoryid 
        LEFT JOIN 
            cuisine cu ON p.cuisineid = cu.cuisineid
        LEFT JOIN 
            review r ON p.publicationid = r.publicationid 
        WHERE 
            p.type = 'restaurant' 
        GROUP BY 
            p.publicationid
        ORDER BY 
            average_rating DESC;
    ";

    $statement = $DB->prepare($query);
    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

$restaurants = fetchAllRestaurantsV2($conn);

if (count($restaurants) > 0) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore Restaurants</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        /* CSS styles for the page */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .restaurant-section {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            padding: 20px;
        }
        .restaurant-card {
            flex: 0 0 calc(33.33% - 20px);
            margin: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            background-color: #fff;
            transition: transform 0.3s;
            position: relative;
        }
        .restaurant-card:hover {
            transform: translateY(-5px);
        }
        .restaurant-image img {
            width: 100%;
            height: 350px; /* Adjust height as needed */
            object-fit: cover;
        }
        .restaurant-content {
            padding: 15px;
        }
        .rating {
            margin: 10px 0;
            color: #FFD700; /* Gold color for stars */
            font-size: 1.2rem;
        }
        .favorite-icon {
            cursor: pointer;
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 1.5rem;
            color: #ff6666; /* Light red color for the heart icon */
        }
        .fas.fa-heart {
            color: #ff0000; /* Red for solid heart (favorited) */
        }
         .hero-section {
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
    </style>
</head>
<body>
    <?php include "./package/navbar.html"; ?>
     <section class="hero-section">
                <h1 class="hero-title">Explore the beauty of Tangier</h1>
                <form class="search-form" action="index.php" method="get">
                    <input type="text" class="search-input" name="q" id="search-query" placeholder="Search restaurants" required>
                    <button type="submit" class="search-button">Explore</button>
                </form>
                    <a href="destinations.html" class="explore-link">Still deciding where to go? Explore restaurants</a>
    </section>
    <section class="restaurant-section">
        <?php foreach ($restaurants as $restaurant): ?>
            <div class="restaurant-card">
                <!-- Favorite Icon -->
                <span class="favorite-icon">
                    <i class="far fa-heart" data-id="<?php echo htmlspecialchars($restaurant['publicationid']); ?>"></i>
                </span>
                <div class="restaurant-image">
                    <img src="./img/<?php echo htmlspecialchars($restaurant['coverimage']); ?>" alt="<?php echo htmlspecialchars($restaurant['titre']); ?>">
                </div>
                <div class="restaurant-content">
                    <h2><?php echo htmlspecialchars($restaurant['titre']); ?></h2>
                    <p><strong>Location:</strong> <?php echo htmlspecialchars($restaurant['location']); ?></p>
                    <p><strong>Categories:</strong> <?php echo htmlspecialchars($restaurant['categories']); ?></p>
                    <div class="rating"><strong> Rating :</strong>
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
                        echo "({$average_rating} / 5) " ;
                        ?>  
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </section>
    <?php include "./package/footer.html"; ?>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script> <!-- Include FontAwesome for the icons -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Select all heart icons for restaurants
            const favoriteIcons = document.querySelectorAll('.favorite-icon i');

            // Function to toggle favorite state
            function toggleFavorite(event) {
                const icon = event.target;
                const restaurantId = icon.getAttribute('data-id');
                
                // Get current favorites from local storage or initialize to empty array
                let restaurantFavorites = JSON.parse(localStorage.getItem('restaurantFavorites')) || [];

                // Toggle favorite status
                if (restaurantFavorites.includes(restaurantId)) {
                    // Remove restaurant from favorites
                    restaurantFavorites = restaurantFavorites.filter(id => id !== restaurantId);
                    icon.classList.remove('fas'); // Solid heart
                    icon.classList.add('far');    // Regular heart
                } else {
                    // Add restaurant to favorites
                    restaurantFavorites.push(restaurantId);
                    icon.classList.remove('far'); // Regular heart
                    icon.classList.add('fas');    // Solid heart
                }

                // Update local storage with the non-null array of favorites
                localStorage.setItem('restaurantFavorites', JSON.stringify(restaurantFavorites));
            }

            // Attach click event listener to each icon
            favoriteIcons.forEach(icon => {
                icon.addEventListener('click', toggleFavorite);

                // Set initial state based on local storage
                const restaurantId = icon.getAttribute('data-id');
                const restaurantFavorites = JSON.parse(localStorage.getItem('restaurantFavorites')) || [];
                if (restaurantFavorites.includes(restaurantId)) {
                    icon.classList.remove('far'); // Regular heart
                    icon.classList.add('fas');    // Solid heart
                }
            });
        });
    </script>
</body>
</html>
<?php
} else {
    echo "<p>No restaurants found.</p>";
}
?>
