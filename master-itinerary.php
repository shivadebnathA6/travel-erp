<?php
include 'includes/db_config.php';
$thisPageTitle = 'ITINERARY';
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

    $di_sql = "SELECT * FROM `tbl_itinerary` WHERE is_deleted= 0";

    ## Search
    $searchQuery = " ";
    if ($searchValue != '') {
        $di_sql .= " AND (`name` LIKE '%" . $searchValue . "%')";
    }

    $query        = $mysqli->query($di_sql);
    $totalRecords = $totalRecordwithFilter = $query->num_rows;

    ## Fetch records
    $diQuery   = $di_sql . " ORDER BY `id` DESC LIMIT " . $start . "," . $rowperpage;
    $diRecords = mysqli_query($mysqli, $diQuery);

    $slno = 0;
    while ($row = mysqli_fetch_assoc($diRecords)) {
        $slno++;
        $row['duration']=$row['no_of_day'].' Day '.$row['no_of_night'].' Night';
        $row['action'] = '<div class="btn-group" role="group" aria-label="table Button">';

        $row['action'] .= '<a href="master-itinerary?e_id=' . $row['id'] . '" type="button" class="btn btn-sm btn-info btn-table" ><i class="fa fa-edit me-1"></i>Edit</a>';

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
    $package_title         = filtervar($mysqli, $_POST['package_title']);
    $no_of_day         = filtervar($mysqli, $_POST['no_of_day']);
    $no_of_night         = filtervar($mysqli, $_POST['no_of_night']);
    $day_itinerary_header         =  implode('||',$_POST['day_itinerary_header']);
    $day_itinerary_description         =  implode('||',$_POST['day_itinerary_description']);

    $user_id = $_SESSION['login']['user_id'];
    $gen_date = input_date(date('d-m-Y'));

    $data     = "   `package_title`       = '$package_title',
    `no_of_day`       = '$no_of_day',
    `no_of_night`       = '$no_of_night',
    `day_itinerary_header`       = '$day_itinerary_header',
    `day_itinerary_description`       = '$day_itinerary_description',";

    if ($form_action == 'ADD') {
        $data .= "`created_by` = '$user_id',`created_at` = '$gen_date'";
        $query = "INSERT INTO `tbl_itinerary` SET $data";
        $id    = $mysqli->insert_id;
        $msg   = "Successfully Inserted";
    } elseif ($form_action == 'UPDATE') {
        $data .= "`updated_by` = '$user_id',`updated_at` = '$gen_date'";
        $query = "UPDATE `tbl_itinerary` SET $data WHERE `id`='$id'";
        $msg   = "Successfully Updated";
    }

    if ($mysqli->query($query)) {
        $result = array('result' => true, 'redirect' => 'master-itinerary', 'dhSession' => ["success" => $msg]);
    } else {
        $result = array('result' => false, 'dhSession' => ["success" => "Sorry !! Try Again"]);
    }

    echo json_encode($result);
    exit;
}

