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
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="app">
        <div class="edit-app">
            <div class="edit-header">
                <div>
                    <h1>Edit Expense</h1>
                    <p>Update your spending details</p>
                </div>
                <a href="index.php" class="back-btn">
                    <- Dashboard
                </a>
            </div>
            <form action="update_expense.php" method ="POST">
            <input type="hidden" name="id" value="<?php echo $row['id'];?>">

        <div class="form-row">
            <div class="form-group">
                <label>Amount:</label>
                <div class="amount-input">
                    <span>₹</span>
                    <input type="number" name="amount" value="<?php echo $row['amount'];?>" step="0.01" required>
                </div>
            </div>
            <div class="form-group">
                <label>category:</label>
                <select name="category" required>
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
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Description</label>
                <input type="text" name="description" value="<?php echo htmlspecialchars($row['description']);?>"required>
            </div>
            <div class="form-group">
                <label>Date</label>
                <input type="date" name="expense_date" value = "<?php echo $row['expense_date'];?>"required>
            </div>
        </div>
    
        <button type="submit" class="update-btn">Update Expense</button>
    </form>
</div>
</div>
</body>
</html>