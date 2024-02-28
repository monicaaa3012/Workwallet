<?php
    $fieldError = "";
    $usernameError = "";
    $emailError = "";
    $passwordError = "";
    $confirmError = "";
    $sucess = "";
    //for registeration
    if (isset($_POST["register"])) {
        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $confirmpassword = $_POST["confirmpassword"];

      
        require_once "config.php";
        $sql = "SELECT * FROM user WHERE email = '$email'";
        $result = mysqli_query($con, $sql);
        $rowCount = mysqli_num_rows($result);

        if (empty($username) || empty($email) || empty($password) || empty($confirmpassword)) {
            $fieldError = "All field are required.";
        } elseif ($rowCount > 0) {
            $emailError = "Email already exits!";
        } else {
            if (strlen($password) < 8) {
                $passwordError = "Password must be at least 8 characters long.";
            }
            if ($password !== $confirmpassword) {
                $confirmError = "Password does not match.";
            }
            if (strlen($password) < 8 || $password !== $confirmpassword) {
            } else {
                //we will insert the data into database
                $sql = "INSERT INTO user (username, email, password) VALUES(?,?,?)";
                $stmt = mysqli_stmt_init($con);
                $prepareStmt = mysqli_stmt_prepare($stmt, $sql);

                if ($prepareStmt) {
                    mysqli_stmt_bind_param($stmt, "sss", $username, $email, $password);
                    mysqli_stmt_execute($stmt);
                    $sucess = "You are registered successfully";
                    header("refresh:1,url=index.php");
                } else {
                    die("Something went wrong");
                }
            }
        }
    }

   
?>