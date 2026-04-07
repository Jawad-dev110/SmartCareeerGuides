<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        /* Navbar Modern Styles */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #03294e; /* Deep Navy Blue */
            padding: 0 40px;
            height: 75px;
            color: #fff;
            position: sticky;
            top: 0;
            z-index: 1100;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .nav-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .menu-icon {
            font-size: 28px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            padding: 8px;
            border-radius: 8px;
            margin-left: -35px;
        }

        .menu-icon:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #faad07;
        }

        .logo {
            font-size: 22px;
            font-weight: 700;
            letter-spacing: -0.5px;
            text-transform: uppercase;
            font-family: 'Segoe UI', Roboto, sans-serif;
            cursor: pointer;
        }

        .logo span {
            color: #faad07; /* Golden Yellow */
        }

        .nav-links-top {
            display: flex;
            align-items: center;
            gap: 25px;
        }

        #logo-img {
            width: 400px;
            margin-left: -80px;
            margin-top: 25px;
        }


        .nav-links-top a {
            color: #e0e0e0;
            text-decoration: none;
            font-size: 15px;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
            padding: 5px 0;
        }

        /* Hover underline effect */
        .nav-links-top a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: #faad07;
            transition: width 0.3s ease;
        }

        .nav-links-top a:hover::after {
            width: 100%;
        }

        .nav-links-top a:hover {
            color: #faad07;
        }

        /* Logout Link Styling */
        .logout-link {
            background: rgba(250, 173, 7, 0.15);
            padding: 8px 18px !important;
            border-radius: 8px;
            border: 1px solid rgba(250, 173, 7, 0.3);
            color: #faad07 !important;
        }

        .logout-link:hover {
            background: #faad07 !important;
            color: #03294e !important;
        }

        .logout-link::after {
            display: none; /* Hide underline for button-style link */
        }

        /* Responsive Fix */
        @media (max-width: 768px) {
            .navbar { padding: 0 15px; }
            .nav-links-top { gap: 15px; }
            .nav-links-top a { font-size: 14px; }
            .logo { font-size: 18px; }
        }
    </style>
</head>
<body>
    <header class="navbar">
        <div class="nav-left">
            <div class="menu-icon" onclick="toggleSidebar()">
                <i class='bx bx-menu-alt-left'></i>
            </div>
            <div class="logo"><img id="logo-img" src="logoimage.png" alt="Logo"></div>
        </div>
        
        <nav class="nav-links-top">
            <a href="index.php">Home</a>
            <a href="about.php">About</a>
            <a href="contact.php">Contact</a>
            <a href="logout.php" class="logout-link">Logout</a>
        </nav>
    </header>
</body>
</html>