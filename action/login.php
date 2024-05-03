<?php
// Include the dbConnect file
require_once("dbConnect.php");

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Get the username and password from the form
    $username = $_GET['username'];
    $password = $_GET['password'];

    // Call the login() function from dbConnect file
    login($username, $password);
}

// Function to handle login
?>