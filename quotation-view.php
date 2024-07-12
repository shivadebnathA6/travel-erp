<?php  
include 'includes/db_config.php';
if (isset($_REQUEST['q_id'])) {
    $id         = filtervar($mysqli, $_REQUEST['q_id']);
    $get_result = $mysqli->query("SELECT * FROM `tbl_quotation` WHERE `id`='$id'");
    if ($get_result->num_rows) {
    $quot    = $get_result->fetch_assoc();
        
    } else {
        echo '<script>window.history.back();</script>';
        exit;
    }
}else {
    echo '<script>window.history.back();</script>';
    exit;
}
$q_id =$quot['id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Quotation</title>
    <style>
        body {
    font-family: 'Arial', sans-serif;
    background-color: #f8f9fa;
    margin: 0;
    padding: 0;
    color: #333;
}

header {
    background-color: #007bff;
    color: #fff;
    text-align: center;
    padding: 1.5rem 0;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

header h1 {
    margin: 0;
    font-size: 2rem;
    font-weight: 700;
}

main {
    padding: 2rem;
    max-width: 900px;
    margin: 2rem auto;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
}

section {
    margin-bottom: 2rem;
}

section h2 {
    border-bottom: 2px solid #007bff;
    padding-bottom: 0.5rem;
    margin-bottom: 1rem;
    font-size: 1.5rem;
    color: #007bff;
}

.quotation-item {
    padding: 1rem;
    margin-bottom: 1rem;
    border-radius: 5px;
    border: 1px solid #e1e1e1;
    background-color: #f8f9fa;
    transition: background-color 0.3s ease;
}

.quotation-item:hover {
    background-color: #e9ecef;
}

.quotation-item h3 {
    margin: 0;
    color: #007bff;
    font-size: 1.25rem;
}

.quotation-item p {
    margin: 0.5rem 0 0 0;
    line-height: 1.6;
}

    </style>
</head>
<body>
    <header>
        <h1> <?php echo $quot['id']?> Quotation</h1>
    </header>
    <main>
        <?php            
    $sql="SELECT * FROM `tbl_voucher_hotel` WHERE `quotation_id`='$q_id'";
    $h_query=$mysqli->query($sql);
    if($h_query->num_rows >0){ ?>
        <section id="hotels">
            <h2>Hotels</h2>
            <?php 

    while($h_row=$h_query->fetch_assoc()){
            ?>
            <div class="quotation-item">
                <h3><?php echo getHotelName($h_row['hotel_id']) ?></h3>
                <p><strong>Checkin & Checkout:</strong> <?php echo output_date($h_row['checkin']) ?> To <?php echo output_date($h_row['checkout']) ?></p>
                <p><strong>Price:</strong> ₹<?php echo $h_row['customer_price']?></p>
            </div>
            <?php } ?>
        </section>
        <?php } ?>
        <?php            
    $sql="SELECT * FROM `tbl_voucher_cab` WHERE `quotation_id`='$q_id'";
    $c_query=$mysqli->query($sql);
    if($c_query->num_rows >0){ ?>
        <section id="cabs">
            <h2>Cabs</h2>
            <?php 

    while($c_row=$c_query->fetch_assoc()){
            ?>
            <div class="quotation-item">
                <h3><?php echo getCabName($c_row['cab_id']) ?></h3>
                <p><strong>Price:</strong> ₹<?php echo  $c_row['customer_price'] ?> </p>
            </div>
            <?php } ?>
        </section>
        <?php } ?>
        <?php            
    $sql="SELECT * FROM `tbl_voucher_addon` WHERE `quotation_id`='$q_id'";
    $a_query=$mysqli->query($sql);
    if($a_query->num_rows >0){ ?>
        <section id="addons">
            <h2>Addons</h2>
            <?php 

    while($a_row=$a_query->fetch_assoc()){
            ?>
            <div class="quotation-item">
                <h3><?php echo getAddonName($a_row['addon_id']) ?></h3>
                <p><strong>Price:</strong> ₹<?php echo $a_row['customer_price'] ?></p>
            </div>
            <?php } ?>
        </section>
        <?php } ?>
    </main>
</body>
</html>
