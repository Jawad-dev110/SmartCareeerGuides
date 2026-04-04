<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartCareerGuides.pk</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        :root {
            --primary-blue: #034e99;
            --dark-blue: #02366b;
            --accent-yellow: #f1c40f;
            --white: #ffffff;
            --glass: rgba(255, 255, 255, 0.15);
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(rgba(3, 78, 153, 0.8), rgba(2, 54, 107, 0.9)), 
                        url('https://images.unsplash.com/photo-1523050853063-913bc9aed7dd?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80'); /* Background image like your screenshot */
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* --- NAVBAR --- */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 8%;
            color: white;
        }

        .logo {
            font-size: 1.8rem;
            font-weight: 800;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .logo span { color: var(--accent-yellow); }

        .nav-links a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            font-weight: 600;
            font-size: 15px;
        }

        .auth-btns a {
            text-decoration: none;
            padding: 10px 25px;
            border-radius: 50px;
            font-weight: bold;
            margin-left: 10px;
            transition: 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .login-link { background: var(--white); color: var(--primary-blue); }
        .signup-link { border: 2px solid var(--white); color: var(--white); }

        .login-link:hover { background: #eee; transform: translateY(-2px); }
        .signup-link:hover { background: var(--white); color: var(--primary-blue); }

        /* --- HERO SECTION (Drawing & Screenshot Based) --- */
        .hero-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 20px;
        }

        .glass-card {
            background: var(--glass);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            padding: 50px 40px;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            max-width: 800px;
            width: 90%;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
        }

        .glass-card h1 {
            font-size: 3.5rem;
            color: white;
            margin: 0;
            line-height: 1.1;
        }

        .glass-card p {
            color: #e0e0e0;
            font-size: 1.2rem;
            margin: 20px 0;
        }

        /* --- SEARCH BAR (As per your drawing) --- */
        .search-container {
            margin-top: 30px;
            width: 100%;
            max-width: 600px;
            position: relative;
            margin-left: auto;
            margin-right: auto;
        }

        .search-container input {
            width: 100%;
            padding: 18px 30px;
            border-radius: 50px;
            border: none;
            outline: none;
            font-size: 1rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .search-container button {
            position: absolute;
            right: 5px;
            top: 5px;
            bottom: 5px;
            background: var(--primary-blue);
            color: white;
            border: none;
            padding: 0 25px;
            border-radius: 50px;
            cursor: pointer;
            font-weight: bold;
            transition: 0.3s;
        }

        .search-container button:hover { background: var(--dark-blue); }

        .icons-row {
            margin-top: 30px;
            font-size: 2rem;
            color: var(--accent-yellow);
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        /* --- FOOTER --- */
        .footer {
            background: rgba(0,0,0,0.3);
            color: white;
            text-align: center;
            padding: 20px;
            font-size: 14px;
            border-top: 1px solid rgba(255,255,255,0.1);
        }

        .footer p { margin: 5px 0; }

        @media (max-width: 768px) {
            .glass-card h1 { font-size: 2rem; }
            .navbar { flex-direction: column; gap: 15px; }
        }
    </style>
</head>
<body>

    <header class="navbar">
        <div class="logo">SMART<span>CAREERGUIDES</span></div>
        
        <div class="auth-btns">
                <a href="login.html" class="login-link"><i class='bx bx-log-in-circle'></i> Login</a>
                <a href="Signup.html" class="signup-link"><i class='bx bx-user-plus'></i> Sign Up</a>
            
        </div>
    </header>

    <main class="hero-container">
        <div class="glass-card">
            <h1>Shape Your Future <br> With Us</h1>
            <p>Pakistan's Premier Career Guidance Platform - Search for your dream university and success today!</p>
           
            <div class="icons-row">
                <i class='bx bxs-star'></i>
                <i class='bx bxs-graduation'></i>
                <i class='bx bxs-rocket'></i>
            </div>
        </div>
    </main>

    <footer class="footer">
        <p>&copy; 2026 SmartCareerGuides.pk | All Rights Reserved</p>
        <p>Designed & Developed by Muhammad Jawad</p>
    </footer>

</body>
</html>