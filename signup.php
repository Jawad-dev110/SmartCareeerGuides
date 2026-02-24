<?php
// Include database connection
include 'db_config.php';

if(isset($_POST['signup-btn'])) {      // Check if the signup form was submitted
    // Get and sanitize input data
    $name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = $_POST['password'];
    $c_pass = $_POST['confirm_password'];

    // Check if passwords match
    if($pass !== $c_pass) {
        echo "<script>alert('Passwords do not match!'); window.history.back();</script>";
        exit();
    }

    // Check if email already exists
    $check_email = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $check_email);
    if(mysqli_num_rows($result) > 0) {
        echo "<script>alert('Email already registered!'); window.history.back();</script>";
        exit();
    }

    // Hash the password for security
    $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

    // Insert user into 'users' table
    $sql = "INSERT INTO users (full_name, email, password) VALUES ('$name', '$email', '$hashed_password')";

    if(mysqli_query($conn, $sql)) {
        echo "<script>alert('Account created successfully! Please Login.'); window.location.href='login.html';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
mysqli_close($conn);  // Close the database connection
?>