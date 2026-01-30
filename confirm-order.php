<?php
require 'config.php';

// ✅ UltraMsg WhatsApp API credentials
define('ULTRAMSG_INSTANCE_ID', 'instance148786');
define('ULTRAMSG_TOKEN', 'thgiaa26ngruenx9');

// ✅ WhatsApp send function
function sendWhatsApp($number, $message) {
    $url = "https://api.ultramsg.com/" . ULTRAMSG_INSTANCE_ID . "/messages/chat";
    $data = ['token' => ULTRAMSG_TOKEN, 'to' => $number, 'body' => $message];
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => http_build_query($data),
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => 0,
    ]);
    curl_exec($ch);
    curl_close($ch);
}

// ✅ Validate token
$token = $_GET['token'] ?? '';
if (!$token) {
    die("<h3>❌ Invalid confirmation link.</h3>");
}

// ✅ Fetch all bookings linked to this token
$sql = "SELECT b.*, p.name AS product_name 
        FROM tbl_booking b 
        JOIN tbl_product p ON b.product_id = p.id 
        WHERE b.confirm_token = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("<h3>❌ Invalid or expired link.</h3>");
}

// ✅ Collect data
$bookings = [];
$customer = [];
$total_amount = 0;
while ($row = $result->fetch_assoc()) {
    $bookings[] = $row;
    $customer = [
        'name' => $row['customer_name'],
        'mobile' => $row['mobile'],
        'table_number' => $row['table_number'],
        'email' => $row['email']
    ];
    $total_amount += $row['total_price'];
}

// ✅ Check if already confirmed
$alreadyConfirmed = $bookings[0]['status'] === 'confirmed';

// ✅ Handle AJAX confirmation
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if ($alreadyConfirmed) {
        echo json_encode(['already' => true]);
        exit;
    }

    // Mark all same token orders as confirmed
    $update = $conn->prepare("UPDATE tbl_booking SET status='confirmed', is_confirmed=1 WHERE confirm_token=?");
    $update->bind_param("s", $token);
    $update->execute();

    // ✅ Send WhatsApp to admin
    $msg = "✅ *Customer Order Confirmed!*\n"
         . "-----------------------\n"
         . "👤 *Name:* {$customer['name']}\n"
         . "📞 *Mobile:* {$customer['mobile']}\n"
         . "🪑 *Table:* {$customer['table_number']}\n"
         . "📧 *Email:* {$customer['email']}\n"
         . "-----------------------\n";

    foreach ($bookings as $item) {
        $msg .= "🍲 *{$item['product_name']}* ({$item['size']}) × {$item['quantity']} = ₹" . number_format($item['total_price'], 2) . "\n";
    }

    $msg .= "-----------------------\n💰 *Total:* ₹" . number_format($total_amount, 2) . "\n🕒 Confirmed at: " . date("d M Y, h:i A");

    sendWhatsApp("+918764480642", $msg);

    echo json_encode(['success' => true]);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Confirm Your Order</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
    background: linear-gradient(135deg, #00c9ff, #92fe9d);
    font-family: 'Poppins', sans-serif;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 0;
}
.confirm-card {
    background: rgba(255,255,255,0.15);
    backdrop-filter: blur(15px);
    border-radius: 25px;
    padding: 40px 30px;
    text-align: center;
    width: 90%;
    max-width: 450px;
    color: #fff;
    box-shadow: 0 8px 25px rgba(0,0,0,0.25);
}
h2 {
    font-weight: 700;
    margin-bottom: 10px;
}
p {
    margin: 6px 0;
    font-size: 15px;
}
.btn-confirm {
    background: #fff;
    color: #00c9ff;
    border: none;
    border-radius: 30px;
    padding: 12px 30px;
    font-weight: 600;
    font-size: 16px;
    margin-top: 15px;
    transition: all 0.3s;
}
.btn-confirm:hover {
    background: #00c9ff;
    color: #fff;
}
.success, .already {
    display: none;
    font-size: 17px;
    margin-top: 15px;
}
.item-box {
    background: rgba(255,255,255,0.1);
    border-radius: 10px;
    margin: 10px 0;
    padding: 10px;
    font-size: 14px;
}
</style>
</head>
<body>

<div class="confirm-card">
    <h2>Confirm Your Order</h2>
    <p><strong>👤 <?= htmlspecialchars($customer['name']); ?></strong></p>
    <p>📞 <?= htmlspecialchars($customer['mobile']); ?></p>
    <p>🪑 Table: <?= $customer['table_number']; ?></p>
    <hr>

    <?php foreach ($bookings as $b): ?>
        <div class="item-box">
            🍲 <?= htmlspecialchars($b['product_name']); ?> (<?= htmlspecialchars($b['size']); ?>)<br>
            Qty: <?= $b['quantity']; ?> | ₹<?= number_format($b['total_price'], 2); ?>
        </div>
    <?php endforeach; ?>

    <h5 class="mt-3">💰 Total: ₹<?= number_format($total_amount, 2); ?></h5>

    <?php if ($alreadyConfirmed): ?>
        <div class="already" style="display:block;">✅ Order Already Confirmed</div>
    <?php else: ?>
        <button class="btn-confirm" id="confirmBtn">✅ Confirm Order</button>
        <div class="success" id="successMsg">Order Confirmed! Thank you 🍴</div>
        <div class="already" id="alreadyMsg">✅ Already Confirmed!</div>
    <?php endif; ?>
</div>

<script>
const btn = document.getElementById('confirmBtn');
if(btn){
    btn.addEventListener('click', function(){
        btn.disabled = true;
        btn.innerText = 'Confirming...';
        fetch("", {method: "POST"})
        .then(r => r.json())
        .then(d => {
            if (d.success) {
                btn.style.display = "none";
                document.getElementById('successMsg').style.display = "block";
            } else if (d.already) {
                btn.style.display = "none";
                document.getElementById('alreadyMsg').style.display = "block";
            }
        })
        .catch(() => alert("Error! Try again."));
    });
}
</script>

</body>
</html>
