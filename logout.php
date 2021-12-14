<?php
session_start();
if(!isset($_SESSION['tuvustamine'])) {
    header('Location:login.php');
    exit();
}
if (isset($_POST['logout'])){
    session_destroy();
    //aadressi reas avatakse login.php fail
    header('Location:konkurs.php');
    exit();
}
?>