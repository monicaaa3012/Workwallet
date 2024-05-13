<?php
include 'config.php';
include 'function.php';
checkUser();
userArea();
include'user_header.php';
if(isset($_SESSION['UID']) && $_SESSION['UID']!=''){

}
else{
    redirect('index.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
    <br>
<h2 style="text-align:center">Dashboard</h2>
<br>
<div class="table-container">
    <table>
        <tr>
            <td>Today's Expense</td>
            <td>
                <?php  echo getDashboardExpense('today')?>
            </td>
        </tr>
        <tr>
            <td>Yesterday's Expense</td>
            <td>
            <?php  echo getDashboardExpense('yesterday')?>
            </td>
        </tr>
        <tr>
            <td>This Week Expense</td>
            <td>
            <?php  echo getDashboardExpense('week')?>
            </td>
        </tr>
        <tr>
            <td>This Month Expense</td>
            <td>
            <?php  echo getDashboardExpense('month')?>
            </td>
        </tr>
        <tr>
            <td>This Year Expense</td>
            <td>
            <?php  echo getDashboardExpense('year')?>
            </td>
        </tr>
        <tr>
            <td>Total Expense</td>
            <td>
            <?php  echo getDashboardExpense('total')?>
            </td>
        </tr>
    </table>
</div>
</body>
</html>


<?php
include'footer.php';
?>