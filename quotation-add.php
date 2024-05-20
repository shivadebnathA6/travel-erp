<?php
    include 'includes/after_login.php';
    $thisPageTitle = 'Quotation';
    $action = "ADD";


  

  if(isset($_POST['submit'])){
    $id = isset($_POST['id']) ? filtervar($mysqli, $_POST['id']) : '';
    $form_action=filtervar($mysqli,$_POST['form_action']);
$guest_name=filtervar($mysqli,$_POST['guest_name']);
$guest_phone=filtervar($mysqli,$_POST['guest_phone']);
$altphone=filtervar($mysqli,$_POST['altphone']);
$email=filtervar($mysqli,$_POST['email']);
$country=filtervar($mysqli,$_POST['country']);
$address=filtervar($mysqli,$_POST['address']);
$pincode=filtervar($mysqli,$_POST['pincode']);
$remarks=filtervar($mysqli,$_POST['remarks']);
$user_id=$_SESSION['login']['user_id'];
$gen_date=input_date(date('d-m-Y'));




    
    $data = "`guest_name` = '$guest_name',
    `guest_phone` = '$guest_phone',
    `altphone` = '$altphone',
    `email` = '$email',
    `country` = '$country',
    `address` = '$address',
    `pincode` = '$pincode',
    `remarks` = '$remarks',
         ";

    if($form_action == 'ADD'){
        $data.="`created_by` = '$user_id',`created_at` = '$gen_date'";
        $query = "INSERT INTO `tbl_guest` SET $data";
      
        $msg = "Successfully Inserted";
    }elseif($form_action == 'UPDATE'){
        $data.="`updated_by` = '$user_id',`updated_at` = '$gen_date'";
        $query = "UPDATE `tbl_guest` SET $data WHERE `id`='$id'";
        $msg = "Successfully Updated";
    }

    if($mysqli->query($query)){
       $result = array('result' => true, 'redirect' => 'task', 'dhSession' => ["success" => $msg]);
    }else{
        $result = array('result' => false, 'dhSession' => ["success" => "Sorry !! Try Again"]);
    }

    echo json_encode($result);
    exit;
  }

    

  if(isset($_REQUEST['e_id'])){
    $id         = filtervar($mysqli, $_REQUEST['e_id']);
    $get_result = $mysqli->query("SELECT * FROM `tbl_guest` WHERE `id`='$id' ");
    if($get_result->num_rows){
        $row = $get_result->fetch_assoc();
        $action = "UPDATE";
    }else{
        echo '<script>window.history.back();</script>'; exit;
    }
  }



?>
<!doctype html>
<html lang="en">

<head>
    <?php include_once 'includes/style.php' ?>
    <link rel="stylesheet" href="assets/libs/datatables/dataTables.bs4.css" />
    <link rel="stylesheet" href="assets/libs/jquery-ui/jquery-ui.css">

</head>

