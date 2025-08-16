<?php
ob_start();
session_start(); 
include_once "helper_functions/loader.php";
if ((!isset($_SESSION['memberuser']))){
    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>

<aside>
    <h4 class="text-center mb-4">Member Menu</h4>
    <a href="savings.php">🏦 Savings</a>
    <a href="loan.php">💳 Loan</a>
    <a href="repayment.php">💵 Repayment</a>
    <a href="logout.php">🚪 Logout</a>
</aside>

<main>
    <h2>Hi, <?php echo $_SESSION['memberuser']['fname'];?> </h2>
    <p>Here you can manage your savings, apply for loans, and track repayments.</p>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
