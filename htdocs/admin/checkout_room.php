<?php
include 'dbc.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['booking_id']) && !empty($_POST['room_no'])) {

    $booking_id = intval($_POST['booking_id']);
    $room_no    = intval($_POST['room_no']);

    // 1️⃣ Update booking status to 'vacated'
    $stmt_booking = $conn->prepare("UPDATE tbl_room_booking SET status='vacated' WHERE id=?");
    $stmt_booking->bind_param("i", $booking_id);
    $stmt_booking->execute();
    $stmt_booking->close();

    // 2️⃣ Mark room as available
    $stmt_room = $conn->prepare("UPDATE rooms SET status='available' WHERE room_number=?");
    $stmt_room->bind_param("i", $room_no);
    $stmt_room->execute();
    $stmt_room->close();

    // 3️⃣ Return success JSON
    echo json_encode(['status' => 'success']);
    exit;

} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
    exit;
}
?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('.checkout-btn').click(function() {
        if(!confirm("Are you sure you want to checkout this room?")) return;

        var booking_id = $(this).data('id');
        var room_no    = $(this).data('room');
        var btn        = $(this);

        $.ajax({
            url: 'room_booking-list.php',
            type: 'POST',
            data: { booking_id: booking_id, room_no: room_no },
            dataType: 'json',
            success: function(response) {
                if(response.status == 'success') {
                    // Update row instantly
                    btn.closest('td').html('<span class="text-secondary">'+ room_no +' - Vacated</span>');
                    alert('✅ Room checked out successfully!');
                } else {
                    alert('❌ ' + response.message);
                }
            },
            error: function() {
                alert('❌ Something went wrong!');
            }
        });
    });
});
</script>

