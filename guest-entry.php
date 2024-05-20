<?php
    include 'includes/after_login.php';
    $thisPageTitle = 'GUEST';
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
        <input type="text" name="guest_name" id="guest_name" class="form-control" value="<?php echo (isset($row['guest_name'])&&!empty($row['guest_name'])?$row['guest_name']:'') ?>">
    </div>
    <div class="col-md-4">
        <label for="">Guest Phone</label>
        <input type="text" name="guest_phone" id="guest_phone" class="form-control numInput"value="<?php echo (isset($row['guest_phone'])&&!empty($row['guest_phone'])?$row['guest_phone']:'') ?>">
    </div>
    <div class="col-md-4">
        <label for="">Alt. Phone</label>
        <input type="text" name="altphone" id="altphone" class="form-control"value="<?php echo (isset($row['altphone'])&&!empty($row['altphone'])?$row['altphone']:'') ?>">
    </div>
    <div class="col-md-4">
        <label for="">Guest Email</label>
        <input type="email" name="email" id="email" class="form-control"value="<?php echo (isset($row['email'])&&!empty($row['email'])?$row['email']:'') ?>">
    </div>
    <div class="col-md-4">
        <label for="">Country</label>
        <input type="text" name="country" id="country" class="form-control"value="<?php echo (isset($row['country'])&&!empty($row['country'])?$row['country']:'') ?>">
    </div>
    <div class="col-md-4">
        <label for="">Address</label>
        <input type="text" name="address" id="address" class="form-control"value="<?php echo (isset($row['address'])&&!empty($row['address'])?$row['address']:'') ?>">
    </div>
    <div class="col-md-4">
        <label for="">Pin/Zip Code</label>
        <input type="text" name="pincode" id="pincode" class="form-control"value="<?php echo (isset($row['pincode'])&&!empty($row['pincode'])?$row['pincode']:'') ?>">
    </div>
    <div class="col-md-8">
        <label for="">Remarks</label>
        <input type="text" name="remarks" id="remarks" class="form-control"value="<?php echo (isset($row['remarks'])&&!empty($row['remarks'])?$row['remarks']:'') ?>">
    </div>
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