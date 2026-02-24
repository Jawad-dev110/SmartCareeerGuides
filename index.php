<?php
session_start();
// Check if user is logged in
$isLoggedIn = isset($_SESSION['user_id']);
$userName = $isLoggedIn ? $_SESSION['user_name'] : "Guest";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CareerGuides.pk</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        :root {
            --primary: #2c3e50;
            --accent: #3498db;
            --white: #ffffff;
            --text: #333;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', Arial, sans-serif;
            background-color: #f9f9f9;
        }

        /* --- TOP NAVBAR --- */
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

        .nav-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .menu-icon {
            font-size: 30px;
            cursor: pointer;
            display: flex;
            align-items: center;
        }

        .logo {
            font-size: 1.2rem;
            font-weight: bold;
        }

        .nav-links-top {
            display: flex;
            align-items: center;
        }

        .nav-links-top a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            font-size: 14px;
            transition: 0.3s;
        }

        .nav-links-top a:hover {
            color: var(--accent);
        }

        .user-greeting {
            margin-left: 20px;
            font-size: 14px;
            color: #f1c40f;
            font-weight: bold;
        }

        /* --- SIDEBAR --- */
        .sidebar {
            position: fixed;
            top: 0;
            left: -280px;
            width: 280px;
            height: 100%;
            background: var(--primary);
            transition: all 0.3s ease;
            z-index: 1002;
            padding-top: 20px;
            
        }

        .sidebar.active {
            left: 0;
        }

        .sidebar-header {
            padding: 10px 25px;
            border-bottom: 1px solid #34495e;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            color: white;
        }

        .sidebar-links {
            list-style: none;
            padding: 0;
        }

        .sidebar-links li a {
            display: flex;
            align-items: center;
            padding: 15px 25px;
            color: #bdc3c7;
            text-decoration: none;
            border-bottom: 1px solid #34495e;
        }

        .sidebar-links li a i {
            margin-right: 15px;
            font-size: 20px;
        }

        .sidebar-links li a:hover {
            background: #34495e;
            color: white;
        }

        .sidebar-links .logout {
            color: #e74c3c;
            margin-top: 20px;
            font-weight: bold;
        }

        .close-btn {
            text-align: right;
            padding: 0 20px 10px;
            font-size: 25px;
            cursor: pointer;
            color: white;
        }

        /* Overlay */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.6);
            display: none;
            z-index: 1001;
        }

        .overlay.active {
            display: block;
        }

        main {
            padding: 30px;
            max-width: 1000px;
            margin: 0 auto;
            min-height: 80vh;
        }

        #login-btn, #reg-btn, #start-test-btn {
            background-color:#34495e;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        #login-btn:hover, #reg-btn:hover, #start-test-btn:hover {
            background-color: #034e99;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .hero {
            background: #ecf0f1;
            padding: 40px;
            text-align: center;
            border-radius: 8px;
            margin-bottom: 40px;
        }

        .sections {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
        }

        section.cards {
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .cards:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
        }

        .card1 { border-left: 5px solid #3498db; }
        .card2 { border-left: 5px solid #e67e22; }
        .card3 { border-left: 5px solid #2ecc71; }
        .card4 { border-left: 5px solid #9b59b6; }
        .card5 { border-left: 5px solid #f1c40f; }
        .card6 { border-left: 5px solid #9e5706; }

        footer {
            background: var(--primary);
            color: white;
            padding: 40px 20px;
            margin-top: 50px;
        }
    </style>
</head>
<body>

    <header class="navbar">
        <div class="nav-left">
            <?php if($isLoggedIn): ?>
            <div class="menu-icon" onclick="toggleSidebar()">
                <i class='bx bx-menu'></i>
            </div>
            <?php endif; ?>
            <div class="logo">SmartCareerGuides.pk</div>
        </div>
        
        <nav class="nav-links-top">
            <a href="index.php">Home</a>
            <a href="about.html">About Us</a>
            <a href="contact.html">Contact</a>
            
            <?php if(!$isLoggedIn): ?>
                <a href="Signup.html">Sign Up</a>
                <a href="login.html">Login</a>
            <?php else: ?>
                <span class="user-greeting">Hi, <?php echo htmlspecialchars($userName); ?></span>
            <?php endif; ?>
        </nav>
    </header>

    <?php if($isLoggedIn): ?>
    <div class="sidebar" id="sidebar">
        <div class="close-btn" onclick="toggleSidebar()">
            <i class='bx bx-x'></i>
        </div>
        <div class="sidebar-header">
            <i class='bx bxs-user-circle' style="font-size: 24px; margin-right: 10px;"></i>
            <span><?php echo htmlspecialchars($userName); ?></span>
        </div>
        <ul class="sidebar-links">
            <li><a href="profile.php"><i class='bx bxs-user'></i> Profile</a></li>
            <li><a href="universities.html"><i class='bx bxs-school'></i> Universities Info</a></li>
            <li><a href="test.php"><i class='bx bx-edit'></i> Test</a></li>
            <li><a href="results-view.php"><i class='bx bx-bar-chart-alt-2'></i> Results</a></li>
            <li><a href="final_report.php"><i class='bx bx-file-find'></i> View Final Result</a></li>
            <li><a href="career_info.html"><i class='bx bx-briefcase'></i> Careers Info</a></li>
            <li><a href="AI_councler.html"><i class='bx bx-bot'></i> AI Counselor</a></li>
            <li><a href="logout.php" class="logout"><i class='bx bx-log-out'></i> Logout</a></li>
        </ul>
    </div>
    <div class="overlay" id="overlay" onclick="toggleSidebar()"></div>
    <?php endif; ?>

    <main>
        <h1>Welcome to SmartCareerGuides.pk</h1>
        <p>Your ultimate destination for career guidance and resources in Pakistan.</p>
        <br>

        <section class="hero">
            <p>Explore career paths, university information, and resources tailored for students in Pakistan.</p>
            <?php if(!$isLoggedIn): ?>
                <a href="login.html"><button id="login-btn">Login</button></a>
                <a href="Register.html"><button id="reg-btn">Register</button></a>
            <?php else: ?>
                <h3>Welcome <?php echo htmlspecialchars($userName); ?>. Explore your dashboard!</h3>
            <?php endif; ?>
        </section>

       <div class="sections">
           <section class="card1 cards">
                <h3>Career Tests</h3>
                <p>Take career tests to discover your interests and potential career paths.</p>
                <a href="test.php"><button id="start-test-btn">Start Test</button></a>
           </section>

            <section class="card2 cards">
                 <h3>University Information</h3>
                 <p>Explore detailed information about universities across Pakistan.</p>
            </section>
      
           <section class="card3 cards">
                <h3>Career Resources</h3>
                <p>Access a wide range of resources including articles and counseling services.</p>
           </section>

           <section class="card4 cards">
                <h3>AI Career Counselor</h3>
                <p>Get personalized career advice from our AI-powered counselor.</p>
           </section>

           <section class="card5 cards">
                <h3>Preparation Tools</h3>
                <p>Utilize our tools to excel in your exams and interviews.</p>
           </section>

           <section class="card6 cards">
                <h3>Student Support</h3>
                <p>Join our community and access support from peers and experts.</p>
           </section>
       </div>
    </main>

    <footer>
        <p style="text-align: center;">&copy; 2026 CareerGuides.pk. All rights reserved.</p>
        <div style="text-align: center; font-size: 14px; margin-top: 10px;">
            <p>Developed by Muhammad Jawad</p>
            <p>Follow us on Facebook, Twitter, and LinkedIn</p>
        </div>
    </footer>

    <script>
     const sidebar = document.getElementById('sidebar');
const overlay = document.getElementById('overlay');
const menuIcon = document.querySelector('.menu-icon');
let hoverTimeout;

// Function to Open Sidebar
function openSidebar() {
    // Delay the opening to prevent accidental hovers from triggering the sidebar immediately
    hoverTimeout = setTimeout(() => {
        sidebar.classList.add('active');
        overlay.classList.add('active');
    }, 300); 
}

// Function to Close Sidebar
function closeSidebar() {
    clearTimeout(hoverTimeout); // Clear any pending timeout to prevent the sidebar from opening if the user quickly moves the mouse away
    sidebar.classList.remove('active');
    overlay.classList.remove('active');
}

// Events
if(menuIcon) {
    menuIcon.addEventListener('mouseenter', openSidebar);
    menuIcon.addEventListener('mouseleave', () => clearTimeout(hoverTimeout));
}

sidebar.addEventListener('mouseleave', closeSidebar);
overlay.addEventListener('click', closeSidebar);
    </script>
</body>
</html>