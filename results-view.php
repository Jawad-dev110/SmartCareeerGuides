<?php 
session_start();
include 'db_config.php';

// Check if user is authenticated
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");  // Redirect to login page if not authenticated
    exit();
}

$u_id = $_SESSION['user_id'];   // Get the RIASEC type from the URL parameter or fetch the most recent result from the database if not provided
$type = isset($_GET['type']) ? $_GET['type'] : '';   // This allows users to directly access specific result types via URL, but we will validate it against the database to ensure they have a valid result before showing the page.

// Validation Logic: Ensure user has a valid result before viewing this page
if (empty($type)) {
    // Attempt to fetch the most recent RIASEC result for the logged-in user
    $res_query = mysqli_query($conn, "SELECT top_type FROM test_results WHERE user_id = '$u_id' ORDER BY id DESC LIMIT 1");
    
    if (mysqli_num_rows($res_query) > 0) {
        $row = mysqli_fetch_assoc($res_query);
        $type = $row['top_type'];
    } else {
        // Redirect to test page if no record is found in the database
        echo "<script>alert('No test results found. Please complete the RIASEC test first.'); window.location.href='test.php';</script>";
        exit();
    }
}

// Career Profiles Data Mapping
$descriptions = [
    'R' => [
        'title' => 'Realistic (The Doers)',
        'desc' => 'You enjoy working with your hands, tools, machines, or animals. You prefer practical, hands-on activities and see yourself as practical, mechanical, and realistic.',
        'careers' => 'Civil Engineering, Mechanical Engineering, Architecture, Information Technology, Agriculture, and Construction.'
    ],
    'I' => [
        'title' => 'Investigative (The Thinkers)',
        'desc' => 'You love to observe, learn, investigate, and solve problems. You are highly analytical and enjoy science, math, and research-oriented tasks.',
        'careers' => 'Medical Research, Software Engineering, Chemical Engineering, Psychology, Data Science, and Laboratory Research.'
    ],
    'A' => [
        'title' => 'Artistic (The Creators)',
        'desc' => 'You value creativity, intuition, and imagination. You prefer working in unstructured environments where you can express your creative talents.',
        'careers' => 'Graphic Design, Fine Arts, Creative Writing, Media & Communication, Photography, and Interior Design.'
    ],
    'S' => [
        'title' => 'Social (The Helpers)',
        'desc' => 'You enjoy working with people to enlighten, help, train, or cure them. You are skilled with words and have a high level of empathy.',
        'careers' => 'Teaching & Education, Nursing, Counseling, Social Work, Medicine, and Human Resources.'
    ],
    'E' => [
        'title' => 'Enterprising (The Persuaders)',
        'desc' => 'You are a natural leader who enjoys influencing, persuading, and leading people. You are ambitious and excel in management and business environments.',
        'careers' => 'Business Management, Law, Marketing & Sales, International Trade, Banking, and Entrepreneurship.'
    ],
    'C' => [
        'title' => 'Conventional (The Organizers)',
        'desc' => 'You like to work with data and have clerical or numerical ability. You prefer carrying out tasks in detail and following through on instructions.',
        'careers' => 'Accounting, Financial Analysis, Corporate Administration, Insurance, Banking, and Data Processing.'
    ]
];

// Security: Verify if the requested type exists in our predefined data
if (!array_key_exists($type, $descriptions)) {
    header("Location: index.php");
    exit();
}

$myResult = $descriptions[$type];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RIASEC Results - CareerGuides.pk</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        :root {
            --primary: #034e99;
            --dark: #2c3e50;
            --bg: #f0f2f5;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', Arial, sans-serif;
            background-color: var(--bg);
        }

        .navbar {
            background-color: var(--primary);
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            color: white;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .logo { font-size: 1.2rem; font-weight: bold; }
        .nav-links a { color: white; text-decoration: none; margin-left: 20px; font-size: 14px; }

        .result-container { max-width: 850px; margin: 40px auto; padding: 20px; }
        .result-card {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            text-align: center;
            border-top: 8px solid var(--primary);
        }

        .type-badge {
            background: #e1f5fe;
            color: var(--primary);
            padding: 10px 25px;
            border-radius: 50px;
            display: inline-block;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .career-box {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 12px;
            margin-top: 30px;
            text-align: left;
            border-left: 5px solid var(--primary);
        }

        .next-step-box {
            margin-top: 30px;
            padding: 20px;
            background: #fff3cd;
            border-radius: 10px;
            border: 1px solid #ffeeba;
        }

        .btn-action {
            display: inline-block;
            margin-top: 15px;
            padding: 12px 30px;
            background: #e67e22;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: 0.3s;
        }

        .btn-action:hover { background: #d35400; transform: translateY(-2px); }

        footer {
            background: var(--dark);
            color: white;
            text-align: center;
            padding: 25px;
            margin-top: 50px;
        }
        #cr-link a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
        }
        #cr-link a:hover {
            text-decoration: underline;
        }
        @media (max-width: 600px) {
            .result-card { padding: 20px; }
             .career-box { padding: 15px; }
             .content h1 { font-size: 2rem; }
             .btn-action { padding: 10px 20px; font-size: 14px; }
    </style>
</head>
<body>
    <header class="navbar">
        <div class="logo">CareerGuides.pk</div>
        <nav class="nav-links">
            <a href="index.php">Dashboard</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <div class="result-container">
        <div class="result-card">
            <div class="type-badge">Your Result: <?php echo $type; ?></div>
            <h1 style="color: var(--dark);"><?php echo $myResult['title']; ?></h1>
            <p style="font-size: 1.2rem; color: #555; line-height: 1.6;">
                <?php echo $myResult['desc']; ?>
            </p>

            <div class="career-box">
                <h3 style="margin-top:0; color: var(--primary);">
                    <i class='bx bxs-graduation'></i> Suggested Career Paths:
                </h3>
                <p style="font-size: 1.1rem;"><?php echo $myResult['careers']; ?></p>
                <p id="cr-link"> <a href="career_info.html" target="_blank">Explore more career options</a></p>
            </div>

            <div class="next-step-box">
                <p style="margin:0; font-weight:bold; color: #856404;">
                    <i class='bx bxs-lock-open'></i> Final Step Remaining!
                </p>
                <p style="font-size: 0.95rem; color: #856404;">
                    To get your specialized career roadmap, complete the Multiple Intelligence test.
                </p>
                <a href="mi-test.php" class="btn-action">Start Intelligence Test</a>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; 2026 CareerGuides.pk | Developed by Muhammad Jawad</p>
    </footer>
</body>
</html>