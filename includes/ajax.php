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

if(isset($_POST['getHotelActualPrice'])&&!empty($_POST['room_type'])&&!empty($_POST['hotel_id'])&&!empty($_POST['meal_plan'])&&!empty($_POST['child_category'])){
    $hotel_id=$_POST['hotel_id'];
    $type_id=    $_POST['room_type'];
    $meal_id=    $_POST['meal_plan'];
    $child_id=    $_POST['child_category'];
    $gendate=input_date(date('d-m-Y'));
    $sql="SELECT * FROM `master_hotel_tariff` WHERE `hotel_id`='$hotel_id' AND `type_id`='$type_id' AND `meal_id`='$meal_id' AND `child_id`='$child_id' AND ('$gendate' BETWEEN valid_from AND valid_to) LIMIT 1";
    $query=$mysqli->query($sql);
   echo $count=$query->num_rows;

   // $fetch=$query->fetch_assoc();
}


?>