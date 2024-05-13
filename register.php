<!DOCTYPE html>
<?php
include_once './head.php';
include_once './navbar.php';
include 'function.php';

if (isset($_SESSION["users"])) {
    header("Location: index.php");
}

if (isset($_POST['register'])) {
    $username = get_safe_value($_POST['username']);
    $email = get_safe_value($_POST['email']);
    $password = get_safe_value($_POST['password']);
    $confirmpassword = get_safe_value($_POST['confirmpassword']);
    $role = isset($_POST['optradio']) ? get_safe_value($_POST['optradio']) : 'User'; // Default role is 'User'

    // Check if password and confirm password match
    if ($password != $confirmpassword) {
        //echo "Password and confirm password do not match";
        echo "<script>alert('Password do not match.');</script>";
    } else {
        require_once "config.php";
       //username and email validation
        $sql = "SELECT * FROM user WHERE username = ? OR email = ?";
        $stmt = mysqli_prepare($con,$sql);
        mysqli_stmt_bind_param($stmt,'ss',$username, $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $rowCount = mysqli_num_rows($result);
        if($rowCount > 0){
            $row =mysqli_fetch_assoc($result);
            if($row['username'] == $username){
                echo "<script>alert('Username already exits. Please choose a different username.');</script>";
            }else{
                echo "<script>alert('Email already exits. Please choose a different email.');</script>";
            }
        }else{
        // call RegisterUser function to register the user with pending approval
         registerUser($username, $email, $password, $role, 'pending');
        }
    }
}
?>
<!-- Your HTML registration form goes here -->

<div class="row">
    <div class="card card-register mx-auto mt-5 col-md-8">
        <div class="card-header">Register an Account</div>
        <div class="card-body">
            <form method="post" action="">
                <div class="form-group row">
                    <label class="col-md-3" for="optradio"></label>
                    <div class="col-md-9">
                        <div class="form-check-inline">
                            <label class="form-check-label" for="radio1" hidden>
                                <input type="radio" class="form-check-input" id="radio1" name="optradio"
                                    value="Admin" checked>Admin
                            </label>
                        </div>
                        <div class="form-check-inline">
                            <label class="form-check-label" for="radio2" hidden>
                                <input checked type="radio" class="form-check-input" id="radio2" name="optradio"
                                    value="User">User
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3" for="username">Username :</label>
                    <div class="col-md-9">
                        <input type="text" id="username" name="username" class="form-control"
                            placeholder="Enter your username" required="required" autofocus="autofocus">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3" for="email">Email :</label>
                    <div class="col-md-9">
                        <input type="email" id="email" name="email" class="form-control" placeholder="Email address"
                            required="required">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3" for="password">Password :</label>
                    <div class="col-md-9">
                        <input type="password" id="password" name="password" class="form-control" placeholder="Password"
                            required="required">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3" for="confirmPassword">Repeat password :</label>
                    <div class="col-md-9">
                        <input type="password" id="confirmPassword" name="confirmpassword" class="form-control"
                            placeholder="Repeat password" required="required">
                    </div>
                </div>
                <button type="submit" name="register" class="btn btn-primary btn-block">Register</button>
            </form>
            <div class="text-center mt-3">
                <a class="d-block medium" href="forgot-password.html">Forgot Password?</a>
            </div>
        </div>
    </div>
</div>
