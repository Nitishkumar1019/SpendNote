<?php
include "db.php";

if(!isset($_GET['id'])){
    die ("Invalid request");
}

$id=$_GET['id'];
if($id<=0){
    die ("Invalid Id");
}

$sql="SELECT * FROM expenses WHERE id=?";

$stmt=mysqli_prepare($con,$sql);
if($stmt===false){
    die ("Prepare failed:".mysqli_error($con));
}
mysqli_stmt_bind_param($stmt,"i",$id);

$executeResult=mysqli_stmt_execute($stmt);
if($executeResult===false){
    die("Execution failed:".mysqli_stmt_error($stmt));
}


$result=mysqli_stmt_get_result($stmt);

$row = mysqli_fetch_assoc($result);
if(!$row){
    die("Expense not found");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Expense</title>
</head>
<body>
    <h1>Edit Expense</h1>

    <form action="update_expense.php" method ="POST">
        <input type="hidden" name="id" value="<?php echo $row['id'];?>">

        <label>Amount:</label>
        <input type="number" name="amount" value="<?php echo $row['amount'];?>">
        <br><br>

        <input type="text" name="description" value="<?php echo $row['description'];?>">
        <br><br>

        <label>category:</label>
        <select name="category">
            <option value="Grocery" <?php if($row['category']=="Grocery") echo "selected";?>>
                Grocery
            </option>

            <option value="Food" <?php if($row['category']=="Food") echo "selected";?>>
                Food
            </option>

            <option value="Travel" <?php if ($row['category']=="Travel") echo "selected";?>>
                Travel
            </option>

            <option value="Cloth" <?php if ($row['category']=="Cloth") echo "selected";?>>
                Cloth
            </option>

            <option value="Study Material" <?php if ($row['category']=="Study Material") echo "selected";?>>
                Study Material
            </option>

            <option value="Other" <?php if ($row['category']=="Other") echo "selected";?>>
                Other
            </option>

        </select>

        <br><br>
        
        <label>Date</label>
        <input type="date" name="expense_date" value = "<?php echo $row['expense_date'];?>">
        <br><br>

        <button type="submit">Update Expense</button>
    </form>
</body>
</html>