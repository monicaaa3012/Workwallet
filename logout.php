<?php
include'config.php';
include'function.php';
unset($_SESSION['UID']);
unset($_SESSION['UNAME']);
//yesle indexko page khulxa
redirect('landing.php');
?>