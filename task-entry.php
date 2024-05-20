<?php
    include 'includes/after_login.php';
    $thisPageTitle = 'TASK';
    $action = "ADD";


  

  if(isset($_POST['submit'])){
    $id = isset($_POST['id']) ? filtervar($mysqli, $_POST['id']) : '';
    $form_action=filtervar($mysqli,$_POST['form_action']);
    $title = filtervar($mysqli, ($_POST['title']));
    $description = filtervar($mysqli, htmlentities($_POST['description']));
    $task_status=filtervar($mysqli,($_POST['task_status']));
    $user_id=filtervar($mysqli,($_POST['user_id']));
    $due_date=input_date(filtervar($mysqli,$_POST['due_date']));
    
    $data = "`title` = '$title',
    `description` = '$description',
    `status` = '$task_status',
    `user_id` = '$user_id',
    `due_date` = '$due_date'
         ";

    if($form_action == 'ADD'){
        $query = "INSERT INTO `task` SET $data";
        $id = $mysqli->insert_id;
        $msg = "Successfully Inserted";
    }elseif($form_action == 'UPDATE'){
        $query = "UPDATE `task` SET $data WHERE `id`='$id'";
        $msg = "Successfully Updated";
    }

    if($mysqli->query($query)){
       $result = array('result' => true, 'redirect' => 'task', 'dhSession' => ["success" => $msg]);
    }else{
        $result = array('result' => false, 'dhSession' => ["success" => "Sorry !! Try Again"]);
    }

    echo json_encode($result);
    exit;
  }

    

  if(isset($_REQUEST['e_id'])){
    $id         = filtervar($mysqli, $_REQUEST['e_id']);
    $get_result = $mysqli->query("SELECT * FROM `task` WHERE `id`='$id' ");
    if($get_result->num_rows){
        $row = $get_result->fetch_assoc();
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
    <form class="dhForm" method="post">
    <div class="row g-3">
    <input type="hidden" name="form_action" id="form_action" value="<?php echo $action ?>">
    <input type="hidden" name="id" value="<?php echo (isset($row['id'])&&!empty($row['id'])?$row['id']:'') ?>">
    <div class="col-md-12 ">
        <label for="">Task Title</label>
        <input type="text" class="form-control" name="title" id="title" value="<?php echo (isset($row['title']))?$row['title']:'' ?>" placeholder="Enter Task Title">
    </div>

    <div class="col-md-12 ">
        <label for="">Task Description</label>
        <textarea class="form-control ckeditor" name="description" id="description"  placeholder="Enter Tax Percent"><?php echo (isset($row['description']))?html_entity_decode(html_entity_decode($row['description'])):'' ?></textarea>
    </div>
    <div class="col-md-4">
        <label for="">Status</label>
        <select name="task_status" id="task_status" class="form-select">
            <option value="" >Select Status</option>
            <option value="1" <?php echo (isset($row['status'])&& $row['status']==1)?'selected':'' ?>>To Do</option>
            <option value="2" <?php echo (isset($row['status'])&& $row['status']==2)?'selected':'' ?>>In Progress</option>
            <option value="3" <?php echo (isset($row['status'])&& $row['status']==3)?'selected':'' ?>>Done</option>
        </select>
    </div>
    <div class="col-md-4">
        <label for="">Employee</label>
        <select name="user_id" id="user_id" class="form-select select2">
                                                <option value="">Select</option>
                                                <?php $filed_sql = $mysqli->query("SELECT * FROM `users`");
                                                while ($field_fetch = $filed_sql->fetch_array()) {
                                                ?>
                                                    <option value="<?php echo $field_fetch['id'] ?>" <?php echo (isset($row['user_id'])&& $row['user_id']==$field_fetch['id'])?'selected':'' ?>><?php echo $field_fetch['name'] ?></option>
                                                <?php } ?>
                                            </select>
    </div>
<div class="col-md-4">
    <label for="">Last Date</label>
    <input type="text" class="form-control datepicker" name="due_date" id="due_date" value="<?php echo (isset($row['due_date']))?output_date($row['due_date']):'' ?>" placeholder="Enter Last Date">
</div>
    <div class="col-md-12  text-center">
        <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle me-2"></i>SUBMIT DETAILS</button>
    </div>
    </div>
    </form>
    </div>
    </div>

    </div>
    <!-- form proparty end -->
    

    </div> <!-- container-fluid -->
    </div>
    </div>

    <?php include_once 'includes/footer.php' ?>
    <script src="assets/libs/jquery-ui/jquery-ui.js"></script>
    <script src="assets/libs/datatables/dataTables.min.js"></script>
    <script src="assets/libs/datatables/dataTables.bootstrap.min.js"></script>
    <script src="assets/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js"></script>
<script>
     $('.select2').select2();
</script>
<script>
    ClassicEditor
        .create( document.querySelector( '.ckeditor' ) )
        .catch( error => {
            console.error( error );
        } );
</script>


</body>

</html>