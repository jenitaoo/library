<?php
/**
 * Home page, prompts user for login if they aren't already and if they are, allows them to access the pages on the website
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
    <!--REQUIRED META TAGS-->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--TITLE-->
    <title>View Reserved</title>

    <!--LINK IN FONTS-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather&family=Montserrat&display=swap" rel="stylesheet">

    <!--LINK IN BOOTSTRAP ICONS AND STYLESHEETS-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!--LINK IN STYLESHEETS-->
    <link rel="stylesheet" href="..\styles\style.css">
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
    $username = $_SESSION["username"];
    
    // Get data for books from the database
    $sql = "SELECT *
    FROM `books`
    INNER JOIN `reservations` ON `books`.`ISBN` = `reservations`.`ISBN`
    WHERE `reservations`.`Username` = '$username'";
    $result = $conn->query($sql);

    echo "<div class='container'><h1>View Your Reserved Books</h1>
        <table style='border:1px solid black'>";

    // if there are rows in the table
    if ($result->num_rows > 0) {
        // create html table?>
        <tr>
            <th>ISBN</th>
            <th>Book Title</th>
            <th>Author</th>
            <th>Edition</th>
            <th>Year</th>
            <th>Category Code</th>
            <th>Reservation</th>
        </tr><?php
        
        // get data
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . htmlentities($row["ISBN"]) . "</td>
                    <td>" . htmlentities($row["BookTitle"]) . "</td>
                    <td>" . htmlentities($row["Author"]) . "</td>
                    <td>" . htmlentities($row["Edition"]) . "</td>
                    <td>" . htmlentities($row["Year"]) . "</td>
                    <td>" . htmlentities($row["CategoryCode"]) . "</td>
                    <td>" . htmlentities($row["Reservation"]) . "</td>";

            if ( htmlentities($row["Reservation"])==="Y"){
                echo "<td><a class='link' href='unreserve.php?id=" . $row["ISBN"] . "'>Unreserve</a></td>
                </tr>";
            }
        }
    
        echo "</table></br></div>";
    }
}

?>


<?php require_once "../includes/footer.php";?>

</body>
</html>


<?php $conn->close();?>