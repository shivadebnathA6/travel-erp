<?php
    include 'includes/db_config.php';

$form_action=$_POST['form_action'];
$id=$_POST['form_action'];
 $guest_id=$_POST['guest_id'];

$lead_id=$_POST['lead_id'];

$user_id=$_SESSION['login']['user_id'];
$gen_date=input_date(date('d-m-Y'));
// hotels array row
$hotels=$_POST['hotel'];
$checkins=$_POST['checkin'];
$checkouts=$_POST['checkout'];
// $places=$_POST['place'];
$roomss=$_POST['rooms'];
$hotel_costs=$_POST['hotel_cost'];
$hotel_customer_price=$_POST['hotel_customer_price'];
// hotels array row end

//cab array row
$cab=$_POST['cab'];
$cab_date=$_POST['cab_date'];
$cab_from=$_POST['cab_from'];
$cab_to=$_POST['cab_to'];
$num_of_cab=$_POST['num_of_cab'];
$passenger=$_POST['passenger'];
$cab_cost=$_POST['cab_cost'];
$cab_customer_price=$_POST['cab_customer_price'];
// cab array row end

//addon array row
$addon=$_POST['addon'];
$addon_date=$_POST['addon_date'];
$num_of_addon=$_POST['num_of_addon'];
$addon_cost=$_POST['addon_cost'];
$addon_customer_price=$_POST['addon_customer_price'];
// addon array row end

// totals part
$hotel_total=$_POST['hotel_total'];
$cab_total=$_POST['cab_total'];
$addon_total=$_POST['addon_total'];
$grand_total=$_POST['grand_total'];
$pack_total=$_POST['pack_total'];
//totals part end

// data for quotation
$data="`guest_id`='$guest_id',
        `lead_id`='$lead_id',
        `hotel_total`='$hotel_total',
        `cab_total`='$cab_total',
        `addon_total`='$addon_total',
        `grand_total`='$grand_total',
        `pack_total`='$pack_total',
";




if($form_action== 'ADD'){
    //insert querys
    $data.="`created_by` = '$user_id',`created_at` = '$gen_date'";
    $query =$mysqli->query("INSERT INTO `tbl_quotation` SET $data");
    $quotation_id=$mysqli->insert_id;
    
for($h=0; $h <count($hotels); $h++){
    $checkins[$h]=input_date($checkins[$h]);
    $checkouts[$h]=input_date($checkouts[$h]);
    $tbl_hotel_voucher="`hotel_id`= '$hotels[$h]',
    `quotation_id`= '$quotation_id',
    `checkin`= '$checkins[$h]',
    `checkout`= '$checkouts[$h]',
    `rooms`= '$roomss[$h]',
    `cost`='$hotel_costs[$h]',
    `customer_price`='$hotel_customer_price[$h]', ";
    $tbl_hotel_voucher.="`created_by` = '$user_id',`created_at` = '$gen_date'";
    $tbl_hotel_voucher_query = $mysqli->query("INSERT INTO `tbl_voucher_hotel` SET $tbl_hotel_voucher");
    
}
for($i= 0; $i <count($cab); $i++){
    $cab_date[$i]=input_date($cab_date[$i]);
 $tbl_voucher_cab="`cab_id`='$cab[$i]',
 `quotation_id`='$quotation_id',
 `date`='$cab_date[$i]',
 `from`='$cab_from[$i]',
 `to`='$cab_to[$i]',
 `no_cab`='$num_of_cab[$i]',
 `pax`='$passenger[$i]',
 `cost`='$cab_cost[$i]',
  `customer_price`='$cab_customer_price[$i]', ";
 $tbl_voucher_cab.="`created_by` = '$user_id',`created_at` = '$gen_date'";
 $tbl_cab_voucher_query = $mysqli->query("INSERT INTO `tbl_voucher_cab` SET $tbl_voucher_cab");

}

for($a= 0; $a <count($addon); $a++){
$addon_date[$a]=input_date($addon_date[$a]);
$tbl_voucher_addon="`addon_id`='$addon[$a]',
    `quotation_id`='$quotation_id',
    `date`='$addon_date[$a]',
    `no_addon`='$num_of_addon[$a]',
    `cost`='$addon_cost[$a]',
    `customer_price`='$addon_customer_price[$a]', ";
    $tbl_voucher_addon.="`created_by` = '$user_id',`created_at` = '$gen_date'";
    $tbl_addon_voucher_query = $mysqli->query("INSERT INTO `tbl_voucher_addon` SET $tbl_voucher_addon");
}
//$result = array('result' => true, 'redirect' => 'master-cab', 'dhSession' => ["success" => "Quotation Add Success"]);
header("location:lead-list");

}else if($form_action== 'UPDATE'){
//update querys



}