<body>
    <?php include_once 'includes/header.php' ?>
    <div class="main-content" id="miniaresult">
    <div class="page-content">
    <div class="container-fluid">

    <!-- start page title -->
    <div class="row">
    <!-- form proparty Start -->
    <div class="col-12">

    <div class="card">
    <div class="card-header">
    <h4><?php echo $action ?> <?php echo $thisPageTitle ?></h4>
    </div>
    <div class="card-body">
    <form class="dhForm" method="post">
    <div class="row g-3">
    <input type="hidden" name="form_action" id="form_action" value="<?php echo $action ?>">
    <input type="hidden" name="id" value="<?php echo (isset($row['id'])&&!empty($row['id'])?$row['id']:'') ?>">
    <div class="col-md-4">
        <label for="">Guest Name</label>
        <input type="text" name="guest_name" id="guest_name" class="form-control" readonly value="Demo Guest<?php echo (isset($row['guest_name'])&&!empty($row['guest_name'])?$row['guest_name']:'') ?>">
    </div>
    <div class="col-md-4">
        <label for="">Guest Phone</label>
        <input type="text" name="guest_phone" id="guest_phone" class="form-control numInput" readonly value="8989898989<?php echo (isset($row['guest_phone'])&&!empty($row['guest_phone'])?$row['guest_phone']:'') ?>">
    </div>
    
    <div class="col-md-4">
        <label for="">Guest Email</label>
        <input type="email" name="email" id="email" readonly class="form-control"value="demo@gmail.com<?php echo (isset($row['email'])&&!empty($row['email'])?$row['email']:'') ?>">
    </div>
    
    
    
    <div class="col-md-4">
        <label for="">Location</label>
        <input type="text" name="remarks" readonly id="remarks" class="form-control"value="Maldivs<?php echo (isset($row['remarks'])&&!empty($row['remarks'])?$row['remarks']:'') ?>">
    </div>
    <div class="col-md-1">
        <label for="">Male Pax</label>
        <input type="text" name="remarks" readonly id="remarks" class="form-control"value="1<?php echo (isset($row['remarks'])&&!empty($row['remarks'])?$row['remarks']:'') ?>">
    </div>
    <div class="col-md-1">
        <label for="">Feale Pax</label>
        <input type="text" name="remarks" readonly id="remarks" class="form-control"value="1<?php echo (isset($row['remarks'])&&!empty($row['remarks'])?$row['remarks']:'') ?>">
    </div>
    <div class="col-md-1">
        <label for="">Child Pax</label>
        <input type="text" name="remarks" readonly id="remarks" class="form-control"value="0<?php echo (isset($row['remarks'])&&!empty($row['remarks'])?$row['remarks']:'') ?>">
    </div>
    <div class="col-md-1">
        <label for="">Infant Pax</label>
        <input type="text" name="remarks" readonly id="remarks" class="form-control"value="0<?php echo (isset($row['remarks'])&&!empty($row['remarks'])?$row['remarks']:'') ?>">
    </div>
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-4">
                <h4>Add hotels</h4>
                </div>
                <div class="col-md-8 text-end">
                    <button class="btn btn-success btn-sm"><i class="fa fa-plus me-1"></i>Add More</button>
                </div>
            </div>
        </div>
        <div class="card-body g-">
            <div class="row g-3">
                <div class="col-md-2">
                    <label for="">Hotel</label>
                    <select name="" class="form-select" id="">
                        <option value="">Select Hotel</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="">Check In</label>
                    <input type="text" name="" id="" value="12-6-2024" class="form-control datepicker">
                </div>
                <div class="col-md-2">
                    <label for="">Check Out</label>
                    <input type="text" name="" id="" value="14-6-2024" class="form-control datepicker">
                </div>
                <div class="col-md-2">
                    <label for="">Place</label>
                    <input type="text" name="" id="" value="" class="form-control">
                </div>
                <div class="col-md-2">
                    <label for="">No Of Room</label>
                    <input type="text" name="" id="" value="1" class="form-control">
                </div>
                <div class="col-md-2">
                    <label for="">Cost</label>
                    <input type="text" name="" id="" value="1500" class="form-control">
                </div>

            </div>
            <div class="row g-3 mt-2">
                <div class="col-md-2">
                    <label for="">Hotel</label>
                    <select name="" class="form-select" id="">
                        <option value="">Select Hotel</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="">Check In</label>
                    <input type="text" name="" id="" value="12-6-2024" class="form-control datepicker">
                </div>
                <div class="col-md-2">
                    <label for="">Check Out</label>
                    <input type="text" name="" id="" value="14-6-2024" class="form-control datepicker">
                </div>
                <div class="col-md-2">
                    <label for="">Place</label>
                    <input type="text" name="" id="" value="" class="form-control">
                </div>
                <div class="col-md-2">
                    <label for="">No Of Room</label>
                    <input type="text" name="" id="" value="1" class="form-control">
                </div>
                <div class="col-md-2">
                    <label for="">Cost</label>
                    <input type="text" name="" id="" value="1500" class="form-control">
                </div>
<div class="col-md-12 text-end">
<button class="btn btn-sm btn-danger"><i class="fa fa-trash me-1" ></i>remove</button>
</div>
            </div>
        </div>
    </div>
</div>

<!-- cab -->
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-4">
                <h4>Add Cabs</h4>
                </div>
                <div class="col-md-8 text-end">
                    <button class="btn btn-success btn-sm"><i class="fa fa-plus me-1"></i>Add More</button>
                </div>
            </div>
        </div>
        <div class="card-body g-">
            <div class="row g-3">
                <div class="col-md-2">
                    <label for="">Cab</label>
                    <select name="" class="form-select" id="">
                        <option value="">Select Cab</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="">Date </label>
                    <input type="text" name="" id="" value="12-6-2024 " class="form-control datepicker">
                </div>
                <div class="col-md-2">
                    <label for="">From</label>
                    <input type="text" name="" id="" value="" class="form-control datepicker">
                </div>
                <div class="col-md-2">
                    <label for="">To</label>
                    <input type="text" name="" id="" value="" class="form-control">
                </div>
                <div class="col-md-1">
                    <label for="">No Of Cab</label>
                    <input type="text" name="" id="" value="1" class="form-control">
                </div>
                <div class="col-md-1">
                    <label for="">Pacenger</label>
                    <input type="text" name="" id="" value="2" class="form-control">
                </div>
                <div class="col-md-2">
                    <label for="">Cost</label>
                    <input type="text" name="" id="" value="1500" class="form-control">
                </div>

            </div>
            <div class="row g-3 mt-2">
            <div class="col-md-2">
                    <label for="">Cab</label>
                    <select name="" class="form-select" id="">
                        <option value="">Select Cab</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="">Date </label>
                    <input type="text" name="" id="" value="12-6-2024 " class="form-control datepicker">
                </div>
                <div class="col-md-2">
                    <label for="">From</label>
                    <input type="text" name="" id="" value="" class="form-control datepicker">
                </div>
                <div class="col-md-2">
                    <label for="">To</label>
                    <input type="text" name="" id="" value="" class="form-control">
                </div>
                <div class="col-md-1">
                    <label for="">No Of Cab</label>
                    <input type="text" name="" id="" value="1" class="form-control">
                </div>
                <div class="col-md-1">
                    <label for="">Pacenger</label>
                    <input type="text" name="" id="" value="2" class="form-control">
                </div>
                <div class="col-md-2">
                    <label for="">Cost</label>
                    <input type="text" name="" id="" value="1500" class="form-control">
                </div>
