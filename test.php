<?php 
// test.php - RIASEC Career Interest Test Page

session_start(); // Start session to check user login status

include 'db_config.php'; // Include database configuration for fetching questions

// Check if user is logged in, if not redirect to login page with an alert
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please login first to take the test.'); window.location.href='login.html';</script>";
    exit();   //
}
// Fetch user information for personalized greeting
$isLoggedIn = isset($_SESSION['user_id']);            //
$userName = $isLoggedIn ? $_SESSION['user_name'] : "Guest";  
 //
// Fetch RIASEC questions from the database
$sql = "SELECT * FROM riasec_questions ORDER BY id ASC";
$result = mysqli_query($conn, $sql);
$questions = [];

// Convert questions to JSON for use in JavaScript
while($row = mysqli_fetch_assoc($result)) {
    $questions[] = $row;
}

// Encode questions as JSON for JavaScript
$json_questions = json_encode($questions);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Career Interest Test - CareerGuides.pk</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'> // Boxicons for icons
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
            background-color: #f4f7f6;
        }

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

        .logo { font-size: 1.2rem; font-weight: bold; }
        .nav-links-top a {
            color: white; text-decoration: none; margin-left: 20px; font-size: 14px;
        }

        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
        }

        .test-card {
            background: white;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
        }

        .progress-container {
            background: #eee;
            height: 8px;
            border-radius: 4px;
            margin-bottom: 25px;
            overflow: hidden;
        }

        #progress-bar {
            height: 100%;
            background: #034e99;
            width: 0%;
            transition: 0.4s ease;
        }

        .option-label {
            display: block;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 10px;
            cursor: pointer;
            transition: 0.2s;
        }

        .option-label:hover { background: #f0f7ff; border-color: #034e99; }

        .btn {
            background: #034e99;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
            display: inline-block;
        }

        .btn-outline {
            background: transparent;
            border: 2px solid #034e99;
            color: #034e99;
            margin-top: 10px;
        }

        .btn:disabled { opacity: 0.5; cursor: not-allowed; }

        footer {
            background: var(--primary);
            color: white;
            text-align: center;
            padding: 20px;
            margin-top: 100px;
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
            <!-- // Show personalized greeting and logout option if logged in, otherwise show login link -->
            <?php if($isLoggedIn): ?>
                <span style="margin-left:20px; font-weight:bold; color:#f1c40f;">Hi, <?php echo $userName; ?></span>
                <a href="logout.php">Logout</a>
            <?php else: ?>
                <a href="login.html">Login</a>
            <?php endif; ?>
        </nav>
    </header>

    <div class="container">
        <div id="instruction-box" class="test-card" style="text-align: center;">
            <h2 style="color: #034e99; margin-top:0;">RIASEC Career Interest Test</h2>
            <p style="color: #666; font-size: 1.1rem;">Follow these easy steps to see where your interests are:</p>
            <div style="text-align: left; margin: 20px auto; max-width: 500px;">
                <p><strong>Step 1:</strong> Read each statement carefully.</p>
                <p><strong>Step 2:</strong> There are no wrong answers. Be honest!</p>
                <p><strong>Step 3:</strong> Rate 1 (Strongly Disagree) to 5 (Strongly Agree).</p>
            </div>
            <button onclick="startTest()" class="btn">Start RIASEC Test</button>
            <br>
            <a href="mi-test.php" class="btn btn-outline">Switch to Multiple Intelligence Test</a>
        </div>

        <div id="test-area" class="test-card" style="display: none;">
            <div class="progress-container">
                <div id="progress-bar"></div>
            </div>
            <p id="q-count" style="color: #888; font-weight: bold;"></p>
            <h3 id="q-text" style="margin-bottom: 25px; color: #333;"></h3>

            <div id="options-container">
                <label class="option-label"><input type="radio" name="score" value="5" onclick="enableBtn()"> Strongly Agree</label>
                <label class="option-label"><input type="radio" name="score" value="4" onclick="enableBtn()"> Agree</label>
                <label class="option-label"><input type="radio" name="score" value="3" onclick="enableBtn()"> Neutral</label>
                <label class="option-label"><input type="radio" name="score" value="2" onclick="enableBtn()"> Disagree</label>
                <label class="option-label"><input type="radio" name="score" value="1" onclick="enableBtn()"> Strongly Disagree</label>
            </div>

            <div style="text-align: right; margin-top: 20px;">
                <button id="next-btn" class="btn" onclick="nextQuestion()" disabled>Next Question</button>
            </div>
        </div>

        <div id="submit-area" class="test-card" style="display: none; text-align: center;">
            <h2 style="color: #27ae60;">RIASEC Test Completed!</h2>
            <p>You have successfully completed the interest assessment.</p>
            
            <form action="calculate_result.php" method="POST" style="margin-bottom: 20px;">
                <input type="hidden" name="test_data" id="final-results">
                <button type="submit" class="btn" style="background:#27ae60;">Show RIASEC Results</button>
            </form>

            <div style="border-top: 1px solid #eee; padding-top: 20px;">
                <p style="color: #666;">For a complete career recommendation, we suggest taking the Multiple Intelligence test as well.</p>
                <a href="mi-test.php" class="btn" style="background: #3498db;">Proceed to MI Test</a>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; 2026 CareerGuides.pk. All rights reserved.</p>
        <pre>Developed by Muhammad Jawad</pre>
    </footer>

    <script>
        //
        const questions = <?php echo $json_questions; ?>;
        let currentIdx = 0;
        let userResponses = [];
        // Start the test by hiding instructions and showing the first question
        function startTest() {
            document.getElementById('instruction-box').style.display = 'none';
            document.getElementById('test-area').style.display = 'block';
            showQuestion();
        }
        // Display the current question and update progress
        function showQuestion() {
            const q = questions[currentIdx];
            document.getElementById('q-count').innerText = `Question ${currentIdx + 1} of 42`;
            document.getElementById('q-text').innerText = q.question_text;
            // Reset radio buttons and disable next button until an option is selected
            const radios = document.getElementsByName('score');
            radios.forEach(r => r.checked = false);
            // Update progress bar based on current question index
            document.getElementById('progress-bar').style.width = ((currentIdx + 1) / 42 * 100) + '%';
            document.getElementById('next-btn').disabled = true;
        }
         // Enable the next button once an option is selected
        function enableBtn() {
            document.getElementById('next-btn').disabled = false;
        }
         // Save the user's response and move to the next question or finish the test if it was the last question
        function nextQuestion() {
            const selected = document.querySelector('input[name="score"]:checked').value;  //
            userResponses.push({
                category: questions[currentIdx].category,  // Save the category of the question for later analysis
                score: parseInt(selected)
            });
           // Increment the current question index and show the next question or finish the test if all questions have been answered
            currentIdx++;
            if (currentIdx < questions.length) {
                showQuestion();
            } else {
                finishTest();
            }
        }
         // Once the test is finished, hide the test area and show the submit area with the user's responses ready to be sent to the server for result calculation
        function finishTest() {
            document.getElementById('test-area').style.display = 'none';
            document.getElementById('submit-area').style.display = 'block';
            document.getElementById('final-results').value = JSON.stringify(userResponses);
        }
    </script>
</body>
</html>