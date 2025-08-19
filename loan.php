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
$type = $conn->query("SELECT * FROM loan_types order by `type_name` desc ");
$plan = $conn->query("SELECT * FROM loan_plan order by `months` desc ");
//print_r($row);

if (isset($_POST['btnSaveLoan'])) {
    
    $status = 0;

    extract($_POST);
    $data = " member_id = $member_id ";
    $data .= " , loan_type_id = '$loan_type_id' ";
    $data .= " , plan_id = '$plan_id' ";
    $data .= " , amount = '$amount' ";
    $data .= " , purpose = '$purpose' ";
    $data .= " , status = '$status' ";

    $ref_no = mt_rand(1,99999999);
    $i= 1;

    while($i== 1){
        $check = $conn->query("SELECT * FROM loan_list where ref_no ='$ref_no' ")->num_rows;
        if($check > 0){
        $ref_no = mt_rand(1,99999999);
        }else{
            $i = 0;
        }
    }
    $data .= " , date_created = '".date("Y-m-d H:i")."' ";
    $data .= " , date_released = '0000-00-00 00:00:00' ";
    $data .= " , ref_no = '$ref_no' ";

    $save = $conn->query("INSERT INTO loan_list set ".$data);
    
    echo "<script> alert('Loan Request Submitted!'); </script>";
}

// declaring an empty array to hold different querys
$query = [];
$queryarray = [];
	
// Query to search only music table in the database
$query['getloans'] = "
    SELECT `amount`, `purpose`, `date_created`, `status`  FROM loan_list 
    WHERE member_id='".$memberID."'  LIMIT 10 OFFSET 0
";

$runloans = run_query($conn, $query['getloans']);
$runloansresult = mysqli_fetch_all($runloans);

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
    <h2>Hi, <?php echo $_SESSION['memberuser']['fname'];?></h2>
    <p>Here you can manage and apply for loans</p>
    
    <div class="p-4">
        <?php //include('helper_functions/manage_loan.php');?>
        <h2>Loan Request Form</h2>
        <form action="<?php $_SELF_PHP ?>" method="POST" enctype="multipart/form-data" class="mb-4">

            <div class="mb-3">
                <label class="control-label">Member</label>
				<select name="member_id" id="member_id" class="custom-select browser-default select2 form-control" required>
					<option value=""></option>
					<option value="<?php echo $row['id']?>"> <?php echo $row['firstname'] . ' | Tax ID:'.$row['tax_id'] ?> </option>
				</select>
            </div>

            <div class="mb-3">
                <label class="form-label">Loan Amount</label>
                <input type="number" name="amount" class="form-control" placeholder="Enter loan amount" required>
            </div>

            <div class="mb-3">
                <label class="control-label">Loan Type</label>
                <select name="loan_type_id" id="loan_type_id" class="custom-select browser-default select2 form-control" required>
                    <option value=""></option>
                        <?php while($row = $type->fetch_assoc()): ?>
                            <option value="<?php echo $row['id'] ?>" <?php echo isset($loan_type_id) && $loan_type_id == $row['id'] ? "selected" : '' ?>><?php echo $row['type_name'] ?></option>
                        <?php endwhile; ?>
                </select>
            </div>

            <div class="mb-3">
				<label class="control-label">Loan Plan</label>
				<select name="plan_id" id="plan_id" class="custom-select browser-default select2 form-control" >
					<option value=""></option>
						<?php while($row = $plan->fetch_assoc()): ?>
							<option value="<?php echo $row['id'] ?>" <?php echo isset($plan_id) && $plan_id == $row['id'] ? "selected" : '' ?> data-months="<?php echo $row['months'] ?>" data-interest_percentage="<?php echo $row['interest_percentage'] ?>" data-penalty_rate="<?php echo $row['penalty_rate'] ?>"><?php echo $row['months'] . ' month/s [ '.$row['interest_percentage'].'%, '.$row['penalty_rate'].'% ]' ?></option>
						<?php endwhile; ?>
				</select>
			</div>

            <div class="mb-3">
                <label class="control-label">Purpose</label>
                <textarea name="purpose" id="" cols="30" rows="2" class="form-control" required><?php echo isset($purpose) ? $purpose : '' ?></textarea>
            </div>

            <button type="submit" name="btnSaveLoan" class="btn btn-primary">Apply for Loan</button>
            <button class="btn btn-primary" type="button" id="calculate">Calculate</button> 
        </form>
        <div id="calculation_table">
			
		</div>
        

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
                <?php echo_out_loans($runloansresult, count($runloansresult)); ?>
            </tbody>
        </table>

        <a href="dashboard.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
    </div>
    
</main>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</body>

<script>
    window.alert_toast= function($msg = 'TEST',$bg = 'success'){
        $('#alert_toast').removeClass('bg-success')
        $('#alert_toast').removeClass('bg-danger')
        $('#alert_toast').removeClass('bg-info')
        $('#alert_toast').removeClass('bg-warning')

        if($bg == 'success')
        $('#alert_toast').addClass('bg-success')
        if($bg == 'danger')
        $('#alert_toast').addClass('bg-danger')
        if($bg == 'info')
        $('#alert_toast').addClass('bg-info')
        if($bg == 'warning')
        $('#alert_toast').addClass('bg-warning')
        $('#alert_toast .toast-body').html($msg)
        $('#alert_toast').toast({delay:3000}).toast('show');
    }
    
    let calBtn = document.getElementById('calculate');
    calBtn.addEventListener('click', function() {
        calculate();
    });
	
	function calculate(){
		if($('#plan_id').val() == '' && $('[name="amount"]').val() == ''){
			alert_toast("Select plan and enter amount first.","warning");
			return false;
		}
		var plan = $("#plan_id option[value='"+$("#plan_id").val()+"']")
		$.ajax({
			url:"admin/calculation_table.php",
			method:"POST",
			data:{amount:$('[name="amount"]').val(),months:plan.attr('data-months'),interest:plan.attr('data-interest_percentage'),penalty:plan.attr('data-penalty_rate')},
			success:function(resp){
				if(resp){
					
					$('#calculation_table').html(resp)
					
				}
			}

		})
	}
	
	$(document).ready(function(){
		if('<?php echo isset($memberID) ?>' == 1)
			calculate()
	})
</script>

</html>