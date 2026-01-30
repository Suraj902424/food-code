<?php 
include 'loginQuery/session_start.php';
include 'dbc.php';

$pageTitle = "Room Booking List";
$pageName = "Room Bookings";
$user_id = $_SESSION['userid'];

/* ============================================================
   DELETE BOOKING (Cancel + Free Room)
============================================================ */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'delete_booking') {
    header('Content-Type: application/json');
    $booking_id = (int)($_POST['id'] ?? 0);

    if ($booking_id <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid Booking ID']);
        exit;
    }

    mysqli_begin_transaction($conn);
    try {
        // Fetch booking details
        $stmt = mysqli_prepare($conn, "SELECT room_number FROM tbl_room_booking WHERE id = ? AND status = 'pending'");
        mysqli_stmt_bind_param($stmt, "i", $booking_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $booking = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);

        if (!$booking) {
            throw new Exception("Only pending bookings can be cancelled.");
        }

        $room_number = $booking['room_number'];

        // Delete booking
        $stmt = mysqli_prepare($conn, "DELETE FROM tbl_room_booking WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $booking_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // Free room
        if (!empty($room_number)) {
            $stmt = mysqli_prepare($conn, "UPDATE rooms SET status = 'available' WHERE room_number = ?");
            mysqli_stmt_bind_param($stmt, "s", $room_number);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }

        mysqli_commit($conn);
        echo json_encode(['status' => 'success', 'message' => 'Booking cancelled & room freed successfully.']);
    } catch (Exception $e) {
        mysqli_rollback($conn);
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($pageTitle) ?></title>

<?php include 'include/header-file.php'; ?>
<link rel="stylesheet" href="vendor/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
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

    <!-- ✅ Show SweetAlert Messages -->
    <?php if (isset($_SESSION['success_msg'])): ?>
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        Swal.fire('Success', '<?= addslashes($_SESSION['success_msg']) ?>', 'success');
    });
    </script>
    <?php unset($_SESSION['success_msg']); endif; ?>

    <?php if (isset($_SESSION['error_msg'])): ?>
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        Swal.fire('Error', '<?= addslashes($_SESSION['error_msg']) ?>', 'error');
    });
    </script>
    <?php unset($_SESSION['error_msg']); endif; ?>

    <!-- ✅ Search Form -->
    <form method="GET" class="search-form" style="margin:15px 0; display:flex; gap:10px; flex-wrap:wrap;">
        <select name="search_room" class="form-select form-select-sm">
            <option value="">-- Check Room --</option>
            <?php
            $rooms = mysqli_query($conn, "SELECT room_number FROM rooms ORDER BY room_number ASC");
            while ($r = mysqli_fetch_assoc($rooms)) {
                $sel = (isset($_GET['search_room']) && $_GET['search_room'] == $r['room_number']) ? 'selected' : '';
                echo "<option value='{$r['room_number']}' $sel>Room {$r['room_number']}</option>";
            }
            ?>
        </select>

        <select name="search_status" class="form-select form-select-sm">
            <option value="">-- All Status --</option>
            <option value="pending" <?= (($_GET['search_status'] ?? '') == 'pending') ? 'selected' : '' ?>>Pending</option>
            <option value="confirmed" <?= (($_GET['search_status'] ?? '') == 'confirmed') ? 'selected' : '' ?>>Confirmed</option>
            <option value="checkedout" <?= (($_GET['search_status'] ?? '') == 'checkedout') ? 'selected' : '' ?>>Checked Out</option>
        </select>

        <button type="submit" class="btn btn-primary btn-sm">Search</button>
        <a href="booking-list.php" class="btn btn-secondary btn-sm">Reset</a>
    </form>

    <!-- ✅ Booking Table -->
    <div class="table-responsive">
        <table id="bookingTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>Guests</th>
                    <th>Check-in</th>
                    <th>Check-out</th>
                    <th>Room</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
            // ✅ Dynamic Filters
            $where = [];
            if (!empty($_GET['search_room'])) {
                $room = mysqli_real_escape_string($conn, $_GET['search_room']);
                $where[] = "room_number = '$room'";
            }
            if (!empty($_GET['search_status'])) {
                $status = mysqli_real_escape_string($conn, $_GET['search_status']);
                $where[] = "status = '$status'";
            }
            $filter = count($where) ? "WHERE " . implode(" AND ", $where) : "";

            $result = mysqli_query($conn, "SELECT * FROM tbl_room_booking $filter ORDER BY id DESC");
            while ($row = mysqli_fetch_assoc($result)):
            ?>
                <tr id="row-<?= $row['id'] ?>">
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['phone']) ?></td>
                    <td><?= htmlspecialchars($row['guests']) ?></td>
                    <td><?= htmlspecialchars($row['checkin']) ?></td>
                    <td><?= htmlspecialchars($row['checkout']) ?></td>
                    <td><?= htmlspecialchars($row['room_number']) ?></td>
                    <td>
                        <?php if ($row['status'] === 'pending'): ?>
                            <span class="badge bg-warning text-dark">Pending</span>
                        <?php elseif ($row['status'] === 'confirmed'): ?>
                            <span class="badge bg-success">Confirmed</span>
                        <?php elseif ($row['status'] === 'checkedout'): ?>
                            <span class="badge bg-secondary">Checked Out</span>
                        <?php else: ?>
                            <span class="badge bg-light text-dark">N/A</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($row['status'] === 'pending'): ?>
                            <form method="POST" action="confirm_room.php" class="d-inline">
                                <input type="hidden" name="booking_id" value="<?= $row['id'] ?>">
                                <select name="room_no" class="form-select form-select-sm" required>
                                    <option value="">Select Room</option>
                                    <?php
                                    // ✅ Show only available rooms (since checkout sets room to available)
                                    $avail = mysqli_query($conn, "SELECT room_number FROM rooms WHERE status='available' ORDER BY room_number ASC");
                                    while ($r = mysqli_fetch_assoc($avail)):
                                    ?>
                                        <option value="<?= $r['room_number'] ?>"><?= $r['room_number'] ?></option>
                                    <?php endwhile; ?>
                                </select>
                                <button type="submit" class="btn btn-success btn-sm mt-1">Confirm</button>
                            </form>
                            <button type="button" class="btn btn-danger btn-sm mt-1 delete-btn" data-id="<?= $row['id'] ?>">Cancel</button>

                        <?php elseif ($row['status'] === 'confirmed'): ?>
                            <form method="POST" action="checkout_room.php" class="d-inline">
                                <input type="hidden" name="booking_id" value="<?= $row['id'] ?>">
                                <input type="hidden" name="room_no" value="<?= $row['room_number'] ?>">
                                <button type="submit" class="btn btn-warning btn-sm">Checkout</button>
                            </form>

                        <?php elseif ($row['status'] === 'checkedout'): ?>
                            <span class="text-secondary">Completed ✅</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'include/footer-file.php'; ?>

<!-- ✅ JS -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/datatables/media/js/jquery.dataTables.min.js"></script>
<script src="vendor/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(function() {
    var table = $('#bookingTable').DataTable({
        pageLength: 10,
        order: [[4, 'desc']],
        columnDefs: [{ orderable: false, targets: [8] }]
    });

    // ✅ Cancel Booking with SweetAlert + AJAX
    $(document).on('click', '.delete-btn', function() {
        const id = $(this).data('id');
        const row = $('#row-' + id);

        Swal.fire({
            title: 'Cancel this booking?',
            text: "This will remove the booking and free the room.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Cancel',
            cancelButtonText: 'No, Keep it',
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6'
        }).then(result => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    data: { action: 'delete_booking', id: id },
                    dataType: 'json',
                    success: function(res) {
                        if (res.status === 'success') {
                            row.fadeOut(400, () => {
                                table.row(row).remove().draw(false);
                            });
                            Swal.fire('Cancelled!', res.message, 'success');
                        } else {
                            Swal.fire('Error', res.message, 'error');
                        }
                    },
                    error: () => Swal.fire('Error', 'Server error occurred!', 'error')
                });
            }
        });
    });
});
</script>

</body>
</html>
