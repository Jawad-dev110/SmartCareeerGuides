<?php 
// Start session to access logged-in user's info
session_start();

// Include the database connection file
include 'db_config.php'; 

// Check if the user is actually logged in before allowing registration
if(!isset($_SESSION['user_id'])) {
    echo "<script>
            alert('Please login first to fill the registration form.');
            window.location.href='login.html';
          </script>";
    exit();
}

// Check if the form was submitted via the POST method
if(isset($_POST['reg-submit-btn'])) {
    
    // Retrieve form data and sanitize it
    $fname = mysqli_real_escape_string($conn, $_POST['first_name']);
    $lname = mysqli_real_escape_string($conn, $_POST['last_name']);
    $age   = mysqli_real_escape_string($conn, $_POST['age']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $qual  = mysqli_real_escape_string($conn, $_POST['qualification']); 
    $inst  = mysqli_real_escape_string($conn, $_POST['institute']);     

    // GET DYNAMIC USER ID: Now using the ID of the person who is logged in
    $user_id = $_SESSION['user_id']; 

    // Prepare the SQL query to insert data into student_profiles
    $sql = "INSERT INTO student_profiles (user_id, first_name, last_name, age, qualification, institute) 
            VALUES ('$user_id', '$fname', '$lname', '$age', '$qual', '$inst')";

    // Execute the query
    if(mysqli_query($conn, $sql)) {
        echo "<script>
                alert('Registration Successful! Your profile is now linked to your account.');
                window.location.href='index.php';
              </script>";
    } else {
        // This will show if there's still a database issue
        echo "Database Error: " . mysqli_error($conn);
    }

} else {
    echo "Access Denied! Please submit the form.";
}

// Close the connection
mysqli_close($conn);
?>