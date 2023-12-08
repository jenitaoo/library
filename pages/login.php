<?php
/**
 * login page, allows users to login if they haven't already.
 * if their login doesn't work, send them over to register an account
 */
// Start a session and unset any existing "username" session variable
session_start();
// unset session variable for username
unset($_SESSION["username"]);

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

// Check if the form is submitted
if ( isset($_POST['login-submit'])) {
    echo $_POST["username"];
    // Check if both fields were filled out
    // If yes, then check if they match
    if (isset($_POST["username"]) && isset($_POST["password"])) { 
        // Get the values entered by the form and clean them
        $username = $conn->real_escape_string($_POST["username"]);
        $password = $conn->real_escape_string($_POST["password"]);
    
        // Query the database to check if the username and password match
        $sql = "SELECT * FROM Users WHERE Username = '$username' AND Password = '$password'";
        $result = $conn->query($sql);

        // check if the query ran successfully
        if ($result) { 
            // If a matching record is found, set the "username" session variable and redirect to index.php
            if ($result->num_rows > 0) {
                $_SESSION["username"] = $username;
                $_SESSION["success"] = "Logged in.";
                header('Location: index.php');
                return;
            } else {
                // If no matching record is found, set an error message and redirect to  login.php
                $_SESSION["error"] = "Incorrect username or password. Would you like to <a href='register.php'>register?</a>";
                header('Location: login.php');
                return;
            }
        } else {
            // Handle the case where the query failed
            $_SESSION["error"] = "Error executing the query.";
            header('Location: login.php');
            return;
        } 
    } else { 
        // If form is submitted but required information is missing, set an error message and redirect to login.php
        $_SESSION["error"] = "Missing Required Information";
        header('Location: login.php');
        return;
    }
}   

?>


<!DOCTYPE html>
<html lang="en">
    <!--REQUIRED META TAGS-->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--TITLE-->
    <title>Log In</title>

    <!--LINK IN FONTS-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather&family=Montserrat&display=swap" rel="stylesheet">

    <!--LINK IN BOOTSTRAP ICONS AND STYLESHEETS-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!--LINK IN STYLESHEETS-->
    <link rel="stylesheet" href="..\styles\style.css">
<body>

<h1>Log In</h1>

<form method="post">
    <p>Username: <input type="text" name="username" value=""></p>
    <p>Password: <input type="password" name="password" value=""></p> 
    <p><input type="submit" name="login-submit"value="Log in"></p>
</form>

<p>Don't have an account? <a href="register.php">Register here.</a></p>

<?php require_once "../includes/footer.php";?>

</body>
</html>


<?php $conn->close();?>
