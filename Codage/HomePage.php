<?php
session_start();
include "connection.php";
$topRestaurants = fetchTopRestaurants($conn);
$topDestinations = fetchTopDestinations($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Explore the beauty of Tangier</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./Style/indexPage.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"
        integrity="sha384-Z65FFH9kCk3Upsh6zVeJT6zxy5bRB+8SM6RvDhhOdYJbCLs4qybrt1wrj5d9UJGh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@400;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Font Awesome -->
</head>
<body>
   <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">
            <img src="./img/LogoTnagorroco.png" width="180" height="auto" class="d-inline-block align-top" alt="Logo">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="HomePage.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="AllrRestaurants.php">Restaurants</a></li>
                <li class="nav-item"><a class="nav-link" href="Alldestination.php">Destination</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Blog</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
                <?php if(isset($_SESSION['user_id']) || isset($_SESSION['admin_id'])): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-user"></i>
                            <?php 
                            // Display the user's name or 'Admin' if it's an admin session
                            echo isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : 'Admin';
                            ?>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="./User/profile.php">Profile</a>
                            <?php if(isset($_SESSION['admin_id'])): ?>
                                <a class="dropdown-item" href="./Admin/admin_dashboard.php">Dashboard</a>
                            <?php endif; ?>
                            <a class="dropdown-item" href="logout.php">Logout</a>
                        </div>
                    </li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

   <!-- Main Content -->
<div class="container mt-5">
    <div class="row">
        <div class="col-md-6 text-center text-md-left">
            <h1 class="display-3">Explore the beauty of Tangier</h1>
            <form class="form-inline justify-content-center justify-content-md-start mt-3">
                <input class="form-control mr-2" type="search" placeholder="Search destinations" aria-label="Search">
                <button class="btn btn-primary" type="submit">Explore</button>
            </form>
            <p class="mt-3">Still deciding where to go? <a href="" class="head1">Explore destinations</a></p>
        </div>
        <div class="col-md-6 text-center">
            <img src="./img/Tanger.png" class="img-fluid" width="600" alt="Tangier">
        </div>
    </div>
</div>
    <br>
<section class="featured-destination py-5">
    <div class="container">
        <h2 class="text-center mb-4">Featured destination</h2>
        <div class="cardsDst">
            <div class="row">
    <?php foreach ($topDestinations as $destination) : ?>
        <div class="col-md-4">
            <div class="card">
                <span class="favorite-icon position-absolute top-0 end-0">
                    <i class="far fa-heart" data-id="<?php echo $destination['publicationid']; ?>"></i>
                </span>
                <img src="./img/<?php echo $destination['coverimage']; ?>" class="card-img-top" alt="<?php echo $destination['titre']; ?>">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $destination['titre']; ?></h5>
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
                    <a href="destination.php?id=<?php echo $destination['publicationid']; ?>" class="btn btn-link">View details <span class="arrow">→</span></a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

            <div class="text-center">
                <br>
                <a href="Alldestination.php" class="btn btn-secondary mt-6">Discover more destinations</a>
            </div>
        </div>
    </div>
</section>

    <!-- Main Section -->
    <section class="explore-section text-center">
        <div class="container ">
            <h1 class="my-4 text-md-left mt-4">What do you like to explore?</h1>
            <div class="text-md-right">
                <img src="./img/Miramonte.pnj.jpg" alt="Explore Image" class="img-fluid2 mb-3 " width="800">
                <p class="lead"> Discover the charm of this magnificent city through its array of restaurants and top
                    destinations awaiting
                    exploration.</p>
            </div>
        </div>
    </section>

    <!-- Restaurant Section -->
    <section class="restaurants py-5">
        <div class="container">
            <h2 class="text-center mb-4">Restaurant</h2>
            <div class="row">
    <?php foreach ($topRestaurants as $restaurant) : ?>
        <div class="col-md-4">
            <div class="card position-relative">
                <!-- Favorite Icon -->
                <span class="favorite-icon position-absolute top-0 end-0">
                    <i class="far fa-heart" data-id="<?php echo $restaurant['publicationid']; ?>"></i>
                </span>
                <!-- Restaurant Image -->
                <img src="./img/<?php echo $restaurant['coverimage']; ?>" class="card-img-top" alt="<?php echo $restaurant['titre']; ?>">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $restaurant['titre']; ?></h5>
                    <div class="rating">
                        <?php
                        $max_stars = 5;
                        $average_rating = $restaurant['average_rating'];
                        $percentage = ($average_rating / $max_stars) * 100;
                        $rounded_percentage = round($percentage / 20) * 20;
                        $filled_stars = $rounded_percentage / 20;

                        for ($i = 0; $i < $filled_stars; $i++) {
                            echo "&#9733;";
                        }
                        for ($i = $filled_stars; $i < $max_stars; $i++) {
                            echo "&#9734;";
                        }
                        ?>
                    </div>
                    <a href="about.php?publicationid=<?php echo $restaurant['publicationid']; ?>" class="btn btn-link">View more <span class="arrow">→</span></a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

            <div class="text-center mt-4">
                <a href="AllrRestaurants.php" class="btn btn-secondary">Discover more Restaurants</a>
            </div>
        </div>
    </section>
    <section class="subscription-section text-center py-5">
        <div class="container">
            <h2>Get weekly notification about new destination!</h2>
            <form class="form-inline justify-content-center mt-4">
                <div class="form-group mb-2">
                    <label for="email" class="sr-only">Email address</label>
                    <input type="email" class="form-control" id="email" placeholder="Your email address">
                </div>
                <button type="submit" class="btn btn-primary mb-2 ml-2">Subscribe</button>
            </form>
        </div>
        <div class="imagepattern"></div>
    </section>

   <!-- Comments Section -->
<!-- <section class="comments-section py-5">
    <div class="container">
        <div class="comment-boxs">
            <div class="col-md-6">
                <div class="comment-box p-4">
                    <h3 class="Best_comments">Best Comments</h3>
                    <blockquote class="blockquote">
                        <p>“I found a reason to live”</p>
                        <footer class="blockquote-footer">I few months back, I was considering suicide. Life felt unbearable and lonely. I was opportuned to come across a group trip to Old Medina, I made new friends and found a community of people. Now we are planning a new group trip soon.</footer>
                    </blockquote>
                    <div class="navigation-arrows">
                        <div>
                            <span class="arrow left-arrow" onclick="showPreviousComment()">&larr;</span>
                            <span class="arrow right-arrow" onclick="showNextComment()">&rarr;</span>
                        </div>
                        <div class="pagination-dots mt-2">
                            <span class="dot"></span>
                            <span class="dot"></span>
                            <span class="dot" style="background-color: aqua;"></span>
                            <span class="dot"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="comment-image">
                    <div class="comment-image-img"></div>
                </div>
            </div>
        </div>
    </div>
</section> -->
<!-- Comments Section -->
    <section class="comments-section py-5">
        <div class="container">
            <div class="comment-boxs">
                <div class="col-md-6">
                    <div class="comment-box p-4">
                        <h3 class="Best_comments">Best Comments</h3>
                        <blockquote class="blockquote">
                            <p>“I found a reason to live”</p>
                            <footer class="blockquote-footer">I few months back, I was considering suicide. Life felt
                                unbearable and lonely. I was opportuned to come across a group trip to Old Medina, I
                                made
                                new friends and found a community of people. Now we are planning a new group trip soon.
                            </footer>
                        </blockquote>
                        <div class="navigation-arrows"><div>
                            <span class="arrow left-arrow"><a href="#">&larr;</a></span>
                            <span class="arrow right-arrow"><a href="#">&rarr;</a></span>
                            </div>
                            <div class="pagination-dots mt-2">
                                <span class="dot"></span>
                                <span class="dot"></span>
                                <span class="dot" style="background-color: aqua;"></span>
                                <span class="dot"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div  class="comment-image ">
                        <div class="comment-image-img"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="testimonia l-section py-5">
        <div class="container text-center">
            <h2 class="section-title">What Our Clients Say About Us</h2>
            <div class="row justify-content-center mt-4">
                <div class="col-md-3">
                    <div class="testimonial-card p-4">
                        <h5 class="client-name">Alex Feder</h5>
                        <p class="client-location">Miami, USA</p>
                        <p class="client-review">I had an amazing experience using this website to plan my trip to Tangier. It provided comprehensive information about the city's attractions, accommodations, and dining options. Thanks to this platform, my trip was a memorable one!</p>
                        <div class="rating">
                            &#9733;&#9733;&#9733;&#9733;&#9733;
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="testimonial-card p-4">
                        <h5 class="client-name">Elly Forbs</h5>
                        <p class="client-location">London, England</p>
                        <p class="client-review">As a food enthusiast, I found this website to be incredibly useful in discovering the best restaurants in Tangier. The reviews and recommendations helped me explore the city's culinary scene and find hidden gems I wouldn't have known about otherwise.</p>
                        <div class="rating">
                            &#9733;&#9733;&#9733;&#9733;&#9733;
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="testimonial-card p-4">
                        <h5 class="client-name">Mia Nest</h5>
                        <p class="client-location">Madrid, Spain</p>
                        <p class="client-review">I stumbled upon this website while planning my trip to Tangier, and it turned out to be a lifesaver! The detailed guides and insider tips made my visit to Tangier stress-free and enjoyable. I'll definitely be using this platform for future travels.</p>
                        <div class="rating">
                            &#9733;&#9733;&#9733;&#9733;&#9733;
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="testimonial-card p-4">
                        <h5 class="client-name">Dan Dornu</h5>
                        <p class="client-location">Iasi, Romania</p>
                        <p class="client-review">This website was a game-changer for my vacation in Tangier. It provided me with valuable insights into the city's culture, history, and attractions. Thanks to the detailed information and user-friendly interface, I was able to make the most out of my trip.</p>
                        <div class="rating">
                            &#9733;&#9733;&#9733;&#9733;&#9733;
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./Style/footer.css">
    <!-- Include FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha512-...." crossorigin="anonymous" />
    <title>Document</title>
</head>

<body>
    <footer class="footer">
        <div class="imagepattern2"></div>
        <div class="container">
            <div class="footer-logo">
                <img src="./img/LogoTnagorroco.png" alt="Logo" class="logo">
            </div>
            <div class="footer-nav">
                <a href="HomePage.php">Home</a>
                <a href="Alldestination.php">destination</a>
                <a href="AllrRestaurants.php">Restaurants</a>
                <a href="profile.php">Profil</a>
            </div>
            <div class="footer-social">
                <!-- Replace text links with FontAwesome icons -->
                <a href="https://www.instagram.com/ivar_happ/?next=%2F"><i class="fab fa-instagram"></i> Instagram</a>
                <a href="https://www.youtube.com/channel/UCg5VEtIzb_q-xb_cldg0UeQ"><i class="fab fa-youtube"></i> Youtube</a>
                <a href="https://www.linkedin.com/in/zakaria-azizi-082b8927a/"><i class="fab fa-linkedin"></i> Linkedin</a>
                <a href="https://x.com/Za14Zakaria"><i class="fab fa-twitter"></i> Twitter</a>
            </div>
            <div class="footer-credit">
                <p>&copy; All Rights Reserved By <strong>Tangorroco</strong></p>
            </div>
        </div>
    </footer>
</body>

</html>


    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>

document.addEventListener('DOMContentLoaded', function () {
    const favoriteIcons = document.querySelectorAll('.favorite-icon i');
    favoriteIcons.forEach(icon => {
        icon.addEventListener('click', function () {
            if (this.classList.contains('far')) {
                this.classList.remove('far');
                this.classList.add('fas');
                this.style.color = 'red';
            } else {
                this.classList.remove('fas');
                this.classList.add('far');
                this.style.color = '';
            }
        });
    });
});
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

 document.addEventListener('DOMContentLoaded', function () {
        // Select all heart icons
        const favoriteIcons = document.querySelectorAll('.favorite-icon i');

        // Function to toggle favorite state
        function toggleFavorite(event) {
            const icon = event.target;
            const destinationId = icon.getAttribute('data-id');
            
            // Get current favorites from local storage or initialize to empty array
            let favorites = JSON.parse(localStorage.getItem('favorites')) || [];

            // Toggle favorite status
            if (favorites.includes(destinationId)) {
                // Remove destination from favorites
                favorites = favorites.filter(id => id !== destinationId);
                icon.classList.remove('fas'); // Solid heart
                icon.classList.add('far');    // Regular heart
            } else {
                // Add destination to favorites
                favorites.push(destinationId);
                icon.classList.remove('far'); // Regular heart
                icon.classList.add('fas');    // Solid heart
            }

            // Update local storage
            localStorage.setItem('favorites', JSON.stringify(favorites));
        }

        // Attach click event listener to each icon
        favoriteIcons.forEach(icon => {
            icon.addEventListener('click', toggleFavorite);

            // Set initial state based on local storage
            const destinationId = icon.getAttribute('data-id');
            const favorites = JSON.parse(localStorage.getItem('favorites')) || [];
            if (favorites.includes(destinationId)) {
                icon.classList.remove('far'); // Regular heart
                icon.classList.add('fas');    // Solid heart
            }
        });
    });
// const images = ['./img/Sky_image.jpg', './img/blueSky.webp', './img/Cap_Spartel.png'];
// let currentIndex = 0;
// const imageElement = document.querySelector('.comment-image-img');

// function changeImage() {
//     imageElement.style.backgroundImage = `url('${images[currentIndex]}')`;
//     currentIndex = (currentIndex + 1) % images.length;
// }
// changeImage();


// // Change image every 5 seconds (adjust as needed)
// setInterval(changeImage, 5000);

// Define an array of comments and testimonials
// const comments = [
//     {
//         comment: "“I found a reason to live”",
//         testimonial: "A few months back, I was considering suicide. Life felt unbearable and lonely. I was fortunate to come across a group trip to Old Medina. I made new friends and found a community of people. Now we are planning a new group trip soon."
//     },
//     {
//         comment: "“Incredible experience!”",
//         testimonial: "Visiting Cap Spartel was an incredible experience. The view of the ocean and the lighthouse is breathtaking. I highly recommend it to anyone visiting Tangier."
//     },
//     {
//         comment: "“The best food ever!”",
//         testimonial: "Eating at El Morocco Club was an unforgettable culinary experience. The food was delicious, and the ambiance was perfect for a romantic dinner. I will definitely come back."
//     },
//     // Add more comments and testimonials as needed
// ];

// // Initialize variables
// let currentCommentIndex = 0;
// let isShowingComment = true;
// const commentBlock = document.querySelector(".comment-box .blockquote p");
// const testimonialBlock = document.querySelector(".comment-box .blockquote footer");

// // Function to update the comment or testimonial
// function updateContent() {
//     if (isShowingComment) {
//         commentBlock.textContent = comments[currentCommentIndex].comment;
//         testimonialBlock.textContent = "";
//     } else {
//         commentBlock.textContent = "";
//         testimonialBlock.textContent = comments[currentCommentIndex].testimonial;
//     }
// }

// // Function to show the next comment or testimonial
// function showNextContent() {
//     currentCommentIndex++;
//     if (currentCommentIndex >= comments.length) {
//         currentCommentIndex = 0;
//     }
//     updateContent();
// }

// // Function to toggle between comments and testimonials
// function toggleContent() {
//     isShowingComment = !isShowingComment;
//     updateContent();
// }

// // Automatically move to the next comment or testimonial at regular intervals (5 seconds)
// setInterval(showNextContent, 5000);

// // Initially display the first comment
// updateContent();

// // Add event listener to the navigation arrows for toggling
// document.querySelector(".left-arrow").addEventListener("click", toggleContent);
// document.querySelector(".right-arrow").addEventListener("click", toggleContent);

</script>
</body>

</html>
