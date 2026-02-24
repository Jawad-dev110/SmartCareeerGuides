<?php
// Start the session to track the user
session_start();
include 'db_config.php';

if(isset($_POST['login-btn'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);  // Sanitize the email input to prevent SQL injection
    $password = $_POST['password'];

    // Check if user exists
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        
        // Verify the hashed password
        if(password_verify($password, $user['password'])) {
            // Login success: Store user data in session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['full_name'];

            echo "<script>alert('Login Successful! Welcome back.'); window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('Invalid Password!'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('No account found with this email!'); window.history.back();</script>";
    }
}
mysqli_close($conn);
?>