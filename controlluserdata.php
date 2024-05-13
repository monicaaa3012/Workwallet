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
        $role=$_POST["optradio"];

      
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
                $hashedpassword = password_hash($password, PASSWORD_DEFAULT);
                 //we will insert the data into database
                $sql = "INSERT INTO user (username, email, password,role,approved) VALUES(?,?,?,?,'pending')";
                $stmt = mysqli_stmt_init($con);
                $prepareStmt = mysqli_stmt_prepare($stmt, $sql);

                if ($prepareStmt) {
                    mysqli_stmt_bind_param($stmt, "ssss", $username, $email, $hashedpassword,$role);
                    mysqli_stmt_execute($stmt);
                    $sucess = "Your registration request is pending approval by the admin.";
                    header("refresh:1,url=index.php");
                } else {
                    die("Something went wrong");
                }
            }
        }
    }

   
?>
<?php
/*include_once 'send_email.php'; // Include the file responsible for sending emails

// Your existing registration logic
if (isset($_POST['register'])) {
    // Process registration form data
    
    // Assuming you have already sanitized and validated user input
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmpassword = $_POST['confirmpassword'];
    
    // Save user data to database
    
    // Send email notification to admin
    $admin_email = 'admin@example.com'; // Replace with your admin's email address
    $subject = 'New User Registration';
    $message = "A new user has registered.\n\n";
    $message .= "Username: $username\n";
    $message .= "Email: $email\n";
    
    // Send the email
    send_email($admin_email, $subject, $message);
}*/
?>
