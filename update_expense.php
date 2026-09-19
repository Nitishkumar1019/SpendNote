<?php
include ("db.php");

$id=$_POST['id'];
$amount=$_POST['amount'];
$description=$_POST['description'];
$category=$_POST['category'];
$expense_date=$_POST['expense_date'];

// $sql="UPDATE expenses SET amount='$amount', description='$description', category='$category', expense_date='$expense_date'  WHERE id=$id";

$sql="UPDATE expenses SET amount=?, description=?, category=?, expense_date=?  WHERE id=?";

$stmt=mysqli_prepare($con,$sql);

mysqli_stmt_bind_param($stmt,"dsssi",$amount,$description,$category,$expense_date,$id);

// $result=mysqli_query($con,$sql);
$result=mysqli_stmt_execute($stmt);

if($result){
    header("Location:index.php");
    exit;
}
else{
    echo "Error:".mysqli_error($con);
}
?>