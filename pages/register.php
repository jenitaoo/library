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
    unset($_SESSION["sucess"]);
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

        // Check if password confirmation matches up
        if($password === $confpassword){
            // Create a new record in the database
            $sql = "INSERT INTO `users` (`Username`, `Password`, `Firstname`, `Surname`, `AddressLine1`, `AddressLine2`, `City`, `Telephone`, `Mobile`)
            VALUES ('$username', '$password','$firstname', '$surname', '$address1', '$address2', ' $city', '$telephone', '$mobile')";
            $result = $conn->query($sql);

            // Check if it worked
            if ($result === TRUE) {
                $_SESSION["sucess"] = "Success: Account registered successfully.";
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

// Check if the user is not logged in (returns true if username is not set)
if (!isset($_SESSION["username"])) { 
    // User is not logged in
    // Show the user a form and get their details to register
?>
    <h1>Register An Account</h1>
    <form method="post" action="">
        <label for="uname">Username:</label>
        <input type="text" id="uname" name="uname" required></br></br>

        <label for="pass">Password:</label>
        <input type="password" id="pass" name="pass" required></br></br>

        <label for="confpass">Confirm Password:</label>
        <input type="password" id="confpass" name="confpass" required></br></br>

        <label for="fname">First Name:</label>
        <input type="text" id="fname" name="fname" required></br></br>

        <label for="sname">Surname:</label>
        <input type="text" id="sname" name="sname" required></br></br>

        <label for="add1">Address Line 1:</label>
        <input type="text" id="add1" name="add1" required></br></br>

        <label for="add2">Address Line 2:</label>
        <input type="text" id="add2" name="add2" required></br></br>

        <label for="city">City:</label>
        <input type="text" id="city" name="city" required></br></br>

        <label for="tel">Telephone:</label>
        <input type="tel" id="tel" name="tel" required></br></br>

        <label for="mob">Mobile:</label>
        <input type="tel" id="mob" name="mob" required></br>

        <p><input type="submit" name="register-submit" value="Register User"/></p>
    </form>

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