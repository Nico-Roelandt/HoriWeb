<?php
// Include the dbConnect file
require_once("../PageParts/dbConnect.php");

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Call the newAccount() function from dbConnect file
    newAccount($_POST['firstname'], $_POST['name'], $_POST['username'], $_POST['password'], $_POST['confirm'], $_POST['date'], $_POST['mail']);
}

// Go back to the index page
header('Location: ../index.php');
?>