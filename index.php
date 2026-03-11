<?php require_once 'config/db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elegance - Fine Dining Restaurant</title>
    <!-- Add fontawesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div id="loader">
    <div class="spinner"></div>
</div>

<header>
    <div class="container nav-container">
        <a href="index.php" class="logo">ELEGANCE</a>
        <div class="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <ul class="nav-links">
            <li><a href="index.php" class="active">Home</a></li>
            <li><a href="menu.php">Menu</a></li>
            <li><a href="booking.php">Book a Table</a></li>
            <li><a href="contact.php">Contact</a></li>
        </ul>
    </div>
</header>

<section class="hero">
    <img src="images/restaurant_hero_1773228294423.png" alt="Hero Background" class="hero-bg">
    <div class="hero-overlay"></div>
    <div class="hero-content fade-up delay-1">
        <h1>Experience <span>Culinary</span> Perfection</h1>
        <p>A symphony of flavors in every bite, served with unmatched elegance and passion.</p>
        <a href="booking.php" class="btn">Book a Table</a>
        <a href="menu.php" class="btn btn-secondary" style="margin-left: 15px;">View Menu</a>
    </div>
</section>

<section class="section">
    <div class="container">
        <h2 class="section-title fade-up">Featured Dishes</h2>
        <div class="menu-grid">
            <?php
            $stmt = $pdo->query("SELECT * FROM menu_items LIMIT 3");
            $delay = 1;
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo '<div class="glass-card menu-item fade-up delay-'.$delay.'">';
                echo '<div class="menu-img-container">';
                echo '<img src="'.$row['image_url'].'" alt="'.htmlspecialchars($row['title']).'">';
                echo '</div>';
                echo '<div class="menu-details">';
                echo '<h3>'.htmlspecialchars($row['title']).'</h3>';
                echo '<p>'.htmlspecialchars($row['description']).'</p>';
                echo '<div class="menu-price">$'.number_format($row['price'], 2).'</div>';
                echo '</div>';
                echo '</div>';
                $delay++;
            }
            ?>
        </div>
    </div>
</section>

<section class="section" style="background-color: #0d0d0d;">
    <div class="container">
        <h2 class="section-title fade-up">What Our Guests Say</h2>
        <div class="menu-grid">
            <div class="glass-card fade-up delay-1">
                <p style="font-style: italic; margin-bottom: 20px;">"The best fine dining experience I have ever had. The Wagyu steak was cooked to absolute perfection and the ambiance is stunning."</p>
                <h4 style="color: var(--primary-color);">- Sarah Jenkins</h4>
            </div>
            <div class="glass-card fade-up delay-2">
                <p style="font-style: italic; margin-bottom: 20px;">"A luxurious atmosphere with exceptional service. Their signature sunset amber cocktail is an absolute must-try!"</p>
                <h4 style="color: var(--primary-color);">- Michael Doe</h4>
            </div>
            <div class="glass-card fade-up delay-3">
                <p style="font-style: italic; margin-bottom: 20px;">"The chocolate lava cake was divine. Highly recommend this place for anniversaries or special celebrations."</p>
                <h4 style="color: var(--primary-color);">- Emily Rogers</h4>
            </div>
        </div>
    </div>
</section>

<footer>
    <div class="container">
        <div class="footer-content">
            <div class="footer-col fade-up delay-1">
                <h4>ELEGANCE</h4>
                <p>123 Culinary Boulevard,<br>Food District, NY 10001</p>
                <p style="margin-top: 15px;">Phone: (555) 123-4567<br>Email: info@elegance.com</p>
            </div>
            <div class="footer-col fade-up delay-2">
                <h4>Opening Hours</h4>
                <p>Mon - Fri: 5:00 PM - 11:00 PM</p>
                <p>Sat - Sun: 12:00 PM - 12:00 AM</p>
            </div>
            <div class="footer-col fade-up delay-3">
                <h4>Follow Us</h4>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> Elegance Restaurant. All rights reserved. | <a href="admin/login.php" style="color: var(--text-muted); font-size: 0.9rem;">Admin Login</a></p>
        </div>
    </div>
</footer>

<button class="scroll-top"><i class="fas fa-chevron-up"></i></button>

<script src="js/script.js"></script>
</body>
</html>
