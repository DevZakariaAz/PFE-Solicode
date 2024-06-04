<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Page</title>
    <link rel="stylesheet" href="./Style/SignUp.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <section class="signup-section">
        <div class="container">
            <div class="left-side">
                <blockquote class="quote">
                    <h3>"The <span class="highlight">essence</span> of existence lies in <br> embracing <span class="highlight">the mysteries</span> of our journey."</h3>
                    <footer>- Steve Jobs</footer>
                </blockquote>
                <div class="logo">
                    <img src="./img/LogoTnagorroco.png" alt="Logo">
                </div>
            </div>
            <div class="right-side">
                <form class="signup-form">
                    <h2>Sign Up</h2>
                    <div class="form-group">
                        <label for="email"><i class="fas fa-envelope"></i></label>
                        <input type="email" id="email" name="email" placeholder="Your email">
                    </div>
                    <div class="form-group">
                        <label for="username"><i class="fas fa-user"></i></label>
                        <input type="text" id="username" name="username" placeholder="User name">
                    </div>
                    <div class="form-group">
                        <label for="password"><i class="fas fa-key"></i></label>
                        <input type="password" id="password" name="password" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <label for="repeat-password"><i class="fas fa-key"></i></label>
                        <input type="password" id="repeat-password" name="repeat-password" placeholder="Repeat Password">
                    </div>
                    <button type="submit" class="btn">Sign Up</button>
                </form>
                <p>Already have an account? <a href="Login.php">Log in</a></p>
            </div>
        </div>
    </section>
</body>
</html>
