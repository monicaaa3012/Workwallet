<?php
include 'config.php';
include 'function.php';
include 'user_header.php';
checkUser();
userArea();
$msg = "";
$category_id = "";
$item = "";
$price = "";
$details = "";
$expense_date = date('Y-m-d');
$label = "Add";

$category_id = 1; // Example category ID, replace this with your actual category ID

$categoryBudget = getCategoryBudget($con, $category_id);
$budget = $categoryBudget;
if (isset($_GET['id']) && $_GET['id'] > 0) {
    $label = "Edit";
    $id = get_safe_value($_GET['id']);
    $res = mysqli_query($con, "SELECT * FROM expense WHERE id = $id");
    if (mysqli_num_rows($res) == 0) {
        redirect('expense.php');
        die();
    }
    $row = mysqli_fetch_assoc($res);
    $category_id = $row['category_id'];
    $item = $row['item'];
    $price = $row['price'];
    $details = $row['details'];
    $added_on = $row['added_on'];
    if ($row['added_by'] != $_SESSION['UID']) {
        redirect('expense.php');
    }
}

if (isset($_POST['submit'])) {
    $category_id = get_safe_value($_POST['category_id']);
    $item = get_safe_value($_POST['item']);
    $price = get_safe_value($_POST['price']);
    $details = get_safe_value($_POST['details']);
    $expense_date = get_safe_value($_POST['expense_date']);
    $payment_method = get_safe_value($_POST['payment_method']);
    $added_on = date('Y-m-d h:i:s');

    // Get the category's budget
    $categoryBudget = getCategoryBudget($con, $category_id);

    $type = "add";
    $sub_sql = "";
    if (isset($_GET['id']) && $_GET['id'] > 0) {
        $type = "edit";
        $sub_sql = "AND id != $id";
    }
    $added_by = $_SESSION['UID'];

    $sql = "INSERT INTO expense (category_id, item, price, details, added_on, expense_date, added_by, payment_method) VALUES ('$category_id', '$item', '$price', '$details', '$added_on', '$expense_date', '$added_by', '$payment_method')";
    if (isset($_GET['id']) && $_GET['id'] > 0) {
        $sql = "UPDATE expense SET category_id = '$category_id', item = '$item', price = '$price', details = '$details', expense_date = '$expense_date', payment_method = '$payment_method' WHERE id = $id";
    }
    mysqli_query($con, $sql);

    // Deduct expense amount from category budget
    $newBudget = $categoryBudget - $price;

    // Update category's budget in the database
    mysqli_query($con, "UPDATE category SET budget = '$newBudget' WHERE id = '$category_id'");

    // Check if expense exceeds budget
    if ($price > $categoryBudget) {
        // Set expense status as negative
        $status = 'Negative';
        // Send email notification
        sendEmailNotification($userEmails, $expenseDetails);
    }

    redirect('expense.php');
}
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="./style.css">
    <title>WorkWallet</title>
</head>

<body>

<a href="Expense.php" class="btn btn-primary">
    <h6 style="text-align: center;">&#8592;</h6></a>
<div class="container content">
    <div class="row">
        <div class="card card-login mx-auto mt-5 col-md-8 col-lg-6">
            <div class="card-header text-center">AddExpense</div>
            <div class="card-body">
                <form method="post">
                    <div class="form-group">
                        <div class="form-label-group">
                            <label for="inputUsername">Category </a></label>
                            <!--<input type="text" name="name" required value="--><?php echo getCategory($category_id)?>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-label-group">
                            <label for="inputUsername">Item :</label>
                            <input type="text" name="item" class="form-control" placeholder="item" required
                                value="<?php echo $item?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-label-group">
                            <label for="inputUsername">Price :</label>
                            <input type="text" name="price" class="form-control" placeholder="Price" required
                                value="<?php echo $price?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-label-group">
                            <label for="inputUsername">Details :</label>
                            <input type="text" name="details" class="form-control" placeholder="Details" required
                                value="<?php echo $details?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-label-group">
                            <label for="inputUsername">Expense Date :</label>
                            <input type="date" name="expense_date" class="form-control" placeholder="Password"
                                required value="<?php echo $expense_date?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-label-group">
                            <label for="inputPaymentMethod">Payment Method:</label>
                            <select name="payment_method" class="form-control">
                                <option value="Cash">Cash</option>
                                <option value="Cheque">Cheque</option>
                                <option value="Online Payment">Online Payment</option>
                            </select>
                        </div>
                    </div>


                    <button type="submit" name="submit" value="submit" class="btn btn-primary btn-block">submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
    integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn"
    crossorigin="anonymous"></script>
</body>
</html>
<?php include 'footer.php'?>