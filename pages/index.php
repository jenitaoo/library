<?php
/**
 * Home page
 * 
 * Prompts user for login if they aren't already and if they are, allows them to access the pages on the website
 */
session_start();

// Connect to database
require_once "..\configs\config.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!--REQUIRED META TAGS-->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--TITLE-->
    <title>Home</title>

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
// Check if user is logged in
if (!isset($_SESSION["username"])) { 
    require_once "no_login.php" ;
    return;
} else { 
    // They're logged in, let them access the rest of the website!
    require_once "../includes/header.php";?>
    <main>
        <section class="landing">
            <div class="container">
                    <div class="flexRowContainer">
                        <img src="..\assets\logo-dark-small.png" alt="Library logo">
                        <h1>Meadow Library</h1>
                    </div>
                    <h2>A Home For Every Growing Mind</h2>
                    <p>JWe're happy to have you here! We've a place for every reader looking to grow their love for reading. 
                        We have an ever growing collection of books in several genres from horror to romance - 
                        Take a look at our catalogue!
                    </p>
                    <a href="search.php" class="btn btn-default">Our Catalogue</a> 
                    <a href="view_reserved.php" class="btn btn-default">Your Reserved Books</a> 
                </div>
            </div>
        </section>
    </main>
<?php
}
// Check session for errors
require_once "error_check.php";
require_once "../includes/footer.php";?>

    <!--LINK IN BOOTSTRAP SCRIPTS-->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>

// Close the connection to the database
<?php $conn->close();?>