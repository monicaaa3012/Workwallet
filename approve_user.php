<?php
include 'config.php';
include 'function.php';
checkUser();
adminArea();

if (isset($_GET['id']) && isset($_GET['action'])) {
    $id = get_safe_value($_GET['id']); 
    $action = get_safe_value($_GET['action']);

    // Approve or reject the user
    if(approveUser($id, $action)) {
        redirect('users.php');
    } else {
        echo "Error approving/rejecting user";
    }
}
?>