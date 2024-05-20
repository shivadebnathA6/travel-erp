<?php
    include 'includes/db_config.php';
    $thisPageTitle = 'LEADS';
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

        $di_sql = "SELECT * FROM `tbl_guest` WHERE `is_deleted`=0";

        ## Search
        $searchQuery = " ";
        if($searchValue != ''){
          $di_sql .= " AND (`guest_name` LIKE '%" . $searchValue . "%')";
        }

        $query        = $mysqli->query($di_sql);
        $totalRecords = $totalRecordwithFilter = $query->num_rows;

        ## Fetch records
        $diQuery   = $di_sql . " ORDER BY `id` DESC LIMIT " . $start . "," . $rowperpage;
        $diRecords = mysqli_query($mysqli, $diQuery);

        $slno = 0;
        while($row = mysqli_fetch_assoc($diRecords)){
            $slno++;
//             <div class="dropdown">
//   <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
//     Dropdown button
//   </button>
//   <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
//     <li><a class="dropdown-item" href="#">Action</a></li>
//     <li><a class="dropdown-item" href="#">Another action</a></li>
//     <li><a class="dropdown-item" href="#">Something else here</a></li>
//   </ul>
// </div>
            $row['action'] = '<div class="dropdown">
               <div class="form-select"  id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                 action
               </div>
               <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">';
            $row['action'].='<li><a class="dropdown-item" href="quotation-add">Add Quotation</a></li>';
            $row['action'].='<li><a class="dropdown-item" href="#">edit Quotation</a></li>';
            $row['action'].='<li><a class="dropdown-item" href="#">View Quotation</a></li>';

            $row['action'] .= '<li><a href="employee?e_id=' . $row['id'] . '" type="button" class="dropdown-item" >Edit</a></li>';

            $row['action'] .= '<li><button type="button" class="dropdown-item" title="Delete Category" onclick="delete_row(' . $row['id'] . ')">Delete</button></li>';
            $row['action'] .='</ul>
             </div>';

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
        $id           = filtervar($mysqli, $_REQUEST['id']);
        $update_query = $mysqli->query("UPDATE `tbl_guest` SET `is_deleted`=1 WHERE `id`='$id'");
        if($update_query){
            $result = array('result'=>true,'dhSession'=>["warning"=>"Deleted Successfully!!"]);
        }
        else{
            $result = array('result'=>false,'dhSession'=>["error"=>"Sorry !! Try Again"]);
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

    <table id="datatable" class="table table-striped table-bordered"></table>
    
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
                'url': 'lead-list'
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
                    data: 'guest_name',
                    title: 'Name',
                    orderable: false,
                },
                {
                    data: 'guest_phone',
                    title: 'Phone',
                    orderable: false,
                },
                {
                    data: 'altphone',
                    title: 'Alt. Phone',
                    orderable: false,
                },
                {
                    data: 'email',
                    title: 'Email',
                    orderable: false,
                },
                {
                    data: 'country',
                    title: 'Country',
                    orderable: false,
                },
                {
                    data: 'address',
                    title: 'Address',
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
            dhUrl: "guest-list?delete&id=" + id
          })
        }

        //-------------------------DATATABLE END------------------------------//

    </script>


</body>

</html>