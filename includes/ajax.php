<?php
include 'db_config.php';



if (isset($_POST['gethotelterrifquot']) && !empty($_POST['hotel_id'])) {
    $hotel_id =$_POST['hotel_id'];
    $options = [
        'room_type' => '<option value="">Select Room Type</option>',
        'meal_plan' => '<option value="">Select Meal Plan</option>',
        'child_category' => '<option value="">Select Child Category</option>'
    ];
    $queries = [
        'room_type' => "SELECT DISTINCT rt.id AS id, rt.room_type AS type 
                        FROM master_hotel_tariff mht
                        INNER JOIN tbl_master_rooms rt ON mht.type_id = rt.id WHERE mht.hotel_id='$hotel_id'",
        'meal_plan' => "SELECT DISTINCT mt.id AS id, mt.meal_plan AS type 
                        FROM master_hotel_tariff mht
                        INNER JOIN tbl_master_meals mt ON mht.meal_id = mt.id WHERE mht.hotel_id='$hotel_id'",
        'child_category' => "SELECT DISTINCT tc.id AS id, tc.category_type AS type 
                             FROM master_hotel_tariff mht
                             INNER JOIN tbl_master_child tc ON mht.child_id = tc.id WHERE mht.hotel_id='$hotel_id'"
    ];

    foreach ($queries as $key => $sql) {
        $query = $mysqli->query($sql);
        while ($row = $query->fetch_assoc()) {
            $options[$key] .= '<option value="' . $row["id"] . '">' . $row["type"] . '</option>';
        }
    }

    echo json_encode($options);
}

if(isset($_POST['getHotelActualPrice'])&&isset($_POST['room_type'])&&isset($_POST['hotel_id'])&&isset($_POST['meal_plan'])){
    $hotel_id=$_POST['hotel_id'];
    $type_id=    $_POST['room_type'];
    $meal_id=    $_POST['meal_plan'];
    $child_id=   '';
    $check_in = (!empty($_POST['check_in']))?input_date($_POST['check_in']):'';
    $check_out = (!empty($_POST['check_out']))?input_date($_POST['check_out']):'';
    $price=0;
//calculating day diff
$day_difference=false;
if(!empty($check_in)&&!empty($check_out)){
    $checkin = new DateTime($check_in);
    $checkout = new DateTime($check_out);
    $interval = $checkin->diff($checkout);
    $day_difference = $interval->days;
    if($day_difference<1){
        $day_difference=1;
    }
}


$sql="SELECT * FROM `master_hotel_tariff` WHERE `hotel_id`='$hotel_id' ";
if(!empty($type_id)){
    $sql.= "AND `type_id`='$type_id'  ";
}
if(!empty($meal_id)){
    $sql.= "AND `meal_id`='$meal_id' ";
}
if(!empty($check_in)&&!empty($check_out)){
    $sql.="AND (valid_from <= '$check_out'
  AND valid_to >= '$check_in')";
}
$sql.=" AND child_id='' ORDER BY rate DESC LIMIT 1";

$query=$mysqli->query($sql);
$count=$query->num_rows;
if($count>0){
    $fetch=$query->fetch_array();
    $price=$fetch['rate'];
}else{
    $price=0;
    
}
if(!empty($_POST['rooms'])){
    $rooms=$_POST['rooms'];
    $price=$rooms*$price;
}
if($day_difference!=false){
    
    $price=$day_difference*$price;
}

echo $price;
    
    //$gendate=input_date(date('d-m-Y'));
    //$sql="SELECT * FROM `master_hotel_tariff` WHERE `hotel_id`='$hotel_id' AND `type_id`='$type_id' AND `meal_id`='$meal_id' AND ('$gendate' BETWEEN valid_from AND valid_to) ";

    // if($check_in == ""){
    //     $check_in = date('Y/m/d');
    // }
    // if($check_out == ""){
    //     $check_out = date('Y/m/d', strtotime("+1 day"));
    // }
    // if($check_in == $check_out)
    // {
    //     $check_out = date('Y/m/d', strtotime("+1 day", strtotime($check_out)));
    // }
    // $date1=date_create($check_in);
    // $date2=date_create($check_out);
    // $diff=date_diff($date1,$date2);
    // $total_days = $diff->format("%a");

    // if(empty($child_id)){


        // $query=$mysqli->query($sql);
        // if($query->num_rows >0){
        //     $fetch=$query->fetch_assoc();
        
        //     echo ($fetch['rate']*$no_pax)*$total_days;
        // }else{
        //     echo 0;
        // }


    // }else{
    //     $sql_c="SELECT * FROM `master_hotel_tariff` WHERE `hotel_id`='$hotel_id' AND `type_id`='$type_id' AND `meal_id`='$meal_id' AND `child_id`='$child_id' ";

    //     $sql_nc="SELECT * FROM `master_hotel_tariff` WHERE `hotel_id`='$hotel_id' AND `type_id`='$type_id' AND `meal_id`='$meal_id' AND `child_id`='' ";

    //     $query1=$mysqli->query($sql_c);
    //     $query2=$mysqli->query($sql_nc);

    //     if($query1->num_rows >0 && $query2->num_rows >0){
    //         $child_data=$query1->fetch_assoc();
    //         $nochild_data=$query2->fetch_assoc();

    //         $total_child = $child_data['rate']*$no_child;
    //         $total_nochild = $nochild_data['rate']*$no_pax;
    //         echo ($total_child+$total_nochild)*$total_days;
    //     }else{
    //         echo 0;
    //     }
    // }
   
    
}

if(isset($_POST['get_cab_price'])&&isset($_POST['cab_id'])&&isset($_POST['cab_date'])){
    $cab_id=$_POST['cab_id'];
    $cab_date=$_POST['cab_date'];
    $price=0;
    $sql="SELECT * FROM `master_cab_tariff` WHERE cab_id='$cab_id' ";
    if(!empty($cab_date)){
        $cab_date=input_date($cab_date);
        $sql.="AND ('$cab_date' BETWEEN valid_from AND valid_to) ";
    }
    $query=$mysqli->query($sql);
    $count=$query->num_rows;
    if($count>0){
        $fetch=$query->fetch_array();
        $price=$fetch['rate'];
    }else{
        $price=0;
        
    }

    if(isset($_POST['nos'])&&!empty($_POST['nos'])){
        $nos=$_POST['nos'];
        $price=$price*$nos;
    }
    echo $price;

}


?>