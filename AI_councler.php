<?php 
session_start();

// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CareerGuides.pk - AI Career Adviser</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <style>
        :root {
            --primary: #2c3e50;
            --accent: #3498db;
            --navbar: #034e99;
            --white: #ffffff;
            --gray: #7f8c8d;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Arial, sans-serif;
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
        /* NAVBAR */
        .navbar {
            background-color: var(--navbar);
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 40px;
            color: white;
            flex-shrink: 0;
        }

        .logo {
            font-size: 1.4rem;
            font-weight: bold;
            text-decoration: none;
            color: white;
        }

        /* CHAT CONTAINER */
        .chat-container {
            max-width: 900px;
            width: 35%;
            height: 600px;
            margin: 20px auto;
             background: rgba(255, 255, 255, 0.50);
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
            flex: 1; 
            overflow: hidden;
        }

        /* CHAT HEADER */
        .chat-header {
            background: var(--primary);
            color: white;
            padding: 15px;
            text-align: center;
            font-weight: 600;
            border-radius: 12px 12px 0 0;
            flex-shrink: 0;
        }

        /* BOTPRESS IFRAME AREA */
        .botpress-frame {
            flex: 1;
            width: 100%;
            height: 100%;
            border: none;
        }

        footer {
            text-align: center;
            padding: 15px;
            background: var(--primary);
            color: white;
            flex-shrink: 0;
        }
    </style>
</head>

<body>

    <header class="navbar">
        <a href="#" class="logo">CareerGuides.pk - AI career adviser</a>
    </header>

    <div class="chat-container">
        <div class="chat-header">
            🤖 AI Career adviser
        </div>

        <iframe 
   src="https://cdn.botpress.cloud/webchat/v3.6/shareable.html?configUrl=https://files.bpcontent.cloud/2026/03/28/13/20260328130816-CS8199EO.json"
   class="";
    style="width: 100%; height: 100%; border: none;">
</iframe>
    </div>

    <footer>
        © 2026 CareerGuides.pk | Developed by Muhammad Jawad
    </footer>

</body>
</html>