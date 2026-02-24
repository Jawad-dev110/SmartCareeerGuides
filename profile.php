<?php
session_start();
include 'db_config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$isLoggedIn = isset($_SESSION['user_id']);
$userName = $isLoggedIn ? $_SESSION['user_name'] : "Guest";
$user_id = $_SESSION['user_id'];

// Fetch user details
$sql = "SELECT users.full_name, users.email, student_profiles.* FROM users 
        LEFT JOIN student_profiles ON users.id = student_profiles.user_id 
        WHERE users.id = '$user_id'";

$result = mysqli_query($conn, $sql);
$user_data = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - CareerGuides.pk</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        :root {
            --primary: #2c3e50;
            --accent: #3498db;
            --white: #ffffff;
        }

        body { margin: 0; font-family: 'Segoe UI', sans-serif; background-color: #f9f9f9; }

        /* --- SAME NAVBAR AS INDEX --- */
        .navbar {
            background-color:#034e99;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            color: white;
            position: sticky;
            top: 0;
            z-index: 1001;
        }
        .nav-left { display: flex; align-items: center; gap: 15px; }
        .logo { font-size: 1.2rem; font-weight: bold; }
        .nav-links-top a { color: white; text-decoration: none; margin-left: 20px; font-size: 14px; }
        .user-greeting { margin-left: 20px; font-size: 14px; color: #f1c40f; font-weight: bold; }

        /* --- PROFILE CONTENT STYLE --- */
        .profile-main {
            padding: 40px 20px;
            max-width: 800px;
            margin: 0 auto;
            min-height: 70vh;
        }
        .profile-card {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            border-top: 5px solid #034e99;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 15px 0;
            border-bottom: 1px solid #eee;
        }
        .info-row label { font-weight: bold; color: var(--primary); }
        .info-row span { color: #555; }

        /* --- FOOTER AS INDEX --- */
        footer {
            background: var(--primary);
            color: white;
            padding: 40px 20px;
            margin-top: 50px;
            text-align: center;
        }
    </style>
</head>
<body>

    <header class="navbar">
        <div class="nav-left">
            <div class="logo">CareerGuides.pk</div>
        </div>
        <nav class="nav-links-top">
            <a href="index.php">Home</a>
            <a href="about.html">About Us</a>
            <span class="user-greeting">Hi, <?php echo htmlspecialchars($userName); ?></span>
            <a href="logout.php" style="color: #e74c3c; margin-left: 15px;">Logout</a>
        </nav>
    </header>

    <main class="profile-main">
        <div class="profile-card">
            <h2 style="text-align: center; color: #034e99;">
                <i class='bx bxs-user-detail'></i> My Account Details
            </h2>
            <br>
            
            <div class="info-row">
                <label>Full Name</label>
                <span><?php echo htmlspecialchars($user_data['full_name']); ?></span>
            </div>
            
            <div class="info-row">
                <label>Email</label>
                <span><?php echo htmlspecialchars($user_data['email']); ?></span>
            </div>

            <?php if ($user_data['first_name']): ?>
                <div class="info-row">
                    <label>Age</label>
                    <span><?php echo htmlspecialchars($user_data['age']); ?></span>
                </div>
                <div class="info-row">
                    <label>Qualification</label>
                    <span><?php echo htmlspecialchars($user_data['qualification']); ?></span>
                </div>
                <div class="info-row">
                    <label>Institute</label>
                    <span><?php echo htmlspecialchars($user_data['institute']); ?></span>
                </div>
            <?php else: ?>
                <div style="text-align: center; padding: 20px;">
                    <p style="color: #e67e22;">Complete your registration to see more details.</p>
                    <a href="Register.html" style="text-decoration: none; color: #034e99; font-weight: bold;">Click here to Register</a>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <footer>
        <p>&copy; 2026 CareerGuides.pk. All rights reserved.</p>
        <p style="font-size: 12px; opacity: 0.7;">Developed by Muhammad Jawad</p>
    </footer>

</body>
</html>