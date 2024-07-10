<?php
header('Content-type: application/json');
include 'db_config.php';



if (isset($_POST['quotdetails']) && !empty($_POST['delId'])) {
    $delId =$_POST['delId'];
    $data = [];
    
        $sql = "SELECT * FROM `tbl_quotation` WHERE `id` = $delId";
        $query = $mysqli->query($sql);
        if($query->num_rows >0){
            while ($row = $query->fetch_assoc()) {
                $data['quotId'] = $row['id'];
	$mysqli = mysqli_connect('localhost','root','', 'travel_crm');
                $data['gestId'] = get_guest_name($mysqli,$row['guest_id']);
                $data['hotelTotal'] = $row['hotel_total'];
                $data['cabTotal'] = $row['cab_total'];
                $data['addonTotal'] = $row['addon_total'];
                $data['grandTotal'] = $row['grand_total'];
            }
        } else{
            $data['quotId'] = "";
            $data['gestId'] = "";
            $data['hotelTotal'] = "";
            $data['cabTotal'] = "";
            $data['addonTotal'] = "";
            $data['grandTotal'] = "";
        }
    

    echo json_encode($data);
}

?>