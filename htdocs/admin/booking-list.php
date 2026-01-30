<?php  
include 'loginQuery/session_start.php';
include 'dbc.php';

$pageTitle = "Table Booking List";
$pageName  = "Table Bookings";
$tableName = "tbl_booking";
?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


<?php include 'include/header-file.php'; ?>
<link rel="stylesheet" href="vendor/datatables.net-bs/css/dataTables.bootstrap.min.css" />
<link rel="stylesheet" href="vendor/sweetalert/lib/sweet-alert.css" />

<style>
    body { background: #f8f9fc; font-family: 'Poppins', sans-serif; }
    .content { padding: 20px; }
    table th, table td { vertical-align: middle !important; text-align: center; }
    .badge-success { background-color: #28a745 !important; color: #fff; padding: 6px 12px; border-radius: 12px; }
    .badge-secondary { background-color: #6c757d !important; color: #fff; padding: 6px 12px; border-radius: 12px; }
    .btn-xs { padding: 5px 10px; font-size: 13px; }
</style>


</head>
<body>

<?php include 'include/header.php'; ?>

<?php include 'include/side-menu.php'; ?>

<div id="wrapper">
    <div class="small-header">
        <div class="hpanel">
            <div class="panel-body">
                <h2 class="font-light m-b-xs"><?= htmlspecialchars($pageName) ?></h2>
                <small><?= htmlspecialchars($pageTitle) ?></small>
            </div>
        </div>
    </div>


<div class="content">
    <div class="hpanel">
        <div class="panel-body">
            <div class="table-responsive">
                <table id="bookingTable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Number</th>
                            <th>Table No</th>
                            <th>Category</th>
                            <th>Product</th>
                            <th>Size</th>
                            <th>Quantity</th>
                            <th>Total Price</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT b.*, 
                                         c.name AS category_name, 
                                         p.name AS product_name, 
                                         p.price_half, 
                                         p.price_full 
                                  FROM $tableName b
                                  LEFT JOIN tbl_product_category c ON b.category_id = c.id
                                  LEFT JOIN tbl_product p ON b.product_id = p.id
                                  ORDER BY b.id DESC"; // Newest first

                        $result = mysqli_query($conn, $query);
                        $counter = 1;

                        while ($row = mysqli_fetch_assoc($result)) {
                            $size = $row['size'];
                            $quantity = (int)$row['quantity'];
                            $unit_price = ($size === 'half') ? $row['price_half'] : $row['price_full'];
                            $total_price = $unit_price * $quantity;
                            $status = strtolower($row['status']);
                        ?>
                        <tr id="row-<?= $row['id'] ?>">
                            <td><?= $counter++ ?></td>
                            <td><?= htmlspecialchars($row['customer_name']) ?></td>
                            <td><?= htmlspecialchars($row['mobile']) ?></td>
                            <td><?= htmlspecialchars($row['table_number']) ?></td>
                            <td><?= htmlspecialchars($row['category_name']) ?></td>
                            <td><?= htmlspecialchars($row['product_name']) ?></td>
                            <td><?= ucfirst($size) ?></td>
                            <td><?= $quantity ?></td>
                            <td>₹<?= number_format($total_price, 2) ?></td>
                            <td><?= htmlspecialchars($row['created_at']) ?></td>
                            <td>
                                <?php if ($status === 'confirmed'): ?>
                                    <span class="badge badge-success">Confirmed</span>
                                <?php else: ?>
                                    <span class="badge badge-secondary">Pending</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <button class="btn btn-danger btn-xs delete-btn" data-id="<?= $row['id'] ?>">Delete</button>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include 'include/footer-file.php'; ?>


</div>

<!-- JS -->

<script src="vendor/jquery/jquery.min.js"></script>

<script src="vendor/datatables/media/js/jquery.dataTables.min.js"></script>

<script src="vendor/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<script src="vendor/sweetalert/lib/sweet-alert.min.js"></script>

<script>
$(document).ready(function() {
    $('#bookingTable').DataTable({
        "pageLength": 10,
        "order": [[0, "desc"]],
        "language": {
            "search": "Search:",
            "lengthMenu": "Show _MENU_ entries",
            "info": "Showing _START_ to _END_ of _TOTAL_ bookings"
        }
    });

    // Delete booking
    $(document).on('click', '.delete-btn', function() {
        var id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "This booking will be permanently deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'delete-booking.php',
                    type: 'POST',
                    data: {id: id},
                    success: function(response) {
                        if (response == 'success') {
                            $('#row-' + id).remove();
                            Swal.fire('Deleted!', 'Booking has been deleted.', 'success');
                 
