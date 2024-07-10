<?php
header('Content-type: application/json');
include 'db_config.php';



if (isset($_POST['quotdelete']) && !empty($_POST['delId'])) {
    $delId =$_POST['delId'];
    $data = [];
    
        $sql_quot = "DELETE FROM `tbl_quotation` WHERE `id` = $delId";
        $query = $mysqli->query($sql_quot);

        $tables = array("tbl_voucher_hotel","tbl_voucher_cab","tbl_voucher_addon");

        if($query){
            foreach($tables as $table) {
                $voucher_sql = "DELETE FROM $table WHERE quotation_id=$delId";
                $voucher_query = $mysqli->query($voucher_sql);
            }
            if($voucher_query)
            {
                $result = array('result'=>true,'dhSession'=>["warning"=>"Deleted Successfully!!"]);
            } else {
                $result = array('result'=>false,'dhSession'=>["error"=>"Sorry !! Try Again"]);
            }
        }else{
            $result = array('result'=>false,'dhSession'=>["error"=>"Sorry !! Try Again"]);
        }
    

    echo json_encode($result);
}

?>