<?php require_once 'config/db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - Elegance</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .page-header {
            padding: 150px 0 50px;
            text-align: center;
            background: linear-gradient(180deg, var(--dark-bg) 0%, #0d0d0d 100%);
        }
        .filter-container {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 40px;
            flex-wrap: wrap;
        }
        .filter-btn {
            background: transparent;
            color: var(--accent-color);
            border: 1px solid var(--glass-border);
            padding: 8px 20px;
            border-radius: 20px;
            cursor: pointer;
            transition: var(--transition);
            font-size: 1rem;
        }
        .filter-btn:hover, .filter-btn.active {
            background: var(--primary-color);
            color: var(--dark-bg);
            border-color: var(--primary-color);
        }
        .menu-item.hide {
            display: none;
        }
    </style>
</head>
<body>

<header>
    <div class="container nav-container">
        <a href="index.php" class="logo">ELEGANCE</a>
        <div class="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <ul class="nav-links">
            <li><a href="index.php">Home</a></li>
            <li><a href="menu.php" class="active">Menu</a></li>
            <li><a href="booking.php">Book a Table</a></li>
            <li><a href="contact.php">Contact</a></li>
        </ul>
    </div>
</header>

<section class="page-header">
    <div class="container fade-up delay-1">
        <h1>Our <span>Menu</span></h1>
        <p>Explore a variety of exquisite flavors tailored to perfection.</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="filter-container fade-up delay-2">
            <button class="filter-btn active" data-filter="all">All</button>
            <button class="filter-btn" data-filter="Starters">Starters</button>
            <button class="filter-btn" data-filter="Main">Main</button>
            <button class="filter-btn" data-filter="Desserts">Desserts</button>
            <button class="filter-btn" data-filter="Drinks">Drinks</button>
        </div>

        <div class="menu-grid fade-up delay-3">
            <?php
            $stmt = $pdo->query("SELECT * FROM menu_items ORDER BY category, title");
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo '<div class="glass-card menu-item" data-category="'.$row['category'].'">';
                echo '<div class="menu-img-container">';
                echo '<img src="'.$row['image_url'].'" alt="'.htmlspecialchars($row['title']).'" loading="lazy">';
                echo '</div>';
                echo '<div class="menu-details">';
                echo '<h3>'.htmlspecialchars($row['title']).'</h3>';
                echo '<p>'.htmlspecialchars($row['description']).'</p>';
                echo '<div class="menu-price">$'.number_format($row['price'], 2).'</div>';
                echo '</div>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
</section>

<footer>
    <div class="container">
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> Elegance Restaurant. All rights reserved. | <a href="admin/login.php" style="color: var(--text-muted); font-size: 0.9rem;">Admin Login</a></p>
        </div>
    </div>
</footer>

<script src="js/script.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const filterBtns = document.querySelectorAll('.filter-btn');
        const menuItems = document.querySelectorAll('.menu-item');

        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                // Remove active class
                filterBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');

                const filterValue = btn.getAttribute('data-filter');

                menuItems.forEach(item => {
                    if (filterValue === 'all' || item.getAttribute('data-category') === filterValue) {
                        item.classList.remove('hide');
                    } else {
                        item.classList.add('hide');
                    }
                });
            });
        });
    });
</script>
</body>
</html>
