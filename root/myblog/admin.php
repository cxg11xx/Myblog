<?php 
    if(!isset($_COOKIE['login_flag']) || $_COOKIE['login_flag']!=1){
        header('Location:login.php');
        exit;
    }

?>