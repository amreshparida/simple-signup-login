<?php
include("conn.php");

if(isset($_POST['logout'])){
    session_unset();
    session_destroy();
    header("Location: login.php");  // now we have removed the session, redirecting to login page
}