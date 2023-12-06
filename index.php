<?php
session_start();

require_once "config.php";

// Check if session started successfully
if(isset($_SESSION["error"])){
    echo"<p style='color:red'>Error </p>" . $_SESSION["error"];
    unset($_SESSION["error"]);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>

<?php


// Check the session, if user is not already logged in then provide link to login page
if (!isset($_SESSION["username"])) { 
    echo "Please <a href='pages/authentication/login.php'>Log In</a> to start.";
} // otherwise they're logged in, show them the links to other pages
else { 
    require_once "includes/header.php";
    echo "You're logged in!";
    
}


?>


<?php require_once "includes/footer.php";?>

</body>
</html>


<?php $conn->close();?>