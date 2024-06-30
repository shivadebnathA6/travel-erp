<?php
include 'includes/db_config.php';
$thisPageTitle = 'TERIFF';
$action = "ADD";

if (isset($_REQUEST['draw'])) {
    # Read value
    $draw            = $_POST['draw'];
    $start           = $_POST['start'];
    $data            = array();
    $rowperpage      = $_POST['length']; // Rows display per page
    $columnIndex     = $_POST['order'][0]['column']; // Column index
    $columnName      = $_POST['columns'][$columnIndex]['data']; // Column name
    $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
    $searchValue     = mysqli_real_escape_string($mysqli, $_POST['search']['value']); // Search value

    $di_sql = "SELECT * FROM `master_hotel_tariff` WHERE `is_deleted`=0";

    ## Search
    $searchQuery = " ";
    if ($searchValue != '') {
        $di_sql .= " AND (`hotel_name` LIKE '%" . $searchValue . "%')";
    }

    $query        = $mysqli->query($di_sql);
    $totalRecords = $totalRecordwithFilter = $query->num_rows;

    ## Fetch records
    $diQuery   = $di_sql . " ORDER BY `id` DESC LIMIT " . $start . "," . $rowperpage;
    $diRecords = mysqli_query($mysqli, $diQuery);

    $slno = 0;
    while ($row = mysqli_fetch_assoc($diRecords)) {
        $slno++;
        $row['hotel_name']=getHotelName($row['hotel_id']);
        $row['meal_plan']=getMealPlan($row['meal_id']);
        $row['room_type']=getRoomType($row['type_id']);
        $row['child_type']=getChildType($row['child_id']);

        $row['action'] = '<div class="btn-group" role="group" aria-label="table Button">';

        $row['action'] .= '<a href="master-hotel-tariff?e_id=' . $row['id'] . '" type="button" class="btn btn-sm btn-info btn-table" ><i class="fa fa-edit me-1"></i>Edit</a>';

        $row['action'] .= '<button type="button" class="btn btn-sm btn-danger btn-table" title="Delete Category" onclick="delete_row(' . $row['id'] . ')"><i class="fa fa-trash me-1"></i>Delete</button>';

        $row['action'] .= '</div>';

        $row['slno'] = $start + $slno;
        $data[] = $row;
    }

    ## Response
    $response = array(
        "draw" => intval($draw),
        "iTotalRecords" => $totalRecords,
        "iTotalDisplayRecords" => $totalRecordwithFilter,
        "aaData" => $data
    );

    echo json_encode($response);
    exit;
}

if (isset($_POST['submit'])) {
    $id           = isset($_POST['id']) ? filtervar($mysqli, $_POST['id']) : '';
    $form_action  = filtervar($mysqli, $_POST['form_action']);
    $hotel_id=filtervar($mysqli,$_POST['hotel_id']);
    $valid_from=input_date(filtervar($mysqli,$_POST['valid_from']));
$valid_to=input_date(filtervar($mysqli,$_POST['valid_to']));
$type_idArr=$_POST['type_id'];
$meal_idArr=$_POST['meal_id'];
    $child_idArr=$_POST['child_id'];
    $rateArr=$_POST['rate'];
    $user_id = $_SESSION['login']['user_id'];
    $gen_date = input_date(date('d-m-Y'));
    $arrcount= count($type_idArr);
    for($i=0;$i<$arrcount;$i++){
        $type_id= filtervar($mysqli,$type_idArr[$i]);
        $meal_id= filtervar($mysqli,$meal_idArr[$i]);
        $child_id= filtervar($mysqli,$child_idArr[$i]);
        $rate= filtervar($mysqli,$rateArr[$i]);
        
        $data     = "   `hotel_id`       = '$hotel_id',
        `type_id`      = '$type_id',
        `child_id`    = '$child_id',
        `rate`    = '$rate',
        `valid_from`    = '$valid_from',
        `valid_to`    = '$valid_to',
        `meal_id`    = '$meal_id',";
        if ($form_action == 'ADD') {
            $data .= "`created_by` = '$user_id',`created_at` = '$gen_date'";
            $query = "INSERT INTO `master_hotel_tariff` SET $data";
            $id    = $mysqli->insert_id;
            $msg   = "Successfully Inserted";
            $mysqli->query($query);
        }

    }
    $result = array('result' => true, 'redirect' => 'master-hotel-tariff', 'dhSession' => ["success" => $msg]);
    
   

    // if ($form_action == 'ADD') {
    //     $data .= "`created_by` = '$user_id',`created_at` = '$gen_date'";
    //     $query = "INSERT INTO `master_hotel_tariff` SET $data";
    //     $id    = $mysqli->insert_id;
    //     $msg   = "Successfully Inserted";
    // } elseif ($form_action == 'UPDATE') {
    //     $data .= "`updated_by` = '$user_id',`updated_at` = '$gen_date'";
    //     $query = "UPDATE `master_hotel_tariff` SET $data WHERE `id`='$id'";
    //     $msg   = "Successfully Updated";
    // }

    // if ($mysqli->query($query)) {
    //     $result = array('result' => true, 'redirect' => 'master-hotel-tariff', 'dhSession' => ["success" => $msg]);
    // } else {
    //     $result = array('result' => false, 'dhSession' => ["success" => "Sorry !! Try Again"]);
    // }

    echo json_encode($result);
    exit;
}

