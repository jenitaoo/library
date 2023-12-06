<?php
session_start();
session_destroy(); // destroy the session, logging user out
header("Location: login.php");
?>