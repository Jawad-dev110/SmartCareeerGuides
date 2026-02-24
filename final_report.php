<?php
session_start();
include 'db_config.php';

// Check if the user is authenticated
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION['user_id'];

// 1. Fetch the latest RIASEC (Interest) result from the database
$riasec_q = mysqli_query($conn, "SELECT top_type FROM test_results WHERE user_id = '$user_id' ORDER BY id DESC LIMIT 1");
$riasec_data = mysqli_fetch_assoc($riasec_q);
$riasec = $riasec_data['top_type'] ?? null;

// 2. Fetch the latest Multiple Intelligence (Strength) result from the database
$mi_q = mysqli_query($conn, "SELECT top_strength FROM mi_results WHERE user_id = '$user_id' ORDER BY id DESC LIMIT 1");
$mi_data = mysqli_fetch_assoc($mi_q);
$mi = $mi_data['top_strength'] ?? null;

// 3. Validation: If any test is missing, redirect the user to complete both assessments
if (!$riasec || !$mi) {
    echo "<script>alert('Requirement: Please complete both RIASEC and MI tests to generate this report.'); window.location.href='index.php';</script>";
    exit();
}

// 4. Core Career Matching Logic (Intersection of Interests and Abilities)
$suggestion = "";
$details = "";

if ($riasec == 'R') {
    if ($mi == 'Bodily-Kinesthetic') { 
        $suggestion = "Mechanical or Civil Engineer"; 
        $details = "Your hands-on physical skills combined with a practical interest in building things make you an ideal candidate for engineering and construction."; 
    }
    else if ($mi == 'Spatial') { 
        $suggestion = "Architect / Urban Planner"; 
        $details = "You possess a strong sense of spatial awareness and a practical approach to design and building structures."; 
    }
    else { 
        $suggestion = "Technical Systems Specialist"; 
        $details = "You excel in environments that require practical problem-solving and technical expertise."; 
    }
} 
else if ($riasec == 'I') {
    if ($mi == 'Logical-Mathematical') { 
        $suggestion = "Medical Researcher or Data Scientist"; 
        $details = "Your high logical reasoning and investigative nature are a perfect match for advanced scientific research and data analysis."; 
    }
    else if ($mi == 'Naturalist') { 
        $suggestion = "Environmental Scientist / Geologist"; 
        $details = "You have a deep interest in analyzing the natural world and solving complex environmental mysteries."; 
    }
    else { 
        $suggestion = "Systems Analyst / Cybersecurity"; 
        $details = "Analytical thinking and critical investigation are your core professional strengths."; 
    }
}
else if ($riasec == 'A') {
    if ($mi == 'Spatial') { 
        $suggestion = "Graphic Designer / 3D Animator"; 
        $details = "Your creative vision paired with spatial intelligence allows you to excel in visual arts and digital design."; 
    }
    else if ($mi == 'Linguistic') { 
        $suggestion = "Content Creator / Screenwriter"; 
        $details = "You express your creativity best through the power of words, storytelling, and linguistic expression."; 
    }
    else { 
        $suggestion = "Creative Arts Professional"; 
        $details = "You thrive in unstructured, creative environments where innovation is the primary goal."; 
    }
}
else if ($riasec == 'S') {
    if ($mi == 'Interpersonal') { 
        $suggestion = "Clinical Psychologist / Counselor"; 
        $details = "Your natural empathy and ability to understand human emotions make you an excellent professional in mental health and counseling."; 
    }
    else if ($mi == 'Linguistic') { 
        $suggestion = "Educational Consultant / Professor"; 
        $details = "You have the passion to help others and the verbal skills required to teach and inspire effectively."; 
    }
    else { 
        $suggestion = "Healthcare / NGO Lead"; 
        $details = "Helping communities and healing individuals are your primary professional callings."; 
    }
}
else if ($riasec == 'E') {
    if ($mi == 'Interpersonal') { 
        $suggestion = "Entrepreneur / Corporate Executive"; 
        $details = "You possess the drive to lead and the social intelligence required to manage and motivate large teams."; 
    }
    else if ($mi == 'Linguistic') { 
        $suggestion = "Legal Professional / Corporate Advocate"; 
        $details = "Persuasive communication and high verbal intelligence make you a formidable leader in legal or public sectors."; 
    }
    else { 
        $suggestion = "Strategic Marketing Manager"; 
        $details = "Managing projects, influencing people, and driving business growth are your top professional traits."; 
    }
}
else if ($riasec == 'C') {
    if ($mi == 'Logical-Mathematical') { 
        $suggestion = "Chartered Accountant / Financial Auditor"; 
        $details = "Extreme accuracy with numbers and a love for organizational structure make you a perfect fit for high-level finance."; 
    }
    else { 
        $suggestion = "Database Administrator / Quality Analyst"; 
        $details = "You excel in managing complex datasets, ensuring precision, and maintaining systematic order."; 
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprehensive Career Analysis - CareerGuides.pk</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f0f2f5; margin: 0; color: #333; }
        .navbar { background: #034e99; height: 60px; display: flex; align-items: center; justify-content: space-between; padding: 0 40px; color: white; }
        .navbar .logo { font-size: 1.3rem; font-weight: bold; }
        .report-container { max-width: 900px; margin: 50px auto; background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 10px 40px rgba(0,0,0,0.12); }
        .header-banner { background: linear-gradient(135deg, #034e99, #002a54); color: white; padding: 50px 20px; text-align: center; }
        .header-banner h1 { margin: 0; font-size: 2.2rem; letter-spacing: 1px; }
        .content { padding: 45px; }
        .score-box { display: flex; justify-content: space-around; margin-bottom: 35px; gap: 20px; }
        .score-card { background: #f8fbff; padding: 25px; border-radius: 12px; border-left: 6px solid #3498db; width: 100%; }
        .score-card h4 { margin: 0 0 10px 0; color: #7f8c8d; text-transform: uppercase; font-size: 0.85rem; }
        .score-card h3 { margin: 0; color: #034e99; font-size: 1.5rem; }
        
        .career-highlight { background: #f0f7ff; padding: 40px; border-radius: 15px; border: 2px dashed #034e99; text-align: center; margin-top: 30px; }
        .career-highlight h2 { color: #034e99; margin-top: 0; font-size: 1.2rem; text-transform: uppercase; }
        .career-highlight h1 { font-size: 2.8rem; margin: 15px 0; color: #2c3e50; }
        
        .explanation-section { margin-top: 40px; line-height: 1.8; }
        .explanation-section h3 { border-bottom: 2px solid #eee; padding-bottom: 10px; color: #034e99; }
        
        .action-btns { text-align: center; margin-top: 50px; display: flex; justify-content: center; gap: 15px; }
        .btn { padding: 14px 30px; border-radius: 6px; border: none; font-weight: bold; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; font-size: 1rem; transition: 0.3s; }
        .btn-print { background: #2c3e50; color: white; }
        .btn-home { background: #034e99; color: white; }
        .btn:hover { opacity: 0.9; transform: translateY(-2px); }

        @media print {
            .navbar, .action-btns { display: none; }
            .report-container { box-shadow: none; margin: 0; width: 100%; }
        }
    </style>
</head>
<body>
    <header class="navbar">
        <div class="logo">CareerGuides.pk Analysis</div>
        <div class="nav-links">
            <a href="index.php" style="color:white; text-decoration:none;">Dashboard</a>
        </div>
    </header>

    <div class="report-container">
        <div class="header-banner">
            <h1>Comprehensive Career Roadmap</h1>
            <p style="opacity: 0.9;">Expert analysis based on Interests and Intelligence Strengths</p>
            <p style="margin-top:15px; font-weight: bold;">User: <?php echo $_SESSION['user_name']; ?></p>
        </div>

        <div class="content">
            <div class="score-box">
                <div class="score-card">
                    <h4><i class='bx bx-heart'></i> Career Interest</h4>
                    <h3><?php echo $riasec; ?> Type</h3>
                    <p style="font-size: 0.9rem; color: #666;">This represents your passion and preferred work environment.</p>
                </div>
                <div class="score-card">
                    <h4><i class='bx bx-brain'></i> Natural Strength</h4>
                    <h3><?php echo $mi; ?></h3>
                    <p style="font-size: 0.9rem; color: #666;">This represents your innate talents and cognitive abilities.</p>
                </div>
            </div>

            

            <div class="career-highlight">
                <h2>Recommended Career Pathway</h2>
                <h1><?php echo $suggestion; ?></h1>
                <p style="font-size: 1.2rem; color: #555; max-width: 600px; margin: 0 auto; line-height: 1.6;">
                    <?php echo $details; ?>
                </p>
            </div>

            <div class="explanation-section">
                <h3>Analysis Overview</h3>
                <p>
                    Our algorithm has identified a "High-Compatibility Match" between your primary personality interest 
                    (<strong><?php echo $riasec; ?></strong>) and your dominant multiple intelligence 
                    (<strong><?php echo $mi; ?></strong>). 
                </p>
                <p>
                    A successful career is built at the intersection of what you love and what you are naturally good at. 
                    Based on your profile, you are most likely to achieve both professional excellence and personal 
                    satisfaction in the field of <strong><?php echo $suggestion; ?></strong>.
                </p>
            </div>

            <div class="action-btns">
                <a href="index.php" class="btn btn-home"><i class='bx bx-home'></i> Dashboard</a>
                <button onclick="window.print()" class="btn btn-print"><i class='bx bx-printer'></i> Save as PDF Report</button>
            </div>
        </div>

        <div style="text-align: center; padding: 25px; color: #888; background: #fafafa; border-top: 1px solid #eee; font-size: 0.9rem;">
            &copy; 2026 CareerGuides.pk | Validating your journey towards a bright future.
        </div>
    </div>
</body>
</html>