<?php
    include 'includes/after_login.php';
    $thisPageTitle = 'Quotation';
    $action = "ADD";

    //restriction
    if(isset($_REQUEST['lead_id'])){
        $lead_id         = filtervar($mysqli, $_REQUEST['lead_id']);
        $get_result = $mysqli->query("SELECT * FROM `tbl_leads` WHERE `id`='$lead_id'");
        if($get_result->num_rows){
            $lead_row = $get_result->fetch_assoc();
            $guest=getGuestRow($lead_row['guest_id']);
        }else{
            echo '<script>window.history.back();</script>'; exit;
        }
      }
  
  if(isset($_REQUEST['e_id'])){
    $id         = filtervar($mysqli, $_REQUEST['e_id']);
    $get_result = $mysqli->query("SELECT * FROM `tbl_quotation` WHERE `id`='$id' ");
    if($get_result->num_rows){
        $row = $get_result->fetch_assoc();
        $action = "UPDATE";
        $guest=getGuestRow($row['guest_id']);
        // print_r($row);
        // die;
        $lead_row=getLeadRow($row['lead_id']);
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
    <style>
        .remove-btn {
            margin-top: 30px;
        }
    </style>
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
                                <form action="quotation-submit" method="post">
                                    <div class="row g-3">
                                        <input type="hidden" name="form_action" id="form_action" value="<?php echo $action ?>">
                                        <input type="hidden" name="id" value="<?php echo (isset($row['id'])&&!empty($row['id'])?$row['id']:'') ?>">
                                        <input type="hidden" name="guest_id" id="guest_id" value="<?php echo (isset($guest['id'])&&!empty($guest['id'])?$guest['id']:'') ?>">
                                        <input type="hidden" name="lead_id" id="lead_id" value="<?php echo (isset($lead_row['id'])&&!empty($lead_row['id'])?$lead_row['id']:'') ?>">
                                        <div class="col-md-4">
                                            <label for="">Guest Name</label>
                                            <input type="text" name="guest_name" id="guest_name" class="form-control" readonly value="<?php echo (isset($guest['guest_name'])&&!empty($guest['guest_name'])?$guest['guest_name']:'') ?>">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="">Guest Phone</label>
                                            <input type="text" name="guest_phone" id="guest_phone" class="form-control numInput" readonly value="<?php echo (isset($guest['guest_phone'])&&!empty($guest['guest_phone'])?$guest['guest_phone']:'') ?>">
                                        </div>

                                        <div class="col-md-4">
                                            <label for="">Guest Email</label>
                                            <input type="email" name="email" id="email" readonly class="form-control"value="<?php echo (isset($guest['email'])&&!empty($guest['email'])?$guest['email']:'') ?>">
                                        </div>



                                        <div class="col-md-4">
                                            <label for="">Location</label>
                                            <input type="text" name="loc_id" readonly id="remarks" class="form-control"value="<?php echo (isset($lead_row['loc_id'])&&!empty($lead_row['loc_id'])?getLocationName($lead_row['loc_id']):'') ?>">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="">Male Pax</label>
                                            <input type="text" name="male_pax" readonly id="male_pax" class="form-control"value="<?php echo (isset($lead_row['male_pax'])&&!empty($lead_row['male_pax'])?$lead_row['male_pax']:'') ?>">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="">Female Pax</label>
                                            <input type="text" name="female_pax" readonly id="female_pax" class="form-control"value="<?php echo (isset($lead_row['female_pax'])&&!empty($lead_row['female_pax'])?$lead_row['female_pax']:'') ?>">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="">Child Pax</label>
                                            <input type="text" name="child_pax" readonly id="child_pax" class="form-control"value="<?php echo (isset($lead_row['child_pax'])&&!empty($lead_row['child_pax'])?$lead_row['child_pax']:'') ?>">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="">Infant Pax</label>
                                            <input type="text" name="infant_pax" readonly id="infant_pax" class="form-control"value="<?php echo (isset($lead_row['infant_pax'])&&!empty($lead_row['infant_pax'])?$lead_row['infant_pax']:'') ?>">
                                        </div>
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <h4>Add hotels</h4>
                                                        </div>
                                                        <div class="col-md-8 text-end">
                                                            <button type="button" class="btn btn-success btn-sm add-hotel-btn"><i class="fa fa-plus me-1"></i>Add More</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body hotel-body">
                                                    <div class="row g-3 hotel-row">
                                                        <div class="col-md-2">
                                                            <label for="">Hotel</label>
                                                            <select name="hotel[]" class="form-select">
                                                                
                                                                <option value="">Select Hotel</option>
                                                                <?php $field_sql=$mysqli->query("SELECT * FROM `tbl_hotel` WHERE `is_deleted`=0");
                                                                 while($field_fetch=$field_sql->fetch_array()){
                                                                 ?>
                                                                    <option value="<?php echo $field_fetch['id']  ?>"><?php echo $field_fetch['hotel_name'] ?></option>
                                                                 <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="">Check In</label>
                                                            <input type="text" name="checkin[]" value="" class="form-control datepicker">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="">Check Out</label>
                                                            <input type="text" name="checkout[]" value="" class="form-control datepicker">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="">Place</label>
                                                            <input type="text" name="place[]" value="" class="form-control">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="">No Of Room</label>
                                                            <input type="text" name="rooms[]" value="" class="form-control">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="">Cost</label>
                                                            <input type="text" name="hotel_cost[]" value="" class="form-control">
                                                        </div>
                                                        <div class="col-md-12 text-end">
                                                            <button type="button" class="btn btn-sm btn-danger remove-hotel-btn"><i class="fa fa-trash me-1"></i>remove</button>
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
                                                            <button type="button" class="btn btn-success btn-sm add-cab-btn"><i class="fa fa-plus me-1"></i>Add More</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body cab-body">
                                                    <div class="row g-3 cab-row">
                                                        <div class="col-md-2">
                                                            <label for="">Cab</label>
                                                            <select name="cab[]" class="form-select">
                                                                <option value="">Select Cab</option>
                                                                <?php $field_sql=$mysqli->query("SELECT * FROM `tbl_cab` WHERE `is_deleted`=0");
                                                                 while($field_fetch=$field_sql->fetch_array()){
                                                                 ?>
                                                                    <option value="<?php echo $field_fetch['id']  ?>"><?php echo $field_fetch['cab_name'] ?></option>
                                                                 <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="">Date </label>
                                                            <input type="text" name="cab_date[]" value="" class="form-control datepicker">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="">From</label>
                                                            <input type="text" name="cab_from[]" value="" class="form-control">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="">To</label>
                                                            <input type="text" name="cab_to[]" value="" class="form-control">
                                                        </div>
                                                        <div class="col-md-1">
                                                            <label for="">No Of Cab</label>
                                                            <input type="text" name="num_of_cab[]" value="" class="form-control">
                                                        </div>
                                                        <div class="col-md-1">
                                                            <label for="">Passenger</label>
                                                            <input type="text" name="passenger[]" value="" class="form-control">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="">Cost</label>
                                                            <input type="text" name="cab_cost[]" value="" class="form-control">
                                                        </div>
                                                        <div class="col-md-12 text-end">
                                                            <button type="button" class="btn btn-sm btn-danger remove-cab-btn"><i class="fa fa-trash me-1"></i>remove</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- addon -->
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <h4>Add Addon</h4>
                                                        </div>
                                                        <div class="col-md-8 text-end">
                                                            <button type="button" class="btn btn-success btn-sm add-addon-btn"><i class="fa fa-plus me-1"></i>Add More</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body addon-body">
                                                    <div class="row g-3 addon-row">
                                                    <div class="col-md-3">
                                                            <label for="">Addon</label>
                                                            <select name="addon[]" class="form-select">
                                                                <option value="">Select Addon</option>
                                                                <?php $field_sql=$mysqli->query("SELECT * FROM `tbl_addon` WHERE `is_deleted`=0");
                                                                 while($field_fetch=$field_sql->fetch_array()){
                                                                 ?>
                                                                    <option value="<?php echo $field_fetch['id']  ?>"><?php echo $field_fetch['addon_name'] ?></option>
                                                                 <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label for="">Date </label>
                                                            <input type="text" name="addon_date[]" value="" class="form-control datepicker">
                                                        </div>

                                                        <div class="col-md-3">
                                                            <label for="">No Of Addon</label>
                                                            <input type="text" name="num_of_addon[]" value="" class="form-control">
                                                        </div>

                                                        <div class="col-md-3">
                                                            <label for="">Cost</label>
                                                            <input type="text" name="addon_cost[]" value="" class="form-control">
                                                        </div>
                                                        <div class="col-md-12 text-end">
                                                            <button type="button" class="btn btn-sm btn-danger remove-addon-btn"><i class="fa fa-trash me-1"></i>remove</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- calculations -->
                                        <div class="col-md-4">
                                            <label for="">Hotel Total</label>
                                            <input type="text" name="hotel_total" id="hotel_total" class="form-control" readonly>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="">Cab Total</label>
                                            <input type="text" name="cab_total" id="cab_total" class="form-control" readonly>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="">Addon Total</label>
                                            <input type="text" name="addon_total" id="addon_total" class="form-control" readonly>
                                        </div>
                                      
                                        <div class="col-md-4">
                                            <label for="">Grand Total</label>
                                            <input type="text" name="grand_total" id="grand_total" class="form-control" readonly>
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
        <script src="assets/libs/jquery/jquery.min.js"></script>
        <script src="assets/libs/jquery-ui/jquery-ui.js"></script>
        <script src="assets/libs/datatables/dataTables.min.js"></script>
        <script src="assets/libs/datatables/dataTables.bootstrap.min.js"></script>
        <script src="assets/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js"></script>

        <script>
    $(document).ready(function () {
        // Function to add new hotel row
        $('.add-hotel-btn').click(function (e) {
            e.preventDefault();
            var newHotelRow = $('.hotel-row').first().clone();
            newHotelRow.find('input').val('');
            newHotelRow.find('select').val('');
            newHotelRow.appendTo('.hotel-body');
            reinitializeDatepicker();
            checkRemoveButtons();
        });

        // Function to remove hotel row
        $(document).on('click', '.remove-hotel-btn', function (e) {
            e.preventDefault();
            if ($('.hotel-row').length > 1) {
                $(this).closest('.hotel-row').remove();
            }
            calculateTotals();
            checkRemoveButtons();
        });

        // Function to add new cab row
        $('.add-cab-btn').click(function (e) {
            e.preventDefault();
            var newCabRow = $('.cab-row').first().clone();
            newCabRow.find('input').val('');
            newCabRow.find('select').val('');
            newCabRow.appendTo('.cab-body');
            reinitializeDatepicker();
            checkRemoveButtons();
        });

        // Function to remove cab row
        $(document).on('click', '.remove-cab-btn', function (e) {
            e.preventDefault();
            if ($('.cab-row').length > 1) {
                $(this).closest('.cab-row').remove();
            }
            calculateTotals();
            checkRemoveButtons();
        });

        // Function to add new addon row
        $('.add-addon-btn').click(function (e) {
            e.preventDefault();
            var newAddonRow = $('.addon-row').first().clone();
            newAddonRow.find('input').val('');
            newAddonRow.appendTo('.addon-body');
            reinitializeDatepicker();
            checkRemoveButtons();
        });

        // Function to remove addon row
        $(document).on('click', '.remove-addon-btn', function (e) {
            e.preventDefault();
            if ($('.addon-row').length > 1) {
                $(this).closest('.addon-row').remove();
            }
            calculateTotals();
            checkRemoveButtons();
        });

        // Function to check and hide/remove buttons
        function checkRemoveButtons() {
            if ($('.hotel-row').length <= 1) {
                $('.remove-hotel-btn').hide();
            } else {
                $('.remove-hotel-btn').show();
            }

            if ($('.cab-row').length <= 1) {
                $('.remove-cab-btn').hide();
            } else {
                $('.remove-cab-btn').show();
            }

            if ($('.addon-row').length <= 1) {
                $('.remove-addon-btn').hide();
            } else {
                $('.remove-addon-btn').show();
            }
        }

        // Reinitialize datepicker for all datepicker elements
        function reinitializeDatepicker() {
            $('.datepicker').each(function() {
                // $(this).datepicker('destroy'); // Destroy the current datepicker
                $(this).removeClass('hasDatepicker');
                $(this).removeAttr('id');
                $(this).datepicker('destroy');
                $(this).datepicker(); // Reinitialize the datepicker
            });
        }
        //calculate total

         // Function to calculate totals
         function calculateTotals() {
            let hotelTotal = 0;
            let cabTotal = 0;
            let addonTotal = 0;

            $('.hotel-body .hotel-row').each(function() {
                let cost = parseFloat($(this).find('input[name="hotel_cost[]"]').val()) || 0;
                hotelTotal += cost;
            });

            $('.cab-body .cab-row').each(function() {
                let cost = parseFloat($(this).find('input[name="cab_cost[]"]').val()) || 0;
                cabTotal += cost;
            });

            $('.addon-body .addon-row').each(function() {
                let cost = parseFloat($(this).find('input[name="addon_cost[]"]').val()) || 0;
                addonTotal += cost;
            });

            $('#hotel_total').val(hotelTotal.toFixed(2));
            $('#cab_total').val(cabTotal.toFixed(2));
            $('#addon_total').val(addonTotal.toFixed(2));

            let grandTotal = hotelTotal + cabTotal + addonTotal;
            $('#grand_total').val(grandTotal.toFixed(2));
        }
        $(document).on('input', 'input[name="hotel_cost[]"], input[name="cab_cost[]"], input[name="addon_cost[]"]', function() {
            calculateTotals();
        });

        // Initial check for remove buttons
        checkRemoveButtons();

        // Initialize datepicker for the first time
        reinitializeDatepicker();
        calculateTotals();
    });
</script>
    </body>

</html>
