<?php
include'header.php';
checkUser();

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
    <title>Workwallet</title>
    <link rel="stylesheet" href="./css/user_header.css">


<h2>Category</h2>
</head>
<br>
<br>
<br>
<body>
    <div class="but">
<a href="manage_category.php">Add Category</a>
</div>
<br>
<br>
<br>
<br>
<br>
<br>


<?php
if (mysqli_num_rows($res) > 0) {
    ?>
    <table id="customers">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Actions</th>
        </tr>
        <?php
        while ($row = mysqli_fetch_assoc($res)) {
            ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td>
                    <a href="manage_category.php?id=<?php echo $row['id']; ?>">edit</a>
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


<?php
include'footer.php';
?>