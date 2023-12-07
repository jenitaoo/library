<?php
/**
 * Search page
 * 
 * Allow user to partial search for book 
 * 1) book title and/or author 
 * 2) book category description (dropdown)
 * 
 * And also allow user to reserve book 
 * 
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
    <title>Search</title>
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
}
?>
    
    <h1>Search For Book</h1>
    <div class="container">
    <form method="post" action="">
        <input type="text" id="search" name="search" placeholder="Search Data">
        <input type="text" id="search2" name="search2" placeholder="Search Data">

        <button name="search-submit">Search</button>
        </form>
    </div>

<?php
// If the search is submitted
if(isset($_POST["search-submit"])){
    $search = isset($_POST["search"]) ? $_POST["search"] : "";
    $search2 = isset($_POST["search2"]) ? $_POST["search2"] : "";

    // Query the db and get the data that matches if both fields entered
    if (!empty($search) && !empty($search2)) {
        $sql = "SELECT * FROM `books` WHERE (`BookTitle` LIKE '%$search%' OR `Author` LIKE '%$search2%')";
    } elseif (!empty($search)) {
        $sql = "SELECT * FROM `books` WHERE (`BookTitle` LIKE '%$search%')";
    } elseif (!empty($search2)) {
        $sql = "SELECT * FROM `books` WHERE (`Author` LIKE '%$search2%')";
    } else {
        // Both search fields are empty
        $sql = "SELECT * FROM `books`";
    }



    $result = $conn->query($sql);

    // if there are rows in the table
    if ($result->num_rows > 0) {
        // create table
?>
        <table style='border:1px solid black'>
        <tr>
            <th>ISBN</th>
            <th>Book Title</th>
            <th>Author</th>
            <th>Edition</th>
            <th>Year</th>
            <th>Category Code</th>
            <th>Reservation</th>
        </tr>
<?php
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

            if ( htmlentities($row["Reservation"])==="N"){
                echo "<td><a href='reserve.php?id=" . $row["ISBN"] . "'>Reserve</a></td>
                </tr>";
            }
        }
    
        echo "</table></br>";
    }
}



require_once "../includes/footer.php";?>

</body>
</html>


<?php $conn->close();?>