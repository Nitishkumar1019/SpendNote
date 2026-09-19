<?php
include "db.php";

$id=$_GET['id'];
$sql="SELECT * FROM expenses WHERE id=$id";
$result=mysqli_query($con,$sql);
$row = mysqli_fetch_assoc($result);

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

            <option value="Faishon" <?php if ($row['category']=="Faishon") echo "selected";?>>
                Faishon
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