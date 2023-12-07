<?php
/**
 * Reservation page
 * 
 * Given that the book isn't already reserved, this page allows users to reserve a book 
 * Updates the database that the book has been reserved and creates a reservation link between the user and book
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

// Check if reserve confirm form was submitted and 'id' is set in the URL
if (isset($_POST['delete-submit'])) {
    // Check if ID is set
    if (isset($_GET['id'])) {
        // get the isbn from the id in the URL
        $isbn = $conn->real_escape_string($_GET['id']);
        $username = $_SESSION["username"];

        // Get the data for for this book using the isbn
        $sql = "SELECT * FROM `books` WHERE `ISBN` = '$isbn'";
        $result = $conn->query($sql);

        // Get the row of the result
        $row = $result->fetch_assoc();

        // Check if the book is not already reserved
        if (htmlentities($row["Reservation"]) === "N") {
            $_SESSION["success"] = "Successfully reserved book";
            // Update the reservation value for the book in the database
            $sql = "UPDATE `books` SET `Reservation` = 'Y' WHERE `ISBN` = '$isbn'";
            $result1 = $conn->query($sql);

            $sql = "INSERT INTO `reservations`(`ISBN`, `Username`, `ReservedDate`) VALUES ('$isbn','$username',NOW())";
            $result2 = $conn->query($sql);
            
            // Check if queries ran successfully
            if ($result1 && $result2) {
                // Handle the case where the query failed
                $_SESSION["Succ ess"] = "Book reserved successfully";
                header('Location: search.php');
                return;
            } else {
                // Handle the case where the query failed
                $_SESSION["error"] = "Error executing queries.";
                header('Location: search.php');
                return;
            }

        } else {
            // If no matching record is found, set an error message and redirect to  login.php
            $_SESSION["error"] = "Can't reserve this book! Already reserved";
            header('Location: search.php');
            return;
        }

    } else {
            // Handle the case where the query failed
            $_SESSION["error"] = "Error: Id not set";
            header('Location: search.php');
            return;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserve</title>
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
    // Display confirmation form for user to reserve this book
?>
    <h1>Reserve A Book</h1>
    <form method="post">
        <p>Are you sure you want to reserve this book??</p>
        <input type="submit" name="delete-submit" value="Confirm">
    </form>
<?php

}

?>



<?php require_once "../includes/footer.php";?>

</body>
</html>


<?php $conn->close();?>