<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="./Style/SignUp.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <section class="login-section">
        <div class="container">
            <div class="left-side">
                <blockquote class="quote">
                    <h3>"The adventure awaits for those who <br><span class="highlight">believe</span> in the <span class="highlight">magic of their dreams</span>."</h3>
                    <footer>- Zakaria Azizi</footer>
                </blockquote>
                <div class="logo">
                    <img src="./img/LogoTnagorroco-removebg-preview.png" alt="Logo">
                </div>
            </div>
            <div class="right-side">
                <form class="login-form">
                    <h2>Login</h2>
                    <div class="form-group">
                        <label for="email"><i class="fas fa-envelope"></i></label>
                        <input type="email" id="email" name="email" placeholder="Your email">
                    </div>
                    <div class="form-group">
                        <label for="password"><i class="fas fa-key"></i></label>
                        <input type="password" id="password" name="password" placeholder="Password">
                    </div>
                    <button type="submit" class="btn">Login</button>
                </form>
                <p>Don't have an account? <a href="signup.php">Sign up</a></p>
            </div>
        </div>
    </section>
</body>
</html>
