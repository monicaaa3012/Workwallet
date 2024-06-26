<?php
include'config.php';
include'function.php';
checkUser();
userArea();
include'user_header.php';

$cat_id='';
$sub_sql='';
$from='';
$to='';
if( isset($_GET['category_id']) && $_GET['category_id']>0 ){
    $cat_id=get_safe_value($_GET['category_id']);
    $sub_sql=" and category.id=$cat_id";
    
}
if( isset($_GET['from'])) {
    $from=get_safe_value($_GET['from']);
    }
    if( isset($_GET['to'])) {
    $to=get_safe_value($_GET['to']);
    }
    if($from!=='' && $to!==''){
        $sub_sql.=" and expense.expense_date between '$from' and '$to'";
    }

$res = mysqli_query($con, "SELECT   sum(expense.price) as price,category.name from expense,category where
expense.category_id=category.id and expense.added_by='".$_SESSION['UID']."' $sub_sql  group by expense.category_id");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Reports</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2>Reports</h2>
        <form method="get">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="from_date">From</label>
                    <input type="date" id="from_date" name="from" class="form-control" value="<?php echo $from ?>" max="<?php echo date('Y-m-d') ?>" onchange="set_to_date()">
                </div>
                <div class="form-group col-md-4">
                    <label for="to_date">To</label>
                    <input type="date" id="to_date" name="to" class="form-control" value="<?php echo $to ?>" max="<?php echo date('Y-m-d') ?>">
                </div>
                <div class="form-group col-md-4">
                    <?php echo getCategory($cat_id, 'reports'); ?>
                </div>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            <a href="reports.php" class="btn btn-secondary">Reset</a>
        </form>

        <?php if (mysqli_num_rows($res) > 0) { ?>
            <table class="table table-bordered mt-4">
                <thead>
                    <tr>
                        <th>Category</th>
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
                            <td><?php echo $row['price']; ?></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <th>Total</th>
                        <th><?php echo $final_price; ?></th>
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

<?php include('footer.php')?>