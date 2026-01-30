<?php
include 'dbc.php';
$booking_id = $_GET['id']; // booking ID from URL

$query = "SELECT * FROM tbl_booking WHERE id = $booking_id";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
?>

<h3>Hello <?= htmlspecialchars($row['customer_name']) ?>,</h3>
<p>Your booking for table <?= htmlspecialchars($row['table_number']) ?> is pending confirmation.</p>

<?php if ($row['status'] != 'confirmed'): ?>
    <button id="confirmBooking" class="btn btn-success">Confirm My Booking</button>
<?php else: ?>
    <p class="text-success">✅ You have already confirmed your booking!</p>
<?php endif; ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$('#confirmBooking').click(function() {
    Swal.fire({
        title: 'Are you sure?',
        text: "Confirm your table booking?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, confirm it!',
    }).then((result) => {
        if (result.isConfirmed) {
            $.post('customer-confirm.php', { id: <?= $booking_id ?> }, function(res) {
                if (res.trim() === 'success') {
                    Swal.fire('Thank you!', 'Your booking has been confirmed.', 'success').then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Error!', 'Something went wrong.', 'error');
                }
            });
        }
    });
});
</script>
