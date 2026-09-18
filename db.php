<?php
$server="localhost";
$username="root";
$password="";
$databse="SpendNote";

$con=mysqli_connect($server,$username,$password,$databse);

if(!$con){
    die ("connection is faild due to".mysqli_connect_error());
}
// echo "Database connected successfullly";
?>