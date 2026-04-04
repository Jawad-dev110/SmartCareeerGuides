<?php

session_start();
// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
// Programs List (Total 50 Departments cover ho rahay hain categories mein)
$program_list = [
    "Computer Science", "Software Engineering", "Data Science", "Cyber Security", "AI",
    "Electrical Engineering", "Mechanical Engineering", "Civil Engineering", "Chemical Engineering",
    "MBBS", "BDS", "Pharm-D", "Nursing", "Physiotherapy",
    "BBA", "Accounting & Finance", "Economics", "Marketing", "Supply Chain",
    "Psychology", "International Relations", "Mass Comm", "English Literature", "Fine Arts",
    "Architecture", "Fashion Design", "Law (LLB)", "Education", "Sociology"
];

$universities = [
    // --- KARACHI UNIVERSITIES (20) ---
    ["name" => "University of Karachi (KU)", "location" => "Karachi", "type" => "Public", "ranking" => "4", "program" => "Psychology", "fees" => "30k-40k", "min_fsc" => 60],
    ["name" => "NED University", "location" => "Karachi", "type" => "Public", "ranking" => "6", "program" => "Civil Engineering", "fees" => "65k-80k", "min_fsc" => 75],
    ["name" => "IBA Karachi", "location" => "Karachi", "type" => "Public", "ranking" => "8", "program" => "BBA", "fees" => "250k-300k", "min_fsc" => 80],
    ["name" => "FAST NUCES", "location" => "Karachi", "type" => "Private", "ranking" => "3", "program" => "Computer Science", "fees" => "180k-210k", "min_fsc" => 70],
    ["name" => "Dow University (DUHS)", "location" => "Karachi", "type" => "Public", "ranking" => "Med-1", "program" => "MBBS", "fees" => "50k-100k", "min_fsc" => 85],
    ["name" => "Jinnah Sindh Medical Uni", "location" => "Karachi", "type" => "Public", "ranking" => "Med-3", "program" => "BDS", "fees" => "60k-120k", "min_fsc" => 82],
    ["name" => "Habib University", "location" => "Karachi", "type" => "Private", "ranking" => "Top", "program" => "Electrical Engineering", "fees" => "over 300k", "min_fsc" => 70],
    ["name" => "Sir Syed University (SSUET)", "location" => "Karachi", "type" => "Private", "ranking" => "Eng-10", "program" => "Software Engineering", "fees" => "120k-140k", "min_fsc" => 55],
    ["name" => "Dawood University (DUET)", "location" => "Karachi", "type" => "Public", "ranking" => "Eng-15", "program" => "Chemical Engineering", "fees" => "40k-60k", "min_fsc" => 60],
    ["name" => "Indus University", "location" => "Karachi", "type" => "Private", "ranking" => "Gen", "program" => "Fashion Design", "fees" => "90k-110k", "min_fsc" => 50],
    ["name" => "Bahria University", "location" => "Karachi", "type" => "Semi-Govt", "ranking" => "Gen-5", "program" => "Cyber Security", "fees" => "130k-150k", "min_fsc" => 60],
    ["name" => "SZABIST", "location" => "Karachi", "type" => "Private", "ranking" => "Bus-3", "program" => "Mass Comm", "fees" => "160k-180k", "min_fsc" => 55],
    ["name" => "IQRA University", "location" => "Karachi", "type" => "Private", "ranking" => "Bus-1", "program" => "Marketing", "fees" => "100k-130k", "min_fsc" => 50],
    ["name" => "Aga Khan University", "location" => "Karachi", "type" => "Private", "ranking" => "Med-Top", "program" => "MBBS", "fees" => "over 400k", "min_fsc" => 90],
    ["name" => "MAJU (Mohammad Ali Jinnah)", "location" => "Karachi", "type" => "Private", "ranking" => "Gen", "program" => "Data Science", "fees" => "110k-130k", "min_fsc" => 55],
    ["name" => "PAF-KIET", "location" => "Karachi", "type" => "Private", "ranking" => "Eng", "program" => "AI", "fees" => "120k-140k", "min_fsc" => 60],
    ["name" => "Hamdard University", "location" => "Karachi", "type" => "Private", "ranking" => "Gen", "program" => "Pharm-D", "fees" => "140k-160k", "min_fsc" => 60],
    ["name" => "Benazir Bhutto Shaheed Uni", "location" => "Karachi", "type" => "Public", "ranking" => "Gen", "program" => "English Literature", "fees" => "20k-30k", "min_fsc" => 50],
    ["name" => "Greenwich University", "location" => "Karachi", "type" => "Private", "ranking" => "Gen", "program" => "Supply Chain", "fees" => "150k-170k", "min_fsc" => 50],
    ["name" => "SMIU (Sindh Madressatul Islam)", "location" => "Karachi", "type" => "Public", "ranking" => "Gen", "program" => "International Relations", "fees" => "35k-50k", "min_fsc" => 55],

    // --- OVERALL PAKISTAN (30) ---
    ["name" => "NUST", "location" => "Islamabad", "type" => "Public", "ranking" => "1", "program" => "Computer Science", "fees" => "140k-160k", "min_fsc" => 75],
    ["name" => "LUMS", "location" => "Lahore", "type" => "Private", "ranking" => "2", "program" => "Accounting & Finance", "fees" => "over 300k", "min_fsc" => 85],
    ["name" => "GIKI", "location" => "Topi", "type" => "Private", "ranking" => "10", "program" => "Mechanical Engineering", "fees" => "over 300k", "min_fsc" => 70],
    ["name" => "Punjab University (PU)", "location" => "Lahore", "type" => "Public", "ranking" => "Top", "program" => "Law (LLB)", "fees" => "25k-40k", "min_fsc" => 70],
    ["name" => "COMSATS", "location" => "Islamabad", "type" => "Public", "ranking" => "Top 5", "program" => "Software Engineering", "fees" => "110k-130k", "min_fsc" => 70],
    ["name" => "UET Lahore", "location" => "Lahore", "type" => "Public", "ranking" => "Eng-2", "program" => "Electrical Engineering", "fees" => "60k-80k", "min_fsc" => 75],
    ["name" => "Quaid-e-Azam University", "location" => "Islamabad", "type" => "Public", "ranking" => "1", "program" => "Physics", "fees" => "30k-50k", "min_fsc" => 75],
    ["name" => "Peshawar University", "location" => "Peshawar", "type" => "Public", "ranking" => "Gen", "program" => "Sociology", "fees" => "30k-45k", "min_fsc" => 50],
    ["name" => "Bahauddin Zakariya Uni", "location" => "Multan", "type" => "Public", "ranking" => "Gen", "program" => "Architecture", "fees" => "40k-60k", "min_fsc" => 65],
    ["name" => "University of Agriculture", "location" => "Faisalabad", "type" => "Public", "ranking" => "Agri-1", "program" => "Food Sciences", "fees" => "30k-50k", "min_fsc" => 60],
    // ... logic same rahay gi (30 universities complete list yahan extend ki ja sakti hai)
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartCareerGuide | Admission Portal</title>
    <link rel="stylesheet" href="uni_admission_portal.css">
    <style>
        /* New Style for FSc Percentage Filter */
        .fsc-range { width: 100%; margin: 10px 0; }
        .percentage-display { font-weight: bold; color: #034e99; }
    </style>
</head>
<body>

<header class="header">
    <div class="logo">SmartCareer<span>Guide</span> Universities Admission portal</div>
    <a href="dashboard.php" style="color:white; text-decoration:none;">Dashboard</a>
</header>

<div class="main-wrapper">
    <aside class="sidebar">
        <h3>Smart Filters</h3>
        <form id="filterForm">
            <div class="filter-group">
                <label>Your FSc Percentage: <span id="fscVal" class="percentage-display">50</span>%</label>
                <input type="range" id="fscInput" min="45" max="95" value="50" class="fsc-range" oninput="applyFilters()">
            </div>

            <div class="filter-group">
                <label>City</label>
                <input type="text" id="locInput" placeholder="e.g. Karachi" onkeyup="applyFilters()">
            </div>

            <div class="filter-group">
                <label>Program</label>
                <select id="progSelect" onchange="applyFilters()">
                    <option value="">All Programs</option>
                    <?php foreach($program_list as $p): ?>
                        <option value="<?= $p ?>"><?= $p ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="filter-group">
                <label>Sector</label>
                <select id="typeSelect" onchange="applyFilters()">
                    <option value="">All</option>
                    <option value="Public">Public</option>
                    <option value="Private">Private</option>
                </select>
            </div>

            <button type="button" onclick="resetFilters()" class="sidebar-search-btn" style="background:#666;">Reset Filters</button>
        </form>
    </aside>

    <main class="content">
        <div class="search-bar-container">
            <div class="search-input-wrapper">
                <input type="text" id="nameSearch" placeholder="Search University by Name..." onkeyup="applyFilters()">
            </div>
        </div>

        <section class="results-section">
            <div class="results-info">
                <h2>Matched Universities</h2>
                <span class="count-badge" id="resultCount">0 Results</span>
            </div>
            <div class="results-grid" id="uniGrid"></div>
        </section>
    </main>
</div>

<script>
    const allUnis = <?php echo json_encode($universities); ?>;

    function displayUnis(data) {
        const grid = document.getElementById('uniGrid');
        const countBadge = document.getElementById('resultCount');
        grid.innerHTML = "";
        
        countBadge.innerText = data.length + " Results";

        if(data.length === 0) {
            grid.innerHTML = '<div class="no-results-box"><p>Apke marks ya criteria ke mutabiq koi university nahi mili.</p></div>';
            return;
        }

        data.forEach(uni => {
            grid.innerHTML += `
                <div class="uni-card">
                    <div class="card-header">
                        <span class="type-pill ${uni.type.toLowerCase()}">${uni.type}</span>
                        <span class="rank-label">Rank: ${uni.ranking}</span>
                    </div>
                    <h3>${uni.name}</h3>
                    <div class="card-body">
                        <p>📍 <strong>City:</strong> ${uni.location}</p>
                        <p>🎓 <strong>Key Program:</strong> ${uni.program}</p>
                        <p>💰 <strong>Estimated Fee:</strong> ${uni.fees}</p>
                        <p>📉 <strong>Min Merit:</strong> ${uni.min_fsc}%</p>
                    </div>
                    <button class="view-details" onclick="alert('Admission Details for ${uni.name} Coming Soon!')">Check Admission</button>
                </div>
            `;
        });
    }

    function applyFilters() {
        const fscMarks = document.getElementById('fscInput').value;
        document.getElementById('fscVal').innerText = fscMarks;

        const nameQ = document.getElementById('nameSearch').value.toLowerCase();
        const locQ = document.getElementById('locInput').value.toLowerCase();
        const progQ = document.getElementById('progSelect').value;
        const typeQ = document.getElementById('typeSelect').value;

        const filtered = allUnis.filter(uni => {
            const matchesFsc = fscMarks >= uni.min_fsc; // Eligibility check
            const matchesName = uni.name.toLowerCase().includes(nameQ);
            const matchesLoc = uni.location.toLowerCase().includes(locQ);
            const matchesProg = progQ === "" || uni.program === progQ;
            const matchesType = typeQ === "" || uni.type === typeQ;

            return matchesFsc && matchesName && matchesLoc && matchesProg && matchesType;
        });

        displayUnis(filtered);
    }

    function resetFilters() {
        document.getElementById('filterForm').reset();
        document.getElementById('fscVal').innerText = "50";
        applyFilters();
    }

    window.onload = applyFilters;
</script>

</body>
</html>