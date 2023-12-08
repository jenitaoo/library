<?php
// Check session for errors
// Display success message if set
if (isset($_SESSION["success"])) {
    echo('<p class= "alert alert-success">' . $_SESSION["success"] . "</p>\n");
    unset($_SESSION["success"]);
}
// Display error message if set
if (isset($_SESSION["error"])) {
    echo('<p class="alert alert-danger">' . $_SESSION["error"] . "</p>\n");
    unset($_SESSION["error"]);
}
?>