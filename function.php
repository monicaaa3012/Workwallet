<?php
require_once "config.php";
function prx($data){
    echo '<pre>';
    print_r($data);
    die();
}
function get_safe_value($data){
    global $con;
    if($data){
        return mysqli_real_escape_string($con, $data);
    }
}
//yesle login vayesi dashboard ma re direct garxa
function redirect($link){
    ?>
    <script>window.location.href="<?php echo $link?>"
    </script>
    <?php
}

function checkUser(){
    if(isset($_SESSION['UID']) && $_SESSION['UID']!=''){

    }
    else{
        redirect('index.php');
    }
}
function getCategory($category_id='', $page=''){
    global $con;
       $res=mysqli_query($con,"select * from category order by name asc");
       $fun="required";
    if($page=='reports'){
    // $fun="onchange=change_cat() ";
    $fun="";
    }
    $html='<select $fun name="category_id"  id="category_id">';
    $html.='<option value="">Select Category</option>';

    while($row=mysqli_fetch_assoc($res)){
        if($category_id>0  && $category_id==$row['id']) {
            $html.='<option value="'.$row['id'].'" selected>'.$row['name'].'</option>';
        }else{
            $html.='<option value="'.$row['id'].'">'.$row['name'].'</option>';
        }

    }

    $html.='</select>';
    return $html;
}
function getDashboardExpense($type){
    global $con;
    $today=date('Y-m-d');
    if($type=='today'){
        $sub_sql="and  expense_date='$today' ";
        $from=$today;
        $to=$today;
    }
    elseif($type=='yesterday'){
        $yesterday=date('Y-m-d',strtotime('yesterday'));
        $sub_sql="and  expense_date='$yesterday' ";
        $from=$yesterday;
        $to=$yesterday;
    }
    elseif($type=='week'  || $type=='month' || $type=='year'){
        $from=date('Y-m-d',strtotime("-1 $type"));
        $sub_sql="and  expense_date between '$from' and '$today' ";
        $to=$today;
    } 
    elseif($type=='total'  ){
        $from=date('Y-m-d',strtotime("$type"));
        $sub_sql="and  expense_date between '$from' and '$today' ";
        $to=$today;
    }
    else{
        $sub_sql="";
        $from='';
        $to='';
    }   
       $res=mysqli_query($con, "SELECT   sum(price) as price from expense where added_by='".$_SESSION['UID']."'  $sub_sql");
       $row=mysqli_fetch_assoc($res);
       $p=0;
       $link="";
       if($row['price']>0)
       {
       $p= $row['price'];
       $link="<a href='dashboard_report.php?from=".$from."&to=".$to."' target='_blank'>Details</a>";
       }
       return $p.$link;
}

function adminArea(){
    if($_SESSION['UROLE']!='Admin'){
redirect('dashboard.php');
    }
}
function userArea(){
    if($_SESSION['UROLE']!='User'){
redirect('category.php');
    }
}

function registerUser($username, $email, $password, $role, $approved) {
    global $con;
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $approvedStatus = 'pending';
    $sql = "INSERT INTO user (username, email, password, role, approved) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($con);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, "sssss", $username, $email, $hashedPassword, $role, $approvedStatus);
        mysqli_stmt_execute($stmt);

            $adminEmail = getAdminEmail(); // Implement this function to get admin email from the database
            if ($adminEmail) {
                $to = $adminEmail; // Admin's email address from the database
                $subject = "New User Registration";
                $message = "A new user has registered. Please review and approve their registration.\n";
                $message .= "Username: $username\n";
                $message .= "Email: $email\n";
                $mailSent = mail($to, $subject, $message);
                if ($mailSent) {
                        echo "<script>alert('Your registration request has been received. You will receive an email once your account is approved by the admin.');</script>";
                } else {
                    echo "<script>alert('Registration request failed!');</script>";
                }
            }else{
                echo "<script>alert('Admin not found.');</script>";
            }
            header("Location=login.php");
        }
        else{
            echo "<script>alert('Something went wrong.Try again!');</script>";
        }

}

function getAdminEmail() {
    global $con; // Assuming $con is your database connection object

    // Query to fetch the admin's email address from the database
    $result = mysqli_query($con, "SELECT email FROM user WHERE role = 'Admin' LIMIT 1");

    // Check if the query was successful
    if ($result && mysqli_num_rows($result) > 0) {
        // Fetch the admin's email from the result
        $row = mysqli_fetch_assoc($result);
        return $row['email'];
    } else {
        // Return null or handle the case where admin email is not found
        return null;
    }
}

function getUserEmail($userId) {
    global $con; // Assuming $con is your database connection object

    // Prepare and execute the query to fetch the user's email
    $stmt = mysqli_prepare($con, "SELECT email FROM user WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $email);

    // Fetch the result
    mysqli_stmt_fetch($stmt);

    // Close the statement
    mysqli_stmt_close($stmt);

    return $email;
}


function approveUser($id, $action) {
    global $con;
    $approvedStatus = ($action == 'approve') ? 'approved' : 'rejected';
    mysqli_query($con, "UPDATE user SET approved = '$approvedStatus' WHERE id = '$id'");
    //check if the actio is approval
    if($action == 'approve'){
        $userEmail = getUserEmail($id);
        
        if($userEmail){
            $to = $userEmail; // user's email address from the database
            $subject = "Registration Approval";
            $message = "Dear User,\n\nYour registration has been approved. You can now access all the features of our platform.";
            $mailSent = mail($to, $subject, $message);
            if ($mailSent) {
                    echo "<script>alert('Registraion approval notifcation sent.');</script>";
            } else {
                echo "<script>alert('Registration approval notification sent failed.');</script>";
            }
        }else{
            echo "<script>alert('User email not found.');</script>";
        }
    }
return true;
}
function getCategoryBudget($con, $category_id) {
    $result = mysqli_query($con, "SELECT budget FROM category WHERE id = '$category_id'");
    $row = mysqli_fetch_assoc($result);
    return $row['budget'];
}

function getCategoryBudgets($con,$category_id) {
    $result = mysqli_query($con, "SELECT id, budget FROM category");
    $categoryBudgets = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $categoryBudgets[$row['id']] = $row['budget'];
    }
    return $categoryBudgets;
}

function sendEmailNotification($userIds, $expenseDetails) {
    include 'config.php'; // Make sure to include your database connection settings

    // Fetch user emails from the database based on user IDs
    $userEmails = array();
    foreach ($userIds as $userId) {
        $userId = mysqli_real_escape_string($con, $userId);
        $result = mysqli_query($con, "SELECT email FROM user WHERE id='$userId'");
        if ($row = mysqli_fetch_assoc($result)) {
            $userEmails[] = $row['email'];
        }
    }

    // Compose email subject and body
    $subject = "Expense Notification: Budget Exceeded";
    $message = "Dear User,\n\n";
    $message .= "This is to inform you that your recent expense has exceeded the allocated budget. Details of the expense:\n\n";
    $message .= "Expense Details: " . $expenseDetails . "\n\n";
    $message .= "Please review your expenses and manage your budget accordingly.\n\n";
    $message .= "Thank you.";

    // Send email to each user
    foreach ($userEmails as $userEmail) {
        $headers = 'From: ' . $userEmail . "\r\n" .
                   'Reply-To: ' . $userEmail . "\r\n" .
                   'X-Mailer: PHP/' . phpversion();
        $isEmailSent = mail($userEmail, $subject, $message, $headers);
        if ($isEmailSent) {
            echo "Email notification sent successfully to $userEmail.<br>";
        } else {
            echo "Failed to send email notification to $userEmail.<br>";
        }
    }
}









?>
