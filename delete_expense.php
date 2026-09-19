<?php
include "db.php";
if($_SERVER["REQUEST_METHOD"]!="GET"){
    die("Invalid Request");
}

if(!isset($_GET['id'])){
    die ("Invalid Id");
}
$id=$_GET['id'];
if($id<=0){
    die ("Invalid Id");
}


$sql="DELETE FROM expenses WHERE id=?";

$stmt=mysqli_prepare($con,$sql);
if($stmt===false){
    die ("Prepare failed:".mysqli_error($con));
}


$test=mysqli_stmt_bind_param($stmt,"i",$id);
if($test===false){
    die ("Parameter failed:".mysqli_stmt_error($stmt));
}


$result=mysqli_stmt_execute($stmt);
// $result=mysqli_query($con,$sql);
if($result===false){
    die ("Execution failed:".mysqli_stmt_error($stmt));
}
header ("Location:index.php");
exit;


// if($result){
//     header ("Location:index.php");
//     exit;
// }
// else{
//     echo "Error:".mysqli_stmt_error($stmt);
// }
?>