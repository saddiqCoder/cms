<?php
ob_start();
session_start(); 
include_once "helper_functions/loader.php";
$con = connect_to_db('localhost','root','','loan_db');

if ((isset($_SESSION['memberuser']))){
    session_destroy();
    header("Location: index.php");
}else{
    header("Location: index.php");
}

?>