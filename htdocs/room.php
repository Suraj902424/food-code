<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_email = $_SESSION['user_email'];
?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rooms & Suites</title>


<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">

<!-- Custom CSS -->
<link rel="stylesheet" href="assets/css/style.css">

<?php include 'include/head.php'; ?>


</head>
<body>

<?php 
include 'include/preloader.php'; 
include 'include/topbar.php'; 
include 'include/header.php'; 
?>

<main class="container my-5">


<h1 class="text-center mb-4">Rooms & Suites</h1>

<div class="row">
    <?php
    $rooms = [
        ['name' => 'Standard Room', 'image' => 'assets/img/hotel.webp', 'details' => 'Area 136.5 sq ft + All Amenities | Smart TV'],
        ['name' => 'Deluxe Room', 'image' => 'assets/img/hotel1.webp', 'details' => '190 sq ft + All Amenities | Smart TV'],
        ['name' => 'Executive Room', 'image' => 'assets/img/hotel3.webp', 'details' => '203 sq ft + All Amenities | Prem Mandir View']
    ];

    foreach ($rooms as $room):
    ?>
    <div class="col-md-4 mb-4">
        <div class="room-card text-center">
            <img src="<?= htmlspecialchars($room['image']) ?>" alt="<?= htmlspecialchars($room['name']) ?>">
            <h3 class="room-title"><?= htmlspecialchars($room['name']) ?></h3>
            <p class="room-details"><?= htmlspecialchars($room['details']) ?></p>
            <a href="#" class="btn btn-custom" data-bs-toggle="modal" data-bs-target="#bookingModal">Book Now</a>
            <a href="room-image.php" class="btn btn-custom">Room Photo</a>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<!-- User Bookings -->
<h2 class="mt-5">Your Room Bookings</h2>
<?php
$stmt = $conn->prepare("
    SELECT id, name, email, checkin, checkout, rooms, guests, phone, status, room_number
    FROM tbl_room_booking
    WHERE email = ?
    ORDER BY checkin DESC
");
$stmt->bind_param("s", $user_email);
$stmt->execute();
$bookings = $stmt->get_result();
?>

<?php if ($bookings->num_rows > 0): ?>
<div class="table-responsive mt-3">
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Room Number</th>
                <th>Room Type</th>
                <th>Check-in</th>
                <th>Check-out</th>
                <th>Guests</th>
                <th>Phone</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($b = $bookings->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($b['room_number']) ?></td>
                <td><?= htmlspecialchars($b['rooms']) ?></td>
                <td><?= htmlspecialchars($b['checkin']) ?></td>
                <td><?= htmlspecialchars($b['checkout']) ?></td>
                <td><?= htmlspecialchars($b['guests']) ?></td>
                <td><?= htmlspecialchars($b['phone']) ?></td>
                <td><?= htmlspecialchars($b['status']) ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<?php else: ?>
    <div class="alert alert-info mt-3">You have no room bookings yet.</div>
<?php endif; ?>


</main>

<!-- Booking Modal -->

<div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bookingModalLabel">Book Your Stay</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="booking_submit.php" method="post">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="fullName" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="fullName" name="fullName" placeholder="Enter your name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                        </div>
                        <div class="col-md-6">
                            <label for="checkinDate" class="form-label">Check-in Date</label>
                            <input type="date" class="form-control" id="checkinDate" name="checkinDate" required>
                        </div>
                        <div class="col-md-6">
                            <label for="checkoutDate" class="form-label">Check-out Date</label>
                            <input type="date" class="form-control" id="checkoutDate" name="checkoutDate" required>
                        </div>
                        <div class="mb-3">
                            <label for="roomSelect" class="form-label">Select Room(s)</label>
                            <select class="form-select room-select" id="roomSelect" name="rooms[]" multiple="multiple">
                                <option value="Standard Room">Standard Room</option>
                                <option value="Deluxe Room">Deluxe Room</option>
                                <option value="Executive Room">Executive Room</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="guests" class="form-label">Guests</label>
                            <input type="number" class="form-control" id="guests" name="guests" min="1" value="1" required>
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter phone number" required>
                        </div>
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-submit">Confirm Booking</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JS Libraries -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
    $('.room-select').select2({
        placeholder: "Select Room Types",
        allowClear: true,
        width: '100%',
        dropdownParent: $('#bookingModal')
    });
});
</script>

<?php include 'include/footer.php'; ?>

<?php include 'include/js.php'; ?>

</body>
</html>

<style>
.room-card img { width: 100%; height: 250px; object-fit: cover; border-radius: 10px; }
.room-card { background: #fff; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); padding: 15px; transition: 0.3s; }
.room-card:hover { transform: translateY(-5px); box-shadow: 0 6px 15px rgba(0,0,0,0.15); }
.room-title { font-size: 20px; font-weight: bold; margin-top: 15px; color: #333; }
.room-details { margin: 10px 0; color: #666; }
.btn-custom { background: #f4a62a; color: #fff; font-weight: bold; margin: 5px; border-radius: 6px; padding: 8px 15px; border: none; }
.btn-custom:hover { background: #d88f1c; }
.modal-content { border-radius: 12px; box-shadow: 0 5px 20px rgba(0,0,0,0.3); }
.modal-header { background: #f4a62a; color: #fff; border-bottom: none; }
.modal-title { font-weight: bold; }
.btn-close { filter: invert(1); }
.form-control, .form-select { border-radius: 8px; border-color: #ccc; }
.form-label { font-weight: 500; }
.btn-submit { background: #f4a62a; color: #fff; font-weight: bold; border-radius: 8px; padding: 10px; width: 100%; border: none; }
.btn-submit:hover { background: #d88f1c; }
</style>
