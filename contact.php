<?php 
include 'config.php';

// Agar aapko site info (phone, email, address, map URL) chahiye toh wahan se fetch kar lijiye, warna dummy data daal sakte hain:
$row = [
    'phone1' => '1234567890',
    'address' => '123, Some Street, City',
    'email' => 'info@example.com',
    'url' => 'https://maps.google.com/?q=28.6139,77.2090&output=embed'
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'include/head.php'; ?>
</head>
<body>

    <!-- <?php include 'include/preloader.php'; ?> -->

    <?php include 'include/header.php'; ?>

    <!-- Breadcrumb -->
    <div class="breadcrumb-area bg-cover shadow dark text-center text-light" style="background-image: url(assets/img/shape/5.jpg);">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h1>Contact Us</h1>
                    <ul class="breadcrumb">
                        <li><a href="#"><i class="fas fa-home"></i> Home</a></li>
                        <li>Contact</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Info -->
    <div class="contact-style-one-area default-padding overflow-hidden">
        <div class="container">
            <div class="row justify-content-center">

                <div class="col-lg-10">
                    <div class="contact-style-one-info mb-5">
                        <ul>
                            <li>
                                <div class="icon">
                                    <img src="assets/img/icon/phone.png" alt="Phone Icon">
                                </div>
                                <div class="content">
                                    <h5 class="title">Hotline</h5>
                                    <a href="tel:<?= htmlspecialchars($row['phone1']) ?>"><?= htmlspecialchars($row['phone1']) ?></a>
                                </div>
                            </li>
                            <li>
                                <div class="icon">
                                    <img src="assets/img/icon/placeholder.png" alt="Location Icon">
                                </div>
                                <div class="info">
                                    <h5 class="title">Our Location</h5>
                                    <p><?= htmlspecialchars($row['address']) ?></p>
                                </div>
                            </li>
                            <li>
                                <div class="icon">
                                    <img src="assets/img/icon/email.png" alt="Email Icon">
                                </div>
                                <div class="info">
                                    <h5 class="title">Official Email</h5>
                                    <a href="mailto:<?= htmlspecialchars($row['email']) ?>"><?= htmlspecialchars($row['email']) ?></a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Contact Form -->
<div class="contact-section">
    <h5>KEEP IN TOUCH</h5>
    <h2>Send us a Message</h2>
    
    <form action="submit_contact.php" method="POST">
        <input name="name" type="text" placeholder="Name" required>
        
        <div style="display: flex; gap: 10px;">
            <input name="email" type="email" placeholder="Email*" required style="flex: 1;">
            <input name="phone" type="text" placeholder="Phone" required style="flex: 1;">
        </div>

        <input type="date" name="date" required>

        <select name="table_number" required>
            <option value="">Select Table Number</option>
            <?php for ($i = 1; $i <= 50; $i++): ?>
                <option value="<?= $i ?>">Table <?= $i ?></option>
            <?php endfor; ?>
        </select>

        <textarea name="message" placeholder="Your Message *" rows="4" required></textarea>

        <button type="submit" name="submit">
            <i class="fa fa-paper-plane"></i> Get In Touch
        </button>
    </form>
</div>
</div>
            </div>
        </div>
    </div>
    <!-- Contact Form End -->

    <!-- Google Map -->
    <div class="maps-area overflow-hidden">
        <div class="google-maps">
            <iframe src="<?= htmlspecialchars($row['url']) ?>" style="border:0; width:100%; height:400px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>

    <!-- <?php include 'include/time.php'; ?> -->
    <?php include 'include/footer.php'; ?>
    <?php include 'include/js.php'; ?>

</body>
</html>
    <style>
        .contact-section {
    background: #fff;
    max-width: 900px;
    margin: 50px auto;
    padding: 40px;
    border-radius: 16px;
    box-shadow: 0 0 30px rgba(0, 0, 0, 0.05);
}

/* Headings */
.contact-section h2 {
    font-size: 36px;
    font-weight: bold;
    text-align: center;
    margin-bottom: 10px;
}

.contact-section h5 {
    text-align: center;
    color: #a48c60;
    font-weight: 600;
    font-size: 16px;
    letter-spacing: 1px;
    text-transform: uppercase;
    margin-bottom: 20px;
}

/* Form Fields */
.contact-section input,
.contact-section textarea,
.contact-section select {
    width: 100%;
    padding: 14px 18px;
    border: none;
    border-radius: 10px;
    background: #f1f1f1;
    margin-bottom: 20px;
    font-size: 16px;
    transition: 0.3s;
}

.contact-section input:focus,
.contact-section textarea:focus,
.contact-section select:focus {
    outline: none;
    background: #e7e7e7;
}

/* Submit Button */
.contact-section button[type="submit"] {
    background-color: #7c6240;
    color: white;
    padding: 12px 30px;
    border: none;
    border-radius: 10px;
    font-size: 16px;
    font-weight: 500;
    cursor: pointer;
    transition: 0.3s ease;
}

.contact-section button[type="submit"]:hover {
    background-color: #5e4a2f;
}

        /* body {
            background-color: #f8f9fa;
            padding-top: 50px;
            font-family: 'Segoe UI', sans-serif;
        } */
        .contact-section {
            background: #fff;
            padding: 40px 30px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0,0,0,0.05);
        }
        footer {
            background-color: #343a40;
            color: #ccc;
            text-align: center;
            padding: 20px 0;
            margin-top: 50px;
            width: 100%;
        }
        footer a {
            color: #ffffff;
            text-decoration: underline;
        }
    </style>
