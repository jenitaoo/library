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
// Check the session, if user is not already logged in then provide link to login page
if (!isset($_SESSION["username"])) { 
    echo "Please <a href='login.php'>Log In</a> to start.";
} // otherwise they're logged in, show them the links to other pages
else { 
    // They're logged in, let them access the rest of the website!
    require_once "../includes/header.php";
?>

    <main>
        <section class="landing">
            <div class="flexRowContainer">
                        <img src="..\assets\logo-dark.png" alt="Library logo">
                        <h1>bejewel</h1>
                    </div>
                    <h2>made with love, made to last.</h2>
                    <p>Coming soon to Jervis Shopping Centre, Dublin. Until then, our ecommerce website is here to satisfy all your needs for handmade and delicate jewellery. Feel like a princess with our new "pearl & daizee" collection of rings and chokers.</p>
                    <a href="shop.html" class="btn btn-default">Shop Now</a>        
            </div>
        </section>
    </main>

<?php
}


?>


<?php require_once "../includes/footer.php";?>

    <!--LINK IN BOOTSTRAP SCRIPTS-->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>


<?php $conn->close();?>