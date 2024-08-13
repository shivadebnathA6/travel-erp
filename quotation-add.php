<?php
include 'includes/after_login.php';
$thisPageTitle = 'Quotation';
$action = "ADD";

//restriction
if (isset($_REQUEST['lead_id'])) {
    $lead_id         = filtervar($mysqli, $_REQUEST['lead_id']);
    $get_result = $mysqli->query("SELECT * FROM `tbl_leads` WHERE `id`='$lead_id'");
    if ($get_result->num_rows) {
        $lead_row = $get_result->fetch_assoc();
        $guest = getGuestRow($lead_row['guest_id']);
    } else {
        echo '<script>window.history.back();</script>';
        exit;
    }
}

if (isset($_REQUEST['e_id'])) {
    $id         = filtervar($mysqli, $_REQUEST['e_id']);
    $get_result = $mysqli->query("SELECT * FROM `tbl_quotation` WHERE `id`='$id' ");
    if ($get_result->num_rows) {
        $row = $get_result->fetch_assoc();
        $action = "UPDATE";
        $guest = getGuestRow($row['guest_id']);
        // print_r($row);
        // die;
        $lead_row = getLeadRow($row['lead_id']);
    } else {
        echo '<script>window.history.back();</script>';
        exit;
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
                                        <input type="hidden" name="id" value="<?php echo (isset($row['id']) && !empty($row['id']) ? $row['id'] : '') ?>">
                                        <input type="hidden" name="guest_id" id="guest_id" value="<?php echo (isset($guest['id']) && !empty($guest['id']) ? $guest['id'] : '') ?>">
                                        <input type="hidden" name="lead_id" id="lead_id" value="<?php echo (isset($lead_row['id']) && !empty($lead_row['id']) ? $lead_row['id'] : '') ?>">
                                        <div class="col-md-4">
                                            <label for="">Guest Name</label>
                                            <input type="text" name="guest_name" id="guest_name" class="form-control" readonly value="<?php echo (isset($guest['guest_name']) && !empty($guest['guest_name']) ? $guest['guest_name'] : '') ?>">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="">Guest Phone</label>
                                            <input type="text" name="guest_phone" id="guest_phone" class="form-control numInput" readonly value="<?php echo (isset($guest['guest_phone']) && !empty($guest['guest_phone']) ? $guest['guest_phone'] : '') ?>">
                                        </div>

                                        <div class="col-md-4">
                                            <label for="">Guest Email</label>
                                            <input type="email" name="email" id="email" readonly class="form-control" value="<?php echo (isset($guest['email']) && !empty($guest['email']) ? $guest['email'] : '') ?>">
                                        </div>



                                        <div class="col-md-4">
                                            <label for="">Location</label>
                                            <input type="text" name="loc_id" readonly id="remarks" class="form-control" value="<?php echo (isset($lead_row['loc_id']) && !empty($lead_row['loc_id']) ? getLocationName($lead_row['loc_id']) : '') ?>">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="">Male Pax</label>
                                            <input type="text" name="male_pax" readonly id="male_pax" class="form-control" value="<?php echo (isset($lead_row['male_pax']) && !empty($lead_row['male_pax']) ? $lead_row['male_pax'] : '') ?>">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="">Female Pax</label>
                                            <input type="text" name="female_pax" readonly id="female_pax" class="form-control" value="<?php echo (isset($lead_row['female_pax']) && !empty($lead_row['female_pax']) ? $lead_row['female_pax'] : '') ?>">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="">Child Pax</label>
                                            <input type="text" name="child_pax" readonly id="child_pax" class="form-control" value="<?php echo (isset($lead_row['child_pax']) && !empty($lead_row['child_pax']) ? $lead_row['child_pax'] : '') ?>">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="">Infant Pax</label>
                                            <input type="text" name="infant_pax" readonly id="infant_pax" class="form-control" value="<?php echo (isset($lead_row['infant_pax']) && !empty($lead_row['infant_pax']) ? $lead_row['infant_pax'] : '') ?>">
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
                                                            <select name="hotel[]" class="form-select hotel-select">

                                                                <option value="">Select Hotel</option>
                                                                <?php $field_sql = $mysqli->query("SELECT * FROM `tbl_hotel` WHERE `is_deleted`=0");
                                                                while ($field_fetch = $field_sql->fetch_array()) {
                                                                ?>
                                                                    <option value="<?php echo $field_fetch['id']  ?>"><?php echo $field_fetch['hotel_name'] ?>(<?php echo $field_fetch['hotel_loc'] ?>)</option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="">Room Type </label>
                                                            <select name="room_type[]" id="room_type" class="form-select room-type" required>
                                                                <!-- <option value="">Select Room Type</option> -->
                                                                <option value="">Hotel Not Selected</option>

                                                            </select>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="">Meal Plan</label>
                                                            <select name="meal_plan[]" id="meal_plan" class="form-select meal-plan">
                                                                <option value="">Hotel Not Selected</option>
                                                            </select>
                                                        </div>
                                                        <!-- <div class="col-md-2">
                                                            <label for="">Child Category</label>
                                                            <select name="child_category[]" id="child_category" class="form-select child-category">
                                                                <option value="">Hotel Not Selected</option>
                                                            </select>
                                                        </div> -->
                                                        <div class="col-md-2">
                                                            <label for="">Check In</label>
                                                            <input type="text" name="checkin[]" value="" class="form-control datepicker checkin">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="">Check Out</label>
                                                            <input type="text" name="checkout[]" value="" class="form-control datepicker checkout">
                                                        </div>

                                                        <div class="col-md-2 ">
                                                            <label for="">No Of Room</label>
                                                            <input type="text" name="rooms[]" value="1" class="form-control rooms">
                                                        </div>
                                                        <div class="col-md-2 d-none">
                                                            <label for="">No Of Pax</label>
                                                            <input type="text" name="pax[]" value="" class="form-control pax">
                                                        </div>
                                                        <div class="col-md-2 d-none">
                                                            <label for="">No Of Child</label>
                                                            <input type="text" name="child[]" value="" class="form-control child" readonly>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for=""> Price</label>
                                                            <input style="background-color:#90EE90;" type="text" name="hotel_cost[]" value="" class="form-control hotel-cost">
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
                                                        <div class="col-md-3">
                                                            <label for="">Cab</label>
                                                            <select name="cab[]" class="form-select cabs">
                                                                <option value="">Select Cab</option>
                                                                <?php $field_sql = $mysqli->query("SELECT * FROM `tbl_cab` WHERE `is_deleted`=0");
                                                                while ($field_fetch = $field_sql->fetch_array()) {
                                                                ?>
                                                                    <option value="<?php echo $field_fetch['id']  ?>"><?php echo $field_fetch['cab_name'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label for="">Date </label>
                                                            <input type="text" name="cab_date[]" value="" class="form-control datepicker cab_date">
                                                        </div>
                                                        <!-- <div class="col-md-2">
                                                            <label for="">From</label>
                                                            <input type="text" name="cab_from[]" value="" class="form-control">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="">To</label>
                                                            <input type="text" name="cab_to[]" value="" class="form-control">
                                                        </div> -->
                                                        <div class="col-md-3">
                                                            <label for="">No Of Cab</label>
                                                            <input type="text" name="num_of_cab[]" value="" class="form-control num_of_cab">
                                                        </div>

                                                        <div class="col-md-3">
                                                            <label for="">Price</label>
                                                            <input type="text" name="cab_cost[]" value="" class="form-control cab_cost">
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
                                                                <?php $field_sql = $mysqli->query("SELECT * FROM `tbl_addon` WHERE `is_deleted`=0");
                                                                while ($field_fetch = $field_sql->fetch_array()) {
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

                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <h4>Add Child</h4>
                                                        </div>
                                                        <div class="col-md-8 text-end">
                                                            <button type="button" class="btn btn-success btn-sm add-addon-btn"><i class="fa fa-plus me-1"></i>Add More</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                                <!-- add   child -->
                                                <div class="card-body child-body">
                                                    <div class="row g-3 child-row">
                                                    <div class="col-md-3">
                                                            <label for="">Child</label>
                                                            <select name="child[]" class="form-select">
                                                                <option value="">Select Child</option>
                                                                <?php $field_sql=$mysqli->query("SELECT * FROM `tbl_master_child` WHERE `is_deleted`=0");
                                                                 while($field_fetch=$field_sql->fetch_array()){
                                                                 ?>
                                                                    <option value="<?php echo $field_fetch['id']  ?>"><?php echo $field_fetch['category_type'] ?></option>
                                                                 <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="">Hotel</label>
                                                            <select name="hotel[]" class="form-select hotel-select">
                                                                
                                                                <option value="">Select Hotel</option>
                                                                <?php $field_sql=$mysqli->query("SELECT * FROM `tbl_hotel` WHERE `is_deleted`=0");
                                                                 while($field_fetch=$field_sql->fetch_array()){
                                                                 ?>
                                                                    <option value="<?php echo $field_fetch['id']  ?>"><?php echo $field_fetch['hotel_name'] ?>(<?php echo $field_fetch['hotel_loc'] ?>)</option>
                                                                 <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label for="">Check in Date </label>
                                                            <input type="text" name="addon_date[]" value="" class="form-control datepicker">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label for="">Check Out Date </label>
                                                            <input type="text" name="addon_date[]" value="" class="form-control datepicker">
                                                        </div>

                                                        <div class="col-md-3">
                                                            <label for="">No Of Child</label>
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
                                        <div class="col-md-12 text-center">
                                            <button type="button" class="btn btn-info" onclick="calculateTotals()">Calculate Total</button>
                                        </div>
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
                                        <div class="col-md-4">
                                            <label for="">Packege Total</label>
                                            <input type="text" name="pack_total" id="pack_total" class="form-control" required>
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
        </script>
        <script>
            $(document).ready(function() {

                $(document).on('change', '.hotel-select', function() {
                    var selectedHotelId = $(this).val();
                    var $hotelRow = $(this).closest('.hotel-row');
                    var $roomType = $hotelRow.find('.room-type');
                    var $mealPlan = $hotelRow.find('.meal-plan');
                    var $childCategory = $hotelRow.find('.child-category');

                    $.ajax({
                        url: 'includes/ajax.php',
                        method: 'POST',
                        data: {
                            hotel_id: selectedHotelId,
                            gethotelterrifquot: true
                        },
                        success: function(response) {
                            var decoded = JSON.parse(response);
                            $roomType.html(decoded.room_type);
                            $mealPlan.html(decoded.meal_plan);
                            $childCategory.html(decoded.child_category);
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                });
            });
        </script>
        <script>
            $(document).ready(function() {
                function getHotelActualPrice(hotel_id, roomType, mealPlan, childCategory, check_in, check_out, $hotelRow, rooms) {
                    $.ajax({
                        url: 'includes/ajax.php',
                        method: 'POST',
                        data: {
                            hotel_id: hotel_id,
                            room_type: roomType,
                            meal_plan: mealPlan,
                            child_category: childCategory,
                            check_in: check_in,
                            check_out: check_out,
                            // no_pax: no_pax,
                            // no_child: no_child,
                            getHotelActualPrice: true,
                            rooms: rooms
                        },
                        success: function(response) {

                            $hotelRow.find('.hotel-cost').val(response);
                            console.log(response);
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                }


                $(document).on('change', '.room-type, .meal-plan, .child-category, .checkin, .checkout,.rooms', function() {
                    var $hotelRow = $(this).closest('.hotel-row');
                    var roomType = $hotelRow.find('.room-type').val();
                    var mealPlan = $hotelRow.find('.meal-plan').val();
                    var childCategory = $hotelRow.find('.child-category').val();
                    var hotel_id = $hotelRow.find('.hotel-select').val();
                    // var no_pax = $hotelRow.find('.pax').val();
                    // var no_child = $hotelRow.find('.child').val();
                    var check_in = $hotelRow.find('.checkin').val();
                    var check_out = $hotelRow.find('.checkout').val();
                    var rooms = $hotelRow.find('.rooms').val();

                    if (childCategory == "") {
                        $hotelRow.find(".child").attr("readonly", true);
                        $hotelRow.find(".child").val("1");
                    } else {
                        $hotelRow.find(".child").attr("readonly", false);
                    }

                    // Check if any of the values are not empty
                    if (roomType || mealPlan || childCategory) {
                        getHotelActualPrice(hotel_id, roomType, mealPlan, childCategory, check_in, check_out, $hotelRow, rooms);

                    }
                });


                $(document).on('keyup', '.pax, .child, .check_in, .check_out,.rooms', function() {
                    var $hotelRow = $(this).closest('.hotel-row');
                    var roomType = $hotelRow.find('.room-type').val();
                    var mealPlan = $hotelRow.find('.meal-plan').val();
                    var childCategory = $hotelRow.find('.child-category').val();
                    var hotel_id = $hotelRow.find('.hotel-select').val();
                    // var no_pax = $hotelRow.find('.pax').val();
                    // var no_child = $hotelRow.find('.child').val();
                    var check_in = $hotelRow.find('.checkin').val();
                    var check_out = $hotelRow.find('.checkout').val();
                    var rooms = $hotelRow.find('.rooms').val();
                    if (no_pax == "") {
                        no_pax = 0;
                    }
                    if (no_child == "") {
                        no_child = 0;
                    }

                    getHotelActualPrice(hotel_id, roomType, mealPlan, childCategory, check_in, check_out, $hotelRow, rooms);
                });
            });
        </script>


        <script>
            $(document).ready(function() {
                //calculate total
                $('body').on('input change', 'input, select', function() {
                    calculateTotals();
                    console.log('exe');
                });
                // Function to add new hotel row
                $('.add-hotel-btn').click(function(e) {
                    e.preventDefault();
                    var newHotelRow = $('.hotel-row').first().clone();
                    newHotelRow.find('.child').attr("readonly", true);
                    newHotelRow.find('.child').val("1");
                    newHotelRow.find('.pax').val("1");
                    newHotelRow.find('select').val('');
                    newHotelRow.find('.hotel-cost').val('');
                    newHotelRow.find('.checkin').val('');
                    newHotelRow.find('.checkout').val('');
                    newHotelRow.find('.customer_price').val('');
                    newHotelRow.appendTo('.hotel-body');
                    reinitializeDatepicker();
                    checkRemoveButtons();
                });

                // Function to remove hotel row
                $(document).on('click', '.remove-hotel-btn', function(e) {
                    e.preventDefault();
                    if ($('.hotel-row').length > 1) {
                        $(this).closest('.hotel-row').remove();
                    }
                    calculateTotals();
                    checkRemoveButtons();
                });

                // Function to add new cab row
                $('.add-cab-btn').click(function(e) {
                    e.preventDefault();
                    var newCabRow = $('.cab-row').first().clone();
                    newCabRow.find('input').val('');
                    newCabRow.find('select').val('');
                    newCabRow.appendTo('.cab-body');
                    reinitializeDatepicker();
                    checkRemoveButtons();
                });

                // Function to remove cab row
                $(document).on('click', '.remove-cab-btn', function(e) {
                    e.preventDefault();
                    if ($('.cab-row').length > 1) {
                        $(this).closest('.cab-row').remove();
                    }
                    calculateTotals();
                    checkRemoveButtons();
                });

                // Function to add new addon row
                $('.add-addon-btn').click(function(e) {
                    e.preventDefault();
                    var newAddonRow = $('.addon-row').first().clone();
                    newAddonRow.find('input').val('');
                    newAddonRow.appendTo('.addon-body');
                    reinitializeDatepicker();
                    checkRemoveButtons();
                });

                // Function to remove addon row
                $(document).on('click', '.remove-addon-btn', function(e) {
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
                        $(this).datepicker({
                            dateFormat: 'dd/mm/yy'
                        });
                    });
                }


                $(document).on('input', 'input[name="hotel_customer_price[]"], input[name="cab_customer_price[]"], input[name="addon_customer_price[]"]', function() {
                    calculateTotals();
                });

                // Initial check for remove buttons
                checkRemoveButtons();

                // Initialize datepicker for the first time
                reinitializeDatepicker();
                calculateTotals();
            });
        </script>
        <!------------------------------------- cab terrif -------------------------------->
        <script>
            $('body').on('change', '.num_of_cab', function() {
                var num_of_cab = $(this);
                var cab_body = num_of_cab.closest('.cab-row');
                cab = cab_body.find('.cabs');
                cab_val = cab.val();
                if ($.trim(cab_val) == '') {
                    alert('please select cab first');
                } else {
                    get_cab_price(cab)
                }
            });



            $('body').on('change', '.cabs', function() {
                var cab = $(this);
                get_cab_price(cab)
            });
            $('body').on('change', '.cab_date', function() {
                var cab_date = $(this);
                var cab_body = cab_date.closest('.cab-row');
                cab = cab_body.find('.cabs');
                cab_val = cab.val();
                if ($.trim(cab_val) == '') {
                    alert('please select cab first');
                } else {
                    get_cab_price(cab)
                }
            });

            function get_cab_price(cab) {
                cab_value = cab.val();
                var cab_body = cab.closest('.cab-row');
                cab_date = cab_body.find('.cab_date');
                cab_cost = cab_body.find('.cab_cost');
                num_of_cab = cab_body.find('.num_of_cab');
                cab_date = cab_date.val();
                nos = num_of_cab.val();

                $.ajax({
                    url: 'includes/ajax.php',
                    type: 'POST',
                    data: {
                        cab_id: cab_value,
                        cab_date: cab_date,
                        nos: nos,
                        get_cab_price: true
                    },
                    success: function(response) {
                        // Handle the successful response here
                        console.log(response)
                        cab_cost.val(response);

                    },
                    error: function(xhr, status, error) {
                        // Handle any errors here
                        console.log('error')
                        console.error('AJAX request failed:', status, error);
                    }
                });
            }
        </script>
</body>

</html>