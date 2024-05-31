<?php
include 'includes/after_login.php';
$thisPageTitle = 'GUEST PAYMENTS REPORT';
$action = "ADD";

$sql="SELECT * FROM `tbl_payment_guest` WHERE `is_deleted`=0";
// add filter
if(isset($_GET["guest"])&&!empty($_GET["guest"])){
    $guest_id=$_GET["guest"];
$sql.=" AND `guest_id`=$guest_id";
}
if(isset($_GET["quotation_id"])&&!empty($_GET["quotation_id"])){
    $quotation_id=$_GET["quotation_id"];
$sql.=" AND `quotation_id`=$quotation_id";
}
if(isset($_GET["start_date"])&&isset($_GET["end_date"])&&!empty($_GET["start_date"])&&!empty($_GET["end_date"])){
    $start_date=input_date($_GET["start_date"]);
    $end_date=input_date($_GET["end_date"]);
    $sql.= " AND `created_at` BETWEEN '$start_date' AND '$end_date'";
}



$query = $mysqli->query($sql);

if(isset($_REQUEST['submit'])){
   $check=checkPaymentAmount($_POST['quotation_id'],$_POST['paid_amount']);
if($check){
    $quotation_id=filtervar($mysqli,$_POST['quotation_id']);
    $paid_amount=filtervar($mysqli,$_POST['paid_amount']);
    $user_id=$_SESSION['login']['user_id'];
    $gen_date=input_date(date('d-m-Y'));


    $data     = "   `quotation_id`       = '$quotation_id',
                        `paid_amount`      = '$paid_amount',";
    $data.="`created_by` = '$user_id',`created_at` = '$gen_date'";
    $query_insert = "INSERT INTO `tbl_payment_guest` SET $data";
    $msg   = "Successfully Inserted";
    if($mysqli->query($query_insert)){
        $result = array('result' => true, 'redirect' => 'payment-guest', 'dhSession' => ["success" => $msg]);
    }else{
        $result = array('result' => false, 'dhSession' => ["success" => "Sorry !! Try Again"]);
    }
}else{
    $result = array('result' => false, 'dhSession' => ["warning" => "Sorry !! Try Again0"]);
}
    echo json_encode($result);
    exit;
}

?>
<!doctype html>
<html lang="en">

<head>
    <?php include_once 'includes/style.php' ?>
        <link rel="stylesheet" href="assets/libs/jquery-ui/jquery-ui.css">
    

</head>

<body>
    <?php include_once 'includes/header.php' ?>
    <div class="main-content" id="miniaresult">
        <div class="page-content">
            <div class="container-fluid">
              
                <!-- start page title -->
                <div class="card">
                    <div class="card-header">
                        <form  method="get">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <select name="quotation_id" id="quotation_id" class="form-select">
                                    <option value="">Chose Quotation</option>
                                    <?php $field_sql=$mysqli->query("SELECT * FROM `tbl_quotation` WHERE `is_deleted`=0");
                                    while($field_row=$field_sql->fetch_array()){
                                    ?>
                                        <option value="<?php echo $field_row['id'] ?>" <?php echo (isset($_GET['quotation_id'])&&!empty($_GET['quotation_id'])&&$_GET['quotation_id']==$field_row['id'])?'selected':'' ?>>QUOT-<?php echo $field_row['id'] ?></option>

                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="guest" id="guest" class="form-select">
                                    <option value="">Chose Guest</option>
                                    <?php 
                                        $field_sql=$mysqli->query("SELECT * FROM `tbl_guest` WHERE `is_deleted`=0");
                                        while($field_row = $field_sql->fetch_array()){
                                    ?>
                                        <option value="<?php  echo $field_row['id'] ?>" <?php echo (isset($_GET['guest'])&&!empty($_GET['guest'])&&$_GET['guest']==$field_row['id'])?'selected':'' ?>><?php  echo $field_row['guest_name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <input type="text" name="start_date" id="start_date" class="form-control start_date" placeholder="Enter Date" value="<?php echo isset($_GET['start_date'])&&!empty($_GET['start_date'])?$_GET['start_date']:'' ?>">
                            </div>
                            <div class="col-md-2">
                                <input type="text" name="end_date" id="end_date" class="form-control end_date" placeholder="Enter Date" value="<?php echo isset($_GET['end_date'])&&!empty($_GET['end_date'])?$_GET['end_date']:'' ?>">
                            </div>
                            <div class="col-md-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-primary w-100">Flter</button>
                                    </div>
                                    <div class="col-md-6">
                                        <a href="report-payment" class="btn btn-warning w-100">Reset</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                    <div class="card-body">
                    <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <tr>

                                    <th>Sl. No</th>
                                    <th>Quotation No.</th>
                                    <th>Guest Name</th>
                                    <th>Amount Paid</th>
                                    <th>Amount Due</th>
                                    <th>Date</th>
                                </tr>
                                <?php $slno = 1;
                                $total_paid_amount=0;
                                $total_amount=getQuotTotalAmount();
                                while ($row = $query->fetch_array()) { 
                                     ?>
                                    <tr>
                                        <td><?php echo $slno;
                                            $slno++ ?></td>
                                        <td><?php echo 'QUOT-' . $row['quotation_id'] ?></td>
                                        <td><?php echo getGuestName($row['guest_id']) ?></td>
                                        <td><?php  $total_paid_amount+= $row['paid_amount']; echo $row['paid_amount'];?></td>
                                        <td><?php echo $row['due_amount']?></td>
                                        <td><?php echo output_date($row['created_at'])?></td>
                                    </tr>
                                <?php } ?>

                                <tr> <td colspan="4"></td> <td colspan="2" class="text-start"><b>Total Amount Paid :<?php echo $total_paid_amount ?></b></td>
                            
                            </tr>
                            </table>
                        </div>
                    </div>
                </div>
                    </div>
                </div>
                <!-- end page title -->

            </div> <!-- container-fluid -->
        </div>
    </div>

    <?php include_once 'includes/footer.php' ?>    
    <script src="assets/libs/jquery/jquery.min.js"></script>
        <script src="assets/libs/jquery-ui/jquery-ui.js"></script>

    <script>
        function openPayNow(quotation_id,due_amount) {
            
            $('#quotation_id').val(quotation_id);
            $('#exampleModal').modal('show');
        }
    </script>
</body>

</html>