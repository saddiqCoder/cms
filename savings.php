<?php
ob_start();
session_start(); 
include_once "helper_functions/loader.php";

if ((!isset($_SESSION['memberuser']))){
    header("Location: login.php");
}

$memberID = $_SESSION['memberuser']['id'];

extract($_POST);
@$data  = " memberID = '$memberID' ";
@$data .= ", amount = '$amount' ";
@$data .= ", date = '$date' ";
@$data .= ", status = 'pendig' ";
/* endOfData */

/* updating savings into the database */
    if (!empty($amount) && !empty($date)){
        if(comfirm_query($con) !== false){
            if ($con->query("INSERT INTO savings set ".$data)){
                echo "<script> alert('Savings Record updated!!!'); </script>"; 
            }else{
                echo "<script> alert('An unexpected error occur'); </script>"; 
            }
        }
    }
/* End */

// declaring an empty array to hold different querys
$query = [];
$queryarray = [];
	
// Query to search only music table in the database
$query['getsavings'] = "
    SELECT `amount`, `date`, `status`  FROM savings 
    WHERE 1=1  LIMIT 10 OFFSET 0
";

$runsavings = run_query($con, $query['getsavings']);
$runsavingsresult = mysqli_fetch_all($runsavings);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Savings - Cooperative Society</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
    <aside>
        <h4 class="text-center mb-4">Member Menu</h4>
        <a href="#">🏦 Savings</a>
        <a href="loan.php">💳 Loan</a>
        <a href="repayment.php">💵 Repayment</a>
        <a href="index.php">🚪 Logout</a>
    </aside>

    <main>
        <h2>Hi, <?php echo $_SESSION['memberuser']['fname'];?> </h2>
        <p>Here you can manage your savings</p>
        <div class="p-4">
            <h2>Savings Form</h2>
            <form action="<?php $_SELF_PHP ?>" method="POST" enctype="multipart/form-data" class="mb-4">
                <div class="mb-3">
                    <label class="form-label">Amount</label>
                    <input type="number" name="amount" class="form-control" placeholder="Enter amount" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Date</label>
                    <input type="text" value="<?php echo date('d/m/Y');?>" name="date" class="form-control" readonly required>
                </div>
                <button type="submit" class="btn btn-success">Save</button>
            </form>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Amount</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php echo_out_updateresult($runsavingsresult, count($runsavingsresult)) ?>
                </tbody>
            </table>

            <a href="dashboard.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
        </div>
    </main>

    
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>