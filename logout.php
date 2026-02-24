<?php
session_start();
session_unset(); // Unset all session variables to clear user data from the session
session_destroy(); // destroy the session to log the user out
header("Location: index.php"); // Redirect to homepage after logout
exit();
?>