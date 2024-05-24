<?php
    include 'includes/db_config.php';
    $thisPageTitle = 'ADDON';
    $action = "ADD";

    if(isset($_REQUEST['draw'])){
        # Read value
        $draw            = $_POST['draw'];
        $start           = $_POST['start'];
        $data            = array();
        $rowperpage      = $_POST['length']; // Rows display per page
        $columnIndex     = $_POST['order'][0]['column']; // Column index
        $columnName      = $_POST['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
        $searchValue     = mysqli_real_escape_string($mysqli, $_POST['search']['value']); // Search value

        $di_sql = "SELECT * FROM `tbl_addon` WHERE `is_deleted`=0";

        ## Search
        $searchQuery = " ";
        if($searchValue != ''){
          $di_sql .= " AND (`addon_name` LIKE '%" . $searchValue . "%')";
        }

        $query        = $mysqli->query($di_sql);
        $totalRecords = $totalRecordwithFilter = $query->num_rows;

        ## Fetch records
        $diQuery   = $di_sql . " ORDER BY `id` DESC LIMIT " . $start . "," . $rowperpage;
        $diRecords = mysqli_query($mysqli, $diQuery);

        $slno = 0;
        while($row = mysqli_fetch_assoc($diRecords)){
            $slno++;

            $row['action'] = '<div class="btn-group" role="group" aria-label="table Button">';

            $row['action'] .= '<a href="master-addon?e_id=' . $row['id'] . '" type="button" class="btn btn-sm btn-info btn-table" ><i class="fa fa-edit me-1"></i>Edit</a>';

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

    if(isset($_POST['submit'])){
        $id           = isset($_POST['id']) ? filtervar($mysqli, $_POST['id']) : '';
        $form_action  = filtervar($mysqli,$_POST['form_action']);
        $addon_name         = filtervar($mysqli,$_POST['addon_name']);
        $addon_ph        = filtervar($mysqli,$_POST['addon_ph']);
        $addon_email      = filtervar($mysqli,$_POST['addon_email']);
        $user_id=$_SESSION['login']['user_id'];
        $gen_date=input_date(date('d-m-Y'));

        $data     = "   `addon_name`       = '$addon_name',
                        `addon_ph`      = '$addon_ph',
                        `addon_email`    = '$addon_email',";

        if($form_action == 'ADD'){
        $data.="`created_by` = '$user_id',`created_at` = '$gen_date'";
            $query = "INSERT INTO `tbl_addon` SET $data";
            $id    = $mysqli->insert_id;
            $msg   = "Successfully Inserted";
        }elseif ($form_action == 'UPDATE'){
            $data.="`updated_by` = '$user_id',`updated_at` = '$gen_date'";
            $query = "UPDATE `tbl_addon` SET $data WHERE `id`='$id'";
            $msg   = "Successfully Updated";
        }

        if($mysqli->query($query)){
            $result = array('result' => true, 'redirect' => 'master-addon', 'dhSession' => ["success" => $msg]);
        }else{
            $result = array('result' => false, 'dhSession' => ["success" => "Sorry !! Try Again"]);
        }

        echo json_encode($result);
        exit;
    }

    //======================Delete======================
    if(isset($_REQUEST['delete']) && !empty($_REQUEST['id'])){
        $id           = filtervar($mysqli, $_REQUEST['id']);
        $update_query = $mysqli->query(" DELETE FROM `tbl_addon` WHERE `id`='$id' ");
        if($update_query){
            $result = array('result'=>true,'dhSession'=>["warning"=>"Deleted Successfully!!"]);
        }
        else{
            $result = array('result'=>false,'dhSession'=>["error"=>"Sorry !! Try Again"]);
        }
        echo json_encode($result);
        exit;
    }

    if(isset($_REQUEST['e_id'])){
        $id         = filtervar($mysqli, $_REQUEST['e_id']);
        $get_result = $mysqli->query("SELECT * FROM `tbl_addon` WHERE `id`='$id' ");
        if($get_result->num_rows){
            $row    = $get_result->fetch_assoc();
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
        <input type="hidden" name="id" value="<?php echo (isset($row['id'])&&!empty($row['id'])?$row['id']:'') ?>">
        <div class="col-md-4">
            <label for="">Addon Name</label>
            <input type="text" class="form-control " name="addon_name" id="addon_name" value="<?php echo (isset($row['addon_name']))?$row['addon_name']:'' ?>" placeholder="Name" required>
        </div> 
        <div class="col-md-4">
            <label for="">Addon Phone</label>
            <input type="text" name="addon_ph" id="addon_ph" class="form-control" placeholder="Addon Phone" value="<?php echo (isset($row['addon_ph']))?$row['addon_ph']:'' ?>">
        </div>
        <div class="col-md-4">
            <label for="">Addon Email</label>
            <input type="text" name="addon_email" id="addon_email" class="form-control" placeholder="Addon Email" value="<?php echo (isset($row['addon_email']))?$row['addon_email']:'' ?>">
        </div>
        <div class="col-md-6 pt-4  text-end">
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
        //--------------------------DATATABLE START--------------------------//
        $(document).ready(function (){
            var dataTable = $('#datatable').DataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'ajax': {
                'url': 'master-addon'
             },
            'order': [  [0, "desc"] ],
            'columns': [
                {
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
                    data: 'addon_name',
                    title: 'Name',
                    orderable: false,
                },
               
                {
                    data: 'addon_ph',
                    title: 'Phone',
                    orderable: false,
                },
                {
                    data: 'addon_email',
                    title: 'Email',
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

        function delete_row(id){
          $.dhConfirm({
            dhContent: "Are you sure to Delete ?",
            dhUrl: "master-addon?delete&id=" + id
          })
        }

        //-------------------------DATATABLE END------------------------------//

    </script>


</body>

</html>