<?php
/**
 * Registration page
 * 
 * Users can enter in their information and a new record is created in the database
 */

// Get the page ready, start sessions and include files
session_start();
require_once "../configs/config.php";

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

// Check if the register form was submitted
if (isset($_POST['register-submit'])) {
    // Check if all fields were filled 
    if(
        isset($_POST['uname']) && isset($_POST['pass']) && isset($_POST['confpass']) && isset($_POST['fname']) && isset($_POST['sname']) &&
        isset($_POST['add1']) && isset($_POST['add2']) && isset($_POST['city']) && isset($_POST['tel']) && isset($_POST['mob'])
    ){
        // No fields empty
        // Declare php vars
        $username = $password = $confpassword = $firstname = $surname = $address1 = $address2 = $city = $telephone = $mobile = "";

        // Take the values submitted from the form and store in php values
        $username = $_POST['uname'];
        $password = $_POST['pass'];
        $confpassword = $_POST['confpass'];
        $firstname = $_POST['fname'];
        $surname = $_POST['sname'];
        $address1 = $_POST['add1'];
        $address2 = $_POST['add2'];
        $city = $_POST['city'];
        $telephone = $_POST['tel'];
        $mobile = $_POST['mob'];

        //Check if username is unique
        $sql = "SELECT * FROM `users` WHERE `Username` = '$username'";
        $result = $conn->query($sql);
        // Check record with username already exists in database, 
        if($result->num_rows > 0) {
            $_SESSION["error"] = "Error: This username already exists";
            header("Location: register.php");
            return;
        }

        // Check if password confirmation matches up
        if($password === $confpassword){
            // Create a new record in the database
            $sql = "INSERT INTO `users` (`Username`, `Password`, `Firstname`, `Surname`, `AddressLine1`, `AddressLine2`, `City`, `Telephone`, `Mobile`)
            VALUES ('$username', '$password','$firstname', '$surname', '$address1', '$address2', ' $city', '$telephone', '$mobile')";
            $result = $conn->query($sql);

            // Check if it worked
            if ($result === TRUE) {
                $_SESSION["success"] = "Success: Account registered successfully.";
                header("Location: index.php"); 
            } else {
                // Handle the case where the query failed
                $_SESSION["error"] = "Error executing the query.";
                header('Location: register.php');
                return;
            } 
        } else {
            $_SESSION["error"] = "Passwords do not match";
            header('Location: register.php');
            return;
        }
    } else {
        // One or more fields empty, tell error
        $_SESSION["error"] = "Missing Required Information";
        header('Location: register.php');
        return;
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!--REQUIRED META TAGS-->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--TITLE-->
    <title>Register</title>

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

<?php
// Display error message if set
if (isset($_SESSION["error"])) {
echo('<p style="color:red">' . $_SESSION["error"] . "</p>\n");
unset($_SESSION["error"]);
}

// Check if the user is not logged in (returns true if username is not set)
if (!isset($_SESSION["username"])) { 
    // User is not logged in
    // Show the user a form and get their details to register
    require_once "..\includes\header.php";
?>   
    <main>
        <!--FORM-->
        <section>
            <div class="container">
                <div class="row">
                     <!--FIRST COLUMN WITH IMAGE-->
                     <div class="col-lg-5">
                         <section>
                            <img src="..\assets\really-long-library-shelves.jpg" class="img-fluid fullImage" alt="Book shelves">
                            </br></br><p>Already have an account? <a href="login.php">Log in here!</a></p>
                        </section>
                    </div>
    
                    <!--SECOND COLUMN WITH FORM-->
                    <div class="col-lg-7">
                        <section class="form">
                            <form id="form" method="post" action="">
                                <h1>Register An Account</h1>
                                <div class="input-control">
                                    <label for="uname">Username:</label>
                                    <input class="form-control" type="text" id="uname" name="uname" placeholder="John Smith" required>
                                    <div class="error"></div>
                                </div>
                                <div class="input-control">
                                    <label for="pass">Password (6 characters minimum):</label>
                                    <input class="form-control" type="password" minlength="6" id="pass" name="pass" required>
                                    <div class="error"></div>
                                </div>

                                <div class="input-control">
                                    <label for="confpass">Confirm Password:</label>
                                    <input class="form-control" type="password"  minlength="6" id="confpass" name="confpass" required>
                                    <div class="error"></div>
                                </div>

                                <div class="input-control">
                                    <label for="fname">First Name:</label>
                                    <input class="form-control" type="text" id="fname" name="fname" required>
                                    <div class="error"></div>
                                </div>

                                <div class="input-control">
                                    <label for="sname">Surname:</label>
                                    <input class="form-control" type="text" id="sname" name="sname" required>
                                    <div class="error"></div>
                                </div>

                                <div class="input-control">
                                    <label for="add1">Address Line 1:</label>
                                    <input  class="form-control" type="text" id="add1" name="add1" required>
                                    <div class="error"></div>
                                </div>

                                <div class="input-control">
                                    <label for="add2">Address Line 2:</label>
                                    <input class="form-control" type="text" id="add2" name="add2" required>
                                    <div class="error"></div>
                                </div>

                                <div class="input-control">
                                    <label for="city">City:</label>
                                    <input  class="form-control" type="text" id="city" name="city" required>
                                    <div class="error"></div>
                                </div>

                                <div class="input-control">
                                    <label for="tel">Telephone:</label>
                                    <input class="form-control" type="text" pattern="[0-9]{10}" title="Please enter 10 numbers" id="tel" name="tel" required>
                                    <div class="error"></div>
                                </div>

                                <div class="input-control">
                                    <label for="mob">Mobile:</label>
                                    <input class="form-control" type="text" pattern="[0-9]{10}" title="Please enter 10 numbers" id="mob" name="mob" required>
                                    <div class="error"></div>
                                </div>

                                </br><input class="btn btn-default" type="submit" name="register-submit" value="Register User">
                            </form>      
                        </section>
                    </div>
                </div>
             </div>
        </section>  
    </main>    

<?php
}
else {
    // User is logged in
    // Set an error that they're already logged in and send them back to homepage
    $_ERROR = $_SESSION["error"] = "You're already logged in to an account! <a href='logout.php'>Log out?</a>";
    header("Location: index.php");
}

?>
    


<?php require_once "../includes/footer.php";?>


</body>
</html>


<?php $conn->close();?>