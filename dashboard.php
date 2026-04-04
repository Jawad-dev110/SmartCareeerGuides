<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$userName = $_SESSION['user_name'];
$isLoggedIn = true; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - SmartCareerGuides.pk</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        :root {
            --primary: #034e99;
            --dark-bg: #f0f4f8;
            --sidebar-color: #1e2a38;
            --white: #ffffff;
            --accent: #3498db;
            --yellow: #f1c40f;
            --text-main: #2d3436;
            --text-muted: #636e72;
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }

        body {
            margin: 0;
            font-family: 'Inter', 'Segoe UI', Roboto, sans-serif;
            background-color: white;
            background-image: url("imagebg.jpg");
            backdrop-filter: blur(5px);
            opacity: 0.95;
            min-height: 100vh;
            color: var(--text-main);
        }

       /* Sidebar Main Container */
.sidebar {
    position: fixed;
    top: 0;
    left: -280px;
    width: 280px;
    height: 100%;
    background: #1e2a38; /* Sidebar dark color */
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    z-index: 2000;
    box-shadow: 5px 0 25px rgba(0,0,0,0.3);
    overflow-y: auto;
}

.sidebar.active {
    left: 0;
}

/* User Profile Header */
.sidebar-header {
    padding: 10px 25px 30px 25px;
    display: flex;
    flex-direction: column;
    align-items: center;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    margin-bottom: 15px;
}

.user-pic i {
    font-size: 70px;
    color: #faad07;
    margin-bottom: 10px;
}

.user-info {
    text-align: center;
}

.user-name {
    display: block;
    color: #ffffff;
    font-size: 18px;
    font-weight: 600;
    letter-spacing: 0.5px;
}

.user-status {
    font-size: 12px;
    color: #3498db;
    text-transform: uppercase;
    font-weight: bold;
    letter-spacing: 1px;
}

/* Sidebar Links */
.sidebar-links {
    list-style: none;
    padding: 0 15px;
}

.sidebar-links li {
    margin-bottom: 5px;
}

.sidebar-links li a {
    display: flex;
    align-items: center;
    padding: 12px 15px;
    color: #cbd5e0;
    text-decoration: none;
    font-size: 15px;
    border-radius: 10px;
    transition: 0.3s;
    gap: 12px;
}

/* Active and Hover Effects */
.sidebar-links li a:hover, 
.sidebar-links li a.active {
    background: rgba(250, 173, 7, 0.1);
    color: #faad07;
}

.sidebar-links li a i {
    font-size: 20px;
}

/* Special Logout Styling */
.sidebar-links li a.logout-btn {
    margin-top: 20px;
    color: #ff7675;
    border: 1px solid rgba(255, 118, 117, 0.2);
}

.sidebar-links li a.logout-btn:hover {
    background: #ff7675;
    color: white;
}

