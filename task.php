<?php
include 'includes/after_login.php';
$thisPageTitle = 'TASK';
$action = "ADD";

if (isset($_REQUEST['draw'])) {

    # Read value
    $draw = $_POST['draw'];
    $start = $_POST['start'];
    $data = array();
    $rowperpage = $_POST['length']; // Rows display per page
    $columnIndex = $_POST['order'][0]['column']; // Column index
    $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
    $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
    $searchValue = mysqli_real_escape_string($mysqli, $_POST['search']['value']); // Search value

    $di_sql = "SELECT * FROM `task` WHERE 1";

    if(admin_access($_SESSION['login']['user_id'])){
       
    }else{
        $user_id=$_SESSION['login']['user_id'];
        $di_sql .= " AND user_id='$user_id'";
    }
    
    ## Search
    $searchQuery = " ";
    if ($searchValue != '') {
      $di_sql .= " AND (`title` LIKE '%" . $searchValue . "%')";
    }

    $query = $mysqli->query($di_sql);
    $totalRecords = $totalRecordwithFilter = $query->num_rows;

    ## Fetch records
    $diQuery = $di_sql . " ORDER BY `id` DESC LIMIT " . $start . "," . $rowperpage;
    $diRecords = mysqli_query($mysqli, $diQuery);
    $slno = 0;
    while ($row = mysqli_fetch_assoc($diRecords)) {
        $slno++;

if($row['status']==1){
    $row['status']='<span class="badge bg-secondary">To Do</span>';
}else if($row['status']==2){
    $row['status']='<span class="badge bg-primary">In Process</span>';
}else if($row['status']==3){
    $row['status']='<span class="badge bg-success">Done</span>';
}
else if($row['status']==0){
    $row['status']='<span class="badge bg-secondary">No Status</span>';
}

$text = html_entity_decode(html_entity_decode($row['description']));
$words = explode(" ", $text);
if (count($words) > 10) {
    $first_10_words = implode(" ", array_slice($words, 0, 10));
    $row['description'] =$first_10_words . "...";
} else {
    $row['description']= $text;
}
        

        $row['user_id']=($row['user_id']!=0)?get_user_name($mysqli,$row['user_id']):'<span class="badge bg-danger">Not Assigned</span> ';
        $row['action'] = '<div class="btn-group" role="group" aria-label="table Button">';

       (admin_access($_SESSION['login']['user_id']))? $row['action'] .= '<a href="task-entry?e_id=' . $row['id'] . '" type="button" class="btn btn-sm btn-info btn-table" ><i class="fa fa-edit me-1"></i>Edit</a>':$row['action'] .= '<a href="task-view?e_id=' . $row['id'] . '" type="button" class="btn btn-sm btn-info btn-table" ><i class="fa fa-edit me-1"></i>View</a>';

      (admin_access($_SESSION['login']['user_id']))?  $row['action'] .= '<button type="button" class="btn btn-sm btn-danger btn-table" title="Delete Category" onclick="delete_row(' . $row['id'] . ')"><i class="fa fa-trash me-1"></i>Delete</button>':'';

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



//======================Delete======================
if(isset($_REQUEST['delete']) && !empty($_REQUEST['id'])){
    $id = filtervar($mysqli, $_REQUEST['id']);
    $update_query = $mysqli->query(" DELETE FROM `task` WHERE `id`='$id' ");
    if($update_query){
        $result= array('result'=>true,'dhSession'=>["warning"=>"Deleted Successfully!!"]);
    }
    else{
        $result= array('result'=>false,'dhSession'=>["error"=>"Sorry !! Try Again"]);
    }
    echo json_encode($result);
    exit;
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
$(document).ready(function () {
            var dataTable = $('#datatable').DataTable({
                
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'ajax': {
                    'url': 'task'
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
                        data: 'title',
                        title: 'Task Title',
                        orderable: false,
                    },
                    {
                        data: 'description',
                        title: 'Task Description',
                        orderable: false,
                    },
                    {
                        data: 'status',
                        title: 'Task Status',
                        orderable: false,
                    },
                    {
                        data: 'user_id',
                        title: 'Employee',
                        orderable: false,
                    },
                    {
                        data: 'due_date',
                        title: 'Last Date',
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
                dhUrl: "task?delete&id=" + id
            })
        }

//-------------------------DATATABLE END------------------------------//


</script>


</body>

</html>