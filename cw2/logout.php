<!--User And Admin Login System In PHP MySQL Step By Step | PHP Tutorial For Beginners: https://youtu.be/wODW8RLBPt0?si=3cK0PUXJHJmD3eTI-->
<?php
$servername = "mariadb";
$username = "root";
$password = "rootpwd";
$dbname = "coursework2"; 

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
} 

session_start();
session_unset();
session_destroy();

header('location:index.php')



?>
