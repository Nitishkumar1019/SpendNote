<?php
include "db.php";

$amount=$_POST['amount'];
$description=$_POST['description'];
$category=$_POST['category'];
$expense_date=$_POST['expense_date'];

// $sql="INSERT INTO expenses (amount,description,category,expense_date) VALUES ('$amount','$description','$category','$expense_date') ";
$sql="INSERT INTO expenses (amount,description,category,expense_date) VALUES (?,?,?,?) ";

$stmt=mysqli_prepare($con,$sql);


mysqli_stmt_bind_param($stmt,"dsss",$amount,$description,$category,$expense_date);



// $result=mysqli_query($con,$sql);
$result=mysqli_stmt_execute($stmt);

if($result){
    // echo "Expense added";
    header ("Locatin:index.php");
    exit;
}
else{
    // echo "error".mysqli_error($con);
    echo "error".mysqli_stmt__error($stmt);
}
// echo "amount:".$amount. "<br>";
// echo "description:".$description. "<br>";
// echo "category:".$category. "<br>";
// echo "date:".$expense_date. "<br>";
?>