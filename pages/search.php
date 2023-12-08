<?php
/**
 * Search, View and Reserve Page
 * 
 * This page allows users to view the book records in the database,
 * Search by partial title and/or author and/or category
 * And reserve books
 */
session_start();

require_once "../configs/config.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!--REQUIRED META TAGS-->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--TITLE-->
    <title>Search</title>

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
// Check the session, if the user is not already logged in then provide a link to the login page
if (!isset($_SESSION["username"])) { 
    // User not logged in
    require_once "no_login.php";
    return;
} // otherwise, they're logged in, show them the links to other pages
else { 
    // User logged in
    require_once "../includes/header.php";
}
?>
<main>
    <section>
        <div class="container">
            <h1>Search For Book</h1>
            <form method="post" action="">
                <input type="text" id="search" name="search" placeholder="Search Book Title">
                <input type="text" id="search2" name="search2" placeholder="Search Author">

                <label for="category">Select Category:</label>
                <select id="category" name="category">
                    <option value="">All Categories</option>
                    <?php
                    // Fetch categories from the database
                    $categoryQuery = "SELECT * FROM categories";
                    $categoryResult = $conn->query($categoryQuery);

                    // Check for errors in fetching categories
                    if (!$categoryResult) {
                        die("Error fetching categories: " . $conn->error);
                    }

                    // Display categories in the dropdown
                    while ($categoryRow = $categoryResult->fetch_assoc()) {
                        echo "<option value='" . htmlentities($categoryRow["CategoryID"]) . "'>" . htmlentities($categoryRow["CategoryDescription"]) . "</option>";
                    }
                    ?>
                </select>

                <button name="search-submit">Search</button>
                
            </form>
        </div>
    </section>
</main>


<?php
// If the search is submitted
if (isset($_POST["search-submit"])) {
    $search = isset($_POST["search"]) ? $_POST["search"] : "";
    $search2 = isset($_POST["search2"]) ? $_POST["search2"] : "";
    $category = isset($_POST["category"]) ? $_POST["category"] : "";

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

    if(empty($search) && empty($search2) && !empty($category)){
        $sql .= " WHERE `CategoryCode` LIKE '$category'";
    } elseif (!empty($category)) {
        $sql .= " AND `CategoryCode` LIKE '$category'";
    }

    $result = $conn->query($sql);

    // if there are rows in the table
    if ($result->num_rows > 0) {
        // create table
?>
        <table class="container table" style='border:1px solid black'>
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

            if (htmlentities($row["Reservation"]) === "N") {
                echo "<td><a href='reserve.php?id=" . $row["ISBN"] . "'>Reserve</a></td>
                </tr>";
            }
        }

        echo "</table></br></br></br>";
    }
}

require_once "error_check.php";
require_once "../includes/footer.php";
?>

</body>
</html>

<?php $conn->close();?>
