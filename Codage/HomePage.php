
<?php

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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"
        integrity="sha384-Z65FFH9kCk3Upsh6zVeJT6zxy5bRB+8SM6RvDhhOdYJbCLs4qybrt1wrj5d9UJGh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@400;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Font Awesome -->
</head>

<body>
    <nav class="navbar navbar-expand-lg  ">
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

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 text-center text-md-left">
                <h1 class="display-3">Explore the beauty of Tangier</h1>
                <form class="form-inline justify-content-center justify-content-md-start mt-3">
                    <input class="form-control mr-2" type="search" placeholder="search destinations"
                        aria-label="Search">
                    <button class="btn btn-primary" type="submit">Explore</button>
                </form>
                <p class="mt-3">Still deciding where to go? <a href="#" class="head1">Explore destinations</a></p>
            </div>
            <div class="col-md-6 text-center">
                <img src="./img/Tanger.png" class="img-fluid" width="600"  alt="Tangier">
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
                        <img src="./img/<?php echo $destination['coverimage']; ?>" class="card-img-top" alt="<?php echo $destination['titre']; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $destination['titre']; ?></h5>
                            <!-- <p class="card-text"><?php echo $destination['description']; ?></p> -->
                            <p class="card-text rating"><i class="fa fa-star"></i> <?php echo round($destination['average_rating'], 1); ?></p>

                            <a href="#" class="btn btn-link">View more <span class="arrow">→</span></a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
            <div class="text-center">
                <br>
                <a href="#" class="btn btn-secondary mt-6">Discover more destinations</a>
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
                <!-- Restaurant Card 1 -->
                 <?php foreach ($topRestaurants as $restaurant) : ?>
                <div class="col-md-4">
                    <div class="card">
                        <img src="./img/<?php echo $restaurant['coverimage']; ?>" class="card-img-top" alt="<?php echo $restaurant['titre']; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $restaurant['titre']; ?></h5>
                            <p class="card-text"><?php echo $restaurant['description']; ?></p>
                            <p class="card-text rating"><i class="fa fa-star"></i> <?php echo round($restaurant['average_rating'], 1); ?></p>
                            <a href="#" class="btn btn-link">View more <span class="arrow">→</span></a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
            <div class="text-center mt-4">
                <a href="#" class="btn btn-secondary">Discover more Restaurants</a>
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
                        <p class="client-review">Lorem Ipsum Dolor Sit Amet, Consectetur Adipiscing Elit. Urna, Torto
                            Tempus.</p>
                        <div class="rating">
                            &#9733;&#9733;&#9733;&#9733;&#9733;
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="testimonial-card p-4">
                        <h5 class="client-name">Elly Forbs</h5>
                        <p class="client-location">London, England</p>
                        <p class="client-review">Lorem Ipsum Dolor Sit Amet, Consectetur Adipiscing Elit. Urna, Torto
                            Tempus.</p>
                        <div class="rating">
                            &#9733;&#9733;&#9733;&#9733;&#9733;
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="testimonial-card p-4">
                        <h5 class="client-name">Mia Nest</h5>
                        <p class="client-location">Madrid, Spain</p>
                        <p class="client-review">Lorem Ipsum Dolor Sit Amet, Consectetur Adipiscing Elit. Urna, Torto
                            Tempus.</p>
                        <div class="rating">
                            &#9733;&#9733;&#9733;&#9733;&#9733;
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="testimonial-card p-4">
                        <h5 class="client-name">Dan Dornu</h5>
                        <p class="client-location">Iasi, Romania</p>
                        <p class="client-review">Lorem Ipsum Dolor Sit Amet, Consectetur Adipiscing Elit. Urna, Torto
                            Tempus.</p>
                        <div class="rating">
                            &#9733;&#9733;&#9733;&#9733;&#9733;
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    

    <footer class="footer">
        <div class="imagepattern2"></div>
        <div class="container">
            
                <div class="footer-logo">
                <img src="./img/LogoTnagorroco-removebg-preview.png" alt="Logo" class="logo">
                </div>
                <div class="footer-nav">
                    <a href="#">about</a>
                    <a href="#">destination</a>
                    <a href="#">blog</a>
                    <a href="#">contact</a>
                </div>
                <div class="footer-social">
                <a href="#">Instagram</a>
                <a href="#">Youtube</a>
                <a href="#">LinkedIn</a>
                <a href="#">Twitter</a>
                </div>
            <div class="footer-credit">
                <p>&copy; All Rights Reserved By <strong>Tangorroco</strong></p>
            </div>
        </div>
    </footer>


    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
<?php
// include "./package/footer.html" ;
// // include "./Style/footer.css";
// include "./package/navbar.html";
?>