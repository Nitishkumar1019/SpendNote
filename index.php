<?php
include "db.php";

// Fetch all expenses
$sql = "SELECT * FROM expenses ORDER BY expense_date DESC, id DESC";
$result = mysqli_query($con, $sql);

// Total spent
$total_sql = "SELECT SUM(amount) AS total FROM expenses";
$total_result = mysqli_query($con, $total_sql);
$total_row = mysqli_fetch_assoc($total_result);
$total_spent = $total_row['total'] ?? 0;

// Total number of expenses
$count_sql = "SELECT COUNT(*) AS total_expenses FROM expenses";
$count_result = mysqli_query($con, $count_sql);
$count_row = mysqli_fetch_assoc($count_result);
$total_expenses = $count_row['total_expenses'] ?? 0;

// Current month's spending
$month_sql = "SELECT SUM(amount) AS monthly_total
              FROM expenses
              WHERE MONTH(expense_date) = MONTH(CURDATE())
              AND YEAR(expense_date) = YEAR(CURDATE())";
$month_result = mysqli_query($con, $month_sql);
$month_row = mysqli_fetch_assoc($month_result);
$this_month = $month_row['monthly_total'] ?? 0;
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

    <!-- Dashboard Header -->
    <header class="topbar">
        <div>
            <h1>SpendNote</h1>
            <p>Track your spending simply</p>
        </div>

        <button id="openExpenseBtn" type="button" class="add-btn">
            + Add Expense
        </button>
    </header>

    <!-- Summary Cards -->
    <div class="summary-cards">
        <div class="summary-card">
            <p>Total Spent</p>
            <h2>₹<?php echo number_format($total_spent, 2); ?></h2>
        </div>

        <div class="summary-card">
            <p>This Month</p>
            <h2>₹<?php echo number_format($this_month, 2); ?></h2>
        </div>

        <div class="summary-card">
            <p>Total Expenses</p>
            <h2><?php echo $total_expenses; ?></h2>
        </div>
    </div>

    <!-- Add Expense Modal -->
    <div class="modal" id="expenseModal">
        <div class="modal-content">

            <div class="modal-header">
                <div>
                    <h2>Add Expense</h2>
                    <p>Record your spending</p>
                </div>

                <button type="button" class="close-btn" id="closeExpenseBtn">
                    &times;
                </button>
            </div>

            <form id="expenseForm" action="add_expense.php" method="POST">

                <div class="form-row">
                    <div class="form-group">
                        <label>Amount:</label>

                        <div class="amount-input">
                            <span>₹</span>
                            <input
                                type="number"
                                name="amount"
                                placeholder="0.00"
                                step="0.01"
                                min="0.01"
                                required
                            >
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Category:</label>

                        <select name="category" required>
                            <option value="" disabled selected>
                                Select category
                            </option>
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

                        <input
                            type="text"
                            name="description"
                            placeholder="Where did you spend it?"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label>Date:</label>

                        <input
                            type="date"
                            name="expense_date"
                            value="<?php echo date('Y-m-d'); ?>"
                            required
                        >
                    </div>
                </div>

                <button type="submit">Save Expense</button>
            </form>
        </div>
    </div>

    <!-- Edit Expense Modal -->
    <div class="modal" id="editExpenseModal">
        <div class="modal-content">

            <div class="modal-header">
                <div>
                    <h2>Edit Expense</h2>
                    <p>Update your spending details</p>
                </div>

                <button
                    type="button"
                    class="close-btn"
                    id="closeEditExpenseBtn"
                >
                    &times;
                </button>
            </div>

            <form
                action="update_expense.php"
                method="POST"
                id="editExpenseForm"
            >

                <input type="hidden" name="id" id="editExpenseId">

                <div class="form-row">
                    <div class="form-group">
                        <label>Amount:</label>

                        <div class="amount-input">
                            <span>₹</span>
                            <input
                                type="number"
                                name="amount"
                                id="editExpenseAmount"
                                placeholder="0.00"
                                step="0.01"
                                min="0.01"
                                required
                            >
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Category:</label>

                        <select
                            name="category"
                            id="editExpenseCategory"
                            required
                        >
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

                        <input
                            type="text"
                            name="description"
                            id="editExpenseDescription"
                            placeholder="Where did you spend it?"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label>Date:</label>

                        <input
                            type="date"
                            name="expense_date"
                            id="editExpenseDate"
                            required
                        >
                    </div>
                </div>

                <button type="submit">Update Expense</button>
            </form>
        </div>
    </div>

    <!-- Transactions Header -->
    <div class="transactions-header">
        <div>
            <h2>Recent Transactions</h2>
            <p>Your latest expenses</p>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="filter-row">
        <input
            type="text"
            id="searchExpense"
            placeholder="Search expenses..."
        >

        <select id="categoryFilter">
            <option value="all">All Categories</option>
            <option value="Grocery">Grocery</option>
            <option value="Travel">Travel</option>
            <option value="Food">Food</option>
            <option value="Cloth">Cloth</option>
            <option value="Study Material">Study Material</option>
            <option value="Other">Other</option>
        </select>

        <input type="month" id="monthFilter">
    </div>

    <!-- Transactions Table -->
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Amount</th>
                    <th>Description</th>
                    <th>Category</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>

                <tr
                    data-id="<?php echo $row['id']; ?>"
                    data-amount="<?php echo htmlspecialchars((string)$row['amount'], ENT_QUOTES, 'UTF-8'); ?>"
                    data-description="<?php echo htmlspecialchars($row['description'], ENT_QUOTES, 'UTF-8'); ?>"
                    data-category="<?php echo htmlspecialchars($row['category'], ENT_QUOTES, 'UTF-8'); ?>"
                    data-date="<?php echo htmlspecialchars($row['expense_date'], ENT_QUOTES, 'UTF-8'); ?>"
                >
                    <td class="expense-amount">
                        ₹<?php echo number_format($row['amount'], 2); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row['description'], ENT_QUOTES, 'UTF-8'); ?>
                    </td>

                    <td>
                        <span class="category-badge">
                            <?php echo htmlspecialchars($row['category'], ENT_QUOTES, 'UTF-8'); ?>
                        </span>
                    </td>

                    <td
                        class="expense-date"
                        data-date="<?php echo htmlspecialchars($row['expense_date'], ENT_QUOTES, 'UTF-8'); ?>"
                    >
                        <?php echo date("d M Y", strtotime($row['expense_date'])); ?>
                    </td>

                    <td>
                        <button
                            type="button"
                            class="edit-btn edit-expense-btn"
                        >
                            Edit
                        </button>

                        <a
                            class="delete-btn"
                            href="delete_expense.php?id=<?php echo $row['id']; ?>"
                            onclick="return confirm('Are you sure you want to delete this expense?');"
                        >
                            Delete
                        </a>
                    </td>
                </tr>

                <?php } ?>
            </tbody>
        </table>
    </div>

