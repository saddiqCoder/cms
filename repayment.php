<?php
ob_start();
session_start(); 
include_once "helper_functions/loader.php";
$conn = connect_to_db('localhost','root','','loan_db');


if ((!isset($_SESSION['memberuser']))){
    header("Location: login.php");
}

$loan = $conn->query("SELECT * from loan_list where status = 2 AND `member_id`='".$_SESSION['memberuser']['id']."' AND amount > 0");

if (isset($_POST['repayment'])) {
    extract($_POST);
    $data = " loan_id = '$loanID' ";
    $data .= ", amount = '$amount' ";
    $data .= ", date = '".date("Y-m-d H:i:s")."' ";

    echo $data;
    //echo "<script> alert('Repayment Submitted!'); </script>";
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
        <a href="logout.php">🚪 Logout</a>
    </aside>

    <main>
        <h2>Hi, <?php echo $_SESSION['memberuser']['fname'];?></h2>
        <p>Here you can repay your loans</p>

        <div class="p-4">
            <h2>Loan Repayment Form</h2>
            <form action="<?php $_SELF_PHP ?>" method="POST" enctype="multipart/form-data" class="mb-4">
                <div class="mb-4">
                    <label for="" class="control-label">Loan Reference No.</label>
                    <select name="loanID" class="custom-select browser-default select2 form-control" required>
                        <option value=""></option>
                        <?php
                        while($row=$loan->fetch_assoc()):
                        ?>
                        <option value="<?php echo $row['id'] ?>" <?php echo isset($loan_id) && $loan_id == $row['id'] ? "selected" : '' ?>><?php echo $row['ref_no'] ?></option>
                        <?php endwhile; ?>
                    </select>
                    
                </div>

                <div class="mb-3">
                    <label class="form-label">Repayment Amount</label>
                    <input type="number" name="amount" class="form-control" placeholder="Enter repayment amount" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Date</label>
                    <input type="text" value="<?php echo date('d/m/Y');?>" name="date" class="form-control" readonly required>
                </div>

                <button type="submit" name="repayment" class="btn btn-warning">Submit Repayment</button>




                <div class="mb-3">
                    <large class="card-title"> <b>Payment List</b> </large>
                </div>

                <div class="mb-3">
                    <table class="table table-bordered" id="loan-list">
                        <colgroup>
                            <col width="10%">
                            <col width="25%">
                            <col width="25%">
                            <col width="20%">
                            <col width="10%">
                            <col width="10%">
                        </colgroup>
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Loan Reference No</th>
                                <th class="text-center">Payee</th>
                                <th class="text-center">Amount</th>
                                <th class="text-center">Penalty</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        
                        </tbody>
                    </table>
                </div>  






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
                    <tr>
                        <td>LN001</td>
                        <td>5000</td>
                        <td>2025-07-01</td>
                        <td>Confirmed</td>
                    </tr>
                </tbody>
            </table>

            <a href="dashboard.html" class="btn btn-secondary mt-3">Back to Dashboard</a>
        </div>
    </main>
    
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>