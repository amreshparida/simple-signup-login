<?php
session_start(); //session start

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "simple-signup-login";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}


