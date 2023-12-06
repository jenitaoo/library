<?php
require_once "config.php";

// Start a session and unset any existing "username" session variable
session_start();

// Check session for errors
// Display error message if set
if (isset($_SESSION["error"])) {
    echo('<p style="color:red">' . $_SESSION["error"] . "</p>\n");
    unset($_SESSION["error"]);
}

unset($_SESSION["username"]);

// Check if the form is submitted
if ( isset($_POST['login-submit'])) {
    if (isset($_POST["username"]) && isset($_POST["user_pw"])) { 
        // Get the values entered by the form and clean them
        $username = $conn->real_escape_string($_POST["username"]);
        $password = $conn->real_escape_string($_POST["user_pw"]);
    
        // Query the database to check if the username and password match
        $sql = "SELECT * FROM user_account WHERE username = '$username' AND user_pw = '$password'";
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
                // If no matching record is found, set an error message and redirect to login.php
                $_SESSION["error"] = "Incorrect username or password.";
                header('Location: login.php');
                return;
            }
        } else {
            // Handle the case where the query failed
            $_SESSION["error"] = "Error executing the query.";
            header('Location: login.php');
            return;
        } 
    } else if (count($_POST) > 0) { 
        // If form is submitted but required information is missing, set an error message and redirect to login.php
        $_SESSION["error"] = "Missing Required Information";
        header('Location: login.php');
        return;
    }
}   

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
</head>
<body>

<h1>Log In</h1>



<form method="post">
    <p>Username: <input type="text" name="username" value=""></p>
    <p>Password: <input type="password" name="user_pw" value=""></p> 
    <p><input type="submit" name="login-submit"value="Log in"></p>
</form>
</body>
</html>
