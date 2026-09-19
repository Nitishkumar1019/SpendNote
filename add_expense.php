<?php

include "db.php";

if($_SERVER["REQUEST_METHOD"]=="POST"){

if(!isset($_POST['amount'])||
    !isset($_POST['description'])||
    !isset($_POST['category'])||
    !isset($_POST['expense_date'])){
        die("Please submit the expense form");
    }

$amount=$_POST['amount'];
if($amount<=0){
    die("Amount must be greater than 0");
}

$description=$_POST['description'];
if(empty(trim($description))){
    die ("Description should not be empty");
}

$category=$_POST['category'];
if(empty(trim($category))){
    die("Category cannot empty");
}
$allowed_category= ["Grocery","Travel","Food","Cloth","Study Material","Other"];
if(!in_array($category,$allowed_category)){
    die ("Invalid category");
}

$expense_date=$_POST['expense_date'];
if(empty($expense_date)){
    die("Date cannot be empty");
}

$date=DateTime::createFromFormat('Y-m-d',$expense_date);
if(!$date || $date->format('Y-m-d')!==$expense_date){
    die("Invalid date");
}


// $sql="INSERT INTO expenses (amount,description,category,expense_date) VALUES ('$amount','$description','$category','$expense_date') ";
$sql="INSERT INTO expenses (amount,description,category,expense_date) VALUES (?,?,?,?) ";

$stmt=mysqli_prepare($con,$sql);


mysqli_stmt_bind_param($stmt,"dsss",$amount,$description,$category,$expense_date);



// $result=mysqli_query($con,$sql);
$result=mysqli_stmt_execute($stmt);

if($result){
    // echo "Expense added";
    header ("Location:index.php");
    exit;
}
else{
    // echo "error".mysqli_error($con);
    echo "error".mysqli_stmt_error($stmt);
}
// echo "amount:".$amount. "<br>";
// echo "description:".$description. "<br>";
// echo "category:".$category. "<br>";
// echo "date:".$expense_date. "<br>";
}
?>