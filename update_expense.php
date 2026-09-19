<?php
include ("db.php");

$id=$_POST['id'];
$amount=$_POST['amount'];
$description=$_POST['description'];
$category=$_POST['category'];
$expense_date=$_POST['expense_date'];

$sql="UPDATE expenses SET amount='$amount', description='$description', category='$category', expense_date='$expense_date'  WHERE id=$id";
$result=mysqli_query($con,$sql);

if($result){
    header("Location:index.php");
    exit;
}
else{
    echo "Error:".mysqli_error($con);
}
?>