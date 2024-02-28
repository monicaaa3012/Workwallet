<?php
include'header.php';
if(isset($_POST['login'])){
   $username= get_safe_value($_POST['username']);
   $password=get_safe_value($_POST['password']);
   $res=mysqli_query($con,"select * from user where username='$username' and password='$password'");
   if(mysqli_num_rows($res)>0){
    $row=mysqli_fetch_assoc($res);
    $_SESSION['UID']=$row['id'];
    $_SESSION['UNAME']=$row['username'];
    redirect('dashboard.php');
   }else{
   echo "please enter valid login details";
   }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Form</title>
  <link rel="stylesheet" href="./css/login.css">
  <script src="https://kit.fontawesome.com/e6ec068722.js" crossorigin="anonymous"></script>
</head>
<body>
  <div class="wrapper">
    <form action="" method="POST">
      <h1>Login</h1>
      <!--Error and Success msz display-->
     <!-- <span class="error-txt"><?php echo $fieldError; ?></span>-->
      <div class="input-box">
        <input type="text" name="username" placeholder="">
        <i class="fa-solid fa-envelope"></i>
        <!--Error and Success msz display-->
      <!--<span class="error-txt"><?php echo $emailError; ?></span>-->
      </div>
      <div class="input-box">
        <input type="password" name="password" placeholder="Password">
        <i class="fa-solid fa-lock"></i>
        <!--Error and Success msz display-->
     <!-- <span class="error-txt"><?php echo $passwordError; ?></span>-->
      </div>
      <div class="remember-forgot">
        <label><input type="checkbox" name="remember_me">Remember Me</label>
        <a href="forgetpassword.html">Forgot Password</a>
      </div>
      <button type="submit" name="login" class="btn">Login</button>
      <div class="register-link">
        <p>Dont have an account? <a href="register.php">Register</a></p>
      </div>
    </form>
  </div>
</body>
</html>
    
<!--<h2>Login</h2>
<form method="post">
    <table>
        <tr>
            <td>Username</td>
            <td><input type="text" name="username" required></td>
        </tr>
        <tr>
            <td>Password</td>
            <td><input type="password" name="password" required></td>
        </tr> 
        <td></td>
        <td><input type="submit" name="login" value="login"></td>
    </table>
</form>-->

<?php
include'footer.php';
?>