<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Elegance</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .page-header {
            padding: 150px 0 50px;
            text-align: center;
            background: linear-gradient(180deg, var(--dark-bg) 0%, #0d0d0d 100%);
        }
        .contact-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 50px;
            align-items: flex-start;
        }
        .contact-info {
            padding: 30px;
        }
        .contact-item {
            display: flex;
            align-items: flex-start;
            gap: 20px;
            margin-bottom: 30px;
        }
        .contact-icon {
            width: 50px;
            height: 50px;
            background: rgba(212, 175, 55, 0.1);
            color: var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            flex-shrink: 0;
            transition: var(--transition);
        }
        .contact-item:hover .contact-icon {
            background: var(--primary-color);
            color: var(--dark-bg);
            transform: scale(1.1);
        }
        .contact-details h3 {
            margin-bottom: 5px;
            font-size: 1.2rem;
            color: var(--accent-color);
        }
        .contact-details p {
            color: var(--text-muted);
        }
        .map-container {
            width: 100%;
            height: 400px;
            border-radius: 15px;
            overflow: hidden;
            border: 1px solid var(--glass-border);
        }
        @media (max-width: 768px) {
            .contact-container {
                grid-template-columns: 1fr;
            }
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
            <li><a href="menu.php">Menu</a></li>
            <li><a href="booking.php">Book a Table</a></li>
            <li><a href="contact.php" class="active">Contact</a></li>
        </ul>
    </div>
</header>

<section class="page-header">
    <div class="container fade-up delay-1">
        <h1>Get in <span>Touch</span></h1>
        <p>Reach out to us for events, catering, or any special requests.</p>
    </div>
</section>

<section class="section">
    <div class="container contact-container">
        
        <div class="glass-card fade-up delay-2">
            <h3 style="margin-bottom: 30px; color: var(--accent-color); font-size: 1.8rem;">Send Us A Message</h3>
            <form action="#" method="POST">
                <div class="form-group">
                    <label>Your Name *</label>
                    <input type="text" class="form-control" required placeholder="John Doe">
                </div>
                <div class="form-group">
                    <label>Your Email *</label>
                    <input type="email" class="form-control" required placeholder="john@example.com">
                </div>
                <div class="form-group">
                    <label>Subject</label>
                    <input type="text" class="form-control" placeholder="Inquiry about...">
                </div>
                <div class="form-group">
                    <label>Message *</label>
                    <textarea class="form-control" required placeholder="Type your message here..."></textarea>
                </div>
                <button type="submit" class="btn" style="width: 100%;">Send Message</button>
            </form>
        </div>

        <div class="fade-up delay-3">
            <div class="contact-info glass-card" style="margin-bottom: 30px;">
                <div class="contact-item">
                    <div class="contact-icon"><i class="fas fa-map-marker-alt"></i></div>
                    <div class="contact-details">
                        <h3>Our Location</h3>
                        <p>123 Culinary Boulevard,<br>Food District, NY 10001</p>
                    </div>
                </div>
                <div class="contact-item">
                    <div class="contact-icon"><i class="fas fa-phone-alt"></i></div>
                    <div class="contact-details">
                        <h3>Phone Number</h3>
                        <p>(555) 123-4567<br>(555) 987-6543</p>
                    </div>
                </div>
                <div class="contact-item" style="margin-bottom:0;">
                    <div class="contact-icon"><i class="fas fa-envelope"></i></div>
                    <div class="contact-details">
                        <h3>Email Address</h3>
                        <p>info@elegance.com<br>events@elegance.com</p>
                    </div>
                </div>
            </div>

            <div class="map-container glass-card">
                <!-- Google Maps Iframe -->
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1m3!1d193595.15830869428!2d-74.119763973046!3d40.69766374874431!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c24fa5d33f083b%3A0xc80b8f06e177fe62!2sNew%20York%2C%20NY%2C%20USA!5e0!3m2!1sen!2s!4v1683935293297!5m2!1sen!2s" width="100%" height="100%" style="border:0; filter: grayscale(1) invert(0.9) hue-rotate(180deg);" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
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

<button class="scroll-top"><i class="fas fa-chevron-up"></i></button>

<script src="js/script.js"></script>
</body>
</html>
