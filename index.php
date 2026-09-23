<?php
include "db.php";

$sql="SELECT * FROM expenses";
$result=mysqli_query($con,$sql);

$total_sql="SELECT SUM(amount) AS total FROM expenses";
$total_result=mysqli_query($con,$total_sql);
$total_row=mysqli_fetch_assoc($total_result);
$total_spent=$total_row['total']??0;

$count_sql="SELECT COUNT(*) AS total_expenses FROM expenses";
$count_result=mysqli_query($con,$count_sql);
$count_row=mysqli_fetch_assoc($count_result);
$total_expenses=$count_row['total_expenses']??0;

$month_sql="SELECT SUM(amount) AS monthly_total FROM expenses WHERE MONTH(expense_date)=MONTH(CURDATE()) AND YEAR(expense_date)=YEAR(CURDATE())";
$month_result=mysqli_query($con,$month_sql);
$month_row=mysqli_fetch_assoc($month_result);
$this_month=$month_row['monthly_total']??0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SpendNote</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="app">

        <header class="topbar">
            <div>
                <h1>SpendNote</h1>
                <p>Track your spending simply</p>
            </div>

            <button id="openExpenseBtn" type="button" class="add-btn">+ Add Expense</button>
        </header>

        <div class="summary-cards">
            <div class="summary-card">
                <p>Total Spent</p>
                <h2>₹<?php echo number_format($total_spent,2);?></h2>
            </div>

            <div class="summary-card">
                <p>This Month</p>
                <h2>₹<?php echo number_format($this_month,2);?></h2>
            </div>

            <div class="summary-card">
                <p>Total Expenses</p>
                <h2><?php echo $total_expenses;?></h2>
            </div>

        </div>
        
        <div class="modal" id="expenseModal">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <h2>Add Expense</h2>
                        <p>Record your spending</p>
                    </div>

                    <button type="button" class="close-btn" id="closeExpenseBtn">
                        x
                    </button>
                </div>
                <form id="expenseForm" action="add_expense.php" method="POST">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Amount:</label>
                            <div class="amount-input">
                                <span>₹</span>
                                <input type="number" name="amount" placeholder="0.00" step="0.01">
                            </div>
                        </div>
            
                        <div class="form-group">
                            <label>Category</label>
                            <select name="category">
                                <option value="disabled selected">Select category</option>
                                <option value="Grocery">Grocery</option>
                                <option value="Travel">Travel</option>
                                <option value="Food">Food</option>
                                <option value="Cloth">Cloth</option>
                                <option value="Study Material">Study Material</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                    </div>  

                    <div class="form-row">
                        <div class="form-group">
                            <label>Description:</label>
                            <input type="text" name="description" placeholder="Where did you spend it?">
                        </div>

                        <div class="form-group">
                            <label>Date:</label>
                            <input type="date" name="expense_date" value=<?php echo date('Y-m-d');?>>
                        </div>
                    </div>
        
                    <button type="submit">Save Expense</button>
                </form>

            </div>
        </div>

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

                    <a href="delete_expense.php?id=<?php echo $row['id'];?>"
                       onclick="return confirm('Are you sure you want to delete this expense?');">
                        Delete
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

    </div>

    <script>
        const openExpenseBtn=document.querySelector("#openExpenseBtn");
        const closeExpenseBtn=document.querySelector("#closeExpenseBtn");
        const expenseModal=document.querySelector("#expenseModal");

        console.log("Open button:",openExpenseBtn);
        console.log("Close button:",closeExpenseBtn);
        console.log("Modal:",expenseModal);

        openExpenseBtn.addEventListener("click",function(){
            expenseModal.style.display="flex";
        });
        closeExpenseBtn.addEventListener("click",function(){
            expenseModal.style.display="none";
        });
    </script>
</body>
</html>