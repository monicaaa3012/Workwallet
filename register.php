<?php
include "controlluserdata.php";
if (isset($_SESSION["users"])) {
  header("Location: index.php");//replace # By page name as main.php for redirect
}
?>
<!DOCTYPE html>
<html lang="en">
<title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registration Form</title>
  <link rel="stylesheet" href="./css/register.css">
  <script src="https://kit.fontawesome.com/e6ec068722.js" crossorigin="anonymous"></script>
</title>
</head>
<body>
  <div class="wrapper">
    <form action="" method="POST">
      <h1>Register</h1>
       <!--Error and Success msz display-->
      <span class="error-txt"><?php echo $fieldError; ?></span>
      <span class="success-txt"><?php echo $sucess; ?></span>
      <div class="input-box">
        <input type="text" name="username" placeholder="Username">
        <i class="fa-solid fa-user"></i>
         <!--Error and Success msz display-->
      <span class="error-txt" ><?php echo $usernameError; ?></span>
      </div>
      <div class="input-box">
        <input type="text" name="email" placeholder="Email">
        <i class="fa-solid fa-envelope"></i>
         <!--Error and Success msz display-->
      <span class="error-txt"><?php echo $emailError; ?></span>
      </div>
      <div class="input-box">
        <input type="password" name="password" placeholder="Password">
        <i class="fa-solid fa-lock"></i>
         <!--Error and Success msz display-->
      <span class="error-txt"><?php echo $passwordError; ?></span>
      </div>
      <div class="input-box">
        <input type="password" name="confirmpassword" placeholder="Confirm Password">
        <i class="fa-solid fa-lock"></i>
        <!--Error and Success msz display-->
      <span class="error-txt"><?php echo $confirmError; ?></span>
      </div>
      <button type="submit" name="register" class="btn">Register</button>
      <div class="login-link">
        <p>Already have an account? <a href="index.php">login</a></p>
      </div>
    </form>
  </div>
</body>
</html>