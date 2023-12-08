<?php
/**
 * Database connection script
 * 
 * This file establishes a connection to a MySQL database using database server details server name, username, password and database name. 
 * MySQLi Object-Oriented Approach
 */

$servername = "localhost"; // server where my MySql DB is hosted
$username = "root"; // username i connect with
$password = "";
$dbname = "library"; //db i want to connect to

// create connection
$conn = new mysqli($servername, $username, $password, $dbname); // create a new instance of class mysqli -> object, this object allows us to connect

// check if connection failed
if ($conn->connect_error) { // access error property of conn, if there's sumn there (a string describing the error)
    die("Connection failed: " . $conn->connect_error); // terminate script and display message
}
//echo "Connected To Database Successfully"

//$conn->close(); // good practice to close your db connection
?>