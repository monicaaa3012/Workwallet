<?php
include 'config.php';
include'function.php';
checkUser();
userArea();
include 'user_header.php';
$from='';
$to='';
$sub_sql="";
if( isset($_GET['from'])) {
    $from=get_safe_value($_GET['from']);
    }
    if( isset($_GET['to'])) {
    $to=get_safe_value($_GET['to']);
    }
    if($from!=='' && $to!==''){
        $sub_sql.=" and expense.expense_date between '$from' and '$to'";
    }


$res = mysqli_query($con, "SELECT expense.price, category.name, expense.item, expense.expense_date FROM expense, category WHERE expense.category_id = category.id and expense.added_by='".$_SESSION['UID']."' $sub_sql");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Dashboard</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2 class="text-center">Expense Dashboard</h2>
        <?php if ($from != '' && $to != '') { ?>
            <p class="text-center">From: <?php echo $from; ?> To: <?php echo $to; ?></p>
        <?php } ?>

        <?php if (mysqli_num_rows($res) > 0) { ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Item</th>
                        <th>Expense Date</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $final_price = 0;
                    while ($row = mysqli_fetch_assoc($res)) {
                        $final_price += $row['price'];
                    ?>
                        <tr>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['item']; ?></td>
                            <td><?php echo /*isset($row['expense_date']) ? */$row['expense_date'] /*: 'N/A'; */?></td>
                            <td><?php echo $row['price']; ?></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="3" class="text-right"><strong>Total</strong></td>
                        <td><?php echo $final_price; ?></td>
                    </tr>
                </tbody>
            </table>
        <?php } else {
            echo "<p class='text-center'><strong>No data found</strong></p>";
        } ?>
    </div>

    <!-- Include Bootstrap JS (optional) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
