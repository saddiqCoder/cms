<?php
ob_start();
session_start(); 
include_once "helper_functions/loader.php";
$con = connect_to_db('localhost','root','','loan_db');

if ((isset($_SESSION['memberuser']))){
    header("Location: dashboard.php");
}

extract($_POST);
$memberuser = [];


if (!empty($mail) && !empty($passme)){
    if(comfirm_query($con) !== false){
        $q = ("SELECT * FROM members WHERE `email`= '".$mail."' AND `password` = '".$passme."' ");
        $run = mysqli_query($con, $q);
		$runresult = mysqli_fetch_assoc($run);      
        
        if (count($runresult) > 0){
            extract($runresult);
            $memberuser['id'] = $id;
            $memberuser['fname'] = $firstname;
            $memberuser['email'] = $mail;
            $memberuser['password'] = $passme;
            $_SESSION['memberuser'] = $memberuser;
            header("Location: dashboard.php");
        }else{
            echo "<script> alert('No Record Found!!!'); </script>"; 
        }
       
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/login.css">
    <style>

    </style>
</head>
<body>

<div class="login-card">
    <h3 class="text-center">Member Login</h3>
    <form action="<?php $_SELF_PHP ?>" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="mail" class="form-control" placeholder="Enter your email" required>
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="passme" class="form-control" placeholder="Enter your password" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>
    <p class="text-center mt-3">
        Don't have an account? <a href="register.php">Register</a>
    </p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
