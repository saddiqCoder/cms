<?php
ob_start();
session_start(); 
include_once "helper_functions/loader.php";
$conn = connect_to_db('localhost','root','','loan_db');


if ((!isset($_SESSION['memberuser']))){
    header("Location: login.php");
}

$loan = $conn->query("SELECT * from loan_list where status = 2 AND `member_id`='".$_SESSION['memberuser']['id']."' AND amount > 0");

//adding a new repayment and updating the loan amount
if (isset($_POST['repayment'])) {
    extract($_POST);
    $data = " loan_id = '$loanID' ";
    $data .= ", payee = '".$_SESSION['memberuser']['fname']."' ";
    $data .= ", amount = '$amount' ";
    $data .= ", date_created = '".date("Y-m-d H:i:s")."' ";


    //Fetching the initial loan amount
    $loanDetails = $conn->query("SELECT * FROM loan_list WHERE id = '$loanID'")->fetch_assoc();
    $initialAmount = $loanDetails['amount'];

    //compering the repayment amount with the initial loan amount
    if ($amount > $initialAmount) {
        echo "<script> alert('Repayment amount cannot exceed the initial loan amount!'); </script>";
    } else {
        //substracting the repayment amount from the initial loan amount
        $newAmount = $initialAmount - $amount;
        $conn->query("UPDATE loan_list SET amount = '$newAmount' WHERE id = '$loanID'");
        
        //Inserting the repayment record
        $save = $conn->query("INSERT INTO payments SET ".$data);
        if ($save) {
            echo "<script> alert('Repayment Submitted!'); </script>";
        } else {
            echo "<script> alert('Error in submitting repayment!'); </script>";
        }
    }
}

// Fetching the loan repayment history
$query = [];
$query['getRepaymentHistory'] = "
    SELECT 
    l.ref_no, 
    p.payee, 
    p.amount
FROM loan_list l
JOIN payments p ON p.loan_id = l.id
WHERE l.id = '".$_SESSION['memberuser']['id']."'";
$runRepaymentHistory = run_query($conn, $query['getRepaymentHistory']);
$RepaymentHistoryResult = mysqli_fetch_all($runRepaymentHistory);

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
            </form>

            <hr>

            <h3>Repayment History</h3>
            <div class="mb-3">
                <table class="table table-bordered" id="loan-list">
                    <colgroup>
                        <col width="33.3%">
                        <col width="33.3%">
                        <col width="33.3%">
                    </colgroup>
                    <thead>
                        <tr>
                            <th class="text-center">Loan Reference No</th>
                            <th class="text-center">Payee</th>
                            <th class="text-center">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php echo_out_updateresult($RepaymentHistoryResult, count($RepaymentHistoryResult)); ?>
                    </tbody>
                </table>
            </div>  

            <a href="dashboard.html" class="btn btn-secondary mt-3">Back to Dashboard</a>
        </div>
    </main>
    
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>