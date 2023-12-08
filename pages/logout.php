<?php
session_start();
session_destroy(); // destroy the session, logging user out
$_SESSION["success"] = "Success: Logged out.";
header("Location: index.php");
?>