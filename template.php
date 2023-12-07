<?php
/**
 * Name
 * 
 * Description
 */
session_start();

require_once "..\configs\config.php";

// Check session for errors
// Display success message if set
if (isset($_SESSION["success"])) {
    echo('<p style="color:green">' . $_SESSION["success"] . "</p>\n");
    unset($_SESSION["success"]);
}
// Display error message if set
if (isset($_SESSION["error"])) {
    echo('<p style="color:red">' . $_SESSION["error"] . "</p>\n");
    unset($_SESSION["error"]);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search</title>
</head>
<body>


<?php

// Check the session, if user is not already logged in then provide link to login page
if (!isset($_SESSION["username"])) { 
    // User not logged in
    echo "Please <a href='login.php'>Log In</a> to start.";
} // otherwise they're logged in, show them the links to other pages
else { 
    // User logged in
    require_once "../includes/header.php";
}

?>



<?php require_once "../includes/footer.php";?>

</body>
</html>


<?php $conn->close();?>