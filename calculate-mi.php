<?php
session_start();
include 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['mi_data'])) {    // Check if the form was submitted and the expected data is present
    $data = json_decode($_POST['mi_data'], true);  // Decode the JSON data sent from the client-side, which should be an array of objects with 'category' and 'score' properties
    $user_id = $_SESSION['user_id'];

    $totals = [
        'Linguistic' => 0, 'Logical-Mathematical' => 0, 'Spatial' => 0,
        'Bodily-Kinesthetic' => 0, 'Musical' => 0, 'Interpersonal' => 0,
        'Intrapersonal' => 0, 'Naturalist' => 0
    ];
    // Loop through the decoded data and sum up the scores for each category
    foreach ($data as $row) {
        $totals[$row['category']] += $row['score'];
    }
     // Sort the totals in descending order to find the category with the highest score, which will be considered the user's dominant intelligence type
    arsort($totals);
    $top_strength = key($totals);
    $json_all = json_encode($totals);
     // Prepare and execute the SQL statement to insert the results into the 'mi_results' table, associating it with the current user
    $stmt = $conn->prepare("INSERT INTO mi_results (user_id, top_strength, all_scores_json) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $top_strength, $json_all);

    if ($stmt->execute()) {
        // Redirection to a combined results page
        header("Location: final_report.php");
        exit();
    }
}
?>