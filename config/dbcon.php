<?php
$host ="localhost";
$username = "root";
$password = "";
$database = "black_coffer";

$con = mysqli_connect("$host", "$username","$password","$database");
if(!$con){
    header("Location: ../errors/db.php");
    die();
} else {
    echo "Database Connected!";
}
?>