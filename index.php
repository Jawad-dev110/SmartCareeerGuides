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
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(rgba(3, 78, 153, 0.8), rgba(2, 54, 107, 0.9)), 
                        url('https://images.unsplash.com/photo-1523050853063-913bc9aed7dd?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* --- FIXED NAVBAR SIZE --- */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 8%;
            height: 80px; /* Navbar ki height fix kar di */
            background: rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            position: sticky;
            z-index: 1000;
        }

        .logo-box {
            position: relative;
            height: 100%;
            display: flex;
            align-items: center;
        }

        #logoimg {
          
            height:250px; 
            width: auto;
            position: absolute; 
            margin-top:15px;
            margin-left: -150px;
            object-fit: contain;
            transition: 0.3s ease;
            filter: drop-shadow(0 5px 15px rgba(0,0,0,0.2));
        }

        #logoimg:hover {
            
        }

        .auth-btns {
            display: flex;
            gap: 15px;
            align-items: center;
            margin-right: -80px;
        }

        .auth-btns a {
            text-decoration: none;
            padding: 10px 22px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 14px;
            transition: 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .login-link { 
            background: var(--white); 
            color: var(--primary-blue); 
        }
        
        .signup-link { 
            border: 2px solid var(--white); 
            color: var(--white); 
        }

        .login-link:hover { background: #f0f0f0; transform: translateY(-2px); }
        .signup-link:hover { background: var(--white); color: var(--primary-blue); transform: translateY(-2px); }

        /* --- HERO SECTION --- */
        .hero-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 40px 20px;
        }

        .glass-card {
            background: var(--glass);
            backdrop-filter: blur(15px);
            padding: 60px 40px;
            border-radius: 30px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            max-width: 850px;
            width: 90%;
            box-shadow: 0 25px 50px rgba(0,0,0,0.3);
        }

        .glass-card h1 {
            font-size: 3.5rem;
            color: white;
            margin: 0;
            line-height: 1.1;
            font-weight: 800;
        }
        .glass-card p {
            font-size: 1.2rem;
            color: #e0e0e0;
            margin-top: 20px;
            margin-bottom: 30px;
        }

        .icons-row {
            margin-top: 40px;
            font-size: 2.5rem;
            color: var(--accent-yellow);
            display: flex;
            justify-content: center;
            gap: 30px;
        }

        .footer {
            background: rgba(0,0,0,0.4);
            color: white;
            text-align: center;
            padding: 20px;
            font-size: 14px;
        }

        /* --- MOBILE DESIGN --- */
        @media (max-width: 768px) {
            .navbar {
                height: auto;
                padding: 15px 5%;
                flex-direction: column;
                gap: 50px; 
            }

            
            
            .glass-card h1 { font-size: 2.2rem; }
        }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="logo-box">
            <img id="logoimg" src="logoimage.png" alt="SmartCareerGuides Logo">
        </div>
            
        <div class="auth-btns">
            <a href="login.html" class="login-link"><i class='bx bxs-log-in'></i> Login</a>
            <a href="signup.html" class="signup-link"><i class='bx bxs-user-plus'></i> Sign Up</a>
        </div>
    </nav>

    <main class="hero-container">
        <div class="glass-card">
            <h1>Shape Your Future <br> With Us</h1>
            <p>Pakistan's Premier Career Guidance Platform. Search for your dream university and start your success journey today!</p>
           
            <div class="icons-row">
                <i class='bx bxs-star'></i>
                <i class='bx bxs-graduation'></i>
                <i class='bx bxs-rocket'></i>
            </div>
        </div>
    </main>

    <footer class="footer">
        <p>&copy; 2026 <strong>SmartCareerGuides.pk</strong> | All Rights Reserved</p>
        <p>Designed & Developed by Muhammad Jawad</p>
    </footer>

</body>
</html>