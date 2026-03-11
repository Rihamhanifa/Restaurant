<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

$action = $_GET['action'] ?? 'bookings';

// Handle booking status updates
if ($action === 'update_booking' && isset($_GET['id']) && isset($_GET['status'])) {
    $id = intval($_GET['id']);
    $status = $_GET['status'];
    if (in_array($status, ['Accepted', 'Rejected'])) {
        $stmt = $pdo->prepare("UPDATE bookings SET status = ? WHERE id = ?");
        $stmt->execute([$status, $id]);
    }
    header("Location: dashboard.php?action=bookings");
    exit;
}

// Handle menu item deletion
if ($action === 'delete_menu' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $pdo->prepare("DELETE FROM menu_items WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: dashboard.php?action=menu");
    exit;
}

// Handle adding menu items
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_menu'])) {
    $title = trim($_POST['title']);
    $price = floatval($_POST['price']);
    $category = $_POST['category'];
    $description = trim($_POST['description']);
    
    // Default image if not uploaded
    $image_url = 'images/default_menu.png'; 

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "../images/";
        // Create directory if not exists
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $filename = time() . '_' . basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $filename;
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image_url = "images/" . $filename;
        }
    }

    $stmt = $pdo->prepare("INSERT INTO menu_items (title, description, price, category, image_url) VALUES (?, ?, ?, ?, ?)");
    if ($stmt->execute([$title, $description, $price, $category, $image_url])) {
        $msg = "Menu item added successfully.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Elegance</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body { background: #050505; color: #fff; display: flex; }
        .sidebar { width: 250px; background: rgba(10,10,10,0.95); height: 100vh; padding: 20px; position: fixed; border-right: 1px solid var(--glass-border); }
        .sidebar h2 { color: var(--primary-color); margin-bottom: 40px; font-size: 1.5rem; text-align: center; }
        .nav-items { list-style: none; }
        .nav-items li { margin-bottom: 15px; }
        .nav-items a { display: block; padding: 12px 15px; border-radius: 8px; color: var(--text-color); font-weight: 500; transition: 0.3s; }
        .nav-items a:hover, .nav-items a.active { background: var(--primary-color); color: var(--dark-bg); }
        .main-content { margin-left: 250px; padding: 40px; width: calc(100% - 250px); }
        .table-responsive { overflow-x: auto; background: var(--card-bg); padding: 20px; border-radius: 10px; border: 1px solid var(--glass-border); }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid rgba(255,255,255,0.05); }
        th { color: var(--primary-color); font-weight: 600; text-transform: uppercase; font-size: 0.9rem; }
        .badge { display: inline-block; padding: 5px 10px; border-radius: 15px; font-size: 0.8rem; font-weight: 600; }
        .badge.pending { background: #f39c12; color: #fff; }
        .badge.accepted { background: #2ecc71; color: #fff; }
        .badge.rejected { background: #e74c3c; color: #fff; }
        .action-btn { background: rgba(255,255,255,0.1); padding: 6px 12px; border-radius: 5px; color: #fff; font-size: 0.9rem; margin-right: 5px; }
        .action-btn.accept:hover { background: #2ecc71; }
        .action-btn.reject:hover, .action-btn.delete:hover { background: #e74c3c; }
        
        .form-container { background: var(--card-bg); padding: 30px; border-radius: 10px; border: 1px solid var(--glass-border); max-width: 600px; margin-bottom: 30px; }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>ELEGANCE<br><span style="font-size: 0.9rem; color:#fff;">Admin</span></h2>
    <ul class="nav-items">
        <li><a href="?action=bookings" class="<?php echo $action == 'bookings' ? 'active' : ''; ?>"><i class="fas fa-calendar-alt"></i> Bookings</a></li>
        <li><a href="?action=menu" class="<?php echo $action == 'menu' ? 'active' : ''; ?>"><i class="fas fa-utensils"></i> Manage Menu</a></li>
        <li><a href="logout.php" style="margin-top: 50px; color: #ffaaaa;"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
    </ul>
</div>

<div class="main-content">

    <?php if ($action == 'bookings'): ?>
        <h2 style="color: var(--accent-color); margin-bottom: 30px;">Reservation Requests</h2>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Contact</th>
                        <th>Date & Time</th>
                        <th>Guests</th>
                        <th>Special Request</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt = $pdo->query("SELECT * FROM bookings ORDER BY created_at DESC");
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
                    ?>
                    <tr>
                        <td>#<?php echo $row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['phone']); ?><br><small style="color:var(--text-muted);"><?php echo htmlspecialchars($row['email']); ?></small></td>
                        <td><?php echo htmlspecialchars($row['booking_date']); ?><br><small><?php echo htmlspecialchars($row['booking_time']); ?></small></td>
                        <td><?php echo $row['guests']; ?></td>
                        <td><?php echo htmlspecialchars($row['special_requests'] ?: '-'); ?></td>
                        <td>
                            <span class="badge <?php echo strtolower($row['status']); ?>"><?php echo $row['status']; ?></span>
                        </td>
                        <td>
                            <?php if ($row['status'] == 'Pending'): ?>
                                <a href="?action=update_booking&id=<?php echo $row['id']; ?>&status=Accepted" class="action-btn accept" title="Accept"><i class="fas fa-check"></i></a>
                                <a href="?action=update_booking&id=<?php echo $row['id']; ?>&status=Rejected" class="action-btn reject" title="Reject"><i class="fas fa-times"></i></a>
                            <?php else: ?>
                                <span style="color:var(--text-muted); font-size:0.9rem;">Done</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

    <?php elseif ($action == 'menu'): ?>
        <h2 style="color: var(--accent-color); margin-bottom: 30px;">Manage Menu</h2>
        
        <?php if ($msg): ?>
            <div style="background: rgba(46, 204, 113, 0.2); color: #2ecc71; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                <?php echo htmlspecialchars($msg); ?>
            </div>
        <?php endif; ?>

        <div class="form-container">
            <h3 style="margin-bottom: 20px;">Add New Item</h3>
            <form action="?action=menu" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="add_menu" value="1">
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" name="title" class="form-control" required>
                </div>
                <div class="form-group" style="display:flex; gap:15px;">
                    <div style="flex:1;">
                        <label>Price</label>
                        <input type="number" step="0.01" name="price" class="form-control" required>
                    </div>
                    <div style="flex:1;">
                        <label>Category</label>
                        <select name="category" class="form-control" required style="background: rgba(255,255,255,0.05); color: #fff;">
                            <option value="Starters">Starters</option>
                            <option value="Main">Main</option>
                            <option value="Desserts">Desserts</option>
                            <option value="Drinks">Drinks</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" class="form-control" style="min-height: 80px;"></textarea>
                </div>
                <div class="form-group">
                    <label>Item Image</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>
                <button type="submit" class="btn">Add Menu Item</button>
            </form>
        </div>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt = $pdo->query("SELECT * FROM menu_items ORDER BY category, title");
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
                    ?>
                    <tr>
                        <td>
                            <?php if($row['image_url']): ?>
                                <img src="../<?php echo htmlspecialchars($row['image_url']); ?>" alt="" style="width:50px; height:50px; object-fit:cover; border-radius:5px;">
                            <?php endif; ?>
                        </td>
                        <td><?php echo htmlspecialchars($row['title']); ?><br><small style="color:var(--text-muted);"><?php echo htmlspecialchars(substr($row['description'], 0, 50)).'...'; ?></small></td>
                        <td><?php echo htmlspecialchars($row['category']); ?></td>
                        <td>$<?php echo number_format($row['price'], 2); ?></td>
                        <td>
                            <a href="?action=delete_menu&id=<?php echo $row['id']; ?>" class="action-btn delete" onclick="return confirm('Delete this item?');"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

</div>

</body>
</html>
