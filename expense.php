<?php
include 'config.php';
include 'function.php';
checkUser();
userArea();
include 'user_header.php';

if (isset($_GET['type']) && $_GET['type'] == 'delete' && isset($_GET['id']) && $_GET['id'] > 0) {
    $id = get_safe_value($_GET['id']);
    mysqli_query($con, "delete from expense where id=$id");
    echo "<br>Data deleted  <br>";
}

$res = mysqli_query($con, "SELECT expense.*, category.name, category.budget FROM expense INNER JOIN category ON expense.category_id=category.id WHERE expense.added_by='".$_SESSION['UID']."' ORDER BY expense.expense_date DESC");


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
<h2>Expense</h2>
<a href="manage_expense.php" class="btn btn-primary">Add Expense</a>

<?php
if (mysqli_num_rows($res) > 0) {
    while ($row = mysqli_fetch_assoc($res)) {
        // Check if the budget is allocated
        $status = "Budget Not Allocated";
        if ($row['budget'] !== null) {
            // Check if the expense exceeds the budget
            $status = ($row['price'] > $row['budget']) ? "Exceeded" : "Within Budget";
        }
?>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Category</th>
            <th>Items</th>
            <th>Price</th>
            <th>Details</th>
            <th>Expense Date</th>
            <th>Status</th>
            <th>Payment Method</th>
        </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['item']; ?></td>
                <td><?php echo $row['price']; ?></td>
                <td><?php echo $row['details']; ?></td>
                <td><?php echo $row['expense_date']; ?></td>
                <td><?php echo $status; ?></td>
                <td><?php echo $row['payment_method']; ?></td> <!-- Displaying Payment Method -->
                <td>
                    <a href="manage_expense.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="javascript:void(0)" onclick="delete_confir('<?php echo $row['id'];?>','expense.php')" class="btn btn-sm btn-danger">Delete</a>
                </td>
            </tr>
        </tbody>
    </table>
<?php
    }
} else {
    echo "<p>No data found</p>";
}
?>
</div>
</body>
</html>
<?php include 'footer.php';?>
