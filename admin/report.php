<?php
// Include the database connection
include 'loginQuery/session_start.php';
include 'dbc.php';

$pageTitle = "List of Final Report";
$pageName = "Final Report";

$group_id = ''; // Initialize $group_id with an empty value

if (isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];
    $order_date = $_POST['order_date'];
    $cart_status = 1; // Example status, update if necessary

    // Check if a record with the same order_id and order_date already exists in tbl_order
    $checkQuery = mysqli_query($conn, "SELECT * FROM tbl_order WHERE order_id = '$order_id' AND order_date = '$order_date'");

    if (mysqli_num_rows($checkQuery) === 0) { // No matching record found, safe to insert
        // Fetch records from tbl_temp_order with the given order_id
        $sqlFetch = mysqli_query($conn, "SELECT * FROM tbl_temp_order WHERE order_id = '$order_id'");

        if (mysqli_num_rows($sqlFetch) > 0) {
            $values = [];

            while ($row = mysqli_fetch_assoc($sqlFetch)) {
                $values[] = "(
                    '$order_id', 
                    '{$row['order_date']}', 
                    '{$row['group_id']}', 
                    '{$row['customer_id']}', 
                    '{$row['customer_name']}', 
                    '{$row['delivery_type']}', 
                    '{$row['product_id']}', 
                    '{$row['product_name']}', 
                    '{$row['product_price']}', 
                    '{$row['size_id']}', 
                    '{$row['size_name']}', 
                    '{$row['size_value']}', 
                    '{$row['total_amount']}', 
                    '$cart_status',
                     '{$row['delivery_boy_id']}', 
                    '{$row['delivery_boy_name']}'
                )";

                // Set $group_id once from the row data
                $group_id = $row['group_id'];
            }

            if (count($values) > 0) {
                $insert_sql = "INSERT INTO tbl_order 
                (order_id, order_date, group_id, customer_id, customer_name, delivery_type, product_id, product_name, 
                 product_price, size_id, size_name, size_value, total_amount, cart_status, delivery_boy_id,delivery_boy_name)
                VALUES " . implode(", ", $values);

                if (mysqli_query($conn, $insert_sql)) {
                    echo "Data successfully inserted into tbl_order.";
                } else {
                    echo "Error: " . mysqli_error($conn);
                }
            }
        } else {
            echo "No records found in tbl_temp_order for the specified order_id.";
        }
    } else {
        // echo "Record with order_id '$order_id' and order_date '$order_date' already exists in tbl_order.";

        // Set $group_id from the existing tbl_order record if not already set
        $existingOrder = mysqli_fetch_assoc($checkQuery);
        $group_id = $existingOrder['group_id'];
    }
} else {
    echo "Order ID not set.";
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <title><?php echo $pageTitle; ?></title>
    <!-- Vendor styles -->
    <?php include 'include/header-file.php'; ?>
    <link rel="stylesheet" href="vendor/select2-3.5.2/select2.css" />
    <link rel="stylesheet" href="vendor/select2-bootstrap/select2-bootstrap.css" />
    <link rel="stylesheet" href="vendor/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css" />
    <link rel="stylesheet" href="vendor/datatables.net-bs/css/dataTables.bootstrap.min.css" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <?php include 'message.php'; ?>
    <style>
        .small-header .panel-body h2 {
            margin-top: 3px;
        }

        .hbreadcrumb {
            margin-top: 0;
        }
    </style>
</head>

<body>

    <!-- Header -->
    <?php include 'include/header.php'; ?>
    <!-- Navigation -->
    <?php include 'include/side-menu.php'; ?>

    <div id="wrapper">
        <div class="small-header">
            <div class="hpanel">
                <div class="panel-body">
                    <h2 class="font-light m-b-xs"><?php echo $pageName; ?></h2>
                    <small><?php echo $pageTitle; ?></small>
                </div>
            </div>
        </div>

        <?php
        // Query to fetch customer details
        $sql = mysqli_query($conn, "SELECT cg.*, c.name AS customer_name, c.phone, c.address, dt.name AS delivery_type
        FROM tbl_customer_group cg 
        LEFT JOIN tbl_customer c ON cg.customer_id = c.id
        LEFT JOIN tbl_delivery_type dt ON c.delivery_type_id = dt.id
        WHERE cg.group_id = '$group_id'");

        while ($fetch_row = mysqli_fetch_array($sql)) {
        ?>
            <div class="col-lg-6" style="margin-top: 50px;">
                <div class="hpanel hgreen">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <h4><a href="#"><?= $fetch_row['customer_name'] ?></a></h4>
                                <p>
                                    Contact No. : <?= $fetch_row['phone'] ?><br>
                                    Address : <?= $fetch_row['address'] ?><br>
                                    Delivery Type : <?= $fetch_row['delivery_type'] ?>
                                </p>
                                <div class="row" style="margin-top: 15px;">
                                    <div class="col-sm-12">
                                        <div class="project-label">Product</div>
                                    </div>

                                    <?php
                                    // Fetch and display each product's details
                                    $sql1 = mysqli_query($conn, "SELECT * FROM tbl_order WHERE customer_id = '{$fetch_row['customer_id']}' AND order_date = '$order_date'");

                                    if (mysqli_num_rows($sql1) > 0) {
                                        // Orders are found in tbl_order, display them
                                        while ($product_row = mysqli_fetch_array($sql1)) {
                                            echo "<div class='col-sm-12'><small>{$product_row['size_name']} &nbsp; &nbsp;&nbsp; {$product_row['product_name']}</small></div>";
                                        }
                                    } else {
                                        // No order found for today in tbl_order, check tbl_temp_order next
                                        $temp_order_sql = mysqli_query($conn, "SELECT * FROM tbl_temp_order WHERE customer_id = '{$fetch_row['customer_id']}' AND order_date = '$order_date'");

                                        if (mysqli_num_rows($temp_order_sql) > 0) {
                                            // Records exist in tbl_temp_order but not yet processed to tbl_order
                                            echo "<div class='col-sm-12'><small>Pending in temporary orders for today.</small></div>";
                                        } else {
                                            // No records in both tbl_order and tbl_temp_order, check for off days
                                            $off_day_sql = mysqli_query($conn, "SELECT * FROM tbl_off_days WHERE customer_id = '{$fetch_row['customer_id']}' AND date = '$order_date'");

                                            if (mysqli_num_rows($off_day_sql) > 0) {
                                                // Customer has an off day record, display the reason
                                                $off_day_row = mysqli_fetch_assoc($off_day_sql);
                                                // echo "<pre>";
                                                // print_r($off_day_row);
                                                // echo "</pre>";
                                                echo "<div class='col-sm-12'><small>Off day for : {$off_day_row['remark']}</small></div>";
                                            } else {
                                                // No order and no off day found for today
                                                echo "<div class='col-sm-12'><small>No order today and no off day record found.</small></div>";
                                            }
                                        }
                                    }
                                    ?>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        Additional information about project in footer
                    </div>
                </div>
            </div>
        <?php
        }
        ?>

        <?php include 'include/footer-file.php'; ?>
    </div>

</body>

</html>

<link rel="stylesheet" href="vendor/sweetalert/lib/sweet-alert.css" />
<script src="vendor/sweetalert/lib/sweet-alert.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>