<div class="col-md-12 text-end">
<button class="btn btn-sm btn-danger"><i class="fa fa-trash me-1" ></i>remove</button>
</div>
            </div>
        </div>
    </div>
</div>

<!-- cab-end -->
<!-- addon -->
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-4">
                <h4>Add Addon</h4>
                </div>
                <div class="col-md-8 text-end">
                    <button class="btn btn-success btn-sm"><i class="fa fa-plus me-1"></i>Add More</button>
                </div>
            </div>
        </div>
        <div class="card-body g-">
            <div class="row g-3">
                <div class="col-md-3">
                    <label for="">Addon Name</label>
                   <input type="text" name="" id="" class="form-control">
                </div>
                <div class="col-md-3">
                    <label for="">Date </label>
                    <input type="text" name="" id="" value="12-6-2024 " class="form-control datepicker">
                </div>
                
                <div class="col-md-3">
                    <label for="">No Of Addon</label>
                    <input type="text" name="" id="" value="2" class="form-control">
                </div>
                
                <div class="col-md-3">
                    <label for="">Cost</label>
                    <input type="text" name="" id="" value="1500" class="form-control">
                </div>

            </div>
            <div class="row g-3 mt-2">
            <div class="col-md-3">
                    <label for="">Addon Name</label>
                   <input type="text" name="" id="" class="form-control">
                </div>
                <div class="col-md-3">
                    <label for="">Date </label>
                    <input type="text" name="" id="" value="12-6-2024 " class="form-control datepicker">
                </div>
                
                <div class="col-md-3">
                    <label for="">No Of Addon</label>
                    <input type="text" name="" id="" value="2" class="form-control">
                </div>
                
                <div class="col-md-3">
                    <label for="">Cost</label>
                    <input type="text" name="" id="" value="1500" class="form-control">
                </div>
<div class="col-md-12 text-end">
<button class="btn btn-sm btn-danger"><i class="fa fa-trash me-1" ></i>remove</button>
</div>
            </div>
        </div>
    </div>
</div>

<!-- addon-end -->
<!-- calculations -->
<div class="col-md-4">
    <label for="">Hotel Total</label>
    <input type="text" name="" id="" class="form-control">
</div>
<div class="col-md-4">
    <label for="">Cab Total</label>
    <input type="text" name="" id="" class="form-control">
</div>
<div class="col-md-4">
    <label for="">Addon Total</label>
    <input type="text" name="" id="" class="form-control">
</div>
<div class="col-md-4">
    <label for="">Cgst %</label>
    <input type="text" name="" id="" class="form-control">
</div>
<div class="col-md-4">
    <label for="">Sgst %</label>
    <input type="text" name="" id="" class="form-control">
</div>
<div class="col-md-4">
    <label for="">Other Tax %</label>
    <input type="text" name="" id="" class="form-control">
</div>
<div class="col-md-4">
    
    <label for="">Grand Total</label>
    <input type="text" name="" id="" class="form-control">
   
</div>
    <!-- calculations-end -->

    <div class="col-md-12  text-center">
        <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle me-2"></i>SUBMIT DETAILS</button>
    </div>
    </div>
    </form>
    </div>
    </div>

    </div>
    <!-- form proparty end -->
    

    </div> <!-- container-fluid -->
    </div>
    </div>

    <?php include_once 'includes/footer.php' ?>
    <script src="assets/libs/jquery-ui/jquery-ui.js"></script>
    <script src="assets/libs/datatables/dataTables.min.js"></script>
    <script src="assets/libs/datatables/dataTables.bootstrap.min.js"></script>
    <script src="assets/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js"></script>



</body>

</html>