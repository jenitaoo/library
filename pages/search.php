<?php
/**
 * Display and search book records page
 * 
 * Users can view all book records in the database, 5 rows of per page
 * They should be able to do a partial search for book title and/or author and by book category description in a dropdown menu
 */

// Get the page ready, start sessions and include files
session_start();
require_once "../configs/config.php";

// Check session for errors
// Display success message if set
if (isset($_SESSION["success"])) {
    echo('<p style="color:green">' . $_SESSION["success"] . "</p>\n");
    unset($_SESSION["sucess"]);
}
// Display error message if set
if (isset($_SESSION["error"])) {
    echo('<p style="color:red">' . $_SESSION["error"] . "</p>\n");
    unset($_SESSION["error"]);
}

// Check the session, if user is not already logged in then provide link to login page
if (!isset($_SESSION["username"])) { 
    echo "Please <a href='login.php'>Log In</a> to start.";
} // otherwise they're logged in, show them the links to other pages
else { 
    require_once "../includes/header.php";
    echo "You're logged in!";
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>

    


<?php require_once "../includes/footer.php";?>


</body>
</html>


<?php $conn->close();?>