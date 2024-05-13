<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My App</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <!-- Your custom CSS -->
</head>
<body>
<nav class="navbar navbar-expand-lg navbar_container">
    <a class="navbar-brand ml-4 navbar_logo" href="#">
        <i class="fas fa-wallet mr-2"></i> <!-- WorkWallet icon -->
        WorkWallet
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-between" id="navbarSupportedContent">
        <ul class="navbar-nav">
            <div class="navbar_content">
                <?php if (isset($_SESSION['UROLE']) && $_SESSION['UROLE'] == 'User') { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="expense.php">Expense</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="reports.php">Reports</a>
                    </li>
                <?php } else { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="category.php">Category</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="users.php">Users</a>
                    </li>
                <?php } ?>
            </div>
        </ul>
        <div class="navbar_content">
            <?php if (isset($_SESSION['UROLE'])) { ?>
                <a class="nav-link btn btn-primary mr-4" href="logout.php">Logout</a>
            <?php } else { ?>
                <a class="nav-link btn btn-primary mr-1" href="login.php">Login</a>
                <a class="nav-link btn btn-primary mr-4" href="register.php">Register</a>
            <?php } ?>
        </div>
    </div>
</nav>


