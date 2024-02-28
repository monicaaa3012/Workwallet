<?php
include'header.php';
checkUser();
include'user_header.php';
if(isset($_SESSION['UID']) && $_SESSION['UID']!=''){

}
else{
    redirect('index.php');
}
?>
<h2>Dashboard</h2>



<?php
include'footer.php';
?>