<?php
require_once 'config.php';
header('Content-Type: application/json');

$checkin = $_POST['checkin'] ?? '';
$checkout = $_POST['checkout'] ?? '';

if (!$checkin || !$checkout || $checkin >= $checkout) {
    echo json_encode([]);
    exit;
}

$sql = "
    SELECT r.id, r.room_number, COALESCE(r.room_type, 'Standard') as room_type
    FROM rooms r
    WHERE (r.status = 'available' OR r.status IS NULL OR r.status = '')
      AND r.id NOT IN (
          SELECT room_number 
          FROM tbl_room_booking 
          WHERE room_number != 0 
            AND status = 'confirmed'
            AND checkin < ? AND checkout > ?
      )
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $checkout, $checkin);
$stmt->execute();
$result = $stmt->get_result();

$rooms = [];
while ($row = $result->fetch_assoc()) {
    $rooms[] = $row;
}

echo json_encode($rooms);
?>