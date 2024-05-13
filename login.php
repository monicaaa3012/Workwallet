
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
    <?php include './navbar.php'; ?>
    <?php
include'config.php';
include'function.php';
/*if(isset($_POST['login'])){
   $username= get_safe_value($_POST['username']);
   $password=get_safe_value($_POST['password']);
   $res=mysqli_query($con,"select * from user where username='$username'");
   if(mysqli_num_rows($res)>0){
    $row=mysqli_fetch_assoc($res);

    $verify=password_verify($password,$row['password']);

    if($verify==1){
    $_SESSION['UID']=$row['id'];
    $_SESSION['UNAME']=$row['username'];
    $_SESSION['UROLE']=$row['role'];
    $_SESSION['APPROVE']=$ROW['approved'];
    if($_SESSION['UROLE']=='Users'){
    redirect('dashboard.php');
    }else{
        redirect('category.php');
    }
    }else{
        echo "please enter valid password";
    }
   }else{
   echo "please enter valid username";
   }
}*/
if (isset($_POST['login'])) {
    $username = get_safe_value($_POST['username']);
    $password = get_safe_value($_POST['password']);
    
    $res = mysqli_query($con, "SELECT * FROM user WHERE username='$username'");
    
    if (mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);    
        if (password_verify($password, $row['password'])) {
            if ($row['approved'] ==='approved') { // Check if account is approved
                $_SESSION['UID'] = $row['id'];
                $_SESSION['UNAME'] = $row['username'];
                $_SESSION['UROLE'] = $row['role'];
                
                if ($_SESSION['UROLE'] == 'Users') {
                    redirect('dashboard.php');
                } else {
                    redirect('category.php');
                }
            } else {
                echo "Your account is pending approval or has been rejected. Please contact the administrator.";
            }
        } else {
            echo "Invalid password";
        }
    } else {
        echo "Username not found";
    }
}

?>
    <div class="container content">
        <div class="row">
            <div class="card card-login mx-auto mt-5 col-md-8 col-lg-6">
                <div class="card-header text-center">Login</div>
                <div class="card-body">
                    <form method="post">
                        <div class="form-group">
                            <div class="form-label-group">
                                <label for="inputUsername">Username :</label>
                                <input type="username" id="username" name="username" class="form-control" placeholder="Username"
                                    required="required" autofocus="autofocus">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-label-group">
                                <label for="inputUsername">Password :</label>
                                <input type="password" id="password" name="password" class="form-control" placeholder="Password"
                                    required="required">
                            </div>
                        </div>
                    
                        <div class="form-group">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="remember-me">
                                    Remember Password
                                </label>
                            </div>
                        </div>
                        <button type="submit" name="login" class="btn btn-primary btn-block">Login</button>
                    </form>
                    <div class="text-center">
                        <!--<a class="d-block medium" href="forgot-password.html">Forgot Password?</a>-->
                    </div>
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
</body>

</html>
<?php
include'footer.php';
?>