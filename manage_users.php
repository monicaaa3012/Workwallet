<?php
 include 'config.php';
 include 'function.php';
checkUser();
adminArea();
$msg="";
$username="";
$password="";
$label="Add";
if(isset($_GET['id']) && $_GET['id'] > 0){
    $label="Edit";
    $id = get_safe_value($_GET['id']);
    $res=mysqli_query($con,"select * from user where id=$id ");
    if(mysqli_num_rows($res)==0){
        redirect('users.php');
        die();
    }
    $row=mysqli_fetch_assoc($res);
    $username=$row['username'];
    $password=$row['password'];
}
if (isset($_POST['submit'])) {
    $username = get_safe_value($_POST['username']);
    $password = get_safe_value($_POST['password']);
     $type="add";
     $sub_sql="";
     if(isset($_GET['id']) && $_GET['id'] > 0){
        $type="edit";
        $sub_sql="and id!=$id";
     }
     
     $res = mysqli_query($con, "SELECT * FROM user WHERE username = '$username'  $sub_sql");
     if (mysqli_num_rows($res) > 0) {
        $msg="username already exist";
     }else{
        $password=password_hash($password,PASSWORD_DEFAULT);
        $sql="insert into user(username,password,role) values('$username','$password','User')";
   		if(isset($_GET['id']) && $_GET['id']>0){
   			$sql="update user set username='$username',password='$password' where id=$id";
   		}
        mysqli_query($con, $sql);
        redirect('users.php');
     }
   
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

<a href="users.php" class="btn btn-primary">Back</a>
<br>
<br>
<div class="container content">
        <div class="row">
            <div class="card card-login mx-auto mt-5 col-md-8 col-lg-6">
                <div class="card-header text-center">Edit User</div>
                    <div class="card-body">
                        <form method="post">
                            <div class="form-group">
                                    <div class="form-label-group">
                                        <label for="inputUsername">Username :</label>
                                            <input type="text" name="username" class="form-control" placeholder="Username"  required value="<?php echo $username?>" autofocus="autofocus">
                                    </div>
                            </div>
                            <!--<div class="form-group">
                                 <div class="form-label-group">
                                                <label for="inputUsername">Password :</label>
                                            <input type="password" name="password"   class="form-control" placeholder="Password" required value="<?php echo $password?>">
                                 </div>
                            </div>-->
                                <button type="submit" name="submit" value="Submit" class="btn btn-primary btn-block">Submit</button>
                        </form>
                    </div>
            </div>
        </div>
</div>

<?php echo $msg;
?>
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