//======================Delete======================
if (isset($_REQUEST['delete']) && !empty($_REQUEST['id'])) {
    $id           = filtervar($mysqli, $_REQUEST['id']);
    $update_query = $mysqli->query("UPDATE `tbl_itinerary` SET `is_deleted`=1 WHERE `id`='$id'");
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
    $get_result = $mysqli->query("SELECT * FROM `tbl_itinerary` WHERE `id`='$id' ");
    if ($get_result->num_rows) {
        $row    = $get_result->fetch_assoc();
        $action = "UPDATE";

        // Split itinerary headers and descriptions
        $itinerary_headers = explode('||', $row['day_itinerary_header']);
        $itinerary_descriptions = explode('||', $row['day_itinerary_description']);

        // Generate HTML for existing itinerary rows
        foreach ($itinerary_headers as $index => $header) {
            $day = $index + 1;
            $description = $itinerary_descriptions[$index];
            $itineraryRowsHtml .= "
                <div class='itinerary' id='itinerary_$day'>
                    <div class='row g-3'>
                        <div class='col-md-12'>
                            <label for='day_itinerary_header_$day'>Day $day Itinerary Header</label>
                            <input type='text' class='form-control' name='day_itinerary_header[]' id='day_itinerary_header_$day' value='$header' required>
                        </div>
                        <div class='col-md-12'>
                            <label for='day_itinerary_description_$day'>Day $day Itinerary Description</label>
                            <textarea class='form-control ckeditor' name='day_itinerary_description[]' id='day_itinerary_description_$day'>$description</textarea>
                        </div>
                        <div class='col-md-12'>
                            <button type='button' class='btn btn-sm btn-danger remove-itinerary mt-2'>Remove</button>
                        </div>
                    </div>
                </div>
            ";
        }

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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <?php include_once 'includes/header.php' ?>
    <div class="main-content" id="miniaresult">
        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <!-- form proparty Start -->
                    <div class="col-md-12">

                        <div class="card">
                            <div class="card-header">
                                <h4><?php echo $action ?> <?php echo $thisPageTitle ?></h4>
                            </div>
                            <div class="card-body">
                                <form class="dhForm" method="post" autocomplete="off">
                                    <div class="row g-3">

                                        <input type="hidden" name="form_action" id="form_action" value="<?php echo $action ?>">
                                        <input type="hidden" name="id" value="<?php echo (isset($row['id']) && !empty($row['id']) ? $row['id'] : '') ?>">
                                        <div class="col-md-8">
                                            <label for="">Package Title</label>
                                            <input type="text" class="form-control " name="package_title" id="package_title" value="<?php echo (isset($row['package_title'])) ? $row['package_title'] : '' ?>" placeholder="Package Title" required>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="">No Of Day</label>
                                            <input type="text" class="form-control numInput" name="no_of_day" id="package_title" value="<?php echo (isset($row['package_title'])) ? $row['package_title'] : '' ?>" placeholder="No Of Day" required>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="">No Of Night</label>
                                            <input type="text" class="form-control numInput" name="no_of_night" id="no_of_night" value="<?php echo (isset($row['no_of_night'])) ? $row['no_of_night'] : '' ?>" placeholder="No Of Night" required>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="itinerary-container">
                                                
                                                <?php if (!empty($itineraryRowsHtml)) {
                                                    echo $itineraryRowsHtml;
                                                }else {
                                                    // Default empty itinerary row
                                                    echo "
                                                        <div class='itinerary' id='itinerary_1'>
                                                            <div class='row g-3'>
                                                                <div class='col-md-12'>
                                                                    <label for='day_itinerary_header_1'>Day 1 Itinerary Header</label>
                                                                    <input type='text' class='form-control' name='day_itinerary_header[]' id='day_itinerary_header_1' required>
                                                                </div>
                                                                <div class='col-md-12'>
                                                                    <label for='day_itinerary_description_1'>Day 1 Itinerary Description</label>
                                                                    <textarea class='form-control ckeditor' name='day_itinerary_description[]' id='day_itinerary_description_1'></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    ";
                                                } ?>
                                            </div>
                                            <button type="button" class="btn btn-sm btn-success mt-3" id="add-itinerary">Add Day</button>
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
                    <div class="col-md-12">
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
    </div>

    <?php include_once 'includes/footer.php' ?>
    <script src="assets/libs/jquery-ui/jquery-ui.js"></script>
    <script src="assets/libs/datatables/dataTables.min.js"></script>
    <script src="assets/libs/datatables/dataTables.bootstrap.min.js"></script>
    <script src="assets/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js"></script>
    <script>
        let editorInstances = {};

        function initCkEditor() {
            $('.ckeditor').each(function() {
                let textareaId = $(this).attr('id');
                if (!editorInstances[textareaId]) {
                    ClassicEditor
                        .create(document.querySelector(`#${textareaId}`), {
                            removePlugins: ['CKFinderUploadAdapter', 'CKFinder', 'EasyImage', 'Image', 'ImageCaption', 'ImageStyle', 'ImageToolbar', 'ImageUpload', 'MediaEmbed']
                        })
                        .then(editor => {
                            editorInstances[textareaId] = editor;
                        })
                        .catch(error => {
                            console.error(error);
                        });
                }
            });
        }

        function destroyCkEditor(textareaId) {
            if (editorInstances[textareaId]) {
                editorInstances[textareaId].destroy()
                    .then(() => {
                        delete editorInstances[textareaId];
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }
        }

        $(document).ready(function() {
            initCkEditor();

            $('#add-itinerary').on('click', function() {
                const itineraryIndex = $('.itinerary').length + 1;

                const itineraryTemplate = `
                    <div class="itinerary" id="itinerary_${itineraryIndex}">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label for="day_itinerary_header_${itineraryIndex}">Day ${itineraryIndex} Itinerary Header</label>
                                <input type="text" class="form-control" name="day_itinerary_header[]" id="day_itinerary_header_${itineraryIndex}" required>
                            </div>
                            <div class="col-md-12">
                                <label for="day_itinerary_description_${itineraryIndex}">Day ${itineraryIndex} Itinerary Description</label>
                                <textarea class="form-control ckeditor" name="day_itinerary_description[]" id="day_itinerary_description_${itineraryIndex}" ></textarea>
                            </div>
                            <div class="col-md-12">
                                <button type="button" class="btn btn-sm btn-danger remove-itinerary mt-2">Remove</button>
                            </div>
                        </div>
                    </div>
                `;

                $('.itinerary-container').append(itineraryTemplate);
                initCkEditor();
            });

            $(document).on('click', '.remove-itinerary', function() {
                let textareaId = $(this).closest('.itinerary').find('.ckeditor').attr('id');
                destroyCkEditor(textareaId);
                $(this).closest('.itinerary').remove();
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
                        'url': 'master-itinerary'
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
                            data: 'package_title',
                            title: 'Package Title',
                            orderable: false,
                        },
                        {
                            data: 'duration',
                            title: 'Duration',
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
                    dhUrl: "master-itinerary?delete&id=" + id
                })
            }

            //-------------------------DATATABLE END------------------------------//
        </script>

</body>

</html>