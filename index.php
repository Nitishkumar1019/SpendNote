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
            <option value="study material">Study Material</option>
            <option value="other">Other</option>
        </select>
        <br><br>

        <label >Date:</label>
        <input type="date" name="expense_date">
        <br><br>

        <button type="submit">Save Expense</button>
    </form>
</body>
</html>