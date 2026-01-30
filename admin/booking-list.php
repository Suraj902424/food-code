<?php
include 'loginQuery/session_start.php';
include 'dbc.php';

// Disable caching (forces browser + DataTable to always load fresh)
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

$pageTitle = "Table Booking List";
$pageName  = "Table Bookings";
$tableName = "tbl_booking";

// === DELETE LOGIC (Same File) ===
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    header('Content-Type: application/json');
    $id = (int)$_POST['id'];
    
    if ($id <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid ID']);
        exit;
    }

    $stmt = mysqli_prepare($conn, "DELETE FROM `$tableName` WHERE id = ?");
    if (!$stmt) {
        echo json_encode(['status' => 'error', 'message' => 'DB Error']);
        exit;
    }

    mysqli_stmt_bind_param($stmt, "i", $id);
    $executed = mysqli_stmt_execute($stmt);
    $deleted = $executed && mysqli_stmt_affected_rows($stmt) > 0;
    mysqli_stmt_close($stmt);

    echo json_encode([
        'status' => $deleted ? 'success' : 'error',
        'message' => $deleted ? 'Booking deleted!' : 'Not found!'
    ]);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <?php include 'include/header-file.php'; ?>
    <link rel="stylesheet" href="vendor/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        body { background: #f8f9fc; font-family: 'Poppins', sans-serif; }
        .content { padding: 20px; }
        table th, table td { vertical-align: middle !important; text-align: center; }
        .badge { padding: 5px 10px; border-radius: 12px; font-size: 12px; }
        .btn-xs { padding: 4px 8px; font-size: 12px; }
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
                                <th>ID</th>
                                <th>Name</th>
                                <th>Number</th>
                                <th>Table</th>
                                <th>Category</th>
                                <th>Product</th>
                                <th>Size</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT b.*, c.name AS category_name, p.name AS product_name, p.price_half, p.price_full 
                                      FROM $tableName b
                                      LEFT JOIN tbl_product_category c ON b.category_id = c.id
                                      LEFT JOIN tbl_product p ON b.product_id = p.id
                                      ORDER BY b.id DESC";
                            $result = mysqli_query($conn, $query);
                            $counter = 1;

                            if ($result && mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $size = $row['size'] ?? 'full';
                                    $qty = (int)($row['quantity'] ?? 0);
                                    $price = ($size === 'half') ? ($row['price_half'] ?? 0) : ($row['price_full'] ?? 0);
                                    $total = $price * $qty;
                                    $status = strtolower($row['status'] ?? 'pending');
                            ?>
                            <tr id="row-<?= $row['id'] ?>">
                                <td><?= $counter++ ?></td>
                                <td><?= htmlspecialchars($row['id']) ?></td>
                                <td><?= htmlspecialchars($row['customer_name']) ?></td>
                                <td><?= htmlspecialchars($row['mobile']) ?></td>
                                <td><?= htmlspecialchars($row['table_number']) ?></td>
                                <td><?= htmlspecialchars($row['category_name'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($row['product_name'] ?? '-') ?></td>
                                <td><?= ucfirst($size) ?></td>
                                <td><?= $qty ?></td>
                                <td>₹<?= number_format($total, 2) ?></td>
                                <td><?= date('d-m-Y H:i', strtotime($row['created_at'])) ?></td>
                                <td>
                                    <span class="badge badge-<?= $status === 'confirmed' ? 'success' : 'secondary' ?>">
                                        <?= ucfirst($status) ?>
                                    </span>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-xs delete-btn" data-id="<?= $row['id'] ?>">
                                        <i class="fa fa-trash"></i> Delete
                                    </button>
                                </td>
                            </tr>
                            <?php
                                }
                            } else {
                                echo '<tr><td colspan="13">No bookings found.</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <?php include 'include/footer-file.php'; ?>
</div>

<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/datatables/media/js/jquery.dataTables.min.js"></script>
<script src="vendor/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    var table = $('#bookingTable').DataTable({
        destroy: true,          // ensure clean reinit
        stateSave: false,       // disable cache
        order: [[1, 'desc']],   // sort by ID descending
        pageLength: 10,
        language: {
            emptyTable: "No bookings found"
        },
        columnDefs: [{ orderable: false, targets: [12] }]
    });

    // Delete Booking
    $(document).on('click', '.delete-btn', function() {
        var id = $(this).data('id');
        var row = $('#row-' + id);

        Swal.fire({
            title: 'Delete Booking?',
            text: "This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '',
                    type: 'POST',
                    data: { action: 'delete', id: id },
                    dataType: 'json',
                    success: function(res) {
                        if (res.status === 'success') {
                            row.fadeOut(300, function() {
                                table.row(row).remove().draw(false);
                            });
                            Swal.fire('Deleted!', res.message, 'success');
                        } else {
                            Swal.fire('Error', res.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Server error. Please try again.', 'error');
                    }
                });
            }
        });
    });
});
</script>

</body>
</html>