/* Custom Scrollbar for Sidebar */
.sidebar::-webkit-scrollbar {
    width: 5px;
}
.sidebar::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 10px;
}

        main { padding: 40px 20px; max-width: 1200px; margin: 0 auto; }

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: white;
            padding: 50px 30px;
            text-align: center;
            border-radius: 24px;
            box-shadow: var(--shadow);
            margin-bottom: 50px;
            min-height: 200px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .hero h1 { font-size: 2.2rem; margin-bottom: 10px; letter-spacing: -0.5px; }
        .hero p { font-size: 1.1rem; opacity: 0.9; margin-bottom: 15px; }

        /* Dashboard Cards - Modern Look */
        .sections {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 30px;
        }

        .cards {
            background: var(--white);
            padding: 35px;
            border-radius: 20px;
            border: 1px solid rgba(0,0,0,0.05);
            transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-shadow: var(--shadow);
        }
        
        .cards:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.12);
        }

        .cards h3 { 
            margin: 0 0 15px 0; 
            font-size: 1.4rem;
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .cards h3 i {
            background: rgba(3, 78, 153, 0.1);
            padding: 10px;
            border-radius: 12px;
            font-size: 1.6rem;
        }

        .cards p { 
            color: var(--text-muted); 
            line-height: 1.6; 
            font-size: 1rem;
            margin-bottom: 25px;
        }

        /* Button Width Fix */
        .btn-premium {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: white;
            padding: 10px 24px;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            width: fit-content; /* Kam width ke liye */
            transition: all 0.3s ease;
            font-size: 0.95rem;
            box-shadow: 0 4px 15px rgba(3, 78, 153, 0.2);
        }

        .btn-premium:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(3, 78, 153, 0.3);
        }

        /* Footer */
        footer {
            background: var(--sidebar-color);
            padding: 50px 20px;
            color: white;
            text-align: center;
            margin-top: 80px;
            border-radius: 40px 40px 0 0;
        }
        .social-links {
            display: flex;
            justify-content: center;
            gap: 25px;
            margin-top: 20px;
        }
        .social-links a { color: #55efc4; text-decoration: none; transition: 0.3s; }
        .social-links a:hover { color: var(--yellow); }

        .fade-in { animation: fadeIn 0.6s ease-out; }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

    <?php include 'navbar.php'; ?>

    <div class="sidebar" id="sidebar">
    <div style="padding: 15px 20px; text-align: right; cursor: pointer;" onclick="toggleSidebar()">
        <i class='bx bx-x' style="font-size: 28px; color: #cbd5e0;"></i>
    </div>

    <div class="sidebar-header">
        <div class="user-pic">
            <i class='bx bxs-user-circle'></i>
        </div>
        <div class="user-info">
            <span class="user-name"><?php echo htmlspecialchars($userName); ?></span>
            <span class="user-status">Student</span>
        </div>
    </div>

    <ul class="sidebar-links">
        <li><a href="profile.php"><i class='bx bxs-user'></i> Profile</a></li>
        <li><a href="dashboard.php" class="active"><i class='bx bxs-dashboard'></i> Dashboard</a></li>
        <li><a href="uni_admission_portal.php"><i class='bx bxs-school'></i> Universities</a></li>
        <li><a href="AI_councler.php"><i class='bx bx-bot'></i> AI career Adviser</a></li>
        <li><a href="test.php"><i class='bx bx-spreadsheet'></i> Career Test</a></li>
        <li><a href="prep_tools.html"><i class='bx bx-tool'></i> Prep Tools</a></li>
        <li><a href="career_info.php"><i class='bx bxs-info-circle'></i> Career Information</a></li>
        <li><a href="resources.html"><i class='bx bx-book-open'></i> Resources</a></li>
        <li><a href="logout.php" class="logout-btn"><i class='bx bx-log-out-circle'></i> Logout</a></li>
    </ul>
</div>
    
    <div class="overlay" id="overlay" onclick="toggleSidebar()"></div>

    <main>
        <section class="hero" id="hero-slider">
            <h1 id="slider-title" class="fade-in">Smarter Decisions, Brighter Futures</h1>
            <p id="slider-text" class="fade-in">Discover the best career paths and top universities in Pakistan.</p>
            <div style="margin-top: 10px; font-weight: 500; color: var(--yellow);">
                Welcome back, <?php echo htmlspecialchars($userName); ?>!
            </div>
        </section>

        <div class="sections">
            <section class="cards">
                <div>
                    <h3><i class='bx bx-edit-alt'></i> Career Tests</h3>
                    <p>Discover your strengths with our scientifically designed aptitude tests and personality assessments.</p>
                </div>
                <a href="test.php" class="btn-premium">Take Assessment</a>
            </section>

            <section class="cards">
                <div>
                    <h3><i class='bx bxs-bank'></i> Universities</h3>
                    <p>Complete database of HEC recognized universities in Pakistan with detailed admission criteria.</p>
                </div>
                <a href="uni_admission_portal.php" class="btn-premium">Explore Portal</a>
            </section>
      
            <section class="cards">
                <div>
                    <h3><i class='bx bx-bot'></i> AI Counselor</h3>
                    <p>Get 24/7 personalized advice and instant answers from our intelligent career assistant.</p>
                </div>
                <a href="AI_councler.php" class="btn-premium">Chat Now</a>
            </section>

            <section class="cards">
                <div>
                    <h3><i class='bx bx-book-open'></i> Resources</h3>
                    <p>Access a wealth of information, guides, and tools to support your academic and professional journey.</p>
                </div>
                <a href="resources.html" class="btn-premium">Explore Resources</a>
            </section>

            <section class="cards">
                <div>
                    <h3><i class='bx bx-tool'></i> Prep Tools</h3>
                    <p>Enhance your entry test preparation with our comprehensive study materials and practice modules.</p>
                </div>
                <a href="prep_tools.html" class="btn-premium">Explore Tools</a>
            </section>

            <section class="cards">
                <div>
                    <h3><i class='bx bx-briefcase'></i> Careers</h3>
                    <p>Explore various high-growth career options and find the best fit for your unique skills.</p>
                </div>
                <a href="careers.html" class="btn-premium">Discover Careers</a>
            </section>
        </div>
    </main>

    <footer>
        <p>&copy; 2026 SmartCareerGuides.pk | Developed by Muhammad Jawad</p>
        <div class="social-links">
            <a href="#">Facebook</a>
            <a href="#">Twitter</a>
            <a href="#">Instagram</a>
        </div>
    </footer>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('active');
            document.getElementById('overlay').classList.toggle('active');
        }

        const sliderData = [
            {
                title: "Smarter Decisions, Brighter Futures",
                text: "Discover the best career paths and top universities in Pakistan.",
                bg: "linear-gradient(135deg, #034e99, #007bff)"
            },
            {
                title: "Plan Your Success",
                text: "Join 10,000+ students exploring their dream careers today.",
                bg: "linear-gradient(135deg, #1e2a38, #3a4b5c)"
            },
            {
                title: "Expert Guidance 24/7",
                text: "Talk to our AI Counselor for personalized career advice.",
                bg: "linear-gradient(135deg, #2980b9, #2c3e50)"
            }
        ];

        let currentIndex = 0;
        const heroSection = document.getElementById('hero-slider');
        const titleElement = document.getElementById('slider-title');
        const textElement = document.getElementById('slider-text');

        function updateSlider() {
            currentIndex = (currentIndex + 1) % sliderData.length;
            titleElement.classList.remove('fade-in');
            textElement.classList.remove('fade-in');
            
            setTimeout(() => {
                titleElement.innerText = sliderData[currentIndex].title;
                textElement.innerText = sliderData[currentIndex].text;
                heroSection.style.background = sliderData[currentIndex].bg;
                titleElement.classList.add('fade-in');
                textElement.classList.add('fade-in');
            }, 50);
        }

        setInterval(updateSlider, 4000);
    </script>
</body>
</html>