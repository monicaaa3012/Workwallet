
<?php
include 'config.php';
include 'function.php';
checkUser();
adminArea();
include 'user_header.php';
if(isset($_GET['type']) && $_GET['type']=='delete' && isset($_GET['id']) && $_GET['id']>0 ){
    $id=get_safe_value($_GET['id']);
    $deleteCategoryQuery = "DELETE FROM user WHERE id=$id";
    if(mysqli_query($con, $deleteCategoryQuery)){
        echo "<script>
        window.onload= function() {
            alert('Data deleted successfully.');
            window.location.href = 'users.php'; // Redirect to users.php after OK is clicked
        };
      </script>";
    } else {
        echo "Error deleting record: " . mysqli_error($con);
    }
}
// Retrieve approved users for editing/deleting
$resApproved = mysqli_query($con, "SELECT * FROM user WHERE role='User' AND approved='approved' ORDER BY id DESC");

// Retrieve pending registrations for approval/rejection
$resPending = mysqli_query($con, "SELECT * FROM user WHERE role='User' AND approved='pending' ORDER BY id DESC");


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="./style.css">
    <title>Expense</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">
<h2>Users</h2>

<!--<a href="manage_users.php" class="btn btn-primary">Add User</a>-->

<div style="margin-top:5dvh;">
    <h2 style="text-align: left;">Pending Registrations</h2>
    <?php if (mysqli_num_rows($resPending) > 0): ?>
        <table class="table table-bordered" style="width:50%">
            <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Action</th>
            </tr>
            </thead>
            <?php while ($row = mysqli_fetch_assoc($resPending)): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['username']; ?></td>
                    <td>
                        <a href="approve_user.php?id=<?php echo $row['id']; ?>&action=approve" class="btn btn-sm btn-success">Approve</a>
                        <a href="approve_user.php?id=<?php echo $row['id']; ?>&action=reject" class="btn btn-sm btn-danger">Reject</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No pending registrations found.</p>
    <?php endif; ?>
</div>
    <h2 style="text-align: LEFT;">Approved Users</h2>
    <?php if (mysqli_num_rows($resApproved) > 0): ?>
        <table class="table table-bordered" style="width:50%">
            <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Action</th>
            </tr>
            </thead>
            <?php while ($row = mysqli_fetch_assoc($resApproved)): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['username']; ?></td>
                    <td>
                        <!--
                        <a href="manage_users.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                        -->
                        <a href="javascript:void(0)" onclick="delete_confir(<?php echo $row['id']; ?>, 'users.php')" class="btn btn-sm btn-danger">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No approved users found.</p>
    <?php endif; ?>
</div>
</body>
</html>

<?php include 'footer.php'; ?>
