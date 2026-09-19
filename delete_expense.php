<?php
include "db.php";

$id=$_GET['id'];
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
    echo "Error:".mysqli_error($result);
}
?>