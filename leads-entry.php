<?php
    include 'includes/after_login.php';
    $thisPageTitle = 'LEADS';
    $action = "ADD";


  

  if(isset($_POST['submit'])){
    $id = isset($_POST['id']) ? filtervar($mysqli, $_POST['id']) : '';
    $form_action=filtervar($mysqli,$_POST['form_action']);
$guest_id=filtervar($mysqli,$_POST['guest_id']);
$male_pax=filtervar($mysqli,$_POST['male_pax']);
$female_pax=filtervar($mysqli,$_POST['female_pax']);
$child_pax=filtervar($mysqli,$_POST['child_pax']);
$infant_pax=filtervar($mysqli,$_POST['infant_pax']);
$loc_id=filtervar($mysqli,$_POST['loc_id']);
$remarks=filtervar($mysqli,$_POST['remarks']);
$user_id=$_SESSION['login']['user_id'];
$gen_date=input_date(date('d-m-Y'));




    
    $data = "`guest_id` = '$guest_id',
    `male_pax` = '$male_pax',
    `female_pax` = '$female_pax',
    `child_pax` = '$child_pax',
    `infant_pax` = '$infant_pax',
    `loc_id` = '$loc_id',
    `remarks` = '$remarks',";

    if($form_action == 'ADD'){
        $data.="`created_by` = '$user_id',`created_at` = '$gen_date'";
        $query = "INSERT INTO `tbl_leads` SET $data";
      
        $msg = "Successfully Inserted";
    }elseif($form_action == 'UPDATE'){
        $data.="`updated_by` = '$user_id',`updated_at` = '$gen_date'";
        $query = "UPDATE `tbl_leads` SET $data WHERE `id`='$id'";
        $msg = "Successfully Updated";
    }

    if($mysqli->query($query)){
       $result = array('result' => true, 'redirect' => 'leads-entry', 'dhSession' => ["success" => $msg]);
    }else{
        $result = array('result' => false, 'dhSession' => ["success" => "Sorry !! Try Again"]);
    }

    echo json_encode($result);
    exit;
  }

    

  if(isset($_REQUEST['e_id'])){
    $id         = filtervar($mysqli, $_REQUEST['e_id']);
    $get_result = $mysqli->query("SELECT * FROM `tbl_leads` WHERE `id`='$id' ");
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
    <div class="col-md-12">
        
        <select name="search_guest" id="search_guest" class="form-select select2">
            <option value="">Search Guest</option>
            <?php $field_sql=$mysqli->query("SELECT * FROM `tbl_guest` WHERE `is_deleted`=0");
            while($field_fetch=$field_sql->fetch_assoc()){
            ?>
            <option data-guest_name="<?php echo $field_fetch['guest_name'] ?>" data-email="<?php echo $field_fetch['email'] ?>" data-guest_phone="<?php echo $field_fetch['guest_phone'] ?>" data-guest_id="<?php echo $field_fetch['id'] ?>" value=""><?php echo $field_fetch['guest_name'] ?></option>
            <?php } ?>
        </select>
        <input type="hidden" name="guest_id" id="guest_id">
    </div>
    <div class="col-md-4">
        <label for="">Guest Name</label>
        <input type="text" readonly name="guest_name" id="guest_name" class="form-control" value="<?php echo (isset($row['guest_name'])&&!empty($row['guest_name'])?$row['guest_name']:'') ?>">
    </div>
    <div class="col-md-4">
        <label for="">Guest Phone</label>
        <input type="text" readonly name="guest_phone" id="guest_phone" class="form-control numInput"value="<?php echo (isset($row['guest_phone'])&&!empty($row['guest_phone'])?$row['guest_phone']:'') ?>">
    </div>
    
    <div class="col-md-4">
        <label for="">Guest Email</label>
        <input type="email" readonly name="email" id="email" class="form-control "value="<?php echo (isset($row['email'])&&!empty($row['email'])?$row['email']:'') ?>">
    </div>
    <div class="col-md-1">
        <label for="">Male</label>
        <select name="male_pax" id="male_pax" class="form-select">
            <option value="">Select</option>
            <?php for($i=1;$i<=10;$i++){ ?>
<option value="<?php echo $i ?>"><?php echo $i ?></option>
                <?php } ?>
        </select>
    </div>
    <div class="col-md-1">
        <label for="">Female</label>
        <select name="female_pax" id="female_pax" class="form-select">
            <option value="">Select</option>
            <?php for($i=1;$i<=10;$i++){ ?>
<option value="<?php echo $i ?>"><?php echo $i ?></option>
                <?php } ?>
        </select>
    </div>
    <div class="col-md-1">
        <label for="">Child</label>
        <select name="child_pax" id="child_pax" class="form-select">
            <option value="">Select</option>
            <?php for($i=1;$i<=10;$i++){ ?>
<option value="<?php echo $i ?>"><?php echo $i ?></option>
                <?php } ?>
        </select>
    </div>
    <div class="col-md-1">
        <label for="">Infant</label>
        <select name="infant_pax" id="infant_pax" class="form-select">
            <option value="">Select</option>
            <?php for($i=1;$i<=10;$i++){ ?>
<option value="<?php echo $i ?>"><?php echo $i ?></option>
                <?php } ?>
        </select>
    </div>
    <div class="col-md-4">
        <label for="">Location</label>
        <select name="loc_id" id="loc_id" class="form-select">
            <option value="">Select</option>
            <?php
            $field_sql=$mysqli->query("SELECT * FROM `tbl_location` WHERE `is_deleted`=0");
            while($field_fetch=$field_sql->fetch_array()){ ?>
<option value="<?php echo $field_fetch['id'] ?>"><?php echo $field_fetch['location'] ?></option>
                <?php } ?>
        </select>
    </div>
    <div class="col-md-4">
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


    <script>
     $('.select2').select2();
</script>
<script>
    $(document).ready(function() {
        $('#search_guest').change(function() {
            // Get the selected option
            var selectedOption = $(this).find('option:selected');
            
            // Get data attributes from the selected option
            var guestName = selectedOption.data('guest_name');
            var guestPhone = selectedOption.data('guest_phone');
            var guestEmail = selectedOption.data('email');
            var guestId = selectedOption.data('guest_id');
            
            // Set the values in the respective input fields
            $('#guest_name').val(guestName);
            $('#guest_phone').val(guestPhone);
            $('#email').val(guestEmail);
            $('#guest_id').val(guestId); // Assuming you need to set this hidden field as well
        });
    });
</script>
</body>

</html>