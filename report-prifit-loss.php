<?php
include 'includes/after_login.php';
$thisPageTitle = 'GUEST PAYMENTS REPORT';
$action = "ADD";

// SQL query
$sql = "SELECT q.guest_id as guest_id, 
               q.created_at as created_at,
               q.pack_total as pack_total, 
               q.id as quotation_id, 
               va.addon_id as addon_id, 
               SUM(va.cost) as addon_cost, 
               vc.cab_id as cab_id,
               SUM(vc.cost) as cab_cost, 
               vh.hotel_id as hotel_id, 
               SUM(vh.cost) as hotel_cost
        FROM tbl_voucher_addon va
        INNER JOIN tbl_quotation q ON va.quotation_id = q.id
        INNER JOIN tbl_voucher_cab vc ON vc.quotation_id = q.id
        INNER JOIN tbl_voucher_hotel vh ON vh.quotation_id = q.id
        WHERE q.is_deleted = 0";

// Add filters
if(isset($_GET["guest"]) && !empty($_GET["guest"])) {
    $guest_id = $_GET["guest"];
    $sql .= " AND q.guest_id = $guest_id";
}
if(isset($_GET["quotation_id"]) && !empty($_GET["quotation_id"])) {
    $quotation_id = $_GET["quotation_id"];
    $sql .= " AND q.id = $quotation_id";
}
if(isset($_GET["start_date"]) && isset($_GET["end_date"]) && !empty($_GET["start_date"]) && !empty($_GET["end_date"])) {
    $start_date = input_date($_GET["start_date"]);
    $end_date = input_date($_GET["end_date"]);
    $sql .= " AND q.created_at BETWEEN '$start_date' AND '$end_date'";
}

$sql .= " GROUP BY q.guest_id, q.pack_total, q.id, va.addon_id, vc.cab_id, vh.hotel_id, q.created_at";

$query = $mysqli->query($sql);
?>
<!doctype html>
<html lang="en">

<head>
    <?php include_once 'includes/style.php'; ?>
    <link rel="stylesheet" href="assets/libs/jquery-ui/jquery-ui.css">
</head>

<body>
    <?php include_once 'includes/header.php'; ?>
    <div class="main-content" id="miniaresult">
        <div class="page-content">
            <div class="container-fluid">
                <!-- start page title -->
                <div class="card">
                    <div class="card-header">
                        <form method="get">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <select name="quotation_id" id="quotation_id" class="form-select">
                                        <option value="">Choose Quotation</option>
                                        <?php 
                                        $field_sql = $mysqli->query("SELECT * FROM `tbl_quotation` WHERE `is_deleted`=0");
                                        while($field_row = $field_sql->fetch_array()) { ?>
                                            <option value="<?php echo $field_row['id']; ?>" <?php echo (isset($_GET['quotation_id']) && !empty($_GET['quotation_id']) && $_GET['quotation_id'] == $field_row['id']) ? 'selected' : ''; ?>>
                                                QUOT-<?php echo $field_row['id']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select name="guest" id="guest" class="form-select">
                                        <option value="">Choose Guest</option>
                                        <?php 
                                        $field_sql = $mysqli->query("SELECT * FROM `tbl_guest` WHERE `is_deleted`=0");
                                        while($field_row = $field_sql->fetch_array()) { ?>
                                            <option value="<?php echo $field_row['id']; ?>" <?php echo (isset($_GET['guest']) && !empty($_GET['guest']) && $_GET['guest'] == $field_row['id']) ? 'selected' : ''; ?>>
                                                <?php echo $field_row['guest_name']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" name="start_date" id="start_date" class="form-control start_date" placeholder="Enter Date" value="<?php echo isset($_GET['start_date']) ? $_GET['start_date'] : ''; ?>">
                                </div>
                                <div class="col-md-2">
                                    <input type="text" name="end_date" id="end_date" class="form-control end_date" placeholder="Enter Date" value="<?php echo isset($_GET['end_date']) ? $_GET['end_date'] : ''; ?>">
                                </div>
                                <div class="col-md-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <button type="submit" class="btn btn-primary w-100">Filter</button>
                                        </div>
                                        <div class="col-md-6">
                                            <a href="report-payment" class="btn btn-warning w-100">Reset</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <tr>
                                            <th>Sl. No</th>
                                            <th>Quotation No.</th>
                                            <th>Guest Name</th>
                                            <th>Package Amount</th>
                                            <th>Total Hotel</th>
                                            <th>Total Cab</th>
                                            <th>Total Addon</th>
                                            <th>Total Cost</th>
                                            <th>Profit</th>
                                            <th>Date</th>
                                        </tr>
                                        <?php 
                                        $slno = 1;
                                        $total_profit=0;
                                        while ($row = $query->fetch_array()) { 
                                            $total_cost = $row['hotel_cost'] + $row['cab_cost'] + $row['addon_cost'];
                                            $profit = $row['pack_total'] - $total_cost;
                                        ?>
                                            <tr>
                                                <td><?php echo $slno++; ?></td>
                                                <td><?php echo 'QUOT-' . $row['quotation_id']; ?></td>
                                                <td><?php echo getGuestName($row['guest_id']); ?></td>
                                                <td><?php echo $row['pack_total']; ?></td>
                                                <td><?php echo $row['hotel_cost']; ?></td>
                                                <td><?php echo $row['cab_cost']; ?></td>
                                                <td><?php echo $row['addon_cost']; ?></td>
                                                <td><?php echo $total_cost; ?></td>
                                                <td><?php echo $profit;$total_profit+=$profit; ?></td>
                                                <td><?php echo output_date($row['created_at']); ?></td>
                                            </tr>
                                        <?php } ?>
                                        <tr>
                                            <td colspan="7"><h4>Total Profit : <?php echo $total_profit ?></h4></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
            </div> <!-- container-fluid -->
        </div>
    </div>

    <?php include_once 'includes/footer.php'; ?>    
    <script src="assets/libs/jquery/jquery.min.js"></script>
    <script src="assets/libs/jquery-ui/jquery-ui.js"></script>

    <script>
        function openPayNow(quotation_id, due_amount) {
            $('#quotation_id').val(quotation_id);
            $('#exampleModal').modal('show');
        }
    </script>
</body>

</html>