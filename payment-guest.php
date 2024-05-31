<?php
include 'includes/after_login.php';
$thisPageTitle = 'GUEST PAYMENTS';
$action = "ADD";

$query = $mysqli->query("SELECT * FROM `tbl_quotation` WHERE `is_deleted`=0");

if(isset($_REQUEST['submit'])){
   $check=checkPaymentAmount($_POST['quotation_id'],$_POST['paid_amount']);
if($check){
    $quotation_id=filtervar($mysqli,$_POST['quotation_id']);
    $paid_amount=filtervar($mysqli,$_POST['paid_amount']);
    $guest_id=filtervar($mysqli,$_POST['guest_id']);
    $payment_date=filtervar($mysqli,input_date($_POST['payment_date']));
    $due_amount=filtervar($mysqli,$_POST['due_amount']);
    $due_amount=$due_amount-$paid_amount;
    $user_id=$_SESSION['login']['user_id'];
    $gen_date=input_date(date('d-m-Y'));


    $data     = "   `quotation_id`       = '$quotation_id',
                    `guest_id`       = '$guest_id',
                    `created_at`       = '$payment_date',
                    `due_amount`       = '$due_amount',
                        `paid_amount`      = '$paid_amount',";
    $data.="`created_by` = '$user_id'";
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
                <!-- modal start  -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form class="dhForm" method="post">
                                <div class="modal-body">
                                    <input type="hidden" class="form-control" id="quotation_id" name="quotation_id">
                                    <input type="hidden" class="form-control" id="due_amount" name="due_amount">
                                    <input type="hidden" class="form-control" id="guest_id" name="guest_id">
                                    <label for="">Amount</label>
                                    <input type="text" class="form-control numInput" id="paid_amount" name="paid_amount">
                                <label for="">Date</label>
                                <input type="text" name="payment_date" class="form-control datepicker" id="payment_date">
                                </div>
                                
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary"data-bs-dismiss="modal">Make Payment</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- modal end -->
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <tr>

                                    <th>Sl. No</th>
                                    <th>Quotation No.</th>
                                    <th>Guest Name</th>
                                    <th>Total Amount</th>
                                    <th>Amount Due</th>
                                    <th>Action</th>
                                </tr>
                                <?php $slno = 1;
                                while ($row = $query->fetch_array()) { ?>
                                    <tr>
                                        <td><?php echo $slno;
                                            $slno++ ?></td>
                                        <td><?php echo 'QUOT-' . $row['id'] ?></td>
                                        <td><?php echo getGuestName($row['guest_id']) ?></td>
                                        <td><?php echo $row['pack_total'] ?></td>
                                        <td><?php $paid = getQuotDue($row['id']);
                                            echo $row['pack_total'] - $paid ?></td>
                                        <td><?php $due=$row['pack_total'] - $paid; if($due>=0){ ?><button type="button" onclick="openPayNow(<?php echo $row['id'] ?>,<?php echo $row['guest_id'] ?>,<?php echo $due ?>)" class="btn btn-sm btn-success">Pay Now</button> <?php }else{ echo 'paid'; } ?></td>
                                    </tr>
                                <?php } ?>
                            </table>
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
        $('.datepicker').datepicker();
        function openPayNow(quotation_id,guest_id,due_amount) {
            $('input').val('');
            $('#quotation_id').val(quotation_id);
            $('#due_amount').val(due_amount);
            $('#guest_id').val(guest_id);
            $('#exampleModal').modal('show');
        }
    </script>
</body>

</html>