<?php
ob_start();
session_start(); 
include_once "helper_functions/loader.php";
if ((isset($_SESSION['memberuser']))){

}else{
	header("Location: login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Repayment --- Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>

    <aside>
        <h4 class="text-center mb-4">Member Menu</h4>
        <a href="savings.php">🏦 Savings</a>
        <a href="loan.php">💳 Loan</a>
        <a href="#">💵 Repayment</a>
        <a href="index.php">🚪 Logout</a>
    </aside>

    <main>
        <h2>Welcome, Member!</h2>
        <p>Here you can manage and apply for loans</p>

        <div class="p-4">
            <h2>Loan Repayment Form</h2>
            <form class="mb-4">
                <div class="mb-3">
                    <label class="form-label">Loan ID</label>
                    <input type="text" class="form-control" placeholder="Enter loan reference ID" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Repayment Amount</label>
                    <input type="number" class="form-control" placeholder="Enter repayment amount" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Date</label>
                    <input type="date" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-warning">Submit Repayment</button>
            </form>

            <h3>Past Repayments</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Loan ID</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>LN001</td><td>5000</td><td>2025-07-01</td><td>Confirmed</td></tr>
                    <tr><td>LN002</td><td>3000</td><td>2025-05-15</td><td>Confirmed</td></tr>
                </tbody>
            </table>

            <a href="dashboard.html" class="btn btn-secondary mt-3">Back to Dashboard</a>
        </div>
    </main>
    
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>