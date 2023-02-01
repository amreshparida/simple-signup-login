<?php
include("conn.php");
// This is our index page (home page) of our application
// we will check if user-data is available in session
if(isset($_SESSION["user-data"])){
    header("Location: profile.php");  // if available , redirect to profile page
}else{
    header("Location: login.php");   // if not available, redirect to login page
}
?>