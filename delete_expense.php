<?php
include "db.php";

$id=$_GET['id'];
$sql="DELETE FROM expenses WHERE id=$id";

$result=mysqli_query($con,$sql);

if($result){
    header ("Location:index.php");
    exit;
}
else{
    echo "Error:".mysqli_error($result);
}
?>