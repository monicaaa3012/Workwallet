<?php
include'header.php';
checkUser();
include'user_header.php';

if(isset($_GET['type']) && $_GET['type']=='delete'&& isset($_GET['id']) && $_GET['id']>0 ){
    $id=get_safe_value($_GET['id']);
    mysqli_query($con,"delete from expense where id=$id");
    echo "<br>Data deleted  <br>";
}



/*if (isset($_GET['type']) && $_GET['type'] == 'delete' && isset($_GET['id']) && $_GET['id'] > 0) {
    $id = (int)$_GET['id']; // Cast to integer for safety

    // Use prepared statement to prevent SQL injection
    $stmt = mysqli_prepare($con, "DELETE FROM category WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    if (mysqli_affected_rows($con) > 0) {
        echo "<br>Data deleted<br>";
    } else {
        echo "<br>No data found for deletion<br>";
    }
}*/
//using join method
$res = mysqli_query($con, "SELECT expense. * ,category.name FROM expense,category where
expense.category_id=category.id order by expense.expense_date desc");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WorkWallet</title>
    <link rel="stylesheet" href="./css/user_header.css">
</head>
<body>
    



<h2>Expense</h2>
<br>
<br>
<br>
<div class="but">
<br><br><a href="manage_expense.php">Add Expense</a><br><br>
</div>
<br>
<br>

<?php
if (mysqli_num_rows($res) > 0) {
    ?>
    <table id="costomers">
        <tr>
            <th>ID</th>
            <th>Category</th>
            <th>Items</th>
            <th>Price</th>
            <th>Details</th>
            <th> Expense Date</th>
            <th>Actions</th>>
        </tr>
        <?php
        while ($row = mysqli_fetch_assoc($res)) {
            ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['item']; ?></td>
                <td><?php echo $row['price']; ?></td>
                <td><?php echo $row['details']; ?></td>
                <td><?php echo $row['expense_date']; ?></td>
                <td>
                    <a href="manage_expense.php?id=<?php echo $row['id']; ?>">edit</a>
                    <a href="?type=delete&id=<?php echo $row['id']; ?>">Delete</a>
                </td>
            </tr>
            <?php
        }
        ?>
    </table>
    <?php
} else {
    echo "No data found";
}
?>
</body>
</html>
