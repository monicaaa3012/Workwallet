<?php
include'config.php';
include'function.php';
checkUser();
adminArea();
include'user_header.php';
if(isset($_GET['type']) && $_GET['type']=='delete'&& isset($_GET['id']) && $_GET['id']>0 ){
    $id=get_safe_value($_GET['id']);
    mysqli_query($con,"delete from category where id=$id");
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
$res = mysqli_query($con, "SELECT * FROM category order by id desc");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense</title>
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container mt-4">
<h2 style="text-align: center;">Category</h2>
<a href="manage_category.php" class="btn btn-primary">Add Category</a>
<br>
<br>

<?php
if (mysqli_num_rows($res) > 0) {
    ?>
    <table class="table table-bordered" style="width:50%">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th >Actions</th>
        </tr>
        </thead>
        <?php
        while ($row = mysqli_fetch_assoc($res)) {
            ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td>
                    <a href="manage_category.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">edit</a>
                    <a href="javascript:void(0)" onclick="delete_confir('<?php echo $row['id'];?>','category.php')" class="btn btn-sm btn-danger">Delete</a>

                </td>
            </tr>
            <?php
        }
        ?>
    </table>
    <?php
} else {
    echo "<p>No data found</p>";
}
?>
</div>
</body>
</html>

<?php
include'footer.php';
?>