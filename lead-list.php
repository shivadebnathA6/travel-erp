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

        $di_sql = "SELECT * FROM `tbl_leads` WHERE `is_deleted`=0";

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
            $quot=checkQuot($row['id']);
            (checkQuot($row['id']))?$row['lead_id']='<p class="text-success">LEAD-'.$row['id'].'</p>':$row['lead_id']='LEAD-'.$row['id'];
            $quotation=checkQuot($row['id']);
            $row['guest_name']=getGuestName($row['guest_id']);
            $row['pax']='';
            if(!empty($row['male_pax'])){
                $row['pax'].="Male ".$row['male_pax'];
            }
            if(!empty($row['female_pax'])){
                $row['pax'].=" Female ".$row['female_pax'];
            }
            if(!empty($row['child_pax'])){
                $row['pax'].=" Child ".$row['child_pax'];
            }
            if(!empty($row['infant_pax'])){
                $row['pax'].=" Infant ".$row['infant_pax'];
            }
            $row['location']=getLocationName($row['loc_id']);
           
            $row['action'] = '<div class="dropdown">
               <div class="form-select"  id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                 action
               </div>
               <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">';
           (checkQuot($row['id']))?'': $row['action'].='<li><a class="dropdown-item" href="quotation-add?lead_id='.$row['id'].'">Add Quotation</a></li>';
           (checkQuot($row['id']))?$row['action'].='<li><a class="dropdown-item remove-quot-btn" data-bs-toggle="modal" data-bs-target="#del_quot_modal" data-id="'.$quotation['id'].'" href="javascript:void();">Delete Quotation</a></li>':'';
           (checkQuot($row['id']))?$row['action'].='<li><a class="dropdown-item" href="quotation-view?q_id='.$quot['id'].'">View Quotation</a></li>':'';

            $row['action'] .= '<li><a href="leads-entry?e_id=' . $row['id'] . '" type="button" class="dropdown-item" >Edit</a></li>';

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
        $update_query = $mysqli->query("UPDATE `tbl_leads` SET `is_deleted`=1 WHERE `id`='$id'");
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
    <style>
        hr.new1{
            border-top: 2px dashed #fff;
            margin: 0.4rem 0;
        }
        .theme-color {
            color: #004cb9;
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

    <!-- Quotation Delete Modal -->
    <div class="modal" id="del_quot_modal">
    <div class="modal-dialog">
        <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
            <h4 class="modal-title">Are you sure?</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
            <div class="px-4 py-1">
                <div class="d-flex justify-content-between">
                    <span class="font-weight-bold">Quotation ID:</span>
                    <span class="text-muted" id="qid">#</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="font-weight-bold">Guest Name:</span>
                    <span class="text-muted" id="gname"></span>
                </div>
                <span class="theme-color">Quotation Summary</span>
                <div class="mb-3">
                    <hr class="new1">
                </div>
                <div class="d-flex justify-content-between">
                    <span class="font-weight-bold">Hotel Total:</span>
                    <span class="text-muted" id="htotal">0</span>
                </div>  
                <div class="d-flex justify-content-between">
                    <span class="font-weight-bold">Cab Total:</span>
                    <span class="text-muted" id="ctotal">0</span>
                </div> 
                <div class="d-flex justify-content-between">
                    <span class="font-weight-bold">Addon Total:</span>
                    <span class="text-muted" id="atotal">0</span>
                </div> 
                <div class="d-flex justify-content-between">
                    <span class="font-weight-bold"><b>Grand Total:</b></span>
                    <span class="text-muted"><b id="gtotal">5</b></span>
                </div> 
            </div>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
        <button type="button" class="btn btn-danger" id="del-btn" data-id="">Delete</button>
      </div>

        </div>
    </div>
    </div>
    <!-- End Quotation Delete Modal -->

    <?php include_once 'includes/footer.php' ?>
    <script src="assets/libs/jquery-ui/jquery-ui.js"></script>
    <script src="assets/libs/datatables/dataTables.min.js"></script>
    <script src="assets/libs/datatables/dataTables.bootstrap.min.js"></script>

    <script>
        $(document).ready(function (){
            $(document).on('click', '.remove-quot-btn', function (e) {
                e.preventDefault();
                var delId = $(this).data('id');
                    $.ajax({
                    url: 'includes/ajax_quot_details.php',
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        delId: delId,
                        quotdetails: true
                    },
                    success: function(response) {
                        $("#qid").html("#"+response.quotId);
                        $("#gname").html(response.gestId);
                        $("#htotal").html(response.hotelTotal);
                        $("#ctotal").html(response.cabTotal);
                        $("#atotal").html(response.addonTotal);
                        $("#gtotal").html(response.grandTotal);
                        $("#del-btn").attr('data-id' , response.quotId);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });

            $(document).on('click', '#del-btn', function (e) {
                var delId = $(this).data('id');
                if(delId){
                    $.ajax({
                        url: 'includes/ajax_quot_delete.php',
                        method: 'POST',
                        dataType: 'json',
                        data: {
                            delId: delId,
                            quotdelete: true
                        },
                        success: function(response) {
                            if(response.result == true)
                            {
                                alert("Deleted Successfully!!");
                                location.reload();
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                }
            });
        });

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
                    data: 'lead_id',
                    title: 'Lead ID',
                    orderable: false,
                },
                {
                    data: 'guest_name',
                    title: 'Guest Name',
                    orderable: false,
                },
                {
                    data: 'pax',
                    title: 'PAX',
                    orderable: false,
                },
                {
                    data: 'location',
                    title: 'Location',
                    orderable: false,
                },
                {
                    data: 'remarks',
                    title: 'Remarks',
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
            dhUrl: "lead-list?delete&id=" + id
          })
        }

        //-------------------------DATATABLE END------------------------------//

    </script>


</body>

</html>