<?php
ob_start();
session_start(); 
include_once "helper_functions/loader.php";
$conn = connect_to_db('localhost','root','','loan_db');



if ((!isset($_SESSION['memberuser']))){
    header("Location: login.php");
}

$memberID = $_SESSION['memberuser']['id'];
$member = $conn->query("SELECT *, CONCAT(lastname, ', ', firstname, ' ', middlename) AS full_name FROM members WHERE id = $memberID ORDER BY full_name ASC");
$row = $member->fetch_assoc();
print_r($row);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan --- Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
<aside>
    <h4 class="text-center mb-4">Member Menu</h4>
    <a href="savings.php">🏦 Savings</a>
    <a href="#">💳 Loan</a>
    <a href="repayment.php">💵 Repayment</a>
    <a href="index.php">🚪 Logout</a>
</aside>

<main>
    <h2>Welcome, Member!</h2>
    <p>Here you can manage and apply for loans</p>
    
    <div class="p-4">
        <?php //include('helper_functions/manage_loan.php');?>
        <h2>Loan Request Form</h2>
        <form class="mb-4">
            <div class="mb-3">
                <label class="form-label">Loan Amount</label>
                <input type="number" class="form-control" placeholder="Enter loan amount" required>
                <label class="control-label">member</label>
				<select name="member_id" id="member_id" class="custom-select browser-default select2">
					<option value=""></option>
					<option value="<?php echo $row['id']?>"> <?php echo $row['firstname'] . ' | Tax ID:'.$row['tax_id'] ?> </option>
				</select>
            </div>

            <label class="control-label">Loan Type</label>
            <?php
            $type = $conn->query("SELECT * FROM loan_types order by `type_name` desc ");
            ?>
            <select name="loan_type_id" id="loan_type_id" class="custom-select browser-default select2">
                <option value=""></option>
                    <?php while($row = $type->fetch_assoc()): ?>
                        <option value="<?php echo $row['id'] ?>" <?php echo isset($loan_type_id) && $loan_type_id == $row['id'] ? "selected" : '' ?>><?php echo $row['type_name'] ?></option>
                    <?php endwhile; ?>
            </select>

            <div class="mb-3">
                <label class="form-label">Loan Purpose</label>
                <textarea class="form-control" placeholder="State purpose of loan" required></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Repayment Period (months)</label>
                <input type="number" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Apply for Loan</button>
        </form>

        <h3>Past Loans</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Amount</th>
                    <th>Purpose</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr><td>20000</td><td>Business Expansion</td><td>2025-06-10</td><td>Approved</td></tr>
                <tr><td>15000</td><td>Medical Expenses</td><td>2025-04-05</td><td>Paid</td></tr>
            </tbody>
        </table>

        <a href="dashboard.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
    </div>
    
</main>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>