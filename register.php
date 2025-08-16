<?php
ob_start();
session_start(); 
include_once "helper_functions/loader.php";
$con = connect_to_db('localhost','root','','loan_db');

if ((isset($_SESSION['memberuser']))){
    header("Location: dashboard.php");
}

extract($_POST);
@$data = " lastname = '$lname' ";
@$data .= ", firstname = '$fname' ";
@$data .= ", middlename = '$mname' ";
@$data .= ", address = '$address' ";
@$data .= ", contact_no = '$tel' ";
@$data .= ", email = '$mail' ";
@$data .= ", password = '$passme' ";
@$data .= ", tax_id = '$memberid' ";
/* endOfData */

if (!empty($lname) && !empty($fname) && !empty($mname) && !empty($address) && !empty($tel) && !empty($mail) && !empty($passme) && !empty($memberid)){
    if(comfirm_query($con) !== false){
        if ($con->query("INSERT INTO members set ".$data)){
            header("Location: login.php");
        }
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cooperative Society - Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/login.css">
</head>
<body>

<div class="register-card">
    <h3 class="text-center mb-3 creatH">Create Your Account</h3>
    <form action="<?php $_SELF_PHP ?>" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">first Name</label>
            <input type="text" name="fname" class="form-control" placeholder="e.g., hassan" required>
        </div>
        <div class="mb-3">
            <label class="form-label">middle Name</label>
            <input type="text" name="mname" class="form-control" placeholder="e.g., hassan" required>
        </div>
        <div class="mb-3">
            <label class="form-label">last Name</label>
            <input type="text" name="lname" class="form-control" placeholder="e.g., hassan" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Phone</label>
            <input type="tel" name="tel" class="form-control" placeholder="+234 801 234 5678" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="mail" class="form-control" placeholder="you@example.com" required>
        </div>
         <div class="mb-3">
            <label class="form-label">Tax ID/ BVN/ NIN</label>
            <input type="text" name="memberid" class="form-control" placeholder="23333339999983099" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Address</label>
            <input type="text" name="address" class="form-control" placeholder="Street, City, State" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="passme" class="form-control" placeholder="********" required>
        </div>
        <button type="submit" class="btn btn-success w-100">Register</button>
    </form>

    <p class="text-center mt-3">
        Already a member? <a href="login.php">Login</a>
    </p>
    <p class="text-center"><a href="index.php">← Back to Home</a></p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
