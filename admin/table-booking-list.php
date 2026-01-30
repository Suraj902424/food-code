<?php 
include 'loginQuery/session_start.php';
include 'dbc.php';

$pageTitle = "Table Booking List";
$pageName  = "Table Bookings";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= $pageTitle ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php include 'include/header-file.php'; ?>
    <link rel="stylesheet" href="vendor/datatables.net-bs/css/dataTables.bootstrap.min.css" />
    <link rel="stylesheet" href="vendor/sweetalert/lib/sweet-alert.css" />

    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f9fbfd; }
        .badge-success { background-color: #28a745; padding: 5px 10px; border-radius: 15px; color: #fff; }
        .btn-primary, .btn-danger { border-radius: 20px; padding: 4px 10px; }
        table { border-radius: 10px !important; overflow: hidden; }
    </style>
</head>
<body>

<?php include 'include/header.php'; ?>
<?php include 'include/side-menu.php'; ?>

<div id="wrapper">
    <div class="small-header">
        <div class="hpanel">
            <div class="panel-body">
                <h2 class="font-light m-b-xs"><?= $pageName ?></h2>
                <small><?= $pageTitle ?></small>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="hpanel">
                    <div class="panel-body">
                        <table id="bookingTable" class="table table-striped table-bordered table-hover" width="100%">
                            <thead class="table-dark text-center">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Mobile</th>
                                    <th>Table</th>
                                    <th>Category</th>
                                    <th>Product</th>
                                    <th>Size</th>
                                    <th>Qty</th>
                                    <th>Total</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'include/footer-file.php'; ?>
</div>

<!-- JS Files -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/datatables/media/js/jquery.dataTables.min.js"></script>
<script src="vendor/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="vendor/sweetalert/lib/sweet-alert.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function () {
    // 🔹 Load data from PHP via AJAX
    var table = $('#bookingTable').DataTable({
        ajax: 'load-bookings.php',
        columns: [
            { data: 'id' },
            { data: 'customer_name' },
            { data: 'mobile' },
            { data: 'table_number' },
            { data: 'category_name' },
            { data: 'product_name' },
            { data: 'size' },
            { data: 'quantity' },
            { data: 'total_price' },
            { data: 'created_at' },
            { data: 'status_html' }
        ],
        order: [[0, 'desc']]
    });

    // 🔁 Auto-refresh every 10 seconds to reflect customer confirmations
    setInterval(() => {
        table.ajax.reload(null, false);
    }, 10000);
});
</script>

</body>
</html>
