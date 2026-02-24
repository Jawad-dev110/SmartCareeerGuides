<?php
session_start();  // Start the session to access user information and manage authentication
include 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['test_data'])) {
    // 1. receive and decode test results from the form submission
    $test_results = json_decode($_POST['test_data'], true);  // This should be an array of objects with 'category' and 'score' properties
    $user_id = $_SESSION['user_id'];

    // 2. initialize category totals
    $category_totals = [
        'R' => 0, 'I' => 0, 'A' => 0, 
        'S' => 0, 'E' => 0, 'C' => 0
    ];

    // 3.adding scores to respective categories
    foreach ($test_results as $res) {
        $cat = $res['category'];
        $score = $res['score'];
        $category_totals[$cat] += $score;
    }

    // 4. sort categories by score and identify the top category
    arsort($category_totals); // sort in descending order
    $top_type = key($category_totals); // get the category with the highest score
    $scores_json = json_encode($category_totals);

    // 5.save the result in the database
    $stmt = $conn->prepare("INSERT INTO test_results (user_id, top_type, scores_json) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $top_type, $scores_json);

    if ($stmt->execute()) {
        // 6. redirect to results page with the top category as a query parameter
        header("Location: results-view.php?type=" . $top_type);
        exit();
    } else {
        echo "Error saving results: " . $conn->error;  // Handle database errors gracefully
    }
} else {
    header("Location: test.php");
    exit();
}
?>