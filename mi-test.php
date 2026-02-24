<?php 
session_start();
include 'db_config.php'; 

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

// Fetching MI questions
$sql = "SELECT * FROM mi_questions ORDER BY id ASC";
$result = mysqli_query($conn, $sql);
$questions = [];
while($row = mysqli_fetch_assoc($result)) { 
    $questions[] = $row; 
}
$json_questions = json_encode($questions);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multiple Intelligence Test - CareerGuides.pk</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        :root {
            --primary: #2c3e50;
            --navbar: #034e99;
            --bg: #f4f7f6;
            --accent: #3498db;
        }

        body { 
            font-family: 'Segoe UI', Arial, sans-serif; 
            background: var(--bg); 
            margin: 0; 
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .navbar { background: var(--navbar); height: 60px; display: flex; align-items: center; padding: 0 20px; color: white; }
        .container { max-width: 800px; margin: 40px auto; padding: 20px; flex: 1; }
        .test-card { background: white; padding: 35px; border-radius: 12px; box-shadow: 0 8px 20px rgba(0,0,0,0.08); margin-bottom: 20px; }
        
        .btn { background: var(--navbar); color: white; padding: 12px 30px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; transition: 0.3s; }
        .btn:hover { background: #023568; transform: translateY(-2px); }
        .btn:disabled { background: #ccc; cursor: not-allowed; transform: none; }

        .option-label { display: block; padding: 12px; border: 1px solid #ddd; border-radius: 8px; margin-bottom: 10px; cursor: pointer; transition: 0.2s; }
        .option-label:hover { background: #f0f7ff; border-color: var(--navbar); }
        
        .progress-container { background: #eee; border-radius: 4px; margin-bottom: 20px; height: 10px; overflow: hidden; }
        #progress-bar { height: 100%; background: var(--accent); width: 0%; transition: 0.4s; }

        /* Footer Fix */
        footer {
            background: var(--primary);
            color: white;
            text-align: center;
            padding: 40px 20px;
            margin-top: auto; /* Pushes footer to bottom */
        }
        .footer-content p { margin: 8px 0; }
        .social-links { margin-top: 15px; color: #bdc3c7; font-size: 14px; }
    </style>
</head>
<body>
    <header class="navbar">
        <div class="logo">CareerGuides.pk - MI Assessment</div>
    </header>

    <div class="container">
        <div id="instruction-box" class="test-card" style="text-align: center;">
            <h2 style="color: var(--navbar);">Multiple Intelligence Assessment</h2>
            <p>Discover your natural strengths across 8 intelligence areas.</p>
            <div style="text-align: left; margin: 25px auto; max-width: 500px; background: #f9f9f9; padding: 20px; border-radius: 8px; border-left: 5px solid var(--accent);">
                <p>💡 <strong>Instructions:</strong></p>
                <ul style="line-height: 1.8;">
                    <li>Read each statement about your skills.</li>
                    <li>Rate from 1 (Not like me) to 5 (Exactly like me).</li>
                    <li>Honest answers provide the best career matches.</li>
                </ul>
            </div>
            <button type="button" onclick="startTest()" class="btn">Start Intelligence Test</button>
        </div>

        <div id="test-area" class="test-card" style="display: none;">
            <div class="progress-container">
                <div id="progress-bar"></div>
            </div>
            <p id="q-count" style="color: #888; font-weight: bold;"></p>
            <h3 id="q-text" style="margin-bottom: 25px; color: var(--primary);"></h3>
            
            <div id="options">
                <label class="option-label"><input type="radio" name="score" value="5" onchange="enableBtn()"> Exactly Like Me</label>
                <label class="option-label"><input type="radio" name="score" value="4" onchange="enableBtn()"> Mostly Like Me</label>
                <label class="option-label"><input type="radio" name="score" value="3" onchange="enableBtn()"> Somewhat Like Me</label>
                <label class="option-label"><input type="radio" name="score" value="2" onchange="enableBtn()"> A Little Like Me</label>
                <label class="option-label"><input type="radio" name="score" value="1" onchange="enableBtn()"> Not Like Me At All</label>
            </div>
            
            <div style="margin-top: 25px; overflow: hidden;">
                <button id="next-btn" class="btn" onclick="nextQuestion()" disabled style="float: right;">Next Question</button>
            </div>
        </div>

        <div id="submit-area" class="test-card" style="display: none; text-align: center;">
            <i class='bx bxs-check-circle' style='font-size: 5rem; color: #27ae60;'></i>
            <h2 style="color: #27ae60;">Assessment Complete!</h2>
            <p>Your responses have been recorded. Click below to analyze your results.</p>
            <form action="calculate-mi.php" method="POST">
                <input type="hidden" name="mi_data" id="final-mi-results">
                <button type="submit" class="btn" style="background:#27ae60;">Calculate My Strengths</button>
            </form>
        </div>
    </div>

    <footer>
        <div class="footer-content">
            <p>&copy; 2026 <strong>CareerGuides.pk</strong>. All rights reserved.</p>
            <p>Developed by <span style="color: var(--accent);">Muhammad Jawad</span></p>
            <div class="social-links">
                Facebook: CareerGuides.pk | LinkedIn: CareerGuides.pk | WhatsApp: wa.me/CareerGuides.pk
            </div>
        </div>
    </footer>

    <script>
        // Use JSON.parse to ensure data is handled correctly
        const questions = <?php echo $json_questions; ?>;
        let currentIdx = 0;
        let userResponses = [];

        function startTest() {
            console.log("Test Started"); // For Debugging
            if(questions.length === 0) {
                alert("No questions found in database!");
                return;
            }
            document.getElementById('instruction-box').style.display = 'none';
            document.getElementById('test-area').style.display = 'block';
            showQuestion();
        }

        function showQuestion() {
            const q = questions[currentIdx];
            document.getElementById('q-count').innerText = `Question ${currentIdx + 1} of ${questions.length}`;
            document.getElementById('q-text').innerText = q.question_text;
            
            // Reset radio buttons
            const radios = document.getElementsByName('score');
            radios.forEach(r => r.checked = false);
            
            // Progress Bar
            const progress = ((currentIdx + 1) / questions.length) * 100;
            document.getElementById('progress-bar').style.width = progress + '%';
            
            document.getElementById('next-btn').disabled = true;
        }

        function enableBtn() {
            document.getElementById('next-btn').disabled = false;
        }

        function nextQuestion() {
            const selected = document.querySelector('input[name="score"]:checked');
            if(!selected) return;

            userResponses.push({ 
                category: questions[currentIdx].category, 
                score: parseInt(selected.value) 
            });

            currentIdx++;

            if (currentIdx < questions.length) { 
                showQuestion(); 
            } else {
                finishTest();
            }
        }

        function finishTest() {
            document.getElementById('test-area').style.display = 'none';
            document.getElementById('submit-area').style.display = 'block';
            document.getElementById('final-mi-results').value = JSON.stringify(userResponses);
        }
    </script>
</body>
</html>