</div>

<script>
// ====================================
// ADD EXPENSE MODAL
// ====================================

const openExpenseBtn = document.querySelector("#openExpenseBtn");
const closeExpenseBtn = document.querySelector("#closeExpenseBtn");
const expenseModal = document.querySelector("#expenseModal");

openExpenseBtn.addEventListener("click", function () {
    expenseModal.style.display = "flex";
});

closeExpenseBtn.addEventListener("click", function () {
    expenseModal.style.display = "none";
});


// ====================================
// EDIT EXPENSE MODAL
// ====================================

const editExpenseModal = document.querySelector("#editExpenseModal");
const closeEditExpenseBtn = document.querySelector("#closeEditExpenseBtn");

const editExpenseId = document.querySelector("#editExpenseId");
const editExpenseAmount = document.querySelector("#editExpenseAmount");
const editExpenseDescription = document.querySelector("#editExpenseDescription");
const editExpenseCategory = document.querySelector("#editExpenseCategory");
const editExpenseDate = document.querySelector("#editExpenseDate");

const editExpenseButtons = document.querySelectorAll(".edit-expense-btn");

editExpenseButtons.forEach(function (button) {

    button.addEventListener("click", function () {

        const row = button.closest("tr");

        // Get the selected expense's data
        const id = row.dataset.id;
        const amount = row.dataset.amount;
        const description = row.dataset.description;
        const category = row.dataset.category;
        const date = row.dataset.date;

        // Fill the Edit form
        editExpenseId.value = id;
        editExpenseAmount.value = amount;
        editExpenseDescription.value = description;
        editExpenseCategory.value = category;
        editExpenseDate.value = date;

        // Open the Edit popup
        editExpenseModal.style.display = "flex";
    });
});

closeEditExpenseBtn.addEventListener("click", function () {
    editExpenseModal.style.display = "none";
});


// Close a modal when clicking its dark background
expenseModal.addEventListener("click", function (event) {
    if (event.target === expenseModal) {
        expenseModal.style.display = "none";
    }
});

editExpenseModal.addEventListener("click", function (event) {
    if (event.target === editExpenseModal) {
        editExpenseModal.style.display = "none";
    }
});

// Close modals using the Escape key
document.addEventListener("keydown", function (event) {
    if (event.key === "Escape") {
        expenseModal.style.display = "none";
        editExpenseModal.style.display = "none";
    }
});


// ====================================
// SEARCH, CATEGORY AND MONTH FILTERS
// ====================================

const searchExpense = document.querySelector("#searchExpense");
const categoryFilter = document.querySelector("#categoryFilter");
const monthFilter = document.querySelector("#monthFilter");

const expenseRows = document.querySelectorAll(
    ".table-wrapper table tbody tr"
);

function filterExpenses() {

    const searchText = searchExpense.value.toLowerCase().trim();
    const selectedCategory = categoryFilter.value;
    const selectedMonth = monthFilter.value;

    expenseRows.forEach(function (row) {

        const rowText = row.textContent.toLowerCase();
        const categoryText = row.children[2].textContent.trim();

        const expenseDateElement = row.querySelector(".expense-date");
        const expenseDate = expenseDateElement
            ? expenseDateElement.dataset.date
            : "";

        const matchesSearch = rowText.includes(searchText);

        const matchesCategory =
            selectedCategory === "all" ||
            categoryText === selectedCategory;

        const matchesMonth =
            selectedMonth === "" ||
            expenseDate.startsWith(selectedMonth);

        if (matchesSearch && matchesCategory && matchesMonth) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    });
}

searchExpense.addEventListener("input", filterExpenses);
categoryFilter.addEventListener("change", filterExpenses);
monthFilter.addEventListener("change", filterExpenses);

</script>

</body>
</html>