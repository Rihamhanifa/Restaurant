<?php 
require_once 'config/db.php'; 

$message = '';
$messageType = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $date = trim($_POST['date'] ?? '');
    $time = trim($_POST['time'] ?? '');
    $guests = intval($_POST['guests'] ?? 0);
    $special_requests = trim($_POST['special_requests'] ?? '');

    if (empty($name) || empty($phone) || empty($email) || empty($date) || empty($time) || empty($guests)) {
        $message = 'Please fill out all required fields.';
        $messageType = 'error';
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO bookings (name, phone, email, booking_date, booking_time, guests, special_requests) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$name, $phone, $email, $date, $time, $guests, $special_requests]);
            $message = 'Your booking request has been successfully submitted! We will contact you soon to confirm.';
            $messageType = 'success';
        } catch(PDOException $e) {
            $message = 'Error submitting booking: ' . $e->getMessage();
            $messageType = 'error';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book a Table - Elegance</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .page-header {
            padding: 150px 0 50px;
            text-align: center;
            background: linear-gradient(180deg, var(--dark-bg) 0%, #0d0d0d 100%);
        }
        .booking-row {
            display: flex;
            gap: 20px;
        }
        .booking-row .form-group {
            flex: 1;
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            font-weight: 500;
        }
        .alert.error {
            background-color: rgba(255, 50, 50, 0.2);
            color: #ffaaaa;
            border: 1px solid rgba(255, 50, 50, 0.3);
        }
        .alert.success {
            background-color: rgba(46, 204, 113, 0.2);
            color: #82e0a2;
            border: 1px solid rgba(46, 204, 113, 0.3);
        }
        
        .booking-container {
            max-width: 800px;
            margin: 0 auto;
        }

        @media (max-width: 768px) {
            .booking-row {
                flex-direction: column;
                gap: 0;
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
            <li><a href="booking.php" class="active">Book a Table</a></li>
            <li><a href="contact.php">Contact</a></li>
        </ul>
    </div>
</header>

<section class="page-header">
    <div class="container fade-up delay-1">
        <h1>Reservations</h1>
        <p>Book your table to guarantee a spectacular dining experience.</p>
    </div>
</section>

<section class="section pt-0">
    <div class="container">
        <div class="booking-container glass-card fade-up delay-2">
            
            <?php if (!empty($message)): ?>
                <div class="alert <?php echo htmlspecialchars($messageType); ?>">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <form action="booking.php" method="POST" id="bookingForm">
                <style>
                    /* Inline styling for dark browser default inputs */
                    input[type="date"]::-webkit-calendar-picker-indicator,
                    input[type="time"]::-webkit-calendar-picker-indicator {
                        filter: invert(1);
                        cursor: pointer;
                    }
                </style>
                <div class="booking-row">
                    <div class="form-group">
                        <label for="name">Full Name *</label>
                        <input type="text" id="name" name="name" class="form-control" required placeholder="John Doe">
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone Number *</label>
                        <input type="tel" id="phone" name="phone" class="form-control" required placeholder="+1 234 567 8900">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="email">Email Address *</label>
                    <input type="email" id="email" name="email" class="form-control" required placeholder="john@example.com">
                </div>

                <div class="booking-row">
                    <div class="form-group">
                        <label for="date">Date *</label>
                        <input type="date" id="date" name="date" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="time">Time *</label>
                        <input type="time" id="time" name="time" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="guests">Guests *</label>
                        <input type="number" id="guests" name="guests" class="form-control" min="1" max="20" required placeholder="2">
                    </div>
                </div>

                <div class="form-group">
                    <label for="special_requests">Special Requests / Allergies</label>
                    <textarea id="special_requests" name="special_requests" class="form-control" placeholder="Any special requirements we should know about?"></textarea>
                </div>

                <button type="submit" class="btn" style="width: 100%;">Confirm Reservation</button>
            </form>
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
</body>
</html>
