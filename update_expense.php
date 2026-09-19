<?php
include ("db.php");

if($_SERVER["REQUEST_METHOD"]!="POST"){
    die ("Invalid Request");
}
if(!isset($_POST['id'])||
    !isset($_POST['amount'])||
    !isset($_POST['description'])||
    !isset($_POST['category'])||
    !isset($_POST['expense_date'])
    ){
        die("Please submit the expense form");
    }

$id=$_POST['id'];
if($id<=0){
    die ("Invalid id");
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

$allowed_category=['Grocery','Travel','Food','Cloth','Study Material','Other'];

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


// $sql="UPDATE expenses SET amount='$amount', description='$description', category='$category', expense_date='$expense_date'  WHERE id=$id";

$sql="UPDATE expenses SET amount=?, description=?, category=?, expense_date=?  WHERE id=?";

$stmt=mysqli_prepare($con,$sql);
if($stmt===false){
    die ("Prepare failed:".mysqli_error($con));
}

$test=mysqli_stmt_bind_param($stmt,"dsssi",$amount,$description,$category,$expense_date,$id);
if($test===false){
    die ("Parameter binding failed:".mysqli_stmt_error($stmt));
}

// $result=mysqli_query($con,$sql);
$result=mysqli_stmt_execute($stmt);
if($result===false){
    die ("Execution failed:".mysqli_stmt_error($stmt));
}
header("Location:index.php");
exit;


// if($result){
    // header("Location:index.php");
    // exit;
// }
// else{
//     echo "Error:".mysqli_stmt_error($stmt);
// }
?>