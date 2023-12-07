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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Reserved</title>
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

    echo "<h1>View Your Reserved Books</h1>
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
        
        // get 
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . htmlentities($row["ISBN"]) . "</td>
                    <td>" . htmlentities($row["BookTitle"]) . "</td>
                    <td>" . htmlentities($row["Author"]) . "</td>
                    <td>" . htmlentities($row["Edition"]) . "</td>
                    <td>" . htmlentities($row["Year"]) . "</td>
                    <td>" . htmlentities($row["CategoryCode"]) . "</td>
                    <td>" . htmlentities($row["Reservation"]) . "</td>
                    <td><a href='reserve.php?id=" . $row["ISBN"] . "'>Reserve</a></td>
                  </tr>";
        }
    
    }else {
        echo "No books reserved.";
    }

    echo "</table></br>";
}

?>


<?php require_once "../includes/footer.php";?>

</body>
</html>


<?php $conn->close();?>