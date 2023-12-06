<?php
/**
 * Registration page
 * 
 * Users can enter in their information and a new record is created in the database
 */

// Get the page ready, start sessions and include files
session_start();
require_once "../configs/config.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>

<?php
// Display error message if set
if (isset($_SESSION["error"])) {
echo('<p style="color:red">' . $_SESSION["error"] . "</p>\n");
unset($_SESSION["error"]);
}

// Check if the user is logged in (returns true if username is set)
if (isset($_SESSION["username"])) { 
    // User is logged in
    echo "yeah you're logged in";
}
else {
    //
    echo "mf is NOT logged in";
}

?>
    


<?php require_once "../includes/footer.php";?>


</body>
</html>


<?php $conn->close();?>