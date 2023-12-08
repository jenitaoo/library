<?php
/**
 * login page, 
 * 
 * Allows users to login to an existing account.
 * If they haven't made an account yet, gives user a link to register their account
 */
// Start a session and unset any existing "username" session variable
session_start();
// Unset session variable for username
unset($_SESSION["username"]);

// Connect to database
require_once "..\configs\config.php";

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
                $_SESSION["success"] = "Success: Logged in.";
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
<body class="d-flex flex-column min-vh-100">

<?php require_once "../includes/header.php";?>
<main>
    <!--FORM-->
    <section>
        <div class="container">
            <div class="row">
                 <!--FIRST COLUMN WITH IMAGE-->
                 <div class="col-lg-5">
                     <section>
                        <img src="..\assets\library_shelves.jpg" class="img-fluid fullImage" alt="Library shelves">
                    </section>
                </div>

                <!--SECOND COLUMN WITH FORM-->
                <div class="col-lg-7">
                    <section class="form">
                        <form id="form" method="post" action="">
                            </br>
                            <h1>Log In</h1>
                            <p>Let's get started! To access our services you'll need to login.</br>
                            Don't have an account? <a href="register.php">Register here!</a></p>
                            <div class="input-control">
                                <label for="username">Username</label>
                                <input class="form-control" type="text" name="username" value="" placeholder="John Smith">
                                <div class="error"></div>
                            </div>  
                            <div class="input-control">
                                <label for="username">Password</label>
                                <input class="form-control" type="password" name="password" value="" placeholder="Secure Password">
                                <div class="error"></div>
                            </div>  
                            </br><input class="btn btn-default" type="submit" name="login-submit" value="Log In">
                        </form>      
                    </section>
                </div>
            </div>
         </div>
    </section>  
</main>  


<?php 
// Check session for errors
require_once "error_check.php";
require_once "../includes/footer.php";
?>

</body>
</html>


<?php $conn->close();?>
