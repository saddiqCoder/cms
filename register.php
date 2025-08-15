<?php
ob_start();
session_start(); 
include_once "helper_functions/loader.php";
if ((isset($_SESSION['memberuser']))){
    header("Location: dashboard.php");
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
    <h3 class="text-center mb-3">Create Your Account</h3>
    <form action="<?php $_SELF_PHP ?>" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" class="form-control" placeholder="e.g., John Doe" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Phone</label>
            <input type="tel" class="form-control" placeholder="+234 801 234 5678" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" placeholder="you@example.com" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" class="form-control" placeholder="********" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Address</label>
            <input type="text" class="form-control" placeholder="Street, City, State">
        </div>
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" id="terms" required>
            <label class="form-check-label" for="terms">
                I agree to the Terms & Conditions
            </label>
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
