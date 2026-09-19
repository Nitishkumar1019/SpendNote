<?php
include "db.php";

$sql="SELECT * FROM expenses";
$result=mysqli_query($con,$sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SpendNote</title>
</head>
<body>
    <h1>SpendNote</h1>
    <h2>Add Expense</h2>

    <form action="add_expense.php" method="POST">
        <label>Amount:</label>
        <input type="number" name="amount">
        <br><br>

        <label>Description:</label>
        <input type="text" name="description">
        <br><br>

        <label >Category</label>
        <select name="category">
            <option value="Grocery">Grocery</option>
            <option value="Travel">Travel</option>
            <option value="Food">Food</option>
            <option value="Cloth">Cloth</option>
            <option value="Study Material">Study Material</option>
            <option value="Other">Other</option>
        </select>
        <br><br>

        <label >Date:</label>
        <input type="date" name="expense_date">
        <br><br>

        <button type="submit">Save Expense</button>
    </form>

    <h2>Your Expenses</h2>
    <table>
        <tr>
            <th>Amount</th>
            <th>Description</th>
            <th>Category</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>

        <?php
        while($row=mysqli_fetch_assoc($result)){
        ?>

        <tr>
            <!-- <td><?php echo $row['amount'];?></td> -->
            <td><?php echo htmlspecialchars($row['amount']);?></td>
            <!-- <td><?php echo $row['description'];?></td> -->
            <td><?php echo htmlspecialchars($row['description']);?></td>
            <!-- <td><?php echo $row['category'];?></td> -->
             <td><?php echo htmlspecialchars($row['category']);?></td>
            <!-- <td><?php echo $row['expense_date'];?></td> -->
             <td><?php echo htmlspecialchars($row['expense_date']);?></td>
            <td>
                <a href="edit_expense.php?id=<?php echo $row['id'];?>">
                    Edit
                </a>

                <a href="delete_expense.php?id=<?php echo $row['id'];?>" onclick="return confirm('Are you sure you want to delete this expense?');">Delete
                </a>
            </td>
        </tr>
        <?php
        }
        ?>
    </table>
    <!-- <?php
    // while($row=mysqli_fetch_assoc($result)){
    //     echo "Amount:".$row['amount']. "<br>";
    //     echo "description:".$row['description']. "<br>";
    //     echo "category:".$row['category']. "<br>";
    //     echo "Date:".$row['expense_date']. "<br>";
    //     echo "<hr>";
    // }
    ?> -->
</body>
</html>