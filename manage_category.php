<?php
include 'config.php';
include 'function.php';
include 'user_header.php';

checkUser();
adminArea();
$msg = "";
$category = "";
$budget = ""; // Define $budget variable

$label = "Add";
if (isset($_GET['id']) && $_GET['id'] > 0) {
    $label = "Edit";
    $id = get_safe_value($_GET['id']);
    $res = mysqli_query($con, "select * from category where id=$id ");
    if (mysqli_num_rows($res) == 0) {
        redirect('category.php');
        die();
    }
    $row = mysqli_fetch_assoc($res);
    $category = $row['name'];
    $budget = $row['budget']; // Assign value to $budget variable
}

if (isset($_POST['submit'])) {
    $name = get_safe_value($_POST['name']);
    $budget = get_safe_value($_POST['budget']); // Get budget value from form
    
    $type = "add";
    $sub_sql = "";
    if (isset($_GET['id']) && $_GET['id'] > 0) {
        $type = "edit";
        $sub_sql = "and id!=$id";
    }

    $res = mysqli_query($con, "SELECT * FROM category WHERE name = '$name' $sub_sql");
    if (mysqli_num_rows($res) > 0) {
        $msg = "Category already exists";
    } else {
        $sql = "insert into category(name, budget) values('$name', '$budget')";
        if (isset($_GET['id']) && $_GET['id'] > 0) {
            $sql = "update category set name='$name', budget='$budget' where id=$id";
        }
        mysqli_query($con, $sql);
        redirect('category.php');
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous">
    <link rel="stylesheet" href="./style.css">
    <title>WorkWallet</title>
</head>

<body>
    <h2><?php //echo $label ?></h2>
    <br>
    <br>
    <a href="category.php" class="btn btn-primary" style="text-align:center">&#8592;</a>
    <div class="container content">
        <div class="row">
            <div class="card card-login mx-auto mt-5 col-md-8 col-lg-6">
                <div class="card-header text-center">AddCategory</div>
                <div class="card-body">
                    <form method="post">
                        <div class="form-group">
                            <div class="form-label-group">
                                <label for="inputCategory">Category :</label>
                                <input type="text" name="name" class="form-control" placeholder="category" required
                                    value="<?php echo $category ?>" autofocus="autofocus">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-label-group">
                                <label for="inputBudget">Budget :</label>
                                <input type="text" name="budget" class="form-control" placeholder="budget" required
                                    value="<?php echo $budget ?>">
                            </div>
                        </div>

                        <button type="submit" name="submit" value="Submit" class="btn btn-primary btn-block">Submit</button>
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
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
    <?php echo $msg; ?>
</body>

</html>
<?php
include 'footer.php';
?>