//======================Delete======================
if (isset($_REQUEST['delete']) && !empty($_REQUEST['id'])) {
    $id           = filtervar($mysqli, $_REQUEST['id']);
    $update_query = $mysqli->query("UPDATE `master_hotel_tariff` SET `is_deleted`=1 WHERE `id`='$id'");
    if ($update_query) {
        $result = array('result' => true, 'dhSession' => ["warning" => "Deleted Successfully!!"]);
    } else {
        $result = array('result' => false, 'dhSession' => ["error" => "Sorry !! Try Again"]);
    }
    echo json_encode($result);
    exit;
}

if (isset($_REQUEST['e_id'])) {
    $id         = filtervar($mysqli, $_REQUEST['e_id']);
    $get_result = $mysqli->query("SELECT * FROM `master_hotel_tariff` WHERE `id`='$id' ");
    if ($get_result->num_rows) {
        $row    = $get_result->fetch_assoc();
        $action = "UPDATE";
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
            <form class="dhForm" method="post" autocomplete="off">
                <div class="row g-3">

                    <input type="hidden" name="form_action" id="form_action" value="<?php echo $action ?>">
                    <input type="hidden" name="id" value="<?php echo (isset($row['id']) && !empty($row['id']) ? $row['id'] : '') ?>">
                    <div class="col-md-4">
                        <label for="">Hotel</label>
                        <select name="hotel_id" id="hotel_id" class="form-select" required>
                            <option value="">Select Hotel</option>
                            <?php
                            $field_query = $mysqli->query("SELECT * FROM `tbl_hotel` WHERE `is_deleted`=0");
                            while ($field_fetch = $field_query->fetch_assoc()) {
                            ?>
                                <option value="<?php echo $field_fetch['id'] ?>" data-ho><?php echo $field_fetch['hotel_name']  ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-8">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="">Valid From</label>
                                <input type="text" class="form-control start_date" name="valid_from" id="valid_from" readonly placeholder="Enter Date" required>
                            </div>
                            <div class="col-md-6">
                                <label for="">Valid To</label>
                                <input type="text" class="form-control end_date" name="valid_to" id="valid_to" readonly placeholder="Enter Date" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 t_container" id="t_container">
                        <div class="row t_content pt-4" id="t_content">
                            <div class="col-md-3">
                                <select name="type_id[]" id="type_id" class="form-select" required>
                                    <option value="">Select Room Type</option>
                                    <?php
                                    $field_query = $mysqli->query("SELECT * FROM `tbl_master_rooms` WHERE `is_deleted`=0");
                                    while ($field_fetch = $field_query->fetch_assoc()) {
                                    ?>
                                        <option value="<?php echo $field_fetch['id'] ?>" data-ho><?php echo $field_fetch['room_type']  ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="meal_id[]" id="meal_id" class="form-select" required>
                                    <option value="">Select Meal Plan</option>
                                    <?php
                                    $field_query = $mysqli->query("SELECT * FROM `tbl_master_meals` WHERE `is_deleted`=0");
                                    while ($field_fetch = $field_query->fetch_assoc()) {
                                    ?>
                                        <option value="<?php echo $field_fetch['id'] ?>" data-ho><?php echo $field_fetch['meal_plan']  ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="child_id[]" id="child_id" class="form-select">
                                    <option value="">Select Child category</option>
                                    <?php
                                    $field_query = $mysqli->query("SELECT * FROM `tbl_master_child` WHERE `is_deleted`=0");
                                    while ($field_fetch = $field_query->fetch_assoc()) {
                                    ?>
                                        <option value="<?php echo $field_fetch['id'] ?>" data-ho><?php echo $field_fetch['category_type']  ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control" placeholder="RATE" name="rate[]" id="rate" required>
                            </div>
                            <div class="col-md-1 text-end">
                                <button type="button" class="btn btn-sm btn-primary w-50 add_t"><i class="fa fa-plus"></i></button>
                                <button type="button" class="btn btn-sm btn-danger w-50 remove_t" style="display:none;"><i class="fa fa-trash"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 pt-4 text-center">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle me-2"></i>SUBMIT DETAILS</button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>

                    <!-- form proparty end -->
                    <!-- table property Start -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>LIST <?php echo $thisPageTitle ?></h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="datatable" class="table table-striped table-bordered"></table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                </div> <!-- container-fluid -->
            </div>
        </div>

        <?php include_once 'includes/footer.php' ?>
        <script src="assets/libs/jquery-ui/jquery-ui.js"></script>
        <script src="assets/libs/datatables/dataTables.min.js"></script>
        <script src="assets/libs/datatables/dataTables.bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
    // Function to add a new row
    $('body').on('click', '.add_t', function() {
      
        var newRow = $('#t_content').clone().removeAttr('id');
        
        // Reset the values of the new row's inputs
        newRow.find('select').val('');
        newRow.find('input').val('');
        // Show the remove button in the new row
        newRow.find('.remove_t').show();
        newRow.find('.add_t').hide();
        newRow.find('.t_content').addClass("pt-4");
        console.log(newRow.html());
        
        // Append the new row to the container
        $('#t_container').append(newRow);
    });

    // Function to remove a row
    $('body').on('click', '.remove_t', function() {
        $(this).closest('.t_content').remove();
    });
});

</script>
        <script>
            //--------------------------DATATABLE START--------------------------//
            $(document).ready(function() {
                var dataTable = $('#datatable').DataTable({
                    'processing': true,
                    'serverSide': true,
                    'serverMethod': 'post',
                    'ajax': {
                        'url': 'master-hotel-tariff'
                    },
                    'order': [
                        [0, "desc"]
                    ],
                    'columns': [{
                            data: 'id',
                            title: 'ID',
                            orderable: false,
                            visible: false,
                        },
                        {
                            data: 'slno',
                            title: 'Sl.No',
                            orderable: false,
                        },
                        {
                            data: 'hotel_name',
                            title: 'Hotel Name',
                            orderable: false,
                        },

                        {
                            data: 'meal_plan',
                            title: 'Meal Plan',
                            orderable: false,
                        },
                        {
                            data: 'room_type',
                            title: 'Room Type',
                            orderable: false,
                        },
                        {
                            data: 'child_type',
                            title: 'Child Type',
                            orderable: false,
                        },
                        {
                            data: 'valid_from',
                            title: 'Valid From',
                            orderable: false,
                        },
                        {
                            data: 'valid_to',
                            title: 'Valid To',
                            orderable: false,
                        },
                        {
                            data: 'rate',
                            title: 'Rate',
                            orderable: false,
                        },

                        {
                            data: 'action',
                            title: 'Action',
                            orderable: false,
                            width: '5%',
                        }
                    ]
                });
            });

            function delete_row(id) {
                $.dhConfirm({
                    dhContent: "Are you sure to Delete ?",
                    dhUrl: "master-hotel-tariff?delete&id=" + id
                })
            }

            //-------------------------DATATABLE END------------------------------//
        </script>


</body>

</html>