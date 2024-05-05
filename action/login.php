<?php
// Include the dbConnect file
require_once("../PageParts/dbConnect.php");

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Call the login() function from dbConnect file
    login($username, $password);
}

// Go back to the index page
header('Location: ../index.php');
?>