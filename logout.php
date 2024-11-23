<?php

session_start();


if (isset($_SESSION['user_info'])) {
    
    $_SESSION = array();

   
    session_destroy();

   
    header("Location: index.php");
    exit();
} else {
    
    header("Location: register.php");
    exit();
}
?>
