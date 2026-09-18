<?php
include "db.php";

$amount=$_POST['amount'];
$description=$_POST['description'];
$category=$_POST['category'];
$expense_date=$_POST['expense_date'];

$sql="INSERT INTO expenses (amount,description,category,expense_date) VALUES ('$amount','$description','$category','$expense_date') ";

$result=mysqli_query($con,$sql);

if($result){
    echo "Expense added";
}
else{
    echo "error".mysqli_error($con);
}
// echo "amount:".$amount. "<br>";
// echo "description:".$description. "<br>";
// echo "category:".$category. "<br>";
// echo "date:".$expense_date. "<br>";
?>