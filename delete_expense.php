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

mysqli_stmt_bind_param($stmt,"i",$id);

$result=mysqli_stmt_execute($stmt);
// $result=mysqli_query($con,$sql);

if($result){
    header ("Location:index.php");
    exit;
}
else{
    echo "Error:".mysqli_stmt_error($stmt);
}
?>